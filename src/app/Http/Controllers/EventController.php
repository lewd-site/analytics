<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class EventController extends Controller
{
  // Minutes.
  const VISITOR_EXPIRE = 60 * 24 * 365;
  const SESSION_EXPIRE = 30;

  public function collect(Request $request)
  {
    $input = $request->validate([
      'event' => 'required|max:32',
      'data'  => 'nullable|max:2048',
      'host'  => 'required|max:256',
      'path'  => 'required|max:2048',
    ]);

    $visitorId = $request->cookie('vid', Str::random(32));
    $sessionId = $request->cookie('sid', Str::random(32));
    $ip = $request->ip();

    Event::create([
      'event' => $input['event'],
      'data'  => $input['data'] ?? null,

      'visitor_id' => $visitorId,
      'session_id' => $sessionId,
      'ip'         => $ip,

      'host' => $input['host'],
      'path' => $input['path'],
    ]);

    return response('', 204)
      ->cookie('vid', $visitorId, static::VISITOR_EXPIRE, '/')
      ->cookie('sid', $sessionId, static::SESSION_EXPIRE, '/');
  }

  public function pageviews(Request $request)
  {
    $input = $request->validate([
      'before' => 'nullable|integer|min:0',
      'after'  => 'nullable|integer|min:0',
    ]);

    $query = Event::where('event', 'pageview')
      ->select('id', 'created_at', 'ip', 'host', 'path')
      ->take(100);

    if (isset($input['before'])) {
      $events = $query->where('id', '<', $input['before'])
        ->orderBy('id', 'desc')
        ->get()
        ->toArray();
    } elseif (isset($input['after'])) {
      $events = $query->where('id', '>', $input['after'])
        ->orderBy('id', 'asc')
        ->get()
        ->reverse()
        ->toArray();
    } else {
      $events = $query->orderBy('id', 'desc')
        ->get()
        ->toArray();
    }

    $before = null;
    $after = null;

    if (count($events)) {
      $last = Arr::last($events);
      $first = head($events);

      $bounds = Event::selectRaw('MAX(id) as max_id, MIN(id) as min_id')
        ->get('max_id', 'min_id')
        ->first();

      if ($last['id'] > $bounds['min_id']) {
        $before = $last['id'];
      }

      if ($first['id'] < $bounds['max_id']) {
        $after = $first['id'];
      }
    }

    return view('events.pageviews', [
      'events' => $events,
      'before' => $before,
      'after'  => $after,
    ]);
  }
}

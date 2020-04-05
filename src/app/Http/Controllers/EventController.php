<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
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
}

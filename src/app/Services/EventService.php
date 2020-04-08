<?php

namespace App\Services;

use App\Helpers\UrlHelper;
use App\Models\Event;
use App\Models\Referrer;
use App\Models\UserAgent;
use Exception;

class EventService
{
  protected UrlHelper $url;

  public function __construct(UrlHelper $url)
  {
    $this->url = $url;
  }

  public function create(
    string $event,
    ?string $data,
    string $visitorId,
    string $sessionId,
    string $ip,
    string $host,
    string $path,
    ?string $referrer,
    ?string $userAgent
  ): Event {
    $referrerId = null;
    if (!empty($referrer)) {
      try {
        $referrerHost = $this->url->getHost($referrer);
        $referrerPath = $this->url->getPath($referrer);
      } catch (Exception $e) {
        // If referrer is not valid, just skip it.
      }

      if (!empty($referrerHost)) {
        $referrerId = Referrer::firstOrCreate([
          'host' => $referrerHost,
          'path' => $referrerPath,
        ])->id;
      }
    }

    $userAgentId = null;
    if (!empty($userAgent)) {
      $userAgentId = UserAgent::firstOrCreate([
        'user_agent' => $userAgent,
      ])->id;
    }

    return Event::create([
      'event' => $event,
      'data'  => $data ?? null,

      'visitor_id' => $visitorId,
      'session_id' => $sessionId,

      'ip' => $ip,

      'host' => $host,
      'path' => $path,

      'referrer_id'   => $referrerId,
      'user_agent_id' => $userAgentId,
    ]);
  }
}

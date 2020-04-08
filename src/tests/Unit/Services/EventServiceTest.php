<?php

namespace Tests\Unit\Services;

use App\Services\EventService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Tests\TestCase;

class EventServiceTest extends TestCase
{
  use RefreshDatabase;

  public function test_create(): void
  {
    /** @var EventService */
    $service = app()->make(EventService::class);
    $service->create(
      'pageview',
      null,
      Str::random(32),
      Str::random(32),
      '127.0.0.1',
      'http://localhost',
      '/',
      null,
      null
    );

    $this->assertDatabaseHas('events', [
      'event' => 'pageview',
      'ip'    => '127.0.0.1',
      'host'  => 'http://localhost',
      'path'  => '/',
    ]);
  }

  public function test_create_withReferrer(): void
  {
    /** @var EventService */
    $service = app()->make(EventService::class);
    $service->create(
      'pageview',
      null,
      Str::random(32),
      Str::random(32),
      '127.0.0.1',
      'http://localhost',
      '/',
      'https://something.com/test.html',
      null
    );

    $this->assertDatabaseHas('events', [
      'event' => 'pageview',
      'ip'    => '127.0.0.1',
      'host'  => 'http://localhost',
      'path'  => '/',
    ]);

    $this->assertDatabaseHas('referrers', [
      'host'  => 'https://something.com',
      'path'  => '/test.html',
    ]);
  }

  public function test_create_withUserAgent(): void
  {
    /** @var EventService */
    $service = app()->make(EventService::class);
    $service->create(
      'pageview',
      null,
      Str::random(32),
      Str::random(32),
      '127.0.0.1',
      'http://localhost',
      '/',
      null,
      'Mozilla/5.0 (X11; Linux x86_64; rv:68.0) Gecko/20100101 Firefox/68.0'
    );

    $this->assertDatabaseHas('events', [
      'event' => 'pageview',
      'ip'    => '127.0.0.1',
      'host'  => 'http://localhost',
      'path'  => '/',
    ]);

    $this->assertDatabaseHas('user_agents', [
      'user_agent'  => 'Mozilla/5.0 (X11; Linux x86_64; rv:68.0) Gecko/20100101 Firefox/68.0',
    ]);
  }
}

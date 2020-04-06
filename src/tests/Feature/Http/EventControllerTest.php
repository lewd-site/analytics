<?php

namespace Tests\Feature\Http;

use App\Models\Event;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EventControllerTest extends TestCase
{
  use RefreshDatabase;

  public function test_collect(): void
  {
    $response = $this->post('/api/collect', [
      'event' => 'pageview',
      'host'  => 'http://localhost',
      'path'  => '/',
    ]);

    $response->assertSuccessful();
    $this->assertDatabaseHas('events', [
      'event' => 'pageview',
      'host'  => 'http://localhost',
      'path'  => '/',
    ]);
  }

  public function test_pageviews(): void
  {
    $user = factory(User::class)->create();
    factory(Event::class, 200)->create();

    $response = $this->actingAs($user)->get('/pageviews');

    $response->assertSuccessful();
    $response->assertViewIs('events.pageviews');
  }

  public function test_pageviews_empty(): void
  {
    $user = factory(User::class)->create();

    $response = $this->actingAs($user)->get('/pageviews');

    $response->assertSuccessful();
    $response->assertViewIs('events.pageviews');
  }
}

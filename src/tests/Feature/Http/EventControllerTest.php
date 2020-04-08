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
    $response = $this->postJson('/api/collect', [
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

  public function test_collect_withReferrer(): void
  {
    $response = $this->postJson('/api/collect', [
      'event'    => 'pageview',
      'host'     => 'http://localhost',
      'path'     => '/',
      'referrer' => 'http://localhost/test/12345?foo=1',
    ]);

    $response->assertSuccessful();
    $this->assertDatabaseHas('events', [
      'event' => 'pageview',
      'host'  => 'http://localhost',
      'path'  => '/',
    ]);

    $this->assertDatabaseHas('referrers', [
      'host' => 'http://localhost',
      'path' => '/test/12345?foo=1',
    ]);
  }

  public function test_collect_withUserAgent(): void
  {
    $response = $this->postJson('/api/collect', [
      'event' => 'pageview',
      'host'  => 'http://localhost',
      'path'  => '/',
    ], [
      'User-Agent' => 'Mozilla/5.0 (X11; Linux x86_64; rv:68.0) Gecko/20100101 Firefox/68.0',
    ]);

    $response->assertSuccessful();
    $this->assertDatabaseHas('events', [
      'event' => 'pageview',
      'host'  => 'http://localhost',
      'path'  => '/',
    ]);

    $this->assertDatabaseHas('user_agents', [
      'user_agent' => 'Mozilla/5.0 (X11; Linux x86_64; rv:68.0) Gecko/20100101 Firefox/68.0',
    ]);
  }

  public function test_pageviews(): void
  {
    $user = factory(User::class)->create(['is_active' => true]);
    factory(Event::class, 10)->create();

    $response = $this->actingAs($user)->get('/pageviews');

    $response->assertSuccessful();
    $response->assertViewIs('events.pageviews');
  }

  public function test_pageviews_withPagination(): void
  {
    $user = factory(User::class)->create(['is_active' => true]);
    factory(Event::class, 150)->create();

    $response = $this->actingAs($user)->get('/pageviews');

    $response->assertSuccessful();
    $response->assertViewIs('events.pageviews');
  }

  public function test_pageviews_empty(): void
  {
    $user = factory(User::class)->create(['is_active' => true]);

    $response = $this->actingAs($user)->get('/pageviews');

    $response->assertSuccessful();
    $response->assertViewIs('events.pageviews');
  }

  public function test_pageviews_guest(): void
  {
    $response = $this->get('/pageviews');

    $response->assertRedirect(route('auth.login'));
  }
}

<?php

namespace Tests\Feature\Http;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EventControllerTest extends TestCase
{
  use RefreshDatabase;

  public function test_index(): void
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
}

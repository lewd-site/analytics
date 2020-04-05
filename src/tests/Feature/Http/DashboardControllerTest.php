<?php

namespace Tests\Feature\Http;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DashboardControllerTest extends TestCase
{
  use RefreshDatabase;

  public function test_index(): void
  {
    $user = factory(User::class)->create();

    $response = $this->actingAs($user)->get('/');

    $response->assertSuccessful();
    $response->assertViewIs('dashboard.index');
  }

  public function test_index_guest(): void
  {
    $response = $this->get('/');

    $response->assertRedirect(route('auth.login'));
  }
}

<?php

namespace Tests\Feature\Console;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase
{
  use RefreshDatabase;

  public function test_activateUser(): void
  {
    factory(User::class)->create([
      'email'     => 'user@example.com',
      'is_active' => false,
    ]);

    $this->artisan('user:activate')
      ->expectsQuestion('E-Mail', 'user@example.com')
      ->assertExitCode(0);

    $this->assertDatabaseHas('users', [
      'email'     => 'user@example.com',
      'is_active' => true,
    ]);
  }

  public function test_activateUser_notFound(): void
  {
    $this->artisan('user:activate')
      ->expectsQuestion('E-Mail', 'user@example.com')
      ->expectsOutput('User user@example.com not found')
      ->assertExitCode(1);
  }

  public function test_createUser(): void
  {
    $this->artisan('user:create')
      ->expectsQuestion('Name', 'User')
      ->expectsQuestion('E-Mail', 'user@example.com')
      ->expectsQuestion('Password', 'password')
      ->assertExitCode(0);

    $this->assertDatabaseHas('users', [
      'name'      => 'User',
      'email'     => 'user@example.com',
      'is_active' => true,
    ]);
  }

  public function test_createUser_conflict(): void
  {
    factory(User::class)->create(['email' => 'user@example.com']);

    $this->artisan('user:create')
      ->expectsQuestion('Name', 'User')
      ->expectsQuestion('E-Mail', 'user@example.com')
      ->expectsQuestion('Password', 'password')
      ->expectsOutput('User user@example.com already exists')
      ->assertExitCode(1);
  }

  public function test_deactivateUser(): void
  {
    factory(User::class)->create([
      'email'     => 'user@example.com',
      'is_active' => true,
    ]);

    $this->artisan('user:deactivate')
      ->expectsQuestion('E-Mail', 'user@example.com')
      ->assertExitCode(0);

    $this->assertDatabaseHas('users', [
      'email'     => 'user@example.com',
      'is_active' => false,
    ]);
  }

  public function test_deactivateUser_notFound(): void
  {
    $this->artisan('user:deactivate')
      ->expectsQuestion('E-Mail', 'user@example.com')
      ->expectsOutput('User user@example.com not found')
      ->assertExitCode(1);
  }

  public function test_deleteUser(): void
  {
    $user = factory(User::class)->create(['email' => 'user@example.com']);

    $this->artisan('user:delete')
      ->expectsQuestion('E-Mail', 'user@example.com')
      ->assertExitCode(0);

    $this->assertDeleted($user);
  }

  public function test_deleteUser_notFound(): void
  {
    $this->artisan('user:delete')
      ->expectsQuestion('E-Mail', 'user@example.com')
      ->expectsOutput('User user@example.com not found')
      ->assertExitCode(1);
  }

  public function test_listUsers(): void
  {
    $this->artisan('user:list')
      ->assertExitCode(0);
  }
}

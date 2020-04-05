<?php

namespace Tests\Feature\Http;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthControllerTest extends TestCase
{
  use RefreshDatabase;

  public function test_login(): void
  {
    $response = $this->get('/login');

    $response->assertSuccessful();
    $response->assertViewIs('auth.login');
  }

  public function test_loginSubmit(): void
  {
    $user = factory(User::class)->create([
      'password'  => Hash::make('password'),
      'is_active' => true,
    ]);

    $response = $this->post('/login', [
      'email'    => $user->email,
      'password' => 'password',
    ]);

    $response->assertRedirect(route('dashboard.index'));
    $this->assertAuthenticatedAs($user);
  }

  public function test_loginSubmit_invalidEmail(): void
  {
    $response = $this->post('/login', [
      'email'    => 'user',
      'password' => 'password',
    ]);

    $response->assertRedirect();
    $response->assertSessionHasErrors(['email']);
    $this->assertGuest();
  }

  public function test_loginSubmit_invalidPassword(): void
  {
    $response = $this->post('/login', [
      'email'    => 'user@example.com',
      'password' => 'pwd',
    ]);

    $response->assertRedirect();
    $response->assertSessionHasErrors(['password']);
    $this->assertGuest();
  }

  public function test_loginSubmit_notFound(): void
  {
    $response = $this->post('/login', [
      'email'    => 'user@example.com',
      'password' => 'password',
    ]);

    $response->assertRedirect();
    $response->assertSessionHasErrors(['user']);
    $this->assertGuest();
  }

  public function test_loginSubmit_incorrectPassword(): void
  {
    $user = factory(User::class)->create([
      'password'  => Hash::make('password'),
      'is_active' => true,
    ]);

    $response = $this->post('/login', [
      'email'    => $user->email,
      'password' => 'incorrect',
    ]);

    $response->assertRedirect();
    $response->assertSessionHasErrors(['user']);
    $this->assertGuest();
  }

  public function test_loginSubmit_inactive(): void
  {
    $user = factory(User::class)->create([
      'password'  => Hash::make('password'),
      'is_active' => false,
    ]);

    $response = $this->post('/login', [
      'email'    => $user->email,
      'password' => 'password',
    ]);

    $response->assertRedirect();
    $response->assertSessionHasErrors(['user']);
    $this->assertGuest();
  }

  public function test_register(): void
  {
    $response = $this->get('/register');

    $response->assertSuccessful();
    $response->assertViewIs('auth.register');
  }

  public function test_registerSubmit(): void
  {
    $response = $this->post('/register', [
      'name'     => 'User',
      'email'    => 'user@example.com',
      'password' => 'password',
    ]);

    $response->assertRedirect(route('auth.login'));
    $this->assertGuest();
  }

  public function test_registerSubmit_invalidName(): void
  {
    $response = $this->post('/register', [
      'name'     => '',
      'email'    => 'user@example.com',
      'password' => 'password',
    ]);

    $response->assertRedirect();
    $response->assertSessionHasErrors(['name']);
    $this->assertGuest();
  }

  public function test_registerSubmit_invalidEmail(): void
  {
    $response = $this->post('/register', [
      'name'     => 'User',
      'email'    => 'user',
      'password' => 'password',
    ]);

    $response->assertRedirect();
    $response->assertSessionHasErrors(['email']);
    $this->assertGuest();
  }

  public function test_registerSubmit_invalidPassword(): void
  {
    $response = $this->post('/register', [
      'name'     => 'User',
      'email'    => 'user@example.com',
      'password' => 'pwd',
    ]);

    $response->assertRedirect();
    $response->assertSessionHasErrors(['password']);
    $this->assertGuest();
  }

  public function test_registerSubmit_conflict(): void
  {
    $user = factory(User::class)->create();

    $response = $this->post('/register', [
      'name'     => 'User',
      'email'    => $user->email,
      'password' => 'password',
    ]);

    $response->assertRedirect();
    $response->assertSessionHasErrors(['user']);
    $this->assertGuest();
  }

  public function test_logout(): void
  {
    $user = factory(User::class)->create();

    $response = $this->actingAs($user)->post('/logout');

    $response->assertRedirect(route('auth.login'));
    $this->assertGuest();
  }

  public function test_logout_guest(): void
  {
    $response = $this->post('/logout');

    $response->assertRedirect(route('auth.login'));
  }
}

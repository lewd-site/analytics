<?php

namespace Tests\Unit;

use App\Models\User;
use App\Services\UserService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Symfony\Component\HttpKernel\Exception\ConflictHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Tests\TestCase;

class UserServiceTest extends TestCase
{
  use RefreshDatabase;

  public function test_create(): void
  {
    /** @var UserService */
    $service = app()->make(UserService::class);
    $service->create('User', 'user@example.com', 'password', true);

    $this->assertDatabaseHas('users', [
      'name'      => 'User',
      'email'     => 'user@example.com',
      'is_active' => true,
    ]);
  }

  public function test_create_conflict(): void
  {
    factory(User::class)->create(['email' => 'user@example.com']);

    $this->expectException(ConflictHttpException::class);

    /** @var UserService */
    $service = app()->make(UserService::class);
    $service->create('User', 'user@example.com', 'password', true);
  }

  public function test_delete(): void
  {
    factory(User::class)->create(['email' => 'user@example.com']);

    /** @var UserService */
    $service = app()->make(UserService::class);
    $service->delete('user@example.com');

    $this->assertDatabaseMissing('users', ['email' => 'user@example.com']);
  }

  public function test_delete_notFound(): void
  {
    $this->expectException(NotFoundHttpException::class);

    /** @var UserService */
    $service = app()->make(UserService::class);
    $service->delete('user@example.com');
  }

  public function test_activate(): void
  {
    $user = factory(User::class)->create([
      'email'     => 'user@example.com',
      'is_active' => false,
    ]);

    /** @var UserService */
    $service = app()->make(UserService::class);
    $service->activate('user@example.com');

    $this->assertDatabaseHas('users', [
      'name'      => $user->name,
      'email'     => 'user@example.com',
      'is_active' => true,
    ]);
  }

  public function test_activate_notFound(): void
  {
    $this->expectException(NotFoundHttpException::class);

    /** @var UserService */
    $service = app()->make(UserService::class);
    $service->activate('user@example.com');
  }

  public function test_deactivate(): void
  {
    $user = factory(User::class)->create([
      'email'     => 'user@example.com',
      'is_active' => true,
    ]);

    /** @var UserService */
    $service = app()->make(UserService::class);
    $service->deactivate('user@example.com');

    $this->assertDatabaseHas('users', [
      'name'      => $user->name,
      'email'     => 'user@example.com',
      'is_active' => false,
    ]);
  }

  public function test_deactivate_notFound(): void
  {
    $this->expectException(NotFoundHttpException::class);

    /** @var UserService */
    $service = app()->make(UserService::class);
    $service->deactivate('user@example.com');
  }
}

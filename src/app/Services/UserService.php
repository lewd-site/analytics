<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpKernel\Exception\ConflictHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class UserService
{
  /**
   * @throws ConflictHttpException
   */
  public function create(
    string $name,
    string $email,
    string $password,
    bool $is_active
  ): User {
    /** @var ?User */
    $user = User::where('email', $email)->first();
    if (isset($user)) {
      throw new ConflictHttpException("User $email already exists");
    }

    return User::create([
      'email'     => $email,
      'name'      => $name,
      'password'  => Hash::make($password),
      'is_active' => $is_active,
    ]);
  }

  /**
   * @throws NotFoundHttpException
   */
  public function delete(string $email): void
  {
    /** @var ?User */
    $user = User::where('email', $email)->first();
    if (!isset($user)) {
      throw new NotFoundHttpException("User $email not found");
    }

    $user->delete();
  }

  /**
   * @throws NotFoundHttpException
   */
  public function activate(string $email): void
  {
    /** @var ?User */
    $user = User::where('email', $email)->first();
    if (!isset($user)) {
      throw new NotFoundHttpException("User $email not found");
    }

    $user->is_active = true;
    $user->save();
  }

  /**
   * @throws NotFoundHttpException
   */
  public function deactivate(string $email): void
  {
    /** @var ?User */
    $user = User::where('email', $email)->first();
    if (!isset($user)) {
      throw new NotFoundHttpException("User $email not found");
    }

    $user->is_active = false;
    $user->save();
  }
}

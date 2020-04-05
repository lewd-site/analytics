<?php

namespace App\Http\Controllers;

use App\Services\UserService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\ConflictHttpException;

class AuthController extends Controller
{
  protected UserService $userService;

  public function __construct(UserService $userService)
  {
    $this->userService = $userService;
  }

  /**
   * Returns login form.
   */
  public function login()
  {
    return view('auth.login');
  }

  /**
   * Handles login form submit.
   */
  public function loginSubmit(Request $request)
  {
    $credentials = $request->validate([
      'email'    => 'required|email',
      'password' => 'required|min:8',
    ]);

    $credentials['is_active'] = true;

    if (!Auth::attempt($credentials)) {
      return redirect()->back()->withErrors([
        'user' => 'User not found or password is incorrect',
      ]);
    }

    return redirect()->intended(route('dashboard.index'));
  }

  /**
   * Returns register form.
   */
  public function register()
  {
    return view('auth.register');
  }

  /**
   * Handles register form submit.
   */
  public function registerSubmit(Request $request)
  {
    $credentials = $request->validate([
      'name'     => 'required',
      'email'    => 'required|email',
      'password' => 'required|min:8',
    ]);

    try {
      $this->userService->create(
        $credentials['name'],
        $credentials['email'],
        $credentials['password'],
        false
      );
    } catch (ConflictHttpException $e) {
      return redirect()->back()->withErrors([
        'user' => $e->getMessage(),
      ]);
    }

    return redirect()->route('auth.login');
  }

  public function logout()
  {
    Auth::logout();

    return redirect()->route('auth.login');
  }
}

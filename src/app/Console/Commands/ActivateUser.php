<?php

namespace App\Console\Commands;

use App\Services\UserService;
use Illuminate\Console\Command;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ActivateUser extends Command
{
  /**
   * The name and signature of the console command.
   *
   * @var string
   */
  protected $signature = 'user:activate';

  /**
   * The console command description.
   *
   * @var string
   */
  protected $description = 'Activate user account';

  protected UserService $userService;

  /**
   * Create a new command instance.
   *
   * @return void
   */
  public function __construct(UserService $userService)
  {
    parent::__construct();

    $this->userService = $userService;
  }

  /**
   * Execute the console command.
   *
   * @return mixed
   */
  public function handle()
  {
    $email = $this->ask('E-Mail');

    try {
      $this->userService->activate($email);
    } catch (NotFoundHttpException $e) {
      $this->error($e->getMessage());

      return 1;
    }
  }
}

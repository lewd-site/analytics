<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
  /**
   * Register the commands for the application.
   *
   * @return void
   */
  protected function commands()
  {
    $this->load(__DIR__ . '/Commands');

    require base_path('routes/console.php');
  }

  protected function schedule(Schedule $schedule)
  {
    $schedule->command('queue:work --stop-when-empty')->cron('* * * * *')->withoutOverlapping();
  }
}

<?php

use App\Models\Event;
use Illuminate\Database\Seeder;

class EventSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    factory(Event::class, 200)->create();
  }
}

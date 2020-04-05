<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('events', function (Blueprint $table) {
      $table->bigIncrements('id');

      $table->string('event', 32);
      $table->string('data', 2048)->nullable();

      $table->string('visitor_id', 32);
      $table->string('session_id', 32);
      $table->string('ip', 64);

      $table->string('host', 256);
      $table->string('path', 2048);

      $table->timestamp('created_at')->nullable();
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('events');
  }
}

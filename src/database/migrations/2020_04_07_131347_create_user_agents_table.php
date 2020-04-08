<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserAgentsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('user_agents', function (Blueprint $table) {
      $table->increments('id');
      $table->string('user_agent', 256)->unique();
    });

    Schema::table('events', function (Blueprint $table) {
      $table->integer('user_agent_id')->nullable();
      $table->foreign('user_agent_id')->references('id')->on('user_agents');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::table('events', function (Blueprint $table) {
      $table->dropForeign('events_user_agent_id_foreign');
      $table->dropColumn('user_agent_id');
    });

    Schema::dropIfExists('user_agents');
  }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReferrersTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('referrers', function (Blueprint $table) {
      $table->increments('id');
      $table->string('host', 256);
      $table->string('path', 2048);
      $table->unique(['host', 'path']);
    });

    Schema::table('events', function (Blueprint $table) {
      $table->integer('referrer_id')->nullable();
      $table->foreign('referrer_id')->references('id')->on('referrers');
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
      $table->dropForeign('events_referrer_id_foreign');
      $table->dropColumn('referrer_id');
    });

    Schema::dropIfExists('referrers');
  }
}

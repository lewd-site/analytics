<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGeoipsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('geoips', function (Blueprint $table) {
      $table->string('ip', 64)->primary();
      $table->string('type', 16)->nullable();
      $table->string('hostname', 256)->nullable();
      $table->string('continent', 256)->nullable();
      $table->string('country', 256)->nullable();
      $table->string('region', 256)->nullable();
      $table->string('city', 256)->nullable();
      $table->string('zip', 16)->nullable();
      $table->decimal('latitude', 9, 6)->nullable();
      $table->decimal('longitude', 9, 6)->nullable();
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('geoips');
  }
}

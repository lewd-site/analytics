<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\UserAgent;
use Faker\Generator as Faker;

$factory->define(UserAgent::class, function (Faker $faker) {
  return ['user_agent' => $faker->userAgent];
});

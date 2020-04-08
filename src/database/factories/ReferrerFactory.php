<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Referrer;
use Faker\Generator as Faker;

$factory->define(Referrer::class, function (Faker $faker) {
  return [
    'host' => 'https://' . $faker->domainName,
    'path' => '/' . $faker->slug,
  ];
});

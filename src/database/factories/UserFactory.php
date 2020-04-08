<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\User;
use Faker\Generator as Faker;
use Illuminate\Support\Facades\Hash;

$factory->define(User::class, function (Faker $faker) {
  return [
    'name'      => $faker->name,
    'email'     => $faker->unique()->safeEmail,
    'password'  => Hash::make('password'),
    'is_active' => $faker->boolean,
  ];
});

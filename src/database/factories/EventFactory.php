<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Event;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(Event::class, function (Faker $faker) {
  static $visitor_ids = [];
  if (empty($visitor_ids)) {
    for ($i = 0; $i < 10; ++$i) {
      $visitor_ids[] = Str::random(32);
    }
  }

  static $session_ids = [];
  if (empty($session_ids)) {
    for ($i = 0; $i < 10; ++$i) {
      $session_ids[] = Str::random(32);
    }
  }

  return [
    'event' => 'pageview',
    'data'  => null,

    'visitor_id' => $visitor_ids[mt_rand(0, count($visitor_ids) - 1)],
    'session_id' => $session_ids[mt_rand(0, count($visitor_ids) - 1)],
    'ip'         => $faker->ipv4,

    'host' => 'https://' . $faker->domainName,
    'path' => '/' . $faker->slug,

    'referrer_id'   => null,
    'user_agent_id' => null,

    'created_at' => $faker->dateTimeThisYear,
  ];
});

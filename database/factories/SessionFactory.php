<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Treiner\Session;
use Faker\Generator as Faker;

$factory->define(Session::class, function (Faker $faker) {
    return [
        'coach_id' => Arr::random(DB::table('coaches')->pluck('id')->toArray()),
        'location_id' => Arr::random(DB::table('locations')->pluck('id')->toArray()),
        'starts' => $faker->dateTimeBetween('-1 year', '+3 months'),
        'length' => Arr::random([30, 60, 90, 120, 150, 180]),
        'fee' => random_int(50, 10000),
        'group_min' => random_int(0, 5),
        'group_max' => random_int(5, 10),
        'type' => 'VirtualTraining',
        'status' => Arr::random(['scheduled', 'completed']),
        'created_at' => $faker->dateTimeBetween('-1 year', 'now'),
        'updated_at' => $faker->dateTimeThisYear(),
    ];
});


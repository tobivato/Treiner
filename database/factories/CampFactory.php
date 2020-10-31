<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Arr;
use Faker\Generator as Faker;
use Treiner\Camp;

$factory->define(Camp::class, function (Faker $faker) {
    return [
        'session_id' => Arr::random(DB::table('sessions')->pluck('id')->toArray()),
        'image_id' => 'profile-none',
        'title' => $faker->sentence(),
        'description' => $faker->sentences(5, true),
        'tos' => $faker->sentences(10, true),
        'ages' => (Arr::random(config('treiner.ages'), random_int(1, 3))),
        'start_time' => $faker->time(),
        'end_time' => $faker->time(),
        'days' => $faker->numberBetween(1, 30),
    ];
});
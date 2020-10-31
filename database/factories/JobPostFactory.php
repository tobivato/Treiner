<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Treiner\JobPost;
use Faker\Generator as Faker;

$factory->define(JobPost::class, function (Faker $faker) {
    return [
        'title' => $faker->sentence(),
        'player_id' => Arr::random(DB::table('players')->pluck('id')->toArray()),
        'location_id' => Arr::random(DB::table('locations')->pluck('id')->toArray()),
        'starts' => $faker->dateTimeBetween('-1 year', '+3 months'),
        'details' => $faker->text(4000),
        'fee' => random_int(50, 10000),
        'length' => random_int(30, 300),
        'type' => Arr::random(config('treiner.sessions')),
    ];
});

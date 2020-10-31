<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Treiner\Review;
use Faker\Generator as Faker;

$factory->define(Review::class, function (Faker $faker) {
    return [
        'session_player_id' => Arr::random(DB::table('session_players')->pluck('id')->toArray()),
        'rating' => $faker->numberBetween($min = 1, $max = 100),
        'content' => $faker->text($maxNbChars = 100),
        'created_at' => $faker->dateTimeBetween('-2 years', 'now'),
    ];
});

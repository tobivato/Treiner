<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Treiner\CoachCamp;
use Faker\Generator as Faker;

$factory->define(CoachCamp::class, function (Faker $faker) {
    return [
        'coach_id' => Arr::random(DB::table('coaches')->pluck('id')->toArray()),
        'camp_id' => Arr::random(DB::table('camps')->pluck('id')->toArray()),
        'accepted_at' => $faker->dateTimeThisYear,
    ];
});

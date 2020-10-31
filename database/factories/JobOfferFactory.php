<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;
use Treiner\JobOffer;

$factory->define(JobOffer::class, function (Faker $faker) {
    return [
        'coach_id' => Arr::random(DB::table('coaches')->pluck('id')->toArray()),
        'job_post_id' => Arr::random(DB::table('job_posts')->pluck('id')->toArray()),
        'location_id' => Arr::random(DB::table('locations')->pluck('id')->toArray()),
        'content' => $faker->text(500),
        'fee' => random_int(50, 10000),
    ];
});

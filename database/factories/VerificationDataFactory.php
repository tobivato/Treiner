<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;
use Treiner\VerificationData;

$factory->define(VerificationData::class, function (Faker $faker) {
    return [
        'coach_id' => Arr::random(DB::table('coaches')->pluck('id')->toArray()),
        'verification_type' => Arr::random(['working_with_children_au', 'working_with_children_ms', 'fifa']),
        'verification_number' => Str::random(16),
    ];
});
<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Treiner\Report;
use Faker\Generator as Faker;

$factory->define(Report::class, function (Faker $faker) {
    return [
        'content' => $faker->sentence(10, true),
        'complainant_type' => 'Treiner\Player',
        'defendant_type' => 'Treiner\Coach',
        'complainant_id' => array_rand(DB::table('players')->pluck('id')->toArray()),
        'defendant_id' => array_rand(DB::table('coaches')->pluck('id')->toArray()),
        'session_id' => array_rand(DB::table('sessions')->pluck('id')->toArray()),
    ];
});

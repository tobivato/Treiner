<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Treiner\Conversation;
use Faker\Generator as Faker;

$factory->define(Conversation::class, function (Faker $faker) {
    return [
        'from_id' => Arr::random(DB::table('users')->pluck('id')->toArray()),
        'to_id' => Arr::random(DB::table('users')->pluck('id')->toArray()),
        'subject' => $faker->text(255),
    ];
});

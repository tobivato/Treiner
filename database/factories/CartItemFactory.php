<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Treiner\CartItem;
use Faker\Generator as Faker;

$factory->define(CartItem::class, function (Faker $faker) {
    return [
        'session_id' => Arr::random(DB::table('sessions')->pluck('id')->toArray()),
        'player_id' => Arr::random(DB::table('players')->pluck('id')->toArray()),
        'players' => $faker->numberBetween(1, 20),
        'created_at' => $faker->dateTimeThisYear(),
        'updated_at' => $faker->dateTimeThisYear(),
    ];
});

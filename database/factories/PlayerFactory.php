<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Treiner\Player;
use Faker\Generator as Faker;

$factory->define(Player::class, function (Faker $faker) {
    return [
        'created_at' => $faker->dateTimeBetween('-1 year', 'now'),
        'updated_at' => $faker->dateTimeThisYear(),
    ];
});

<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;
use Treiner\Message;

$factory->define(Message::class, function (Faker $faker) {
    return [
        'seen' => $faker->boolean(50),
        'content' => $faker->text(75),
    ];
});

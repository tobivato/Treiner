<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Treiner\BillingAddress;
use Faker\Generator as Faker;

$factory->define(BillingAddress::class, function (Faker $faker) {
    return [
        'street_address' => $faker->streetAddress(),
        'locality' => $faker->city(),
        'first_name' => $faker->firstName(),
        'last_name' => $faker->lastName(),
        'country' => $faker->country(),
        'state' => $faker->city(),
        'postcode' => $faker->postcode(),
    ];
});

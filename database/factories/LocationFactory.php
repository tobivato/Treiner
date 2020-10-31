<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Treiner\Location;
use Faker\Generator as Faker;

$factory->define(Location::class, function (Faker $faker) {
    $city = Arr::random(config('treiner.cities'));
    return [
        'latitude' =>  $city['latitude'] + (random_int(-100, 100) / 10000), //moves locations to random real ones
        'longitude' => $city['longitude'] + (random_int(-100, 100) / 10000),
        'street_address' => $faker->streetAddress(),
        'locality' => $city['name'],
        'country' => $faker->country(),
        'timezone' => $faker->timezone(),
    ];
});
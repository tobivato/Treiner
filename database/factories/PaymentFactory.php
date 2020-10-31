<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Treiner\Payment;
use Faker\Generator as Faker;

$factory->define(Payment::class, function (Faker $faker) {
    return [
        'amount' => $faker->numberBetween(10, 200),
        'charge_id' => 'ch_' . Str::random(20),
        'billing_address_id' => Arr::random(DB::table('billing_addresses')->pluck('id')->toArray()),
        'currency' => Arr::random([
            'AUD', 'MYR', 'NZD', 'USD', 'CAD']),
        'coach_id' => Arr::random(DB::table('coaches')->pluck('id')->toArray()),
        'player_id' => Arr::random(DB::table('players')->pluck('id')->toArray()),
    ];
});

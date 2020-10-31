<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Treiner\Coach;
use Illuminate\Support\Str;
use Faker\Generator as Faker;

$factory->define(Coach::class, function (Faker $faker) {
    return [
        'club' => $faker->firstName,
        'is_company' => (bool) random_int(0, 1),
        'location_id' => Arr::random(DB::table('locations')->pluck('id')->toArray()),
        'business_registration_number' => $faker->randomNumber() . $faker->randomNumber(),
        'qualification' => Arr::random(config('treiner.qualifications')),
        'years_coaching' => random_int(0, 20),
        'age_groups_coached' => (Arr::random(config('treiner.ages'), random_int(1, 3))),
        'session_types' => (Arr::random(config('treiner.sessions'), random_int(1, 4))),
        'treiner_fee' => random_int(10, 30),
        'fee'=>random_int(10,200),
        'profile_session' => $faker->text(500),
        'profile_summary' => $faker->text(500),
        'profile_philosophy' => $faker->text(500),
        'profile_playing' => $faker->text(500),
        'verification_status' => 'verified',
        'stripe_token' => 'acct_1GKHhAJE5SA8JtFW',
        'created_at' => $faker->dateTimeBetween('-1 year', 'now'),
        'updated_at' => $faker->dateTimeBetween('-1 year', 'now'),
    ];
});

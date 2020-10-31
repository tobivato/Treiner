<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Treiner\User;
use Illuminate\Support\Str;
use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(User::class, function (Faker $faker) {
    $role = null;
    $roles = [
        Treiner\Player::class,
        Treiner\Coach::class,
    ];
    $roleType = $roles[array_rand($roles)];

    //Can't send off coaches when they don't have users
    Treiner\Coach::withoutSyncingToSearch(function () use ($roleType, &$role) {
        $role = factory($roleType)->create();
    });
        
    return [
        'role_type' => $roleType,
        'role_id' => $role->id,
        'first_name' => $faker->firstName,
        'last_name' => $faker->lastName,
        'currency' => Arr::random([
            'AUD', 'MYR', 'NZD', 'USD', 'CAD'
        ]),
        'email' => $faker->unique()->safeEmail,
        'phone' => Arr::random(config('treiner.countries'))['phone_code'] . $faker->numberBetween(000000000, 999999999),
        'dob' => $faker->dateTimeThisCentury('now', null),
        'gender' => Arr::random(['Male', 'Female']),
        'password' => Hash::make('123'),
        'image_id' => 'profile-none',
        'remember_token' => Str::random(10),
        'email_verified_at' => $faker->dateTimeThisYear('now'),
        'phone_verified_at' => $faker->dateTimeThisYear('now'),
    ];
});

<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Treiner\NewsletterSubscription;
use Faker\Generator as Faker;
use Illuminate\Support\Facades\Hash;

$factory->define(NewsletterSubscription::class, function (Faker $faker) {
    $email = $faker->unique()->safeEmail;
    return [
        'email' => $email,
        'unsub_token' => md5($email),
    ];
});

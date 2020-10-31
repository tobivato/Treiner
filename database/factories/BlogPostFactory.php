<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Treiner\BlogPost;
use Faker\Generator as Faker;

$factory->define(BlogPost::class, function (Faker $faker) {
    $faker->addProvider(new \DavidBadura\FakerMarkdownGenerator\FakerProvider($faker));
    return [
        'image_id' => 'profile-none',
        'coach_id' => Arr::random(DB::table('coaches')->pluck('id')->toArray()),
        'title' => $faker->sentence(),
        'excerpt' => $faker->sentence(),
        'content' => $faker->markdown(),
    ];
});

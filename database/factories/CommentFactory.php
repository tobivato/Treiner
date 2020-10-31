<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Treiner\Comment;
use Faker\Generator as Faker;
use Illuminate\Support\Arr;

$factory->define(Comment::class, function (Faker $faker) {

    if (random_int(0, 100) > 50) {
        $commentableType = Treiner\Coach::class;
        $commentableId = Arr::random(DB::table('coaches')->pluck('id')->toArray());
    }
    else {
        $commentableType = Treiner\JobPost::class;
        $commentableId = Arr::random(DB::table('job_posts')->pluck('id')->toArray());
    }

    return [
        'commentable_type' => $commentableType,
        'commentable_id' => $commentableId,
        'user_id' => Arr::random(DB::table('users')->pluck('id')->toArray()),
        'content' => $faker->text(500),
    ];
});

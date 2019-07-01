<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Models\MentorDiary;
use Faker\Generator as Faker;

// php artisan make:factory MentorDiaryFactory --model=Models/MentorDiary

$factory->define(MentorDiary::class, function (Faker $faker) {

    $mentors = rand(475, 446);
    return [
        'mentor_srl' => $mentors,
        'title' => 'test1',
        'image' => '',
        'contents' => 'test1',
        'view_count' => rand(20,100),
        'like_count' => 0,
        'regdate' => date("Y-m-d H:i:s"),
    ];
});

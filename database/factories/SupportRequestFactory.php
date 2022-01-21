<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\SupportRequest;
use Faker\Generator as Faker;

$factory->define(SupportRequest::class, function (Faker $faker) {
    return [
        "title" => $faker->sentence,
        "type" => "feature",
        "description" => $faker->sentences(3, true)
    ];
});

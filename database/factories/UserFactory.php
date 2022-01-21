<?php

use Illuminate\Support\Str;
use Faker\Generator as Faker;
use Spatie\Permission\Models\Role;

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

$factory->define(App\User::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', // secret
        'remember_token' => Str::random(10),
        'is_super_admin' => false,
    ];
});


$factory->state(App\User::class, 'admin', function ($faker) {
    return [
        'is_super_admin' => true
    ];
});

$factory->state(App\User::class, 'withRole', function ($faker) {
    return [];
});


$factory->afterCreatingState(App\User::class, 'withRole', function ($user, $faker) {
    $user->assignRole(Role::create(['name' => $faker->word]));
});

<?php

use Carbon\Carbon;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\Concert::class, function(Faker\Generator $faker) {
    return [
        'title' => 'Example Band',
        'subtitle' => 'with Fake Openers',
        'date' => Carbon::parse('+2 Weeks'),
        'price' => 2000,
        'venue' => 'The Example Theatre',
        'address' => '123 Example Lane',
        'city' => 'Fakeville',
        'state' => 'ON',
        'zip' => '10001',
        'additional_information' => 'Some sample additional information',
    ];
});

$factory->state(App\Concert::class, 'published', function ($faker) {
    return [
        'published_at' => Carbon::parse('-1 Week'),
    ];
});

$factory->state(App\Concert::class, 'unpublished', function ($faker) {
    return [
        'published_at' => null,
    ];
});
<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Transaction;
use App\User;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

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
        'email_verified_at' => now(),
        'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        'remember_token' => Str::random(10),
    ];
});

$factory->define(App\Transaction::class, function (Faker $faker) {
    return [
        'user_id' => 1,
        'label' => $faker->words(rand(1, 2), true),
        'amount' => $faker->randomFloat(2, -500, 500),
        'date' => $faker->dateTimeBetween('-30 days', 'now', 'UTC'),
    ];
});

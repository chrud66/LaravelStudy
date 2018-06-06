<?php

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

$factory->define(App\User::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', // secret
        'remember_token' => str_random(10),
        'account' => '1234567890',
    ];
});

$factory->define(App\Project::class, function(Faker $faker) {
    $min = App\User::min('id');
    $max = App\User::max('id');

    return[
        'user_id' => $faker->numberBetween($min, $max),
        'name' => $faker->word,
        'created_at' => $faker->dateTimeBetween($startDate = '-2 years', $endDate = '-1 years'),
        'updated_at' => $faker->dateTimeBetween($startDate = '-1 years', $endDate = 'now'),
    ];
});

$factory->define(App\Task::class, function (Faker $faker) {
    $min = App\Project::min('id');
    $max = App\Project::max('id');

    return[
        'project_id' => $faker->numberBetween($min, $max),
        'name' => substr($faker->sentence, 0, 49),
        'description' => $faker->text,
        'created_at' =>  $faker->dateTimeBetween($startDate = '-2 years', $endDate = '-1 years'),
        'updated_at' => $faker->dateTimeBetween($startDate = '-1 years', $endDate = 'now'),
        'due_date' => $faker->dateTimeBetween($startDate = '-2 weeks', $endDate = '+1 months'),
    ];
});

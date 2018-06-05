<?php

use Faker\Generator as Faker;

$factory->define(App\Role::class, function (Faker $faker) {
    $role = ['guest', 'reporter', 'developer', 'owner', 'master'];
    $num = $faker->numberBetween(0, 4);
    $roleNum = $role[$num] . $num;
    return [
        'name' => $roleNum,
        'created_at' => $faker->dateTimeBetween($startDate = '-2 years', $endDate = '-1 years'),
        'updated_at' => $faker->dateTimeBetween($startDate = '-1 years', $endDate = 'now'),
    ];
});

$factory->define(App\RoleUser::class, function (Faker $faker) {

    $user_id_min = App\User::min('id');
    $user_id_max = App\User::max('id');
    $role_id_min = App\Role::min('id');
    $role_id_max = App\Role::max('id');

    return [
        'user_id' => $faker->numberBetween($user_id_min, $user_id_max),
        'role_id' => $faker->numberBetween($role_id_min, $role_id_max),
        'created_at' => $faker->dateTimeBetween($startDate = '-2 years', $endDate = '-1 years'),
        'updated_at' => $faker->dateTimeBetween($startDate = '-1 years', $endDate = 'now'),
    ];
});

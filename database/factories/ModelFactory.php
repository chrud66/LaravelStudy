<?php

use Faker\Generator as Faker;

$factory->define(App\User::class, function (Faker $faker) {
    return [
        'name'  => $faker->name,
        'email' => $faker->email,
        'password' => bcrypt(str_random(10)),
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\Article::class, function (Faker $faker) {
    return [
        'title' => substr($faker->sentence, 0, 150),
        'content' => $faker->paragraph,
    ];
});

$factory->define(App\Comment::class, function (Faker $faker) {
    return [
        'title' => substr($faker->sentence, 0, 150),
        'content' => $faker->paragraph,
    ];
});

$factory->define(App\Tag::class, function (Faker $faker) {
    $name = ucfirst($faker->optional(0.9, 'Laravel')->word);

    return [
        'name' => $name,
        'slug' => str_slug($name),
    ];
});

$factory->define(App\Attachment::class, function (Faker $faker) {

    return [
        'name' => sprintf("%s.%s", str_random(), $faker->randomElement(['png', 'jpg'])),
    ];
});

/*
use App\Product;
use App\Picture;

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


$factory->define(App\Product::class, function ($faker) {
    return [
        'name' => $faker->sentence,
        'price' => $faker->randomNumber(5),
        'created_at' => $faker->dateTimeBetween($startDate = '-2 years', $endDate = '-1 years'),
        'updated_at' => $faker->dateTimeBetween($startDate = '-1 years', $endDate = 'now'),
    ];
});

$factory->define(App\Picture::class, function ($faker) {
    if (rand(0, 1) == 0) :
        $type = 'App\User';
        $min = App\User::min('id');
        $max = App\User::max('id');
    else :
        $type = 'App\Product';
        $min = App\Product::min('id');
        $max = App\Product::max('id');
    endif;
    return [
        'title' => substr($faker->text, 0, 99),
        'path' => $faker->image($dir = 'storage', $width = 640, $height = 480),
        'imageable_id' => $faker->numberBetween($min, $max),
        'imageable_type'  => $type,
        'created_at' => $faker->dateTimeBetween($startDate = '-2 years', $endDate = '-1 years'),
        'updated_at' => $faker->dateTimeBetween($startDate = '-1 years', $endDate = 'now'),
    ];
});
*/

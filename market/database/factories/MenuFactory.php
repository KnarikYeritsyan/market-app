<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

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

$factory->define(App\MenuItem::class, function (Faker $faker) {
    $categories = App\MenuItem::all()->pluck('id');
    if (count($categories) <= 4) {
        $categories = [null];
    } else {
        $categories = $categories->toArray();
    }
    return [
        'menu_id' => 1,
        'title' => [
        "en"=>$faker->name,
        "ru"=>$faker->name,
        "am"=>$faker->name
    ],
        'parent_id' => $faker->randomElement($categories),
        'sort_order' => $faker->numberBetween(1,5)
    ];
});

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

$factory->define(App\Product::class, function (Faker $faker) {
    return [
        'name' => $faker->word,
        'description' => $faker->paragraph(1),
        'quantity'    => $faker->numberBetween(1,10),
        'status'      => $faker->randomElement([App\Product::AVAILABLE_PRODUCT,App\Product::UNAVAILABLE_PRODUCT]), 
        'image'       => $faker->randomElement(['1.png','2.png','3.png']),
        'seller_id'   => App\User::all()->random()->id,
    ];
}); 

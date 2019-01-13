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

$factory->define(App\Transaction::class, function (Faker $faker) {
   $seller = App\Seller::has('products')->get()->random(); 
   $buyer  = App\User::all()->except($seller->id)->random();
    return [
        'quantity'    => $faker->numberBetween(1,3),
        'buyer_id'      => $buyer->id,
        'product_id'       => $seller->products->random()->id,
    ];
}); 

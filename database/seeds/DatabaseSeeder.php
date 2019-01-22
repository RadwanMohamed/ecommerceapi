<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        /**
         * truncates tables before seeding
         */
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        App\User::truncate();
        App\Product::truncate();
        App\Transaction::truncate();
        App\Category::truncate();
        DB::table('category_product')->truncate();



        /**
         * prevent Events 
         */
        User::flushEventListeners();
        Product::flushEventListeners();
        Transaction::flushEventListeners();
        Category::flushEventListeners();

        /**
         * seeding table users
         */
        factory(App\User::class,1000)->create();
        /**
         * seeding table categories
         */
        factory(App\Category::class,30)->create();
         /**
         * seeding table products and the pivot table
         */
        factory(App\Product::class,1000)->create()->each(
            function($product){
                $categories = App\Category::all()->random(mt_rand(1,5))->pluck('id');
                $product->categories()->attach($categories);
            });
             /**
         * seeding table transactions
         */
        factory(App\Transaction::class,1000)->create();

    }
}

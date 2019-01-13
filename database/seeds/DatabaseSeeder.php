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
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        App\User::truncate();
        App\Product::truncate();
        App\Transaction::truncate();
        App\Category::truncate();
        DB::table('category_product')->truncate();

        factory(App\User::class,200)->create();
        factory(App\Category::class,30)->create();

        factory(App\Product::class,1000)->create()->each(
            function($product){
                $categories = App\Category::all()->random(mt_rand(1,5))->pluck('id');
                $product->categories()->attach($categories);
            });
        factory(App\Transaction::class,1000)->create();

    }
}

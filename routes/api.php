<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/**
 * Buyers
 */
Route::resource('buyers','Buyer\BuyerController')->only(['index','show']);
Route::resource('buyers.transactions','Buyer\BuyerTransactionController')->only(['index']);
Route::resource('buyers.products','Buyer\BuyerProductController')->only(['index']);
Route::resource('buyers.seller','Buyer\BuyerSellerController')->only(['index']);
Route::resource('buyers.categories','Buyer\BuyerCategoryController')->only(['index']);

/**
 * Catrgories
 */
Route::resource('categories','Category\CategoryController')->except(['create','edit']);
Route::resource('categories.products','Category\CategoryProductController')->only(['index']);
Route::resource('categories.seller','Category\CategorySellerController')->only(['index']);
Route::resource('categories.transactions','Category\CategoryTransactionController')->only(['index']);
Route::resource('categories.buyer','Category\CategoryBuyerController')->only(['index']);

/**
 * Products
 */
Route::resource('products','Product\ProductController')->only(['index','show']);
Route::resource('products.transactions','Product\ProductTransactionController')->only(['index','show']);
Route::resource('products.buyer','Product\ProductBuyerController')->only(['index','show']);
Route::resource('products.buyers.transactions','Product\ProductBuyerTransactionController')->only(['store']);
Route::resource('products.category','Product\ProductCategoryController')->except(['create','edit']);

/**
 * Sellers
 */
Route::resource('sellers','Seller\SellerController')->only(['index','show']);
Route::resource('sellers.transactions','Seller\SellerTransactionController')->only(['index']);
Route::resource('sellers.categories','Seller\SellerCategoryController')->only(['index']);
Route::resource('sellers.buyer','Seller\SellerBuyerController')->only(['index']);
Route::resource('sellers.products','Seller\SellerProductController')->except(['create','show']);

/**
 * Transactions
 */
Route::resource('transactions','Transaction\TransactionController')->only(['index','show']);
Route::resource('transactions.categories','Transaction\TransactionCategoryController')->only(['index']);
Route::resource('transactions.seller','Transaction\TransactionSellerController')->only(['index']);

/**
 * Users
 */
Route::get('users/{user}/resend','User\UserController@resend')->name('resend');
Route::get('users/verify/{token}','User\UserController@verify')->name('verify');
Route::resource('users','User\UserController')->except(['create','edit']);
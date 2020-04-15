<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

/*Route::group(['prefix' => 'products', 'middleware' => 'auth'], function() {
    Route::get('/', 'ProductsController@index')->name('products');
});*/

Route::get('products/{product}/add-stock', 'ProductController@addStock')->middleware('auth')->name('products.addStock');
Route::get('products/{product}/remove-stock', 'ProductController@removeStock')->middleware('auth')->name('products.removeStock');
Route::put('products/{product}/update-stock', 'ProductController@updateStock')->middleware('auth')->name('products.updateStock');
Route::any('stocks', 'StockController@index')->middleware('auth')->name('stock.index');
Route::resource('products', 'ProductController')->middleware('auth');
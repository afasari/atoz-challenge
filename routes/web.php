<?php

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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', 'PageController@index')->name('pages.index');
Route::get('prepaid-balance', 'PageController@prepaid')->name('pages.prepaid');
Route::get('product', 'PageController@product')->name('pages.product');

# Users
Route::get('payment', 'UsersController@payment')->name('users.payment');
Route::get('payment/{order_number}', 'UsersController@pay')->name('users.pay');
Route::get('order', 'UsersController@order')->name('users.order');
Route::get('test', 'UsersController@test')->name('users.test');
Route::post('receipt', 'UsersController@receipt')->name('users.receipt');
Route::post('paid', 'UsersController@paid')->name('users.paid');
Route::get('cancel/{order_number}', 'UsersController@cancel')->name('users.cancel');

Auth::routes();
Route::get('home', 'HomeController@index')->name('home');

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

Route::get('/', function () {
    return view('welcome');
});

Route::post ( '/items', 'EmailTepmlateController@storeItem' );
Route::get ( '/spam-items', 'EmailTepmlateController@readSpamItems' );
Route::get ( '/items', 'EmailTepmlateController@readItems' );
Route::post ( '/items/{id}', 'EmailTepmlateController@deleteItem' );
Route::post ( '/edit-items/{id}', 'EmailTepmlateController@editItem' );
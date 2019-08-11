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

Route::get('/', 'HomeController@index');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/active/{id}', 'ActiveController@index');
Route::get('/messages/{id}', 'MessageController@getMessages');
Route::post('/message', 'MessageController@sendMessage');
Route::get('/user/{id}', 'ActiveController@from');
Route::post('/delete/message', 'MessageController@deleteMessage');

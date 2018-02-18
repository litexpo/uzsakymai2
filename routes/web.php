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

// home root
Route::get('/', 'HomeController@index');

// formos išsaugojimo kelias
Route::post('/register', 'HomeController@store');

// visi užsakymai
Route::get('/uzsakymai', 'OrderController@index')->name('uzsakymai.index');

// duomenų paieška
Route::get('/uzsakymai/search', 'OrderController@search');
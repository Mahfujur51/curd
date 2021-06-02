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

Route::get('/','CustomerController@index')->name('index');
Route::get('/delete/{id}','CustomerController@delete')->name('delete');
Route::get('/edit','CustomerController@edit')->name('edit');
Route::post('/store','CustomerController@store')->name('store');
Route::post('/update/{id}','CustomerController@update')->name('update');
Route::get('/inactive/{id}','CustomerController@inactive')->name('inactive');
Route::get('/active/{id}','CustomerController@active')->name('active');

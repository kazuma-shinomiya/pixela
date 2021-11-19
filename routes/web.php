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

Route::get('/', 'TaskController@index')->name('tasks.index')->middleware('auth');
Route::post('/amount/{task}', 'TaskController@addAmount')->name('amount.add');
Route::resource('tasks', 'TaskController')->except(['index'])->middleware('auth');
Auth::routes();

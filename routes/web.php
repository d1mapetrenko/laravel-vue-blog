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

Route::get('/dashboard', 'Admin\DashboardController@index')->name('dashboard_index')->middleware('auth');
Route::get('/dashboard/posts', 'Admin\PostController@index')->name('dashboard_posts')->middleware('auth');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

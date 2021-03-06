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

Route::name('auth.')->group(function () {
  Route::get('/login', 'AuthController@login')->name('login');
  Route::post('/login', 'AuthController@loginSubmit')->name('loginSubmit');
  Route::get('/register', 'AuthController@register')->name('register');
  Route::post('/register', 'AuthController@registerSubmit')->name('registerSubmit');
  Route::post('/logout', 'AuthController@logout')->name('logout')->middleware('auth');
});

Route::name('dashboard.')->middleware('auth')->group(function () {
  Route::get('/', 'DashboardController@index')->name('index');
});

Route::name('events.')->middleware('auth')->group(function () {
  Route::get('/pageviews', 'EventController@pageviews')->name('pageviews');
});

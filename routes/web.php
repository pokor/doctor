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

//登录注册
Auth::routes();


Route::get('/home', 'HomeController@index')->name('home');
Route::get('picture','Media\PictureController@index');
Route::any('upload','Media\PictureController@uploadImg')->name('picture');
Route::get('video','Media\VideoController@index');
Route::any('videos','Media\VideoController@uploadVideo')->name('videos');
Route::get('reset','Api\Auth\ResetController@index');
Route::post('resets','Api\Auth\ResetController@reset')->name('reset');
Route::post('demo','Auth\ResetController@reset');


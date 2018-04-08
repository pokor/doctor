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
Route::get('/',function (){
    return view('welcome');
});

Route::get('/home', 'HomeController@index')->name('home');
Route::get('picture','Media\PictureController@index');
Route::any('upload','Media\PictureController@uploadImg')->name('picture');//
Route::get('video','Media\VideoController@index');
Route::any('video','Media\VideoController@uploadVideo')->name('videos');//
Route::any('video_list','Media\VideoController@videoList')->name('videos');//
Route::any('video_delete','Media\VideoController@videoDelete');//
Route::post('get_pic','Media\PictureController@get_Img')->name('get_img');//
Route::post('pic_list','Media\VideoController@pictureList');//
Route::get('pic_delete','Media\VideoController@pictureDelete');
Route::get('reset','Api\Auth\ResetController@index');
Route::post('resets','Api\Auth\ResetController@reset')->name('reset');//
/*Route::post('demo','Auth\ResetController@reset');//*/
Route::post('feed','UserCenter\FeedController@index');//
Route::any('avatar','UserCenter\AvatarController@index');//
Route::post('nickname','UserCenter\NickNameController@index');//
Route::post('gender','UserCenter\GenderController@index');//
Route::post('signe','UserCenter\SigneController@index');//


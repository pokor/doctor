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

Route::get('/home', 'HomeController@index');
Route::any('video','Media\VideoController@uploadVideo');//
Route::any('video_list','Media\VideoController@videoList');//
Route::any('video_delete','Media\VideoController@videoDelete');//
Route::post('picture','Media\PictureController@uploadImg');//
Route::any('picture2','Media\PictureController@base64_decode');//
Route::post('picturelist','Media\PictureController@pictureList');//
Route::post('picture_delete','Media\PictureController@pictureDelete');


Route::group(['middleware' => 'web','prefix' => 'v1'],function (){

        Route::group(['prefix'=>'user'],function (){
            Route::post('resets','Api\Auth\ResetController@reset');//
            Route::post('feed','UserCenter\FeedController@index');//
            Route::any('avatar','UserCenter\AvatarController@index');//
            Route::post('nickname','UserCenter\NickNameController@index');//
            Route::post('gender','UserCenter\GenderController@index');//
            Route::post('signature','UserCenter\SigneController@index');//
        });
        Route::group(['prefix'=>'western'],function (){//
            Route::post('/','Home\HomeWesternController@index');
        });
        Route::group(['prefix'=>'traditional'],function (){//
            Route::post('/','Home\HomeTraditionalController@index');
        });
        Route::group(['prefix'=>'diet'],function (){//
            Route::post('/','Home\HomeDietController@index');
        });
        Route::group(['prefix'=>'beauty'],function (){//
            Route::post('/','Home\HomeBeautyController@index');
        });

});




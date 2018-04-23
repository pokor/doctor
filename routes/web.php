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


Route::group(['middleware' => 'web','prefix' => 'v1'],function (){

        Route::group(['prefix'=>'user'],function (){
            Route::post('reset','Auth\ResetController@reset');//
            Route::post('feed','UserCenter\FeedController@index');//
            Route::any('avatar','UserCenter\AvatarController@index');//
            Route::post('nickname','UserCenter\NickNameController@index');//
            Route::post('gender','UserCenter\GenderController@index');//
            Route::post('signature','UserCenter\SigneController@index');//
        });
        Route::group(['prefix'=>'western'],function (){//
            Route::post('western','Home\HomeWesternController@index');
        });
        Route::group(['prefix'=>'traditional'],function (){//
            Route::get('traditional','Home\HomeTraditionalController@index');
        });
        Route::group(['prefix'=>'diet'],function (){//
            Route::post('meal','Home\HomeDietController@index');
            Route::post('list','Home\HomeDietController@mealImgList');
            Route::post('choice','Home\HomeDietController@choiceList');
            //Route::post('delete','Home\HomeDietController@mealImgDelete');
        });
        Route::group(['prefix'=>'beauty'],function (){//
            Route::post('upload','Home\HomeBeautyController@beautyPicUpload');
        });
        Route::group(['prefix'=>'picture'],function (){//用户上传医疗照片路由
            Route::post('upload','Media\PictureController@uploadImg');
            Route::any('picture2','Media\PictureController@base64_picture');//用于上传base64图片的功能
            Route::post('list','Media\PictureController@pictureList');
            Route::get('delete','Media\PictureController@pictureDelete');
        });
        Route::group(['prefix'=>'video'],function (){//用户上传医疗视频路由
            Route::post('upload','Media\VideoController@uploadVideo');
            Route::any('video2','Media\VideoController@base64_video');//用于上传base64视频的功能
            Route::post('list','Media\VideoController@videoList');
            Route::post('delete','Media\VideoController@videoDelete');
        });

});




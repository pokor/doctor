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

Route::get('msg','Auth\RegisterController@sendMsg');
Route::group(['middleware' => 'web','prefix' => 'v1'],function (){

        Route::group(['prefix'=>'user'],function (){
            Route::post('reset','Auth\ResetController@reset');//重置密码
            Route::post('feed','UserCenter\FeedController@index');//意见反馈
            Route::any('avatar','UserCenter\AvatarController@index');//用户头像
            Route::post('nickname','UserCenter\NickNameController@index');//用户昵称
            Route::post('gender','UserCenter\GenderController@index');//用户性别
            Route::post('signature','UserCenter\SigneController@index');//用户签名
        });
        Route::group(['prefix'=>'hospital'],function (){//用户看病项目的路由
            Route::post('hospital','Home\HomeTraditionalController@index');
        });
        Route::group(['prefix'=>'remind'],function (){
            Route::post('remind','Home\HomeRemindController@index');
            Route::post('list','Home\HomeRemindController@list');
            Route::post('delete','Home\HomeRemindController@delete');
        });
        Route::group(['prefix'=>'diet'],function (){//用户饮食记录
            Route::post('meal','Home\HomeDietController@index');//用户上传饮食记录的图片
            Route::post('list','Home\HomeDietController@mealImgList');//用户上传饮食记录的列表
            Route::post('choice','Home\HomeDietController@choiceList');
            //Route::post('delete','Home\HomeDietController@mealImgDelete');
        });
        Route::group(['prefix'=>'beauty'],function (){//用户美容日记
            Route::post('upload','Home\HomeBeautyController@beautyPicUpload');//上传美容日记的上传
            Route::post('list','Home\HomeBeautyController@beautyImgList');//用户美容日记的记录
        });
        Route::group(['prefix'=>'picture'],function (){//用户上传医疗照片路由
            Route::post('upload','Media\PictureController@uploadImg');//用于文件上传的形式上传
            Route::any('picture2','Media\PictureController@base64_picture');//用于上传base64图片的功能
            Route::post('list','Media\PictureController@pictureList');
            Route::get('delete','Media\PictureController@pictureDelete');
        });
        Route::group(['prefix'=>'video'],function (){//用户上传医疗视频路由
            Route::post('upload','Media\VideoController@uploadVideo');
            Route::any('video2','Media\VideoController@base64_video');//用于上传base64视频的功能
            Route::post('list','Media\VideoController@videoList');//视频列表
            Route::post('delete','Media\VideoController@videoDelete');//图片删除
        });

});




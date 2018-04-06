<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});
$api = app('Dingo\Api\Routing\Router');
$api->version('v1',function ($api){
    //$api->post('demo', 'App\Http\Controllers\Auth\ResetController@reset');
   /* $api->get('picture','App\Http\Controllers\Api\Media\PictureController@index');*/

    ////认证通过
    //$api->group(['middleware'=>'api.auth'],function($api){
    //    $api->get('logout','App\Http\Api\Auth\LoginController@logout');
    //    $api->resource('user','App\Http\Api\UsersController');
    //});
    //$api->get('refresh','App\Http\Api\UsersController@refresh');
});

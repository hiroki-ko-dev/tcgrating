<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

//test

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


// AppleコールバックURL
Route::post('/auth/apple/redirect', 'Auth\AppleController@handleProviderCallback');

Route::get('/user/{user_id}', 'Api\Auth\AuthController@index');
Route::post('/auth/expo/token/update', 'Api\Auth\AuthController@expoTokenUpdate');
Route::get('/auth/logout', 'Api\Auth\AuthController@logout');
Route::post('/auth/discord_name/update', 'Api\Auth\AuthController@discordName');

Route::get('/single/test', 'Api\Event\SingleController@test');

Route::resources(['event/single' => Api\Event\SingleController::class]);
Route::get('/event/badge', 'Api\Event\SingleController@badge');

Route::post('/event/join', 'Api\Event\SingleController@join');

Route::resources(['post' => Api\Post\PostController::class]);
Route::resources(['post/comment' => Api\Post\CommentController::class]);

Route::resources(['rank' => Api\Rank\RankController::class]);
Route::resources(['video' => Api\Video\VideoController::class]);

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// Api

Route::get('/single/test', 'Api\Event\SingleController@test');

Route::resources(['event/single' => Api\Event\SingleController::class]);
Route::post('/event/join', 'Api\Event\SingleController@join');

Route::resources(['post' => Api\Post\PostController::class]);
Route::resources(['post/comment' => Api\Post\CommentController::class]);

Route::resources(['rank' => Api\Rank\RankController::class]);
Route::get('user/{user_id}', 'Api\Auth\AuthController@index');

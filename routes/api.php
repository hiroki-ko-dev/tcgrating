<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Auth;
use App\Http\Controllers\Web\Auth\AppleController;

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

Route::prefix('auth')->group(function () {
    Route::post('/login', [Auth\AuthController::class, 'login']);
    Route::get('/logout', [Auth\AuthController::class, 'logout']);
});

// AppleコールバックURL
Route::post('/auth/apple/redirect', [AppleController::class, 'handleProviderCallback']);
Route::get('/user/{user_id}', 'Api\Auth\AuthController@index');
Route::get('/single/test', 'Api\Event\SingleController@test');
Route::resources(['event/single' => Api\Event\SingleController::class]);
Route::get('/event/badge', 'Api\Event\SingleController@badge');
Route::post('/event/join', 'Api\Event\SingleController@join');
Route::resources(['post' => Api\Post\PostController::class]);
Route::resources(['post_comment' => Api\Post\PostCommentController::class]);
Route::resources(['rank' => Api\Rank\RankController::class]);
Route::resources(['video' => Api\Video\VideoController::class]);

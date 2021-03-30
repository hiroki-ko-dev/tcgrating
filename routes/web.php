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

    //直接TOPページを表示
    Route::get('/', function () {
        return view('site.index');
    });
    //footerの管理者情報を表示
    Route::get('/administrator', 'SiteController@administrator');

    //権限関係
    Auth::routes();

    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    //掲示板スレッド
    Route::resources([
        'post'         => Post\PostController::class,
    //掲示板コメント
        'post/comment' => Post\CommentController::class,
    ]);

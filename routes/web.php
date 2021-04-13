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

    //ページ更新処理
    Route::get('/reload', function () {
        return back();
    });

    //footerの管理者情報を表示
    Route::get('/administrator', 'SiteController@administrator');

    //権限関係
    Auth::routes();

//    Route::get('/user', [App\Http\Controllers\UserController::class, 'index'])->name('user');

    //ユーザー系スレッド
    Route::resources([
        'user' => UserController::class,
    ]);

    //チーム系スレッド
    Route::resources([
        'team'      => Team\TeamController::class,
    //チームユーザー系スレッド
        'team/user' => Team\TeamUserController::class,
    ]);

    //掲示板スレッド
    Route::resources([
        'post'         => Post\PostController::class,
    //掲示板コメント
        'post/comment' => Post\CommentController::class,
    ]);

    //1対1デュエル系スレッド
    Route::resources([
        'event/single' => Event\SingleController::class,
    ]);
    //イベント系スレッド
    Route::resources([
        'event/user' => Event\UserController::class,
    ]);

    //デュエル系スレッド
    Route::resources([
        'duel' => Duel\SingleController::class,
    ]);

    //ランキング系スレッド
    Route::resources([
        'rank' => RankController::class,
    ]);

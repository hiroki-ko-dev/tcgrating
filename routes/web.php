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

    //サイトの情報ページ
    Route::get('/sample', function () {return view('sample');});     //直接TOPページを表示
    Route::get('/', function () {return view('site.index');});     //直接TOPページを表示
    Route::get('/site/administrator', function () {return view('site.administrator');}); //管理人を表示
    Route::get('/site/inquiry', function () {return view('site.inquiry');}); //お問い合わせ用の動画を表示
    Route::get('/site/how_to_use/normal', function () {return view('site.how_to_use.normal');}); //動画ページを表示
    Route::get('/site/how_to_use/instant', function () {return view('site.how_to_use.instant');}); //動画ページを表示
    Route::post('/site/update_selected_game', [App\Http\Controllers\SiteController::class, 'update_selected_game']); //管理人を表示

    //ページ更新処理
    Route::get('/reload', function () {
        return back();
    });

    //権限関係
    Auth::routes();

    // twitterログイン
    Route::prefix('auth')->group(function () {
        // TwitterログインURL
        Route::get('/twitter/login', 'Auth\TwitterController@redirectToProvider');
        // TwitterコールバックURL
        Route::get('/twitter/callback', 'Auth\TwitterController@handleProviderCallback');
        // TwitterログアウトURL
        Route::get('/twitter/logout', 'Auth\TwitterController@logout');
    });

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

    //イベント系スレッド
    Route::resources([
        'event/single'  => Event\SingleController::class,
        'event/instant' => Event\InstantController::class,
        'event/group'   => Event\GroupController::class,
    ]);
    //イベントユーザー系スレッド
    Route::resources([
        'event/user' => Event\UserController::class,
    ]);
    Route::post('/event/instant/user', [App\Http\Controllers\Event\UserController::class,'instant']);

    //デュエル系スレッド
    Route::resources([
        'duel/single' => Duel\SingleController::class,
        'duel/instant' => Duel\InstantController::class,
        'duel/point'  => Duel\PointController::class,
    ]);

    //ランキング系スレッド
    Route::resources([
        'rank' => RankController::class,
    ]);

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
    Route::get('/site/test', [App\Http\Controllers\SiteController::class, 'test']); //管理人を表示

    // ランディングページ系
    Route::get('/site/landing/pokemon_card', function () {return view('site.landing.03_pokemon_card');});

    // プロキシページ系
    Route::get('/proxy', function () {return view('proxy.show');}); //管理人を表示
    Route::post('/proxy/pdf', [App\Http\Controllers\ProxyController::class, 'pdf']); //管理人を表示

    //ページ更新処理
    Route::get('/reload', function () {return back();});

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

    // Api
    Route::prefix('api')->group(function () {

        Route::get('/single/test', 'Api\Event\SingleController@test');
        Route::resources(['post' => Api\Post\PostController::class]);
        Route::resources(['single' => Api\Event\SingleController::class]);
        Route::resources(['rank' => Api\Rank\RankController::class]);
        Route::get('user/{user_id}', 'Api\Auth\AuthController@index');
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

    //記事
    Route::resources([
        'blog'         => Blog\BlogController::class,
        //掲示板コメント
        'blog/comment' => Blog\CommentController::class,
    ]);

    //イベント系スレッド
    Route::resources([
        'event/single'  => Event\SingleController::class,
        'event/instant' => Event\InstantController::class,
        'event/group'   => Event\GroupController::class,
        'event/swiss'   => Event\SwissController::class,
    ]);
    //イベントユーザー系スレッド
    Route::resources([
        'event/user' => Event\UserController::class,
    ]);
    Route::post('/event/instant/user', [App\Http\Controllers\Event\UserController::class,'instant']);
    Route::post('/event/user/join/request', [App\Http\Controllers\Event\UserController::class,'joinRequest']);

    //デュエル系スレッド
    Route::resources([
        'duel/single' => Duel\SingleController::class,
        'duel/instant' => Duel\InstantController::class,
        'duel/point'  => Duel\PointController::class,
        'duel/swiss'   => Duel\SwissController::class,
    ]);

    //ランキング系スレッド
    Route::resources([
        'rank' => RankController::class,
    ]);

    //管理者専用
    Route::resources([
        'admin' => AdminController::class,
    ]);

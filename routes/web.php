<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\Auth\AppleController;
use App\Http\Controllers\Web\ProxyController;
use App\Http\Controllers\Web\SiteController;
use App\Http\Controllers\Web\Image\ImageController;
use App\Http\Controllers\Web\Decks\DecksController;
use App\Http\Controllers\Web\Decks\DeckTagDeckController;

require __DIR__ . '/auth.php';

Route::namespace('Web')->group(function () {

    Route::get('/', function () {
        return view('welcome');
    });

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->middleware(['auth', 'verified'])->name('dashboard');

    Route::middleware('auth')->group(function () {
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    });

    //サイトの情報ページ
    Route::get('/sample', function () {
        return view('sample');
    });
    //直接TOPページを表示
    Route::get('/', function () {
        return view('site.index');
    });     //直接TOPページを表示
    Route::get('/site/administrator', function () {
        return view('site.administrator');
    }); //管理人を表示
    Route::get('/site/inquiry', function () {
        return view('site.inquiry');
    }); //お問い合わせ用の動画を表示
    Route::get('/site/how_to_use/normal', function () {
        return view('site.how_to_use.normal');
    }); //動画ページを表示
    Route::get('/site/how_to_use/instant', function () {
        return view('site.how_to_use.instant');
    }); //動画ページを表示
    Route::post('/site/update_selected_game', [SiteController::class, 'updateSelectedGame']); //管理人を表示
    Route::get('/site/test', [SiteController::class, 'test']); //管理人を表示
    //プライバシーポリシー
    Route::get('/site/privacy', function () {
        return view('site.privacy');
    });

    // ランディングページ系
    Route::get('/site/landing/pokemon_card', function () {
        return view('site.landing.03_pokemon_card');
    });
    Route::get('/site/landing/resume', [SiteController::class, 'resume']);

    // プロキシページ系
    Route::get('/proxy', function () {
        return view('proxy.show');
    }); //管理人を表示
    Route::post('/proxy/pdf', [ProxyController::class, 'pdf']); //管理人を表示

    //ページ更新処理
    Route::get('/reload', function () {
        return back();
    });

    //権限関係
    // Auth::routes();

    // twitterログイン
    Route::prefix('auth')->group(function () {
        Route::prefix('twitter')->group(function () {
            // TwitterログインURL
            Route::get('/login', 'Auth\TwitterController@redirectToProvider');
            // API用TwitterログインURL
            Route::get('/api/login', 'Auth\TwitterController@redirectToProviderForApi');
            // TwitterコールバックURL
            Route::get('/callback', 'Auth\TwitterController@handleProviderCallback');
            // TwitterログアウトURL
            Route::get('/logout', 'Auth\TwitterController@logout');
        });
        Route::prefix('discord')->group(function () {
            // TwitterログインURL
            Route::get('/login', 'Auth\DiscordController@redirectToProvider');
            // API用TwitterログインURL
            Route::get('/api/login', 'Auth\DiscordController@redirectToProviderForApi');
            // TwitterコールバックURL
            Route::get('/callback', 'Auth\DiscordController@handleProviderCallback');
            // TwitterログアウトURL
            Route::get('/logout', 'Auth\DiscordController@logout');
        });
        Route::prefix('apple')->group(function () {
            // TwitterログインURL
            Route::get('/login', [AppleController::class, 'redirectToProvider']);
            // API用TwitterログインURL
            Route::get('/api/login', [AppleController::class, 'redirectToProviderForApi']);
            Route::post('/callback', [AppleController::class, 'handleProviderCallback']);
            // TwitterログアウトURL
            Route::get('/logout', [AppleController::class, 'logout']);
        });
    });


    //    Route::get('/user', [App\Http\Controllers\UserController::class, 'index'])->name('user');

    //ユーザー系スレッド
    Route::resources([
        'user' => UserController::class,
    ]);

    //ユーザー系スレッド
    Route::resources([
        'resume' => Resume\ResumeController::class,
    ]);

    //チーム系スレッド
    Route::resources([
        'team'      => Team\TeamController::class,
    //チームユーザー系スレッド
        'team/user' => Team\TeamUserController::class,
    ]);

    //掲示板スレッド
    Route::resources([
        'posts'         => Post\PostController::class,
    //掲示板コメント
        'posts/comments' => Post\CommentController::class,
    ]);
    Route::get('/post', function () {
        return redirect('/posts');
    });

    // 商品
    Route::post('/item/charge', [App\Http\Controllers\Item\ItemController::class, 'charge']);
    Route::get('/item/transaction/customer', [App\Http\Controllers\Item\TransactionController::class, 'customer']);
    Route::post('/item/transaction/register', [App\Http\Controllers\Item\TransactionController::class, 'register']);
    Route::get('/item/transaction/completion', [App\Http\Controllers\Item\TransactionController::class, 'completion']);
    Route::resources([
        'item/{item_id}/stock' => Item\StockController::class,
        'item/cart'        => Item\CartController::class,
        'item/transaction' => Item\TransactionController::class,
        'item'             => Item\ItemController::class,
    ]);

    //記事
    Route::resources([
        'blogs'         => Blogs\BlogsController::class,
        //掲示板コメント
        'blogs/comments' => Blogs\CommentsController::class,
    ]);

    Route::put('decks/deck-tag-deck/{deckId}/{deckTagId}', [DeckTagDeckController::class, 'update']);
    Route::resources([
        'decks' => DecksController::class,
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
        'duel/swiss'   => Duel\SwissController::class,
    ]);

    //ランキング系スレッド
    Route::resources([
        'rank' => RankController::class,
    ]);

    //ランキング系スレッド
    Route::resources([
        'opinion' => OpinionController::class,
    ]);

    //管理者専用
    Route::resources([
        'admin' => AdminController::class,
    ]);
    Route::get('/admin_post', 'AdminController@postRequest');
    Route::get('/admin/item/transaction', 'AdminController@itemTransaction');

    //アプリヘルプ
    Route::get('/app/help', function () {
        return view('app.help');
    });

    Route::post('/images/upload/ckeditor', [ImageController::class, 'ckeditorUpload'])->name('images.upload.ckeditor');
});

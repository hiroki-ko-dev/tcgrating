<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;

use Auth;
use Hash;
use DB;

use App\Services\UserService;

class TwitterController extends Controller
{

    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    // Twitterログイン
    public function redirectToProvider()
    {
        return Socialite::driver('twitter')->redirect();
    }

    // Twitterコールバック
    public function handleProviderCallback() {
        try {
            // ユーザー詳細情報の取得
            $twitterUser = Socialite::driver('twitter')->user();
            $user = $this->userService->getUserByTwitterId($twitterUser->id);

            // TwitterIDが存在しない場合の処理
            if(is_null($user)){

                // Twitter情報からユーザーアカウントを作成
                $request             = new Request();
                $request->twitter_id = $twitterUser->id;
                $request->twitter_nickname  = $twitterUser->nickname;
                $request->twitter_image_url = $twitterUser->avatar_original;
                $request->twitter_simple_image_url = $twitterUser->user['profile_image_url_https'];


                // すでにログイン中なら、ログインアカウントにTwitter情報を追加
                if(Auth::check()){
                    // ログインユーザーにTwitter情報をアップデート
                    $user = DB::transaction(function () use($request) {
                        $request->id = Auth::id();
                        return $this->userService-> updateUser($request);
                    });
                    Auth::login($user, true);

                // ログインしていないなら、新規アカウントを作成
                }else{
                    $request->game_id    = session('selected_game_id');
                    $request->name       = $twitterUser->name;
                    $request->email      = $twitterUser->email;
                    $request->password   = Hash::make($twitterUser->id.'hash_pass');
                    $request->body       = $twitterUser->user['description'];
                    // 新規ユーザー作成
                    $user = DB::transaction(function () use($request) {
                        return $this->userService->makeUser($request);
                    });
                    Auth::login($user, true);
                }

            }else{
                $user->twitter_nickname  = $twitterUser->nickname;
                $user->twitter_image_url = $twitterUser->avatar_original;
                $user->twitter_simple_image_url = $twitterUser->user['profile_image_url_https'];
                $user->save();

                Auth::login($user, true);
            }

        } catch (Exception $e) {
            return redirect('/login')->with('flash_message', 'エラーが発生しました');
        }

        // duelページなどからTwitterログインしてきた場合に元のページに戻す
        if(session('loginAfterRedirectUrl')){
            $redirectUrl = session('loginAfterRedirectUrl');
            session()->forget('loginAfterRedirectUrl');
            return redirect($redirectUrl);
        }
        return redirect('/user/'.Auth::user()->id);
    }
}

<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;

use Auth;
use Hash;
use DB;

use App\Services\UserService;

class AppleController extends Controller
{

    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    // Twitterログイン
    public function redirectToProvider()
    {
        $url = 'https://appleid.apple.com/auth/authorize?';
        $url = $url . 'client_id=' . config('services.apple.client_id');
        $url = $url . '&scope=name email';
        $url = $url . '&redirect_uri=' . config('services.apple.redirect');
        $url = $url . '&response_type=code id_token ';
        $url = $url . '&state=aaa';
        $url = $url . '&nonce=bbb';
        $url = $url . '&response_mode=form_post';

        return redirect($url);
    }

    // Api用Twitterログイン
    public function redirectToProviderForApi()
    {
        session(['api' => true]);
        $url = 'https://appleid.apple.com/auth/authorize?';
        $url = $url . 'client_id=' . config('services.apple.client_id');
        $url = $url . '&scope=name email';
        $url = $url . '&redirect_uri=' . config('services.apple.redirect');
        $url = $url . '&response_type=code id_token ';
        $url = $url . '&state=aaa';
        $url = $url . '&nonce=bbb';
        $url = $url . '&response_mode=form_post';
        return redirect($url);
    }

    // Twitterコールバック
    public function handleProviderCallback(Request $request)
    {

        try {
            // ユーザー詳細情報の取得
            $id_token = $request->id_token;
            $tokenParts = explode(".", $id_token);
            $tokenHeader = base64_decode($tokenParts[0]);
            $tokenPayload = base64_decode($tokenParts[1]);
            $jwtHeader = json_decode($tokenHeader);
            $jwtPayload = json_decode($tokenPayload);
            $sub = json_decode($tokenPayload)->sub;

            $user = null;
            if($sub){
                $user = $this->userService->getUserByAppleCode($sub);
            }

            // TwitterIDが存在しない場合の処理
            if(is_null($user)){
                // Twitter情報からユーザーアカウントを作成
                $request             = new Request();
                $request->apple_code = $sub;

                // すでにログイン中なら、ログインアカウントにTwitter情報を追加
                if(Auth::check()){
                    // ログインユーザーにTwitter情報をアップデート
                    $user = DB::transaction(function () use($request) {
                        $request->id = Auth::id();
                        return $this->userService->updateUser($request);
                    });
                    Auth::login($user, true);

                // ログインしていないなら、新規アカウントを作成
                }else{
                    $game_id = config('assets.site.game_ids.pokemon_card');
                    if(session('selected_game_id')){
                        $game_id = session('selected_game_id');
                    }
                    $request->game_id    = $game_id;
                    $request->name       = 'ユーザー';
                    $request->email      = json_decode($tokenPayload)->email;
                    $request->password   = Hash::make($sub.'hash_pass');
                    $request->body       = '';
                    $request->twitter_nickname = 'ユーザー';
                    $request->twitter_image_url = '/images/icon/default-icon-mypage.jpg';
                    $request->twitter_simple_image_url = '/images/icon/default-account.png';
                        // 新規ユーザー作成
                    $user = DB::transaction(function () use($request) {
                        return $this->userService->makeUser($request);
                    });
                    Auth::login($user, true);
                }

            }else{
                Auth::login($user, true);
            }

        } catch (\Exception $e) {

            if(session('api')){
                session()->forget('api');
                $loginId = 0;
                return view('auth.api_logined',compact('loginId'));
            }
            return redirect('/login')->with('flash_message', 'エラーが発生しました');
        }

//        if(session('api')){
            session()->forget('api');
            $loginId = Auth::id();
            return view('auth.api_logined',compact('loginId'));
//        }
//        return redirect('/user/' . Auth::user()->id);
    }
}

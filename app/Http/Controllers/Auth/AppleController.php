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
        return Socialite::driver('apple')->redirect();
    }

    // Api用Twitterログイン
    public function redirectToProviderForApi()
    {
        session(['api' => true]);
        return Socialite::driver('apple')->redirect();
    }

    // Twitterコールバック
    public function handleProviderCallback(Request $request) {

        dd(
            [
                Socialite::driver('apple')->stateless()
            ]
            );

        try {
            // ユーザー詳細情報の取得
            $appleUser = Socialite::driver('apple')->user();

            $user = $this->userService->getUserByAppleId($appleUser->id);

            // TwitterIDが存在しない場合の処理
            if(is_null($user)){
                // Twitter情報からユーザーアカウントを作成
                $request             = new Request();
                $request->apple_id = $appleUser->id;

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
                    $request->game_id    = session('selected_game_id');
                    $request->name       = $appleUser->name;
                    $request->email      = $appleUser->email;
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

        if(session('api')){
            session()->forget('api');
            $loginId = Auth::id();
            return view('auth.api_logined',compact('loginId'));
        }
        return redirect('/user/' . Auth::user()->id);
    }
}

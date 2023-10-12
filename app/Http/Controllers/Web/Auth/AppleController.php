<?php

namespace App\Http\Controllers\Web\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Hash;
use App\Services\User\UserService;

class AppleController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function redirectToProvider()
    {
        session(['web' => true]);
        $url = 'https://appleid.apple.com/auth/authorize?';
        $url .= 'client_id=' . config('services.apple.client_id');
        $url .= '&scope=name email';
        $url .= '&redirect_uri=' . config('services.apple.redirect');
        $url .= '&response_type=code id_token ';
        $url .= '&state=aaa';
        $url .= '&nonce=bbb';
        $url .= '&response_mode=form_post';
        return redirect($url);
    }

    public function redirectToProviderForApi(): string
    {
        session(['api' => true]);
        $url = 'https://appleid.apple.com/auth/authorize?';
        $url .= 'client_id=' . config('services.apple.client_id');
        $url .= '&scope=name email';
        $url .= '&redirect_uri=' . config('services.apple.redirect');
        $url .= '&response_type=code id_token ';
        $url .= '&state=aaa';
        $url .= '&nonce=bbb';
        $url .= '&response_mode=form_post';
        return redirect($url);
    }

    // Appleコールバック https://hashimu.com/api/auth/apple/redirect
    public function handleProviderCallback(Request $request)
    {
        if (!session('api') && !session('web')) {
            session(['api' => true]);
        }
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
            if ($sub) {
                $user = $this->userService->findUserBy('apple_code', $sub);
            }
            if (is_null($user)) {
                $userAttrs['apple_core'] = $sub;
                if (Auth::check()) {
                    $user = $this->userService->updateUser(Auth::id(), $userAttrs);
                } else {
                    $game_id = config('assets.site.game_ids.pokemon_card');
                    if (session('selected_game_id')) {
                        $game_id = session('selected_game_id');
                    }
                    $userAttrs['selected_game_id']    = $game_id;
                    $userAttrs['name']       = 'ユーザー';
                    $userAttrs['email']      = json_decode($tokenPayload)->email;
                    $userAttrs['password']   = Hash::make($sub . 'hash_pass');
                    $userAttrs['body']       = '';
                    $userAttrs['twitter_nickname'] = 'ユーザー';
                    $userAttrs['twitter_image_url'] = '/images/icon/default-icon-mypage.jpg';
                    $userAttrs['twitter_simple_image_url'] = '/images/icon/default-account.png';
                        // 新規ユーザー作成
                    $user = $this->userService->createUser($userAttrs);
                }
            }
        } catch (\Exception $e) {
            \Log::debug('bb');
            if (session('api')) {
                \Log::debug('cc');
                session()->forget('api');
                $loginId = 0;
                return view('auth.api_logined', compact('loginId'));
            }
            \Log::debug('dd');
            return redirect('/login')->with('flash_message', 'エラーが発生しました');
        }
        Auth::login($user, true);
        if (session('api')) {
            \Log::debug('ee');
            session()->forget('api');
            $loginId = Auth::id();
            return view('auth.api_logined', compact('loginId'));
        }
        \Log::debug('ff');
        return redirect('/user/' . Auth::user()->id);
    }
}

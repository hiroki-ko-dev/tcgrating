<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;
use App\Services\User\UserInfoDiscordService;
use App\Dto\Auth\DiscordAuthResponseDto;
use Auth;
use DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class DiscordController extends Controller
{
    public function __construct(
        private readonly UserInfoDiscordService $userDiscordService,
    ) {
    }

    // Twitterログイン
    public function redirectToProvider()
    {
        return Socialite::driver('discord')->redirect();
    }

    // Api用Twitterログイン
    public function redirectToProviderForApi()
    {
        session(['api' => true]);
        return Socialite::driver('discord')->redirect();
    }

    public function handleProviderCallback(): View | Redirect
    {
        try {
            // ユーザー詳細情報の取得
            $discordUser = Socialite::driver('discord')->user();
            $user = $this->userInfoDiscordService->login(
                new DiscordAuthResponseDto(
                    id: (int)$discordUser->id,
                    name: $discordUser->name,
                    nickname: $discordUser->nickname,
                    email: $discordUser->email,
                    profileImagePath: $discordUser->avatar,
                )
            );
            $redirectUrl = $this->userInfoDiscordService->getRedirectUrl($user->id);
            Auth::login($user, true);
            return redirect($redirectUrl);
        } catch (\Exception $e) {
            if (session('api')) {
                session()->forget('api');
                $loginId = 0;
                return view('auth.api_logined', compact('loginId'));
            }
            return redirect('/login')->with('flash_message', 'エラーが発生しました');
        }
    }
}

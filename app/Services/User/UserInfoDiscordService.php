<?php

declare(strict_types=1);

namespace App\Services\User;

use App\Models\User;
use App\Dto\Auth\DiscordAuthResponseDto;
use DB;
use Hash;

final class UserInfoDiscordService extends UserService
{
    public function login(DiscordAuthResponseDto $discordAuthInfoDto): User
    {
        $user = DB::transaction(function () use ($discordAuthInfoDto) {
            $userAttrs['selected_game_id'] = config('assets.site.game_ids.pokemon_card');
            $userAttrs['name'] = $discordAuthInfoDto->name;
            $userAttrs['email'] = $discordAuthInfoDto->email;
            $userDiscordAttrs['discord_id'] = $discordAuthInfoDto->id;
            $userDiscordAttrs['nickname'] = $discordAuthInfoDto->nickname;
            $discordUser = $this->findUserDiscord($discordAuthInfoDto->id);
            if ($discordUser) {
                $user = $this->updateUser($discordUser->user->id, $userAttrs);
                $this->updateUserDiscord($user->id, $userAttrs);
            } else {
                $user = $this->findUserBy('email', $discordAuthInfoDto->email);
                if (!$user) {
                    $userAttrs['password'] = Hash::make($discordAuthInfoDto->id . 'hash_pass');
                    $user = $this->createUser($userAttrs);
                }
                $userDiscordAttrs['user_id'] = $user->id;
                $this->createUserInfoDiscord($userDiscordAttrs);
            }
            return $user;
        });
        return $user;
    }

    public function getRedirectUrl(int $userId): string
    {
        if (session('loginAfterRedirectUrl')) {
            $redirectUrl = session('loginAfterRedirectUrl');
            session()->forget('loginAfterRedirectUrl');
        } elseif (session('api')) {
            session()->forget('api');
            $redirectUrl = '/auth.api_logined';  // Put your correct URL here
        } else {
            $redirectUrl = '/resume/' . $userId;
        }

        return $redirectUrl;
    }
}

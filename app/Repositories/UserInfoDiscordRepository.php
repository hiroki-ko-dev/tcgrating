<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\UserInfoDiscord;

final class UserInfoDiscordRepository
{
    public function create(array $attrs): UserInfoDiscord
    {
        $userDiscord = new UserInfoDiscord();
        $userDiscord->user_id = $attrs['user_id'];
        $userDiscord->discord_id = $attrs['discord_id'];
        $userDiscord->nickname = $attrs['nickname'];
        $userDiscord->save();

        return $userDiscord;
    }

    public function find(int $id)
    {
        return UserInfoDiscord::find($id);
    }

    public function update(int $id, array $attrs): UserInfoDiscord
    {
        $userDiscord = $this->find($id);
        $userDiscord->discord_id = $attrs['discord_id'];
        $userDiscord->nickname = $attrs['nickname'];
        $userDiscord->save();

        return $userDiscord;
    }
}

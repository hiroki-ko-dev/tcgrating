<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\UserDiscord;

final class UserDiscordRepository
{
    public function create(array $data): UserDiscord
    {
        $userDiscord = new UserDiscord();
        $userDiscord->user_id = $data->user_id;
        
        return UserDiscord::find($id);
    }

    public function find($id)
    {
        return UserDiscord::find($id);
    }
}

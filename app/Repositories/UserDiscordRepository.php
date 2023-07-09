<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\UserDiscord;

final class UserDiscordRepository
{
    public function find($id) {
        return UserDiscord::find($id);
    }
}

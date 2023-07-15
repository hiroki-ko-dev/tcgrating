<?php

declare(strict_types=1);

namespace App\Services\User;

use App\Models\GameUser;

final class UserResumeService extends UserService
{
    public function show(int $userId): GameUser
    {
        $this->findUser($userId);
        $gameId = $this->fetchSelectedGameId($userId);
        $gameUser = $this->getGameUserByGameIdAndUserId($gameId, $userId);
        if (is_null($gameUser)) {
            throw new \Exception("GameUser not found");
        }
        return $gameUser;
    }
}

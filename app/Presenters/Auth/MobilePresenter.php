<?php

namespace App\Presenters\Auth;

use App\Models\GameUser;
use App\Enums\Gender;

final class MobilePresenter
{
    public function login(GameUser $gameUser): array
    {
        return [
            'user' => [
                'id' => $gameUser->user->id,
                'name' => $gameUser->user->name,
                'body' => $gameUser->user->birthday,
                'profileImagePath' => $gameUser->user->profile_image_path,
                'birthday' => $gameUser->user->birthday,
                'gender' => $this->getGenderName($gameUser->user->gender),
                'rate' => $gameUser->rate,
            ]
        ];
    }

    private function getGenderName(int $gender): string
    {
        return Gender::from($gender)->description();
    }
}

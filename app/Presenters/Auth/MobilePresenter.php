<?php

namespace App\Presenters\Auth;

use App\Enums\Gender;

final class MobilePresenter
{
    public function login(User $user): array
    {
        return [
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'body' => $user->birthday,
                'profileImagePath' => $user->profile_image_path,
                'birthday' => $user->birthday,
                'gender' => $this->getGenderName($user->gender),
            ]
        ];
    }

    private function getGenderName(int $gender): string
    {
        return Gender::from($gender)->description();
    }
}

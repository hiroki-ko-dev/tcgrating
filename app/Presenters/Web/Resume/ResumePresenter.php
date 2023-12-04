<?php

namespace App\Presenters\Web\Resume;

use App\Models\GameUser;
use App\Enums\Gender;

final class ResumePresenter
{
    public function resume(gameUser $gameUser): string
    {
        $gameUserChecks = [];
        foreach ($gameUser->gameUserChecks as $gameUserCheck) {
            // Assign a value of true to the key which corresponds to the item_id
            $gameUserChecks[$gameUserCheck->item_id] = true;
        }

        return json_encode([
            'user' => [
                'id' => $gameUser->user->id,
                'name' => $gameUser->user->name,
                'body' => $gameUser->user->body,
                'gender' => $this->getGenderName($gameUser->user->gender),
                'gameUser' => [
                    'id' =>  $gameUser->id,
                    'rank' => $gameUser->rank,
                    'area' => $gameUser->area,
                    'experience' => $gameUser->area,
                    'preference' => $gameUser->preference,
                    'gameUserChecks' => $gameUserChecks,
                ],
            ],
        ]);
    }

    private function getGenderName(int $gender): string
    {
        return Gender::from($gender)->alternativeDescription();
    }
}

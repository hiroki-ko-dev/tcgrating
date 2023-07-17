<?php

declare(strict_types=1);

namespace App\Enums;

enum PostCategory: int
{
    case CATEGORY_FREE = 1;
    case CATEGORY_DUEL = 2;
    case CATEGORY_TEAM = 3;
    case CATEGORY_TEAM_WANTED = 4;
    case CATEGORY_EVENT = 5;
    case CATEGORY_PERSONAL = 6;

    public function description(): string
    {
        return match ($this) {
            PostCategory::CATEGORY_FREE => 'フリー',
            PostCategory::CATEGORY_DUEL => '対戦',
            PostCategory::CATEGORY_TEAM =>  'チーム',
            PostCategory::CATEGORY_TEAM_WANTED => 'チーム募集',
            PostCategory::CATEGORY_EVENT => '大会',
            PostCategory::CATEGORY_PERSONAL => '個別',
        };
    }

}
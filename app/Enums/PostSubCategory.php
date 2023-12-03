<?php

declare(strict_types=1);

namespace App\Enums;

enum PostSubCategory: int
{
    case FREE = 1;
    case DECK = 2;
    case RULE = 3;

    public function description(): string
    {
        return match ($this) {
            PostSubCategory::FREE  => '雑談',
            PostSubCategory::DECK  => 'デッキ相談',
            PostSubCategory::RULE  => 'ルール質問',
        };
    }

}
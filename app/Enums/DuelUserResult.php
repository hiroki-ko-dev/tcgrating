<?php

declare(strict_types=1);

namespace App\Enums;

enum DuelUserResult: int
{
    case WIN = 1;
    case LOSE = 2;
    case DRAW = 3;
    case INVALID = 4;

    public function description(): string
    {
        return match ($this) {
            self::WIN => '勝利',
            self::LOSE => '敗北',
            self::DRAW => 'ドロー',
            self::INVALID => '無効',
        };
    }
}

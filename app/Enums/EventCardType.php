<?php

declare(strict_types=1);

namespace App\Enums;

enum EventCardType: int
{
    case NORMAL = 1;
    case PROXY = 2;

    public function description(): string
    {
        return match ($this) {
            self::NORMAL => 'なし',
            self::PROXY => 'あり',
        };
    }
}

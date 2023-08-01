<?php

declare(strict_types=1);

namespace App\Enums;

enum EventRegulationType: int
{
    case STANDARD = 1;
    case EXTRA = 2;

    public function description(): string
    {
        return match ($this) {
            self::STANDARD => 'スタンダード',
            self::EXTRA => 'エクストラ',
        };
    }
}

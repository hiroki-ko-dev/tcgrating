<?php

declare(strict_types=1);

namespace App\Enums;

enum EventRateType: int
{
    case RATE = 1;
    case EXHIBITION = 2;

    public function description(): string
    {
        return match ($this) {
            self::RATE => 'レート戦',
            self::EXHIBITION => 'エキシビジョン戦',
        };
    }
}

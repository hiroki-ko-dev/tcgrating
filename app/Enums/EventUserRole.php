<?php

declare(strict_types=1);

namespace App\Enums;

enum EventUserRole: int
{
    case USER = 1;
    case ADMIN = 2;

    public function description(): string
    {
        return match ($this) {
            self::USER => 'ユーザー',
            self::ADMIN => '管理者',
        };
    }
}

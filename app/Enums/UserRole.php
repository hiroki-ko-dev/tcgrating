<?php

declare(strict_types=1);

namespace App\Enums;

enum UserRole: int
{
    case NONE = 0;
    case ADMIN = 1;

    public function description(): string
    {
        return match ($this) {
            self::NONE => '権限無し',
            self::ADMIN => '管理者',
        };
    }
}

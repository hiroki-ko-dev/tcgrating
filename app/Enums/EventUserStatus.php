<?php

declare(strict_types=1);

namespace App\Enums;

enum EventUserStatus: int
{
    case REQUEST   = 0;
    case APPROVAL  = 1;
    case REJECT    = 2;
    case MASTER    = 3;

    public function description(): string
    {
        return match ($this) {
            self::RECRUIT => '参加者募集中',
            self::APPROVAL => '参加決定',
            self::REJECT => 'キャンセル',
            self::MASTER => '管理者',
        };
    }
}

<?php

declare(strict_types=1);

namespace App\Enums;

enum EventUserStatus: int
{
    case REQUEST   = 1;
    case APPROVAL  = 2;
    case REJECT    = 3;
    case MASTER    = 4;

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

<?php

declare(strict_types=1);

namespace App\Enums;

enum EventStatus: int
{
    case RECRUIT = 0;
    case READY = 1;
    case FINISH = 2;
    case CANCEL = 3;
    case INVALID = 4;

    public function description(): string
    {
        return match ($this) {
            self::RECRUIT => '参加者募集中',
            self::READY => '準備完了',
            self::FINISH => '完了',
            self::CANCEL => 'キャンセル',
            self::INVALID => '無効',
        };
    }
}

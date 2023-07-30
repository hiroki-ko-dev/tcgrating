<?php

declare(strict_types=1);

namespace App\Enums;

enum DuelStatus: int
{
    case RECRUIT = 1;
    case READY = 2;
    case FINISH = 3;
    case CANCEL = 4;
    case INVALID = 5;

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

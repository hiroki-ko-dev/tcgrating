<?php

declare(strict_types=1);

namespace App\Enums;

enum EventUserAttendance: int
{
    case PREPARING = 1;
    case READY = 2;
    case ATTENDED = 3;
    case ABSENT = 4;

    public function description(): string
    {
        return match ($this) {
            self::PREPARING => '参加準備中',
            self::READY => '参加受付完了',
            self::ATTENDED => '参加決定',
            self::ABSENT => 'キャンセル',
        };
    }
}

<?php

declare(strict_types=1);

namespace App\Enums;

enum GameUserCheckItem: int
{
    case RegulationStandard = 1;
    case RegulationExtra = 2;
    case RegulationLegend = 3;
    case PlayStyleRemote = 101;
    case PlayStyleEvent = 102;
    case PlayStyleAdvice = 103;
    case PlayStyleBeginner = 104;
    case PlayStyleIntermediate = 105;
    case PlayStyleSenior = 106;

    public function description(): string
    {
        return match ($this) {
            self::RegulationStandard => 'スタンダード',
            self::RegulationExtra => 'エクストラ',
            self::RegulationLegend => '殿堂',
            self::PlayStyleRemote => 'リモート対戦募集！',
            self::PlayStyleEvent => '大会に出たい！',
            self::PlayStyleAdvice => '雑談がしたい！',
            self::PlayStyleBeginner => '初心者です！',
            self::PlayStyleIntermediate => 'エンジョイ勢です！',
            self::PlayStyleSenior => 'ガチ勢です！',
        };
    }
}

<?php

declare(strict_types=1);

namespace App\Enums;

enum Gender: int
{
    case Undefined = 0;
    case Male = 1;
    case Female = 2;

    public function description(): string
    {
        return match ($this) {
            Gender::Undefined => '',
            Gender::Male => '男',
            Gender::Female => '女',
        };
    }

    public function alternativeDescription(): string
    {
        return match ($this) {
            Gender::Undefined => '',
            Gender::Male => '♂',   // ここを別の表現に変更
            Gender::Female => '♀', // ここを別の表現に変更
        };
    }
}
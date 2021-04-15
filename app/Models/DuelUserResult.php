<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DuelUserResult extends Model
{
    use HasFactory;
    protected $guarded = [];

    //定数の定義
    const WIN     = 1;
    const LOSE    = 2;
    const DRAW    = 3;
    const INVALID = 4;

    const RESULT = [
        'win'     => self::WIN,
        'lose'    => self::LOSE,
        'draw'    => self::DRAW,
        'invalid' => self::INVALID,
    ];
}

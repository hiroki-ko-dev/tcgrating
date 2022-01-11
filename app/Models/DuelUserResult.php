<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DuelUserResult extends Model
{
    use HasFactory;
    protected $guarded = [];

    //定数の定義
    const RESULT_WIN     = 1;
    const RESULT_LOSE    = 2;
    const RESULT_DRAW    = 3;
    const RESULT_INVALID = 4;

    const RESULT = [
        'win'     => self::RESULT_WIN,
        'lose'    => self::RESULT_LOSE,
        'draw'    => self::RESULT_DRAW,
        'invalid' => self::RESULT_INVALID,
    ];
}

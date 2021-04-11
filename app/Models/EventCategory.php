<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventCategory extends Model
{
    use HasFactory;

    //定数の定義
    const ONE_VS_ONE     = 1;
    const CATEGORY = [
        'one_vs_one'     => self::ONE_VS_ONE,
    ];
}

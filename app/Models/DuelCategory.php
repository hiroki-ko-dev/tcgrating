<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DuelCategory extends Model
{
    use HasFactory;

    //定数の定義
    const CATEGORY_SINGLE = 1;
    const CATEGORY_POINT  = 2;
    const CATEGORY = [
        'single'     => self::CATEGORY_SINGLE,
    ];

}

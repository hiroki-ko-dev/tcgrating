<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventCategory extends Model
{
    use HasFactory;

    //定数の定義
    const CATEGORY_SINGLE = 1;
    const CATEGORY_GROUP  = 2;
    const CATEGORY_SWISS  = 3;
    const CATEGORY = [
        'single' => self::CATEGORY_SINGLE,
        'group'  => self::CATEGORY_GROUP,
        'group'  => self::CATEGORY_SWISS,
    ];
}

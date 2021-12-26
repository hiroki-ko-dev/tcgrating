<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventCategory extends Model
{
    use HasFactory;

    //定数の定義
    const SINGLE = 1;
    const GROUP  = 2;
    const CATEGORY = [
        'single' => self::SINGLE,
        'group'  => self::GROUP,
    ];
}

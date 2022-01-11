<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostCategory extends Model
{
    use HasFactory;

    //定数の定義
    const CATEGORY_FREE           = 1;
    const CATEGORY_DUEL           = 2;
    const CATEGORY_TEAM           = 3;
    const CATEGORY_TEAM_WANTED    = 4;
    const CATEGORY_EVENT          = 5;
    const CATEGORY_PERSONAL       = 6;
    const CATEGORY = [
        'free'           => self::CATEGORY_FREE,
        'duel'           => self::CATEGORY_DUEL,
        'team'           => self::CATEGORY_TEAM,
        'team_wanted'    => self::CATEGORY_TEAM_WANTED,
        'event'          => self::CATEGORY_EVENT,
        'personal'       => self::CATEGORY_PERSONAL,
    ];
}

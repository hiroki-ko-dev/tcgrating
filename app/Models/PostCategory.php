<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostCategory extends Model
{
    use HasFactory;

    //定数の定義
    const FREE           = 1;
    const DIRECT_MASSAGE = 2;
    const TEAM           = 3;
    const TEAM_WANTED    = 4;
    const EVENT          = 5;
    const PERSONAL       = 6;
    const CATEGORY = [
        'FREE'           => self::FREE,
        'direct_massage' => self::DIRECT_MASSAGE,
        'team'           => self::TEAM,
        'team_wanted'    => self::TEAM_WANTED,
        'event'          => self::EVENT,
        'personal'       => self::PERSONAL,
    ];
}
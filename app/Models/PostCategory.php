<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostCategory extends Model
{
    use HasFactory;

    //定数の定義
    const FREE           = 0;
    const DIRECT_MASSAGE = 1;
    const TEAM           = 2;
    const TEAM_WANTED    = 3;
    const EVENT          = 4;
    const PERSONAL       = 5;
    const CATEGORY = [
        'FREE'           => self::DIRECT_MASSAGE,
        'direct_massage' => self::DIRECT_MASSAGE,
        'team'           => self::TEAM,
        'team_wanted'    => self::TEAM_WANTED,
        'event'          => self::EVENT,
        'personal'       => self::PERSONAL,
    ];
}

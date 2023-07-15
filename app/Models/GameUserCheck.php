<?php

namespace App\Models;

use Auth;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GameUserCheck extends Model
{
    use HasFactory;

    protected $guarded = [];

    const ITEM_TYPES = [
        'regulation' => 1,
        'play_style' => 2,
    ];

    const ITEM_ID_REGULATIONS = [
        'standard' => 1,
        'extra'    => 2,
        'legend'   => 3,
    ];

    const ITEM_ID_REGULATIONS_NAME = [
        self::ITEM_ID_REGULATIONS['standard'] => 'スタンダード',
        self::ITEM_ID_REGULATIONS['extra']    => 'エクストラ',
        self::ITEM_ID_REGULATIONS['legend']   => '殿堂',
    ];

    const ITEM_ID_PLAY_STYLES = [
        'remote' => 101,
        'event'    => 102,
        'advice'   => 103,
        'beginner' => 104,
        'intermediate' => 105,
        'senior'   => 106,
    ];

    const ITEM_ID_PLAY_STYLES_NAME = [
        self::ITEM_ID_PLAY_STYLES['remote']    => 'リモート対戦募集！',
        self::ITEM_ID_PLAY_STYLES['event']    => '大会に出たい！',
        self::ITEM_ID_PLAY_STYLES['advice']   => '雑談がしたい！',
        self::ITEM_ID_PLAY_STYLES['beginner'] => '初心者です！',
        self::ITEM_ID_PLAY_STYLES['intermediate'] => 'エンジョイ勢です！',
        self::ITEM_ID_PLAY_STYLES['senior']   => 'ガチ勢です！',
    ];

    public function gameUser()
    {
        return $this->belongsTo('App\Models\Game', 'game_id');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }
}

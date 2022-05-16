<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;
    protected $guarded = [];

    //定数の定義
    const STATUS_RECRUIT   = 0;
    const STATUS_READY     = 1;
    const STATUS_FINISH    = 2;
    const STATUS_CANCEL    = 3;
    const STATUS_INVALID   = 4;

    const STATUS = [
        'recruit'  => self::STATUS_RECRUIT,
        'ready'    => self::STATUS_READY,
        'finish'   => self::STATUS_FINISH,
        'cancel'   => self::STATUS_CANCEL,
        'invalid'  => self::STATUS_INVALID,
    ];

    //定数の定義
    const RATE_TYPE_RATE = 0;
    const RATE_TYPE_EXHIBITION = 1;

    const RATE_TYPE = [
        'rate'  => self::RATE_TYPE_RATE,
        'exhibition' => self::RATE_TYPE_EXHIBITION,
    ];

    const RATE_TYPE_STR = [
        self::RATE_TYPE_RATE  => 'レート戦',
        self::RATE_TYPE_EXHIBITION  => 'エキシビジョン戦',
    ];

    //定数の定義
    const REGULATION_TYPE_STANDARD = 0;
    const REGULATION_TYPE_EXTRA = 1;

    const REGULATION_TYPE = [
        'normal'  => self::REGULATION_TYPE_STANDARD,
        'proxy' => self::REGULATION_TYPE_EXTRA,
    ];

    const REGULATION_TYPE_STR = [
        self::REGULATION_TYPE_STANDARD  => 'スタンダード',
        self::REGULATION_TYPE_EXTRA  => 'エクストラ',
    ];

    //定数の定義
    const CARD_TYPE_NORMAL = 0;
    const CARD_TYPE_PROXY = 1;

    const CARD_TYPE = [
        'normal'  => self::CARD_TYPE_NORMAL,
        'proxy' => self::CARD_TYPE_PROXY,
    ];

    const CARD_TYPE_STR = [
        self::CARD_TYPE_NORMAL  => 'なし',
        self::CARD_TYPE_PROXY  => 'あり',
    ];

    public function user(){
        return $this->belongsTo('App\Models\User','user_id','id');
    }

    public function eventUsers(){
        return $this->hasMany('App\Models\EventUser','event_id','id');
    }

    public function eventDuels(){
        return $this->hasMany('App\Models\EventDuel','event_id','id');
    }

    public function game(){
        return $this->belongsTo('App\Models\Game','game_id','id');
    }
}

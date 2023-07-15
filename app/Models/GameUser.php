<?php

namespace App\Models;

use Auth;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GameUser extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function getRankAttribute(): int
    {
        return self::where('game_id', $this->game_id)
            ->where('rate', '>', $this->rate)->count() + 1;
    }

    public static function getCount()
    {
        return self::count();
    }

    public function game()
    {
        return $this->belongsTo('App\Models\Game', 'game_id');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }

    public function gameUserChecks()
    {
        return $this->hasMany('App\Models\GameUserCheck', 'game_user_id', 'id');
    }
}

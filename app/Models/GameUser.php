<?php

namespace App\Models;

use Auth;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GameUser extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function game()
    {
        return $this->belongsTo('App\Models\Game','game_id');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User','user_id');
    }
}

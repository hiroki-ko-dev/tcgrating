<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DuelUser extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function duel()
    {
        return $this->belongsTo('App\Models\Duel', 'duel_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }

    public function duelUserResults()
    {
        return $this->hasMany('App\Models\DuelUserResult', 'duel_user_id', 'id');
    }
}

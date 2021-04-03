<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DuelUser extends Model
{
    use HasFactory;

    public function duel(){
        return $this->belongsTo('App\Models\Duel','duel_id','id');
    }

    public function user(){
        return $this->belongsTo('App\Models\User','user_id','id');
    }
}

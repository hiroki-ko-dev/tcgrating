<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Duel extends Model
{
    use HasFactory;

    public function duelUser(){
        return $this->hasMany('App\Models\duelUser','duel_id','id');
    }
}

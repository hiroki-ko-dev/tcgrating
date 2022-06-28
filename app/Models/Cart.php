<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function game(){
        return $this->belongsTo('App\Models\Game','game_id','id');
    }
}

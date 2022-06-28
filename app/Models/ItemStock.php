<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemStock extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function item(){
        return $this->belongsTo('App\Models\Item','item_id','id');
    }
}

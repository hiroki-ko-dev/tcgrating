<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionUser extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function transaction(){
        return $this->belongsTo('App\Models\Transaction','item_id','id');
    }

    public function user(){
        return $this->belongsTo('App\Models\Transaction','item_id','id');
    }
}

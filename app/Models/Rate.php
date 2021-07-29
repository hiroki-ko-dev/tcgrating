<?php

namespace App\Models;

use Auth;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rate extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo('App\Models\User','user_id');
    }
}

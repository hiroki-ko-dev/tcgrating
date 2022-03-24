<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function post()
    {
        return $this->belongsTo('App\Models\Post');
    }

    public function postComments()
    {
        return $this->hasMany('App\Models\PostComment','user_id','id');
    }

    public function postUser()
    {
        return $this->belongsTo('App\Models\PostUser','user_id');
    }

    public function teamUser()
    {
        return $this->belongsTo('App\Models\TeamUser','user_id');
    }

    public function gameUsers()
    {
        return $this->hasMany('App\Models\GameUser','user_id');
    }

    public function eventUsers()
    {
        return $this->hasMany('App\Models\EventUser','user_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

// Stripe決済を使うための追加
use Laravel\Cashier\Billable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;
    // Stripe決済を使うための追加
    use Billable;

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


    //定数の定義
    const ROLE_USER   = 0;
    const ROLE_ADMIN  = 1;

    const ROLES = [
        self::ROLE_USER => 'メンバー',
        self::ROLE_ADMIN => '管理者',
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

    public function carts()
    {
        return $this->hasMany('App\Models\Cart','user_id');
    }

    public function transactions()
    {
        return $this->hasMany('App\Models\Transaction','user_id');
    }
}

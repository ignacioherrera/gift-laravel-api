<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','birth_date', 'avatar', 'card'
    ];

    protected $attributes = [
        'avatar' => '',
        'card' => '',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    public function eventsDedicated(){
        return $this->hasMany('App\Event','user_id');
    }
    public function eventsInvolved($actives=false){
        if($actives) return $this->belongsToMany(App\Event::class, 'event_user')->where();
        return $this->belongsToMany(App\Event::class, 'event_user');
    }
    public function messages()
    {
    return $this->hasMany(Message::class);
    }
}

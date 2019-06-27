<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    //
    protected $fillable = [
        'name', 'date', 'active','for_user', 'user_id'
    ];

    protected $attributes = [
        'for_user' => false,
        'user_id' => '',
        'active' => true
    ];

    public function eventsInvolved(){
        return $this->belongsToMany(App\User::class, 'event_user');
    }

}

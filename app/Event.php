<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    //
    protected $fillable = [
        'name', 'event_date', 'active','for_user', 'user_id', 'creator_id'
    ];

    protected $attributes = [
        'for_user' => false,
        'user_id' => null,
        'active' => true
    ];

    public function eventsInvolved(){
        return $this->belongsToMany(App\User::class, 'event_user');
    }
    public function messages()
    {
    return $this->hasMany(Message::class);
    }

}

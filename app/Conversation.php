<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Conversation extends Model
{
    
    protected $fillable = [
        'user', 'friend', 'messages'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'timestamp' => 'datetime',
    ];
    

}

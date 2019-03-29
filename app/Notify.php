<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Notify extends Model
{
    protected $fillable = [
        'content', 'from', 'to', 
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

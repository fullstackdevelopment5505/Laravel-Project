<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Configuration extends Model
{
    protected $fillable = [
        'id','type','settings','price'
    ];

    protected $casts = [
        'settings' => 'array'
    ];
}

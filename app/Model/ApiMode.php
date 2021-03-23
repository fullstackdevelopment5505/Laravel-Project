<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ApiMode extends Model
{
    protected $table='api_mode';

    protected $fillable = [
        'api_name','enabled_mode','mode'
    ];
}

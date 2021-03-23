<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Holiday extends Model
{
    protected $table='holiday';

    protected $fillable = [
        'id','name','holiday_date'
    ];

}

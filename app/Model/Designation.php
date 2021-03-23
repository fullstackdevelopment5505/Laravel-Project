<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Designation extends Model
{
   
    protected $table='designations';

    protected $fillable = [
        'id','designation','department'
    ];

}

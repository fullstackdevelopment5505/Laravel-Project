<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Cities extends Model
{
    protected $table='us_cities';

    protected $fillable = ['ID','ID_STATE','CITY','COUNTY'];
}

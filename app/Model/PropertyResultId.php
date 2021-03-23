<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class PropertyResultId extends Model
{
    protected $table='property_result_id';
    protected $fillable = [
        'id','user_property_id','result_id'
    ];
	
}

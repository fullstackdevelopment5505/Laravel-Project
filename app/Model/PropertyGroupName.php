<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class PropertyGroupName extends Model
{
    protected $table='property_group_name';
    protected $fillable = [
        'id','user_property_id','result_id','folder_name'
    ];

}

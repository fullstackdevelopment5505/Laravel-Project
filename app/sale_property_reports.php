<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class sale_property_reports extends Model
{
    protected $table='sale_property_reports';

	protected $fillable=['date','customer_name','property_type','amount','tax','date','cash','created_at','updated_at'];

	protected $hidden=['id']; 
}

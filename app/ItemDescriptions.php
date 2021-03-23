<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ItemDescriptions extends Model
{
    protected $table='item_descriptions';

	protected $fillable=['invoice_no','item_name','item_description','unit_cost','quantity','amount','tax','discount', 'sub_total','created_at','updated_at'];

	protected $hidden=['id']; 
}

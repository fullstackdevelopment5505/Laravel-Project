<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DataFinder extends Model
{
    protected $table='data_finder';

	protected $fillable=['date','amount','tax','net_amount'];

	protected $hidden=['id']; 
}

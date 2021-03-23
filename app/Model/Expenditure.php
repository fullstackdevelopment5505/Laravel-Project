<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Expenditure extends Model
{
    protected $table='expenditure_master';

	protected $fillable=['expenditure_date','payment_mode','amount','type'];

	protected $hidden=['id']; 
}

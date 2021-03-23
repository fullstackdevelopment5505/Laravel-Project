<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Subscribe extends Model
{
    protected $table='subscriber';

    protected $fillable = [
       'email'                         // Type : 1- profile 2- kickstarter 3- property   
    ];

}

<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{

    protected $table='department';

    protected $fillable = [
        'id','name','created_at'
    ];

}

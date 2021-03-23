<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Manager extends Model
{
    protected $table='managers';
    protected $fillable = [
        'id','sale_executive','sale_manager'
    ];
    protected $visible = [
        'id','sale_executive','sale_manager'
    ];
}

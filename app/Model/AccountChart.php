<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class AccountChart extends Model
{
    protected $table='account_charts';

    protected $fillable = [
        'id','account_type','gl_code','title','type','status'
    ];
}

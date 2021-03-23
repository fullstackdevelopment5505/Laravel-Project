<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class States extends Model
{
    protected $table='us_states';

    protected $fillable = ['ID','STATE_CODE','STATE_NAME'];
}

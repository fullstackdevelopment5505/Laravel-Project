<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $table='role';

    protected $fillable = [
        'id','role', 'department_id'
    ];

    public function department()
    {
        return $this->belongsTo('App\Model\Department','department_id');

    }

    
    public function user()
    {
        return $this->belongsTo('App\User','role');

    }

}

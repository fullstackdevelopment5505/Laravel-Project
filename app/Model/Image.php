<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    protected $table='images';

    protected $fillable = [
        'user_id','type','filename'                         // Type : 1- profile 2- kickstarter 3- property   
    ];

    public function getFilenameAttribute($value)
    {
        return asset("storage/".$value);
    }

}

<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class PackageFeatures extends Model
{
    protected $table=' package_features';
    public $timestamps = true;
   
    protected $fillable = [
        'id','type','number_allowed','description','status'
    ];
	
}

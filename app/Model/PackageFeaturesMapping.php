<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class PackageFeaturesMapping extends Model
{
    protected $table=' package_features_mapping';
    public $timestamps = true;
   
    protected $fillable = [
        'id','package_id','feature_id','status'
    ];
	
	
}

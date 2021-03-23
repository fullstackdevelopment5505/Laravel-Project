<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Packages extends Model
{
    protected $table='packages';
    public $timestamps = true;
   
    protected $fillable = [
        'id','plan_name','price','validity_from','validity_to','status','validity_period'
    ];
	
	public function features()
	{
		return $this->hasMany('App\Model\PackageFeaturesMapping','id','package_id');
	}
}

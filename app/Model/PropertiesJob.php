<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use App\Model\PropertyResultId;

class PropertiesJob extends Model
{
	protected $table='properties_job';
   public $timestamps = true;
   
    protected $fillable = [
        'id','user_id','property_id','status','batch_id','user_property_id','result_id','type','progress','batch_total','started_at','completed_at',
    ];
	
}

<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
	protected $table='tbl_purchased_records';

	protected $fillable=['user_id','point_id','report_name','report_type','user_prop_id','property_id'];

	protected $hidden=['updated_at'];

	public function point()
        {
          return $this->belongsTo('App\Model\Points','point_id');
        }
}
 
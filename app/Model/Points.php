<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Points extends Model
{
	protected $table='points_transaction';

	protected $fillable=['user_id','type','point','trans_id','amount','instant','transaction_detail'];

	protected $hidden=['updated_at'];
	
	public function user()
    {
        return $this->belongsTo('App\User','user_id','id');

    }

	public function reports()
    {
        return $this->hasOne('App\Model\Report','point_id');
    }
}

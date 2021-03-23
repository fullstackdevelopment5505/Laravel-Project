<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Deposite extends Model
{
	protected $table='tbl_deposite';

	protected $fillable=['user_id','type','charge_id','balance_transaction','amount','currency','last4','brand','receipt_url','json'];

	protected $hidden=['id','charge_id','user_id','json','updated_at'];
	
	public function membership_deposite()
    {
        return $this->hasOne('App\Model\Member','trans_id')->orderBy('id','desc');
    }
}

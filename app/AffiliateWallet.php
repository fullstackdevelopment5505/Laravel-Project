<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AffiliateWallet extends Model
{
    protected $table='tbl_affiliate_wallet';
	
	protected $fillable=[ 'id', 'affiliate_id', 'amount', 'transaction_id', 'transaction_type', 'type', 'status', 'user_id', 'deposit_id', 'order_id', 'order_status'  ];

	public function affiliate_detail()
    {
        return $this->belongsTo('App\AffiliateUsers','affiliate_id','id');
    }
}

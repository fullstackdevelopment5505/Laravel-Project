<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AffiliateCommission extends Model
{
    protected $table='tbl_affiliate_commissions';
	
	protected $fillable=[ 'id', 'affiliate_id', 'commission' ];
}


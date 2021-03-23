<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vouchers extends Model
{
    protected $table='vouchers';

	protected $fillable=['id','voucher_no','voucher_type','amount','gst','total'];

	
}

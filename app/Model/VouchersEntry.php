<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class VouchersEntry extends Model
{
    protected $table='vouchers_entries';

	protected $fillable=['id','voucher_no','purpose','amount','tax','rem_total','status'];

}

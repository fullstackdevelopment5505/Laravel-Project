<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class PaymentMaster extends Model
{
    protected $table='tbl_user_payment_master';
    protected $fillable = [
        'id','user_id','amount','total_records','payment_type','payment_type_text'
    ];
}

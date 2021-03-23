<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $table='invoices';

    protected $fillable=['id','invoice_no','company_name','session','bill_type','address','gstin','date','invoice_prefix','rec_name',
    'rec_address','rec_state','rec_state_code','rec_gstin','con_name','con_address','con_state','con_state_code','con_gstin','sub_totla',
    'tax','discount','total','status','created_at','updated_at'];

	 
}

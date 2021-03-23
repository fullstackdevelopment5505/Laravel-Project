<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class CustomerMaster extends Model
{
    protected $table='customers_master';
    protected $fillable=['id','membership_id','email','phone_number','type','membership_purchase_date','first_name','last_name','company_name','city','state','country','address','postal_code','username','custid'];
    protected $visible=['id','membership_id','email','phone_number','type','membership_purchase_date','first_name','last_name','company_name','city','state','country','address','postal_code','username','custid'];

}

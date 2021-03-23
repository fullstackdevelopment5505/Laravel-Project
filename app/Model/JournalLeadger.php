<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class JournalLeadger extends Model
{
    protected $table='tbl_deposite';

	protected $fillable=['created_at','brand','amount','currency'];

	protected $hidden=['id']; 
}

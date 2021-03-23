<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Saved extends Model
{
	protected $table='tbl_saved_search';

	protected $fillable=['unique_id','user_id','search','status','title','folder_name'];

	protected $hidden=['updated_at'];
}

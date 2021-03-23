<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserPostcardTemplate extends Model
{
    protected $table='user_postcard_template';
	
	protected $fillable=['user_id',	'postcard_title',	'postcard_front_content',	'status',  'postcard_back_content'];

}

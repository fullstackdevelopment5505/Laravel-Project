<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
    protected $table='tbl_slider';
    protected $fillable=['type','image','slide_title','position','slider_content','status','deleted_at'];
	
	public function getimageAttribute($value)
    {
        return url($value);
    }
}

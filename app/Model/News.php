<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class News extends Model
{
	protected $table='news';

	protected $fillable=['url','title','small_description','description','filename','vimeo_id','posted_by_role','date','views','category',  'youtube_id'];//punch

	protected $hidden=['updated_at'];

	public function getFilenameAttribute($value)
    {
		if($value == ''){
			return '';
		}
        return url($value);
    }

	public function category()
    {
	   return $this->hasMany('App\Category','id','category');
    }

	public function category_detail()
    {
        return $this->hasOne('App\Category','id','category');
    }

	public function role_detail()
    {
        return $this->hasOne('App\NewsRole','id','posted_by_role');
    }



}

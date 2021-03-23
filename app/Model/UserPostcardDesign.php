<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class UserPostcardDesign extends Model
{
    protected $table='user_postcard_designs';
    public $timestamps = true;
   
   /* status= 0:resquest sent,1:accepted/in progress,2:completed,3:rejected */
    protected $fillable = [
        'user_id','postcard_size','handwriting_style','title','description','postcard_content','company_goal',
		'targets','primary_color','secondary_color','font_family','sample_image','additional_notes','save_as_template','status'
    ];
	
	public function users(){

        return $this->hasOne('App\User','id','user_id');
    }
	
	public function user_detail(){

        return $this->hasOne('App\Model\Detail','id','user_id');
    }
	
}

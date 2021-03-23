<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserEmailTemplate extends Model
{
    protected $table='user_email_template';
	
	protected $fillable=['user_id',	'template_title',	'template_content',	 'status', 'template_designer_name', 'template_subject', 'email_preheader', 'template_json'];

}

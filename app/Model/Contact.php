<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Contact extends Model
{
	use Notifiable;
	
    protected $table='contact_us';

    protected $fillable = [
        'first_name','last_name','email','phone','description'
    ];


}

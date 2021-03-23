<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;

use Illuminate\Notifications\Notification;

use Illuminate\Contracts\Queue\ShouldQueue;

use Illuminate\Notifications\Messages\MailMessage;

use Illuminate\Notifications\resources\views;

use Illuminate\Support\ServiceProvider;

class AffiliateRegister extends Notification{

	use Queueable;

	protected $my_notification; 
   
	public $data;
 

	public function __construct($data,$msg){

       $this->my_notification = $msg; 
	   $this->data = $data; 

	}

	public function via($notifiable){

       return ['mail'];

	}
	
	public function routeNotificationForMail($notification){
        // Return email address only...
        //return $this->email;

        // Return name and email address...
        return [$this->email => $this->data["email"]];
    }
	
	public function toMail($notifiable){
		
		$url = config('app.affiliate_url') . 'login';
		return (new MailMessage)
		->greeting('Hello '.$this->data["fullname"].',')
		->subject('Affiliate approval confirmation')
		->line($this->my_notification)
		->action('Click here to complete the process', $this->data["url"])
		->salutation('Thank you for using '. config('app.website_url') )
		->markdown('mail.welcome.signup',['url' => $this->data["url"],'data' => $this->data]);

	}

	public function toArray($notifiable){
       return [];

	}

}

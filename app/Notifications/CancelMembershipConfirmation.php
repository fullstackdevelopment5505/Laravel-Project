<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;

use Illuminate\Notifications\Notification;

use Illuminate\Contracts\Queue\ShouldQueue;

use Illuminate\Notifications\Messages\MailMessage;

use Illuminate\Notifications\resources\views;

use Illuminate\Support\ServiceProvider;

class CancelMembershipConfirmation extends Notification{

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
		$url = config('app.website_url').'authentication/login';
		return (new MailMessage)
		->greeting($this->data["greetings"])
		->subject($this->data["subject"])
		->line($this->data["line1"])
		->line($this->data["line2"])
		->action('Click here to login', config('app.website_url').'authentication/login')
		->salutation('The EQUITY FINDERS PRO TEAM')
		->markdown('mail.welcome.signup',['url' => $url,'data' => $this->data]);

	}

	public function toArray($notifiable){
       return [];

	}

}

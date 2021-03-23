<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;

use Illuminate\Notifications\Notification;

use Illuminate\Contracts\Queue\ShouldQueue;

use Illuminate\Notifications\Messages\MailMessage;

use Illuminate\Notifications\resources\views;

use Illuminate\Support\ServiceProvider;

class UserCreated extends Notification{

	use Queueable;

	protected $my_notification;

	public $data;


	public function __construct($data,$msg){

       $this->my_notification = $msg;
	   $this->data = $data;
	   $this->callbacks[] =( function ($message) {
			$message->getHeaders()->addTextHeader("Priority", "Urgent");
			$message->getHeaders()->addTextHeader("Importance", "high");
		});

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
		->greeting('Thank you for Registering for your FREE Account!')
		->subject('Equity Signup Confirmation')
		->line($this->my_notification)
		->line('Your login is your email address.')
		->line('Your temporary password is: '.$this->data["password"])
		->action('Click here to login', config('app.website_url').'authentication/login')
		->salutation('The EQUITY FINDERS PRO TEAM')
		->markdown('mail.welcome.signup',['url' => $url,'data' => $this->data]);

	}

	public function toArray($notifiable){
       return [];

	}

}

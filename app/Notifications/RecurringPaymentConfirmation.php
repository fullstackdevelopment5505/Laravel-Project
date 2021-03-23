<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;

use Illuminate\Notifications\Notification;

use Illuminate\Contracts\Queue\ShouldQueue;

use Illuminate\Notifications\Messages\MailMessage;

use Illuminate\Notifications\resources\views;

use Illuminate\Support\ServiceProvider;

class RecurringPaymentConfirmation extends Notification{

	use Queueable;

	protected $my_notification; 
   
	public $data;
 

	public function __construct($data,$msg,$email){

       $this->my_notification = $msg; 
	   $this->data = $data; 
		$this->email = $email;
	}

	public function via($notifiable){

       return ['mail'];

	}
	
	/* public function routeNotificationForMail($notification){
        // Return email address only...
        //return $this->email;

        // Return name and email address...
        return [$this->email => $this->data["email"]];
    } */
	
	public function toMail($notifiable){
		$notifiable->email = $this->email;
		return (new MailMessage)
		->cc('tiffany@briansoutlet.com')
		->greeting('Hello '.ucfirst($this->data["name"]).',')
		->subject('Equity recurring payment initiated confirmation.')
		->line($this->my_notification)
		->line('Your current plan details:')
		->salutation('Thank you for using '. config('app.website_url') )
		->markdown('mail.payment.recurringPaymentConfirmation',['data' => $this->data, ]);

	}

	public function toArray($notifiable){
       return [];

	}

}

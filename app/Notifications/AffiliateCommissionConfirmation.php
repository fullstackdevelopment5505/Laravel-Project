<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;

use Illuminate\Notifications\Notification;

use Illuminate\Contracts\Queue\ShouldQueue;

use Illuminate\Notifications\Messages\MailMessage;

use Illuminate\Notifications\resources\views;

use Illuminate\Support\ServiceProvider;

class AffiliateCommissionConfirmation extends Notification{

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
		
		return (new MailMessage)
		->greeting('Your affiliate commission has been initiated successfully!')
		->subject('Equity finders commission Confirmation.')
		->line($this->my_notification)
		->line('You have received $'.$this->data["amount"]." in your paypal account." )
		->salutation('The EQUITY FINDERS PRO TEAM')
		->markdown('mail.affiliate.affiliateCommission',['data' => $this->data]);

	}

	public function toArray($notifiable){
       return [];

	}

}

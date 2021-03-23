<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;

use Illuminate\Notifications\Notification;

use Illuminate\Contracts\Queue\ShouldQueue;

use Illuminate\Notifications\Messages\MailMessage;

use Illuminate\Notifications\resources\views;

use Illuminate\Support\ServiceProvider;

class ContactRequest extends Notification{

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
		->subject('New Contact Form Request')
		->line($this->my_notification)
		->salutation('Sales Enquiries')
		->markdown('mail.welcome.contactEmail',['data' => $this->data,'outroLines' => array('Interested in any of our products? Talk to our experts today') ]);

	}

	public function toArray($notifiable){
       return [];

	}

}

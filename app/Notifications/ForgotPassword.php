<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;

use Illuminate\Notifications\Notification;

use Illuminate\Contracts\Queue\ShouldQueue;

use Illuminate\Notifications\Messages\MailMessage;

use Illuminate\Notifications\resources\views;
use Illuminate\Support\ServiceProvider;

class ForgotPassword extends Notification
{

   use Queueable;

   protected $my_notification; 
   
	public $data;

   public function __construct($data,$msg)

   {

       $this->data = $data; 
       $this->my_notification = $msg; 

   }

   public function via($notifiable)

   {

       return ['mail'];

   }
	public function routeNotificationForMail($notification)
    {
        // Return email address only...
        //return $this->email;

        // Return name and email address...
        return [$this->email => $this->data["email"]];
    }
	public function toMail($notifiable)
	{
		return (new MailMessage)
		->greeting('Hello '.$this->data["fullname"].',')
		->subject($this->data["subject"])
		->line($this->my_notification)
		->action('Click here to reset your password',$this->data["url"])
		->salutation('Thank you for using '. config('app.website_url') )
		//->line('Regards, Team Equity')
		->markdown('mail.password.forgotpassword',['url' => $this->data["url"],'data' => $this->data]);

	}

   public function toArray($notifiable)

   {

       return [

           //

       ];

   }

}

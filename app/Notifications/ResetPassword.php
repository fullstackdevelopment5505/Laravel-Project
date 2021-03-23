<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;

use Illuminate\Notifications\Notification;

use Illuminate\Contracts\Queue\ShouldQueue;

use Illuminate\Notifications\Messages\MailMessage;

use Illuminate\Notifications\resources\views;
use Illuminate\Support\ServiceProvider;

class ResetPassword extends Notification
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
	   $url = config('app.website_url') . '/authentication/login';
	   
       return (new MailMessage)
		->greeting('Hello '.$this->data["fullname"].',')
		->subject('Equity Password Reset Confirmation')
		->line($this->my_notification)
		->line('New password: '.$this->data["new_password"])
		->action('Click here to login', config('app.website_url') . '/authentication/login')
		->salutation('Thank you for using '. config('app.website_url') )
		//->line('Regards, Team Equity')
		->markdown('mail.password.resetpassword',['url' => $url,'data' => $this->data]);

   }

   public function toArray($notifiable)

   {

       return [

           //

       ];

   }

}

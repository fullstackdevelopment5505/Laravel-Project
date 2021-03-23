<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\resources\views;
use Illuminate\Support\ServiceProvider;

class PropertyReminderNotification extends Notification
{
    use Queueable;
	protected $my_notification;
	public $data,$reminderData;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($data,$reminderData,$msg,$email){

        $this->my_notification = $msg;
        $this->data = $data;
        $this->reminderData = $reminderData;

    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    public function routeNotificationForMail($notification){
        // Return email address only...
        //return $this->email;

        // Return name and email address...
        return [$this->email => $this->data["email"]];
    }
    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable){
		$url = config('app.website_url').'authentication/login';
		return (new MailMessage)
		->greeting('Hello '.$this->data["name"].',')
		->subject('Property reminder alert!')
		->line($this->my_notification)
		->salutation('The EQUITY FINDERS PRO TEAM')
		->markdown('mail.reminderNotification',['url' => $url,'data' => $this->data,'reminderData' => $this->reminderData]);

	}

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}

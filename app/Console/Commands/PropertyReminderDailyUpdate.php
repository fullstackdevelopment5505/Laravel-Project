<?php

namespace App\Console\Commands;

use Illuminate\Support\Facades\Auth;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use App\User;
use App\Model\UserProperty;
use App\Model\PropertyReminder;
use App\Mail\MailNotify;
use App\Notifications\PropertyReminderNotification;


class PropertyReminderDailyUpdate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'daily:reminderUpdate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send reminder emails to users every morning';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $userData = User::with('details','property_reminders')->whereHas('property_reminders', function($q) {
             $q->where('status', 1); // in this scope, `$q` refers to the MediaProfile object, not the User.
        })->get();
       if(isset($userData)){
            //Here send the link with CURL with an external email API
            foreach($userData as $key => $data){
                $user = User::find($data->id);
                $email = $data->email;
                $email = 'creativemamta17@gmail.com';
                $html='';
                if($data->property_reminders){
                    $html ='<table>';
                    if($data->property_reminders){
                        $html .='<tr><th>Reminder</th><th>Time</th></tr>';
                        foreach ($data->property_reminders as $key => $value) {
                            $html .="<tr><td>".$value->start_date."</td><td>".$value->start_time."</td></tr>";
                        }
                    }
                    $html .='</table>';
                }
                $dataE = array(
                    'email' => 	$email,
                    'name'			=>  ucfirst($data->details->f_name),
                );
               // Mail::to('creativemamta17@gmail.comm')->send(new MailableClass('George','Kindly note that your email has been sent'));
               $user->notify(new PropertyReminderNotification($dataE, $data->property_reminders,'Please check reminders details.',$email));
            }


        }
    }
}

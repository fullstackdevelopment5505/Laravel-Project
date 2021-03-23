<?php
namespace App\Console\Commands;
use App\Model\Contact;
use Illuminate\Support\Facades\Mail;
use App\Mail\MailNotify;
use App\Notifications\ContactRequest;


use Illuminate\Console\Command;

class TestCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'send contact us email every minute';

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
       $contact_details = Contact::find(33);
		
		if(isset($contact_details)){
			
        //Here send the link with CURL with an external email API
			
			//$email = 'creativecruncy@gmail.com';
			$email = 'creativemamta17@gmail.com';
			$data = array(
				'contact_email' => 		$contact_details->email,
				'name'			=>  	ucfirst($contact_details->first_name.' '.$contact_details->last_name),
				'phone' 		=>  	$contact_details->phone,
				'description' 	=>  	$contact_details->description
			);
			
			 $contact_details->notify(new ContactRequest($data,'You received a message from : '.ucfirst($contact_details->first_name.' '.$contact_details->last_name),$email));
            
        }
    }
}

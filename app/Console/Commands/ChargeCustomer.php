<?php
namespace App\Console\Commands;
use App\User;
use Illuminate\Support\Facades\Mail;
use App\Mail\MailNotify;
use App\Notifications\ContactRequest;
use Cartalyst\Stripe\Stripe;
use App\UserSubscriptions;
use App\Model\Points;
use DB;
use Carbon\Carbon;
use Illuminate\Console\Command;

class ChargeCustomer extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'chargeCustomer:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'charge fixed amount from customer on 1st of month';

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

		/* $stripe 		= 	Stripe::make('sk_test_TW1zWKlwKJVMI0M6ToxVjfMP00iVpIB4Ka');//client

		$customers 		= 	$stripe->customers()->all();
		$email 			= 	array_column($customers['data'], 'email');

		$users 			= 	User::select('id')->whereIn('email',array_values($email))->get()->toArray();
		$ids 			= 	array_column($users, 'id');
		$active_sub 	= 	UserSubscriptions::select('stripe_customer_id','user_id')->whereIn('user_id',array_values($ids))->where('status','active')->get();
		$finalArray 	= 	array();
		$amount 		= 	0.50;
		$pointRate		=	DB::table('tbl_static')->select('point_per_dollar')->first();
		foreach($active_sub as $key => $val){

			$charge  = $stripe->charges()->create([
			  'amount' => $amount,
			  'currency' => 'usd',
			  'customer' => $val->stripe_customer_id,
			  'description' => 'Automatic credited in equity wallet each month',
			]);
			if($charge['status'] == 'succeeded')
			{

				array_push($finalArray, array('user_id'=>$val->user_id,'type'=>'1','point'=>$amount*$pointRate->point_per_dollar,'amount'=>$amount,'created_at'=>Carbon::now()));

			}


		}
		Points::insert($finalArray); */
    }
}

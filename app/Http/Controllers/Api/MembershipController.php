<?php
namespace App\Http\Controllers\Api;
use Anam\PhantomMagick\Converter;
use App\Http\Controllers\Api\MainController;
use Cartalyst\Stripe\Stripe;
use Illuminate\Contracts\Database\Eloquent\Castable;
use Illuminate\Support\Facades\Mail;
use App\Mail\MailNotify;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Validator, Response, DB;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Client;
use Carbon\Carbon;
use DataTables;
use App\ContactLog;
use App\Model\UserProperty;
use App\Model\ApiMode;
use App\Model\CancelMembershipRequest;
use App\UserSubscriptions;
use App\Notifications\CancelMembershipConfirmation;
use App\Notifications\RecurringPaymentConfirmation;
use App\Notifications\PostcardDesignConfirmation;
use App\User;

class MembershipController extends MainController
{
	private $stripe_key;

	public function __construct() 
	{
		$data = ApiMode::where('api_name','stripe')->first();
		$this->stripe_key = env('STRIPE_TEST_KEY');
		if( isset($data) && $data->mode == 1){
			$this->stripe_key = env('STRIPE_LIVE_KEY');
		} 
        
    }
	public function testEmail() 
	{
		$email = 'creativemamta17@gmail.com';
		$user = User::with('details')->where("email",$email)->first();
		
		$email = 'creativemamta17@gmail.com';
		
		
		//$user = User::with('details')->where("email",$email)->first();
		//$subdata  = UserSubscriptions::orderBy('id','desc')->where('email',$email)->first();
		$subdata=User::with('member','subscription','details')->where('email',$email)->first();
		
		
		$data = array(
						'contact_email' => 	$user->email,
						'name'			=>  'test',
						'start_date' 	=>  date('d-M-Y',strtotime($subdata->subscription->plan_period_start)),
						'end_date' 	    =>  date('d-M-Y',strtotime($subdata->subscription->plan_period_end)),
						'amount' 	    =>  $subdata->subscription->plan_amount,
					);
						
					/* $user->notify(new RecurringPaymentConfirmation($data,'Your payment for the equity membership has been successfully processed
					and your membership details has been modified.',$user->email)); */
	
        $notification_customer = 'Your membership is cancelled successfully!';
		
        if(isset($user)){
			
			
			
			$data = array(
				"greetings"      => 'Hello Mamta',
				"email"          => 'creativemamta17@gmail.com',
				"fullname"       => 'mamta',
				"subject" 		 => 'Membership cancel request confirmation',
				"line1" 		 => '',
				"line2" 		 => '',
				"cancel_subject" => 'subject',
				"comment" 		 =>'comment',
			);
			//return "ssdd".$user->notify(new CancelMembershipConfirmation($data,'testing send'));
			
			return "send";
        }
	}
	private function cancelConfirmationEmail($email,$requestArr)
    {
		
        //Retrieve the user from the database
		//echo "<pre>"; print_r($requestArr); die;
        $user = User::with('details')->where('email',$email)->first();
        $notification_customer = 'Your membership is cancelled successfully!';
        if(isset($user)){
			$comment   = $requestArr['comment'];
			$subject   = $requestArr['subject'];
			$reasonId   = $requestArr['reasonId'];
			$reasonText =  $requestArr['reasonText'] ? $requestArr['reasonText'] :$requestArr['otherText'] ;
			$name= ($user->details!="") ? ucfirst($user->details->f_name) : $user->email;
			$data = array(
				"greetings"      => 'Hello '.$name.',',
				"email"          => 'creativemamta17@gmail.com',
				"fullname"       => $name,
				"subject" 		 => 'Membership cancel request confirmation',
				"line1" 		 => '',
				"line2" 		 => '',
				"cancel_subject" => $subject,
				"comment" 		 => $comment,
			);
			return $user->notify(new CancelMembershipConfirmation($data,$notification_customer));
			
			//return "send";
        }
        return "error";
        
    }
	
	public function SaveCancelMembershipRequest(Request $request){
		
		$validator = Validator::make($request->all(),[
		'reasonId' => 'required'
		]);

		if ($validator->fails())
		{
			return $this->getResponse(422,$validator->errors()->first(),$validator->errors(),0);
		}  
		//print_r($request->get('reason')); die;
		if($request->get('cancel') == 0){
			$validator = Validator::make($request->all(),[
			'subject'  => 'required',
			'comment'  => 'required'
			]);

			if ($validator->fails())
			{
				return $this->getResponse(422,$validator->errors()->first(),$validator->errors(),0);
			}  
		}
		
		$reasonId   = $request->get('reasonId');
		$reasonText = $request->get('reasonText');
		$otherText  = $request->get('otherText');
		$reason_array = array('reason_id' => $reasonId , 'reason_text'=>$reasonText ,'other'=>$otherText);
		$last_data = CancelMembershipRequest::select('id')->orderBy('id','desc')->first();
		
		$last_id = 1;
		if(isset($last_data['id'])){
			
			$last_id = $last_data['id']+1;
		}
		$data=array(
			'user_id'=>Auth::id(),
			'reason'=>json_encode($reason_array),   
			'ticket_number'=>'#EFMEM'.$last_id,   
			'cancel'=>$request->get('cancel'),   
			'subject'=>$request->get('subject')? $request->get('subject') :'',  
			'message'=>$request->get('comment') ? $request->get('comment') : '',  
		);
		$user = User::find(Auth::id());
		
		$saved=CancelMembershipRequest::create($data);
		if($saved){
			if($request->get('cancel') == 0){
				
				$this->cancelConfirmationEmail($user->email,$request->all());
			}
			if($request->get('cancel') == 1){
				
				$cancelled = $this->CancelMembership();
				//$cancelled = true;
				if($cancelled){
					
					$this->cancelConfirmationEmail($user->email,$request->all());
					return $this->getResponse(200,'membership cancelled successfully',1);
					
				}else{
					return $this->getResponse(200,'Invalid request',0);	
				}
			}
			
			return $this->getResponse(200,'Your request is submitted successfully',[],1); 	
		}
		return $this->getResponse(422,'Something went wrong!',(Object)[],0); 
	}
	
	public function CancelMembership(){
	
		$currentUserId = Auth::id();
		
		$currentSubscription = UserSubscriptions::select('user_subscriptions.*')
		->join('tbl_membership','user_subscriptions.id','=','tbl_membership.subscriptions_id')->orderBy('user_subscriptions.id','desc')->where('user_subscriptions.user_id',$currentUserId)->first();
		
		/* echo "<pre>"; print_r($currentSubscription); die; */
		
		if(!empty($currentSubscription) &&  $currentSubscription->status == 'active'){
			$stripe = Stripe::make($this->stripe_key);
			$subscriptionCancl = $stripe->subscriptions()->cancel($currentSubscription->stripe_customer_id, $currentSubscription->stripe_subscription_id);
			$canceled_at = date("Y-m-d H:i:s", $subscriptionCancl["canceled_at"]);
			$ended_at = date("Y-m-d H:i:s", $subscriptionCancl["ended_at"]);
			$updated_sub = UserSubscriptions::where('id',$currentSubscription->id)->update(['canceled_at'=>$canceled_at,'ended_at'=>$ended_at,'status'=>$subscriptionCancl["status"]]);
			if($updated_sub){
				return true;
			}
		}
		return false;
	}
}

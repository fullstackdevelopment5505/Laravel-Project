<?php
/**
 * API Controller
 *
 * PHP version 7
 *
 * @category CustomerCardController
 * @package  API
 * @author   Equity <author@domain.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     http://localhost/
 */

namespace App\Http\Controllers\Api;

use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Http\Controllers\Api\MainController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Client;
use Validator, Response, DB, Config;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use App\Mail\MailNotify;
use App\User;
use App\Notifications\AffiliateWelcome;
use App\AffiliateCommission;
use App\Notifications\ResetPassword;
use App\Notifications\ForgotPassword;
use App\Model\PropertyResultId;
use App\Model\Detail;
use App\UserSubscriptions;
use App\Model\Member;
use Cartalyst\Stripe\Stripe;
use App\AffiliateWallet;
use App\AffiliateUsers;
use App\Model\Deposite;
use App\Model\Points;
use App\Model\ApiMode;

class CustomerCardController extends MainController
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
	
	public function walletRecharge(Request $request){
		
		$validator = Validator::make($request->all(), [
		'amount' 		=> 'required|numeric|min:50',
		]);
		
		if ($validator->fails())
		{
			return $this->getResponse(422,$validator->errors()->first(),$validator->errors(),0);
		} 
		
		$card_id = $request->get('card_id');
		$amount  = $request->get('amount');
		
		$user_id = Auth::id();
	
		$currentSubscription = UserSubscriptions::select('user_subscriptions.status','stripe_customer_id')
		->join('tbl_membership','user_subscriptions.id','=','tbl_membership.subscriptions_id')->orderBy('user_subscriptions.id','desc')->where('user_subscriptions.user_id',$user_id)->first();
		if(empty($currentSubscription)){
			
			return $this->getResponse(422,'Invalid request',0);
		}
		if(isset($currentSubscription->status) &&  $currentSubscription->status != 'active'){
			
			return $this->getResponse(422,'you do not have any active subscription',0);
		}
		
		try 
		{
			$customer_id = $currentSubscription->stripe_customer_id;
			$stripe_key = $this->stripe_key;
			$stripe = Stripe::make($stripe_key);//client	
			
			if($card_id !=""){
				try 
				{
					$charge = $stripe->charges()->create([
						'customer' => $customer_id,
						'currency' => 'USD',
						'amount'   => $amount,
						'source'   => $card_id
					]);
				}catch(\Cartalyst\Stripe\Exception\MissingParameterException $e) {
				  return ($this->getResponse(422,$e->getMessage(),(Object)[],0)); 
				}catch(\Cartalyst\Stripe\Exception\CardErrorException $e) {
				  return ($this->getResponse(422,$e->getMessage(),(Object)[],0)); 
				} catch(\Cartalyst\Stripe\Exception\NotFoundException $e) {
				  return ($this->getResponse(422,$e->getMessage(),(Object)[],0)); 
				} catch (\Cartalyst\Stripe\Exception\BadRequestException $e) {
				  return ($this->getResponse(422,$e->getMessage(),(Object)[],0)); 
				} catch (\Cartalyst\Stripe\Exception\UnauthorizedException $e) {
				  return ($this->getResponse(422,$e->getMessage(),(Object)[],0)); 
				}catch (\Cartalyst\Stripe\Exception\ServerErrorException $e) {
				  return ($this->getResponse(422,$e->getMessage(),(Object)[],0)); 
				}
			}
			else{
				try 
				{
					$charge = $stripe->charges()->create([
						'customer' => $customer_id,
						'currency' => 'USD',
						'amount'   => $amount,
					]);
					
				}catch(\Cartalyst\Stripe\Exception\MissingParameterException $e) {
				  return ($this->getResponse(422,$e->getMessage(),(Object)[],0)); 
				}catch(\Cartalyst\Stripe\Exception\CardErrorException $e) {
				  return ($this->getResponse(422,$e->getMessage(),(Object)[],0)); 
				}catch(\Cartalyst\Stripe\Exception\NotFoundException $e) {
				  return ($this->getResponse(422,$e->getMessage(),(Object)[],0)); 
				} catch (\Cartalyst\Stripe\Exception\BadRequestException $e) {
				  return ($this->getResponse(422,$e->getMessage(),(Object)[],0)); 
				} catch (\Cartalyst\Stripe\Exception\UnauthorizedException $e) {
				  return ($this->getResponse(422,$e->getMessage(),(Object)[],0)); 
				}catch (\Cartalyst\Stripe\Exception\ServerErrorException $e) {
				  return ($this->getResponse(422,$e->getMessage(),(Object)[],0)); 
				}
				
			}
			
			if($charge['status'] == 'succeeded') 
			{
			
				$data=array(
					'user_id'=>Auth::id(),
					'type'=>'4', 
					'charge_id'=>$charge['id'],
					'balance_transaction'=>$charge['balance_transaction'],
					'amount'=>$request->get('amount'),
					'currency'=>1,
					'last4'=>$charge['source']['last4'],
					'brand'=>$charge['source']['brand'],
					'receipt_url'=>$charge['receipt_url'],
					'json'=>json_encode($charge)
				);
				
				$trans=Deposite::create($data);

				if($trans->id <= 0){
					return $this->getResponse(500,'Something went wrong, Please try after some time.',(Object)[],0);
				}
				
				$pointRate=DB::table('tbl_static')->select('point_per_dollar')->first();	
					
				$points=array(
					'user_id'=>Auth::id(),
					'type'=>'1',
					'point'=>($pointRate->point_per_dollar*$request->get('amount')),
					'amount'=>$request->get('amount'),
					'trans_id'=>$trans->id,
					'transaction_detail'  => 'Wallet Recharge'
				);
				
				Points::create($points);
				
				//check if affiliate mapped to customer
				
				$user_data = User::find(Auth::id());
				
				if($user_data->mapped_to_affiliate != ''){
					$affiliate_id = $user_data->mapped_to_affiliate;
					
					//get affiliate commission rate
					$affdataExists = AffiliateUsers::find($affiliate_id);
					
					$affiliate_commission = '';
					$aff_wallet_data = [];
					
					if(!empty($affdataExists)){
						
						$comm_data = AffiliateCommission::where('affiliate_id', $affiliate_id)->first();
						
						if(!empty($comm_data)){
							$affiliate_commission =  $comm_data->commission;
							$commission_earned =($amount*$affiliate_commission)/100;
							$aff_wallet_data = array( 'affiliate_id' => $affiliate_id, 'amount'=> $commission_earned, 'deposit_id' =>$trans->id, 'transaction_type' => 'wallet recharge', 'type' => 'credit','user_id' => Auth::id() );
							
							AffiliateWallet::create($aff_wallet_data);
						}
						
					}
					
				}
				
				if($user_data->mapped_to_users != ''){
					$mapped_user_id = $user_data->mapped_to_users;
					
					//get affiliate commission rate
					$userExists = User::find($mapped_user_id);
					
					$user_commission = 10;
					
					if($userExists){
						$amount = $request->get('amount');
						$commission_earned =($amount*$user_commission)/100;
						$points=array(
							'user_id'=>$userExists->id,
							'type'=>'1',
							'point'=>($pointRate->point_per_dollar*$commission_earned),
							'amount'=>$commission_earned,
							'transaction_detail'=>'Customer referral commission',
						);
						Points::create($points);
					}
					
				}
				return $this->getResponse(200,'Money added successfully in wallet',(Object)array('amount'=>$amount),1); 
			}
		}catch (\Cartalyst\Stripe\Exception\UnauthorizedException $e) {
		  return ($this->getResponse(422,$e->getMessage(),(Object)[],0)); 
		}catch (\Cartalyst\Stripe\Exception\ServerErrorException $e) {
		  return ($this->getResponse(422,$e->getMessage(),(Object)[],0)); 
		}
	
	}
	public function getAllCards(){
		
		$user_id = Auth::id();
		
		$currentSubscription = UserSubscriptions::select('user_subscriptions.status','stripe_customer_id')
		->join('tbl_membership','user_subscriptions.id','=','tbl_membership.subscriptions_id')->orderBy('user_subscriptions.id','desc')->where('user_subscriptions.user_id',$user_id)->first();
		
		if(!empty($currentSubscription) &&  $currentSubscription->status == 'active'){
			
			$customer_id = $currentSubscription->stripe_customer_id;
			
			$stripe_key = $this->stripe_key;
			try 
			{
				$stripe = Stripe::make($stripe_key);//client	
				try 
				{
					$data = $stripe->cards()->all($customer_id);
					return $this->getResponse(200,'all cards', $data,1);
					
				}catch(\Cartalyst\Stripe\Exception\NotFoundException $e){
				  return ($this->getResponse(422,$e->getMessage(),(Object)[],0)); 
				}catch (\Cartalyst\Stripe\Exception\UnauthorizedException $e) {
				  return ($this->getResponse(422,$e->getMessage(),(Object)[],0)); 
				}catch (\Cartalyst\Stripe\Exception\ServerErrorException $e) {
				  return ($this->getResponse(422,$e->getMessage(),(Object)[],0)); 
				}
				
			}catch (\Cartalyst\Stripe\Exception\UnauthorizedException $e) {
			  return ($this->getResponse(422,$e->getMessage(),(Object)[],0)); 
			}catch (\Cartalyst\Stripe\Exception\ServerErrorException $e) {
			  return ($this->getResponse(422,$e->getMessage(),(Object)[],0)); 
			}
		}
		return $this->getResponse(422,'Invalid request',0);
		
	}
	
	public function createNewCard(Request $request){
		
		$validator = Validator::make($request->all(), [
		'card_no' 		=> 'required',
		'ccExpiryMonth' => 'required',
		'ccExpiryYear' 	=> 'required',
		'cvvNumber' 	=> 'required',
		]);
		
		if ($validator->fails())
		{
			return $this->getResponse(422,$validator->errors()->first(),$validator->errors(),0);
		} 
		
		$stripe_key = $this->stripe_key;
		$user_id = Auth::id();
		
		$currentSubscription = UserSubscriptions::select('user_subscriptions.status','stripe_customer_id')
		->join('tbl_membership','user_subscriptions.id','=','tbl_membership.subscriptions_id')->orderBy('user_subscriptions.id','desc')->where('user_subscriptions.user_id',$user_id)->first();
		
		if(empty($currentSubscription) &&  $currentSubscription->status != 'active'){
			
			return $this->getResponse(422,'Invalid request',0);
		}
		
		try 
		{
			$customer_id = $currentSubscription->stripe_customer_id;
			
			$stripe = Stripe::make($stripe_key);//client	
		
			try 
			{
				$token = $stripe->tokens()->create([
					'card' => [
						'name'      => $request->get('name'),
						'number'    => $request->get('card_no'),
						'exp_month' => $request->get('ccExpiryMonth'),
						'exp_year'  => $request->get('ccExpiryYear'),
						'cvc'       => $request->get('cvvNumber'),
					],
				]);
				try 
				{
					$card = $stripe->cards()->create($customer_id , $token['id']);
					return $this->getResponse(200,'card created successfully',(Object)array('card'=>$card),1);
					
				}catch(\Cartalyst\Stripe\Exception\NotFoundException $e) {
				  return ($this->getResponse(422,$e->getMessage(),(Object)[],0)); 
				} catch (\Cartalyst\Stripe\Exception\BadRequestException $e) {
				  return ($this->getResponse(422,$e->getMessage(),(Object)[],0)); 
				} catch (\Cartalyst\Stripe\Exception\UnauthorizedException $e) {
				  return ($this->getResponse(422,$e->getMessage(),(Object)[],0)); 
				}catch (\Cartalyst\Stripe\Exception\ServerErrorException $e) {
				  return ($this->getResponse(422,$e->getMessage(),(Object)[],0)); 
				}catch(\Cartalyst\Stripe\Exception\CardErrorException $e) {
				  return ($this->getResponse(422,$e->getMessage(),(Object)[],0)); 
				}
			} catch (\Cartalyst\Stripe\Exception\BadRequestException $e) {
			  return ($this->getResponse(422,$e->getMessage(),(Object)[],0)); 
			} catch (\Cartalyst\Stripe\Exception\UnauthorizedException $e) {
			  return ($this->getResponse(422,$e->getMessage(),(Object)[],0)); 
			}catch (\Cartalyst\Stripe\Exception\ServerErrorException $e) {
			  return ($this->getResponse(422,$e->getMessage(),(Object)[],0)); 
			}catch(\Cartalyst\Stripe\Exception\CardErrorException $e) {
			  return ($this->getResponse(422,$e->getMessage(),(Object)[],0)); 
			}
			
		}catch (\Cartalyst\Stripe\Exception\UnauthorizedException $e) {
		  return ($this->getResponse(422,$e->getMessage(),(Object)[],0)); 
		}catch (\Cartalyst\Stripe\Exception\ServerErrorException $e) {
		  return ($this->getResponse(422,$e->getMessage(),(Object)[],0)); 
		}
	}
	
	public function deleteCard(Request $request){
		
		$validator = Validator::make($request->all(), [
		'card_id' => 'required',
		]);
		
		if ($validator->fails())
		{
			return $this->getResponse(422,$validator->errors()->first(),$validator->errors(),0);
		} 
		
		$user_id = Auth::id();
		
		$currentSubscription = UserSubscriptions::select('user_subscriptions.status','stripe_customer_id')
		->join('tbl_membership','user_subscriptions.id','=','tbl_membership.subscriptions_id')->orderBy('user_subscriptions.id','desc')->where('user_subscriptions.user_id',$user_id)->first();
		
		if(empty($currentSubscription) &&  $currentSubscription->status != 'active'){
			
			return $this->getResponse(422,'Invalid request',0);
		}
		$stripe_key = $this->stripe_key;
		
		try 
		{
			$customer_id = $currentSubscription->stripe_customer_id;
			
			$stripe = Stripe::make($stripe_key);//client	
			try 
			{
				$card_id = $request->get('card_id');
				$deleted = $stripe->cards()->delete($customer_id, $card_id );
				return $this->getResponse(200,'Card deleted successfully',(Object)array('data'=>$deleted),1);
				
			}catch(\Cartalyst\Stripe\Exception\MissingParameterException $e) {
			  return ($this->getResponse(422,$e->getMessage(),(Object)[],0)); 
			}catch(\Cartalyst\Stripe\Exception\NotFoundException $e) {
			  return ($this->getResponse(422,$e->getMessage(),(Object)[],0)); 
			} catch (\Cartalyst\Stripe\Exception\BadRequestException $e) {
			  return ($this->getResponse(422,$e->getMessage(),(Object)[],0)); 
			} catch (\Cartalyst\Stripe\Exception\UnauthorizedException $e) {
			  return ($this->getResponse(422,$e->getMessage(),(Object)[],0)); 
			}catch (\Cartalyst\Stripe\Exception\ServerErrorException $e) {
			  return ($this->getResponse(422,$e->getMessage(),(Object)[],0)); 
			}catch(\Cartalyst\Stripe\Exception\CardErrorException $e) {
			  return ($this->getResponse(422,$e->getMessage(),(Object)[],0)); 
			}
		}catch (\Cartalyst\Stripe\Exception\UnauthorizedException $e) {
		  return ($this->getResponse(422,$e->getMessage(),(Object)[],0)); 
		}catch (\Cartalyst\Stripe\Exception\ServerErrorException $e) {
		  return ($this->getResponse(422,$e->getMessage(),(Object)[],0)); 
		}
	}
	public function setDefaultcard(Request $request){
		
		$validator = Validator::make($request->all(), [
		'card_id' => 'required',
		]);
		
		if ($validator->fails())
		{
			return $this->getResponse(422,$validator->errors()->first(),$validator->errors(),0);
		} 
		
		$user_id = Auth::id();
		
		$currentSubscription = UserSubscriptions::select('user_subscriptions.status','stripe_customer_id')
		->join('tbl_membership','user_subscriptions.id','=','tbl_membership.subscriptions_id')->orderBy('user_subscriptions.id','desc')->where('user_subscriptions.user_id',$user_id)->first();
		
		if(empty($currentSubscription) &&  $currentSubscription->status != 'active'){
			
			return $this->getResponse(422,'Invalid request',0);
		}
		$stripe_key = $this->stripe_key;
		try 
		{
			$customer_id = $currentSubscription->stripe_customer_id;
			
			$stripe = Stripe::make($stripe_key);//client	
			try 
			{
				$card_id = $request->get('card_id');
				
				$data = $stripe->customers()->update($customer_id, [
				'default_source' => $card_id,
				]);
				
				return $this->getResponse(200,'default card changed successfully',(Object)array('data'=>$data),1);
				
			}catch(\Cartalyst\Stripe\Exception\MissingParameterException $e) {
			  return ($this->getResponse(422,$e->getMessage(),(Object)[],0)); 
			}catch(\Cartalyst\Stripe\Exception\NotFoundException $e) {
			  return ($this->getResponse(422,$e->getMessage(),(Object)[],0)); 
			} catch (\Cartalyst\Stripe\Exception\BadRequestException $e) {
			  return ($this->getResponse(422,$e->getMessage(),(Object)[],0)); 
			} catch (\Cartalyst\Stripe\Exception\UnauthorizedException $e) {
			  return ($this->getResponse(422,$e->getMessage(),(Object)[],0)); 
			}catch (\Cartalyst\Stripe\Exception\ServerErrorException $e) {
			  return ($this->getResponse(422,$e->getMessage(),(Object)[],0)); 
			}catch(\Cartalyst\Stripe\Exception\CardErrorException $e) {
			  return ($this->getResponse(422,$e->getMessage(),(Object)[],0)); 
			}
		}catch (\Cartalyst\Stripe\Exception\UnauthorizedException $e) {
		  return ($this->getResponse(422,$e->getMessage(),(Object)[],0)); 
		}catch (\Cartalyst\Stripe\Exception\ServerErrorException $e) {
		  return ($this->getResponse(422,$e->getMessage(),(Object)[],0)); 
		}
	}
}

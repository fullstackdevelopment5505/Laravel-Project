<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\Api\MainController;
use App\Mail\MailNotify;
use Validator, Response, DB;
use Cartalyst\Stripe\Stripe;
use Illuminate\Support\Facades\Auth;
use App\Model\Deposite;
use App\Notifications\ContactRequest;
use App\Notifications\RecurringPaymentConfirmation;
use App\Model\Detail;
use App\Model\Points;
use App\Model\Membership;
use App\Model\Kickstarter;
use App\Model\Crm;
use App\Model\Cards;
use App\Model\Member;
use App\Configuration;
use App\Model\UserProperty;
use App\AffiliateWallet;
use App\User;
use App\AffiliateUsers;
use App\AffiliateCommission;
use App\UserSubscriptions;
use Carbon\Carbon;
use App\Model\ApiMode;

class PaymentController extends MainController
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

	public function recurringPaymentRecord(Request $request){
		$event_id =  $request->id;
		$response = $request->all();
		if($event_id !=""){
			switch($request->type) {
				case "customer.subscription.updated":
				$sub_id = $response["data"]["object"]["id"];
				$status = $response["data"]["object"]["status"];
				$plan_id = $response["data"]["object"]["plan"]["id"];
				$plan_amount = $response["data"]["object"]["plan"]["amount"];
				$plan_currency = $response["data"]["object"]["plan"]["currency"];
				$plan_interval = $response["data"]["object"]["plan"]["interval"];
				$plan_interval_count = $response["data"]["object"]["plan"]["interval_count"];
				$current_period_end = date("Y-m-d H:i:s", $response["data"]["object"]["current_period_end"]);
				$current_period_start = date("Y-m-d H:i:s", $response["data"]["object"]["current_period_start"]);
				$customer = $response["data"]["object"]["customer"];
				$subdata  = UserSubscriptions::select('user_id')->orderBy('id','desc')->where('stripe_customer_id',$customer)->first();
				if($subdata){
					$user_id = $subdata->user_id;
					$user = User::find($user_id);
					if($user){
						$dataSub = array(
							'user_id'=>$user->id,
							'stripe_subscription_id' => $sub_id,
							'stripe_customer_id'=> $customer,
							'stripe_plan_id'=> $plan_id,
							'plan_amount'=> ($plan_amount/100),
							'plan_amount_currency'=> $plan_currency,
							'plan_interval'=> $plan_interval,
							'plan_interval_count'=> $plan_interval_count,
							'payer_email'=> $user->email,
							'plan_period_start'=> $current_period_start,
							'plan_period_end'=> $current_period_end,
							'api_response'=> json_encode($response),
							'status'=> $status,
						);
						$subscriptioncreated = UserSubscriptions::create($dataSub);
						$data=array(
							'user_id'=>$user->id,
							'type' => '1',
							'charge_id'=>$sub_id,
							'amount'=>($plan_amount/100),
							'currency'=>$plan_currency,
							'json'=>json_encode($response)
						);

						$trans=Deposite::create($data);

						$count=Member::where('expire_at', '>=', date('Y-m-d').' 00:00:00')->where('user_id',$user->id)->count();

						$member=array(
							'user_id' 	=>	$user->id,
							'trans_id'	=> 	$trans->id,
							'expire_at'	=> 	$current_period_end,
							'subscriptions_id'	=> 	$subscriptioncreated->id
						);
						Member::create($member);

					}

					$userdetail = Detail::where('user_id',$user->id)->first();
					$email = $user->email;
					$data = array(
						'contact_email' => 	$user->email,
						'name'			=>  $userdetail->f_name,
						'start_date' 	=>  $current_period_start,
						'end_date' 	    =>  $current_period_end,
						'amount' 	    =>  '$'.$plan_amount/100,
					);

					$user->notify(new RecurringPaymentConfirmation($data,'Your payment for the equity membership has been successfully processed
					and your membership details has been modified.',$user->email));
					return $this->getResponse(200,'Success',1);
				}
				break;
			}
		}

        return $this->getResponse(200,'Saved Searches',$data);

	}

	public function depositeReport(Request $request)
	{
		//echo  $request->get('amount'); die;

		$validator = Validator::make($request->all(), [
		'card_no' 		=> 'required',
		'ccExpiryMonth' => 'required',
		'ccExpiryYear' 	=> 'required',
		'cvvNumber' 	=> 'required',
		'amount' 		=> 'required|numeric',
		]);

		if ($validator->fails())
		{
			return $this->getResponse(422,$validator->errors()->first(),$validator->errors(),0);
		}
		$total_properties 			= 	$request->get('recordCount');
		$stripe_amount 				= 	$request->get('amount');
		$current_wallet_amount 		= 	$request->get('currentBalance');
		$per_property_rate 			= 	$request->get('perReportRate');
		$total_purchase_amount		=	$total_properties*$per_property_rate;

		$remaining_wallet_amount 	=	$total_purchase_amount-$current_wallet_amount;

		$required_amount = $stripe_amount+$current_wallet_amount;

		if($required_amount < $total_purchase_amount){
			return $this->getResponse(422,'Insufficient Amount',0);
		}
		try
		{
			$stripe_key = $this->stripe_key;

			$stripe = Stripe::make($stripe_key);//client

			$token = $stripe->tokens()->create([
				'card' => [
					'number'    => $request->get('card_no'),
					'exp_month' => $request->get('ccExpiryMonth'),
					'exp_year'  => $request->get('ccExpiryYear'),
					'cvc'       => $request->get('cvvNumber'),
				],
			]);
			if (!isset($token['id'])) {
				return $this->getResponse(422,'The Stripe Token was not generated correctly',(Object)[],0);
			}
			$charge = $stripe->charges()->create([
				'card' => $token['id'],
				'currency' => 'USD',
				'amount'   => $request->get('amount'),
				'description' => 'Add in wallet',
			]);
				if($charge['status'] == 'succeeded')
				{

					if($current_wallet_amount > 0){

						$current_total_amount = $stripe_amount+$current_wallet_amount;

						$debited_amount_wallet	 = 	$current_wallet_amount;

						$credited_amount = 	$stripe_amount-$current_wallet_amount;

						$pointRate=DB::table('tbl_static')->select('point_per_dollar')->first();

						if($current_total_amount == $total_purchase_amount){
							$data=array(
								'user_id'=>Auth::id(),
								'type'=>2,
								'charge_id'=>$charge['id'],
								'balance_transaction'=>$charge['balance_transaction'],
								'amount'=>$stripe_amount,
								'currency'=>1,
								'last4'=>$charge['source']['last4'],
								'brand'=>$charge['source']['brand'],
								'receipt_url'=>$charge['receipt_url'],
								'json'=>json_encode($charge)
							);
							$trans=Deposite::create($data);
							$points=array(
								'user_id'=>Auth::id(),
								'type'=>'2',
								'point'=>($pointRate->point_per_dollar*$stripe_amount),
								'amount'=>$stripe_amount,
								'trans_id'=>$trans->id,
								'instant'=>1,
								'transaction_detail'  => 'Property Report'
							);
							Points::create($points);

							$points_d=array(
								'user_id'=>Auth::id(),
								'type'=>'2',
								'point'=>($pointRate->point_per_dollar*$debited_amount_wallet),
								'amount'=>$debited_amount_wallet,
								'transaction_detail'  => 'Property Report'
							);
							Points::create($points_d);

						}
						else if($current_total_amount > $total_purchase_amount)
						{

							$debited_from_stripe = $total_purchase_amount-$debited_amount_wallet;

							$credited_amount = $stripe_amount-$debited_from_stripe;

							$data=array(
								'user_id'=>Auth::id(),
								'type'=>2,
								'charge_id'=>$charge['id'],
								'balance_transaction'=>$charge['balance_transaction'],
								'amount'=>$stripe_amount,
								'currency'=>1,
								'last4'=>$charge['source']['last4'],
								'brand'=>$charge['source']['brand'],
								'receipt_url'=>$charge['receipt_url'],
								'json'=>json_encode($charge)
							);
							$trans=Deposite::create($data);

							$points=array(
								'user_id'=>Auth::id(),
								'type'=>'1',
								'point'=>($pointRate->point_per_dollar*$credited_amount),
								'amount'=>$credited_amount,
								'trans_id'=>$trans->id,
								'transaction_detail'  => 'Property Report'
							);
							Points::create($points);

							$points_stripe_debit=array(
								'user_id'=>Auth::id(),
								'type'=>'2',
								'point'=>($pointRate->point_per_dollar*$debited_from_stripe),
								'amount'=>$debited_from_stripe,
								'trans_id'=>$trans->id,
								'instant'=>1,
								'transaction_detail'  => 'Property Report'
							);
							Points::create($points_stripe_debit);

							$points_d=array(
								'user_id'=>Auth::id(),
								'type'=>'2',
								'point'=>($pointRate->point_per_dollar*$debited_amount_wallet),
								'amount'=>$debited_amount_wallet,
								'transaction_detail'  => 'Property Report'
							);
							Points::create($points_d);
						}

						else
						{
							$points=array(
								'user_id'=>Auth::id(),
								'type'=>'1',
								'point'=>($pointRate->point_per_dollar*$credited_amount),
								'amount'=>$credited_amount,
								'trans_id'=>$trans->id,
								'transaction_detail'  => 'Property Report'
							);
							Points::create($points);

						}
					}
					if($current_wallet_amount == 0){

						if($stripe_amount > $total_purchase_amount){

							$data=array(
								'user_id'=>Auth::id(),
								'type'=>2,
								'charge_id'=>$charge['id'],
								'balance_transaction'=>$charge['balance_transaction'],
								'amount'=>$stripe_amount,
								'currency'=>1,
								'last4'=>$charge['source']['last4'],
								'brand'=>$charge['source']['brand'],
								'receipt_url'=>$charge['receipt_url'],
								'json'=>json_encode($charge)
							);

							$trans=Deposite::create($data);

							$credited_amount = $stripe_amount-$total_purchase_amount;

							$pointRate=DB::table('tbl_static')->select('point_per_dollar')->first();
							$points=array(
								'user_id'=>Auth::id(),
								'type'=>'1',
								'point'=>($pointRate->point_per_dollar*$credited_amount),
								'amount'=>$credited_amount,
								'trans_id'=>$trans->id,
								'transaction_detail'  => 'Property Report'
							);
							Points::create($points);

							$points_d=array(
								'user_id'=>Auth::id(),
								'type'=>'2',
								'point'=>($pointRate->point_per_dollar*$total_purchase_amount),
								'amount'=>$total_purchase_amount,
								'trans_id'=>$trans->id,
								'instant'=>1,
								'transaction_detail'  => 'Property Report'
							);
							Points::create($points_d);

						}
						if($stripe_amount == $total_purchase_amount){

							$data=array(
								'user_id'=>Auth::id(),
								'type'=>2,
								'charge_id'=>$charge['id'],
								'balance_transaction'=>$charge['balance_transaction'],
								'amount'=>$stripe_amount,
								'currency'=>1,
								'last4'=>$charge['source']['last4'],
								'brand'=>$charge['source']['brand'],
								'receipt_url'=>$charge['receipt_url'],
								'json'=>json_encode($charge)
							);
							$trans=Deposite::create($data);

							$pointRate=DB::table('tbl_static')->select('point_per_dollar')->first();
							$points=array(
								'user_id'=>Auth::id(),
								'type'=>'2',
								'point'=>($pointRate->point_per_dollar*$stripe_amount),
								'amount'=>$stripe_amount,
								'trans_id'=>$trans->id,
								'instant'=>1,
								'transaction_detail'  => 'Property Report'
							);
							Points::create($points);
						}
					}
					$array=array(
						'balance_transaction'=>$charge['balance_transaction'],
						'amount'=>$charge['amount'],
						'stripe_amount'=>$request->get('amount'),
					);
				   return $this->getResponse(200,'Money added successfully in wallet',$array,1);

				} else {
					return $this->getResponse(200,'Money not added in wallet!!',(Object)[],0);
				}

		}
		catch (Exception $e)
		{
			return $this->getResponse(422,$e->getMessage(),(Object)[],0);

		} catch(\Cartalyst\Stripe\Exception\CardErrorException $e) {

			return $this->getResponse(422,$e->getMessage(),(Object)[],0);

		} catch(\Cartalyst\Stripe\Exception\MissingParameterException $e) {

			return $this->getResponse(422,$e->getMessage(),(Object)[],0);

		}
	}

	public function depositeProperty(Request $request)
	{
		//echo  $request->get('amount'); die;

		$validator = Validator::make($request->all(), [
		'card_no' 		=> 'required',
		'ccExpiryMonth' => 'required',
		'ccExpiryYear' 	=> 'required',
		'cvvNumber' 	=> 'required',
		'amount' 		=> 'required|numeric',
		]);

		if ($validator->fails())
		{
			return $this->getResponse(422,$validator->errors()->first(),$validator->errors(),0);
		}
		$total_properties 			= 	$request->get('recordCount');
		$stripe_amount 				= 	$request->get('amount');
		$current_wallet_amount 		= 	$request->get('currentBalance');
		$per_property_rate 			= 	$request->get('perPropertyRate');
		$purchase_amount		    =	$total_properties*$per_property_rate;
		$total_purchase_amount		=	round($purchase_amount,2);

		$remaining_wallet_amount 	=	$total_purchase_amount-$current_wallet_amount;

		$required_amount = $stripe_amount+$current_wallet_amount;

		if($required_amount < $total_purchase_amount){
			return $this->getResponse(422,'Insufficient Amount',0);
		}
		try
		{
			$stripe_key = $this->stripe_key;
			$stripe = Stripe::make($stripe_key);//client
			$token = $stripe->tokens()->create([
				'card' => [
					'number'    => $request->get('card_no'),
					'exp_month' => $request->get('ccExpiryMonth'),
					'exp_year'  => $request->get('ccExpiryYear'),
					'cvc'       => $request->get('cvvNumber'),
				],
			]);

			if (!isset($token['id'])) {
				return $this->getResponse(422,'The Stripe Token was not generated correctly',(Object)[],0);
			}

			$charge = $stripe->charges()->create([
				'card' => $token['id'],
				'currency' => 'USD',
				'amount'   => $request->get('amount'),
				'description' => 'Add in wallet',
			]);

			if($charge['status'] == 'succeeded')
			{
				if($current_wallet_amount > 0){

					$current_total_amount = $stripe_amount+$current_wallet_amount;

					$debited_amount_wallet	 = 	$current_wallet_amount;

					$credited_amount = 	$stripe_amount-$current_wallet_amount;

					$pointRate=DB::table('tbl_static')->select('point_per_dollar')->first();

					if($current_total_amount == $total_purchase_amount){
						$data=array(
							'user_id'=>Auth::id(),
							'type'=>3,
							'charge_id'=>$charge['id'],
							'balance_transaction'=>$charge['balance_transaction'],
							'amount'=>$stripe_amount,
							'currency'=>1,
							'last4'=>$charge['source']['last4'],
							'brand'=>$charge['source']['brand'],
							'receipt_url'=>$charge['receipt_url'],
							'json'=>json_encode($charge)
						);
						$trans=Deposite::create($data);
						$points=array(
							'user_id'=>Auth::id(),
							'type'=>'2',
							'point'=>($pointRate->point_per_dollar*$stripe_amount),
							'amount'=>$stripe_amount,
							'trans_id'=>$trans->id,
							'instant'=>1,
							'transaction_detail'  => 'Property Report'
						);
						Points::create($points);
						$points_d=array(
							'user_id'=>Auth::id(),
							'type'=>'2',
							'point'=>($pointRate->point_per_dollar*$debited_amount_wallet),
							'amount'=>$debited_amount_wallet,
							'transaction_detail'  => 'Property Report'
						);
						Points::create($points_d);

					}
					else if($current_total_amount > $total_purchase_amount)
					{

						$debited_from_stripe = $total_purchase_amount-$debited_amount_wallet;

						$credited_amount = $stripe_amount-$debited_from_stripe;

						$data=array(
							'user_id'=>Auth::id(),
							'type'=>3,
							'charge_id'=>$charge['id'],
							'balance_transaction'=>$charge['balance_transaction'],
							'amount'=>$stripe_amount,
							'currency'=>1,
							'last4'=>$charge['source']['last4'],
							'brand'=>$charge['source']['brand'],
							'receipt_url'=>$charge['receipt_url'],
							'json'=>json_encode($charge)
						);
						$trans=Deposite::create($data);

						$points=array(
							'user_id'=>Auth::id(),
							'type'=>'1',
							'point'=>($pointRate->point_per_dollar*$credited_amount),
							'amount'=>$credited_amount,
							'trans_id'=>$trans->id,
							'transaction_detail'  => 'Property Report'
						);
						Points::create($points);
						$points_stripe_debit=array(
							'user_id'=>Auth::id(),
							'type'=>'2',
							'point'=>($pointRate->point_per_dollar*$debited_from_stripe),
							'amount'=>$debited_from_stripe,
							'trans_id'=>$trans->id,
							'instant'=>1,
							'transaction_detail'  => 'Property Report'
						);
						Points::create($points_stripe_debit);
						$points_d=array(
							'user_id'=>Auth::id(),
							'type'=>'2',
							'point'=>($pointRate->point_per_dollar*$debited_amount_wallet),
							'amount'=>$debited_amount_wallet,
							'transaction_detail'  => 'Property Report'
						);
						Points::create($points_d);
					}

					else
					{
						$points=array(
							'user_id'=>Auth::id(),
							'type'=>'1',
							'point'=>($pointRate->point_per_dollar*$credited_amount),
							'amount'=>$credited_amount,
							'trans_id'=>$trans->id,
							'transaction_detail'  => 'Property Report'
						);
						Points::create($points);

					}
				}

				if($current_wallet_amount == 0){

					if($stripe_amount > $total_purchase_amount){


						$data=array(
							'user_id'=>Auth::id(),
							'type'=>3,
							'charge_id'=>$charge['id'],
							'balance_transaction'=>$charge['balance_transaction'],
							'amount'=>$stripe_amount,
							'currency'=>1,
							'last4'=>$charge['source']['last4'],
							'brand'=>$charge['source']['brand'],
							'receipt_url'=>$charge['receipt_url'],
							'json'=>json_encode($charge)
						);
						$trans=Deposite::create($data);

						$credited_amount = $stripe_amount-$total_purchase_amount;

						$pointRate=DB::table('tbl_static')->select('point_per_dollar')->first();
						$points=array(
							'user_id'=>Auth::id(),
							'type'=>'1',
							'point'=>($pointRate->point_per_dollar*$credited_amount),
							'amount'=>$credited_amount,
							'trans_id'=>$trans->id,
							'transaction_detail'  => 'Property Report'
						);
						Points::create($points);

						$points_d=array(
							'user_id'=>Auth::id(),
							'type'=>'2',
							'point'=>($pointRate->point_per_dollar*$total_purchase_amount),
							'amount'=>$total_purchase_amount,
							'trans_id'=>$trans->id,
							'instant'=>1,
							'transaction_detail'  => 'Property Report'
						);
						Points::create($points_d);

					}
					if($stripe_amount == $total_purchase_amount){

						$data=array(
							'user_id'=>Auth::id(),
							'type'=>3,
							'charge_id'=>$charge['id'],
							'balance_transaction'=>$charge['balance_transaction'],
							'amount'=>$stripe_amount,
							'currency'=>1,
							'last4'=>$charge['source']['last4'],
							'brand'=>$charge['source']['brand'],
							'receipt_url'=>$charge['receipt_url'],
							'json'=>json_encode($charge)
						);
						$trans=Deposite::create($data);

						$pointRate=DB::table('tbl_static')->select('point_per_dollar')->first();
						$points=array(
							'user_id'=>Auth::id(),
							'type'=>'2',
							'point'=>($pointRate->point_per_dollar*$stripe_amount),
							'amount'=>$stripe_amount,
							'trans_id'=>$trans->id,
							'instant'=>1,
							'transaction_detail'  => 'Property Report'
						);
						Points::create($points);
					}
				}
				$array=array(
					'balance_transaction'=>$charge['balance_transaction'],
					'amount'=>$charge['amount'],
				);
			   return $this->getResponse(200,'Money added successfully in wallet',$charge,1);

			} else {
				return $this->getResponse(200,'Money not added in wallet!!',(Object)[],0);
			}

		}
		catch (Exception $e)
		{
			return $this->getResponse(422,$e->getMessage(),(Object)[],0);

		} catch(\Cartalyst\Stripe\Exception\CardErrorException $e) {

			return $this->getResponse(422,$e->getMessage(),(Object)[],0);

		} catch(\Cartalyst\Stripe\Exception\MissingParameterException $e) {

			return $this->getResponse(422,$e->getMessage(),(Object)[],0);

		}
	}

	public function deposite(Request $request)
	{
		//echo  $request->get('amount'); die;
		$validator = Validator::make($request->all(), [
		'card_no' 		=> 'required',
		'ccExpiryMonth' => 'required',
		'ccExpiryYear' 	=> 'required',
		'cvvNumber' 	=> 'required',
		'amount' 		=> 'required|numeric',
		]);

		if ($validator->fails())
		{
			return $this->getResponse(422,$validator->errors()->first(),$validator->errors(),0);
		}

		try
		{
			$stripe_key = $this->stripe_key;
			$stripe = Stripe::make($stripe_key);//client
			$token = $stripe->tokens()->create([
				'card' => [
				'number'    => $request->get('card_no'),
				'exp_month' => $request->get('ccExpiryMonth'),
				'exp_year'  => $request->get('ccExpiryYear'),
				'cvc'       => $request->get('cvvNumber'),
				],
			]);
			if (!isset($token['id'])) {
				return $this->getResponse(422,'The Stripe Token was not generated correctly',(Object)[],0);
			}

			$charge = $stripe->charges()->create([
				'card' => $token['id'],
				'currency' => 'USD',
				'amount'   => $request->get('amount'),
				'description' => 'Add in wallet',
			]);

			if($charge['status'] == 'succeeded')
			{
				$amount_deposited = $request->get('amount');

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
					'transaction_detail'  => 'Membership'
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
							$commission_earned =($amount_deposited*$affiliate_commission)/100;
							$aff_wallet_data = array( 'affiliate_id' => $affiliate_id, 'amount'=> $commission_earned, 'deposit_id' =>$trans->id, 'transaction_type' => 'wallet recharge', 'type' => 'credit','user_id' => Auth::id() );

							AffiliateWallet::create($aff_wallet_data);
						}

					}

				}

				$array=array(
					'balance_transaction'=>$charge['balance_transaction'],
					'amount'=>$charge['amount'],
				);
			   return $this->getResponse(200,'Money added successfully in wallet',$charge,1);

			} else {
				return $this->getResponse(200,'Money not added in wallet!!',(Object)[],0);
			}

		}
		catch (Exception $e)
		{
			return $this->getResponse(422,$e->getMessage(),(Object)[],0);

		} catch(\Cartalyst\Stripe\Exception\CardErrorException $e) {

			return $this->getResponse(422,$e->getMessage(),(Object)[],0);

		} catch(\Cartalyst\Stripe\Exception\MissingParameterException $e) {

			return $this->getResponse(422,$e->getMessage(),(Object)[],0);

		}
	}
	function date_compare($a, $b)
	{
		$t1 = strtotime($a['date']);
		$t2 = strtotime($b['date']);
		return $t2 - $t1;
	}

	public function wallet()
	{
		/* removed points system and added funds in dollars in amount column --points_transaction */

		$pointRate=DB::table('tbl_static')->select('point_per_dollar')->first();

		$pointsRateDollar = $pointRate->point_per_dollar;

		$deposite=Deposite::select( 'amount','created_at')->where('user_id',Auth::id())->orderBy('id','desc')->limit(5)->get()->toArray();

		$depositeAmount=Deposite::where('user_id',Auth::id())->groupBy('user_id')->orderBy('id','desc')->sum('amount');

		//$points=Points::select('*',DB::raw('cast((point)/'.$pointsRateDollar.' AS UNSIGNED) as point'),DB::raw("DATE_FORMAT(created_at, '%d-%b-%Y %H:%i:%s') as date"))->orderBy('created_at','desc')->where('user_id',Auth::id())->get();


		$points=Points::select('*','amount as point',DB::raw("DATE_FORMAT(created_at, '%d-%b-%Y %H:%i:%s') as date"))->orderBy('created_at','desc')->where('user_id',Auth::id())->get();


		/* $deposite=Deposite::select('amount as point',DB::raw('(CASE WHEN type > 0 THEN  "2" ELSE "2" END) as type'),DB::raw("DATE_FORMAT(created_at, '%d-%b-%Y %H:%i:%s') as date"))->orderBy('created_at','desc')->whereNotIN('type',['1','4'])->where('user_id',Auth::id())->get()->toArray();

		$pointsArr = $points=Points::select('type','amount as point',DB::raw("DATE_FORMAT(created_at, '%d-%b-%Y %H:%i:%s') as date"))->orderBy('created_at','desc')->where('user_id',Auth::id())->get()->toArray();

		$points = array_merge($deposite, $pointsArr);
		usort($points, array($this, "date_compare")); */


		//$credit=Points::where('user_id',Auth::id())->where('type','1')->groupBy('user_id')->orderBy('id','desc')->sum('point');
		$credit = Points::where('user_id',Auth::id())->where('type','1')->groupBy('user_id')->orderBy('id','desc')->sum('amount');

		//$debit=Points::where('user_id',Auth::id())->where('type','2')->groupBy('user_id')->orderBy('id','desc')->sum('point');
		$debit=Points::where('user_id',Auth::id())->where('type','2')->where('instant',0)->groupBy('user_id')->orderBy('id','desc')->sum('amount');

		$purchase 	= 	Configuration::where('type','purchase_record_price')->first();
		$purchase_property_price = 	(isset($purchase->price) && $purchase->price!='')  ? $purchase->price : 0;

		$report 	= 	Configuration::where('type','property_report_price')->first();
		$download_report_price = 	isset($report->price) ? $report->price : '';

		$customPostcardData 	= 	Configuration::where('type','custom_postcard_price')->first();
		$custom_postcard_price = 	(isset($customPostcardData->price) && $customPostcardData->price!='')  ? $customPostcardData->price : '';
		//$current_points = $credit-$debit;
		$current_wallet_amount = $credit-$debit;

		//$current_points_dollar = $current_points/10;

		$result=(object)array(
			'total_deposite'=>$depositeAmount,
			'pointRate'=>$pointRate->point_per_dollar,
			'recent_deposite'=>$deposite,
			'points'=>$points,
			'perPropertyRate' => $purchase_property_price,
			'perReportRate' => $download_report_price,
			'custom_postcard_price' => $custom_postcard_price,
			'current_points'=>round($current_wallet_amount,2)
		);
		return $this->getResponse(200,'wallet',$result,1);
	}

	public function walletUpdate(Request $request)
	{
		$validator = Validator::make($request->all(), [
			'amount' 		=> 'required|numeric'
		]);

		if ($validator->fails())
		{
			return $this->getResponse(422,$validator->errors()->first(),$validator->errors(),0);
		}
		$transaction_detail = $request->get("transaction_detail");
		//$credit=Points::where('user_id',Auth::id())->where('type','1')->groupBy('user_id')->orderBy('id','desc')->sum('point');
		$credit=Points::where('user_id',Auth::id())->where('type','1')->groupBy('user_id')->orderBy('id','desc')->sum('amount');

		//$debit=Points::where('user_id',Auth::id())->where('type','2')->groupBy('user_id')->orderBy('id','desc')->sum('point');
		$debit=Points::where('user_id',Auth::id())->where('type','2')->where('instant',0)->groupBy('user_id')->orderBy('id','desc')->sum('amount');

		//$current_points = $credit-$debit;
		$wallet_amount = $credit-$debit;
		$current_wallet_amount = round($current_wallet_amount,2);

		if($current_wallet_amount >= $request->get("amount")){
			$pointRate=DB::table('tbl_static')->select('point_per_dollar')->first();
			$points=array(
				'user_id'=>Auth::id(),
				'transaction_detail'=>$request->get("transaction_detail"),
				'type'=>'2',
				'point'=>$request->get('amount')*$pointRate->point_per_dollar, //amount is in dollar so, convert in points.
				'amount'=>$request->get('amount'), //add amount in dollar
				'transaction_detail'  => 'Add Funds'
			);
			Points::create($points);

			return $this->getResponse(200,'Points debited successfully from wallet',$request->get('amount'),1);
		}
		return $this->getResponse(422,"Insufficient Balance",(Object)[],0);
	}


	public function search()
	{
		$data=UserProperty::select('SITUS_FULL_ADDRESS as address','user_property.created_at','user_property.status',DB::raw('"100" as amount'),'crm.property_id','user_property.id as prop_id')->join('crm','crm.id','=','user_property.property_id')->get();

  		$kick=Kickstarter::with('profile_image')->orderBy('id','desc')->limit(5)->get();

		return $this->getResponse(200,'Search',(object)array('kicks'=>$kick,'lists'=>$data),1);
	}


	public function paymentPage(Request $request)
	{

		$membership=DB::table('membership_master')->value('amount');
		$data=User::with('cards')->where('id',Auth::id())->first();
		return $this->getResponse(200,'Payment Page',(object)array('data'=>$data,'membership'=>$membership),1);

	}

	public function buyMembership(Request $request)
	{
		$validator = Validator::make($request->all(), [
		'card_no' 		=> 'required',
		'ccExpiryMonth' => 'required',
		'ccExpiryYear' 	=> 'required',
		'cvvNumber' 	=> 'required',
		'amount' 		=> 'required|numeric',
		'terms' 		=> 'accepted'
		]);
		if ($validator->fails())
		{
			return $this->getResponse(422,$validator->errors()->first(),$validator->errors(),0);
		}
		try
		{
			$stripe_key = $this->stripe_key;
			$stripe = Stripe::make($stripe_key);//client
			$token = $stripe->tokens()->create([
				'card' => [
					'number'    => $request->get('card_no'),
					'exp_month' => $request->get('ccExpiryMonth'),
					'exp_year'  => $request->get('ccExpiryYear'),
					'cvc'       => $request->get('cvvNumber'),
				],
			]);
			if (!isset($token['id'])) {
				return $this->getResponse(422,'The Stripe Token was not generated correctly',(Object)[],0);
			}
			$userData 		= 	User::find(Auth::id());
			$membershipPlan = 	Membership::first();

			//Create Customer:
			$customer 	= 	$stripe->customers()->create(array(
				'source'   => $token['id'],
				'email'    => $userData->email,
				/* 'metadata' => $metadata, */
			));
			 // Create a plan
			try {
				$plan = $stripe->plans()->create(array(
					"name" => $membershipPlan->type,
					"amount" => $request->get('amount'),
					"currency" => 'USD',
					"interval" => 'month',
					"interval_count" => 1
				));
			}catch(Exception $e) {
				$api_error = $e->getMessage();
			}
			if(empty($api_error) && $plan)
			{
				try {
				$subsData = $stripe->subscriptions()->create($customer['id'], [
					'plan' => $plan['id'],
				]);
				}catch(Exception $e) {
					$api_error = $e->getMessage();
				}

				if(empty($api_error) && $subsData){
					// Retrieve subscription data
					$subscrID = $subsData['id'];
					$custID = $subsData['customer'];
					$planID = $subsData['plan']['id'];
					$planAmount = ($subsData['plan']['amount']/100);
					$planCurrency = $subsData['plan']['currency'];
					$planinterval = $subsData['plan']['interval'];
					$planIntervalCount = $subsData['plan']['interval_count'];
					$created = date("Y-m-d H:i:s", $subsData['created']);
					$current_period_start = date("Y-m-d H:i:s", $subsData['current_period_start']);
					$current_period_end = date("Y-m-d H:i:s", $subsData['current_period_end']);
					$status = $subsData['status'];
					$dataSub = array(
						'user_id'=>Auth::id(),
						'stripe_subscription_id' => $subscrID,
						'stripe_customer_id'=> $custID,
						'stripe_plan_id'=> $planID,
						'plan_amount'=> $planAmount,
						'plan_amount_currency'=> $planCurrency,
						'plan_interval'=> $planinterval,
						'plan_interval_count'=> $planIntervalCount,
						'payer_email'=> $userData->email,
						'plan_period_start'=> $current_period_start,
						'plan_period_end'=> $current_period_end,
						'status'=> $subsData['status'],
					);
					$subscriptioncreated = UserSubscriptions::create($dataSub);
					$data=array(
						'user_id'=>Auth::id(),
						'type' => '1',
						'charge_id'=>$subscrID,
						'amount'=>$planAmount,
						'currency'=>$planCurrency,
						'json'=>json_encode($subsData)
					);
					$trans=Deposite::create($data);
					$count=Member::where('expire_at', '>=', date('Y-m-d').' 00:00:00')->where('user_id',Auth::id())->count();
					$ectraDay=0;
					if($count>0){
						$member=Member::where('expire_at', '>=', date('Y-m-d').' 00:00:00')->where('user_id',Auth::id())->orderBy('id','desc')->first();

						$diff = strtotime($member->expire_at) - strtotime(date("Y/m/d"));
						$ectraDay=abs(round($diff / 86400));
					}

					$member=array(
						'user_id' 	=>	Auth::id(),
						'trans_id'	=> 	$trans->id,
						'expire_at'	=> 	$current_period_end,
						'subscriptions_id'	=> 	$subscriptioncreated->id
					);
					Member::create($member);
					if($request->has('terms')){
						User::where('id', Auth::id())->update(array('accepted_terms' => '1','privacy_policy_updated'=>'1'));

					}
				}
				$charge=array(
					'balance_transaction'=>'',
					'amount'=>($subsData['plan']['amount']/100),
				);
			   return $this->getResponse(200,'Money add successfully in wallet',$charge,1);

			} else {
				return $this->getResponse(200,'Money not add in wallet!!',(Object)[],0);
			}
		}
		catch (Exception $e)
		{
			return $this->getResponse(422,$e->getMessage(),(Object)[],0);

		} catch(\Cartalyst\Stripe\Exception\CardErrorException $e) {

			return $this->getResponse(422,$e->getMessage(),(Object)[],0);

		} catch(\Cartalyst\Stripe\Exception\MissingParameterException $e) {

			return $this->getResponse(422,$e->getMessage(),(Object)[],0);

		}
	}
	public function membershipPage()
	{
		$data=User::with('member','subscription','details','Image')->where('id',Auth::id())->first();
		$extraDay=0;
		$membership=0;
		$progress=0;
		$amount=0;
		if($data->subscription!=null){
 			$diff = strtotime($data->subscription->plan_period_end) - strtotime(date("Y/m/d"));
 		   	$extraDay=abs(round($diff / 86400));
			$membership=1;

			$progDiff = strtotime($data->subscription->plan_period_end) - strtotime($data->subscription->created_at);
			$progExtraDay=abs(round($progDiff / 86400));

			$ReDiff = strtotime($data->subscription->created_at) - strtotime(date("Y/m/d"));
			$ReDay=abs(round($ReDiff / 86400));

			$progress=round(($ReDay*100)/$progExtraDay);
			$amount = $data->subscription->plan_amount;
		}
		$pointRate=DB::table('tbl_static')->value('point_per_dollar');
		return $this->getResponse(200,'Membership Page',(Object)array('data'=>$data,'day'=>$extraDay,'pointRate'=>$pointRate,'membership'=>$membership,'progress'=>$progress,'membership_amount'=>$amount),1);
	}

	public function deleteCard(Request $request)
	{
		$validator = Validator::make($request->all(), [
		'card_id' 		=> 'required',
		]);
		if ($validator->fails())
		{
			return $this->getResponse(422,$validator->errors()->first(),$validator->errors(),0);
		}

		Cards::where([['id',$request->get('card_id')],['user_id',Auth::id()]])->delete();

		$data=Cards::where('user_id',Auth::id())->get();

		return $this->getResponse(200,'Cards',$data,1);
	}
}

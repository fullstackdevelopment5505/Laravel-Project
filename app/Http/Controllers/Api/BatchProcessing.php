<?php

namespace App\Http\Controllers\Api;

use App\Email;
use App\Phone;
use App\Jobs\SendEmailRequest;
use App\Jobs\SendPhoneRequest;
use Anam\PhantomMagick\Converter;
use App\Http\Controllers\Api\MainController;
use Illuminate\Contracts\Database\Eloquent\Castable;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Mail\MailNotify;
use App\Notifications\ContactRequest;
use App\User;
use App\Model\DataTree;
use App\Model\UserProperty;
use Validator, Response, DB;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Client;
use Cartalyst\Stripe\Stripe;
use App\Model\PropertiesJob;
use App\Model\PropertyGroupName;
use App\Model\PropertyResultId;
use Carbon\Carbon;
use App\Model\Points;
use App\Configuration;
use DataTables;
use App\Model\ApiMode;

class BatchProcessing extends MainController
{
	private $datafinder_key,$datafinder_token,$accurate_append_key;

	public function __construct()
	{
		$data = ApiMode::where('api_name','datafinder')->first();
		$this->datafinder_key   = env('DATAFINDER_TEST_KEY');
		$this->datafinder_token = env('DATAFINDER_TEST_TOKEN');
		if( isset($data) && $data->mode == 1){
			$this->datafinder_key   = env('DATAFINDER_LIVE_KEY');
			$this->datafinder_token = env('DATAFINDER_LIVE_TOKEN');
		}
		$dataAp = ApiMode::where('api_name','accurate_append')->first();
        $this->accurate_append_key   = env('ACCURATE_APPEND_TEST_KEY');
		if( isset($dataAp) && $dataAp->mode == 1){
			$this->accurate_append_key   = env('ACCURATE_APPEND_LIVE_KEY');
		}
    }
	public function batchPayment(Request $request){

		$validator = Validator::make($request->all(), [
            'amount'   =>  'required|numeric'
        ]);
        if ($validator->fails())
        {
            return $this->getResponse(422,$validator->errors()->first(),$validator->errors(),0);
        }
		$credit=Points::where('user_id',Auth::id())->where('type','1')->groupBy('user_id')->orderBy('id','desc')->sum('amount');
		$debit=Points::where('user_id',Auth::id())->where('type','2')->where('instant',0)->groupBy('user_id')->orderBy('id','desc')->sum('amount');
		$current_wallet_amount = $credit-$debit;
		if($request->get("amount") > $current_wallet_amount){
			return $this->getResponse(422,"Insufficient Balance",(Object)[],0);
		}
		$pointRate=DB::table('tbl_static')->select('point_per_dollar')->first();
		$points=array(
			'user_id'=>Auth::id(),
			'type'=>'2',
			'point'=>$request->get('amount')*$pointRate->point_per_dollar, //amount is in dollar so, convert in points.
			'amount'=>$request->get('amount'), //add amount in dollar
			'transaction_detail'  => 'Batch Payment'
		);
		$pointQ = Points::create($points);
		return $this->getResponse(200,'Points debited successfully from wallet',$request->get('amount'),1);
    }
	public function batchPaymentDetails(Request $request){
		$validator = Validator::make($request->all(), [
            'property_id'    => 'required',
            'type'    => 'required',
        ]);
        if ($validator->fails())
        {
            return $this->getResponse(422,$validator->errors()->first(),$validator->errors(),0);
        }
		$credit = Points::where('user_id',Auth::id())->where('type','1')->groupBy('user_id')->orderBy('id','desc')->sum('amount');
		$debit=Points::where('user_id',Auth::id())->where('type','2')->where('instant',0)->groupBy('user_id')->orderBy('id','desc')->sum('amount');
		$current_wallet_amount = $credit-$debit;

		$request_type = $request->get( 'type' );

		$property_id_in_arrays = explode( ',' , $request->input( 'property_id' ) );

		$user_properties_count = DB::table('user_property')->where('user_id', Auth::id())->whereIN('id',$property_id_in_arrays)->count();

		if($user_properties_count == 0){

			return $this->getResponse(422,'Invalid property id',0);
		}
		$emails_amount=0;
		$phone_numbers_amount=0;
		$amount_debited_email = 0;
		$amount_debited_phone = 0;
		$total_prop = 0;
		$total_phone_numbers_to_search = 0;
		$total_emails_to_search = 0;
		if($request_type == 'both' || $request_type == 'phone'){
			$total_phone_numbers_to_search = DB::table('user_property')->where([['user_id', Auth::id()],['batch_search_phone_flag','0']])->whereIN('id',$property_id_in_arrays)->count();

			if($total_phone_numbers_to_search > 0){

				$total_prop = $total_prop+$total_phone_numbers_to_search;

				$phone_price_data 	= 	Configuration::where('type','phone_price')->first();
				$per_phone_price = 	(isset($phone_price_data->price) && $phone_price_data->price!='')  ? $phone_price_data->price : 0.5;

				$phone_numbers_amount = $total_phone_numbers_to_search*$per_phone_price;
				$amount_debited_phone = (80*$phone_numbers_amount)/100; //charge 80% of total amount from customer
			}
		}
		if($request_type == 'both' || $request_type == 'email'){

			$total_emails_to_search = DB::table('user_property')->where([['user_id', Auth::id()],['batch_search_email_flag','0']])->whereIN('id',$property_id_in_arrays)->count();

			if($total_emails_to_search > 0){

				$total_prop = $total_prop+$total_emails_to_search;

				$email_price_data 	= 	Configuration::where('type','email_price')->first();
				$per_email_price = 	(isset($email_price_data->price) && $email_price_data->price!='')  ? $email_price_data->price : 0.5;

				$emails_amount = $total_emails_to_search*$per_email_price;
				$amount_debited_email = (80*$emails_amount)/100; //charge 80% of total amount from customer
			}
		}
		if($request_type == 'both'){
			if($total_phone_numbers_to_search == 0 && $total_emails_to_search == 0){
				return $this->getResponse(422,'These properties are already processed for phone numbers and emails, please select other!',[],0);
			}
		}else if($request_type == 'email'){
			if($total_emails_to_search == 0){
				return $this->getResponse(422,'These properties are already processed for emails, please select other!',[],0);
			}

		}else if($request_type == 'phone'){
			if($total_phone_numbers_to_search == 0){
				return $this->getResponse(422,'These properties are already processed for phone numbers please select other!',[],0);
			}

		}else{}
		$total_amount = $emails_amount+$phone_numbers_amount;
		$total_debit_amount = $amount_debited_email+$amount_debited_phone;
		$email_message = '';
		if($user_properties_count != $total_emails_to_search){
			$already_searched_prope = $user_properties_count-$total_emails_to_search;
			$email_message = 'You already purchase '.$already_searched_prope.' out of '.$user_properties_count.' Email IDs and don’t have to pay for those again!';
		}
		$phone_message = '';
		if($user_properties_count != $total_phone_numbers_to_search){
			$already_searched_prope = $user_properties_count-$total_phone_numbers_to_search;
			$phone_message = 'You already purchase '.$already_searched_prope.' out of '.$user_properties_count.' Phone Numbers and don’t have to pay for those again!';
		}

		return $this->getResponse(200,"data",(Object)array('total_properties' =>$total_prop,'total_properties_post' =>$user_properties_count,
		'total_amount'=>round($total_debit_amount, 2),'full_amount'=>round($total_amount, 2),'total_emails_to_search' =>$total_emails_to_search,'total_phone_numbers_to_search'=>$total_phone_numbers_to_search,
		'current_wallet_amount' =>round($current_wallet_amount, 2),'phone_message'=>$phone_message,'email_message'=>$email_message ),1);
	}
	public function viewBatchProperties(Request $request)
    {
		$validator = Validator::make($request->all(), [
            'batch_id'        => 'required',
            'type'        	  => 'required',
        ]);
        if ($validator->fails())
        {
            return $this->getResponse(422,$validator->errors()->first(),$validator->errors(),0);
        }
		$batch_id = $request->get('batch_id');
		$type = $request->get('type');
		$batch_job = PropertiesJob::select('result_id','user_property_id',DB::raw('DATE_FORMAT(created_at, "%d-%b-%Y %H:%i:%s") as date'))
		->where([['batch_id',$batch_id],['user_id',Auth::id()]])->orderBy('id','desc')->get()->toArray();
		$date = $batch_job[0]['date'];
		$property_id_arr = array_column($batch_job, 'user_property_id');
		$result_id_arr = array_column($batch_job, 'result_id');
		$properties =UserProperty::with('logs')->join('datatree','datatree.id','=','user_property.property_id')
		->select('email','user_property.id','opportunity_status','user_property.email','user_property.phone','user_property.id as property_id',
		'user_property.status','datatree.*',DB::raw('(CASE WHEN LENGTH(SitusZipCode) = 4 THEN  CONCAT(\'0\',SitusZipCode) ELSE SitusZipCode END) as SitusZipCode'))
		->where([['user_property.user_id',Auth::id()],['user_property.trash','0']])
		->whereIn("user_property.id",array_values($property_id_arr))
		->get();

		return $this->getResponse(200,'Batch properties', (Object)array('total' => count($batch_job),'data' => $properties),1);
	}
	public static  function date_compare($a, $b)
    {
        $t1 = strtotime($a['started_at']);
        $t2 = strtotime($b['started_at']);
        return  $t2-$t1;
    }
	public function batchProgress()
    {
		$email_progress = PropertiesJob::select(DB::raw('(select purchase_group_name from property_result_id where property_result_id.result_id  =   properties_job.result_id  order by id desc limit 1) as purchase_group_name'),'result_id','user_id','started_at','type',DB::raw('round(count(id)*(100/batch_total)) as success_percentage'),
		'batch_total as total','status as batch_status','batch_id')
		->where([['type','email'],['user_id',Auth::id()]])->where('status','success')
		->groupBy('batch_id')->groupBy('type')->orderBy('started_at','desc')->get();

		$phone_progress = PropertiesJob::select(DB::raw('(select purchase_group_name from property_result_id where property_result_id.result_id  =   properties_job.result_id  order by id desc limit 1) as purchase_group_name'),'result_id','user_id','started_at','type',DB::raw('round(count(id)*(100/batch_total)) as success_percentage'),
		'batch_total as total','status','batch_id')
		->where('status','success')->where('type','phone')->where('user_id',Auth::id())
		->groupBy('batch_id')->groupBy('type')->orderBy('started_at','desc')->get();

		$phone_progress_failed = PropertiesJob::select('properties_job.result_id','started_at','properties_job.type',DB::raw('ROUND(count(properties_job.id)*(100/batch_total)) as failed_percentage'),'batch_total as total','status',
		 DB::raw('(select purchase_group_name from property_result_id where property_result_id.result_id  =   properties_job.result_id  order by id desc limit 1) as purchase_group_name'))
		->where([['status','failed'],['type','phone'],['properties_job.user_id',Auth::id()]])->groupBy('batch_id')->groupBy('type')->orderBy('started_at','desc')->get();

		$full_progress_detail = array_merge($email_progress->toArray(), $phone_progress->toArray());
		usort($full_progress_detail,array($this, "date_compare")); //sort userdefined array by date

		$credit = Points::where('user_id',Auth::id())->where('type','1')->groupBy('user_id')->orderBy('id','desc')->sum('amount');
		$debit=Points::where('user_id',Auth::id())->where('type','2')->where('instant',0)->groupBy('user_id')->orderBy('id','desc')->sum('amount');
		$current_wallet_amount = $credit-$debit;
		$current_wallet = number_format((float)$current_wallet_amount, 2, '.', '');

		return $this->getResponse(200,'Purchase Group ',(Object)array('full_progress_detail'=>$full_progress_detail,'current_wallet_amount'=>$current_wallet,'email_progress' => $email_progress,'phone_progress' => $phone_progress,'phone_progress_failed' => $phone_progress_failed));
	}

	public function massGetEmail( Request $request )
    {
		$validator = Validator::make($request->all(), [
            'property_id'    => 'required',
        ]);
        if ($validator->fails())
        {
            return $this->getResponse(422,$validator->errors()->first(),$validator->errors(),0);
        }
		$property_id_in_arrays = explode( ',' , $request->input( 'property_id' ) );

		$user_properties_count = DB::table('user_property')->where('user_id', Auth::id())->whereIN('id',$property_id_in_arrays)->count();

		if($user_properties_count == 0){

			return $this->getResponse(422,'Invalid property id',0);
		}

		$batch_total = count($property_id_in_arrays);
		$batch_id = Str::random(4);
		$result_id= 0;

		if($request->get( 'purchase_group_name' ) !=''){
			$purchase_group_name = $request->get( 'purchase_group_name' );
			$result_array = PropertyResultId::where('purchase_group_name','LIKE',$purchase_group_name)->where('user_id','=',Auth::id())->groupBy('result_id')->pluck('result_id');
			$result_id = $result_array[0];
		}
		$emails_prop_count = DB::table('user_property')->where([['user_id', Auth::id()],['batch_search_email_flag','0']])
		->whereIN('id',$property_id_in_arrays)->count();
		$user_find_emails = UserProperty::select(DB::raw('(CASE WHEN user_id <> "" THEN  "'.$result_id.'" ELSE "'.$result_id.'" END) as result_id'),
		DB::raw('(CASE WHEN user_id <> "" THEN  "'.Carbon::now().'" ELSE "'.Carbon::now().'" END) as created_at'),'id as user_property_id','property_id',
		'user_id',DB::raw('(CASE WHEN user_id <> "" THEN  "'.$batch_id.'" ELSE "'.$batch_id.'" END) as batch_id'),
		DB::raw('(CASE WHEN user_id <> "" THEN  "email" ELSE "email" END) as type'),DB::raw('(CASE WHEN user_id <> "" THEN  "pending" ELSE "pending" END) as status'),
		DB::raw('(CASE WHEN user_id <> "" THEN  "'.$emails_prop_count.'" ELSE "'.$emails_prop_count.'" END) as batch_total'),
		DB::raw('(CASE WHEN user_id <> "" THEN  "'.Carbon::now().'" ELSE "'.Carbon::now().'" END) as started_at'))
		->where([['user_id', Auth::id()],['batch_search_email_flag','0']])
		->whereIN('id',$property_id_in_arrays)->get()->toArray();

		if($emails_prop_count == 0){
			return $this->getResponse(422,'Already processed!',[],1);
		}

		if($emails_prop_count > 0){
			foreach (array_chunk($user_find_emails,10) as $t )
			{
				$jobsSaved= PropertiesJob::insert(array_values($t)); //save properties which are not exists in datatree
			}
			$queue_jobs_emails = PropertiesJob::where([['batch_id',$batch_id],['type','email'],['user_id',Auth::id()]])->get()->toArray();

			$total_queued_prop = $emails_prop_count; //total properties that are being processed

			$email_price_data 	= 	Configuration::where('type','email_price')->first();
			$per_email_price = 	(isset($email_price_data->price) && $email_price_data->price!='')  ? $email_price_data->price : 0.5;

			$emails_amount_total = $total_queued_prop*$per_email_price; //total amount per_property_price

			$email_amount_debited_80per = (80*$emails_amount_total)/100; //charge 80% of total amount from customer

			PropertiesJob::where([['batch_id',$batch_id],['type','email'],['user_id',Auth::id()]])
			->update(array('eighty_percent_payment_flag'=>'1','per_property_price'=>$per_email_price,'eighty_percent_amount'=>$email_amount_debited_80per));

			$search_methods = array('first', 'last', 'address', 'city', 'state', 'zip');
			foreach (array_chunk($queue_jobs_emails,10) as $t )
			{
				$email_value ='';
				$email_search_flag= 0;
				$i=1;
				foreach($t as $key => $data){
					$datetree_id = $data['property_id'];
					$tempUrl = $this->createBatchUrl($datetree_id, $search_methods, 'user_property', 'email');
					\Log::info('Datafinder get Email URL: '.$tempUrl.'-'.date('d-M-Y H:i:s').'-'.$datetree_id);
					\Log::info('Time: '.date('d-M-Y H:i:s'));
					$email = new Email;
					$email->result_id = $result_id;
					$email->email_value = $email_value;
					$email->email_search_flag = $email_search_flag;
					$email->url = $tempUrl;
					$email->row_num = $i;
					$email->datetree_id = $data['property_id'];
					$email->user_property_id = $data['user_property_id'];
					UserProperty::where([['id',$data['user_property_id']],['user_id', Auth::id()]])
					->update(array('job_status_email'=>'queue','datafinder_url'=>$tempUrl));
					PropertyResultId::where([['property_id',$datetree_id],['user_id', Auth::id()]])
					->update(['batch_process_email_status'=>'2']);
					$email->job_id = $data['id'];
					$email->save();
					$id = $i;
					$url = $tempUrl;
					$datetree_id = $data['property_id'];
					$user_property_id = $data['user_property_id'];
					$job_id = $data['id'];
					$email_search_flag = $email_search_flag;
					$email_value = $email_value;
					$result_id = $result_id;
					$client = new Client();
					try {
						$response = $client->request('GET', $tempUrl);
						\Log::info("response ".date('d-M-Y H:i:s'));
					}
					catch(RequestException $e) {
						// bird is clearly not the word
						\Log::info('Datfinder get email request exception: '.$e->getMessage());
						$this->failed($e);
						UserProperty::where([['user_id', Auth::id()]])->where('id',$user_property_id)->update(array('job_status_email'=>'success','batch_search_email_flag'=>'1'));
						PropertiesJob::where('id',$job_id)->update(array('status'=>'failed','progress'=>$id,'email_found'=>0,'completed_at'=>Carbon::now()));
						PropertyResultId::where([['property_id',$datetree_id],['user_id', Auth::id()]])
						->update(['batch_process_email_status'=>'3']);
					}
					try {
						$result = $response->getBody()->getContents();
					}
					catch(RequestException $e) {
						\Log::info('Datfinder get email exception: '.$e->getMessage());
						$this->failed($e);
						UserProperty::where([['user_id', Auth::id()]])->where('id',$user_property_id)
						->update(array('job_status_email'=>'success','batch_search_email_flag'=>'1'));

						PropertiesJob::where('id',$job_id)->update(array('status'=>'failed','progress'=>$id,'email_found'=>0,'completed_at'=>Carbon::now()));

						PropertyResultId::where([['property_id',$datetree_id],['user_id', Auth::id()]])
						->update(['batch_process_email_status'=>'3']);
					}
					// convert json string to arary
					$jsonString 	= json_decode($result, true); // decode the json string
					$result_array 	= $jsonString['datafinder'];
					$inputData 		= $result_array['input-query'];

					if (array_key_exists('results', $result_array)) { $resultData = $result_array['results'][0]; }
					if (!empty($resultData)) {
						if (array_key_exists('EmailAddr', $resultData)) {
							$email_value = $resultData['EmailAddr'];
							$EmailAddrUsable = isset($resultData['EmailAddrUsable']) ? $resultData['EmailAddrUsable']: null ;
							$urlSource = isset($resultData['urlSource']) ? $resultData['urlSource'] : null;
							$email_search_flag = 1;

							UserProperty::where([['user_id', Auth::id()]])->where('id',$user_property_id)
							->update(array('datafinder_json'=>$result,'email_address_usable' => $EmailAddrUsable,
							'url_source'=>$urlSource,'email' => $email_value,'email_search_flag'=>$email_search_flag,
							'job_status_email'=>'success','batch_search_email_flag'=>'1'));

							PropertiesJob::where('id',$job_id)->update(array('status'=>'success','progress'=>$id,'email_found'=>1,'completed_at'=>Carbon::now()));
							PropertyResultId::where([['property_id',$datetree_id],['user_id', Auth::id()]])->update(['batch_process_email_status'=>'3']);
						}
					}else{
						\Log::info("No email found.");
						UserProperty::where([['user_id', Auth::id()]])->where('id',$user_property_id)
						->update(array('job_status_email'=>'success','batch_search_email_flag'=>'1'));

						PropertiesJob::where('id',$job_id)->update(array('status'=>'success','progress'=>$id,'email_found'=>0,'completed_at'=>Carbon::now()));
						PropertyResultId::where([['property_id',$datetree_id],['user_id', Auth::id()]])->update(['batch_process_email_status'=>'3']);
					}
					$i++;
				}
			}
			$processed_jobs_email_found = PropertiesJob::where([['batch_id',$batch_id],['type','email'],['email_found',1],['user_id',Auth::id()]])->get(); //get properties with email value

			$total_email_found = $processed_jobs_email_found->count();

			$not_found_emails = $total_queued_prop-$total_email_found;

			$found_emails_amount = $total_email_found*$per_email_price;

			$prop_difference = $total_queued_prop-$total_email_found;

			$credit = Points::where('user_id',Auth::id())->where('type','1')->groupBy('user_id')->orderBy('id','desc')->sum('amount');
			$debit=Points::where('user_id',Auth::id())->where('type','2')->where('instant',0)->groupBy('user_id')->orderBy('id','desc')->sum('amount');
			$current_wallet_amount = $credit-$debit;
			$pointRate=DB::table('tbl_static')->select('point_per_dollar')->first();

			/* if we found 100% emails */
			if($not_found_emails == 0){
				$debited_amount = $found_emails_amount-$email_amount_debited_80per; //calculate remaining amount to be paid

				if($debited_amount > $current_wallet_amount){
					PropertiesJob::where([['batch_id',$batch_id],['type','email'],['user_id',Auth::id()]])
					->update(array('total_payment_flag'=>'0','total_amount'=>$debited_amount)); //set payment flag 0 with amount to pay
					return $this->getResponse(422,'Insufficient wallet balance.Please pay $'.$debited_amount,0);
				}

				/* debit from wallet */
				$points_data=array(
					'user_id'=>Auth::id(),
					'type'=>'2',
					'point'=>$debited_amount*$pointRate->point_per_dollar, //amount is in dollar so, convert in points.
					'amount'=>$debited_amount,
					'transaction_detail'  => 'Email Fetch'
				);
				$point_saved = Points::create($points_data);

				$amount_paid = $email_amount_debited_80per+$debited_amount; //total paid amount

				PropertiesJob::where([['batch_id',$batch_id],['type','email'],['user_id',Auth::id()]])
				->update(array('total_payment_flag'=>'1','total_amount'=>$amount_paid)); //set payment flag 1 with total paid amount

				return $this->getResponse(200,'processing!',(Object)array('total_properties_queue' =>$total_queued_prop,
				'total_properties_found' =>$total_email_found,'email_amount_debited_80per'=>$email_amount_debited_80per,
				'prop_difference' =>$prop_difference,'debited_amount' => $debited_amount ),1);
			}
			/* if found less properties */
			if($not_found_emails > 0 ){

				/* case 1 start */
				if($found_emails_amount > $email_amount_debited_80per){

					/* debit amount */
					$debit_amount = $found_emails_amount-$email_amount_debited_80per;
					/* bebit from wallet */
					$points_data=array(
						'user_id'=>Auth::id(),
						'type'=>'2',
						'point'=>$debit_amount*$pointRate->point_per_dollar, //amount is in dollar so, convert in points.
						'amount'=>$debit_amount,
						'transaction_detail'  => 'Email Fetch'
					);
					$point_saved = Points::create($points_data);

					PropertiesJob::where([['batch_id',$batch_id],['type','email'],['user_id',Auth::id()]])
					->update(array('total_payment_flag'=>'1','total_amount'=>$found_emails_amount)); //set payment flag 1 with total paid amount

					return $this->getResponse(200,'processing!',(Object)array('total_properties_queue' =>$total_queued_prop,
					'total_properties_found' =>$total_email_found,'email_amount_debited_80per'=>$email_amount_debited_80per,
					'prop_difference' =>$not_found_emails,'debited_amount' => $debit_amount ),1);
				}
				/* case 1 end */

				/* case 2 start */
				if($found_emails_amount < $email_amount_debited_80per){
					/* credit amount */
					$credit_amount = $email_amount_debited_80per-$found_emails_amount;
					if($credit_amount>0){
						$points_data=array(
							'user_id'=>Auth::id(),
							'type'=>'1',
							'point'=>$credit_amount*$pointRate->point_per_dollar, //amount is in dollar so, convert in points.
							'amount'=>$credit_amount,
							'transaction_detail'  => 'Email Fetch'
						);
						$point_saved = Points::create($points_data);
						PropertiesJob::where([['batch_id',$batch_id],['type','email'],['user_id',Auth::id()]])
						->update(array('total_payment_flag'=>'1','total_amount'=>$found_emails_amount)); //set payment flag with total paid amount
					}
				}
				/* case 2 end */
				return $this->getResponse(200,'processing!',(Object)array('total_properties_queue' =>$total_queued_prop,'total_properties_found' =>$total_email_found,'email_amount_debited_80per'=>$email_amount_debited_80per,'prop_difference' =>$prop_difference,'credited_amount' => $credited_amount ),1);
			}
		}
		return $this->getResponse(422,'These properties are already processed for emails, please select other!',[],0);
	}
	public function failed(RequestException $e)
    {

		 \Log::info($e);
    }
	public function massGetPhone( Request $request )
    {
		$validator = Validator::make($request->all(), [
            'property_id'    => 'required',
        ]);
        if ($validator->fails())
        {
            return $this->getResponse(422,$validator->errors()->first(),$validator->errors(),0);
        }
		$property_id_in_arrays = explode( ',' , $request->input( 'property_id' ) );

		$user_properties_count = DB::table('user_property')->where('user_id', Auth::id())->whereIN('id',$property_id_in_arrays)->count();

		if($user_properties_count == 0){

			return $this->getResponse(422,'Invalid property id',0);
		}

		$batch_total = count($property_id_in_arrays);

		$batch_id = Str::random(4);

		$result_id= 0;
		if($request->get( 'purchase_group_name' ) !=''){

			$purchase_group_name = $request->get( 'purchase_group_name' );
			$result_array = PropertyResultId::where('purchase_group_name','LIKE',$purchase_group_name)->where('user_id','=',Auth::id())->groupBy('result_id')->pluck('result_id');
			$result_id = $result_array[0];
		}

		$phone_prop_count = DB::table('user_property')->where([['user_id', Auth::id()],['batch_search_phone_flag','0']])->whereIN('id',$property_id_in_arrays)->count();

		$user_find_phone = UserProperty::select(DB::raw('(CASE WHEN user_id <> "" THEN  "'.$result_id.'" ELSE "'.$result_id.'" END) as result_id'),
		DB::raw('(CASE WHEN user_id <> "" THEN  "'.Carbon::now().'" ELSE "'.Carbon::now().'" END) as created_at'),
		'id as user_property_id','property_id','user_id',DB::raw('(CASE WHEN user_id <> "" THEN  "'.$batch_id.'" ELSE "'.$batch_id.'" END) as batch_id'),
		DB::raw('(CASE WHEN user_id <> "" THEN  "phone" ELSE "phone" END) as type'),DB::raw('(CASE WHEN user_id <> "" THEN  "pending" ELSE "pending" END) as status'),
		DB::raw('(CASE WHEN user_id <> "" THEN  "'.$phone_prop_count.'" ELSE "'.$phone_prop_count.'" END) as batch_total'),
		DB::raw('(CASE WHEN user_id <> "" THEN  "'.Carbon::now().'" ELSE "'.Carbon::now().'" END) as started_at'))
		->where([['user_id', Auth::id()],['batch_search_phone_flag','0']])
		->whereIN('id',$property_id_in_arrays)->get()->toArray();

		if($phone_prop_count == 0){

			return $this->getResponse(200,'Already processed!',[],1);
		}
		if($phone_prop_count > 0){


			foreach (array_chunk($user_find_phone,10) as $t )
			{
				$jobsSaved= PropertiesJob::insert($t); //save properties which are not exists in datatree
				/* foreach($t as $key => $data){
					UserProperty::where([['id',$data['user_property_id']],['user_id', Auth::id()]])->update(['job_status_phone'=>'queue']);
				} */
			}

			$queue_jobs_phone = PropertiesJob::where([['batch_id',$batch_id],['type','phone'],['user_id',Auth::id()]])->get()->toArray();

			$total_queued_prop 	= 	$phone_prop_count; //properties for phone in queue

			$phone_price_data 	= 	Configuration::where('type','phone_price')->first(); //per phone price

			$per_phone_price 	= 	(isset($phone_price_data->price) && $phone_price_data->price!='')  ? $phone_price_data->price : 0.5;

			$phone_amount_total = $total_queued_prop*$per_phone_price;

			$amount_debited_phone_80per = (80*$phone_amount_total)/100; //charge 80% of total amount from customer

			PropertiesJob::where([['batch_id',$batch_id],['type','phone'],['user_id',Auth::id()]])->update(array('eighty_percent_payment_flag'=>'1','per_property_price'=>$per_phone_price,'eighty_percent_amount'=>$amount_debited_phone_80per));

			$search_methods_phone = array('firstname', 'lastname', 'address', 'city', 'state', 'zip'); // search parameters

		//	UserProperty::whereIN('id',$property_id_in_arrays)->update(['job_status_phone'=>'queue']);

			foreach (array_chunk($queue_jobs_phone,10) as $t )
			{
				$fullNumber2 =0;
				$fullNumber =0;
				$lineType ='';
				$lineType2 ='';
				$phone_search_flag= 0;
				$i=1;
				//$jobsSaved= PropertiesJob::insert($t); //save properties which are not exists in datatree
				foreach($t as $key => $data){
					$datetree_id = $data['property_id'];
					$tempUrl = $this->createBatchAccurateAppendUrl($datetree_id, $search_methods_phone);

					$phone = new Phone;
					$phone->datetree_id = $datetree_id;
					$phone->result_id = $result_id;
					$phone->fullNumber = $fullNumber;
					$phone->fullNumber2 = $fullNumber2;
					$phone->lineType = $lineType;
					$phone->lineType2 = $lineType2;
					$phone->phone_search_flag = $phone_search_flag;
					$phone->url = $tempUrl;
					$phone->row_num = $i;
					$phone->user_property_id = $data['user_property_id'];
					$phone->job_id = $data['id'];
					$phone->save();
					UserProperty::where([['id',$data['user_property_id']],['user_id', Auth::id()]])->update(array('job_status_phone'=>'queue','accurate_append_url'=>$tempUrl));
					PropertyResultId::where([['property_id',$datetree_id],['user_id', Auth::id()]])
					->update(['batch_process_phone_status'=>'2']);
					$this->dispatchNow(new SendPhoneRequest($phone));
					//Address, city, state - or address, postal code
					$i++;
				}

			}

			$processed_jobs_phone = PropertiesJob::where([['batch_id',$batch_id],['type','phone'],['phone_found',1],['user_id',Auth::id()]])->get();

			$total_phone_found = $processed_jobs_phone->count();

			$prop_difference = $total_queued_prop-$total_phone_found;

			$credit = Points::where('user_id',Auth::id())->where('type','1')->groupBy('user_id')->orderBy('id','desc')->sum('amount');
			$debit=Points::where('user_id',Auth::id())->where('type','2')->where('instant',0)->groupBy('user_id')->orderBy('id','desc')->sum('amount');
			$current_wallet_amount = $credit-$debit;
			$pointRate=DB::table('tbl_static')->select('point_per_dollar')->first();

			/* if we found 100% emails */
			if($prop_difference == 0){

				$debited_amount = $phone_amount_total-$amount_debited_phone_80per; //calculate remaining amount to be paid

				if($debited_amount > $current_wallet_amount){

					PropertiesJob::where([['batch_id',$batch_id],['type','[phone'],['user_id',Auth::id()]])->update(array('total_payment_flag'=>'0','total_amount'=>$debited_amount)); //set payment flag 0 with amount to pay
					return $this->getResponse(422,'Insufficient wallet balance.Please pay $'.$debited_amount,0);
				}

				/* bebit from wallet */
				$points_data=array(
					'user_id'=>Auth::id(),
					'type'=>'2',
					'point'=>$debited_amount*$pointRate->point_per_dollar, //amount is in dollar so, convert in points.
					'amount'=>$debited_amount,
					'transaction_detail'  => 'Phone Fetch'
				);
				$point_saved = Points::create($points_data);

				if($point_saved->id !=''){
					$amount_paid = $amount_debited_phone_80per+$debited_amount; //total paid amount

					PropertiesJob::where([['batch_id',$batch_id],['type','phone'],['user_id',Auth::id()]])->update(array('total_payment_flag'=>'1','total_amount'=>$amount_paid)); //set payment flag 1 with total paid amount
				}
				return $this->getResponse(200,'processing!',(Object)array('total_properties_queue' =>$total_queued_prop,'total_properties_found' =>$total_phone_found,'amount_debited_phone_80per'=>$amount_debited_phone_80per,'prop_difference' =>$prop_difference,'debited_amount' => $amount_paid ),1);
            }
			/* if found less properties */
			if($prop_difference > 0 ){

				$prope_80perc = ($total_queued_prop*80)/100; //calculate 80% properties

				$extra_paid_prop = $prope_80perc-$total_phone_found; //get extra paid properties

				$credited_amount = $extra_paid_prop*$per_phone_price; //extra paid amount and that need to credit back to wallet

				//$emails_amount_diff = $total_queued_prop*$per_phone_price;

				$points_data=array(
					'user_id'=>Auth::id(),
					'type'=>'1',
					'point'=>$credited_amount*$pointRate->point_per_dollar, //amount is in dollar so, convert in points.
					'amount'=>$credited_amount,
					'transaction_detail'  => 'Phone Fetch'
				);
				$point_saved = Points::create($points_data);
				if($point_saved->id !=''){
					$amount_paid = $prope_80perc-$credited_amount;
					PropertiesJob::where([['batch_id',$batch_id],['type','phone'],['user_id',Auth::id()]])->update(array('total_payment_flag'=>'1','total_amount'=>$amount_paid)); //set payment flag with total paid amount
				}
			}
			return $this->getResponse(200,'processing!',(Object)array('total_properties_queue' =>$total_queued_prop,'total_properties_found' =>$total_phone_found,'amount_debited_phone_80per'=>$amount_debited_phone_80per,'prop_difference' =>$prop_difference,'credited_amount' => $credited_amount ),1);
		}
	}

	public function createBatchAccurateAppendUrl($datetree_id, $search_methods) {
        // api details
        $AccurateAppendUrl = 'https://api.accurateappend.com/Services/V2/AppendPhone/Residential/';
        $apiKey = $this->accurate_append_key;
       // $hf = new HelperFunctions();

        // example of search url
        // https://api.accurateappend.com/Services/V2/AppendPhone/Residential/e854dda0-f52f-4dff-b26c-9a1fb35dd1f0/?firstname=Evander&lastname=Mendonca&address=17040%2060th%20Lane%20N&city=Loxahatchee&state=FL

        // variables necessary for url creation
        $searchUrl = $AccurateAppendUrl . $apiKey . '/?';

		$datatree_data = DB::table('datatree')->select('SitusHouseNumber','SitusStreetName','SitusMode','Owner1FirstName as firstname','MailCity','MailState','MailZZIP9',
		'OwnerLastname1 as lastname','OwnerMailingName','SitusCity as city','SitusState as state','SitusZipCode as zip','SitusHouseNumber as address','MailingStreetAddress',
		'MailHouseNumber','MailHouseNumber2','MailStreetName','AlternateMailingCity')
		->where('id', '=', $datetree_id)->first();

		$address = $datatree_data->SitusHouseNumber." ".$datatree_data->SitusStreetName." ".$datatree_data->SitusMode." ".$datatree_data->city." ".$datatree_data->state." ".$datatree_data->zip;

		$datatree_data->address = $address;

	//	Error":"Address, city, state - or address, postal code is required

		if($datatree_data->firstname == ''){

			$datatree_data->firstname = $datatree_data->OwnerMailingName;
		}

		if($datatree_data->lastname == ''){

			$datatree_data->lastname = $datatree_data->OwnerMailingName;
		}

		if($datatree_data->city == '' && $datatree_data->state == '' &&  $datatree_data->address == ''){

			$datatree_data->city = $datatree_data->MailCity;
			$datatree_data->state = $datatree_data->MailState;
			$datatree_data->address = $datatree_data->MailHouseNumber." ".$datatree_data->MailStreetName." ".$datatree_data->MailCity." ".$datatree_data->MailState." ".$datatree_data->MailZZIP9;
		}

		if($datatree_data->zip == '' && $datatree_data->address == ''){

			$datatree_data->zip = $datatree_data->MailZZIP9;
			$datatree_data->address = $datatree_data->MailHouseNumber." ".$datatree_data->MailStreetName." ".$datatree_data->MailCity." ".$datatree_data->MailState." ".$datatree_data->MailZZIP9;
		}

		 // create the url to call
        for ($i = 0; $i < count($search_methods); $i++) {
            if ($search_methods[$i] === 'firstname' || $search_methods[$i] === 'lastname' || $search_methods[$i] === 'city' || $search_methods[$i] === 'state' || $search_methods[$i] === 'zip' || $search_methods[$i] === 'address') {

               // $input = $hf->requestSql($table_name, $search_methods[$i], $id);
                $tempSearchVar = $search_methods[$i]; // remove either 1 or 2 from end of string
                $searchUrl .= '&' . $tempSearchVar . '=' . rawurlencode($datatree_data->$tempSearchVar);
            }
        }

        // fill in blank spaces with %20
        $searchUrl = str_replace(' ', '%20', $searchUrl);

        // return the url
        return $searchUrl;
    }
	public function getBatchProspectsEmail( Request $request )
    {
		$validator = Validator::make($request->all(), [
            'property_id'    => 'required',
        ]);
        if ($validator->fails())
        {
            return $this->getResponse(422,$validator->errors()->first(),$validator->errors(),0);
        }
		// declare variables
        $search_methods = array('first', 'last', 'address', 'city', 'state', 'zip'); // search parameters

		$table_name = 'datatree';

		$property_id_in_arrays = explode( ',' , $request->input( 'property_id' ) );
		$numRows = count($property_id_in_arrays);
		/**
         *
         *
         * EMAIL SEARCH
         *
         *
        */
		$api_response_arr = [];

			/*$data = DB::table('user_property')->select('email_search_flag','property_id')->where('user_id', Auth::id())->whereIN('id',$property_id_in_arrays);

			$query = str_replace(array('?'), array('\'%s\''), $data->toSql());
            $queryss = vsprintf($query, $data->getBindings());
            dump($queryss); */

		$user_properties = DB::table('user_property')->select('email_search_flag','status','property_id','id')->where('user_id', Auth::id())->whereIN('id',$property_id_in_arrays)->get();

		$user_properties_count = DB::table('user_property')->select('email_search_flag','status','property_id','id')->where('user_id', Auth::id())->whereIN('id',$property_id_in_arrays)->count();

		if($user_properties_count == 0){

			return $this->getResponse(422,'Invalid property id',0);
		}
        // build urls and dispatch jobs
		$resultData= [];
		$update_arr = [];
		$email = '';
		$email_search_flag= 0;

		foreach($user_properties as $key => $data_prop){
			$flag_check 	= 	$data_prop->email_search_flag;
            $datetree_id 	= 	$data_prop->property_id;
            $status 		= 	$data_prop->status;
			if ($flag_check == 0) {
                $tempUrl = $this->createUrl($datetree_id, $search_methods, 'user_property', 'email');

                /* echo $tempUrl;

				echo "<br />"; */
				$client = new Client();
				$response = $client->request('GET', $tempUrl);
				$result = $response->getBody()->getContents();

				// convert json string to arary
				$jsonString 	= json_decode($result, true); // decode the json string
				$result_array 	= $jsonString['datafinder'];
				$inputData 		= $result_array['input-query'];
				if (array_key_exists('results', $result_array)) { $resultData = $result_array['results'][0]; }
				if (!empty($resultData)) {
					if (array_key_exists('EmailAddr', $resultData)) {
						$email = $resultData['EmailAddr'];
						$email_search_flag = 1;
						if($status ==0){

							$status = '1';
						}

					}
				}
				UserProperty::where([['user_id', Auth::id()],['id',$data_prop->id]])->update(array('email' => $email,'email_search_flag'=>$email_search_flag));

            }
		}
		$user_properties_new = DB::table('user_property')->select('email','email_search_flag','id')->where('user_id', Auth::id())->whereIN('id',$property_id_in_arrays)->get();

		if($user_properties_new->count() > 0){

			return $this->getResponse(200,'Email Data',$user_properties_new,1);

		}


		return $this->getResponse(422,'Something went wrong!',0);

	}

	// createUrl function
    // creates urls based on parameters passed
    public function createBatchUrl($datetree_id, $search_methods, $table_name, $service ) {
        // api details
        $k2 =$this->datafinder_key;
        $DataFinderUrl = "https://api.datafinder.com/qdf.php?service=" . $service . "&k2=";
        $Token = $this->datafinder_token;

        // examples of how url should look
        // $searchUrl = $DataFinderUrl . $k2 . '&d_' . $search_methods[0] . '=' . $input1 . '&d_' . $search_methods[1] . '=' . $input2 . '&d_' . $search_methods[2] . '=' . $input3;
        // $searchUrl = $DataFinderUrl . $k2 . '&d_address=' . $address . '&d_city=' . $city . "&d_state=" . $state;

        // variables necessary for url creation
        $searchUrl = $DataFinderUrl . $k2;
		$datatree_data = DB::table('datatree')->select('SitusHouseNumber','SitusStreetName','SitusMode','Owner1FirstName as first','OwnerLastname1 as last','SitusCity as city','SitusState as state','SitusZipCode as zip','SitusHouseNumber as address')->where('id', '=', $datetree_id)->first();
		$datatree_data->address  = $datatree_data->SitusHouseNumber." ".$datatree_data->SitusStreetName." ".$datatree_data->SitusMode." ".$datatree_data->city." ".$datatree_data->state." ".$datatree_data->zip;
        // create the url to call
        for ($i = 0; $i < count($search_methods); $i++) {
            if ($search_methods[$i] === 'first' || $search_methods[$i] === 'last' || $search_methods[$i] === 'city' || $search_methods[$i] === 'state' || $search_methods[$i] === 'zip' || $search_methods[$i] === 'address') {

               // $input = $hf->requestSql($table_name, $search_methods[$i], $id);
                $tempSearchVar = $search_methods[$i]; // remove either 1 or 2 from end of string
                $searchUrl .= '&d_' . $tempSearchVar . '=' . rawurlencode($datatree_data->$tempSearchVar);
            }
        }

        // fill in blank spaces with %20
        $searchUrl = str_replace(' ', '%20', $searchUrl);

        // return the url
        return $searchUrl;
    }

}

<?php

namespace App\Http\Controllers\SuperadminDashboard;
 
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str; 
use App\Model\Member;
use App\Model\DataTree;
use App\Model\UserProperty;
use App\user;
use App\Configuration;
use App\Model\Detail;
use App\Model\Membership;
use App\Model\DataTreeItem;
use App\Model\ApiMode;
use Validator, Response, DB, Session;
use DataTables;
use Carbon\Carbon;
use App\Model\Packages;
use App\Model\PackageFeatures;
use App\Model\PackageFeaturesMapping;

class ConfigurationController extends Controller
{
	public function ajaxHandlingConfig(Request $request)
    {
  
        if ($request->get("type") == "change_mode") {
			if($request->get("api_type") !="" && $request->get("api_mode") !=''){
				$type = $request->get("api_type");
				$mode = $request->get("api_mode");
				$enabled_mode = $request->get("enabled_mode");
				$arr=array(
					'api_name'=>$type
				);
				$data=array(
					'enabled_mode'=>$enabled_mode,
					'mode'=>$mode,
				);
				$api_mode_q = ApiMode::updateOrCreate($arr,$data);
				if ($api_mode_q) {
					$html     = '';
					$title    = '';
					$model_id = '';
					if($type=='sendgrid'){
						if($mode == '0'){
							$sendgrid_key = env('SENDGRID_TEST_API_KEY');
							$title = 'Sendgrid Test Account';
						} 
						if($mode == '1'){
							$sendgrid_key = env('SENDGRID_LIVE_API_KEY');
							$title = 'Sendgrid Live Account';
						} 
						$html = "<div class='user_finder bg-light p-3 border border-secondary'>
								<h6>Key </h6>
								<p>".$sendgrid_key."</p>
								</div>";
					}
					if($type=='twilio'){
						$model_id = '#show_api_twilio';
						if($mode == '0'){
							$twilio_sid   = env('TWILIO_SID_TEST');
							$twilio_token = env('TWILIO_TOKEN_TEST');
							$title = 'Thanks.io Test Account';
						} 
						if($mode == '1'){
							$twilio_sid   = env('TWILIO_SID_LIVE');
							$twilio_token = env('TWILIO_TOKEN_LIVE');
							$title = 'Thanks.io Live Account';
						} 
						$html = "<div class='user_finder bg-light p-3 border border-secondary'>
								<h6>SID </h6>
								<p>".$twilio_sid."</p>
								<h6>Token </h6>
								<p>".$twilio_token."</p>
								</div>";
					}
					if($type=='stripe'){
						$model_id = '#show_api_stripe';
						if($mode == '0'){
							$stripe_key = env('STRIPE_TEST_KEY');
							$title = 'Stripe Test Account';
						} 
						if($mode == '1'){
							$stripe_key = env('STRIPE_LIVE_KEY');
							$title = 'Stripe Live Account';
						} 
						$html = "<div class='user_finder bg-light p-3 border border-secondary'>
								<h6>Key </h6>
								<p>".$stripe_key."</p>
								</div>";
					}
					if($type=='paypal'){
						$model_id = '#show_api_paypal';
						if($mode == '0'){
							$title = "Paypal Test Account";
							$paypal_username = env('PAYPAL_SANDBOX_API_USERNAME');
							$paypal_password = env('PAYPAL_SANDBOX_API_PASSWORD');
							$paypal_secret   = env('PAYPAL_SANDBOX_API_SECRET');
						}
						if($mode == '1'){
							$title = "Paypal Live Account";
							$paypal_username = env('PAYPAL_LIVE_API_USERNAME');
							$paypal_password = env('PAYPAL_LIVE_API_PASSWORD');
							$paypal_secret   = env('PAYPAL_LIVE_API_SECRET');
						}
						$html = "<div class='user_finder bg-light p-3 border border-secondary'>
								<h6>Username </h6>
								<p>".$paypal_username."</p>
								<h6>Password </h6>
								<p>".$paypal_password."</p>
								<h6>Secret </h6>
								<p>".$paypal_secret."</p>
								</div>";
					}
					if($type=='postcard'){
						$model_id = '#show_api_postcard';
						if($mode == '0'){
							$title = "Postcard Test Account";
							$postcard_key = env('POSTCARD_TOKEN_TEST');
							
						}
						if($mode == '1'){
							$title = "Postcard Live Account";
							$postcard_key = env('POSTCARD_TOKEN_LIVE');
						}
						$html = "<div class='user_finder bg-light p-3 border border-secondary'>
								<h6>Key </h6>
								<p>".$postcard_key."</p>
								</div>";
					}
					if($type=='datatree'){
						$model_id = '#show_api_datafincer';
						if($mode == '0'){
							$title = "Datatree Test Account";
							$dtapi_username = env('DTAPI_TEST_AUTHENTICATE_USERNAME');
							$dtapi_password = env('DTAPI_TEST_AUTHENTICATE_PASSWORD');	
						}
						if($mode == '1'){
							$title = "Datatree Live Account";
							$dtapi_username = env('DTAPI_LIVE_AUTHENTICATE_USERNAME');
							$dtapi_password = env('DTAPI_LIVE_AUTHENTICATE_PASSWORD');	
						}
						$html = "<div class='user_finder bg-light p-3 border border-secondary'>
								<h6>Username </h6>
								<p>".$dtapi_username."</p>
								<h6>Password </h6>
								<p>".$dtapi_password."</p>
								</div>";
					}
					if($type=='datafinder'){
						$model_id = '#show_api_datafinder';
						if($mode == '0'){
							$title = "Datafinder Test Account";
							$datafinder_key = env('DATAFINDER_TEST_KEY');
							$datafinder_token = env('DATAFINDER_TEST_TOKEN');
							
						}
						if($mode == '1'){
							$title = "Datafinder Live Account";
							$datafinder_key = env('DATAFINDER_LIVE_KEY');
							$datafinder_token = env('DATAFINDER_LIVE_TOKEN');
						}
						$html = "<div class='user_finder bg-light p-3 border border-secondary'>
								<h6>Key </h6>
								<p>".$datafinder_key."</p>
								<h6>Token </h6>
								<p>".$datafinder_token."</p>
								</div>";
					}
					if($type=='accurate_append'){
						$model_id = '#show_api_accurateappend';
						if($mode == '0'){
							$title = "Accurate Append Test Account";
							$accurate_append_key = env('ACCURATE_APPEND_TEST_KEY');
							
						}
						if($mode == '1'){
							$title = "Accurate Append Live Account";
							$accurate_append_key = env('ACCURATE_APPEND_LIVE_KEY');
						}
						$html = "<div class='user_finder bg-light p-3 border border-secondary'>
								<h6>Key </h6>
								<p>".$accurate_append_key."</p>
								</div>";
					}
					return response()->json(['success'=>true, 'data' => $api_mode_q,'html' => $html,'title' =>$title,'model_id'=>$model_id]);
				} else {
					return response()->json(['error'=>true, 'data' => '']);
				}    
				
			}
			return response()->json(['error'=>'Invalid request.']);
        }
        return response()->json(['error'=>'Invalid request.']);
    }
	
	public function switchModeDetail()
    {
		$data = ApiMode::get();
		
		$dtapi_auth_username = env('DTAPI_TEST_AUTHENTICATE_USERNAME');
		$dtapi_auth_password = env('DTAPI_TEST_AUTHENTICATE_PASSWORD');	
		$dtapi_title = 'Datatree Test Account';
		$toggle_class = '';
		
		$datafinder_key = env('DATAFINDER_TEST_KEY');
		$datafinder_token = env('DATAFINDER_TEST_TOKEN');
		$datafinder_title = 'Datafinder Test Account';
		$datafinder_toggle_class = '';
		
		$accurate_append_key = env('ACCURATE_APPEND_TEST_KEY');
		$accurate_append_title = 'Accurate Append Test Account';
		$accurate_append_toggle_class = '';
		
		$stripe_key = env('STRIPE_TEST_KEY');
		$stripe_title = 'Stripe Test Account';
		$stripe_toggle_class = '';
		
		$sendgrid_key = env('SENDGRID_TEST_API_KEY');
		$sendgrid_title = 'Sendgrid Test Account';
		$sendgrid_toggle_class = '';
		$sendgrid_from_name = env('MAIL_FROM_NAME');
		$sendgrid_from_email = env('MAIL_FROM_ADDRESS');
		
		$twilio_sid   = env('TWILIO_SID_TEST');
		$twilio_token = env('TWILIO_TOKEN_TEST');
		$twilio_title = 'Thanks.io Test Account';
		$twilio_toggle_class = '';
		$twilio_from_number = env('TWILIO_FROM_NUMBER');
		
		$paypal_username = env('PAYPAL_SANDBOX_API_USERNAME');
		$paypal_password = env('PAYPAL_SANDBOX_API_PASSWORD');
		$paypal_secret   = env('PAYPAL_SANDBOX_API_SECRET');
		$paypal_title = 'Paypal Test Account';
		$paypal_toggle_class = '';
		
		$postcard_token = env('POSTCARD_TOKEN_TEST');
		$postcard_title = 'Postcard Test Account';
		$postcard_toggle_class = '';
		
		foreach($data as $key=>$val){
			if($val->api_name == 'postcard'){
				if($val->mode == '0'){
					$postcard_token = env('POSTCARD_TOKEN_TEST');
					$postcard_title = 'Postcard Test Account';
					$postcard_toggle_class = '';
				} 
				if($val->mode == '1'){
					$postcard_token = env('POSTCARD_TOKEN_LIVE');
					$postcard_title = 'Postcard Live Account';
					$postcard_toggle_class = 'change live';
				} 
			}
			if($val->api_name == 'paypal'){
				if($val->mode == '0'){
					$paypal_username = env('PAYPAL_SANDBOX_API_USERNAME');
					$paypal_password = env('PAYPAL_SANDBOX_API_PASSWORD');
					$paypal_secret   = env('PAYPAL_SANDBOX_API_SECRET');
					$paypal_title = 'Paypal Test Account';
					$paypal_toggle_class = '';
				} 
				if($val->mode == '1'){
					$paypal_username = env('PAYPAL_LIVE_API_USERNAME');
					$paypal_password = env('PAYPAL_LIVE_API_PASSWORD');
					$paypal_secret   = env('PAYPAL_LIVE_API_SECRET');
					$paypal_title = 'Paypal Live Account';
					$paypal_toggle_class = 'change live';
				} 
			}
			if($val->api_name == 'twilio'){
				if($val->mode == '0'){
					$twilio_sid   = env('TWILIO_SID_TEST');
					$twilio_token = env('TWILIO_TOKEN_TEST');
					$twilio_title = 'Thanks.io Test Account';
					$twilio_toggle_class = '';
				} 
				if($val->mode == '1'){
					$twilio_sid   = env('TWILIO_SID_LIVE');
					$twilio_token = env('TWILIO_TOKEN_LIVE');
					$twilio_title = 'Thanks.io Live Account';
					$twilio_toggle_class = 'change live';
				} 
			}
			if($val->api_name == 'sendgrid'){
				if($val->mode == '0'){
					$sendgrid_key = env('SENDGRID_TEST_API_KEY');
					$sendgrid_title = 'Sendgrid Test Account';
					$sendgrid_toggle_class = '';
				} 
				if($val->mode == '1'){
					$sendgrid_key = env('SENDGRID_LIVE_API_KEY');
					$sendgrid_title = 'Sendgrid Live Account';
					$sendgrid_toggle_class = 'change live';
				} 
			}
			if($val->api_name == 'datatree'){
				if($val->mode == '0'){
					$dtapi_auth_username = env('DTAPI_TEST_AUTHENTICATE_USERNAME');
					$dtapi_auth_password = env('DTAPI_TEST_AUTHENTICATE_PASSWORD');	
					$dtapi_title = 'Datatree Test Account';
					$toggle_class = '';
				} 
				if($val->mode == '1'){
					$dtapi_auth_username = env('DTAPI_LIVE_AUTHENTICATE_USERNAME');
					$dtapi_auth_password = env('DTAPI_LIVE_AUTHENTICATE_PASSWORD');	
					$dtapi_title = 'Datatree Live Account';
					$toggle_class = 'change live';
				} 
			}
			if($val->api_name == 'datafinder'){
				if($val->mode == '0'){
					$datafinder_key = env('DATAFINDER_TEST_KEY');
					$datafinder_token = env('DATAFINDER_TEST_TOKEN');
					$datafinder_title = 'Datafinder Test Account';
					$datafinder_toggle_class = '';
				} 
				if($val->mode == '1'){
					$datafinder_key = env('DATAFINDER_LIVE_KEY');
					$datafinder_token = env('DATAFINDER_LIVE_TOKEN');
					$datafinder_title = 'Datafinder Live Account';
					$datafinder_toggle_class = 'change live';
				} 
			}
			if($val->api_name == 'accurate_append'){
				if($val->mode == '0'){
					$accurate_append_key = env('ACCURATE_APPEND_TEST_KEY');
					$accurate_append_title = 'Accurate Append Test Account';
					$accurate_append_toggle_class = '';
				} 
				if($val->mode == '1'){
					$accurate_append_key = env('ACCURATE_APPEND_LIVE_KEY');
					$accurate_append_title = 'Datafinder Live Account';
					$accurate_append_toggle_class = 'change live';
				} 
			}
			if($val->api_name == 'stripe'){
				if($val->mode == '0'){
					$stripe_key = env('STRIPE_TEST_KEY');
					$stripe_title = 'Stripe Test Account';
					$stripe_toggle_class = '';
				} 
				if($val->mode == '1'){
					$stripe_key = env('STRIPE_LIVE_KEY');
					$stripe_title = 'Stripe Live Account';
					$stripe_toggle_class = 'change live';
				} 
			}
		}
		
		
		
		$data = array('datatree' => array(
			'dtapi_auth_username'=>$dtapi_auth_username,'dtapi_auth_password'=>$dtapi_auth_password,'title' => $dtapi_title,'toggle_class'=>$toggle_class
			),
			'datafinder' => array(
				'datafinder_key'=>$datafinder_key,'datafinder_token'=>$datafinder_token,'title' => $datafinder_title,'toggle_class'=>$datafinder_toggle_class
			),
			'accurate_append'=>array(
				'accurate_append_key'=>$accurate_append_key,'title' => $accurate_append_title,'toggle_class'=>$accurate_append_toggle_class
			),
			'stripe'=>array(
				'key'=>$stripe_key,'title' => $stripe_title,'toggle_class'=>$stripe_toggle_class
			),
			'sendgrid'=>array(
				'key'=>$sendgrid_key,'from_name' => $sendgrid_from_name,'from_email'=>$sendgrid_from_email,
				'title' => $sendgrid_title,'toggle_class'=>$sendgrid_toggle_class
			),
			'twilio'=>array(
				'sid'=>$twilio_sid,'token'=>$twilio_token,'from_number'=>$twilio_from_number,'title' => $twilio_title,'toggle_class'=>$twilio_toggle_class
			),
			'paypal'=>array(
				'username'=>$paypal_username,'password'=>$paypal_password,'secret'=>$paypal_secret,
				'title' => $paypal_title,'toggle_class'=>$paypal_toggle_class
			),
			'postcard'=>array(
				'token'=>$postcard_token,'title' => $postcard_title,'toggle_class'=>$postcard_toggle_class
			),
		);
		
		//print_r($data); die;
		return view('SuperadminDashboard.switchMode',compact('data'));
		
	}
	
	public function saveMaintenanceContent(Request $request)
    {
		
		$validator = Validator::make($request->all(), [
			'maintenance_banner_title' => 'required',
			'maintenance_banner_content' => 'required',
			'start_date' 	=> 	'required',
			'end_date' 		=> 	'required',
			'start_time' 	=> 	'required',
			'end_time' 		=> 	'required',
			
		]);
		
		
		if ($validator->passes()) {
			$total = Configuration::where("type","maintenance_banner")->count();
			
			if($total == 0){
				
				$settings = array(
					'status' =>  $request->get('status'),
					'maintenance_banner_title' =>  $request->get('maintenance_banner_title'),
					'maintenance_banner_content' =>  $request->get('maintenance_banner_content'),
					'start_date'	=>  $request->get('start_date'),
					'end_date' 		=>  $request->get('end_date'),
					'start_time'	=>  $request->get('start_time'),
					'end_time' 		=>  $request->get('end_time'),
				);
				$data=array(
					'type'		=> "maintenance_banner",
					'settings'	=> serialize($settings),
				);
				$saved = Configuration::create($data);
				if($saved){
					
					return redirect()->back()->with(['success'=>'Records added successfully ']);
				}else{
					
					return redirect()->back()->with(['success'=>'Save failed.']);
				}
			}else{
				$data 								   =  Configuration::where("type","maintenance_banner")->first();
				
				$content 							   =  unserialize($data->settings);
				$content["status"] =  $request->get('status');
				$content["maintenance_banner_title"] =  $request->get('maintenance_banner_title');
				$content["maintenance_banner_content"] =  $request->get('maintenance_banner_content');
				$content["start_date"]                 =  $request->get('start_date');
				$content["end_date"]                   =  $request->get('end_date');
				$content["start_time"]                 =  $request->get('start_time');
				$content["end_time"]                   =  $request->get('end_time');
				
				$data->settings                        =  serialize($content);
				
				$updated                               =  $data->save();
				
				if($updated){
					
					return redirect()->back()->with(['success'=>'Records updated successfully ']);
				}else{
					
					return redirect()->back()->with(['success'=>'Update failed.']);
				}
			}
		}
		return redirect()->back()->with(['error'=>$validator->errors()->all()]);
	}
	public function maintenanceBannerContent()
    {
       $data = Configuration::where("type","maintenance_banner")->first();
		//echo $data->settings;
		//echo "<pre>"; print_r($data); die;
		$content_arr = array(
            'status' =>   '',        
            'maintenance_banner_content' =>   '',        
            'maintenance_banner_title' =>   '',        
            'start_date'  			=> '',        
            'end_date'  			=> '',        
            'start_time'  			=> '',        
            'end_time'  			=> '',        
			);
		if($data){
			$content = unserialize($data->settings);
			$content_arr = array(
            'status' =>  isset($content['status']) ? $content['status'] : '',        
            'maintenance_banner_title' =>  isset($content['maintenance_banner_title']) ? $content['maintenance_banner_title'] : '',        
            'maintenance_banner_content' =>  isset($content['maintenance_banner_content']) ? $content['maintenance_banner_content'] : '',        
            'start_date'  			=>  isset($content['start_date']) ? $content['start_date'] : '',        
            'end_date'  			=>  isset($content['end_date']) ? $content['end_date'] : '',        
            'start_time'  			=>  isset($content['start_time']) ? $content['start_time'] : '',        
            'end_time'  			=>  isset($content['end_time']) ? $content['end_time'] : '',        
			);
			
		}
		
        return view('SuperadminDashboard.configuration.maintenanceBanner',compact('content_arr'));
    }
	
	public function targetsList()
    {
       $data = Configuration::where("type","targets")->first();
		//echo $data->settings;
		//echo "<pre>"; print_r($data); die;
		$targets_arr_data = unserialize($data->settings);
		$targets_arr = array(
            'revenue_target'  			=>  isset($targets_arr_data['revenue_target']) ? $targets_arr_data['revenue_target'] : '',
            'revenue_target_period'     =>  isset($targets_arr_data['revenue_target_period']) ? $targets_arr_data['revenue_target_period'] : '',
            'expense_target'     		=>  isset($targets_arr_data['expense_target']) ? $targets_arr_data['expense_target'] : '',
            'expense_target_period'   	=>  isset($targets_arr_data['expense_target_period']) ? $targets_arr_data['expense_target_period'] : ''        
        );
        return view('SuperadminDashboard.targets.targets',compact('targets_arr'));
    }
	
	/* public function ratesList()
    {
		$purchase 	= 	Configuration::where('type','purchase_record_price')->first();
		
		$purchase_price = 	(isset($purchase->price) && $purchase->price!='')  ? $purchase->price : 0;
		
		$property 	= 	Configuration::where('type','property_report_price')->first();
		$property_price = 	isset($property->price) ? $property->price : '';
		
		$phone 				= 	Configuration::where('type','phone_price')->first();
		$phone_price = 	isset($phone->price) ? $phone->price : '';
		
		$email 				= 	Configuration::where('type','email_price')->first();
		$email_price 				= 	isset($email->price) ? $email->price : 0;
		
		$membership		 	= 	Membership::where('amount','<>','')->first();
		//echo "ddd"; die;
        return view('SuperadminDashboard.targets.rates',compact('purchase_price','property_price','phone_price','email_price','membership'));
    } */
	
	public function ratesList()
    {
		$packages = $this->packagesList();
		
		$purchase 	= 	Configuration::where('type','purchase_record_price')->first();
		
		$purchase_price = 	(isset($purchase->price) && $purchase->price!='')  ? $purchase->price : '';
		
		$property 	= 	Configuration::where('type','property_report_price')->first();
		$property_price = 	isset($property->price) ? $property->price : '';
		
		$phone 				= 	Configuration::where('type','phone_price')->first();
		$phone_price = 	isset($phone->price) ? $phone->price : '';
		
		$email 				= 	Configuration::where('type','email_price')->first();
		$email_price 				= 	isset($email->price) ? $email->price : '';
		
		$membership		 	= 	Membership::where('amount','<>','')->first();
		
		$marketEmailData 	= 	Configuration::where('type','market_email_price')->first();
		$market_email_price = 	(isset($marketEmailData->price) && $marketEmailData->price!='')  ? $marketEmailData->price : '';
		
		$marketSMSData 	= 	Configuration::where('type','market_sms_price')->first();
		$market_sms_price = 	(isset($marketSMSData->price) && $marketSMSData->price!='')  ? $marketSMSData->price : '';
		
		$postcardData 	= 	Configuration::where('type','market_postcard_price')->first();
		$market_postcard_price = 	(isset($postcardData->price) && $postcardData->price!='')  ? $postcardData->price : '';
		
		$customPostcardData 	= 	Configuration::where('type','custom_postcard_price')->first();
		$custom_postcard_price = 	(isset($customPostcardData->price) && $customPostcardData->price!='')  ? $customPostcardData->price : '';
		
        return view('SuperadminDashboard.configuration.rates',compact('custom_postcard_price','packages','purchase_price','property_price','phone_price','email_price','membership','market_postcard_price','market_email_price','market_sms_price'));
    }
	public function packagesAddForm()
    {
		 return view('SuperadminDashboard.packages.addPackageForm');
	}
	
	private function packagesList()
    {
		$packagesData = Packages::with('features')->orderBy('id','desc')->get();
		return $packagesData;
	}
	public function saveRates(Request $request)
    { 
	
		if($request->get("type") == "custom_postcard_price"){
			$validator = Validator::make($request->all(), [
				'custom_postcard_price' => 'required',
				
			]);
			if ($validator->passes()) {
				$custom_postcard = $request->get("custom_postcard_price");
				$custom_postcard_p = 	(float) str_replace( array(',', '$ '), array('', ''), $custom_postcard);
				if($custom_postcard_p > 0){
				}else{ return back()->withErrors('Please add postcard price'); }
				$arr=array(
					'type'=>'custom_postcard_price',
				);

				$data = array(
					'price' => $custom_postcard_p
				);
				Configuration::updateOrCreate($arr,$data);
				return redirect()->back()->with(['success'=>'Custom Postcard Price Added Successfully ']);
			}
			return redirect()->back()->with(['error'=>$validator->errors()->all()]);
		}
		if($request->get("type") == "purchase_record_price"){
			$validator = Validator::make($request->all(), [
				'purchase_record_price' => 'required',
				
			]);
			
			if ($validator->passes()) {
				$purchase_record = $request->get("purchase_record_price");
				$purchase_record_price = 	(float) str_replace( array(',', '$ '), array('', ''), $purchase_record);
				
				if($purchase_record_price > 0){
				}else{ return back()->withErrors('Please add purchase record price'); } 
				$arr=array(
					'type'=>'purchase_record_price',
				);

				$data = array(
					'price' => $purchase_record_price
				);
				$updated = Configuration::updateOrCreate($arr,$data);
				
				return redirect()->back()->with(['success'=>'Purchase Record Price Added Successfully ']);
			}
			return redirect()->back()->with(['error'=>$validator->errors()->all()]);
		}
		
		if($request->get("type") == "property_report_price"){
			$validator = Validator::make($request->all(), [
				'property_report_price' => 'required',
				
			]);
			if ($validator->passes()) {
				$property_report = $request->get("property_report_price");
				$property_report_price = 	(float) str_replace( array(',', '$ '), array('', ''), $property_report);
				if($property_report_price > 0){
				}else{ return back()->withErrors('Please add property report price'); }
				
				$arr=array(
					'type'=>'property_report_price',
				);

				$data = array(
					'price' => $property_report_price
				);
				Configuration::updateOrCreate($arr,$data);
				return redirect()->back()->with(['success'=>'Property Price Added Successfully ']);
			}
			return redirect()->back()->with(['error'=>$validator->errors()->all()]);
		}
		
		if($request->get("type") == "phone_price"){
			$validator = Validator::make($request->all(), [
				'phone_price' => 'required',
				
			]);
			if ($validator->passes()) {
				$phone = $request->get("phone_price");
				$phone_price = 	(float) str_replace( array(',', '$ '), array('', ''), $phone);
				if($phone_price > 0){
				}else{ return back()->withErrors('Please add phone price'); }
				
				$arr=array(
					'type'=>'phone_price',
				);

				$data = array(
					'price' => $phone_price
				);
				Configuration::updateOrCreate($arr,$data);
				return redirect()->back()->with(['success'=>'Phone Price Added Successfully ']);
			}
			return redirect()->back()->with(['error'=>$validator->errors()->all()]);
		}
		
		if($request->get("type") == "email_price"){
			$validator = Validator::make($request->all(), [
				'email_price' => 'required',
				
			]);
			if ($validator->passes()) {
				$email = $request->get("email_price");
				$email_price = 	(float) str_replace( array(',', '$ '), array('', ''), $email);
				if($email_price > 0){
				}else{ return back()->withErrors('Please add email price'); }
				$arr=array(
					'type'=>'email_price',
				);

				$data = array(
					'price' => $email_price
				);
				Configuration::updateOrCreate($arr,$data);
				return redirect()->back()->with(['success'=>'Email Price Added Successfully ']);
			}
			return redirect()->back()->with(['error'=>$validator->errors()->all()]);
		}
		
		if($request->get("type") == "membership_price"){
			$validator = Validator::make($request->all(), [
				'membership_price' => 'required',
				
			]);
			if ($validator->passes()) {
				$membership	= $request->get("membership_price");
				$membership_price = 	(float) str_replace( array(',', '$ '), array('', ''), $membership);
				if($membership_price > 0){
				}else{ return back()->withErrors('Please add membership price'); }
				$plan 	= 	Membership::orderBy('id','desc')->first();
				if(isset($plan)){
					$plan->amount 		= 	$membership_price;
					$updated 			= 	$plan->save();
				}
				return redirect()->back()->with(['success'=>'Membership Price Added Successfully ']);
			}
			return redirect()->back()->with(['error'=>$validator->errors()->all()]);
		}
		
		if($request->get("type") == "market_email_price"){
			$validator = Validator::make($request->all(), [
				'market_email_price' => 'required',
				
			]);
			if ($validator->passes()) {
				$email = $request->get("market_email_price");
				$email_price = 	(float) str_replace( array(',', '$ '), array('', ''), $email);
				if($email_price > 0){
				}else{ return back()->withErrors('Please add market email price'); }
				$arr=array(
					'type'=>'market_email_price',
				);

				$data = array(
					'price' => $email_price
				);
				Configuration::updateOrCreate($arr,$data);
				return redirect()->back()->with(['success'=>'Market Email Price Added Successfully ']);
			}
			return redirect()->back()->with(['error'=>$validator->errors()->all()]);
		}
		if($request->get("type") == "market_sms_price"){
			$validator = Validator::make($request->all(), [
				'market_sms_price' => 'required',
				
			]);
			if ($validator->passes()) {
				$email = $request->get("market_sms_price");
				$email_price = 	(float) str_replace( array(',', '$ '), array('', ''), $email);
				if($email_price > 0){
				}else{ return back()->withErrors('Please add market sms price'); }
				$arr=array(
					'type'=>'market_sms_price',
				);

				$data = array(
					'price' => $email_price
				);
				Configuration::updateOrCreate($arr,$data);
				return redirect()->back()->with(['success'=>'Market SMS Price Added Successfully ']);
			}
			return redirect()->back()->with(['error'=>$validator->errors()->all()]);
		}
		if($request->get("type") == "market_postcard_price"){
			$validator = Validator::make($request->all(), [
				'market_postcard_price' => 'required',
				
			]);
			if ($validator->passes()) {
				$email = $request->get("market_postcard_price");
				$email_price = 	(float) str_replace( array(',', '$ '), array('', ''), $email);
				if($email_price > 0){
				}else{ return back()->withErrors('Please add postcard price'); }
				$arr=array(
					'type'=>'market_postcard_price',
				);

				$data = array(
					'price' => $email_price
				);
				Configuration::updateOrCreate($arr,$data);
				return redirect()->back()->with(['success'=>'Postcard Price Added Successfully ']);
			}
			return redirect()->back()->with(['error'=>$validator->errors()->all()]);
		}
		
	}
    
	
	public function saveTarget(Request $request)
    { 
		if($request->get("type") == "add_revenue_target"){
			
			$validator = Validator::make($request->all(), [
				'revenue_target' => 'required',
				//'revenue_target_period' => 'required'
			]);
				
		    //echo "<pre>"; print_r($request->all()); die;
			if ($validator->passes()) {
				$total = Configuration::where("type","targets")->count();
				if($total == 0){
					$revenueValue = explode('.', $request->get("revenue_target"));
					$settings["revenue_target"] = (int) str_replace( array(',', '$ '), array('', ''), $revenueValue[0]);
					//$settings["revenue_target_period"]  =   $request->get("revenue_target_period");
					$data=array(
						'type'=> "targets",
						'settings'=> serialize($settings),
					);
					$saved = Configuration::create($data);
					if($saved){
						
						return redirect()->back()->with(['success'=>'Records Added Successful ']);
					}else{
						
						return redirect()->back()->with(['success'=>'Save failed.']);
					}
				}else{
					$data = Configuration::where("type","targets")->first();
					$targets_arr = unserialize($data->settings);
					$revenueValue = explode('.', $request->get("revenue_target"));
					$targets_arr["revenue_target"] = (int) str_replace( array(',', '$ '), array('', ''), $revenueValue[0]);
					//$targets_arr["revenue_target_period"]  =   $request->get("revenue_target_period");
					
					$data->settings = serialize($targets_arr);
					$updated = $data->save();
					
					if($updated){
						
						return redirect()->back()->with(['success'=>'Records Added Successful ']);
					}else{
						
						return redirect()->back()->with(['success'=>'Update failed.']);
					}
				}
				
				return redirect()->back()->with(['error'=>'Unable to Save ']);
			}
			
			return redirect()->back()->with(['error'=>$validator->errors()->all()]);
			
		}
		
		if($request->get("type") == "add_expense_target"){
			
			$validator = Validator::make($request->all(), [
				'expense_target' => 'required',
				//'expense_target_period' => 'required'
			]);
				
			//echo "<pre>"; print_r($request->all()); die;
			if ($validator->passes()) {
				$total = Configuration::where("type","targets")->count();
				if($total == 0){
					$expenseValue = explode('.', $request->get("expense_target"));					
					$settings["expense_target"] = (int) str_replace( array(',', '$ '), array('', ''), $expenseValue[0]);
					//$settings["expense_target_period"]  =   $request->get("expense_target_period");
					$data=array(
						'type'		=> 	"targets",
						'settings'	=> 	serialize($settings),
					);
					$saved = Configuration::create($data);
					if($saved){
						
						return redirect()->back()->with(['success'=>'Records Added Successful ']);
					}
				}else{
					$data = Configuration::where("type","targets")->first();
					//echo $data->settings;
					
					//echo "<pre>"; print_r($data); die;
					$targets_arr = unserialize($data->settings);
					$expenseValue = explode('.', $request->get("expense_target"));
					$targets_arr["expense_target"] = (int) str_replace( array(',', '$ '), array('', ''), $expenseValue[0]);
					//$targets_arr["expense_target_period"]  =   $request->get("expense_target_period");
					/* $save_data=array(
						'type'=> "targets",
						'settings'=> serialize($targets_arr),
					); */
					$data->settings = serialize($targets_arr);
					$updated = $data->save();
					
					if($updated){
						
						return redirect()->back()->with(['success'=>'Records Added Successful ']);
					}else{
						
						return redirect()->back()->with(['success'=>'Update failed.']);
					}
				}
			}
			return redirect()->back()->with(['error'=>$validator->errors()->all()]);
			
		}
    }

   
}
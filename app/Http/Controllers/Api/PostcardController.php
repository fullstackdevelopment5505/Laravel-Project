<?php

namespace App\Http\Controllers\Api;

use Anam\PhantomMagick\Converter;
use App\Http\Controllers\Api\MainController;
use Illuminate\Contracts\Database\Eloquent\Castable;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Validator, Response, DB,File;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Client;
use Carbon\Carbon;
use DataTables;
use App\UserPostcardTemplate;
use App\Model\UserPostcardDesign;
use App\ContactLog;
use App\Model\UserProperty;
use App\Model\ApiMode;
use App\Model\Points;
use App\Configuration;
use Illuminate\Support\Facades\Storage;
class PostcardController extends MainController
{
	private $postcard_token,$admin_url;

	public function __construct()
	{
		$data = ApiMode::where('api_name','postcard')->first();
		$this->postcard_token = env('POSTCARD_TOKEN_TEST');
		$this->admin_url      = env('APP_ADMIN_URL');
		if( isset($data) && $data->mode == 1){
			$this->postcard_token = env('POSTCARD_TOKEN_LIVE');
		}
    }
	public function usersPostcardDesignsDetail($id){
        if ($id)
        {
            $data = UserPostcardDesign::where('id',$id)->where('user_id', Auth::id())->orderBy('updated_at','desc')->first();
			$related_postcard_designs = [];
			if($data->count() >0){
				$related_postcard_designs = UserPostcardDesign::where('id','<>',$id)->where('user_id', Auth::id())->orderBy('updated_at','desc')->get();
			}
			return $this->getResponse(200,'Postcards Designs',(Object)array('data'=>$data,'related_designs'=>$related_postcard_designs));
        }
		return $this->getResponse(422,'Invalid id!',[],0);
	}
	public function listUsersPostcardDesigns(Request $request){
		$sent_postcards = UserPostcardDesign::select('id','created_at','updated_at','status')->where('status','0')->where('user_id', Auth::id())->orderBy('id','desc')->get();
		$progress_postcards = UserPostcardDesign::select('agent_name','phone','id','created_at','updated_at','status')->where('status','1')->where('user_id', Auth::id())->orderBy('updated_at','desc')->get();
		$completed_postcards = UserPostcardDesign::select('id','created_at','completed_at','updated_at','status')->where('status','2')->where('user_id', Auth::id())->orderBy('updated_at','desc')->get();
		return $this->getResponse(200,'Postcards Designs',(Object)array('postcards_sent'=>$sent_postcards,'progress_postcards'=>$progress_postcards,
		'completed_postcards'=>$completed_postcards));
	}

	public function addPostcardDesign(Request $request){

		$validator = Validator::make($request->all(), [
            'comapany_goal'   => 'required',
            'targets'   => 'required',
            'primary_color'   => 'required',
            'postcard_content'   => 'required',
            'postcard_size'   => 'required',

        ]);
        if ($validator->fails())
        {
            return $this->getResponse(422,$validator->errors()->first(),$validator->errors(),0);
        }

		$credit=Points::where('user_id',Auth::id())->where('type','1')->groupBy('user_id')->orderBy('id','desc')->sum('amount');
		$debit=Points::where('user_id',Auth::id())->where('type','2')->where('instant',0)->groupBy('user_id')->orderBy('id','desc')->sum('amount');
		$wallet_amount = $credit-$debit;
		$current_wallet_amount = round($wallet_amount,2);
		$customPostcardData = 	Configuration::where('type','custom_postcard_price')->first();
		$custom_postcard_price = (isset($customPostcardData->price) && $customPostcardData->price!='')  ? $customPostcardData->price : '';
		if($current_wallet_amount < $custom_postcard_price){
			return $this->getResponse(422,"Insufficient Balance",(Object)[],0);
		}
		$pointRate=DB::table('tbl_static')->select('point_per_dollar')->first();
		$points=array(
			'user_id'=>Auth::id(),
			'type'=>'2',
			'transaction_detail'=>'Funds Debited for Custom Postcard',
			'point'=>$custom_postcard_price*$pointRate->point_per_dollar, //amount is in dollar so, convert in points.
			'amount'=>$custom_postcard_price, //add amount in dollar
			'transaction_detail'=>'Customer Postcard Design',
		);
		Points::create($points);
		$comapany_goal = $request->get('comapany_goal');
		$targets = $request->get('targets');
		$primary_color = $request->get('primary_color');
		$secondary_color = $request->get('secondary_color');
		$font_family = $request->get('font_family');
		$postcard_content = $request->get('postcard_content');
		$additional_notes = $request->get('additional_notes');
		$design_sample = $request->get('design_sample');
		$postcard_size = $request->get('postcard_size');
		$sample_design_image = '';
		if ($request->hasFile('design_sample')) {
            // get file info
            $image = $request->file('design_sample');
            $extension = $image->getClientOriginalExtension();

            // check file extension
            if ($extension != 'png' && $extension != 'jpg' && $extension != 'jpeg') {
                $img_error = 'Must be a .jpg or .png file!'; // create message
                return $this->getResponse(422,$img_error,0);
            }

            // create new name and move file to appropriate folder
            // $filename = 'postcard_design_sample_' . time() . '.' . $image->getClientOriginalExtension();
			// $path = $image->storeAs('/templates/uploads', $filename);
            // // create public link to image
			// $url = $this->admin_url;
            // $sample_design_image = $url.'templates/uploads/' . $filename; // change url accordingly
			// punch 5
			$cover = $request->file('design_sample');
			$extension = $cover->getClientOriginalExtension();
			Storage::disk('public')->put('uploads/'.$cover->getFilename().'.'.$extension,  File::get($cover));
			$url = $this->admin_url;
            $sample_design_image = $url.'storage/app/public/uploads/'.$cover->getFilename().'.'.$extension; // change url accordingly
		}
		UserPostcardDesign::insert([
			'user_id' => Auth::id(),
			'postcard_content' => $postcard_content,
			'company_goal' => $comapany_goal,
			'targets' => $targets,
			'primary_color' => $primary_color,
			'secondary_color' => $secondary_color,
			'font_family' => $font_family,
			'sample_image' => $sample_design_image,
			'postcard_size' => $postcard_size,
			'additional_notes' => $additional_notes,
			"created_at" =>  Carbon::now(), # new \Datetime()
            "updated_at" => Carbon::now(),  # new \Datetime()
			]
		);
		$inserted_id = DB::getPdo()->lastInsertId();
		if($inserted_id){

			return $this->getResponse(200,'success',[],1);
		}
		return $this->getResponse(422,'something went wrong!',[],0);

	}

	public function getAddresses(Request $request)
    {
		$validator = Validator::make($request->all(), [
            'property_id'   => 'required'

        ]);
        if ($validator->fails())
        {
            return $this->getResponse(422,$validator->errors()->first(),$validator->errors(),0);
        }

		$property_id_in_arrays = explode( ',' , $request->input( 'property_id' ) );

		$total_user_properties = DB::table('user_property')->where('user_id', Auth::id())->whereIN('id',$property_id_in_arrays)->count();

		if($total_user_properties == 0){

			return $this->getResponse(422,'Properties do not exist',0);
		}
		$user_properties=DB::table('user_property')->select('OwnerMailingName','OwnerName1Full','OwnerName2Full','user_property.id as property_id',
		'MailHouseNumber','MailCity','SitusCity','SitusState','SitusZipCode','SitusHouseNumber','SitusStreetName','SitusMode','MailState','MailStreetName',
		'MailStreetNameSuffix','MailZZIP9')
		->join('datatree','datatree.id','=','user_property.property_id')
		->where('user_id',Auth::id())
		->whereIN('user_property.id',$property_id_in_arrays)
		->get();
		$all_address = [];
		$recipientString = '';
		foreach ($user_properties as $result) {

			$name1 			= 	$result->OwnerMailingName ? $result->OwnerMailingName : $result->OwnerName1Full;
			$name 			= 	$name1 ? $name1 : $result->OwnerName2Full;
			$city 			=  	$result->MailCity;
			$state 			=  	$result->MailState;
			$postal_code 	=  	$result->MailZZIP9;
			$address  		= 	$result->MailHouseNumber." ".$result->MailStreetName." ".$result->MailCity." ".$result->MailState." ".$result->MailZZIP9;
			if($address !="" && $city != "" && $state !="" && $postal_code != ""){

				$all_address[] = array('property_id'=>$result->property_id,"name" => $name,'address' => $address,'city' => $city,'province' => $state,'postal_code' => $postal_code,'country'=>'US');
				$recipientString .= "{\n        \"name\": \"$name\",\n            \"address\": \"$address\",\n            \"city\": \"$city\",\n            \"province\": \"$state\",\n            \"postal_code\": \"$postal_code\",\n            \"country\": \"US\"\n        }\n,";

			}
		}
		return $this->getResponse(200,'Addresses',$all_address,1);
	}
	public function getPostcardStepsData()
    {
		$table_name = 'user_postcard_images';
		$image_templates = DB::table($table_name)->select('id','user_id','template_image_path','save_image_template')->where([['save_image_template','1'],['user_id' , Auth::id()]])->get();
		$handwriting_styles = $this->getHandWritingStyles();
		return $this->getResponse(200,'Prospects List',(Object)array('image_templates'=>$image_templates,'handwriting_styles'=>$handwriting_styles));
	}

	public function postcardProspectsList(Request $request)
    {
        $count=UserProperty::with('datatree')->where([['user_id',Auth::id()],['status','2'],['trash','0']])->count();
        $data=UserProperty::join('datatree','datatree.id','=','user_property.property_id')->select('user_property.id as property_id','user_property.status','datatree.*',DB::raw('(CASE WHEN LENGTH(SitusZipCode) = 4 THEN  CONCAT(\'0\',SitusZipCode) ELSE SitusZipCode END) as SitusZipCode'))->where([['user_id',Auth::id()],['user_property.status','2'],['trash','0']])->get();
		return $this->getResponse(200,'Prospects List',(Object)array('count'=>$count,'data'=>$data));
    }
	public function sendPostcard(Request $request) {
		$validator = Validator::make($request->all(), [
            'property_id'   => 'required',
            'save_image_template' => 'required',
            'size'       	=> 'required',
            'message'       => 'required',
            'record_type'   => 'required',

        ]);
        if ($validator->fails())
        {
            return $this->getResponse(422,$validator->errors()->first(),$validator->errors(),0);
        }
		$record_type = $request->get('record_type');
		$save_image_template = 	$request->save_image_template;
		$property_id 		= 	$request->property_id;
		$message 			= 	$request->message;
        $handwriting_style 	= 	$request->style;
        $image_template 	= 	$request->template;
        $size 				= 	$request->size;
        $type 				= 	$request->type;
        $front_image_url 		= 	$request->front_image_url;
		$template_json  	= 	$request->template_json ? json_encode($request->get('template_json')) : null;
        $title  			= 	$request->title ? $request->title : '' ;
		$url = $this->admin_url;

		$image_template = $front_image_url;
		 // handle file
        if ($request->hasFile('file')) {
            // get file info
            $image = $request->file('file');
            $extension = $image->getClientOriginalExtension();

            // check file extension
            if ($extension != 'png' && $extension != 'jpg') {
                $img_error = 'Must be a .jpg or .png file!'; // create message
                return $this->getResponse(422,$img_error,0);
            }
            // create new name and move file to appropriate folder
            $filename = 'user_upload_' . time() . '.' . $image->getClientOriginalExtension();
			$path = $image->storeAs('/templates/uploads', $filename);
            // create public link to image
            $image_template = $url.'templates/uploads/' . $filename; // change url accordingly
        }
        // change the new line characters so they send in the curl request
        $message = str_replace("\n","\\n", $message);

		$user_image_template_id = 0;
        // check if image is url and store it
        if (filter_var($image_template, FILTER_VALIDATE_URL)) {
            $user_image_template_id = $this->storeImage($image_template,$save_image_template);
        }
			$recipientString = "";

			$property_id_in_arrays = explode( ',' , $request->input( 'property_id' ) );

			$total_user_properties = DB::table('user_property')->where('user_id', Auth::id())->whereIN('id',$property_id_in_arrays)->count();

			if($total_user_properties == 0){

				return $this->getResponse(422,'Properties do not exist',0);
			}
			if($record_type=='datatree'){
				$user_properties=DB::table('user_property')->select('OwnerMailingName','OwnerName1Full','OwnerName2Full','user_property.id as property_id',
				'MailHouseNumber','MailCity','SitusCity','SitusState','SitusZipCode','SitusHouseNumber','SitusStreetName',
				'SitusMode','MailState','MailStreetName','MailStreetNameSuffix','MailZZIP9')
				->join('datatree','datatree.id','=','user_property.property_id')
				->where('user_id',Auth::id())
				->where('property_type','datatree')
				->whereIN('user_property.id',$property_id_in_arrays)->get();

				$data = [];
				$propertiesWithStreetAddress = [];
				foreach ($user_properties as $result) {

					$name 			= 	$result->OwnerMailingName ? $result->OwnerMailingName : '';

					$city 			=  	$result->MailCity;
					$state 			=  	$result->MailState;
					$postal_code 	=  	$result->MailZZIP9;
					$streetAddress  = 	$result->MailHouseNumber." ".$result->MailStreetName;

					/* $addressS  		= 	$result->SitusHouseNumber." ".$result->SitusStreetName." ".$result->SitusMode." ".$result->SitusCity." ".$result->SitusState." ".$result->SitusZipCode; */

					if($streetAddress !="" && $city != "" && $state !="" && $postal_code != ""){
						$address = $streetAddress." ".$result->MailCity." ".$result->MailState." ".$result->MailZZIP9;
						$data[]=array(
							'user_property_id'=>$result->property_id,
							'description'=>$title,
							'type' => 'postcard',
							'user_id' => Auth::id(),
							'contact_date'=>Carbon::now(),
							'contact_time'=>Carbon::now()->toDateTimeString(),
							'status' => 'draft'
						);
						$recipientString .= "{\n        \"name\": \"$name\",\n            \"address\": \"$address\",\n            \"city\": \"$city\",\n            \"province\": \"$state\",\n            \"postal_code\": \"$postal_code\",\n            \"country\": \"US\"\n        }\n,";
						array_push($propertiesWithStreetAddress,$result->property_id);
					}

				}
			}
			if($record_type=='import'){
				$user_properties=DB::table('user_property')->select('firstname','lastname','address','user_property.id as property_id',
				'city','state','zip')
				->where('user_id',Auth::id())
				->where('property_type','import')
				->whereIN('user_property.id',$property_id_in_arrays)->get();

				$data = [];
				$propertiesWithStreetAddress = [];
				foreach ($user_properties as $result) {

					$name 			= 	$result->firstname ? $result->lastname : '';

					$city 			=  	$result->city;
					$state 			=  	$result->state;
					$postal_code 	=  	$result->zip;
					$streetAddress  = 	$result->address;
					if($streetAddress !="" && $city != "" && $state !="" && $postal_code != ""){
						$address = $streetAddress;
						$data[]=array(
							'user_property_id'=>$result->property_id,
							'description'=>$title,
							'type' => 'postcard',
							'user_id' => Auth::id(),
							'contact_date'=>Carbon::now(),
							'contact_time'=>Carbon::now()->toDateTimeString(),
							'status' => 'draft'
						);
						$recipientString .= "{\n        \"name\": \"$name\",\n            \"address\": \"$address\",\n            \"city\": \"$city\",\n            \"province\": \"$state\",\n            \"postal_code\": \"$postal_code\",\n            \"country\": \"US\"\n        }\n,";
						array_push($propertiesWithStreetAddress,$result->property_id);
					}

				}
			}
			try {
				// create post object dispatch it to queue
				$recipientStringN = rtrim($recipientString, ',');
				$url = 'https://api.thanks.io/api/v2/send/postcard';
				$token = $this->postcard_token;
				//$token = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6IjI4N2EwNmZhMTRlNGI2M2U5OWI1YmFiZDM3ZDVhZWIxOGMyYWEwMzZiODZmMTJlMzI5ZWQ0MzRkMGI4MjI3Y2E3NGQyN2I2NTgwYmY2MTU5In0';
				$post_fields = "{\n
                            \"front_image_url\": \"$image_template\",\n
                            \"handwriting_style\": $handwriting_style,\n
                            \"size\": \"$size\",\n
                            \"message\": \"$message\",\n
                            \"recipients\": [\n
                                                $recipientStringN
                                            ]\n}";


				 // initiate curl request
					$curl = curl_init();
					// build request
					curl_setopt_array($curl, array(
					CURLOPT_URL => $url,
					CURLOPT_RETURNTRANSFER => true,
					CURLOPT_ENCODING => "",
					CURLOPT_MAXREDIRS => 10,
					CURLOPT_TIMEOUT => 0,
					CURLOPT_FOLLOWLOCATION => true,
					CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
					CURLOPT_CUSTOMREQUEST => 'POST',
					CURLOPT_POSTFIELDS => $post_fields,
					CURLOPT_HTTPHEADER => array(
						"Content-Type: application/json",
						"Authorization: Bearer $token",
						"Content-Type: application/json"
					),
					));

					// get response
					$response = curl_exec($curl);
					$httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);

					// close curl
					curl_close($curl);

					// convert response to json object and process it
					$response = json_decode($response, true);

					// check if there are errors
					if ($httpcode == 200) {
						$status = 1;
						// store data
						// extract information
							$type = $response['type'];
							$message = $response['message'];
							$apistatus = 'Submitted';
							$handwriting_style = $response['style'];
							$front_image = $response['front_image'];
							$transaction_id = $response['transaction_id'];
							$estimiated_recipients = $response['total_estimated_recipients'];
							$authorization_total = $response['authorization_total'];
							$size = $response['size'];
							$session_id = $response['session_id'];
							$id = $response['id'];
							$display_trigger = $response['display_trigger'];
							$share_url  = $response['share_url'];
							$updated_at = $response['updated_at'];
							$created_at = $response['created_at'];
							// store metadata variables
							 DB::table('user_postcard_metadata')->insert([
									'user_id' => Auth::id(),
									'message' => $message,
									'user_image_template_id' => $user_image_template_id,
									'handwriting_style' => $handwriting_style,
									'front_image' => $front_image,
									'transaction_id' => $transaction_id,
									'total_estimated_recipients' => $estimiated_recipients,
									'authorization_total' => $authorization_total,
									'size' => $size,
									'session_id' =>$session_id,
									'postcard_id' => $id,
									'display_trigger' => $display_trigger,
									'share_url' => $share_url,
									'updated_at' => $updated_at,
									'created_at' => $created_at,
									'status' => $apistatus,
									'template_title' => $title,
									'template_json' => $template_json,
									]
								);
								foreach($data as $val){
									$val['status'] = 'submitted';
								}
								$contact_log = ContactLog::insert($data);
								$userProperty =  UserProperty::find(implode(",",$propertiesWithStreetAddress));
								$userProperty->touch();
						return $this->getResponse(200,'postcard sent'.$httpcode,$response,1);

					} else {
						// set status to 0;
						$status = 0;
						$inserted = DB::table('user_postcard_metadata')->insert([
							'user_id' => Auth::id(),
							'message' => $message,
							'handwriting_style' => $handwriting_style,
							'user_image_template_id' => $user_image_template_id,
							'front_image' => $image_template,
							'total_estimated_recipients' => $total_user_properties,
							'size' => $size,
							'display_trigger' => 'API',
							'status' => 'Failed',
							'template_title' => $title,
							'template_json' => $template_json,
							]);
						// store data
						 foreach($data as $val){
							$val['status'] = 'failed';
						}

						$contact_log = ContactLog::insert($data);
						$userProperty =  UserProperty::find(implode(",",$propertiesWithStreetAddress));
						$userProperty->touch();
						return $this->getResponse(200,'postcard sent'.$httpcode,$response,1);
					}
			} catch (Exception $e) {
				$status = 0;
				return $this->getResponse(422,'Something went wrong,Kindly try after some time!'.$e->getMessage(),$response,1);
			}

        return $this->getResponse(200,'postcard sent'.$httpcode,$response,1);
	}

	public function savePostcard(Request $request) {

		$validator = Validator::make($request->all(), [
            'message'  => 'required',
            'title'    => 'required',

        ]);
        if ($validator->fails())
        {
            return $this->getResponse(422,$validator->errors()->first(),$validator->errors(),0);
        }
		if(!isset($request->front_image_url) || $request->front_image_url == ""){

			return $this->getResponse(422,"Postcard content is required.",0);
		}
		$message 			= 	$request->message;
        $handwriting_style 	= 	($request->style) ? $request->style : '';
        $image_template 	= 	'';
        $size 				= 	($request->size) ? $request->size : '' ;
        $type 				= 	($request->type) ? $request->type : '' ;
        $postcard_html 		= 	$request->front_image_url;
        $template_json  	= 	$request->template_json ? json_encode($request->get('template_json')) : null ;
        $title  			= 	$request->title ? $request->title :'' ;
		$url = $this->admin_url;

		 // handle file
        if ($request->hasFile('file')) {
            // get file info
            $image = $request->file('file');
            $extension = $image->getClientOriginalExtension();
            // check file extension
            if ($extension != 'png' && $extension != 'jpg') {
                $img_error = 'Must be a .jpg or .png file!'; // create message
                return $this->getResponse(422,$img_error,0);
            }

            // create new name and move file to appropriate folder
            $filename = 'user_upload_' . time() . '.' . $image->getClientOriginalExtension();
			$path = $image->storeAs('/templates/uploads', $filename);
            // create public link to image
            $image_template = $url.'templates/uploads/' . $filename; // change url accordingly
        }
		$filename = uniqid().time().'_postcard.png';
		//convert html to image
		$conv = new \Anam\PhantomMagick\Converter();
		$conv->addPage($postcard_html)
		->toPng()
		->save(public_path('templates/uploads/').$filename);
		$image_template = $url.'templates/uploads/' . $filename; // change url accordingly
        // change the new line characters so they send in the curl request
        $message = str_replace("\n","\\n", $message);
        // check if image is url and store it
        if (filter_var($image_template, FILTER_VALIDATE_URL)) {
            $this->storeImage($image_template,'0');
        }
		$inserted = DB::table('user_postcard_metadata')->insert([
			'user_id' => Auth::id(),
			'message' => $message,
			'handwriting_style' => $handwriting_style,
			'front_image' => $image_template,
			'size' => $size,
			'display_trigger' => 'EquityAPI',
			'status' => 'Draft',
			'template_title'=>$title,
			'template_json'=> $template_json
			]);
		if( $inserted ){
			return $this->getResponse(200,'Postcard saved successfully.',1);
		}
        return $this->getResponse(400,'something went wrong!',0);
	}

	public function sendPostcardOld(Request $request) {
		$validator = Validator::make($request->all(), [
            'property_id'   => 'required',
            'size'       	=> 'required',

        ]);
        if ($validator->fails())
        {
            return $this->getResponse(422,$validator->errors()->first(),$validator->errors(),0);
        }

		$property_id 		= 	$request->property_id;
		$message 			= 	$request->message;
        $handwriting_style 	= 	$request->style;
        $image_template 	= 	$request->template;
        $size 				= 	$request->size;
        $type 				= 	$request->type;
        $postcard_html 		= 	$request->front_image_url;
		$url = $this->admin_url;
		// handle file
        if ($request->hasFile('file')) {
            // get file info
            $image = $request->file('file');
            $extension = $image->getClientOriginalExtension();
            // check file extension
            if ($extension != 'png' && $extension != 'jpg') {
                $img_error = 'Must be a .jpg or .png file!'; // create message
                return $this->getResponse(422,$img_error,0);
            }
            // create new name and move file to appropriate folder
            $filename = 'user_upload_' . time() . '.' . $image->getClientOriginalExtension();
			$path = $image->storeAs('/templates/uploads', $filename);
            // create public link to image

            $image_template = $url.'templates/uploads/' . $filename; // change url accordingly
        }
		$filename = uniqid().time().'_postcard.png';
		//convert html to image
		$conv = new \Anam\PhantomMagick\Converter();
		$conv->addPage($postcard_html)
		->toPng()
		->save(public_path('templates/uploads/').$filename);
		$image_template = $url.'templates/uploads/' . $filename; // change url accordingly
        // change the new line characters so they send in the curl request
        $message = str_replace("\n","\\n", $message);
        // check if image is url and store it
        // check if image is url and store it
        if (filter_var($image_template, FILTER_VALIDATE_URL)) {
            $this->storeImage($image_template,'0');
        }
			$recipientString = "";
			$property_id_in_arrays = explode( ',' , $request->input( 'property_id' ) );
			$user_properties=DB::table('user_property')->select('OwnerMailingName','OwnerName1Full','OwnerName2Full','user_property.id as property_id','MailHouseNumber','MailCity','SitusCity','SitusState','SitusZipCode','SitusHouseNumber','SitusStreetName','SitusMode','MailState','MailStreetName','MailStreetNameSuffix','MailZZIP9')->join('datatree','datatree.id','=','user_property.property_id')->where('user_id',Auth::id())->whereIN('user_property.id',$property_id_in_arrays)->get();;
            $total_user_properties = DB::table('user_property')->where('user_id', Auth::id())->whereIN('id',$property_id_in_arrays)->count();

			if($total_user_properties == 0){

				return $this->getResponse(422,'Properties do not exist',0);
			}
			foreach ($user_properties as $result) {

				$name1 			= 	$result->OwnerMailingName ? $result->OwnerMailingName : $result->OwnerName1Full;
				$name 			= 	$name1 ? $name1 : $result->OwnerName2Full;
				$city 			=  	$result->MailCity;
				$state 			=  	$result->MailState;
				$postal_code 	=  	$result->MailZZIP9;
				$address  		= 	$result->MailHouseNumber." ".$result->MailStreetName." ".$result->MailCity." ".$result->MailState." ".$result->MailZZIP9; $addressS  		= 	$result->SitusHouseNumber." ".$result->SitusStreetName." ".$result->SitusMode." ".$result->SitusCity." ".$result->SitusState." ".$result->SitusZipCode; */

				if($address !="" && $city != "" && $state !="" && $postal_code != ""){
                  $recipientString .= "{\n        \"name\": \"$name\",\n            \"address\": \"$address\",\n            \"city\": \"$city\",\n            \"province\": \"$state\",\n            \"postal_code\": \"$postal_code\",\n            \"country\": \"US\"\n        }\n,";
                }
			}
			try {
				// create post object dispatch it to queue
				$recipientStringN = rtrim($recipientString, ',');
				$url = 'https://api.thanks.io/api/v2/send/postcard';
				$token = $this->postcard_token;
				$post_fields = "{\n
                            \"front_image_url\": \"$image_template\",\n
                            \"handwriting_style\": $handwriting_style,\n
                            \"size\": \"$size\",\n
                            \"message\": \"$message\",\n
                            \"recipients\": [\n
                                                $recipientStringN
                                            ]\n}";
				 // initiate curl request
					$curl = curl_init();

					// build request
					curl_setopt_array($curl, array(
					CURLOPT_URL => $url,
					CURLOPT_RETURNTRANSFER => true,
					CURLOPT_ENCODING => "",
					CURLOPT_MAXREDIRS => 10,
					CURLOPT_TIMEOUT => 0,
					CURLOPT_FOLLOWLOCATION => true,
					CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
					CURLOPT_CUSTOMREQUEST => 'POST',
					CURLOPT_POSTFIELDS => $post_fields,
					CURLOPT_HTTPHEADER => array(
						"Content-Type: application/json",
						"Authorization: Bearer " . $token
					),
					));
					// get response
					$response = curl_exec($curl);
					$httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);

					// close curl
					curl_close($curl);
					// convert response to json object and process it
					$response = json_decode($response, true);

					// check if there are errors
					if ($httpcode == 200) {
						$status = 1;
						    // store data
							// extract information
							$type = $response['type'];
							$message = $response['message'];
							$status = 'Submitted';
							$handwriting_style = $response['style'];
							$front_image = $response['front_image'];
							$transaction_id = $response['transaction_id'];
							$estimiated_recipients = $response['total_estimated_recipients'];
							$authorization_total = $response['authorization_total'];
							$size = $response['size'];
							$session_id = $response['session_id'];
							$id = $response['id'];
							$display_trigger = $response['display_trigger'];
							$share_url  = $response['share_url'];
							$updated_at = $response['updated_at'];
							$created_at = $response['created_at'];

							// store metadata variables
							DB::table('user_postcard_metadata')->insert([
									'user_id' => Auth::id(),
									'message' => $message,
									'handwriting_style' => $handwriting_style,
									'front_image' => $front_image,
									'transaction_id' => $transaction_id,
									'total_estimated_recipients' => $estimiated_recipients,
									'authorization_total' => $authorization_total,
									'size' => $size,
									'session_id' =>$session_id,
									'postcard_id' => $id,
									'display_trigger' => $display_trigger,
									'share_url' => $share_url,
									'updated_at' => $updated_at,
									'created_at' => $created_at,
									'status' => $status
							]);
					} else {
						// set status to 0;
						$status = 0;
						$inserted = DB::table('user_postcard_metadata')->insert([
							'user_id' => Auth::id(),
							'message' => $message,
							'handwriting_style' => $handwriting_style,
							'front_image' => $image_template,
							'total_estimated_recipients' => $total_user_properties,
							'size' => $size,
							'display_trigger' => 'API',
							'status' => 'Failed'
						]);
					}
			} catch (Exception $e) {
				$status = 0;
			}

        return $this->getResponse(422,$status,0);
	}

	public function getUserPostcard(Request $request) {
		$postcards = DB::table('user_postcard_metadata')->where('user_id',Auth::id())->where('status','Draft')->orderBy('id','desc')->get();

		return $this->getResponse(200,'Postcards List',(Object)array('count'=>$postcards->count(),'data'=>$postcards));
	}
	// punch
	public function getUserPostcardNew(Request $request) {
		$postcards = DB::table('user_postcard_metadata')->orderBy('id','desc')->get();
		return $this->getResponse(200,'Postcards List',(Object)array('count'=>$postcards->count(),'data'=>$postcards));
	}
	// storeImage function
    // stores the image and the date uploaded
    public function storeImage($image_template,$save_image_template) {

        $table_name = 'user_postcard_images';
        // store image path and date in database
        $inserted = DB::table($table_name)->insert(
            [
                'user_id' => Auth::id(),
                'template_image_path' => $image_template,
				'save_image_template' =>$save_image_template
            ]
        );
		if($inserted){
			$id = DB::getPdo()->lastInsertId();
			return $id;
		}
		return "0";
    }
	
	public function postcardPreview(Request $request) {

		$message 			= 	$request->message;
        $handwriting_style 	= 	$request->style;
        $image_template 	= 	$request->template;
        $size 				= 	$request->size;
        $type 				= 	$request->type;

		// change the new line characters so they send in the curl request
        $message = str_replace("\n","\\n", $message);
		if ($request->hasFile('file')) {
            // get file info
            $image = $request->file('file');
            $extension = $image->getClientOriginalExtension();

            // check file extension
            if ($extension != 'png' && $extension != 'jpg') {
                $img_error = 'Must be a .jpg or .png file!'; // create message

				return $this->getResponse(422,$img_error,0);
            }
            // create new name and move file to appropriate folder
			$filename = 'user_upload_' . time() . '.' . $image->getClientOriginalExtension();
			$path = $image->storeAs('/templates/uploads', $filename);
            // create public link to image
			$url = $this->admin_url;
            $image_template = $url.'templates/uploads/' . $filename; // change url accordingly
        }

		 // check if image is url and store it
        if (filter_var($image_template, FILTER_VALIDATE_URL)) {
            //$this->storeImage($image_template);
        }
		$url = 'https://api.thanks.io/api/v2/preview';
        $post_fields = "{\n
                        \"message\": \"$message\",\n
                        \"handwriting_style\": $handwriting_style,\n
                        \"type\": \"postcard\"\n}";
        $request_type = 'POST';

        // get response from API
        $response = $this->curlRequest($url, $post_fields, $request_type);

        // get the image link from the response
        $response = json_decode($response, true);

		 // check if there are errors
        if (array_key_exists("errors", $response)) {
            // set status to 0;
            return $this->getResponse(422,'Something went wrong!',0);
        } else {
            // set status to 1
			$image_link = $response['data']['handwriting_image'];

			// download and save the image
			$img_id = uniqid();
			$file_path = 'images/' . $img_id . '.png';
			file_put_contents($file_path, file_get_contents($image_link));

            return $this->getResponse(200,'preview',url($file_path),1);
        }
	}

	public function curlRequest($url, $post_fields, $request_type) {
        // personal access token
        $token = $this->postcard_token;
        // initiate curl request
        $curl = curl_init();

        // build request
        curl_setopt_array($curl, array(
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => $request_type,
        CURLOPT_POSTFIELDS => $post_fields,
        CURLOPT_HTTPHEADER => array(
            "Content-Type: application/json",
            "Authorization: Bearer " . $token
        ),
        ));

        // get response
        $response = curl_exec($curl);
        $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);

        // close curl
        curl_close($curl);

        // return the response depending on which request is made
        if ($url == 'https://api.thanks.io/api/v2/sub-accounts') {
            // add responses to empty array and return array
            $response_array = array();
            array_push($response_array, $response);
            array_push($response_array, $httpcode);
            return $response_array;
        } else {
            return $response;
        }
    }

	public function getImageTemplates()
    {

		$token = $this->postcard_token;


        // initiate curl request
        $curl = curl_init();
		$url = 'https://api.thanks.io/api/v2/image-templates?items_per_page=25';
        // build request
        curl_setopt_array($curl, array(
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
        CURLOPT_HTTPHEADER => array(
            "Content-Type: application/json",
            "Authorization: Bearer " . $token
        ),
        ));

        // get response
        $response = curl_exec($curl);
        $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
		  // close curl
        curl_close($curl);

        // convert response to json object and process it
        $response = json_decode($response, true);


        // check if there are errors
        if (array_key_exists("errors", $response)) {
            // set status to 0;
            return $this->getResponse(422,'Something went wrong!');
        } else {
            // set status to 1
            return $this->getResponse(200,$response,1);
        }


	}

	public function getHandWritingStyles()
    {

		$token = $this->postcard_token;

        // initiate curl request
        $curl = curl_init();
		$url = 'https://api.thanks.io/api/v2/handwriting-styles';
        // build request
        curl_setopt_array($curl, array(
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
        CURLOPT_HTTPHEADER => array(
            "Content-Type: application/json",
            "Authorization: Bearer " . $token
        ),
        ));

        // get response
        $response = curl_exec($curl);
        $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
		  // close curl
        curl_close($curl);
        // convert response to json object and process it
        $response = json_decode($response, true);

        // check if there are errors
        if (array_key_exists("errors", $response)) {
            // set status to 0;
            return $response;
        } else {
            // set status to 1
            return $response;
        }
	}

	public function saveUserPostcardTemplate(Request $request)
    {
		$validator = Validator::make($request->all(), [
            'postcard_title' 			=> 	'required',
            'postcard_front_content'  	=> 	'required',
            'postcard_back_content'  	=> 	'required',
        ]);
        if ($validator->fails())
        {
            return $this->getResponse(422,$validator->errors()->first(),$validator->errors(),0);
        }
		$template_data=array(
			'user_id'=>Auth::id(),
			'postcard_title'=>$request->get('postcard_title'),
			'postcard_front_content'=>$request->get('postcard_front_content'),
			'postcard_back_content'=>$request->get('postcard_back_content'),
			//'template_subject'=>$request->get('template_subject'),
			//'email_preheader'=>$request->get('email_preheader'),
		);
		$savedtemplate = UserPostcardTemplate::create($template_data);

		if($savedtemplate->id){
			return $this->getResponse(200,'Postcard created successfully.');
		}
		return $this->getResponse(422,'Something went wrong!');

	}

    public function getUserPostcardTemplate(Request $request)
    {

        $data=UserPostcardTemplate::where('user_id',Auth::id())->where('status','Draft')->orderBy('id','desc')->get();

        return $this->getResponse(200,'Postcard templates',(Object)array('count'=>count($data),'data'=>$data),1);
    }

}

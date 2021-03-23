<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\MainController;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use Twilio\Rest\Client;
use Illuminate\Support\Facades\Auth;
use Validator, Response, DB;
use App\ContactLog;
use Carbon\Carbon;
use App\Model\ApiMode;
use App\Model\UserProperty;

class WebhookController extends MainController
{
	public function handleSendgridRequest() {
        // get json respons from sendgrid 
        $json = file_get_contents("php://input");
        $records = json_decode($json, true);

        // sql table information 
        $metadata = 'sendgrid_data'; 
        $customerData = 'sendgrid_test'; 

        // Loop through the records
        foreach ($records as $record) {
            // get values from json array
            if (array_key_exists('sg_event_id', $record)) { $sg_event_id = $record['sg_event_id']; } else { $sg_event_id = 'none'; }
            if (array_key_exists('smtp-id', $record)) { $smtp_id = $record['smtp-id']; } else { $smtp_id = 'none'; }
            if (array_key_exists('event', $record)) { $event = $record['event']; } else { $event = 'none'; }
            if (array_key_exists('email', $record)) { $email = $record['email']; } else { $email = 'none'; }
            if (array_key_exists('categorey', $record)) { $categorey = $record['categorey']; } else { $categorey = 'none'; }
            if (array_key_exists('timestamp', $record)) { $timestamp = $record['timestamp']; } else { $timestamp = 'none'; }
            if (array_key_exists('type', $record)) { $type = $record['type']; } else { $type = 'none'; }
            if (array_key_exists('sg_message_id', $record)) { $sg_message_id = $record['sg_message_id']; } else { $sg_message_id = 'none'; }
            if (array_key_exists('ip', $record)) { $ip = $record['ip']; } else { $ip = 'none'; }
            if (array_key_exists('response', $record)) { $response = $record['response']; } else { $response = 'none'; }
            if (array_key_exists('tls', $record)) { $tls = $record['tls']; } else { $tls = 'none'; }
            $date = date('Y-m-d H:i:s'); 

            // insert values into database 
            DB::table($metadata)->insert(
                ['date' => $date,
                'timestamp' => $timestamp,
                'type' => $type, 
                'sg_message_id' => $sg_message_id,
                'sg_event_id' => $sg_event_id, 
                'smtp_id' => $smtp_id, 
                'event' => $event, 
                'email' => $email,
                'category' => $categorey,
                'ip' => $ip,
                'response' => $response, 
                'tls' => $tls ]
            );
        }
    }
    // end of class
	
	
	/**
     * Handles a successful payment.
     *
     * @param  array  $payload
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function sendSms( Request $request )
    {
		
		$validator = Validator::make($request->all(), [ 
            'property_id'   => 'required',
            'message'       => 'required',
            'numbers'       => 'required',
        ]);   
        if ($validator->fails())
        {
            return $this->getResponse(422,$validator->errors()->first(),$validator->errors(),0);
        }
		
       // Your Account SID and Auth Token from twilio.com/console
	   
	    $data = ApiMode::where('api_name','twilio')->first();
		 // Your Account SID and Auth Token from twilio.com/console
		$twilio_sid   = env('TWILIO_SID_TEST');
		$twilio_token = env('TWILIO_TOKEN_TEST');
		$twilio_from_number  = env( 'TWILIO_TEST_FROM_NUMBER' );
		if(isset($data) && $data->mode == 1){
			$twilio_sid   = env('TWILIO_SID_LIVE');
			$twilio_token = env('TWILIO_TOKEN_LIVE');
			$twilio_from_number = env('TWILIO_FROM_NUMBER');
		}
      
        $client = new Client( $twilio_sid, $twilio_token );
		
		
		// table and database information 
        $table_name = 'twilio_test';
        $phoneColumn = 'phone_number';
		
		// get recipient phone numbers 
		//$recipients = $this->requestInfo($table_name, $phoneColumn); // recipient numbers 
		$property_id_in_arrays = explode( ',' , $request->input( 'property_id' ) );
		$numbers_in_arrays = explode( ',' , $request->input( 'numbers' ) );
		
		$user_properties = DB::table('user_property')->select('phone','status','property_id','id')->where('user_id', Auth::id())->whereIN('id',$property_id_in_arrays)->get(); 
		
		$total_user_properties = DB::table('user_property')->select('phone','status','property_id','id')->where('user_id', Auth::id())->whereIN('id',$property_id_in_arrays)->count(); 
		
		if($total_user_properties == 0){
			
			return $this->getResponse(422,'Invalid property id',0);
		}
		
		$message = $request->input( 'message' );
		$title = $request->input( 'title' );
		$save = $request->input( 'save' );
		$count = 0;
		$data = [];
		$sms_res = [];
		
		foreach( $numbers_in_arrays as $number )
		{
		   $count++;

			/* $messaged =   $client->messages->create(
				$number,
				[
				   'from' => '+12513223344',
				   'body' => $message,
				]
			); */
			try {
				// send the request to twilio using Notify API - allows up to 10,000 messages in one request 
				$messagedata = $client->messages->create(
					// Where to send a text message (your cell phone?)
					$number,
					[
						'from' 	=> 	$twilio_from_number,
						'title' => 	$title, 
						'body' 	=> 	$message,
						//"statusCallback" => "http://admin.equityfinderspro-dev.com/api/v1/receiveData"
					]
				);
				//$messagedata = $client->messages($message_response->sid)->fetch();
				
				$timestamp_upated = ($messagedata->dateUpdated->getTimestamp()) ? $messagedata->dateUpdated->getTimestamp():'';
				$timestamp_created =($messagedata->dateCreated->getTimestamp()) ? $messagedata->dateCreated->getTimestamp():'';
				$timestamp_sent = ($messagedata->dateSent) ? $messagedata->dateSent->getTimestamp():'';
				
				$response = array(
					"template_title" => $title,
					"account_sid" => $messagedata->accountSid,
					"direction" => $messagedata->direction,
					"from" => $messagedata->from,
					"to" => $messagedata->to,
					"num_segments" => $messagedata->numSegments,
					"body" => $messagedata->body,
					"date_updated" => date('Y-m-d H:i:s', $timestamp_upated),
					"uri" => $messagedata->uri,
					"api_version" => $messagedata->apiVersion,
					"date_created" =>date('Y-m-d H:i:s', $timestamp_created),
					"date_sent" => ($timestamp_sent) ? date('Y-m-d H:i:s', $timestamp_sent) : '',
					"error_code" => $messagedata->errorCode,
					"error_message" => $messagedata->errorMessage,
					"messaging_service_sid" => $messagedata->messagingServiceSid,
					"num_media" => $messagedata->numMedia,
					"price" => $messagedata->price,
					"price_unit" => $messagedata->priceUnit,
					"sid" => $messagedata->sid,
					"status" => $messagedata->status,
				);
				
				$sms_res[] = array(
					"template_title" => $title,
					"account_sid" => $messagedata->accountSid,
					"direction" => $messagedata->direction,
					"from" => $messagedata->from,
					"to" => $messagedata->to,
					"num_segments" => $messagedata->numSegments,
					"body" => $messagedata->body,
					"date_updated" => date('Y-m-d H:i:s', $timestamp_upated),
					"uri" => $messagedata->uri,
					"api_version" => $messagedata->apiVersion,
					"date_created" =>date('Y-m-d H:i:s', $timestamp_created),
					"date_sent" => ($timestamp_sent) ? date('Y-m-d H:i:s', $timestamp_sent) : '',
					"error_code" => $messagedata->errorCode,
					"error_message" => $messagedata->errorMessage,
					"messaging_service_sid" => $messagedata->messagingServiceSid,
					"num_media" => $messagedata->numMedia,
					"price" => $messagedata->price,
					"price_unit" => $messagedata->priceUnit,
					"sid" => $messagedata->sid,
					"status" => $messagedata->status,
				);
				

				$log = [];
				foreach ($user_properties as $data_prop) {
					$log[]=array(
					'user_property_id'=>$data_prop->id,
					'description'=>$message,
					'type'=>'sms',
					'user_id' => Auth::id(),
					'contact_date'=>Carbon::now(),
					'contact_time'=>Carbon::now()->toDateTimeString(),   
					'status' => $messagedata->status
					);
				}
				$contact_log = ContactLog::insert($log);
				$userProperty =  UserProperty::find($request->input( 'property_id' ));
				$userProperty->touch();
				$data[] = array('user_id'=>Auth::id(),"template_title" =>$title,"data" => json_encode($response),"sid" => $messagedata->sid);
				
			} catch (Services_Twilio_RestException $e) {
				echo $e->getMessage(); // echo any error messages
			}

			$sms_data = array('user_id'=>Auth::id(),'save'=>$save,'property_id_arr'=>json_encode($property_id_in_arrays),
			"template_title" =>$title,"data" => json_encode($sms_res),'message'=>$message);

			DB::table('tbl_sms_data')->insert($sms_data);
			
		}
		return $this->getResponse(200,$count.' messages sent!',$data);
		/* foreach($user_properties as $key => $data_prop){
		   $count++;

			
			try {
				// send the request to twilio using Notify API - allows up to 10,000 messages in one request 
				$message_response = $client->messages->create(
					// Where to send a text message (your cell phone?)
					'+1'.$data_prop->phone,	//'+918427757285',
					[
						'from' 	=> 	$twilio_number,
						'title' => 	$title, 
						'body' 	=> 	$message,
						"statusCallback" => "http://admin.equityfinderspro-dev.com/api/v1/receiveData"
					]
				);
				$messagedata = $client->messages($message_response->sid)->fetch();
				$timestamp_upated = ($messagedata->dateUpdated->getTimestamp()) ? $messagedata->dateUpdated->getTimestamp():'';
				$timestamp_created =($messagedata->dateCreated->getTimestamp()) ? $messagedata->dateCreated->getTimestamp():'';
				$timestamp_sent = ($messagedata->dateSent) ? $messagedata->dateSent->getTimestamp():'';
				
				$response = array(
					"title" => $title,
					"account_sid" => $messagedata->accountSid,
					"direction" => $messagedata->direction,
					"from" => $messagedata->from,
					"to" => $messagedata->to,
					"num_segments" => $messagedata->numSegments,
					"body" => $messagedata->body,
					"date_updated" => date('Y-m-d H:i:s', $timestamp_upated),
					"uri" => $messagedata->uri,
					"api_version" => $messagedata->apiVersion,
					"date_created" =>date('Y-m-d H:i:s', $timestamp_created),
					"date_sent" => ($timestamp_sent) ? date('Y-m-d H:i:s', $timestamp_sent) : '',
					"error_code" => $messagedata->errorCode,
					"error_message" => $messagedata->errorMessage,
					"messaging_service_sid" => $messagedata->messagingServiceSid,
					"num_media" => $messagedata->numMedia,
					"price" => $messagedata->price,
					"price_unit" => $messagedata->priceUnit,
					"sid" => $messagedata->sid,
					"status" => $messagedata->status,
				);
				$data[] = array('user_id'=>$data_prop->user_id,'property_id'=>$data_prop->id,"title" =>$title,"data" => json_encode($response),"sid" => $messagedata->sid);
				
			} catch (Services_Twilio_RestException $e) {
				echo $e->getMessage(); // echo any error messages
			}
			
		} */
		/* DB::table('tbl_sms_data')->insert($data);
		return $this->getResponse(200,$count.' messages sent!',$data);  */
	}
   
   
   
    public function callApi(Request $request) {
        // data associated with the Twilio account 
        // sid and auth token are account details; service sid is Twilio Notify detail 
        $accountSid = 'AC8a35cc9fbe346ff25d5f33b358095e0a';
        $authToken = '56c1ccb54b543d5c2bd47bf35f1d61c4'; 
        $serviceSid = 'IS49cfdf10c7964dbcf5ab41fa21376e94';

        // create the twilio client 
        $client = new Client($accountSid, $authToken); // need to create a new twilio client 

        // table and database information 
        $table_name = 'twilio_test';
        $phoneColumn = 'phone_number';

        // variables for message setup 
        $inputMessage = $request->message; // message created by user from form 
        $binding = array(); // will bind all the phone numbers together 
        $recipients = array(); 
    
        // get recipient phone numbers 
        $recipients = $this->requestInfo($table_name, $phoneColumn); // recipient numbers 

        // example of how message should be sent individually 
        // $client->messages
        //         ->create('+15613297757', // recipient of message 
        //                  [
        //                      'from' => '+12513223344', // twilio phone number
        //                      'body' => 'This is a test message!' // text message body
        //                      'statusCallback' => 'http://f38127d2.ngrok.io/twilio/public/receiveData'
        //                  ]
        //          );

        // bind recipients together to make the request to twilio 
        foreach ($recipients as $recipient) {
            $binding[] = '{"binding_type":"sms", "address":"' . $recipient . '"}';
        }
        
        // try catch to get any errors 
        try {
            // send the request to twilio using Notify API - allows up to 10,000 messages in one request 
            $notification = $client
                            ->notify->services($serviceSid)
                            ->notifications->create([
                                'toBinding' => $binding,
                                'body' => $inputMessage,
                                'sms' => ['status_callback' => 'https://27d08c28.ngrok.io/twilio/public/receiveData' ]
                            ]);
        } catch (Services_Twilio_RestException $e) {
            echo $e->getMessage(); // echo any error messages
        }

        // return the blade view with variables 
        return view('index', ['userInput' => $inputMessage]);
    }

    // requestInfo function 
    // gets data from sql database for parameters passed into it 
    public function requestInfo($table_name, $column) {
        // declare empty array
        $items = array(); 

        // database query 
        $results = DB::table($table_name)->get($column);

        // move items from std class object to array 
        foreach ($results as $result) {
            $items[] = $result->$column;
        }

        // return array 
        return $items;
    }
	
	public function handleSms() {
        // table name 
        $metadata = 'twilio_metadata';
        $customerData = 'twilio_test'; 

        // get post data
		
        $MessageSid = $_POST['MessageSid'];
        $MessageStatus = $_POST['MessageStatus'];
        $SmsSid = $_POST['SmsSid'];
        $SmsStatus = $_POST['SmsStatus'];
        $To = $_POST['To'];
        $AccountSid = $_POST['AccountSid'];
        $From = $_POST['From'];
        $ApiVersion = $_POST['ApiVersion'];
        $Date = date('Y-m-d H:i:s'); 

        // update the table with new information 
        DB::table($metadata)->insert(
            ['MessageSid' => $MessageSid, 
            'MessageStatus' => $MessageStatus, 
            'SmsSid' => $SmsSid,
            'SmsStatus' =>$SmsStatus,
            'To' => $To,
            'AccountSid' => $AccountSid,
            'From' => $From,
            'ApiVersion' => $ApiVersion,
            'Date' => $Date ]
        );

        // update the message sent flag in the customer data table 
        /* if ($SmsStatus == 'sent') {
            DB::table($customerData)->where('phone_number', $To)->increment('message_sent_flag', 1);
        } */
    }
	
	public function getSms( Request $request )
    {
		/* $sid    = env( 'TWILIO_SID' );
		$token  = env( 'TWILIO_TOKEN' );
		
		try {
            $client = new Client( $sid, $token );
        } catch (Exception $e) {
            
			return $this->getResponse(422,'Error',$e->getMessage(),0);
        }
		
		
		
		$messages = $client->messages
                   ->read([], 20);
		$response = []; */
		
		/* DB::table('tbl_sms_data')->get($data); */
		
		/* foreach ($messages as $messagedata) {
			$timestamp_upated = ($messagedata->dateUpdated->getTimestamp()) ? $messagedata->dateUpdated->getTimestamp():'';
			$timestamp_created =($messagedata->dateCreated->getTimestamp()) ? $messagedata->dateCreated->getTimestamp():'';
			$timestamp_sent = ($messagedata->dateSent) ? $messagedata->dateSent->getTimestamp():'';
			
			$response[] = array(
				"account_sid" => $messagedata->accountSid,
				"direction" => $messagedata->direction,
				"from" => $messagedata->from,
				"to" => $messagedata->to,
				"num_segments" => $messagedata->numSegments,
				"body" => $messagedata->body,
				"date_updated" => date('Y-m-d H:i:s', $timestamp_upated),
				"uri" => $messagedata->uri,
				"api_version" => $messagedata->apiVersion,
				"date_created" =>date('Y-m-d H:i:s', $timestamp_created),
				"date_sent" => ($timestamp_sent) ? date('Y-m-d H:i:s', $timestamp_sent) : '',
				"error_code" => $messagedata->errorCode,
				"error_message" => $messagedata->errorMessage,
				"messaging_service_sid" => $messagedata->messagingServiceSid,
				"num_media" => $messagedata->numMedia,
				"price" => $messagedata->price,
				"price_unit" => $messagedata->priceUnit,
				"sid" => $messagedata->sid,
				"status" => $messagedata->status,
			);
		}
		
		return $this->getResponse(200,count($response).' messages sent!',$response); */
		$data = DB::table('tbl_sms_data')->where('user_id',Auth::id())->where('save','true')->orderBy('id','desc')->get();
		
		return $this->getResponse(200,'SMS list',(Object)array('count'=>$data->count(),'data'=>$data));
	}
	
	
}
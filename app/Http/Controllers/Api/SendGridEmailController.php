<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\MainController;
use Validator, Response, DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use SendGrid\Mail\To;
use SendGrid\Mail\Cc;
use SendGrid\Mail\Bcc;
use SendGrid\Mail\From;
use SendGrid\Mail\Content;
use SendGrid\Mail\Mail;
use SendGrid\Mail\Personalization;
use SendGrid\Mail\Subject;
use SendGrid\Mail\Header;
use SendGrid\Mail\CustomArg;
use SendGrid\Mail\SendAt;
use SendGrid\Mail\Attachment;
use SendGrid\Mail\Asm;
use SendGrid\Mail\MailSettings;
use SendGrid\Mail\BccSettings;
use SendGrid\Mail\SandBoxMode;
use SendGrid\Mail\BypassListManagement;
use SendGrid\Mail\Footer;
use SendGrid\Mail\SpamCheck;
use SendGrid\Mail\TrackingSettings;
use SendGrid\Mail\ClickTracking;
use SendGrid\Mail\OpenTracking;
use SendGrid\Mail\SubscriptionTracking;
use SendGrid\Mail\Ganalytics;
use SendGrid\Mail\ReplyTo;
use Carbon\Carbon;
use App\ContactLog;
use App\Model\ApiMode;
use Illuminate\Support\Str;
use App\Model\DataTree;
use App\Model\UserProperty;

class SendGridEmailController extends MainController
{
	private $api_key;

	public function __construct() 
	{
		$data = ApiMode::where('api_name','sendgrid')->first();
		$this->api_key = env('SENDGRID_TEST_API_KEY');
		if( isset($data) && $data->mode == 1){
			$this->api_key = env('SENDGRID_LIVE_API_KEY');
		} 
        
    }
	
	function helloEmail()
	{
		try {
			$from = new From("tiffany@equityfinderspro.com");
			$subject = "Hello World from the Twilio SendGrid PHP Library";
			$to = new To("creativemamta17@gmail.com");
			$content = new Content("text/plain", "some text here");
			$mail = new Mail($from, $to, $subject, $content);

			$personalization = new Personalization();
			$personalization->addTo(new To("jpssaini007@gmail.com"));
			$mail->addPersonalization($personalization);

			//echo json_encode($mail, JSON_PRETTY_PRINT), "\n";
			return $mail;
			//return $this->getResponse(200,$mail,1);
		} catch (\Exception $e) {
			return $e->getMessage();
			//return $this->getResponse(422,$e->getMessage(),0);
		}

		return $this->getResponse(200,'done',1);
	}
	
	public function getUserEmailContentDetail($id)
    {
		if(!isset($id) || $id == '' || $id == 0){
			return $this->getResponse(422,'Invalid id!',[],0);
		}
        $data=DB::table('sendgrid_data')->where('user_id',Auth::id())->where('id',$id)->first();
       
        return $this->getResponse(200,'Email content detail',$data,1); 
    }
	
    public function getUserEmailContent()
    {
        $count=DB::table('sendgrid_data')->where('user_id',Auth::id())->where('save',1)->count();
        $data=DB::table('sendgrid_data')->select('id','unique_index','user_id','save','subject','message','template_title')->where('user_id',Auth::id())->where('save',1)->groupBy('unique_index')->orderBy('id','desc')->get();
		
		
        return $this->getResponse(200,'Email Content Listing',(Object)array('count'=>$count,'data'=>$data)); 
    }
	
	public function sendTestEmail(Request $request) {
		$validator = Validator::make($request->all(), [
            'email'       => 'required',
            'message'     => 'required',
			'subject'     => 'required',
        ]);   
        if ($validator->fails())
        {
            return $this->getResponse(422,$validator->errors()->first(),$validator->errors(),0);
        }
		$items = array();
		$apiKey = $this->api_key ;

		$userInput = array();
		 // get input from form
        $userInput['subject'] 		= 	$request->subject ? $request->subject : 'Subject goes here';
		
        $userInput['message'] 		= 	$request->message;
		
		$userInput['pre_header']	= 	$request->pre_header ? $request->pre_header : '';
		
		$name = substr($request->email, 0, strpos($request->email, '@'));
        $items[$request->email] = $name;
		
		$request_body = $this->nonCustomEmails($userInput,$items);
		
        $sg = new \SendGrid($apiKey);

        try {
            $response = $sg->client->mail()->send()->post($request_body);
			
			return $this->getResponse(200,'Mail sent',1);
        } catch (Exception $e) {
           
			return $this->getResponse(422,'Error',$e->getMessage(),0);
        }
	}
	
    // callApi function
    public function sendEmailProspects(Request $request) {
		
		$validator = Validator::make($request->all(), [ 
            'property_id'   => 'required',
            'subject'       => 'required',
            'content'       => 'required',
            'record_type'   => 'required',
        ]);   
        if ($validator->fails())
        {
            return $this->getResponse(422,$validator->errors()->first(),$validator->errors(),0);
        }
        // sendgrid API key
       // $apiKey = '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';
        $apiKey = $this->api_key ;
		
		$record_type = $request->get('record_type');
        // variable declarations
        $table_name = 'sendgrid_data';
       
        $tos = array(); // array of 'to' emails to send to
        $userInput = array();
        $databaseEmails = array();
        $databaseNames = array();
		
        // get input from form
        $userInput['subject'] 		= 	$request->subject ? $request->subject : 'Subject goes here';
		
        $userInput['message'] 		= 	$request->content;
		
		$userInput['pre_header']	= 	$request->pre_header ? $request->pre_header : '';
		
		$userInput['title']			= 	$request->title ? $request->title : '';
		
		$userInput['template_json']	= 	$request->template_json ? json_encode($request->get('template_json')) : null;
		
		$items = array();
        // get values from database
		$property_id_in_arrays = explode( ',' , $request->input( 'property_id' ) );
		/* $user_properties = DB::table('user_property')->select('email','user_id','id as property_id',DB::raw('(CASE WHEN email <> "" THEN  email ELSE email END) as subject'),DB::raw('(CASE WHEN email <> "" THEN  email ELSE email END) as message'),DB::raw('(CASE WHEN email <> "" THEN  "'.Carbon::now().'" ELSE "'.Carbon::now().'" END) as date'))->where('user_id', Auth::id())->whereIN('id',$property_id_in_arrays)->get();  */
		
		
		
		$total_user_properties = DB::table('user_property')->where('user_id', Auth::id())->whereIN('id',$property_id_in_arrays)->count(); 
		if($total_user_properties == 0){
			
			return $this->getResponse(422,'Properties do not exist',0);
		}
		
		// move items from std class object to array
		$dataProp = [];
		$data = [];
		$log = [];
		$unique_id = Str::random(3);
		$propertiesWithEmail = [];
		if($record_type=='datatree'){
			
				$user_properties = UserProperty::join('datatree','datatree.id','=','user_property.property_id')
				->select('user_property.user_id','APNFormatted','user_property.email','user_property.id as property_id',
				'MailHouseNumber','MailCity',DB::raw('(CASE WHEN LENGTH(SitusZipCode) = 4 THEN  CONCAT(\'0\',SitusZipCode) ELSE SitusZipCode END) as zip'),
				'SitusHouseNumber','SitusStreetName','SitusMode','Owner1FirstName as firstname','OwnerLastname1 as lastname','SitusCity as city',
				'SitusState as state')
				->where('user_property.email','<>','')
				->where('property_type','datatree')
				->where('user_id', Auth::id())
				->whereIN('user_property.id',$property_id_in_arrays)->get();
				foreach ($user_properties as $result) {
					/* if($result->email == ""){
						
						$result->email = 'creativemamta17@gmail.com';
					} */
					$namefull= $result->firstname.' '.$result->lastname;
					$name = $namefull ? $namefull : substr($result->email, 0, strpos($result->email, '@'));
					$items[$result->email] = $name;
					$log[]=array(
						'user_property_id'=>$result->property_id,
						'description'=>$userInput['subject'],
						'type'=>'email',
						'user_id' => Auth::id(),
						'contact_date'=>Carbon::now(),
						'contact_time'=>Carbon::now()->toDateTimeString(),   
						'status' => 'sent'
					);
					$address  = $result->SitusHouseNumber." ".$result->SitusStreetName." ".$result->SitusMode." ".$result->city." ".$result->state." ".$result->zip;
					$dataProp[] = array('apn'=>$result->APNFormatted,'name'=>$name,'address'=>$address,'email' =>$result->email,'user_id'=>$result->user_id,
					'property_id' =>$result->property_id,'email' =>$result->email );
					
					$data[] = array('email' =>$result->email,'user_id'=>$result->user_id,'property_id' =>$result->property_id ,
					'message' =>$userInput['message'],'subject' =>$userInput['subject'],'template_title' =>$userInput['title'],
					'email_preheader' =>$userInput['pre_header'],'template_json' =>$userInput['template_json'],'date' =>Carbon::now(),
					'save'=>$request->save,'unique_index'=>$unique_id);
					array_push($propertiesWithEmail,$result->property_id);
				}
			
		}
		if($record_type=='import'){
			
				$user_properties = UserProperty::select('user_id','apn as APNFormatted','email','user_property.id as property_id',
				DB::raw('(CASE WHEN LENGTH(zip) = 4 THEN  CONCAT(\'0\',zip) ELSE zip END) as zip','address'),
				'firstname','lastname','city','state')
				->where('user_property.email','<>','')
				->where('user_id', Auth::id())
				->where('property_type','import')
				->whereIN('user_property.id',$property_id_in_arrays)
				->get();
				foreach ($user_properties as $result) {
					/* if($result->email == ""){
						
						$result->email = 'creativemamta17@gmail.com';
					} */
					$namefull= $result->firstname.' '.$result->lastname;
					$name = $namefull ? $namefull : substr($result->email, 0, strpos($result->email, '@'));
					$items[$result->email] = $name;
					$log[]=array(
						'user_property_id'=>$result->property_id,
						'description'=>$userInput['subject'],
						'type'=>'email',
						'user_id' => Auth::id(),
						'contact_date'=>Carbon::now(),
						'contact_time'=>Carbon::now()->toDateTimeString(),   
						'status' => 'sent'
					);
					$address  = $result->address;
					$dataProp[] = array('apn'=>$result->APNFormatted,'name'=>$name,'address'=>$address,'email' =>$result->email,'user_id'=>$result->user_id,
					'property_id' =>$result->property_id);
					
					$data[] = array('email' =>$result->email,'user_id'=>$result->user_id,'property_id' =>$result->property_id ,
					'message' =>$userInput['message'],'subject' =>$userInput['subject'],'template_title' =>$userInput['title'],
					'email_preheader' =>$userInput['pre_header'],'template_json' =>$userInput['template_json'],'date' =>Carbon::now(),
					'save'=>$request->save,'unique_index'=>$unique_id);
					array_push($propertiesWithEmail,$result->property_id);
				}
			
		}
		
		$items['creativecruncy@gmail.com'] = 'Crucny';
		$items['ayyalur.shiresha@gmail.com'] = 'shiresha';
		$items['pawan@creativebuffer.com'] = 'pawan';
		
        $toEmails = $items;
		
		$request_body = $this->sendMultipleCustomizedEmailsEdit($dataProp, $toEmails, $userInput);

        // call to send function
        //$request_body = $this->nonCustomEmails($userInput,$toEmails);

        $sg = new \SendGrid($apiKey);

        try {
			$contact_log = ContactLog::insert($log);
            $response = $sg->client->mail()->send()->post($request_body);
			if(!empty($propertiesWithEmail)){
				$userProperty =  UserProperty::find(implode(",",$propertiesWithEmail));
				$userProperty->touch();
			}
			
			DB::table('sendgrid_data')->insert($data);
			DB::table('sendgrid_data')->where('unique_index',$unique_id)->whereIN('property_id',$property_id_in_arrays)
			->update(array('response'=>json_encode($response)));
			$email_data = DB::table('sendgrid_data')->where('unique_index',$unique_id)->get();
			return $this->getResponse(200,'data',$propertiesWithEmail,1);
        } catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }

        
		return $this->getResponse(422,'Something went wrong',0);
    }
 function sendMultipleCustomizedEmailsEdit($dataProp, $toEmails, $userInput) {
         //  punch4 add
            $userId=Auth::user()->id;
            $data=DB::table('users')
            ->join('user_detail','user_detail.user_id','=','users.id')
            ->select('users.email','user_detail.l_name','user_detail.f_name',
            'user_detail.address','user_detail.state','user_detail.city','user_detail.phone','user_detail.country')
            ->where('users.id',$userId)
            ->first();
            $email= $data->email;
            $f_name=$data->f_name;
            $l_name=$data->l_name;
        //  end punch4 add
        // email content setup
        // $from = new From(env( 'MAIL_FROM_ADDRESS' ), env( 'MAIL_FROM_NAME' ));punch4 remove
        $from = new From($email,  ucwords($f_name.' '.$l_name));//punch4 add
        $subject = $userInput['subject'];
       // $to = new To("evander@briansoutlet.com", "Default Email from Sendgrid");
       // $content = new Content("text/plain", "some text here");
       //$mail = new Mail($from, $to, $subject, $content);
	   $mail = new \SendGrid\Mail\Mail();
        // $mail->setFrom(env( 'MAIL_FROM_ADDRESS' ), env( 'MAIL_FROM_NAME' )); punch4 remove
       
         $mail->setFrom($email, ucwords($f_name.' '.$l_name)); // punch4 add
        $personalizations = array(); // personalizations array for custom emails

        // loop to fill personalizations array
        for ($i = 0; $i < count($dataProp); $i++) {
            $personalizations[$i] = new Personalization();
            $personalizations[$i]->addTo(new To($dataProp[$i]['email'], $dataProp[$i]['name']));
            $personalizations[$i]->setSubject(new Subject($subject));
            $personalizations[$i]->addHeader(new Header("X-Test", "test")); // not visible to recipient
            $personalizations[$i]->addHeader(new Header("X-Mock", "true")); // not visible to recipient
            $personalizations[$i]->addSubstitution("%name%", ucwords($dataProp[$i]['name'])); // fills in template vars with this punch4 updated
            $personalizations[$i]->addSubstitution("%address%", $dataProp[$i]['address']); 
            $personalizations[$i]->addSubstitution("%apn%", $dataProp[$i]['apn']); 
            $personalizations[$i]->addSubstitution("%email%", $dataProp[$i]['email']); 
            $personalizations[$i]->addCustomArg(new CustomArg("type", "marketing")); // not visible to recipient - for categorization purposes
            $mail->addPersonalization($personalizations[$i]);
        }

        
        // Add content to email
        $content = new Content("text/html", "<html><body>" . $userInput['message'] . "</body></html>");
        $mail->addContent($content);


        
        // echo json_encode($mail, JSON_PRETTY_PRINT), "\n";
        return $mail;
    }

    // requestInfo function
    // gets emails from database
    public function requestInfo($table_name, $column) {
        // empty array
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

    // sendMultipleCustomizedEmails function 
    // sends personalized emails 
    function sendMultipleCustomizedEmails($userInput,$toEmails) {
        // email content setup
		
        $from = new From(env( 'MAIL_FROM_ADDRESS' ), env( 'MAIL_FROM_NAME' ));
        $subject = $userInput['subject'];
        
      
        $mail = new Mail(env( 'MAIL_FROM_ADDRESS' ), $toEmails, $userInput['subject'], $userInput['message']);
		$mail->addTos($toEmails);
        $personalizations = array(); // personalizations array for custom emails
		
        // loop to fill personalizations array
        for ($i = 0; $i < count($toEmails); $i++) {
            $personalizations[$i] = new Personalization();
            $personalizations[$i]->addTo(new To($emails[$i], $names[$i]));
            $personalizations[$i]->setSubject(new Subject($subject));
            $personalizations[$i]->addSubstitution("%name%", $names[$i]); // fills in template vars with this
            $personalizations[$i]->addCustomArg(new CustomArg("type", "marketing")); // not visible to recipient - for categorization purposes
			$personalization0->addCc(new Cc("pawan@creativebuffer.com", "Pawan"));
			$personalization0->addCc(new Bcc("crativecruncy@gmail.com", "Cruncy Creative"));
            $mail->addPersonalization($personalizations[$i]);
        }

        // Example of creating a personalization with all fields added
        // $personalization0 = new Personalization();
        // $personalization0->addTo(new To("test2@example.com", "Example User"));
        // $personalization0->addCc(new Cc("test3@example.com", "Example User"));
        // $personalization0->addCc(new Cc("test4@example.com", "Example User"));
        // $personalization0->addBcc(new Bcc("test5@example.com", "Example User"));
        // $personalization0->addBcc(new Bcc("test6@example.com", "Example User"));
        // $personalization0->setSubject(new Subject("Hello World from the Twilio SendGrid PHP Library"));
        // $personalization0->addHeader(new Header("X-Test", "test"));
        // $personalization0->addHeader(new Header("X-Mock", "true"));
        // $personalization0->addSubstitution("%name%", "Example User");
        // $personalization0->addSubstitution("%city%", "Denver");
        // $personalization0->addSubstitution("%sec1%", "%section1%");
        // $personalization0->addCustomArg(new CustomArg("user_id", "343"));
        // $personalization0->addCustomArg(new CustomArg("type", "marketing"));
        // $personalization0->setSendAt(new SendAt(1443636843)); // must have batch id to use sendAt; ALSO sendAt time must be in Unix time
        // $mail->addPersonalization($personalization0);


        // Add content to email
        $content = new Content("text/html", "<html><body>" . $userInput['message'] . "</body></html>");
        $mail->addContent($content);

        

        # This must be a valid [batch ID](https://sendgrid.com/docs/API_Reference/SMTP_API/scheduling_parameters.html) to work
        # $mail->setBatchID("sendgrid_batch_id");

        $mail->addSection("%section1%", "Substitution Text for Section 1");
        $mail->addSection("%section2%", "Substitution Text for Section 2");

        

        // setting options for your email
        $mail_settings = new MailSettings();

        // BCC settings
        $bcc_settings = new BccSettings();
        $bcc_settings->setEnable(false);
        // $bcc_settings->setEmail("test@example.com");
        $mail_settings->setBccSettings($bcc_settings);

        $sandbox_mode = new SandBoxMode();
        $sandbox_mode->setEnable(false);
        $mail_settings->setSandboxMode($sandbox_mode);


        // echo json_encode($mail, JSON_PRETTY_PRINT), "\n";
        return $mail;
    }

    // nonCustomEmails function 
    // example of how to send multiple non custom emails
    public function nonCustomEmails($userInput,$toEmails) {
        // api key
       
        // get values from database
         $databaseEmails = array('creativemamta17@gmail.com');
        $toNames = array('mamta12','mamta1234');
        //setup sendgrid email
        $email = new \SendGrid\Mail\Mail();
        $email->setFrom(env( 'MAIL_FROM_ADDRESS' ), env( 'MAIL_FROM_NAME' ));
 // loop to creat associate array from the two arrays
       // print_r($toEmails); 
		/* $toEmails[0] = 'creativemamta17@gmail.com';
		foreach(array_combine($toEmails, $databaseEmails) as $emails => $names) {
            $tos[$emails] = $names;
        }
		$emsls_ro =  implode(",",array_values($toEmails)); */
		//die;
        // create the email
        $email->addTos($toEmails);
        $email->setSubject($userInput['subject']." ".$userInput['pre_header']);
        // $email->addContent("text/plain", "This is a test message"); // must add text/plain in front of your string
		
	   $email->addContent(
            // add message content with html in here
            "text/html",  $userInput['message'] 
        );

        // create new sendgrid object
       return $email;
    }
    // end of class
}


// TODOS
// webhooks

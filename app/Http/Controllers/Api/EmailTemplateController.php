<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\MainController;
use Illuminate\Contracts\Database\Eloquent\Castable;
use Illuminate\Support\Facades\Mail;
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
use App\UserEmailTemplate;

class EmailTemplateController extends MainController
{
	public function saveUserEmailTemplate(Request $request)
    {
		$validator = Validator::make($request->all(), [ 
            'title' 					=> 	'required',
            'template_content'  		=> 	'required',
            'template_design_name'  	=> 	'required',
            'template_subject'  		=> 	'required'
        ]);   
        if ($validator->fails())
        {
            return $this->getResponse(422,$validator->errors()->first(),$validator->errors(),0);
        }
		
		$template_data=array(
			'user_id'=>Auth::id(),
			'template_json'=>$request->get('template_json') ? json_encode($request->get('template_json')): null ,
			'template_title'=>$request->get('title') ? $request->get('title'): '' ,
			'template_content'=>$request->get('template_content'),
			'template_designer_name'=>$request->get('template_design_name'),
			'template_subject'=>$request->get('template_subject'),
			'email_preheader'=>$request->get('email_preheader'),
		);
		
		$savedtemplate = UserEmailTemplate::create($template_data);
		
		if($savedtemplate->id){
			return $this->getResponse(200,'Email template created successfully.',$template_data,1); 
		}
		return $this->getResponse(422,'Something went wrong!');
	
	}
	
    public function getUserEmailTemplate(Request $request)
    {
		
        $data=UserEmailTemplate::where([['user_id',Auth::id()],['status','1']])->orderBy('id','desc')->get();
       
        return $this->getResponse(200,'Email templates',(Object)array('count'=>count($data),'data'=>$data),1); 
    }
	
	
}

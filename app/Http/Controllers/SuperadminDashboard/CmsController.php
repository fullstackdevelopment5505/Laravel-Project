<?php

namespace App\Http\Controllers\Superadmindashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Validator, Response, DB, Session,File;
use App\Slider;
use App\Page;
use App\Model\Membership;
use App\AboutTeam;
use App\Faq;
use App\NewsRole;
use App\User;
use Illuminate\Support\Facades\Storage;

class CmsController extends Controller
{
	public function listFaq()
    {
        $data=Faq::orderBy('id','desc')->get();
        return view('SuperadminDashboard.cms.affiliateFaqList',compact('data'));
    }
	
	public function affiliate()
    {
        $data = Page::where('deleted_at', NULL)->where('page_name', 'affiliate')->first();
		$extra_content          = [];
		if(isset($data->extra_content)){
			 $extra_content          =   json_decode($data->extra_content, true);
		}
       
		$data  = [];
		$data['banner']  = array();
	
		$data['become_affiliate_button']= isset($extra_content['become_affiliate_button']) ? $extra_content['become_affiliate_button'] : '';
		
		$data['banner']['banner_title'] = isset($extra_content['banner']['banner_title']) ? $extra_content['banner']['banner_title'] : '';
		$data['banner']['banner_content'] = isset($extra_content['banner']['banner_content']) ? $extra_content['banner']['banner_content'] : '';
		
		$data['get_started']['title'] = isset($extra_content['get_started']['title']) ? $extra_content['get_started']['title'] : '';
		$data['get_started']['description'] = isset($extra_content['get_started']['description']) ? $extra_content['get_started']['description'] : '';
		
		$data['get_started']['box']['title_1'] = isset($extra_content['get_started']['box']['title_1']) ? $extra_content['get_started']['box']['title_1'] : '';
		$data['get_started']['box']['content_1'] = isset($extra_content['get_started']['box']['content_1']) ? $extra_content['get_started']['box']['content_1'] : '';	
		$data['get_started']['box']['title_2'] = isset($extra_content['get_started']['box']['title_2']) ? $extra_content['get_started']['box']['title_2'] : '';
		$data['get_started']['box']['content_2'] = isset($extra_content['get_started']['box']['content_2']) ? $extra_content['get_started']['box']['content_2'] : '';
		$data['get_started']['box']['title_3'] = isset($extra_content['get_started']['box']['title_3']) ? $extra_content['get_started']['box']['title_3'] : '';
		$data['get_started']['box']['content_3'] = isset($extra_content['get_started']['box']['content_3']) ? $extra_content['get_started']['box']['content_3'] : '';
		
		$data['after_getstarted']['title'] = isset($extra_content['after_getstarted']['title']) ? $extra_content['after_getstarted']['title'] : '';
		$data['after_getstarted']['description'] = isset($extra_content['after_getstarted']['description']) ? $extra_content['after_getstarted']['description'] : '';
		
		$data['after_getstarted']['box']['title_1'] = isset($extra_content['after_getstarted']['box']['title_1']) ? $extra_content['after_getstarted']['box']['title_1'] : '';
		$data['after_getstarted']['box']['content_1'] = isset($extra_content['after_getstarted']['box']['content_1']) ? $extra_content['after_getstarted']['box']['content_1'] : '';
		$data['after_getstarted']['box']['title_2'] = isset($extra_content['after_getstarted']['box']['title_2']) ? $extra_content['after_getstarted']['box']['title_2'] : '';
		$data['after_getstarted']['box']['content_2'] = isset($extra_content['after_getstarted']['box']['content_2']) ? $extra_content['after_getstarted']['box']['content_2'] : '';
		$data['after_getstarted']['box']['title_3'] = isset($extra_content['after_getstarted']['box']['title_3']) ? $extra_content['after_getstarted']['box']['title_3'] : '';
		$data['after_getstarted']['box']['content_3'] = isset($extra_content['after_getstarted']['box']['content_1']) ? $extra_content['after_getstarted']['box']['content_1'] : '';
		$data['after_getstarted']['box']['title_4'] = isset($extra_content['after_getstarted']['box']['title_4']) ? $extra_content['after_getstarted']['box']['title_4'] : '';
		$data['after_getstarted']['box']['content_4'] = isset($extra_content['after_getstarted']['box']['content_4']) ? $extra_content['after_getstarted']['box']['content_4'] : '';$data['after_getstarted']['box']['title_5'] = isset($extra_content['after_getstarted']['box']['title_5']) ? $extra_content['after_getstarted']['box']['title_5'] : '';
		$data['after_getstarted']['box']['content_5'] = isset($extra_content['after_getstarted']['box']['content_5']) ? $extra_content['after_getstarted']['box']['content_5'] : '';
		$data['after_getstarted']['box']['title_6'] = isset($extra_content['after_getstarted']['box']['title_6']) ? $extra_content['after_getstarted']['box']['title_6'] : '';
		$data['after_getstarted']['box']['content_6'] = isset($extra_content['after_getstarted']['box']['content_6']) ? $extra_content['after_getstarted']['box']['content_6'] : '';
		
		$data['program_benefits']['title'] = isset($extra_content['program_benefits']['title']) ? $extra_content['program_benefits']['title'] : '';
		$data['program_benefits']['description'] = isset($extra_content['program_benefits']['description']) ? $extra_content['program_benefits']['description'] : '';
       
	   // print_r($data); die;
        return view('SuperadminDashboard.cms.affiliate',compact('data'));
    }
	
    public function popup()
    {
        $data            	=   Page::where('deleted_at', NULL)->where('page_name', 'popup')->first();
		$extra_content 		= 	[];
		if($data){
			$extra_content    =   json_decode($data->extra_content, true);
		}
        
		$data                   =   array(
            'become_member_popup_title'         =>  isset($extra_content['become_member_popup_title']) ? $extra_content['become_member_popup_title'] : '',
            'become_member_popup_content'     =>  isset($extra_content['become_member_popup_content']) ? $extra_content['become_member_popup_content'] : '',
        );
		$cookie            	=   Page::where('deleted_at', NULL)->where('page_name', 'cookie')->first();
		if($cookie){
			$cookie_content    =   $cookie->page_content;
		}else{
			
			$cookie_content = '';
		}
		$session            	=   Page::where('deleted_at', NULL)->where('page_name', 'session')->first();
		if($session){
			$session_content    =   $session->page_content;
			$session_title    =   $session->page_title;
		}else{
			
			$session_content = '';
			$session_title = '';
		}
        return view('SuperadminDashboard.cms.popup',compact('data','cookie_content','session_content','session_title'));
    }
	
	
    public function saveFaq(Request $request)
    {
		//print_r($request->all()); die;
		
		$validator = Validator::make($request->all(), [
            'question' => 'required',
            'answer' => 'required',
        ]);
		
		if ($validator->passes()) {
            
            
            $data=array(
                'question'=> $request->get('question'),
                'answer'=> $request->get('answer'),
                'date'=> now(),
            );

            //echo "<pre>"; print_r($data); die;
            $faq = Faq::create($data);

            
			return response()->json(['success'=>'Added new records.']);
        }
    	return response()->json(['error'=>$validator->errors()->all()]);
       // $data=Faq::orderBy('id','desc')->get();
        //return view('SuperadminDashboard.cms.affiliateFaqList',compact('data'));
    }
	public function updateFaq(Request $request)
    {
		$validator = Validator::make($request->all(), [
            'question' => 'required',
            'answer' => 'required',
        ]);
        //echo "<pre>"; //print_r($request->all());
        if ($validator->passes()) {
			if($request->get('faq_id') > 0){
				
				 $faq    	 =   Faq::find($request->get('faq_id'));
			
				$faq->question  =   $request->get('question');
				$faq->answer  	=   $request->get('answer');
				
				$updated         =   $faq->save();
				if($updated){

					return response()->json(['success'=>'Records updated.']); 
				
				}
			}
             return response()->json(['error'=>'invalid request']);
        }
        return response()->json(['error'=>$validator->errors()->all()]);
    } 
	
	public function faq()
    {
		$data=DB::table('cms')->select('faq')->first();
        return view('SuperadminDashboard.cms.faq',compact('data'));
    }

    public function about()
    {
		$data 		= Page::where('deleted_at', NULL)->where('page_name', 'about')->first();

        //$data = DB::table('cms')->select('about')->first();
        $sliderData = Slider::where('deleted_at', NULL)->where('type', '1')->orderBy("id","desc")->get();
        return view('SuperadminDashboard.cms.about',compact('data','sliderData'));
    }
	
	public function contact()
    {
        $data = Page::where('deleted_at', NULL)->where('page_name', 'contact')->first();
        
        return view('SuperadminDashboard.cms.contact',compact('data'));
    }
	
    public function aboutSlider()
    {
        $data=DB::table('cms')->select('about')->first();
        return view('SuperadminDashboard.cms.about',compact('data'));
    }

    public function aboutTeamList()
    {
        $aboutTeams = AboutTeam::where('deleted_at', NULL)->orderBy('id','desc')->get();
        return view('SuperadminDashboard.cms.aboutTeamList',compact('aboutTeams'));
    }
	
	public function newsRoleList()
    {
        $data = NewsRole::orderBy('id','desc')->get();
        return view('SuperadminDashboard.cms.newsRole',compact('data'));
    }
	
	
	public function signUp()
    {
        $data                   =   Page::where('deleted_at', NULL)->where('page_name', 'signup')->first();
        $extra_content          =   json_decode($data->extra_content, true);
        $id =  $data->id;
        $data                   =   array(
            'heading_1'         =>  isset($extra_content['heading_1']) ? $extra_content['heading_1'] : '',
            'sub_heading_1'     =>  isset($extra_content['sub_heading_1']) ? $extra_content['sub_heading_1'] : '',
            'content_1'         =>  isset($extra_content['content_1']) ? $extra_content['content_1'] : '',
            'heading_2'         =>  isset($extra_content['heading_2']) ? $extra_content['heading_2'] : '',
            'sub_heading_2_1'   =>  isset($extra_content['sub_heading_2_1']) ? $extra_content['sub_heading_2_1'] : '',
            'content_2_1'        =>  isset($extra_content['content_2_1']) ? $extra_content['content_2_1'] : '',
            'sub_heading_2_2'   =>  isset($extra_content['sub_heading_2_2']) ? $extra_content['sub_heading_2_2'] : '',
            'content_2_2'       =>  isset($extra_content['content_2_2']) ? $extra_content['content_2_2'] : '',
            'sub_heading_2_3'   =>  isset($extra_content['sub_heading_2_3']) ? $extra_content['sub_heading_2_3'] : '',
            'content_2_3'       =>  isset($extra_content['content_2_3']) ? $extra_content['content_2_3'] : '',
        
        );
        return view('SuperadminDashboard.cms.signup',compact('data','id'));
    }
	
	public function membershipPage()
    {
       $data = Page::where('deleted_at', NULL)->where('page_name', 'membership')->first();
       $extra_content = json_decode($data->extra_content, true);
       $extra_content_data = array(
            'heading'         =>  isset($extra_content['heading']) ? $extra_content['heading'] : '',
            'sub_heading'     =>  isset($extra_content['sub_heading']) ? $extra_content['sub_heading'] : '',
            'box_title_1'     =>  isset($extra_content['box_title_1']) ? $extra_content['box_title_1'] : '',
            'box_1_content'   =>  isset($extra_content['box_1_content']) ? $extra_content['box_1_content'] : '',
            'box_image_1'     =>  isset($extra_content['box_image_1']) ? $extra_content['box_image_1'] : '',
            'box_title_2'     =>  isset($extra_content['box_title_2']) ? $extra_content['box_title_2'] : '',
            'box_2_content'   =>  isset($extra_content['box_2_content']) ? $extra_content['box_2_content'] : '',
            'box_image_2'     =>  isset($extra_content['box_image_2']) ? $extra_content['box_image_2'] : '',
            'box_title_3'     =>  isset($extra_content['box_title_3']) ? $extra_content['box_title_3'] : '',
            'box_3_content'   =>  isset($extra_content['box_3_content']) ? $extra_content['box_3_content'] : '',
            'box_image_3'     =>  isset($extra_content['box_image_3']) ? $extra_content['box_image_3'] : '',
        
        );
       $plan = Membership::first();
	   // echo "<pre>"; print_r($plan); die;
       //$page_metadata = json_decode($data['page_metadata'], true);
       return view('SuperadminDashboard.cms.membership',compact('data', 'plan', 'extra_content_data'));
    }
	
	public function saveNewsRole(Request $request)
    { 
		$validator = Validator::make($request->all(), [
            'role' => 'required'
        ]);

        if ($validator->passes()) {
            
            
            $data=array(
                'role'=> $request->get('role'),
            );

            //echo "<pre>"; print_r($data); die;
            $roledata = NewsRole::create($data);

            
			return response()->json(['success'=>'Added new records.']);
        }
    	return response()->json(['error'=>$validator->errors()->all()]);
	}
	
	
	public function updateNewsRole(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'role' => 'required'
        ]);
        //echo "<pre>"; //print_r($request->all());
        if ($validator->passes()) {
            $newsrole    	 =   NewsRole::find($id);
			
            $newsrole->role  =   request('role');
            
            $updated         =   $newsrole->save();
            if($updated){

                return response()->json(['success'=>'Records updated.']); 
            
            }
        }
        return response()->json(['error'=>$validator->errors()->all()]);
    }
	
    public function store(Request $request)
    { 
		
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'phone_number' => 'required',
            'email' => 'required|email|unique:tbl_about_teams',
            'status' => 'required',
            'designation' => 'required'
        ]);
      //  echo "<pre>"; print_r($request->all()); die;
        if ($validator->passes()) {
            $upld_profile_image = '';
            $upld_header_image = '';
            if ($request->hasFile('profile_image')) {
               
                $upld_profile_image = $request->file('profile_image')->store('profile_image');
               
            }
            if ($request->hasFile('header_image')) {
               
                $upld_header_image = $request->file('header_image')->store('profile_image');
               
            }
			$phone_number = $request->get('phone_number');
			$phone_number = preg_replace('/[^0-9]/', '',  $phone_number);

            $data=array(
                'email'=> $request->get('email'),
                'name'=> $request->get('name'),
                'phone_number'=> $phone_number,
                'designation'=>$request->get('designation'),
                'description'=>$request->get('description'),
                'status'=>$request->get('status'),
                'facebook_url'=>$request->get('facebook_url'),
                'linkedin_url'=>$request->get('linkedin_url'),
                'profile_image'=>$upld_profile_image,
                'header_image'=>$upld_header_image
            );
            $team = AboutTeam::create($data);

            
			return response()->json(['success'=>'Added new records.']);
        }
    	return response()->json(['error'=>$validator->errors()->all()]);
    }
	
    public function update(Request $request)
    {
		$column =  $request->get("type");
		if($column == "affiliate"){
			$data = Page::where('deleted_at', NULL)->where('page_name', 'affiliate')->first();
			if(!isset( $data)){
				$data = array(
					'page_name'=> "affiliate"
				);
				$data = Page::create($data);
				
			}
			if($request->get("type") != ''){
				$extra_content  =   json_decode($data->extra_content, true);
				if( $request->get("section") == 'affiliate_button' ){
					
					$extra_content['become_affiliate_button']   =   $request->get("become_affiliate_button");
					
					$data->extra_content                      	=   json_encode($extra_content);
					$updated 			                      	=   $data->update(); 
				
					if($updated){

						return redirect()->back()->with(['success'=>'Update Successful ']);
					
					}else{
						return redirect()->back()->with(['error'=>'Unable to update ']);

					}
			
				}
				if( $request->get("section") == 'affiliate_banner' ){
					
					$extra_content['banner']['banner_title']    =   $request->get("banner_title");
					$extra_content['banner']['banner_content']   =   $request->get("banner_content");
					$data->extra_content                      	=   json_encode($extra_content);
					$updated 			                      	=   $data->update(); 
				
					if($updated){

						return redirect()->back()->with(['success'=>'Update Successful ']);
					
					}else{
						return redirect()->back()->with(['error'=>'Unable to update ']);

					}
			
				}
				if( $request->get("section") == 'affiliate_get_started' ){
					
				
					$extra_content['get_started']['title'] 			= $request->get("title");
					$extra_content['get_started']['description'] = $request->get("description");
					
					$extra_content['get_started']['box']['title_1'] = $request->get("title_1");
					$extra_content['get_started']['box']['content_1'] = $request->get("content_1");
					$extra_content['get_started']['box']['title_2'] = $request->get("title_2");
					$extra_content['get_started']['box']['content_2'] =$request->get("content_2");
					$extra_content['get_started']['box']['title_3'] = $request->get("title_3");
					$extra_content['get_started']['box']['content_3'] = $request->get("content_3");
					$data->extra_content                      	=   json_encode($extra_content);
					$updated 			                      	=   $data->update(); 
				
					if($updated){

						return redirect()->back()->with(['success'=>'Update Successful ']);
					
					}else{
						return redirect()->back()->with(['error'=>'Unable to update ']);

					}
			
				}
				if( $request->get("section") == 'affiliate_after_get_started' ){
					
				
					$extra_content['after_getstarted']['title'] = $request->get("title");
					$extra_content['after_getstarted']['description'] = $request->get("description");
					
					$extra_content['after_getstarted']['box']['title_1'] = $request->get("title_1");
					$extra_content['after_getstarted']['box']['content_1'] = $request->get("content_1");
					$extra_content['after_getstarted']['box']['title_2'] = $request->get("title_2");
					$extra_content['after_getstarted']['box']['content_2'] = $request->get("content_2");
					$extra_content['after_getstarted']['box']['title_3'] = $request->get("title_3");
					$extra_content['after_getstarted']['box']['content_3'] = $request->get("content_3");
					$extra_content['after_getstarted']['box']['title_4'] = $request->get("title_4");
					$extra_content['after_getstarted']['box']['content_4'] = $request->get("content_4");
					$extra_content['after_getstarted']['box']['title_5'] = $request->get("title_5");
					$extra_content['after_getstarted']['box']['content_5'] = $request->get("content_5");
					$extra_content['after_getstarted']['box']['title_6'] = $request->get("title_6");
					$extra_content['after_getstarted']['box']['content_6'] = $request->get("content_6");
					$data->extra_content                      	=   json_encode($extra_content);
					$updated 			                      	=   $data->update(); 
				
					if($updated){

						return redirect()->back()->with(['success'=>'Update Successful ']);
					
					}else{
						return redirect()->back()->with(['error'=>'Unable to update ']);

					}
			
				}
				if( $request->get("section") == 'affiliate_program_benefits' ){
					
					$extra_content['program_benefits']['title']    		=   $request->get("title");
					$extra_content['program_benefits']['description']   =   $request->get("program_benefits_description");
					$data->extra_content                      	=   json_encode($extra_content);
					$updated 			                      	=   $data->update(); 
				
					if($updated){

						return redirect()->back()->with(['success'=>'Update Successful ']);
					
					}else{
						return redirect()->back()->with(['error'=>'Unable to update ']);

					}
			
				}
			}
			
		}
		
		if($column == "popup"){
			
			if( $request->get("popup_name") == 'session_popup' ){
				$data = Page::where('deleted_at', NULL)->where('page_name', 'session')->first();
				if(!isset( $data)){
					
					$data = array(
						'page_name'=> "session",
						'page_title'=> $request->get("session_title"),
						'page_content'=> $request->get("session_content")
					);
					$created = Page::create($data);
					if($created){

						return redirect()->back()->with(['success'=>'session content added successfully']);
					
					}else{
						return redirect()->back()->with(['error'=>'Unable to update']);
		
					}
				}
				$data->page_title   =   $request->get("session_title");
				$data->page_content =   $request->get("session_content");
				$updated 			=   $data->update(); 
			
				if($updated){

					return redirect()->back()->with(['success'=>'session content Updated successfully']);
				
				}else{
					return redirect()->back()->with(['error'=>'something went wrong, please try after some time.']);

				}
			
			}
			if( $request->get("popup_name") == 'cookie_popup' ){
				$data = Page::where('deleted_at', NULL)->where('page_name', 'cookie')->first();
				if(!isset( $data)){
					
					$data = array(
						'page_name'=> "cookie",
						'page_title'=> "cookies",
						'page_content'=> $request->get("cookie_content")
					);
					$created = Page::create($data);
					if($created){

						return redirect()->back()->with(['success'=>'cookie content added successfully']);
					
					}else{
						return redirect()->back()->with(['error'=>'Unable to update']);
		
					}
				}
				$data->page_content                      		=   $request->get("cookie_content");
				$updated 			                      		=   $data->update(); 
			
				if($updated){

					return redirect()->back()->with(['success'=>'cookie content Updated successfully']);
				
				}else{
					return redirect()->back()->with(['error'=>'something went wrong, please try after some time.']);

				}
			
			}
			
			if( $request->get("popup_name") == 'become_member_popup' ){
				$data = Page::where('deleted_at', NULL)->where('page_name', 'popup')->first();
				if(!isset( $data)){
					$popup_content["become_member_popup_title"]    		=   $request->get("page_title");
					$popup_content["become_member_popup_content"]    	=   $request->get("page_content");
					$data = array(
						'page_name'=> "popup",
						'extra_content'=> json_encode($popup_content)
					);
					$created = Page::create($data);
					if($created){

						return redirect()->back()->with(['success'=>'Update Successful ']);
					
					}else{
						return redirect()->back()->with(['error'=>'Unable to update ']);
		
					}
				}
			
				$popup_content                    	 			=   json_decode($data->extra_content, true);
				$popup_content["become_member_popup_title"]     =   $request->get("page_title");
				$popup_content["become_member_popup_content"]   =   $request->get("page_content");
				$data->extra_content                      		=   json_encode($popup_content);
				$updated 			                      		=   $data->update(); 
			
				if($updated){

					return redirect()->back()->with(['success'=>'Update Successful ']);
				
				}else{
					return redirect()->back()->with(['error'=>'Unable to update ']);

				}
			
			}
		}
		if($column == "login"){
			
			$data = Page::where('deleted_at', NULL)->where('page_name', 'login')->first();
			if(!isset( $data)){
				$data=array(
					'page_name'=> "login",
					'page_title'=> $request->get('page_title'),
					'page_content'=> $request->get('page_content')
				);
				$created = Page::create($data);
				if($created){

                    return redirect()->back()->with(['success'=>'Update Successful ']);
                
                }else{
                    return redirect()->back()->with(['error'=>'Unable to update ']);
    
                }
			}
			$data->page_title 	=   $request->get("page_title");
            $data->page_content =   $request->get("page_content");
			$updated = $data->update();
			if($updated){

				return redirect()->back()->with(['success'=>'Update Successful ']);
			
			}else{
				return redirect()->back()->with(['error'=>'Unable to update ']);

			}
		}
		if($column == "privacy"){
			
			$data = DB::table('cms')->select($column)->first();
            $privacy_content = json_decode($data->privacy, true);
			if(!isset( $privacy_content)){
				$privacy_content = array();
				$privacy_content['page_title'] =   $request->get("page_title");
				$privacy_content['page_content']       =   $request->get("page_content");
				$updated = DB::table('cms')->update([$column => json_encode($privacy_content)]);
				if($updated){

                    return redirect()->back()->with(['success'=>'Update Successful ']);
                
                }else{
                    return redirect()->back()->with(['error'=>'Unable to update ']);
    
                }
			}
			$privacy_content['page_title'] =   $request->get("page_title");
            $privacy_content['page_content']       =   $request->get("page_content");
			$updated = DB::table('cms')->update([$column => json_encode($privacy_content)]);
			if($request->get("notify_users") && $request->get("notify_users") == 'on'){
				
				$policy_popup_title 	= $request->get("policy_popup_title");
				$policy_popup_content 	= $request->get("policy_popup_content");
				$policydata = Page::where('deleted_at', NULL)->where('page_name', 'privacy_policy_popup')->first();
				if(!isset( $policydata)){
					
					$data = array(
						'page_name'=> "privacy_policy_popup",
						'page_title'=> $request->get("policy_popup_title"),
						'page_content'=> $request->get("policy_popup_content")
					);
					$termspopip_saved = Page::create($data);
					
				}else{
					$policydata->page_title   =   $request->get("policy_popup_title");
					$policydata->page_content =   $request->get("policy_popup_content");
					$policypopip_saved 		  =   $policydata->update();
				}
				if($policypopip_saved ){
					User::query()->update(['privacy_policy_updated' => "0"]);
				}
				
			}
			if($updated){

				return redirect()->back()->with(['success'=>'Update Successful ']);
			
			}else{
				return redirect()->back()->with(['error'=>'Unable to update ']);

			}
		}
		if($column == "terms"){
			
			$data = DB::table('cms')->select($column)->first();
			
			
            $terms_content = json_decode($data->terms, true);
			if(!isset( $terms_content)){
				$terms_content = array();
				$terms_content['page_title'] 		=   $request->get("page_title");
				$terms_content['page_content']       =   $request->get("page_content");
				$updated = DB::table('cms')->update([$column => json_encode($terms_content)]);
				if($updated){

                    return redirect()->back()->with(['success'=>'Update Successful ']);
                
                }else{
                    return redirect()->back()->with(['error'=>'Unable to update ']);
    
                }
			}
			
			$terms_content['page_title'] 		=   $request->get("page_title");
            $terms_content['page_content']       =   $request->get("page_content");
			$updated = DB::table('cms')->update([$column => json_encode($terms_content)]);
			if($request->get("notify_users") && $request->get("notify_users") == 'on'){
				
				$terms_popup_title 		= $request->get("terms_popup_title");
				$terms_popup_content 	= $request->get("terms_popup_content");
				$termsdata = Page::where('deleted_at', NULL)->where('page_name', 'terms_popup')->first();
				if(!isset( $termsdata)){
					
					$data = array(
						'page_name'=> "terms_popup",
						'page_title'=> $request->get("terms_popup_title"),
						'page_content'=> $request->get("terms_popup_content")
					);
					$termspopip_saved = Page::create($data);
					
				}else{
					$termsdata->page_title   =   $request->get("terms_popup_title");
					$termsdata->page_content =   $request->get("terms_popup_content");
					$termspopip_saved 			=   $termsdata->update();
				}
				if($termspopip_saved ){
					User::query()->update(['accepted_terms' => "0"]);
				}
				
			}
			if($updated){
				return redirect()->back()->with(['success'=>'Content updated successfully.']);
			}else{
				return redirect()->back()->with(['error'=>'something went wrong!']);
			}
		}
		
		if( $column == "contact" ){

            $validator = Validator::make($request->all(), [
                'page_title' => 'required',
                'phone_number' => 'required',
                'page_content' => 'required',
            ]);
            if($request->get("id") !=""){
                $page = Page::where('deleted_at', NULL)->where('page_name', 'contact')->first();
                $page->page_title = $request->get('page_title');
                $page->page_content = $request->get('page_content');
                $page->page_metadata = $request->get('phone_number');
                $updated = $page->update();
                if($updated){

                    return redirect()->back()->with(['success'=>'Update Successful ']);
                
                }else{
                    return redirect()->back()->with(['error'=>'Unable to update ']);
    
                }
            }
            $data=array(
                'page_name'=> "contact",
                'page_title'=> $request->get('page_title'),
                'page_content'=> $request->get('page_content'),
                'page_metadata'=> $request->get('phone_number')
            );
            Page::create($data);
            return redirect()->back()->with(['success'=>'Update Successful ']);
        }  
		
        if( $column == "signup" ){
            $validator = Validator::make($request->all(), [
                'heading_1' => 'required',
                'sub_heading_1' => 'required',
                'content_1' => 'required',
            ]);
            if ($validator->passes()) {
                $page 				                      =   Page::find($request->get("id"));
                $signup_extra_content                     =   json_decode($page->extra_content, true);
                $signup_extra_content["heading_1"]        =   $request->get("heading_1");
                $signup_extra_content["sub_heading_1"]    =   $request->get("sub_heading_1");
                $signup_extra_content["content_1"]        =   $request->get("content_1");
                $signup_extra_content["heading_2"]        =   $request->get("heading_2");
                $signup_extra_content["sub_heading_2_1"]  =   $request->get("sub_heading_2_1");
                $signup_extra_content["content_2_1"]      =   $request->get("content_2_1");
                $signup_extra_content["sub_heading_2_2"]  =   $request->get("sub_heading_2_2");
                $signup_extra_content["content_2_2"]      =   $request->get("content_2_2");
                $signup_extra_content["sub_heading_2_3"]  =   $request->get("sub_heading_2_3");
                $signup_extra_content["content_2_3"]      =   $request->get("content_2_3");
                $page->extra_content                      =   json_encode($signup_extra_content);
                $updated 			                      =   $page->update(); 
               
                if($updated){

                    return redirect()->back()->with(['success'=>'Update Successful ']);
                
                }else{
                    return redirect()->back()->with(['error'=>'Unable to update ']);
    
                }
            }
            return redirect('superadmin/cms/'.$column)->with(['error'=>$validator->errors()->all()]);

        }
		if( $column == "about" ){
			$validator = Validator::make($request->all(), [
                'page_content' => 'required'
            ]); 
			if ($validator->passes()) {
				$page 				= 	Page::find($request->get("id"));
				$page->page_title 	= 	$request->get("page_title");
				$page->page_content = 	$request->get("page_content");
				$updated 			= 	$page->save();
		  
				if($updated){

                    return redirect()->back()->with(['success'=>'Update Successful ']);
                
                }else{
                    return redirect()->back()->with(['error'=>'Unable to update ']);
    
                }
			}
			return redirect('superadmin/cms/'.$column)->with(['error'=>$validator->errors()->all()]); 
		}
        $validator = Validator::make($request->all(), [
            'page_content' => 'required'
        ]);
       
        $page_content =  $request->get("page_content");
        $data=DB::table('cms')->select($column)->first();
       //$columnFind = DB::select("SHOW COLUMNS FROM cms LIKE '$column'");
        if ($validator->passes()) {
            DB::table('cms')
            ->update([$column => $page_content]);
      
            return redirect()->back()->with(['success'=>ucfirst($column).' content updated.'],['data'=>$data]);
        }
        
        return redirect('superadmin/cms/'.$column)->with(['error'=>$validator->errors()->all()])->with('data',$data);
       
    }

    public function updateTeam(Request $request, $id)
    {
        
            $validator =   Validator::make($request->all(), [
            'email'     =>  'required|unique:tbl_about_teams,email,'.$id,
            'name' => 'required',
            'phone_number' => 'required',
            'status' => 'required',
            'designation' => 'required'
        ]);

		//echo "<pre>"; //print_r($request->all());
        if ($validator->passes()) {
            $team                  =   AboutTeam::find($id);
			$upld_header_image = '';
            if ($request->hasFile('profile_image')) {
            
                $upld_profile_image = $request->file('profile_image')->store('profile_image');
                $team->profile_image    =   $upld_profile_image;
            }
			
			//var_dump($request->file('header_image'));
			
            if ($request->hasFile('header_image')) {
              
                 $upld_header_image = $request->file('header_image')->store('profile_image');
				 
                 $team->header_image     =   $upld_header_image;
                
            }
			
			
			$phone_number = $request->get('phone_number');
			$phone_number = preg_replace('/[^0-9]/', '',  $phone_number);
            $team->email            =   request('email');
            $team->name             =   request('name');
            $team->phone_number     =   $phone_number;
            $team->status           =   request('status');
            $team->designation      =   request('designation');
            $team->facebook_url     =   request('facebook_url');
            $team->linkedin_url     =   request('linkedin_url');
            $team->description      =   request('description');
            
            

            $updated                =   $team->save();
            if($updated){

                return response()->json(['success'=>'Records updated.']); 
            
            }
        }
        return response()->json(['error'=>$validator->errors()->all()]);
    }
    public function uploadImages(Request $request)
    {   
        request()->validate([           
            'file_slider' => 'required',
        ]);

        // $imgName = $request->file('file_slider')->getClientOriginalName();
       
        // $request->file('file_slider')->move(public_path('images'), $imgName);
        //punch5
        $cover = $request->file('file_slider');
        $extension = $cover->getClientOriginalExtension();
        Storage::disk('public')->put('images/'.$cover->getFilename().'.'.$extension,  File::get($cover));

        $sliderData=array(
           'type'   => '1',
           'position' => $request->get("position"),
		   'slide_title' => $request->get("slide_title"),
           'image' => 'storage/app/public/images/'.$cover->getFilename().'.'.$extension    
        );

        Slider::create($sliderData);
        $data=DB::table('cms')->select('about')->first();
        //return view('SuperadminDashboard.cms.about',compact('data'))->with('success','Slider image uploded');
        return redirect()->route('superadminCms.about');
    }


	public function updateMembershipContent(Request $request){
        // echo "<pre>"; print_r($request->all()); //die;
        // echo "<pre>"; print_r($request->all()); //die;
        $request_type =  $request->get("page_name");
        if($request_type == "membership"){
            $validator = Validator::make($request->all(), [
                'page_title' 		=> 'required',
                'page_content'      => 'required'
            ]);

            if ($validator->fails())
            {
                return back()->withErrors($validator->errors()->all()); 
            }  
			$page 				= 	Page::find($request->get("id"));
			$page->page_title 	= 	$request->get("page_title");
			$page->page_content = 	$request->get("page_content");
			$updated 			= 	$page->save();
           
        }
        if($request_type == "plans"){
			//echo $request->get("amount"); die;
            $validator = Validator::make($request->all(), [
                'type' 		        => 'required',
                'description'       => 'required',
                'login_users'       => 'required',
                'amount'            => 'required',
            ]);

            if ($validator->fails())
            {
                return back()->withErrors($validator->errors()->all()); 
            }  
			$amount 	= 	explode('.', $request->get("amount"));
			$amount_val = 	(int) str_replace( array(',', '$ '), array('', ''), $amount[0]);
			$plan 				= 	Membership::find($request->get("id"));
			$plan->page_title 	= 	$request->get("page_title");
			$plan->type 		= 	$request->get("type");
			$plan->login_users 	= 	$request->get("login_users");
			$plan->description 	= 	$request->get("description");
			$plan->amount 		= 	$amount_val;
			$updated 			= 	$plan->save();
        }

        if($request_type == "how-works"){

            $validator = Validator::make($request->all(), [
                'heading' 		    => 'required',
                'sub_heading'       => 'required',
                'box_title_1'       => 'required',
                'box_1_content'     => 'required',
                'box_title_2'       => 'required',
                'box_2_content'     => 'required',
                'box_title_3'       => 'required',
                'box_3_content'     => 'required',
            ]);

            if ($validator->fails())
            {
                return back()->withErrors($validator->errors()->all()); 
            }  
            $box_image_1            =       $request->get("box_image_1_old");
            $box_image_2            =       $request->get("box_image_2_old");
            $box_image_3            =       $request->get("box_image_3_old");
            if($request->file('box_image_1')){
                $imgName = $request->file('box_image_1')->getClientOriginalName();
                $request->file('box_image_1')->move(public_path('images'), $imgName);
                $box_image_1 = '/images/'.$imgName;
            }
            if($request->file('box_image_2')){
                $imgName = $request->file('box_image_2')->getClientOriginalName();
                $request->file('box_image_2')->move(public_path('images'), $imgName);
                $box_image_2 = '/images/'.$imgName;
            }
            if($request->file('box_image_3')){
                $imgName = $request->file('box_image_3')->getClientOriginalName();
                $request->file('box_image_3')->move(public_path('images'), $imgName);
                $box_image_3 = '/images/'.$imgName;
            }
            $page                                       =   Page::where('page_name', "membership")->where("id",$request->get("id"))->first();
            $extra_content                              =   json_decode($page->extra_content, true);
			$extra_content['heading']                   =   $request->get("heading");
            $extra_content['sub_heading']               =   $request->get("sub_heading");
            $extra_content['box_title_1']               =   $request->get("box_title_1");
            $extra_content['box_1_content']             =   $request->get("box_1_content");
            $extra_content['box_image_1']               =   $box_image_1;
            $extra_content['box_title_2']               =   $request->get("box_title_2");
            $extra_content['box_2_content']             =   $request->get("box_2_content");
            $extra_content['box_image_2']               =   $box_image_2;
            $extra_content['box_title_3']               =   $request->get("box_title_3");
            $extra_content['box_3_content']             =   $request->get("box_3_content");
            $extra_content['box_image_3']               =   $box_image_3;
            
            $page->extra_content                        =   json_encode($extra_content);
           // echo "<pre>"; print_r($page); die;
            $updated 			                        = 	    $page->update();    
            if($updated){

                return redirect()->back()->with(['success'=>'Update Successful ']);
            
            }else{
                return redirect()->back()->with(['error'=>'Unable to update ']);

            }
            
        }
        return redirect()->back()->with(['success'=>'Update Successful ']);
    }
	
    public function ajaxHandling(Request $request)
    {
		
		
		if ($request->get("type") == "getNewsRoleById") {
            if ( $request->id ) {
                $role = NewsRole::where('id', $request->id)->first();
                if ($role) {
                    return response()->json(['success'=>true, 'data' => $role]);
                } else {
                    return response()->json(['error'=>true, 'data' => '']);
                }    
            } else {              
                return response()->json(['error'=>true, 'data' => '']);           
            }
        }
		
		if($request->get("type") == "deleteNewsRoleById"){

            $Newsrole = NewsRole::destroy($request->id);
            return response()->json(['success'=>'Delete successfully.']);

        }
    
        if($request->get("type") == "update_status"){
            $slider = Slider::find($request->slider_id);
            $slider->status = $request->status;
            $slider->save();
            $message = "Deactivate";
            if($request->status == 1){

                $message = "Activate";
            }
            return response()->json(['success'=>'Slide '.$message.' successfully.']);

        }

        if($request->get("type") == "update_position"){
            $slider = Slider::find($request->slider_id);
            $slider->position = $request->position;
            $slider->save();
      
            return response()->json(['success'=>'position change successfully.']);

        }

        if($request->get("type") == "delete_slide"){
            $slider = Slider::find($request->slider_id)->delete();
            return response()->json(['success'=>'Slide delete successfully.']);

        }

        if($request->get("type") == "checkEmail"){
            if( $request->id ){
                $kickstart = AboutTeam::where('email', $request->email)->where('id','<>', $request->id)->get();
                if(count($kickstart) > 0)
                {
                    return "false";
                } else {
                    return "true";
                }
    
            }else{
                $email = AboutTeam::where('email', $request->email)->get();
                if(count($email) > 0)
                {
                    return "false";
                } else {
                    return "true";
                }
             }

        }
		if ($request->get("type") == "getFaqById") {
            if ( $request->id ) {
                $faq = Faq::find($request->id);
                if ($faq) {
                    return response()->json(['success'=>true, 'data' => $faq]);
                } else {
                    return response()->json(['error'=>true, 'data' => '']);
                }    
            } else {              
                return response()->json(['error'=>true, 'data' => '']);           
            }
        }
		
        if ($request->get("type") == "getTeamById") {
            if ( $request->id ) {
                $teamMem = AboutTeam::where('id', $request->id)->first();
                if ($teamMem) {
                    return response()->json(['success'=>true, 'data' => $teamMem]);
                } else {
                    return response()->json(['error'=>true, 'data' => '']);
                }    
            } else {              
                return response()->json(['error'=>true, 'data' => '']);           
            }
        }

		if($request->get("type") == "deleteFaq"){

            $faq = Faq::find($request->id)->delete();
      
            return response()->json(['success'=>'Deleted successfully.']);

        }

        if($request->get("type") == "deleteTeam"){

            $team = AboutTeam::find($request->id)->delete();
      
            return response()->json(['success'=>'Delete successfully.']);

        }

        return response()->json(['error'=>'Invalid request.']);
    }
    
	public function login()
    {
        $data = Page::where('deleted_at', NULL)->where('page_name', 'login')->first();
        if(!isset($data)){
			$data = [];
			return view('SuperadminDashboard.cms.login',compact('data'));
		}
        return view('SuperadminDashboard.cms.login',compact('data'));
    }
    public function terms(){
		$data1				=	DB::table('cms')->select('terms')->first();
		$terms_content 	= 	json_decode($data1->terms, true);
		$data 				= array(
			'page_title' =>  isset($terms_content['page_title']) ? $terms_content['page_title'] : '',
			'page_content' =>  isset($terms_content['page_content']) ? $terms_content['page_content'] : '',
		);
		$terms_popup  =   Page::where('deleted_at', NULL)->where('page_name', 'terms_popup')->first();
		if($terms_popup){
			$terms_popup_content = $terms_popup->page_content;
			$terms_popup_title   = $terms_popup->page_title;
		}else{
			
			$terms_popup_content = '';
			$terms_popup_title = '';
		}
        return view('SuperadminDashboard.cms.terms',compact('data','terms_popup_content','terms_popup_title'));
    }

    public function privacy()
    {
        $data1				=	DB::table('cms')->select('privacy')->first();
		$privacy_content 	= 	json_decode($data1->privacy, true);
		$data 				= array(
			'page_title' =>  isset($privacy_content['page_title']) ? $privacy_content['page_title'] : '',
			'page_content' =>  isset($privacy_content['page_content']) ? $privacy_content['page_content'] : '',
		);
		$privacy_popup  =   Page::where('deleted_at', NULL)->where('page_name', 'privacy_policy_popup')->first();
		if($privacy_popup){
			$policy_popup_content = $privacy_popup->page_content;
			$policy_popup_title   = $privacy_popup->page_title;
		}else{
			
			$policy_popup_content = '';
			$policy_popup_title = '';
		}
        return view('SuperadminDashboard.cms.privacy',compact('data','policy_popup_content','policy_popup_title'));
    }

    public function career()
    {
        $data=DB::table('cms')->select('career')->first();
        return view('SuperadminDashboard.cms.career',compact('data'));
    }
	
	public function home()
    {
        $data = DB::table('cms')->select('home')->first();
       
        $home_content = json_decode($data->home, true);
       
        $data1 = array(
            'home_slider_title'         =>  isset($home_content['home_slider_title']) ? $home_content['home_slider_title'] : '',
            'home_slider_conent'        =>  isset($home_content['home_slider_conent']) ? $home_content['home_slider_conent'] : '',
			'home_slider_video'         =>  isset($home_content['home_slider_video']) ? $home_content['home_slider_video'] : '',
			'home_slider_video_title'   =>  isset($home_content['home_slider_video_title']) ? $home_content['home_slider_video_title'] : '',
			'home_slider_image'    		=>  isset($home_content['home_slider_image']) ? $home_content['home_slider_image'] : '',
            'service_title_1'           =>  isset($home_content['service_title_1']) ? $home_content['service_title_1'] : '',
            'service_title_1_image'     =>  isset($home_content['service_title_1_image']) ? $home_content['service_title_1_image'] : '',
            'service_title_1_content'   =>  isset($home_content['service_title_1_content']) ? $home_content['service_title_1_content'] : '',
            'service_title_2'           =>  isset($home_content['service_title_2']) ? $home_content['service_title_2'] : '',
            'service_title_2_image'     =>  isset($home_content['service_title_2_image']) ? $home_content['service_title_2_image'] : '',
            'service_title_2_content'   =>  isset($home_content['service_title_2_content']) ? $home_content['service_title_2_content'] : '',
            'service_title_3'           =>  isset($home_content['service_title_3']) ? $home_content['service_title_3'] : '',
            'service_title_3_image'     =>  isset($home_content['service_title_3_image']) ? $home_content['service_title_3_image'] : '',
            'service_title_3_content'   =>  isset($home_content['service_title_3_content']) ? $home_content['service_title_3_content'] : '',
            'category_section_title'    =>  isset($home_content['category_section_title']) ? $home_content['category_section_title'] : '',
            'category_content'          =>  isset($home_content['category_content']) ? $home_content['category_content'] : '',
            'kickstart_section_title'   =>  isset($home_content['kickstart_section_title']) ? $home_content['kickstart_section_title'] : '',
            'kickstart_content'         =>  isset($home_content['kickstart_content']) ? $home_content['kickstart_content'] : '',
            'footer_content'            =>  isset($home_content['footer_content']) ? $home_content['footer_content'] : '',
            'footer_logo'               =>  isset($home_content['footer_logo']) ? $home_content['footer_logo'] : '',
            'fb_url'                    =>  isset($home_content['fb_url']) ? $home_content['fb_url'] : '',
            'twt_url'                   =>  isset($home_content['twt_url']) ? $home_content['twt_url'] : '',
            'pin_url'                   =>  isset($home_content['pin_url']) ? $home_content['pin_url'] : '',
            'insta_url'                 =>  isset($home_content['insta_url']) ? $home_content['insta_url'] : '',
            'linkedin_url'              =>  isset($home_content['linkedin_url']) ? $home_content['linkedin_url'] : '',
            'youtube_url'             	=>  isset($home_content['youtube_url']) ? $home_content['youtube_url'] : '',
			'footer_copyright'          =>  isset($home_content['footer_copyright']) ? $home_content['footer_copyright'] : '',
            'playstore_content'         =>  isset($home_content['playstore_content']) ? $home_content['playstore_content'] : '',
            'playstore_title'           =>  isset($home_content['playstore_title']) ? $home_content['playstore_title'] : '',
			 'ca_heading'               =>  isset($home_content['ca_heading']) ? $home_content['ca_heading'] : '',
            'counter_1'                 =>  isset($home_content['counter_1']) ? $home_content['counter_1'] : '',
            'title_1'                   =>  isset($home_content['title_1']) ? $home_content['title_1'] : '',
            'counter_2'                 =>  isset($home_content['counter_1']) ? $home_content['counter_2'] : '',
            'title_2'                   =>  isset($home_content['title_1']) ? $home_content['title_2'] : '',
            'counter_3'                 =>  isset($home_content['counter_1']) ? $home_content['counter_3'] : '',
            'title_3'                   =>  isset($home_content['title_1']) ? $home_content['title_3'] : '',
            'counter_4'                 =>  isset($home_content['counter_1']) ? $home_content['counter_4'] : '',
            'title_4'                   =>  isset($home_content['title_1']) ? $home_content['title_4'] : '',
            'counter_5'                 =>  isset($home_content['counter_1']) ? $home_content['counter_5'] : '',
            'title_5'                   =>  isset($home_content['title_1']) ? $home_content['title_5'] : '',
        );
        
        return view('SuperadminDashboard.cms.home',compact('data1'));
    }
	
	public function homePlayStoreList()
    {
        $data = DB::table('cms')->select("home")->first();
        $home_content = json_decode($data->home, true);
        $playstore_content   = isset($home_content['playstore_content']) ? $home_content['playstore_content'] : '';
        $playstore_title   = isset($home_content['playstore_title']) ? $home_content['playstore_title'] : '';

        $imagesArr = Slider::where('deleted_at', NULL)->where('type','2')->get();
		//echo "<pre>"; print_r($imagesArr); die;   
        return view('SuperadminDashboard.cms.homePlayStore',compact('playstore_content','playstore_title','imagesArr'));
    }
	
	
	public function updateHomeContent(Request $request){
        // echo "<pre>"; print_r($request->all()); die;       

        $request_type =  $request->get("type");
        $column = "home";
        if($request_type == "home_slider"){
			$data = DB::table('cms')->select($column)->first();
            $home_content = json_decode($data->home, true);
			$home_content['home_slider_title']       =   $request->get("home_slider_title");
            $home_content['home_slider_conent']      =   $request->get("home_slider_conent");
			$home_content['home_slider_video']       =   $request->get("home_slider_video");
			$home_content['home_slider_video_title'] =   $request->get("home_slider_video_title");
			$home_slider_image  			     =   $request->get("home_slider_image_old");
			if($request->file('home_slider_image')){
                //pubch5
                // $imgName = $request->file('home_slider_image')->getClientOriginalName();
                // $request->file('home_slider_image')->move(public_path('images'), $imgName);
                // $home_slider_image = '/images/'.$imgName;
                $cover = $request->file('home_slider_image');
                $extension = $cover->getClientOriginalExtension();
                Storage::disk('public')->put('images/'.$cover->getFilename().'.'.$extension,  File::get($cover));
                $home_slider_image = 'storage/app/public/images/'.$cover->getFilename().'.'.$extension;
            }
			$home_content['home_slider_image']   =   $home_slider_image;
			DB::table('cms')->update([$column => json_encode($home_content)]);
		}
		if($request_type == "home_services"){
			$service_title_1_image  =   $request->get("service_title_1_image_old");
            $service_title_2_image  =   $request->get("service_title_2_image_old");
            $service_title_3_image  =   $request->get("service_title_3_image_old");
            if($request->file('service_title_1_image')){
                // $imgName = $request->file('service_title_1_image')->getClientOriginalName();
                // $request->file('service_title_1_image')->move(public_path('images'), $imgName);
                // $service_title_1_image = '/images/'.$imgName;
                $cover = $request->file('service_title_1_image');
                $extension = $cover->getClientOriginalExtension();
                Storage::disk('public')->put('images/'.$cover->getFilename().'.'.$extension,  File::get($cover));
                $service_title_1_image =  'storage/app/public/images/'.$cover->getFilename().'.'.$extension;

            }
            if($request->file('service_title_2_image')){
                // $imgName = $request->file('service_title_2_image')->getClientOriginalName();
                // $request->file('service_title_2_image')->move(public_path('images'), $imgName);
                // $service_title_2_image = '/images/'.$imgName;
                $cover = $request->file('service_title_2_image');
                $extension = $cover->getClientOriginalExtension();
                Storage::disk('public')->put('images/'.$cover->getFilename().'.'.$extension,  File::get($cover));
                $service_title_2_image =  'storage/app/public/images/'.$cover->getFilename().'.'.$extension;
            }
            if($request->file('service_title_3_image')){
                // $imgName = $request->file('service_title_3_image')->getClientOriginalName();
                // $request->file('service_title_3_image')->move(public_path('images'), $imgName);
                // $service_title_3_image = '/images/'.$imgName;
                $cover = $request->file('service_title_3_image');
                $extension = $cover->getClientOriginalExtension();
                Storage::disk('public')->put('images/'.$cover->getFilename().'.'.$extension,  File::get($cover));
                $service_title_3_image =  'storage/app/public/images/'.$cover->getFilename().'.'.$extension;
            }
			$data = DB::table('cms')->select($column)->first();
            $home_content = json_decode($data->home, true);
			$home_content['service_title_1']         =   $request->get("service_title_1");
            $home_content['service_title_1_image']   =   $service_title_1_image;
            $home_content['service_title_1_content'] =   $request->get("service_title_1_content");
            $home_content['service_title_2']         =   $request->get("service_title_2");
            $home_content['service_title_2_image']   =   $service_title_2_image;
            $home_content['service_title_2_content'] =   $request->get("service_title_2_content");
            $home_content['service_title_3']         =   $request->get("service_title_3");
            $home_content['service_title_3_image']   =   $service_title_3_image;
            $home_content['service_title_3_content'] =   $request->get("service_title_3_content");
			DB::table('cms')->update([$column => json_encode($home_content)]);
		}
		if($request_type == "home_category"){
			$data = DB::table('cms')->select($column)->first();
            $home_content = json_decode($data->home, true);
			$home_content['category_section_title']  =   $request->get("category_section_title");
            $home_content['category_content']        =   $request->get("category_content");
			DB::table('cms')->update([$column => json_encode($home_content)]);
		}
		if($request_type == "home_kickstarter"){
			$data = DB::table('cms')->select($column)->first();
            $home_content = json_decode($data->home, true);
			$home_content['kickstart_section_title'] =   $request->get("kickstart_section_title");
            $home_content['kickstart_content']       =   $request->get("kickstart_content");
			DB::table('cms')->update([$column => json_encode($home_content)]);
		}
		if($request_type == "home_footer"){
			$footer_logo            =   $request->get("footer_logo_old");
			if($request->file('footer_logo')){
                // $imgName = $request->file('footer_logo')->getClientOriginalName();
                // $request->file('footer_logo')->move(public_path('images'), $imgName);
                // $footer_logo = '/images/'.$imgName;
                 $cover = $request->file('footer_logo');
                $extension = $cover->getClientOriginalExtension();
                Storage::disk('public')->put('images/'.$cover->getFilename().'.'.$extension,  File::get($cover));
                $footer_logo = 'storage/app/public/images/'.$cover->getFilename().'.'.$extension;
            }
			$data = DB::table('cms')->select($column)->first();
            $home_content = json_decode($data->home, true);
			$home_content["footer_content"]          =   $request->get("footer_content");
            $home_content["footer_logo"]             =   $footer_logo;
            $home_content["fb_url"]                  =   $request->get("fb_url");
            $home_content["twt_url"]                 =   $request->get("twt_url");
            $home_content["pin_url"]                 =   $request->get("pin_url");
            $home_content["insta_url"]               =   $request->get("insta_url");
            $home_content["linkedin_url"]            =   $request->get("linkedin_url");
            $home_content["youtube_url"]             =   $request->get("youtube_url");
			$home_content["footer_copyright"]        =   $request->get("footer_copyright");
			
			DB::table('cms')->update([$column => json_encode($home_content)]);
			//return redirect(url()->previous() . '#footerSection')->with(['success'=>'Content updated.']);
			return redirect()->back()->with(['success'=>'Content updated.']);
		}
      
        $data = DB::table('cms')->select($column)->first();
        $home_content = json_decode($data->home, true);
        
        $data1 = array(
            'home_slider_title'         =>  isset($home_content['home_slider_title']) ? $home_content['home_slider_title'] : '',
            'home_slider_conent'        =>  isset($home_content['home_slider_conent']) ? $home_content['home_slider_conent'] : '',
			'home_slider_video'         =>  isset($home_content['home_slider_video']) ? $home_content['home_slider_video'] : '',
			'home_slider_image'     	=>  isset($home_content['home_slider_image']) ? $home_content['home_slider_image'] : '',
			'home_slider_video_title'   =>  isset($home_content['home_slider_video_title']) ? $home_content['home_slider_video_title'] : '',
            'service_title_1'           =>  isset($home_content['service_title_1']) ? $home_content['service_title_1'] : '',
            'service_title_1_image'     =>  isset($home_content['service_title_1_image']) ? $home_content['service_title_1_image'] : '',
            'service_title_1_content'   =>  isset($home_content['service_title_1_content']) ? $home_content['service_title_1_content'] : '',
            'service_title_2'           =>  isset($home_content['service_title_2']) ? $home_content['service_title_2'] : '',
            'service_title_2_image'     =>  isset($home_content['service_title_2_image']) ? $home_content['service_title_2_image'] : '',
            'service_title_2_content'   =>  isset($home_content['service_title_2_content']) ? $home_content['service_title_2_content'] : '',
            'service_title_3'           =>  isset($home_content['service_title_3']) ? $home_content['service_title_3'] : '',
            'service_title_3_image'     =>  isset($home_content['service_title_3_image']) ? $home_content['service_title_3_image'] : '',
            'service_title_3_content'   =>  isset($home_content['service_title_3_content']) ? $home_content['service_title_3_content'] : '',
            'category_section_title'    =>  isset($home_content['category_section_title']) ? $home_content['category_section_title'] : '',
            'category_content'          =>  isset($home_content['category_content']) ? $home_content['category_content'] : '',
            'kickstart_section_title'   =>  isset($home_content['kickstart_section_title']) ? $home_content['kickstart_section_title'] : '',
            'kickstart_content'         =>  isset($home_content['kickstart_content']) ? $home_content['kickstart_content'] : '',
            'footer_content'            =>  isset($home_content['footer_content']) ? $home_content['footer_content'] : '',
            'footer_logo'               =>  isset($home_content['footer_logo']) ? $home_content['footer_logo'] : '',
            'fb_url'                    =>  isset($home_content['fb_url']) ? $home_content['fb_url'] : '',
            'twt_url'                   =>  isset($home_content['twt_url']) ? $home_content['twt_url'] : '',
            'pin_url'                   =>  isset($home_content['pin_url']) ? $home_content['pin_url'] : '',
            'insta_url'                 =>  isset($home_content['insta_url']) ? $home_content['insta_url'] : '',
            'linkedin_url'              =>  isset($home_content['linkedin_url']) ? $home_content['linkedin_url'] : '',
            'youtube_url'               =>  isset($home_content['youtube_url']) ? $home_content['youtube_url'] : '',
			'footer_copyright'          =>  isset($home_content['footer_copyright']) ? $home_content['footer_copyright'] : '',
            'playstore_content'         =>  isset($home_content['playstore_content']) ? $home_content['playstore_content'] : '',
            'playstore_title'           =>  isset($home_content['playstore_title']) ? $home_content['playstore_title'] : '',
			'ca_heading'                =>  isset($home_content['ca_heading']) ? $home_content['ca_heading'] : '',
            'counter_1'                	=>  isset($home_content['counter_1']) ? $home_content['counter_1'] : '',
            'title_1'                	=>  isset($home_content['title_1']) ? $home_content['title_1'] : '',
            'counter_2'                 =>  isset($home_content['counter_1']) ? $home_content['counter_2'] : '',
            'title_2'                	=>  isset($home_content['title_1']) ? $home_content['title_2'] : '',
            'counter_3'                 =>  isset($home_content['counter_1']) ? $home_content['counter_3'] : '',
            'title_3'                	=>  isset($home_content['title_1']) ? $home_content['title_3'] : '',
            'counter_4'                 =>  isset($home_content['counter_1']) ? $home_content['counter_4'] : '',
            'title_4'                 	=>  isset($home_content['title_1']) ? $home_content['title_4'] : '',
            'counter_5'                 =>  isset($home_content['counter_1']) ? $home_content['counter_5'] : '',
            'title_5'                	=>  isset($home_content['title_1']) ? $home_content['title_5'] : ''
        );

        if($request_type == "home_play_store"){
            $home_content["playstore_content"]       =   $request->get("playstore_content");
            $home_content["playstore_title"]         =   $request->get("playstore_title");
            DB::table('cms')->update(["home" => json_encode($home_content)]);
            return redirect()->back()->with(['success'=>ucfirst($column).' content updated.']);
        }
		if($request_type == "home_ca"){
            $home_content["ca_heading"]       =   $request->get("heading");
            $home_content["counter_1"]         =   $request->get("counter_1");
            $home_content["title_1"]         =   $request->get("title_1");
            $home_content["counter_2"]         =   $request->get("counter_2");
            $home_content["title_2"]         =   $request->get("title_2");
            $home_content["counter_3"]         =   $request->get("counter_3");
            $home_content["title_3"]         =   $request->get("title_3");
            $home_content["counter_4"]         =   $request->get("counter_4");
            $home_content["title_4"]         =   $request->get("title_4");
            $home_content["counter_5"]         =   $request->get("counter_5");
            $home_content["title_5"]         =   $request->get("title_5");
            DB::table('cms')->update(["home" => json_encode($home_content)]);
            return redirect()->back()->with(['success'=>ucfirst($column).' content updated.']);
        }
        if($request_type == "home_play_store_images"){
			
			
            $imgName = $request->file('image')->getClientOriginalName();
       
            $request->file('image')->move(public_path('images'), $imgName);

            $sliderData=array(
            'type'   => '2',
            'position' => $request->get("position"),
            'image' => '/images/'.$imgName     
            );
//echo "<pre>"; print_r($sliderData); die;   
            $slide = Slider::create($sliderData);
			
            return redirect()->back()->with(['success'=>'Content updated.']);

        }
 
        return redirect()->back()->with(['success'=>ucfirst($column).' content updated.'], [ 'data1'=> $data1]);

       //return view('SuperadminDashboard.cms.home',compact('data'));
    }
 
}

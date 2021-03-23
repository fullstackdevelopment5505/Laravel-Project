<?php

namespace App\Http\Controllers\SuperadminDashboard;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use App\Mail\MailNotify;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str; 
use App\user;
use App\Model\ApiMode;
use Validator, Response, DB, Session;
use DataTables;
use Carbon\Carbon;
use App\UserPostcardTemplate;
use App\Model\UserPostcardDesign;
use App\Notifications\PostcardDesignConfirmation;

class PostcardController extends Controller
{
	public static function sendConfirmationEmail($user_id,$type,$subject,$line,$agent_name='',$phone='')
    {
        //Retrieve the user from the database
        $user = user::find($user_id);
		
        //Auto Generate Password,Send password with welcome email. The password generated is embedded in the email
        if(isset($user)){
		
			//echo $user->email; die;
        //Here send the link with CURL with an external email API
			$data = array(
				'email' 		=> 	$user->email,
				'fullname' 		=> 	ucfirst($user->f_name),
				'subject' 		=> 	$subject,
				'agent_name' 	=> 	$agent_name,
				'phone' 		=> 	$phone,
			);
			return  $user->notify(new PostcardDesignConfirmation($data,$line)); 
        }
        return "error";
    }
	// stores the image and the date uploaded
    public function storeImage($user_id,$image_template,$save_image_template,$design_id) {

        $table_name = 'user_postcard_images';

        // store image path and date in database
        $inserted = DB::table($table_name)->insert(
            [
                'user_id' => $user_id,
                'template_image_path' => $image_template,
				'save_image_template' =>$save_image_template,
				'design_id'=>$design_id
            ]
        );
		if($inserted){
			$id = DB::getPdo()->lastInsertId();
			return $id;
		}
		return "0";
    }
	
	public function ajaxHandlingPostcard(Request $request)
    {
		if ($request->get("type") == "request_completed") {
		
			if($request->get('check_completed') == 'on'){
				$url = env('APP_ADMIN_URL');	
				if ($request->hasFile('final_image')) {
					// get file info
					$image = $request->file('final_image');
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
					// check if image is url and store it
					if (filter_var($image_template, FILTER_VALIDATE_URL)) {
						$updated = UserPostcardDesign::where('id',$request->get("id"))->update(array('completed_at'=>Carbon::now(),'status'=>'2','final_postcard_design_template'=>$image_template,'save_as_template'=>'1'));
						if($updated){
							$id = $this->storeImage($request->get("user_id"),$image_template,'1',$request->get("id"));
							if($id){
								return response()->json(['success'=>'Design request completed successfully.', 'message' => 'Design request completed successfully.']);
								
							}
						}
					}
				}
				return response()->json(['error'=>'Please upload final postcard design.', 'message' => 'Invalid request.']);
			}
			return response()->json(['error'=>'Invalid request.', 'message' => 'Invalid request.']);
		}
		if ($request->get("type") == "reject_request") {
			if($request->get("id") !="" && $request->get("id") > 0){
				$updated = UserPostcardDesign::where('id',$request->get("id"))->update(array('status'=>'3'));
				if($updated){
					$data = UserPostcardDesign::find($request->get("id"));
					$subject ='Postcard Design request confirmation.';
					$line ='Your postcard design request is rejected.';
					$this->sendConfirmationEmail($data['user_id'],'rejected',$subject,$line);
					return response()->json(['success'=>true, 'message' => 'Design request rejected successfully.']);
				}
				return response()->json(['error'=>'Invalid request.', 'message' => 'Invalid request.']);
			}
			return response()->json(['error'=>'Invalid request.', 'message' => 'Invalid request.']);
		}
		
		if ($request->get("type") == "request_accepted") {
			if($request->get("id") !="" && $request->get("id") > 0){
				$updated = UserPostcardDesign::where('id',$request->get("id"))->update(array('status'=>'1','agent_name'=>$request->get("agent_name"),'phone'=>$request->get("phone")));
				if($updated){
					$data = UserPostcardDesign::find($request->get("id"));
					$subject ='Postcard Design request confirmation.';
					$line ='Your postcard design request is accepted.';
					$agent_name = $request->get("agent_name");
					$phone      = $request->get("phone");
					$this->sendConfirmationEmail($data['user_id'],'accepted',$subject,$line,$agent_name,$phone);
					return response()->json(['success'=>true, 'message' => 'Design request accepted successfully.']);
				}
				return response()->json(['error'=>true, 'message' => 'Invalid request.']);
			}
			return response()->json(['error'=>true, 'message' => 'Invalid request.']);
		}
	}
	public function postcardDesignDetail($id)
    {
        $detail  = UserPostcardDesign::with('users.details','users.Image')->where('id',$id)->orderBy('id','desc')->first();
		$profileimage='';
		$table_name = 'user_postcard_images';
		$image_templates = DB::table($table_name)->where([['design_id',$detail->id],['save_image_template','1'],['user_id',$detail->user_id]])->get();
		
		if(isset($detail->Image)){
			
			$profileimage=$detail->Image->filename;
		}
		$address =  ''; 
		if($detail->users->details->city){
			$address .=  $detail->users->details->city.","; 
		}
		if($detail->users->details->state){
			$address .=  $detail->users->details->state.","; 
		}
		if($detail->users->details->postal){
			$address .=  $detail->users->details->postal; 
		}
		$address .= ',US';
		
        return view('SuperadminDashboard.marketing.postcardDesignDetail',compact('detail','address','profileimage','image_templates'));
    }
	
	public function requestedPostcardDesigns()
    {
        $sent_postcards = UserPostcardDesign::with('users.details')->select('id','user_id',DB::raw('DATE_FORMAT(created_at, "%d-%b-%Y") as 
		date'),'updated_at','status')->whereIn('status',['0','3'])->orderBy('id','desc')->get();
		//echo "<pre>"; print_r($sent_postcards); die;
        return view('SuperadminDashboard.marketing.requestedPostcardDesign',compact('sent_postcards'));
    }
	
	public function inProgressPostcardDesigns()
    {
        $sent_postcards = UserPostcardDesign::with('users.details','users')->select('id','user_id',
		DB::raw('DATE_FORMAT(created_at, "%d-%b-%Y") as date'),'updated_at','status')
		->where('status','1')->orderBy('id','desc')->get();
		
        return view('SuperadminDashboard.marketing.inprogressPostcardDesign',compact('sent_postcards'));
    }
	
	public function completedPostcardDesigns()
    {
        $sent_postcards = UserPostcardDesign::with('users.details')->select('id','user_id',DB::raw('DATE_FORMAT(created_at, "%d-%b-%Y %H:%i:%s") as date'),'updated_at','status')->where('status','2')->orderBy('id','desc')->get();
		
        return view('SuperadminDashboard.marketing.completedPostcardDesign',compact('sent_postcards'));
    }
	
}
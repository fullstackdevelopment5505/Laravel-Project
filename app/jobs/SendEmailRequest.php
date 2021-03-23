<?php

namespace App\Jobs;

use DB;
use App\Email;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Client;
use Carbon\Carbon;
use App\Model\PropertiesJob;
use App\Model\UserProperty;
use Illuminate\Support\Facades\Auth;
use App\Model\PropertyResultId;

class SendEmailRequest implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    protected $email; 
    public function __construct(Email $email)
    {
        $this->email = $email;
		//\Log::debug('construction');
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
		
        // get variables from controller 
        $id = $this->email->row_num; 
        $url = $this->email->url; 
        $datetree_id = $this->email->datetree_id; 
        $user_property_id = $this->email->user_property_id; 
        $job_id = $this->email->job_id; 
        $email_search_flag = $this->email->email_search_flag; 
        $email_value = $this->email->email_value; 
        $result_id = $this->email->result_id; 
		\Log::info('URL: '.$url);

        // make request to API 
       
        // convert json string to arary 
		
		
        $client = new Client();
		
		try {
			$response = $client->request('GET', $url);
			
		}
		catch(RequestException $e) {
			// bird is clearly not the word
			\Log::info('Datfinder get email request exception: '.$e->getMessage());
			$this->failed($e);
			UserProperty::where([['user_id', Auth::id()]])->where('id',$user_property_id)->update(array('job_status_email'=>'success','batch_search_email_flag'=>'1'));
			PropertiesJob::where('id',$job_id)->update(array('status'=>'failed','progress'=>$id,'email_found'=>0,'completed_at'=>Carbon::now()));
			PropertyResultId::where([['result_id',$result_id],['property_id',$datetree_id],['user_id', Auth::id()]])->update(['batch_process_email_status'=>'3']);
		}
		try {
			$result = $response->getBody()->getContents();
		}
		catch(RequestException $e) {
			// bird is clearly not the word
			//echo $this->getResponse($e->getMessage(), 503);
			\Log::info('Datfinder get email exception: '.$e->getMessage());
			$this->failed($e);
			UserProperty::where([['user_id', Auth::id()]])->where('id',$user_property_id)->update(array('job_status_email'=>'success','batch_search_email_flag'=>'1'));
			PropertiesJob::where('id',$job_id)->update(array('status'=>'failed','progress'=>$id,'email_found'=>0,'completed_at'=>Carbon::now()));
			PropertyResultId::where([['result_id',$result_id],['property_id',$datetree_id],['user_id', Auth::id()]])->update(['batch_process_email_status'=>'3']);
		}
		// convert json string to arary 
		$jsonString 	= json_decode($result, true); // decode the json string
		$result_array 	= $jsonString['datafinder']; 
		// get search-related data 
       
		$inputData 		= $result_array['input-query'];
		
		if (array_key_exists('results', $result_array)) { $resultData = $result_array['results'][0]; }
		if (!empty($resultData)) {
			if (array_key_exists('EmailAddr', $resultData)) { 
				$email_value = $resultData['EmailAddr']; 
				$EmailAddrUsable = isset($resultData['EmailAddrUsable']) ? $resultData['EmailAddrUsable']: null ;
				$urlSource = isset($resultData['urlSource']) ? $resultData['urlSource'] : null;
				$email_search_flag = 1;
				UserProperty::where([['user_id', Auth::id()]])->where('id',$user_property_id)->update(array('datafinder_json'=>$result,'email_address_usable' => $EmailAddrUsable,'url_source'=>$urlSource,'email' => $email_value,'email_search_flag'=>$email_search_flag,'job_status_email'=>'success','batch_search_email_flag'=>'1'));
				PropertiesJob::where('id',$job_id)->update(array('status'=>'success','progress'=>$id,'email_found'=>1,'completed_at'=>Carbon::now()));
				PropertyResultId::where([['result_id',$result_id],['property_id',$datetree_id],['user_id', Auth::id()]])->update(['batch_process_email_status'=>'3']);
			}
		}else{
			\Log::info("No email found.");
			UserProperty::where([['user_id', Auth::id()]])->where('id',$user_property_id)->update(array('job_status_email'=>'success','batch_search_email_flag'=>'1'));
			PropertiesJob::where('id',$job_id)->update(array('status'=>'success','progress'=>$id,'email_found'=>0,'completed_at'=>Carbon::now()));
			PropertyResultId::where([['result_id',$result_id],['property_id',$datetree_id],['user_id', Auth::id()]])->update(['batch_process_email_status'=>'3']);
		}
		
    }
	public function failed(RequestException $e)
    {
        
		 \Log::info($e);
    }

    // end of class 
}

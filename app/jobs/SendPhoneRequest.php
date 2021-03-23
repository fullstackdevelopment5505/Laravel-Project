<?php

namespace App\Jobs;

use DB;
use App\Phone;
use Illuminate\Support\Facades\Auth;
use Illuminate\Bus\Queueable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
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
use Illuminate\Queue\Events\JobFailed;
use Illuminate\Support\Facades\Queue;
use App\Model\PropertyResultId;

class SendPhoneRequest implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    protected $phone;
    public function __construct(Phone $phone)
    {
        $this->phone = $phone;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // get variables from phone object
		$id 			    =  $this->phone->row_num;
        $url 			    =  $this->phone->url;
        $user_property_id   =  $this->phone->user_property_id;
        $job_id 			=  $this->phone->job_id;
        $fullNumber 		=  $this->phone->fullNumber;
        $lineType 			=  $this->phone->lineType;
		$fullNumber2 		=  $this->phone->fullNumber2;
        $lineType2 			=  $this->phone->lineType2;
        $phone_search_flag  =  $this->phone->phone_search_flag;
		$result_id 			= $this->phone->result_id;
		$datetree_id        = $this->phone->datetree_id;
		$number2= [];
		$number1= [];
		\Log::info('url '.$url);
		$client = new Client();

		try {
			$response = $client->request('GET', $url);
			try {
				$result = $response->getBody()->getContents();
			}
			catch(RequestException $e) {
				// bird is clearly not the word
				//echo $this->getResponse($e->getMessage(), 503);
				//\Log::info('Datfinder get phone exception: '.$e->getMessage());
				$this->failed($e);

				UserProperty::where([['user_id', Auth::id()]])->where('id',$user_property_id)->update(array('job_status_phone'=>'success','batch_search_phone_flag'=>'1'));
				PropertiesJob::where('id',$job_id)->update(array('status'=>'failed','progress'=>$id,'phone_found'=>0,'completed_at'=>Carbon::now()));
				PropertyResultId::where([['result_id',$result_id],['property_id',$datetree_id],['user_id', Auth::id()]])->update(['batch_process_phone_status'=>'3']);
			}
			$jsonString 	= json_decode($result, true); // decode the json string
			$result_array 	= $jsonString['Phones'];
			$phone_search_flag= 0;
			//echo "<pre>"; print_r($result_array);
			 $count = count($result_array);
			if ($count == 1) {
				if (array_key_exists(0, $result_array)) {
					$phoneData = $result_array[0];

					if (array_key_exists('AreaCode', $phoneData)) { $areaCode = $phoneData['AreaCode']; } else { $areaCode = ''; }
					if (array_key_exists('LineType', $phoneData)) { $lineType = $phoneData['LineType']; } else { $lineType = ''; }
					if (array_key_exists('PhoneNumber', $phoneData)) { $phoneNumber = $phoneData['PhoneNumber']; } else { $phoneNumber = ''; }

					//$fullNumber = $areaCode . $phoneNumber;

					//$phone_search_flag = 1;

					if($lineType=='CellLine'){
						$fullNumber = $areaCode . $phoneNumber;
						$number1[] = $areaCode . $phoneNumber;
						$lineType2='';
						$fullNumber2='';
						$phone_search_flag = 1;
					}
					if ($lineType == 'LandLine') {
						$lineType2 = 'LandLine';
						$fullNumber2 = $areaCode . $phoneNumber;
						$number2[] = $areaCode . $phoneNumber;
						$lineType='';
						$phone_search_flag = 0;
					}
				}
			} else {

				for ($i = 0; $i < count($result_array); $i++) {
					$phoneData = $result_array[$i];
					if (array_key_exists('AreaCode', $phoneData)) { $areaCode = $phoneData['AreaCode']; } else { $areaCode = ''; }
					if (array_key_exists('LineType', $phoneData)) { $lineTypes = $phoneData['LineType']; } else { $lineTypes = ''; }
					if (array_key_exists('PhoneNumber', $phoneData)) { $phoneNumber = $phoneData['PhoneNumber']; } else { $phoneNumber = ''; }

					/* if ($lineTypes == 'CellLine') {
						$lineType = 'CellLine';
						$fullNumber = $areaCode . $phoneNumber;
						$phone_search_flag = 1;

					}
					if ($lineTypes == 'LandLine') {
						$lineType = 'LandLine';
						$fullNumber = 0;
						$phone_search_flag = 0;

					} */

					if ($lineTypes == 'CellLine') {
						$lineType = 'CellLine';
						$fullNumber = $areaCode . $phoneNumber;
						$phone_search_flag = 1;
						$number1[] = $areaCode . $phoneNumber;
					}
					if ($lineTypes == 'LandLine') {
						$lineType2 = 'LandLine';
						$fullNumber2 = $areaCode . $phoneNumber;
						$number2[] = $areaCode . $phoneNumber;
						$phone_search_flag = 0;
					}
				}
			}
			if($fullNumber>0 || !empty($number2)){
				UserProperty::where([['user_id', Auth::id()]])->where('id',$user_property_id)->update(array('accurate_append_json'=>$result,'phone' => $fullNumber,'phone_search_flag'=>$phone_search_flag,'phone2' => json_encode($number2),'phone1multiple' => json_encode($number1),'line_type2'=>$lineType2,'job_status_phone'=>'success','line_type'=>$lineType,'batch_search_phone_flag'=>'1'));
				PropertiesJob::where('id',$job_id)->update(array('status'=>'success','progress'=>$id,'phone_found'=>$phone_search_flag,'completed_at'=>Carbon::now()));
				PropertyResultId::where([['result_id',$result_id],['property_id',$datetree_id],['user_id', Auth::id()]])->update(['batch_process_phone_status'=>'3']);
			}else{

				UserProperty::where([['user_id', Auth::id()]])->where('id',$user_property_id)->update(array('job_status_phone'=>'success','batch_search_phone_flag'=>'1'));
				PropertiesJob::where('id',$job_id)->update(array('status'=>'success','progress'=>$id,'phone_found'=>$phone_search_flag,'completed_at'=>Carbon::now()));
				PropertyResultId::where([['result_id',$result_id],['property_id',$datetree_id],['user_id', Auth::id()]])->update(['batch_process_phone_status'=>'3']);
			}

		}
		catch(RequestException $e) {
			// bird is clearly not the word
			//\Log::info('Datfinder get phone request exception: '.$e->getMessage());
			$this->failed($e);
			UserProperty::where([['user_id', Auth::id()]])->where('id',$user_property_id)->update(array('job_status_phone'=>'success','batch_search_phone_flag'=>'1'));
			PropertiesJob::where('id',$job_id)->update(array('status'=>'failed','progress'=>$id,'phone_found'=>0,'completed_at'=>Carbon::now()));
			PropertyResultId::where([['result_id',$result_id],['property_id',$datetree_id],['user_id', Auth::id()]])->update(['batch_process_phone_status'=>'3']);
		}


    }

 	 public function failed(RequestException $e)
    {

		 \Log::info('Accurate Append Failed: '.$e);

    }
}

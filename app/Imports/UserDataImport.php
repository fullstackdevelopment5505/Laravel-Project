<?php

namespace App\Imports;

use App\Model\UsersUploadedData;
use App\Model\UsersUploadedDataGroup;
use Illuminate\Validation\Rule;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Validator, Response, DB, Config;
use Illuminate\Support\Facades\Auth;
use App\Model\Result;
use App\Model\PropertyResultId;
use App\Model\UserProperty;
use Carbon\Carbon;

class UserDataImport implements ToCollection, WithHeadingRow,WithValidation
{
	private $ids = [];
	private $group_name,$per_property_rate,$result_id;
	
	public function  __construct($group_name,$per_property_rate)
    {
        $this->group_name= $group_name;
        $this->per_property_rate= $per_property_rate;
    }
	public function rules(): array
	{
		return [
			'email' => 'nullable|email',
			'phone' => 'nullable|regex:/^([0-9\s\-\+\(\)]*)$/|min:10',
		];
	}
    public function collection(Collection  $rows)
    {
		
		if(count($rows)>0){
			$results = Result::create(['user_id'=>Auth::id()]);
			$results_id = $results->id;
		
		$property_row = [];
		foreach ($rows as $row) 
        {
            array_push($property_row,[
			'user_id'   => Auth::id(),
			'property_type'   =>'import',
			'result_id'   =>$results_id,
            'firstname' => $row['firstname'] ? $row['firstname'] : '',
            'lastname'  => $row['lastname'] ? $row['lastname'] : '',
            'address'   => $row['subject_property_address'] ? $row['subject_property_address'] : '',
            'unit_number'=> $row['unit_number'] ? $row['unit_number'] : '',
            'city'      => $row['city'] ? $row['city'] : '',
            'state'     => $row['state'] ? $row['state'] : '',
            'zip'       => $row['zip'] ? $row['zip'] : '',
            'email'     => $row['email'] ? $row['email'] : '',
            'phone'     => $row['phone'] ? $row['phone'] : '',
            'apn'       => $row['apn_subject_property'] ? $row['apn_subject_property'] : '',
			'mailing_address'  => $row['mailing_address'] ? $row['mailing_address'] : '',
            'mailing_unit_number'=> $row['mailing_unit_number'] ? $row['mailing_unit_number'] : '',
            'mailing_city'      => $row['mailing_city'] ? $row['mailing_city'] : '',
            'mailing_state'     => $row['mailing_state'] ? $row['mailing_state'] : '',
            'mailing_zip'       => $row['mailing_zip'] ? $row['mailing_zip'] : '',
            'email_search_flag' => $row['email'] ? 1 : 0,
            'phone_search_flag' => $row['phone'] ? 1 : 0,
			'created_at'=>Carbon::now()
            ]);
		
			//$this->ids[] = $added->id;
        }
		$inserted = UserProperty::insert($property_row);
		$this->result_id = $results_id;
		$group_name = $this->group_name;
		$per_property_rate = $this->per_property_rate;
		
		$peroperty_result_data = UserProperty::select('user_id','result_id','id as property_id','trash',
		DB::raw('(CASE WHEN result_id <> 0 THEN  "'.$group_name.'" END) as purchase_group_name'),
		DB::raw('(CASE WHEN result_id <> 0 THEN  "'.Carbon::now().'" ELSE "'.Carbon::now().'" END) as created_at'),
		DB::raw('(CASE WHEN result_id <> 0 THEN  "import"  END) as property_type'),
		DB::raw('(CASE WHEN result_id <> 0 THEN  "'.$per_property_rate.'"  END) as per_property_rate')
		)->where('result_id',$results_id)->get()->toArray();
		
		PropertyResultId::insert($peroperty_result_data);
		
		$property_ids = UserProperty::where('result_id',$results_id)->pluck('id');
		array_push($this->ids,$property_ids[0]);
		} 
		return $this->ids;
    }
	public function getRowCount(): array
    {
        return $this->ids;
    }
   
}
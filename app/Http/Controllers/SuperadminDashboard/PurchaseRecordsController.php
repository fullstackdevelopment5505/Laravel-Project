<?php

namespace App\Http\Controllers\SuperadminDashboard;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use DataTables;
use App\Model\PropertyResultId;
use DB;

class PurchaseRecordsController extends Controller
{
    

    public function purchasedRecordsList()
    {
		//echo "sadsad"; die;     
		return view('SuperadminDashboard.sale.purchasedRecordsReport');
    }  

    public static  function date_compare($a, $b)
    {
        $t1 = strtotime($a->date);
        $t2 = strtotime($b->date);
        return $t1 - $t2;
    }    


    function purchasedRecords(Request $request)
    {
		
        if($request->ajax())
        {
			// echo "sss";die;
            /* $data = DB::table('user_property')->select('user_property.created_at AS date','user_property.id AS tb_id','property_result_id.result_id'
            ,DB::raw('(CASE WHEN user_detail.f_name <> "" THEN concat(user_detail.f_name) ELSE SUBSTRING_INDEX(users.email, "@", 1) END) as name')
            ,DB::raw('count(property_result_id.result_id) as amount')
            ,DB::raw('(count(property_result_id.result_id)*20)/100 as tax'),
            DB::raw('(count(property_result_id.result_id)*80)/100 as cash'), 
            DB::raw('(CASE WHEN property_result_id.result_id !="" THEN "PRTX01"  END) as taxCode'),
             DB::raw('(CASE WHEN property_result_id.result_id !="" THEN "PRGL01"  END) as glCode'))
             ->leftJoin('property_result_id', 'user_property.property_id', '=', 'property_result_id.property_id')
             ->leftJoin('users', 'user_property.user_id', '=', 'users.id')
             ->leftJoin('user_detail', 'user_property.user_id', '=', 'user_detail.user_id')
             ->whereNotNull('property_result_id.result_id'); */
                
			
			$data = PropertyResultId::select('property_result_id.id','property_result_id.user_id','property_id','property_result_id.created_at as date','result_id','purchase_group_name',DB::raw('(CASE WHEN user_detail.f_name <> "" THEN concat(user_detail.f_name) ELSE SUBSTRING_INDEX(users.email, "@", 1) END) as name'),DB::raw('count(result_id) as total_records'),DB::raw('count(result_id) as amount'),DB::raw('(count(result_id)*20)/100 as tax'),DB::raw('(count(result_id)*80)/100 as cash'), DB::raw('(CASE WHEN result_id !="" THEN "PRTX01"  END) as taxCode'),DB::raw('(CASE WHEN result_id !="" THEN "PRGL01"  END) as glCode'),DB::raw('((result_id)*0) as total_amount'))
			->leftJoin('users', 'property_result_id.user_id', '=', 'users.id')
            ->leftJoin('user_detail', 'users.id', '=', 'user_detail.user_id');
			
			
			if($request->date_from_purchase != '' && $request->date_to_purchase !=''){
				// echo 'HERE';
				$membership_start_date_from = date('Y-m-d', strtotime(str_replace('-', '/', $request->get('date_from_purchase'))));
				$membership_start_date_to = date('Y-m-d', strtotime(str_replace('-', '/', $request->get('date_to_purchase'))));
				$data->whereBetween('property_result_id.created_at',array($membership_start_date_from. ' 00:00:00', $membership_start_date_to . ' 23:59:59'));
			}
			if($request->date_from_purchase == '' && $request->date_to_purchase !=''){
				//echo 'HERE2';
				$membership_start_date_to = date('Y-m-d', strtotime(str_replace('-', '/', $request->get('date_to_purchase'))));
				$data->where('property_result_id.created_at','<=',$membership_start_date_to . ' 23:59:59');
			}
			if($request->date_from_purchase != '' && $request->date_to_purchase ==''){
				//echo 'HERE3';
				$membership_start_date_from = date('Y-m-d', strtotime(str_replace('-', '/', $request->get('date_from_purchase'))));
				$data->where('property_result_id.created_at', '>=',$membership_start_date_from . ' 00:00:00');
			}
			$data= $data->where('trash', '0')->whereNotNull('purchase_group_name')->groupBy('result_id')->orderBy('property_result_id.id','asc')->get();

  
			
			$data1 =$data->toarray();
			$onlyAmout      =     array_column($data1, 'cash');
			 
			$tmp = 0;
			foreach($data1 as $key => $dat){
				
				$tmp = $tmp + $dat["cash"];
			   
				$data1[$key]['total_amount'] = $tmp;
				
			}
			return DataTables::of($data1)
					->addColumn('amount', function($row){
                    return "$".$row['amount'];   
                 })
                ->addColumn('total_amount', function($row){
                    return "$".$row['total_amount'];   
                 })
                 ->addColumn('tax', function($row){
                    return "$".$row['tax']; 
                 })
                 ->addColumn('cash', function($row){
                    return "$".$row['cash']; 
                 })
                /*  ->addColumn('total', function($row){
                     return "$".$row['total'];
                 }) */
                ->make(true); 
				
				
			            
        }
               
			   
			$data = PropertyResultId::select('property_result_id.id','property_result_id.user_id','property_id','property_result_id.created_at as date','result_id','purchase_group_name',DB::raw('(CASE WHEN user_detail.f_name <> "" THEN concat(user_detail.f_name) ELSE SUBSTRING_INDEX(users.email, "@", 1) END) as name'),DB::raw('count(result_id) as total_records'),DB::raw('count(result_id) as amount'),DB::raw('(count(result_id)*20)/100 as tax'),DB::raw('(count(result_id)*80)/100 as cash'), DB::raw('(CASE WHEN result_id !="" THEN "PRTX01"  END) as taxCode'),DB::raw('(CASE WHEN result_id !="" THEN "PRGL01"  END) as glCode'),DB::raw('((result_id)*0) as total_amount'))
			->leftJoin('users', 'property_result_id.user_id', '=', 'users.id')
            ->leftJoin('user_detail', 'users.id', '=', 'user_detail.user_id')
			->where('trash', '0')->whereNotNull('purchase_group_name')->groupBy('result_id')->orderBy('property_result_id.id','asc')->get();
                $data1 =$data->toarray();
			$onlyAmout      =     array_column($data1, 'cash');
			 
			$tmp = 0;
			foreach($data1 as $key => $dat){
				
				$tmp = $tmp + $dat["cash"];
			   
				$data1[$key]['total_amount'] = $tmp;
				
			}
			return DataTables::of($data1)
					->addColumn('amount', function($row){
                    return "$".$row['amount'];   
                 })
                ->addColumn('total_amount', function($row){
                    return "$".$row['total_amount'];   
                 })
                 ->addColumn('tax', function($row){
                    return "$".$row['tax']; 
                 })
                 ->addColumn('cash', function($row){
                    return "$".$row['cash']; 
                 })
                /*  ->addColumn('total', function($row){
                     return "$".$row['total'];
                 }) */
              ->make(true);  
                
    }
}

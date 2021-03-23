<?php

namespace App\Http\Controllers\Superadmindashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Deposite;
use App\Model\DataTreeItem;
use App\Model\Report;
use App\Model\PropertyResultId;
use DataTables;    
use DB;

class TotalSaleController extends Controller
{

    public function TotalSaleView()
    {
       
        return view('SuperadminDashboard.sale.totalSaleReport');
    }
    
    public static  function date_compare($a, $b)
    {
        $t1 = strtotime($a->date);
        $t2 = strtotime($b->date);
        return $t1 - $t2;
    }    
    

    function TotalSaleList(Request $request){
        $Expence=DataTreeItem::sum('amount');
		        $data3 = DB::table('vouchers_entries')
        ->select('vouchers_entries.id AS tb_id','vouchers_entries.created_at AS date',
        DB::raw('(vouchers_entries.amount) as amount'),DB::raw('(vouchers_entries.tax) as tax'),DB::raw('(vouchers_entries.rem_total) as cash'), 
        DB::raw('(CASE WHEN vouchers_entries.status="Credit" THEN "TC-07" END) as taxCode'),
        DB::raw('(CASE WHEN vouchers_entries.status="Credit" THEN "Vouchar Sale " END) as type'),
        DB::raw('(CASE WHEN vouchers_entries.status="Credit" THEN "SGL-07" END) as glCode'));
        
        if($request->date_from != '' && $request->date_to !=''){
            // echo 'HERE';
             $voucher_sale_start_date_from = date('Y-m-d', strtotime(str_replace('-', '/', $request->get('date_from'))));
             $voucher_sale_start_date_to = date('Y-m-d', strtotime(str_replace('-', '/', $request->get('date_to'))));
             $data3->whereBetween('vouchers_entries.created_at',array($voucher_sale_start_date_from. ' 00:00:00', $voucher_sale_start_date_to . ' 23:59:59'));
         }
         if($request->date_from == '' && $request->date_to !=''){
             //echo 'HERE2';
             $voucher_sale_start_date_to = date('Y-m-d', strtotime(str_replace('-', '/', $request->get('date_to'))));
             $data3->where('vouchers_entries.created_at','<=',$voucher_sale_start_date_to . ' 23:59:59');
         }
         if($request->date_from != '' && $request->date_to ==''){
             //echo 'HERE3';
             $voucher_sale_start_date_from = date('Y-m-d', strtotime(str_replace('-', '/', $request->get('date_from'))));
             $data3->where('vouchers_entries.created_at', '>=',$voucher_sale_start_date_from . ' 00:00:00');
         }

         $res3 = $data3->where('status','Credit')->get();
		 
        /* $data = DB::table('tbl_purchased_records')
        ->select('tbl_purchased_records.id AS tb_id','tbl_purchased_records.user_id','tbl_purchased_records.created_at AS date','tbl_purchased_records.report_name as type',
        DB::raw('(points_transaction.point/10) as amount'),DB::raw('((points_transaction.point/10)*20)/100 as tax'),DB::raw('((points_transaction.point/10)*80)/100 as cash'), 
        DB::raw('(CASE WHEN tbl_purchased_records.report_type="1" THEN "TC-01" WHEN tbl_purchased_records.report_type="2" THEN "TC-01" WHEN tbl_purchased_records.report_type="3" THEN "TC-01"  ELSE "TC-01" END) as taxCode'),
        DB::raw('(CASE WHEN tbl_purchased_records.report_type="1" THEN "SGL-03" WHEN tbl_purchased_records.report_type="2" THEN "SGL-02" WHEN tbl_purchased_records.report_type="3" THEN "SGL-03"  ELSE "SGL-04" END) as glCode'))
        ->Join('points_transaction', 'tbl_purchased_records.point_id', '=', 'points_transaction.id')
        ->Join('user_property', 'tbl_purchased_records.user_prop_id', '=', 'user_property.id')
        ->Join('datatree', 'tbl_purchased_records.property_id', '=', 'datatree.PropertyId'); */
        
		
		$data = DB::table('tbl_purchased_records')->select('tbl_purchased_records.user_id','tbl_purchased_records.report_name AS type','tbl_purchased_records.created_at AS date','points_transaction.amount',DB::raw('((points_transaction.amount)*20)/100 as tax'),DB::raw('((points_transaction.amount)*80)/100 as cash'),DB::raw('(CASE WHEN tbl_purchased_records.report_type="1" THEN "TC-01" WHEN tbl_purchased_records.report_type="2" THEN "TC-01" WHEN tbl_purchased_records.report_type="3" THEN "TC-01"  ELSE "TC-01" END) as taxCode'),
        DB::raw('(CASE WHEN tbl_purchased_records.report_type="1" THEN "SGL-03" WHEN tbl_purchased_records.report_type="2" THEN "SGL-02" WHEN tbl_purchased_records.report_type="3" THEN "SGL-03"  ELSE "SGL-04" END) as glCode'))
		->Join('users', 'tbl_purchased_records.user_id', '=', 'users.id')
		->Join('user_detail', 'users.id', '=', 'user_detail.user_id')
		->Join('datatree', 'tbl_purchased_records.property_id', '=', 'datatree.PropertyId')
		->Join('points_transaction', 'tbl_purchased_records.point_id', '=', 'points_transaction.id');
		
		
		
		
        if($request->date_from != '' && $request->date_to !=''){
            // echo 'HERE';
             $purchased_records_start_date_from = date('Y-m-d', strtotime(str_replace('-', '/', $request->get('date_from'))));
             $purchased_records_start_date_to = date('Y-m-d', strtotime(str_replace('-', '/', $request->get('date_to'))));
             $data->whereBetween('tbl_purchased_records.created_at',array($purchased_records_start_date_from. ' 00:00:00', $purchased_records_start_date_to . ' 23:59:59'));
         }
         if($request->date_from == '' && $request->date_to !=''){
             //echo 'HERE2';
             $purchased_records_start_date_to = date('Y-m-d', strtotime(str_replace('-', '/', $request->get('date_to'))));
             $data->where('tbl_purchased_records.created_at','<=',$purchased_records_start_date_to . ' 23:59:59');
         }
         if($request->date_from != '' && $request->date_to ==''){
             //echo 'HERE3';
             $purchased_records_start_date_from = date('Y-m-d', strtotime(str_replace('-', '/', $request->get('date_from'))));
             $data->where('tbl_purchased_records.created_at', '>=',$purchased_records_start_date_from . ' 00:00:00');
         }


        // $res = $data->where('user_property.trash','0')->orderBy('tbl_purchased_records.created_at','desc')->get();
         $res = $data->orderBy('tbl_purchased_records.created_at','desc')->get();
       
        
        
        
        $data1 = DB::table('tbl_membership')
        ->select('tbl_membership.created_at AS date','tbl_membership.id AS tb_id',DB::raw('(CASE WHEN tbl_membership.membership_type="1" THEN "Membership" ELSE "Membership" END) as type'),DB::raw('tbl_deposite.amount as amount'), DB::raw('((tbl_deposite.amount)*20)/100 as tax'),DB::raw('((tbl_deposite.amount)*80)/100 as cash'), DB::raw('(CASE WHEN tbl_membership.membership_type="1" THEN "TC-02" END) as taxCode'),
         DB::raw('(CASE WHEN tbl_membership.membership_type="1" THEN "SGL-05" END) as glCode'))
        ->Join('tbl_deposite', 'tbl_membership.trans_id', '=', 'tbl_deposite.id');
       
        if($request->date_from != '' && $request->date_to !=''){
            // echo 'HERE';
             $membership_start_date_from = date('Y-m-d', strtotime(str_replace('-', '/', $request->get('date_from'))));
             $membership_start_date_to = date('Y-m-d', strtotime(str_replace('-', '/', $request->get('date_to'))));
             $data1->whereBetween('tbl_membership.created_at',array($membership_start_date_from. ' 00:00:00', $membership_start_date_to . ' 23:59:59'));
         }
         if($request->date_from == '' && $request->date_to !=''){
             //echo 'HERE2';
             $membership_start_date_to = date('Y-m-d', strtotime(str_replace('-', '/', $request->get('date_to'))));
             $data1->where('tbl_membership.created_at','<=',$membership_start_date_to . ' 23:59:59');
         }
         if($request->date_from != '' && $request->date_to ==''){
             //echo 'HERE3';
             $membership_start_date_from = date('Y-m-d', strtotime(str_replace('-', '/', $request->get('date_from'))));
             $data1->where('tbl_membership.created_at', '>=',$membership_start_date_from . ' 00:00:00');
         }

        $res1           =       $data1->orderBy('tbl_membership.created_at','desc')->get();

        /* $data3 = DB::table('user_property')
        ->select('user_property.created_at AS date','id AS tb_id','result_id'
        ,DB::raw('(CASE WHEN count(result_id) >= 1 THEN "Record Purchased" END) as type')
        ,DB::raw('count(result_id) as amount')
        ,DB::raw('(count(result_id)*20)/100 as tax'),
        DB::raw('(count(result_id)*80)/100 as cash'), 
        DB::raw('(CASE WHEN result_id !="" THEN "TC-03"  END) as taxCode'),
         DB::raw('(CASE WHEN result_id !="" THEN "SGL-06"  END) as glCode'))->whereNotNull('result_id'); */

		$data2 = PropertyResultId::select('property_result_id.id','property_result_id.user_id','property_id','property_result_id.created_at as date','result_id','purchase_group_name',DB::raw('(CASE WHEN user_detail.f_name <> "" THEN concat(user_detail.f_name) ELSE SUBSTRING_INDEX(users.email, "@", 1) END) as name'),DB::raw('(CASE WHEN count(result_id) >= 1 THEN "Record Purchased" END) as type'),DB::raw('count(result_id) as total_records'),DB::raw('count(result_id) as amount'),DB::raw('(count(result_id)*20)/100 as tax'),DB::raw('(count(result_id)*80)/100 as cash'), DB::raw('(CASE WHEN result_id !="" THEN "TC-03"  END) as taxCode'),DB::raw('(CASE WHEN result_id !="" THEN "SGL-06"  END) as glCode'),DB::raw('((result_id)*0) as total_amount'))
		->leftJoin('users', 'property_result_id.user_id', '=', 'users.id')
		->leftJoin('user_detail', 'users.id', '=', 'user_detail.user_id')->where('trash', '0');



        if($request->date_from != '' && $request->date_to !=''){
            // echo 'HERE';
             $PRecords_start_date_from = date('Y-m-d', strtotime(str_replace('-', '/', $request->get('date_from'))));
             $PRecords_start_date_to = date('Y-m-d', strtotime(str_replace('-', '/', $request->get('date_to'))));
             $data2->whereBetween('property_result_id.created_at',array($PRecords_start_date_from. ' 00:00:00', $PRecords_start_date_to . ' 23:59:59'));
         }
         if($request->date_from == '' && $request->date_to !=''){
             //echo 'HERE2';
             $PRecords_start_date_to = date('Y-m-d', strtotime(str_replace('-', '/', $request->get('date_to'))));
             $data2->where('property_result_id.created_at','<=',$PRecords_start_date_to . ' 23:59:59');
         }
         if($request->date_from != '' && $request->date_to ==''){
             //echo 'HERE3'; 
             $PRecords_start_date_from = date('Y-m-d', strtotime(str_replace('-', '/', $request->get('date_from'))));
             $data2->where('property_result_id.created_at', '>=',$PRecords_start_date_from . ' 00:00:00');
         }

        //$res2           =       $data3->where('user_property.trash','0')->groupBy('result_id')->get();
        $res2           =       $data2->whereNotNull('purchase_group_name')->groupBy('result_id')->get();
		
		
        $res2Arr = json_decode(json_encode($res2->toArray())); 

        $totdata = array_merge($res->toArray(), $res1->toArray(), $res2Arr, $res3->toArray());
      
        usort($totdata,array($this, "date_compare")); //sort userdefined array by date

       // echo "<pre>"; print_r($totdata); die;
        $totalsale      =       array();
        $onlyAmout      =       array_column($totdata, 'cash');
        foreach($totdata as $key => $dataNew){
            $newValue   =       [];
            foreach($onlyAmout as $k => $am){
                if($k<=$key){
                    array_push($newValue,$am);
                }
            }
           
            $ledger = array_sum($newValue);
        
            $totalsale[] = array("date"=>$dataNew->date,"type"=>$dataNew->type ,"amount"=>$dataNew->amount
            ,"tax"=>$dataNew->tax,"cash"=>$dataNew->cash,"taxCode"=>$dataNew->taxCode,"glCode"=>$dataNew->glCode,"ledger"=>$ledger);

        }
       // dd($ledger);
        return DataTables::of($totalsale)
        ->addColumn('amount', function($row){
            if(fmod($row["amount"], 1) !== 0.00){
                return "$".number_format($row["amount"],2);  
            } else {
                
                return "$".floatval($row["amount"]);  
            }   
        })
        ->addColumn('tax', function($row){
           
            if(fmod($row["tax"], 1) !== 0.00){
                return "$".number_format($row["tax"],2);  
            } else {
                
                return "$".floatval($row["tax"]);  
            }
        })
        ->addColumn('cash', function($row){
           if(fmod($row["cash"], 1) !== 0.00){
                return "$".number_format($row["cash"],2);  
            } else {
                
                return "$ ".floatval($row["cash"]);  
            }
        })
        ->addColumn('ledger', function($row){
            if(fmod($row["ledger"], 1) !== 0.00){
                return "$".number_format($row["ledger"],2);  
            } else {
                
                return "$".floatval($row["ledger"]);  
            }
        })
        ->rawColumns(['sale','commision','action','created_at','amount'])
        ->make(true);
    }
}

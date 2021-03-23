<?php

namespace App\Http\Controllers\SuperadminDashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\DataTreeItem;
use App\Model\Points;
use App\Model\Deposite;
use App\Model\VouchersEntry;
use App\Model\Report;
use DB;
use DataTables;

class TotalIncExpController extends Controller
{

 
    public function IncomeBalanceSheet(Request $request)
    {  
        $data = DB::table('vouchers_entries')->select(DB::raw('(vouchers_entries.rem_total) as cash'))->where('status','Debit')->get();

         $totdata = array_merge($data->toArray());
         $totalsale      =       array();
         $onlyAmount      =       array_column($totdata, 'cash');
         foreach($totdata as $key => $dat){
            $arr = [];
            foreach($onlyAmount as $k => $dats){
            if($k<=$key){
                array_push($arr,$dats);

            }
        }
        $abc = array_sum($arr);
            $totalsale[] = array("abc"=>$abc);
        } 

        $ExpAmount=DataTreeItem::sum('amount');
        $tax= (($ExpAmount)*20)/100;
        $DataTreeExpence=$ExpAmount-$tax;
        $Expence=$abc+$DataTreeExpence;


            $data = DB::table('tbl_purchased_records')
            ->select('tbl_purchased_records.created_at AS date','tbl_purchased_records.report_name as type'
            ,DB::raw('(points_transaction.point/10) as amount'),DB::raw('((points_transaction.point/10)*20)/100 as tax'),DB::raw('((points_transaction.point/10)*80)/100 as cash'), DB::raw('(CASE WHEN tbl_purchased_records.report_type="1" THEN "Tax1" WHEN tbl_purchased_records.report_type="2" THEN "Tax2" WHEN tbl_purchased_records.report_type="3" THEN "Tax3"  ELSE "Tax4" END) as taxCode'), DB::raw('(CASE WHEN tbl_purchased_records.report_type="1" THEN "GL-101" WHEN tbl_purchased_records.report_type="2" THEN "GL-102" WHEN tbl_purchased_records.report_type="3" THEN "GL-103"  ELSE "GL-104" END) as glCode'))
            ->Join('user_property', 'tbl_purchased_records.user_prop_id', '=', 'user_property.id')
            ->Join('users', 'user_property.user_id', '=', 'users.id')
            ->Join('datatree', 'tbl_purchased_records.property_id', '=', 'datatree.PropertyId')
            ->Join('points_transaction', 'tbl_purchased_records.point_id', '=', 'points_transaction.id');
            

            $res = $data->where('user_property.trash','0')->orderBy('tbl_purchased_records.created_at','desc')->get();
                
            $data1 = DB::table('tbl_membership')
            ->select('tbl_membership.created_at AS date','tbl_membership.id AS tb_id','tbl_membership.membership_type as type'
            ,DB::raw('(CASE WHEN tbl_membership.membership_type="1" THEN "Membership" ELSE "Membership" END) as type'),DB::raw('tbl_deposite.amount as amount'),DB::raw('((tbl_deposite.amount)*20)/100 as tax'),DB::raw('((tbl_deposite.amount)*80)/100 as cash'), DB::raw('(CASE WHEN tbl_membership.membership_type="1" THEN "M125" ELSE "M125" END) as taxCode'), DB::raw('(CASE WHEN tbl_membership.membership_type="1" THEN "M125" ELSE "M125" END) as glCode'))
            ->Join('tbl_deposite', 'tbl_membership.trans_id', '=', 'tbl_deposite.id');
            


            $res1           =       $data1->orderBy('tbl_membership.created_at','desc')->get();

            $data3 = DB::table('user_property')
            ->select('user_property.created_at AS date','id AS tb_id','result_id'
            ,DB::raw('(CASE WHEN count(result_id) >= 1 THEN "Record Purchased" END) as type')
            ,DB::raw('count(result_id) as amount')
            ,DB::raw('(count(result_id)*20)/100 as tax'),
            DB::raw('(count(result_id)*80)/100 as cash'), 
            DB::raw('(CASE WHEN result_id !="" THEN "PRTX01"  END) as taxCode'),
                DB::raw('(CASE WHEN result_id !="" THEN "PRGL01"  END) as glCode'))->whereNotNull('result_id');



       $res2           =       $data3->where('user_property.trash','0')->groupBy('result_id')->get();

       $data4 = DB::table('vouchers_entries')
       ->select('vouchers_entries.id AS tb_id','vouchers_entries.created_at AS date',
       DB::raw('(vouchers_entries.amount) as amount'),DB::raw('(vouchers_entries.tax) as tax'),DB::raw('(vouchers_entries.rem_total) as cash'), 
       DB::raw('(CASE WHEN vouchers_entries.status="Credit" THEN "TC-07" END) as taxCode'),
       DB::raw('(CASE WHEN vouchers_entries.status="Credit" THEN "Vouchar Sale " END) as type'),
       DB::raw('(CASE WHEN vouchers_entries.status="Credit" THEN "SGL-07" END) as glCode'))->where('status','Credit');

        $res3 = $data4->get();

       $totdata = array_merge($res->toArray(), $res1->toArray(), $res2->toArray(), $res3->toArray());
      
      // usort($totdata,array($this, "date_compare")); //sort userdefined array by date

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

      // echo "<pre>"; print_r($totalsale); die;

  $profit=$ledger-$Expence;
  $Todaydate = date("d-M-Y");
  return view('SuperadminDashboard.accountBooks.incomeBalanceSheet')->with(['ledger'=>$ledger,'Expence'=>$Expence,'profit'=>$profit,'Todaydate'=>$Todaydate]);

    }
}

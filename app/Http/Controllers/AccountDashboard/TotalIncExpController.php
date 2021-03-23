<?php

namespace App\Http\Controllers\AccountDashboard;

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

        $dataInvoice = DB::table('invoices')->select(DB::raw('(invoices.total) as cash'))->where('status','debit')->get();

        $totdata = array_merge($dataInvoice->toArray());
        $totalsale      =       array();
        $onlyAmount      =       array_column($totdata, 'cash');
        foreach($totdata as $key => $dat){
           $arr = [];
           foreach($onlyAmount as $k => $dats){
           if($k<=$key){
               array_push($arr,$dats);

           }
       }
       $inv_amount = array_sum($arr);
           $totalsale[] = array("inv_amount"=>$inv_amount);
       }

        $ExpAmount=DataTreeItem::sum('amount');
        $tax= (($ExpAmount)*20)/100;
        $DataTreeExpence=$ExpAmount-$tax;
        $Expence=$abc+$DataTreeExpence+$inv_amount;


                       $data = DB::table('tbl_purchased_records')
            ->select('tbl_purchased_records.created_at AS date','tbl_purchased_records.report_name as type'
            ,DB::raw('(points_transaction.point/10) as amount'),DB::raw('((points_transaction.point/10)*20)/100 as tax'),
            DB::raw('((points_transaction.point/10)*80)/100 as cash'))
            ->Join('user_property', 'tbl_purchased_records.user_prop_id', '=', 'user_property.id')
            ->Join('users', 'user_property.user_id', '=', 'users.id')
            ->Join('datatree', 'tbl_purchased_records.property_id', '=', 'datatree.PropertyId')
            ->Join('points_transaction', 'tbl_purchased_records.point_id', '=', 'points_transaction.id');
            

            $res = $data->where('user_property.trash','0')->orderBy('tbl_purchased_records.created_at','desc')->get();
                
            $data1 = DB::table('tbl_membership')
            ->select('tbl_membership.created_at AS date','tbl_membership.id AS tb_id','tbl_membership.membership_type as type',
            DB::raw('tbl_deposite.amount as amount'),DB::raw('((tbl_deposite.amount)*20)/100 as tax'),DB::raw('((tbl_deposite.amount)*80)/100 as cash'))
            ->Join('tbl_deposite', 'tbl_membership.trans_id', '=', 'tbl_deposite.id');
            


            $res1           =       $data1->orderBy('tbl_membership.created_at','desc')->get();

            $data3 = DB::table('user_property')
            ->select('user_property.created_at AS date','id AS tb_id','result_id',
            DB::raw('count(result_id) as amount'),
            DB::raw('(count(result_id)*20)/100 as tax'),
            DB::raw('(count(result_id)*80)/100 as cash'))->whereNotNull('result_id');



       $res2           =       $data3->where('user_property.trash','0')->groupBy('result_id')->get();

       $data4 = DB::table('vouchers_entries')
       ->select('vouchers_entries.id AS tb_id','vouchers_entries.created_at AS date',
       DB::raw('(vouchers_entries.amount) as amount'),DB::raw('(vouchers_entries.tax) as tax'),
       DB::raw('(vouchers_entries.rem_total) as cash'))->where('status','Credit');

        $res3 = $data4->get();

        $invoicesale = DB::table('invoices')->select('invoices.date AS date','invoices.invoice_no','invoices.company_name','invoices.discount',
        DB::raw('(invoices.sub_totla) as amount'),
        DB::raw('(invoices.tax) as tax'),
        DB::raw('(invoices.total) as cash'))
        ->where('status','credit');
        $res4 = $invoicesale->get();

       $totdata = array_merge($res->toArray(), $res1->toArray(), $res2->toArray(), $res3->toArray(),$res4->toArray());
      
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
       
           $totalsale[] = array("date"=>$dataNew->date,"amount"=>$dataNew->amount,"tax"=>$dataNew->tax,"cash"=>$dataNew->cash,"ledger"=>$ledger);

       }
      // echo "<pre>"; print_r($totalsale); die;

  $profit=$ledger-$Expence;
  $Todaydate = date("d-M-Y");
  return view('AccountDashboard.accountBooks.incomeBalanceSheet')->with(['ledger'=>$ledger,'Expence'=>$Expence,'profit'=>$profit,'Todaydate'=>$Todaydate]);

    }
}

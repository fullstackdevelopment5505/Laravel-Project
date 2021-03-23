<?php
namespace App\Http\Controllers\SuperadminDashboard;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\JournalLeadger;
use App\Model\DataTreeItem;
use App\Model\VouchersEntry;
use App\Model\Deposite;
use App\Model\Points;
use App\Model\Report;
use DataTables;
use DB;
class JournalLeadgerController extends Controller
{
    public function JournalLeadgerView()
    {
       
        return view('SuperadminDashboard.accountBooks.journalGeneralLedger');
    }
       
    public static  function date_compare($a, $b)
    {
        $t1 = strtotime($a["created_at"]);
        $t2 = strtotime($b["created_at"]);
        return $t1 - $t2;
    } 
    
    function JournalLeadgerList(){

        $voucherEntries = VouchersEntry::get();
        $original = DataTreeItem::get();
        $latest = Deposite::get();
        $trans =Report::with('point')->get();
       
        $pointRate=DB::table('tbl_static')->select('point_per_dollar')->first();
        $data = array_merge($original->toArray(), $latest->toArray(), $trans->toArray(),$voucherEntries->toArray());
     
        usort($data,array($this, "date_compare"));
        $ledger = array();
       // echo "<pre>"; print_r($data); die;
        foreach( $data as $key => $value){
           
            if(array_key_exists("balance_transaction", $data[$key])){    
                $ledger[]= array('amount' => $value["amount"], 'paymnent_method' => $value["brand"], 
                     'date' => $value["created_at"], 'type' => 'Revenue');
            }
            if(array_key_exists("status", $data[$key])){  
                if($value["status"] == "Credit"){
                    $ledger[]= array('amount' => $value["amount"], 'paymnent_method' =>'', 
                     'date' => $value["created_at"], 'type' => 'Revenue');
                }elseif($value["status"] == "Debit"){
                    $ledger[]= array('amount' => $value["amount"], 'paymnent_method' =>'', 
                     'date' => $value["created_at"], 'type' => 'Expense');
                }elseif($value["status"] == 1){
                    $ledger[]= array('amount' => $value["amount"], 'paymnent_method' =>'', 
                     'date' => $value["created_at"], 'type' => 'Expense');
                }  elseif($value["status"] == 2){
                    $ledger[]= array('amount' => $value["amount"], 'paymnent_method' =>'', 
                     'date' => $value["created_at"], 'type' => 'Expense');
                }    
                
            }
            if(array_key_exists("point_id", $data[$key])){
                $dollar_rate    =   $pointRate->point_per_dollar;
                $point          =   $data[$key]["point"]["point"];
                $amount         =   $point/$dollar_rate;
                if($value["point"]["type"] == 1){
                    $ledger[]   =   array('amount' => $amount, 'paymnent_method' => "-", 
                                    'date' => $value["created_at"], 'type' => 'Revenue');
                }
                if($value["point"]["type"] == 2){
                    $ledger[]   =   array('amount' => $amount, 'paymnent_method' => "-", 
                                'date' => $value["created_at"], 'type' => 'Expense');
                }

            }

        }
        return DataTables::of($ledger)
    
          
        ->addColumn('amount', function($row){
           return "$".number_format($row["amount"], 2, '.', '');   
        })
               
        ->addColumn('mode', function($row){
            if($row["type"] =='Revenue'){
                return "Sale";  
            } else {
                
                return "Purchase";  
            }  
        })

        ->addColumn('credit', function($row){
            if($row["type"] =='Revenue'){
                return $row["amount"];  
            } 
        })
        ->addColumn('debit', function($row){
            if($row["type"] =='Expense'){
                return $row["amount"];  
            } 
        })
        
        ->addColumn('created_at', function($row){
            return date('Y-m-d', strtotime(str_replace('-', '/', $row["date"])));
        })
       
        ->rawColumns(['sale','commision','action','created_at','amount'])
        ->make(true);
  }


}

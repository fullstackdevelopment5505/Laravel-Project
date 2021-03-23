<?php
namespace App\Http\Controllers\AccountDashboard;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\propertyReport;
use App\saleMembershipReport;
use App\Model\CustomerMaster;
use App\sale_property_reports;
use App\User;
use DataTables;
use App\Model\Points;
use App\Model\Detail;
use DB;
use Carbon\Carbon;
use Auth;

class ViewController extends Controller
{
    public static  function date_compare($a, $b)
    {
        $t1 = strtotime($a->date);
        $t2 = strtotime($b->date);
        return $t2 - $t1;
    }  
   
    public function dashboard(){

        // Totltal member count start//

            $data = DB::table('tbl_membership')->Join('users', function($query){
            $query->on( 'users.id', '=', 'tbl_membership.user_id');
            $query->where('users.role', '0');
             })->where('tbl_membership.expire_at', '>' , date('Y-m-d').' 00:00:00')->whereNotNull('tbl_membership.expire_at') ->groupBy('tbl_membership.user_id')->get();
    
             $customerEntrolled = $data->count();

        // Total non member start//

            $data_nonmember = DB::table('users')->where('role', '0')->orderBy('users.id','desc')
            ->LeftJoin('tbl_membership', function($query){
                $query->on( 'users.id', '=', 'tbl_membership.user_id');
                $query->where('tbl_membership.expire_at', '>' , date('Y-m-d').' 00:00:00');
            })
                ->leftJoin('user_detail', 'users.id', '=', 'user_detail.user_id')
             ->whereNull('tbl_membership.expire_at')->get();

           $customerJoined = $data_nonmember->count();
		   
            $customerJoinedLastMonth=DB::table('users')->where('role','0')
            ->join('tbl_membership','tbl_membership.user_id','=','users.id')
            ->join('user_detail','user_detail.user_id','=','users.id')
            ->where([['tbl_membership.expire_at', '>' , date('Y-m-d').' 00:00:00']])
            ->whereMonth(DB::raw('tbl_membership.created_at'),  Carbon::now()->subMonth()->month)
            ->groupBy('tbl_membership.user_id')
            ->get()
            ->count();   

            $customerEntrolledLastMonth=DB::table('users')->where('role', '0')->orderBy('users.id','desc')
            ->LeftJoin('tbl_membership', function($query){
                $query->on( 'users.id', '=', 'tbl_membership.user_id');
                $query->where('tbl_membership.expire_at', '>' , date('Y-m-d').' 00:00:00');
            })
            ->leftJoin('user_detail', 'users.id', '=', 'user_detail.user_id')
            ->select('user_detail.user_id')
            ->whereMonth(DB::raw('users.created_at'), Carbon::now()->subMonth()->month)
            ->whereNull('tbl_membership.expire_at')->count();

           $thismonthJoined=DB::table('users')->where('role','0')
           ->join('tbl_membership','tbl_membership.user_id','=','users.id')
           ->join('user_detail','user_detail.user_id','=','users.id')
           ->select('tbl_membership.user_id')
           ->where([['tbl_membership.expire_at', '>' , date('Y-m-d').' 00:00:00']])
           ->whereMonth(DB::raw('tbl_membership.created_at'), Carbon::now()->format('m'))
           ->groupBy('tbl_membership.user_id')
           ->get()
           ->count();
           $thismonthenrolled=DB::table('users')->where('role','0')
           ->join('user_detail','user_detail.user_id','=','users.id')
           ->select('user_detail.user_id')
           ->groupBy('user_detail.user_id')
            ->count();
            $changeInJoinCustomer=$thismonthJoined-$customerJoinedLastMonth;
            if($customerJoinedLastMonth==0){
                $differenceJoin=$changeInJoinCustomer;
            }else{
                $differenceJoin=($changeInJoinCustomer*$customerJoinedLastMonth)/100;
            }
            $joinPercent=$differenceJoin; 
            $changeInEnrollCustomer=$thismonthenrolled-$customerEntrolledLastMonth;
           
            if($customerEntrolledLastMonth==0){
                $differenceEnroll=$changeInEnrollCustomer;
            }else{
                $differenceEnroll=($changeInEnrollCustomer*$customerEntrolledLastMonth)/100;
            }
            $enrollPercent=$differenceEnroll;

        // total contractor start//

         // $userCountee= DB::table('users')->orWhere('role',2)->orWhere('role',4)->orWhere('role',5)->where('status','1')->count();
		$userCount= User::with('detail')->where('status', '1')->whereNotIn('role' , [0,3,1])->count();
        $saleCount=sale_property_reports::sum('cash');
        $credit=Points::sum('point');
        $debit=Points::where('type','2')->sum('point');
        $walletpoint = $credit-$debit;
        $walletBalance=$walletpoint/10;
        
        // total sale count start//
                $data = DB::table('tbl_purchased_records')
        ->select('tbl_purchased_records.id AS tb_id','tbl_purchased_records.user_id','tbl_purchased_records.created_at AS date','tbl_purchased_records.report_name as type',
        DB::raw('(points_transaction.point/10) as amount'),DB::raw('((points_transaction.point/10)*20)/100 as tax'),DB::raw('((points_transaction.point/10)*80)/100 as cash'), 

        DB::raw('MONTHNAME(tbl_purchased_records.created_at) as month'))
        ->Join('points_transaction', 'tbl_purchased_records.point_id', '=', 'points_transaction.id')
        ->Join('user_property', 'tbl_purchased_records.user_prop_id', '=', 'user_property.id')
        ->Join('datatree', 'tbl_purchased_records.property_id', '=', 'datatree.PropertyId');

         $res = $data->where('user_property.trash','0')->orderBy('tbl_purchased_records.created_at','desc')->get();

        $data1 = DB::table('tbl_membership')
        ->select('tbl_membership.created_at AS date','tbl_membership.id AS tb_id','tbl_membership.membership_type as type',
        DB::raw('(CASE WHEN tbl_membership.membership_type="1" THEN "Membership" ELSE "Membership" END) as type'),DB::raw('tbl_deposite.amount as amount'),
        DB::raw('((tbl_deposite.amount)*20)/100 as tax'),DB::raw('((tbl_deposite.amount)*80)/100 as cash'), 

        DB::raw('MONTHNAME(tbl_membership.created_at) as month'))
        ->Join('tbl_deposite', 'tbl_membership.trans_id', '=', 'tbl_deposite.id');
       

        $res1           =       $data1->orderBy('tbl_membership.created_at','desc')->get();
   
        $data3 = DB::table('user_property')
        ->select('user_property.created_at AS date','id AS tb_id','result_id',
        DB::raw('(CASE WHEN count(result_id) >= 1 THEN "Record Purchased" END) as type'),
        DB::raw('count(result_id) as amount'),
        DB::raw('(count(result_id)*20)/100 as tax'),
        DB::raw('(count(result_id)*80)/100 as cash'), 

        DB::raw('MONTHNAME(user_property.created_at) as month'))->whereNotNull('result_id');


        $res2           =       $data3->where('user_property.trash','0')->groupBy('result_id')->orderBy('date', 'desc')->get();

        
        $data4 = DB::table('vouchers_entries')
        ->select('vouchers_entries.id AS tb_id','vouchers_entries.created_at AS date',
        DB::raw('(vouchers_entries.amount) as amount'),DB::raw('(vouchers_entries.tax) as tax'),DB::raw('(vouchers_entries.rem_total) as cash'), 
        DB::raw('(CASE WHEN vouchers_entries.status="Credit" THEN "Vouchar Sale " END) as type'))->where('status','Credit');

         $res3 = $data4->get();

         $InvoiceSale = DB::table('invoices')->select('invoices.date AS date',
         DB::raw('(invoices.sub_totla) as amount'),
         DB::raw('(invoices.tax) as tax'),
         DB::raw('(invoices.total) as cash'),
         DB::raw('(CASE WHEN invoices.status="Credit" THEN "Invoice Sale" END) as type'))->where('status','credit');
         $res4 = $InvoiceSale->get();
        $totdata = array_merge($res->toArray(), $res1->toArray(), $res2->toArray(), $res3->toArray(), $res4->toArray());
        usort($totdata,array($this, "date_compare")); //sort userdefined array by date
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
            ,"tax"=>$dataNew->tax,"cash"=>$dataNew->cash,"ledger"=>$ledger);

        }

        // purchase records table start//

        $customer = Detail::all(['id', 'state'])->unique('state');  
        //$customer = States::all(['ID', 'STATE_NAME'])->unique('STATE_NAME');  
        $purchaseRecords= DB::table('user_property')->select('user_property.created_at AS date','user_property.id AS tb_id','result_id','user_detail.state',
        DB::raw('(CASE WHEN user_detail.f_name <> "" THEN concat(user_detail.f_name) ELSE SUBSTRING_INDEX(users.email, "@", 1) END) as name'),
        DB::raw('count(result_id) as amount'),
        DB::raw('(count(result_id)*20)/100 as tax'),
        DB::raw('(count(result_id)*80)/100 as cash'))
         ->leftJoin('users', 'user_property.user_id', '=', 'users.id')
         ->leftJoin('user_detail', 'user_property.user_id', '=', 'user_detail.user_id')
         ->whereNotNull('result_id')
         ->groupBy('result_id')->take(10)->orderBy("user_property.created_at","desc")->get();

          // Membership table start//

        $MemReports = DB::table('tbl_membership')->select('tbl_membership.*','membership_master.type','membership_master.amount','tbl_membership.created_at as date','user_detail.f_name','user_detail.l_name','user_detail.state',
        DB::raw('((membership_master.amount)*20)/100 as tax'),
        DB::raw('((membership_master.amount)*80)/100 as cash'),
        DB::raw('(CASE WHEN user_detail.f_name <> "" THEN concat(user_detail.f_name) ELSE SUBSTRING_INDEX(users.email, "@", 1) END) as name')
        )
        ->leftJoin('membership_master', 'tbl_membership.membership_type', '=', 'membership_master.id')
        ->leftJoin('users', 'tbl_membership.user_id', '=', 'users.id')
        ->leftJoin('user_detail', 'tbl_membership.user_id', '=', 'user_detail.user_id')
        ->LeftJoin('tbl_deposite', function($query){
            $query->on( 'tbl_membership.user_id', '=', 'tbl_deposite.user_id');
            $query->where('tbl_membership.trans_id', '=', 'tbl_deposite.id');
        })->orderBy("tbl_membership.created_at","desc")->take(10)->get();
		
		//  Graph for total Sale report, Membership and purchase recods start here//
    $membership_graph = [];

       for($i=1; $i<=12; $i++){
        $membershipGraph= DB::table('tbl_membership')->select('tbl_membership.*','membership_master.type','membership_master.amount')
        ->leftJoin('membership_master', 'tbl_membership.membership_type', '=', 'membership_master.id')
        ->leftJoin('users', 'tbl_membership.user_id', '=', 'users.id')
        ->leftJoin('user_detail', 'tbl_membership.user_id', '=', 'user_detail.user_id')
        ->LeftJoin('tbl_deposite', function($query){
            $query->on( 'tbl_membership.user_id', '=', 'tbl_deposite.user_id');
            $query->where('tbl_membership.trans_id', '=', 'tbl_deposite.id');
        })
        ->select('membership_master.amount')
        ->whereMonth('tbl_membership.created_at', $i)
        ->whereYear('tbl_membership.created_at', '2020')
        ->get()->toArray();
        if(count($membershipGraph)>0){
            $new = array_sum(array_column($membershipGraph, 'amount'));
           $membership_graph[]['y'] = $new;


        }else{
          $membership_graph[]['y'] = 0;

        }
    }
    $sale_graph=[];
 for($i=1; $i<=12; $i++){
        $saleReportGraph= DB::table('tbl_purchased_records')
        ->Join('user_property', 'tbl_purchased_records.user_prop_id', '=', 'user_property.id')
        ->Join('users', 'user_property.user_id', '=', 'users.id')
        ->Join('points_transaction', 'tbl_purchased_records.point_id', '=', 'points_transaction.id')
        ->where('user_property.trash','0')
        ->select(DB::raw('(points_transaction.point/10) as amount'))
        ->whereMonth('points_transaction.created_at', $i)
        ->whereYear('points_transaction.created_at', '2020')
        ->get()->toArray();
        if(count($saleReportGraph)>0){
            $new = array_sum(array_column($saleReportGraph, 'amount'));
           $sale_graph[]['y'] = $new;

        }else{
          $sale_graph[]['y'] = 0;

        }
    }

    $purchase_records_graph=[];
    for($i=1; $i<=12; $i++){
        $purchase_records= DB::table('user_property')->join('users', 'user_property.user_id', '=', 'users.id')
        ->select(DB::raw('count(result_id) as amount'))
        ->whereMonth('users.created_at', $i)
        ->whereYear('users.created_at', '2020')
        ->get()->toArray();
        if(count($purchase_records)>0){
            $new = array_sum(array_column($purchase_records, 'amount'));
            $purchase_records_graph[]['y'] = $new;

        }else{
           $purchase_records_graph[]['y']  = 0;
        }
    }
   
        return view('AccountDashboard.dashboard')->with(['customerEnrolled'=>$customerEntrolled,
        'purchase_records_graph'=>json_encode($purchase_records_graph),'membership_graph'=>json_encode($membership_graph),'sale_graph'=>json_encode($sale_graph),'userCount'=>$userCount,
		'ledger'=>$ledger,'walletBalance'=>$walletBalance,'customerJoined'=>$customerJoined,'customer' => $customer,'purchaseRecords'=>$purchaseRecords,'MemReports'=>$MemReports,
		'totalsale'=>$totalsale,'joinPercent'=>$joinPercent,'enrollPercent'=>$enrollPercent]);
    }
  	public function profile(){
        $userId=Auth::user()->id;
          $data=DB::table('users')
          ->join('user_detail','user_detail.user_id','=','users.id')
          ->select('users.email','user_detail.l_name','user_detail.f_name',
          'user_detail.address','user_detail.state','user_detail.city','user_detail.phone','user_detail.country')
          ->where('users.id',$userId)
          ->first();
         $email= $data->email;
         $f_name=$data->f_name;
         $l_name=$data->l_name;
         $add=$data->address;
         $state=$data->state;
         $city=$data->city;
          $phonee=$data->phone;
          $country=$data->country;
          $phone= "(".substr($phonee, 0, 3).") ".substr($phonee, 3, 3)."-".substr($phonee,6);
  
          return view('AccountDashboard.profile')->with(['email'=>$email,'f_name'=>$f_name,'l_name'=>$l_name,
          'add'=>$add,'state'=>$state,'city'=>$city,'phone'=>$phone,'country'=>$country]);
      }

    public function attendance(){
        return view('AccountDashboard.employee.attendance');
    }
    public function employeeSalary(){
        return view('AccountDashboard.employee.employeeSalary');
    }
    public function productList(){
        return view('AccountDashboard.report.productList');
    }
    public function splitTransaction(){
        return view('AccountDashboard.report.splitTransaction');
    }
    public function standardDataLead(){
        return view('AccountDashboard.report.standardDataLead');
    }
    public function automatedGlEntry(){
        return view('AccountDashboard.report.automatedGlEntry');
    }
    public function dataTreeReport(){
        return view('AccountDashboard.report.dataTreeReport');
    }
    public function ProductTable(){
        return view('AccountDashboard.report.productTable');
    }

}

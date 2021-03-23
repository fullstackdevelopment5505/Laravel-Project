<?php

namespace App\Http\Controllers\SuperadminDashboard;
 
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str; 
use App\Model\Member;
use App\Model\DataTree;
use App\Model\UserProperty;
use App\user;
use App\Configuration;
use App\Model\Detail;
use App\Model\Membership;
use App\Model\DataTreeItem;
use Validator, Response, DB, Session;
use DataTables;
use Carbon\Carbon;

class DashboardController extends Controller
{
	
	public static function graphs($type){
		
		if($type == 'total_sale'){
			
			$membership_graph = [];
			for($i=1; $i<=12; $i++){
				$membershipGraph= DB::table('tbl_membership')->select('tbl_membership.*','membership_master.type','tbl_deposite.amount')
				->leftJoin('membership_master', 'tbl_membership.membership_type', '=', 'membership_master.id')
				->leftJoin('users', 'tbl_membership.user_id', '=', 'users.id')
				->leftJoin('user_detail', 'tbl_membership.user_id', '=', 'user_detail.user_id')
				->Join('tbl_deposite', 'tbl_membership.trans_id', '=', 'tbl_deposite.id')
				->whereMonth('tbl_membership.created_at', $i)
				->whereYear('tbl_membership.created_at', date('Y'))
				->get()->toArray();
				if(count($membershipGraph)>0){
					$new = array_sum(array_column($membershipGraph, 'amount'));
				   $membership_graph[] = $new;


				}else{
				  $membership_graph[] = 0;

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
				->whereYear('points_transaction.created_at', date('Y'))
				->get()->toArray();
				if(count($saleReportGraph)>0){
					$new = array_sum(array_column($saleReportGraph, 'amount'));
				   $sale_graph[] = $new;

				}else{
				  $sale_graph[] = 0;

				}
			}

			$purchase_records_graph=[];
			for($i=1; $i<=12; $i++){
				$purchase_records= DB::table('user_property')->join('users', 'user_property.user_id', '=', 'users.id')
				->select(DB::raw('count(user_property.id) as amount'))
				->whereMonth('users.created_at', $i)
				->whereYear('users.created_at', date('Y'))
				->get()->toArray();
				if(count($purchase_records)>0){
					$new = array_sum(array_column($purchase_records, 'amount'));
					$purchase_records_graph[] = $new;

				}else{
				   $purchase_records_graph[]  = 0;
				}
			}
			//print_r(json_encode($purchase_records_graph));
			//die;		
			return array("membership_graph"=>json_encode($membership_graph),"sale_graph"=>json_encode($sale_graph),"purchase_records_graph"=>json_encode($purchase_records_graph));
		}
		
		if($type == 'monthly_sale'){
			
			$membership_graph = [];
			for($i=1; $i<=12; $i++){
				$membershipGraph= DB::table('tbl_membership')->select('tbl_membership.*','membership_master.type','tbl_deposite.amount')
				->leftJoin('membership_master', 'tbl_membership.membership_type', '=', 'membership_master.id')
				->leftJoin('users', 'tbl_membership.user_id', '=', 'users.id')
				->leftJoin('user_detail', 'tbl_membership.user_id', '=', 'user_detail.user_id')
				->Join('tbl_deposite', 'tbl_membership.trans_id', '=', 'tbl_deposite.id')
				->whereYear('tbl_membership.created_at', Carbon::now()->year)
                ->whereMonth('tbl_membership.created_at', Carbon::now()->month)
				->get()->toArray();
				if(count($membershipGraph)>0){
					$new = array_sum(array_column($membershipGraph, 'amount'));
					$membership_graph[] = $new;

				}else{
				  $membership_graph[] = 0;

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
				->whereYear('points_transaction.created_at', date('Y'))
				->get()->toArray();
				if(count($saleReportGraph)>0){
					$new = array_sum(array_column($saleReportGraph, 'amount'));
				   $sale_graph[] = $new;

				}else{
				  $sale_graph[] = 0;

				}
			}

			$purchase_records_graph=[];
			for($i=1; $i<=12; $i++){
				$purchase_records= DB::table('user_property')->join('users', 'user_property.user_id', '=', 'users.id')
				->select(DB::raw('count(user_property.id) as amount'))
				->whereMonth('users.created_at', $i)
				->whereYear('users.created_at', date('Y'))
				->get()->toArray();
				if(count($purchase_records)>0){
					$new = array_sum(array_column($purchase_records, 'amount'));
					$purchase_records_graph[] = $new;

				}else{
				   $purchase_records_graph[]  = 0;
				}
			}
			//print_r(json_encode($purchase_records_graph));
			//die;		
			return array("membership_graph"=>json_encode($membership_graph),"sale_graph"=>json_encode($sale_graph),"purchase_records_graph"=>json_encode($purchase_records_graph));
		}
			
	}
   
    public function dashboard(){
		
		$total_sale_graphs 		=  $this->graphs('total_sale');
		$monthly_sale_graphs 	=  $this->graphs('monthly_sale');
		
        // $interested_properties = UserProperty::with('dataTree')->where('status',1)->get();
		$data = DB::table('tbl_membership')->Join('users', function($query){
				$query->on( 'users.id', '=', 'tbl_membership.user_id');
                $query->where('users.role', '0');
        })->where('tbl_membership.expire_at', '>' , date('Y-m-d').' 00:00:00')->whereNotNull('tbl_membership.expire_at') ->groupBy('tbl_membership.user_id')->get();
		
		$total_member = $data->count();
		  
		$data_nonmember = DB::table('users')->where('role', '0')->orderBy('users.id','desc')
        ->LeftJoin('tbl_membership', function($query){
            $query->on( 'users.id', '=', 'tbl_membership.user_id');
            $query->where('tbl_membership.expire_at', '>' , date('Y-m-d').' 00:00:00');
        })
        ->leftJoin('user_detail', 'users.id', '=', 'user_detail.user_id')
       ->whereNull('tbl_membership.expire_at')->get();

       $total_non_member = $data_nonmember->count();
	 
        $interested_properties = DB::table('user_property')->where('user_property.status', '1')->where("user_property.trash",'0')
        ->LeftJoin('datatree', function($query){
            $query->on( 'user_property.property_id', '=', 'datatree.id');
        })->get();
        
        $highly_interested_properties = DB::table('user_property')->where('user_property.status', '2')->where("user_property.trash",'0')
        ->LeftJoin('datatree', function($query){
            $query->on( 'user_property.property_id', '=', 'datatree.id');
        })->get();

        $trending = DB::table('user_property')
		->LeftJoin('datatree', function($query){
            $query->on( 'user_property.property_id', '=', 'datatree.id');
        })->select(DB::raw('count(*) as total'),'property_id','MailCity as City','MailState as State',DB::raw('CONCAT(SitusHouseNumber, \' \', SitusStreetName, \' \', SitusMode) as Address'),'MailZZIP9 as Zip','County')
        ->where('user_property.status','2')
		->where("user_property.trash",'0')
        ->groupBy('property_id')
        ->having('total', '>' , 4)
        ->get();

        $recently_joined_members = User::with('details')->where('role','>',0)->where('role','<>',3)->orderBy('created_at', 'desc')->limit(10)->get();
		// echo "<pre>"; print_r( $trending); die;
	 
		$data = DB::table('vouchers_entries')->select(DB::raw('(vouchers_entries.rem_total) as cash'))->where('status','Debit')->get();
	
         $totdata = array_merge($data->toArray());
         $totalsale      =       array();
         $onlyAmount      =       array_column($totdata, 'cash');
		 $abc = 0;
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
		
		
		$ledger = 0;
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
            


            $res1   =  $data1->orderBy('tbl_membership.created_at','desc')->get();

            $data3 = DB::table('user_property')
            ->select('user_property.created_at AS date','id AS tb_id','user_property.id'
            ,DB::raw('(CASE WHEN count(user_property.id) >= 1 THEN "Record Purchased" END) as type')
            ,DB::raw('count(user_property.id) as amount')
            ,DB::raw('(count(user_property.id)*20)/100 as tax'),
            DB::raw('(count(user_property.id)*80)/100 as cash'), 
            DB::raw('(CASE WHEN user_property.id !="" THEN "PRTX01"  END) as taxCode'),
                DB::raw('(CASE WHEN user_property.id !="" THEN "PRGL01"  END) as glCode'))->whereNotNull('user_property.id');



       $res2   =   $data3->where('user_property.trash','0')->groupBy('user_property.id')->get();

       $data4 = DB::table('vouchers_entries')
       ->select('vouchers_entries.id AS tb_id','vouchers_entries.created_at AS date',
       DB::raw('(vouchers_entries.amount) as amount'),DB::raw('(vouchers_entries.tax) as tax'),DB::raw('(vouchers_entries.rem_total) as cash'), 
       DB::raw('(CASE WHEN vouchers_entries.status="Credit" THEN "TC-07" END) as taxCode'),
       DB::raw('(CASE WHEN vouchers_entries.status="Credit" THEN "Vouchar Sale " END) as type'),
       DB::raw('(CASE WHEN vouchers_entries.status="Credit" THEN "SGL-07" END) as glCode'))->where('status','Credit');
		$totalsale      =       array();
        /* $res3 = $data4->get();

      // $totdata = array_merge($res->toArray(), $res1->toArray(), $res2->toArray(), $res3->toArray());
       $totdata = array_merge($res->toArray(), $res1->toArray(), $res2->toArray());
      
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

        } */
		$ExpAmount=DataTreeItem::sum('amount');
        $tax= (($ExpAmount)*20)/100;
        $DataTreeExpence=$ExpAmount-$tax;
        $expense=$abc+$DataTreeExpence;

		//$targetData = DB::table('tbl_targets')->select("expense","revenue")->first();
		$dataConfiguration = Configuration::where("type","targets")->first();
		$targets_arr_data = unserialize($dataConfiguration->settings);
		
		$percentExpense =  0;
        $percentRevenue =  0;
		$expense_target = 0;
		$revenue_target = 0;
		if($targets_arr_data['expense_target'] != '' && $targets_arr_data['expense_target'] > 0){
			$expense_target = $targets_arr_data['expense_target'];
			$percentExpense =  ($expense / $targets_arr_data['expense_target']) * 100;
		}
		
		if($targets_arr_data['revenue_target'] != '' && $targets_arr_data['revenue_target'] > 0){
			$revenue_target = $targets_arr_data['revenue_target'];
			$percentRevenue =  ($ledger / $targets_arr_data['revenue_target']) * 100;
		}
		
        return view('SuperadminDashboard.dashboard', compact('total_sale_graphs','revenue_target','expense_target','percentExpense','percentRevenue','ledger','expense','total_member','total_non_member','interested_properties', 'highly_interested_properties', 'trending', 'recently_joined_members'));
    }


    public function salePropertyList()
    {
       
        return view('SuperadminDashboard.sales.salePropertyReport');
    }
	
	

    // function customerEnrolled(){
    //     $customerEnrolled=Customer::select("*")->count();
    //     return view('AccountDashboard.dashboard')->with('customerEnrolled',$customerEnrolled);
    // }
    // public function memberDetail($id){
    //     $memberDetail=Customer::where('id',$id)->get();
       
    //     return view('AccountDashboard.customerProfile')->with(['memberDetail'=>$memberDetail]);
    // }

   
}
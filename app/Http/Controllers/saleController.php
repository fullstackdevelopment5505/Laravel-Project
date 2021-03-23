<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str; 
use App\Model\Member;
use App\sale_property_reports;
use App\saleMembershipReport;
use Auth;
use App\user;
use DB;
use DataTables;


class saleController extends Controller
{
  
    public function datatable()
    {
        return view('AccountDashboard.sale.salePropertyReport');
    }
    
    public static  function date_compare($a, $b)
    {
        $t1 = strtotime($a->date);
        $t2 = strtotime($b->date);
        return $t1 - $t2;
    }    

    public static  function date_compare_membership($a, $b)
    {
        $t1 = strtotime($a->date);
        $t2 = strtotime($b->date);
        return $t1 - $t2;
    }    
    
    
    function saleReportList(Request $request){
        if($request->ajax())
        {
            $abc = 0;
                // return view('SuperadminDashboard.sales.salePropertyReport');
                $data = DB::table('tbl_purchased_records')->select('tbl_purchased_records.user_id','tbl_purchased_records.report_name AS property_type','tbl_purchased_records.created_at AS date','datatree.Address',
                DB::raw('(points_transaction.point/10) as amount'),DB::raw('((points_transaction.point/10)*20)/100 as tax'),DB::raw('((points_transaction.point/10)*80)/100 as cash'),DB::raw('(CASE WHEN user_detail.f_name <> "" THEN concat(user_detail.f_name) ELSE SUBSTRING_INDEX(users.email, "@", 1) END) as name'))
                ->Join('user_property', 'tbl_purchased_records.user_prop_id', '=', 'user_property.id')
                ->Join('users', 'user_property.user_id', '=', 'users.id')
                ->Join('user_detail', 'users.id', '=', 'user_detail.user_id')
                ->Join('datatree', 'tbl_purchased_records.property_id', '=', 'datatree.PropertyId')
                ->Join('points_transaction', 'tbl_purchased_records.point_id', '=', 'points_transaction.id')
                
                ->where('user_property.trash','0');
        
                if($request->date_from != '' && $request->date_to !=''){
                    // echo 'HERE';
                    $user_property_date_from = date('Y-m-d', strtotime(str_replace('-', '/', $request->get('date_from'))));
                    $user_property_date_to = date('Y-m-d', strtotime(str_replace('-', '/', $request->get('date_to'))));
                    $data->whereBetween('tbl_purchased_records.created_at',array($user_property_date_from. ' 00:00:00', $user_property_date_to . ' 23:59:59'));
                }
                if($request->date_from == '' && $request->date_to !=''){
                    //echo 'HERE2';
                    $user_property_date_to = date('Y-m-d', strtotime(str_replace('-', '/', $request->get('date_to'))));
                    $data->where('tbl_purchased_records.created_at','<=',$user_property_date_to . ' 23:59:59');
                }
                if($request->date_from != '' && $request->date_to ==''){
                    //echo 'HERE3';
                    $user_property_date_from = date('Y-m-d', strtotime(str_replace('-', '/', $request->get('date_from'))));
                    $data->where('tbl_purchased_records.created_at', '>=',$user_property_date_from . ' 00:00:00');
                }
               
                $data = $data->get();
                $totalsale      =       array();
                $data1 =$data->toarray();
                $onlyAmout      =     array_column($data1, 'cash');
                usort($data1,array($this, "date_compare")); //sort userdefined array by date
               // echo "<pre>"; print_r($data); die;
                foreach($data1 as $key => $dat){
                    $arr = [];
                    foreach($onlyAmout as $k => $dats){
                        if($k<=$key){
                            array_push($arr,$dats);
            
                        }
                    }
                    $abc = array_sum($arr);
                    $totalsale[] = array("date"=>$dat->date ,"name"=>$dat->name ,"property_type"=>$dat->property_type ,"amount"=>$dat->amount ,"tax"=>$dat->tax ,"cash"=>$dat->cash ,"abc"=>$abc);
                }

                // dd($totalsale);
                return DataTables::of($totalsale)
                ->rawColumns(['sale','commision','action','created_at','amount'])
                ->addColumn('amount', function($row){
                    return "$".number_format($row["amount"]);   
                 })
                 ->addColumn('tax', function($row){
                    return "$".number_format($row["tax"]); 
                 })
                 ->addColumn('cash', function($row){
                    return "$".number_format($row["cash"]); 
                 })
                 ->addColumn('abc', function($row){
                     return "$".number_format($row["abc"]);
                 })
                ->make(true); 
        }    


        $data = DB::table('tbl_purchased_records')->select('tbl_purchased_records.id AS tb_id','tbl_purchased_records.user_id','tbl_purchased_records.report_name AS property_type','tbl_purchased_records.created_at AS date','datatree.Address','user_detail.Address',
        DB::raw('(points_transaction.point/10) as amount'),DB::raw('((points_transaction.point/10)*20)/100 as tax'),DB::raw('((points_transaction.point/10)*80)/100 as cash'),DB::raw('(CASE WHEN user_detail.f_name <> "" THEN concat(user_detail.f_name) ELSE SUBSTRING_INDEX(users.email, "@", 1) END) as name'))
        ->Join('user_property', 'tbl_purchased_records.user_prop_id', '=', 'user_property.id')
        ->Join('users', 'user_property.user_id', '=', 'users.id')
        ->Join('user_detail', 'users.id', '=', 'user_detail.user_id')
        ->Join('datatree', 'tbl_purchased_records.property_id', '=', 'datatree.PropertyId')
        ->Join('points_transaction', 'tbl_purchased_records.point_id', '=', 'points_transaction.id')
        
        ->where('user_property.trash','0')->orderBy('tbl_purchased_records.created_at','desc')->get();
    
        $abc = 0;
         $totalsale      =       array();
         $data1 =$data->toarray();
         $onlyAmout      =     array_column($data1, 'cash');
         usort($data1,array($this, "date_compare")); //sort userdefined array by date
         //echo "<pre>"; print_r($data1); die;
         foreach($data as $key => $dat){
             $arr = [];
             foreach($onlyAmout as $k => $dats){
                    if($k<=$key){
                        array_push($arr,$dats);
        
                    }
                }
                $abc = array_sum($arr);
                 $totalsale[] = array("date"=>$dat->date ,"name"=>$dat->name ,"property_type"=>$dat->property_type ,"amount"=>$dat->amount ,"tax"=>$dat->tax ,"cash"=>$dat->cash ,"abc"=>$abc);
         }

        // dd($totalsale);
         return DataTables::of($totalsale)
         ->rawColumns(['sale','commision','action','created_at','amount'])
                 ->addColumn('amount', function($row){
           return "$".number_format($row["amount"]);   
        })
        ->addColumn('tax', function($row){
           return "$".number_format($row["tax"]); 
        })
        ->addColumn('cash', function($row){
           return "$".number_format($row["cash"]); 
        })
        ->addColumn('abc', function($row){
            return "$".number_format($row["abc"]);
        })
        ->make(true);
    }
    public function saleMembership()
    {
        return view('AccountDashboard.sale.saleMembershipReport');
    }
    public function saleMembershipReport(Request $request)
    {

        $report = Member::with('user','user.detail','membership_type');
        
        if($request->ajax())
        {
            
        
            if(!empty($request->get('date_from')) || !empty($request->get('date_to')))
			{
                
                $data = DB::table('tbl_membership')->select('tbl_membership.*','membership_master.type','membership_master.amount','tbl_membership.created_at AS date','user_detail.f_name',
                DB::raw('((membership_master.amount)*20)/100 as tax'),
                DB::raw('((membership_master.amount)*80)/100 as cash'),
                DB::raw('(CASE WHEN user_detail.f_name <> "" THEN concat(user_detail.f_name) ELSE SUBSTRING_INDEX(users.email, "@", 1) END) as name'))
                ->leftJoin('membership_master', 'tbl_membership.membership_type', '=', 'membership_master.id')
                ->leftJoin('users', 'tbl_membership.user_id', '=', 'users.id')
                ->leftJoin('user_detail', 'tbl_membership.user_id', '=', 'user_detail.user_id')
                ->LeftJoin('tbl_deposite', function($query){
                    $query->on( 'tbl_membership.user_id', '=', 'tbl_deposite.user_id');
                    $query->where('tbl_membership.trans_id', '=', 'tbl_deposite.id');
                });
                
                if($request->date_from != '' && $request->date_to !=''){
                   // echo 'HERE';
                    $membership_start_date_from = date('Y-m-d', strtotime(str_replace('-', '/', $request->get('date_from'))));
                    $membership_start_date_to = date('Y-m-d', strtotime(str_replace('-', '/', $request->get('date_to'))));
                    $data->whereBetween('tbl_membership.created_at',array($membership_start_date_from. ' 00:00:00', $membership_start_date_to . ' 23:59:59'));
                }
				if($request->date_from == '' && $request->date_to !=''){
                    //echo 'HERE2';
					$membership_start_date_to = date('Y-m-d', strtotime(str_replace('-', '/', $request->get('date_to'))));
                    $data->where('tbl_membership.created_at','<=',$membership_start_date_to . ' 23:59:59');
				}
				if($request->date_from != '' && $request->date_to ==''){
                    //echo 'HERE3';
					$membership_start_date_from = date('Y-m-d', strtotime(str_replace('-', '/', $request->get('date_from'))));
                    $data->where('tbl_membership.created_at', '>=',$membership_start_date_from . ' 00:00:00');
                }
                $abc = 0;
				//$data->orderBy("tbl_membership.created_at","desc");
                $data= $data->get();
				$totalsale      =       array();
				$data1 =$data->toarray();
				$onlyAmout      =     array_column($data1, 'cash');
                usort($data1,array($this, "date_compare_membership")); //sort userdefined array by date
				foreach($data1 as $key => $dat){
					$arr = [];
					foreach($onlyAmout as $k => $dats){
					if($k<=$key){
							array_push($arr,$dats);
							}
						 }
				   $abc = array_sum($arr);
				   $totalsale[] = array("user_id"=>$dat->user_id ,"date"=>$dat->date ,"name"=>$dat->name ,"type"=>$dat->type ,"cash"=>$dat->cash,"tax"=>$dat->tax ,"amount"=>$dat->amount ,"abc"=>$abc);
				}
                return DataTables::of($totalsale)
                ->addColumn('amount', function($row){
                    return "$".number_format($row["amount"], 2, '.', '');   
                 })
                 ->addColumn('tax', function($row){
                    return "$".number_format($row["tax"], 2, '.', ''); 
                 })
                 ->addColumn('cash', function($row){
                    return "$".number_format($row["cash"], 2, '.', ''); 
                 })
                 ->addColumn('abc', function($row){
                     return "$".number_format($row["abc"], 2, '.', '');
                 })
                // ->addColumn('date', function($row){
                //     //echo "<pre>"; print_r($row);
                //     $created_at = date('d-m-Y', strtotime(str_replace('-', '/', $row["date"])));
                //     return $created_at;
                // })
               
                ->addColumn('action', function($row){
                    $button = ' <a href='.\URL::route('member.detail', ['id'=>$row["user_id"],'type'=>'1']).' class="btn btn-success">View Detail</a>';
                   
                    return $button;
                })
               
                ->make(true);
				
			}else{
               $abc=0;
                $data = DB::table('tbl_membership')->select('tbl_membership.*','membership_master.type','membership_master.amount','tbl_membership.created_at as date','user_detail.f_name','user_detail.l_name',
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
                })->get();	
                $totalsale      =       array();
                $data1 =$data->toarray();
                $onlyAmout      =     array_column($data1, 'cash');
                usort($data1,array($this, "date_compare_membership")); //sort userdefined array by date
                foreach($data1 as $key => $dat){
                    $arr = [];
                    foreach($onlyAmout as $k => $dats){
                    if($k<=$key){
                        array_push($arr,$dats);
        
                    }
                }
                $abc = array_sum($arr);
        
                    $totalsale[] = array("user_id"=>$dat->user_id,"date"=>$dat->date ,"name"=>$dat->name ,"type"=>$dat->type ,"cash"=>$dat->cash,"tax"=>$dat->tax ,"amount"=>$dat->amount ,"abc"=>$abc);
                }
              
                return DataTables::of($totalsale)
                ->addColumn('amount', function($row){
                    return "$".number_format($row["amount"]);   
                 })
                 ->addColumn('tax', function($row){
                    return "$".number_format($row["tax"]); 
                 })
                 ->addColumn('cash', function($row){
                    return "$".number_format($row["cash"]); 
                 })
                 ->addColumn('abc', function($row){
                     return "$".number_format($row["abc"]);
                 })
                // ->addColumn('date', function($row){
                //     //echo "<pre>"; print_r($row);
                //     $created_at = date('d-m-Y', strtotime(str_replace('-', '/', $row["date"])));
                //     return $created_at;
                // })
               
                ->addColumn('action', function($row){
                    $button = ' <a href='.\URL::route('member.detail', ['id'=>$row["user_id"],'type'=>'1']).' class="btn btn-success">View Detail</a>';
                   
                    return $button;
                })

                ->make(true);
            }

            
        }
      
    }

    
    function saleMemReportList(Request $request){
        $reg_status = saleMembershipReport::select('*');
        if($request->ajax())
        {
   
           if(!empty($request->all()))
            {
              $data = DB::table('membership_report');   
              if( $request->type){
                  $data->where('type', '=',  $request->type );
              }
          
              if( $request->Date_from ){
                  $date_from = date('Y-m-d', strtotime(str_replace('-', '/', $request->get('date_from'))));
                  $data->where('date','>=',$date_from);
                 
              }
              if($request->date_to){
                  $date_to = date('Y-m-d', strtotime(str_replace('-', '/', $request->get('date_to'))));
                  $data->where('date','<=',$date_to);
              }
              $datatables =  app('datatables')->of($data)
              ->addColumn('action', '
              <a href="#" class="btn btn-success">View Detail</a>')
              ->rawColumns(['sale','commision','action']);
                       return $datatables->make(true);  
            }   
        }
    }


    public function memberDetail($id){
        $memberDetail=Customer::where('id',$id)->get();
       
        return view('AccountDashboard.customerProfile')->with(['memberDetail'=>$memberDetail]);
    }

    public function memberSearch(Request $request)
    {
     if($request->ajax())
      {
 
         if(!empty($request->all()))
          {
            $data = DB::table('membership_report'); 
            if( $request->type){
                $data->where('type', '=',  $request->type );
            }
        
            if( $request->Date_from ){
                $date_from = date('Y-m-d', strtotime(str_replace('-', '/', $request->get('date_from'))));
                $data->where('date','>=',$date_from);
               
            }
            if($request->date_to){
                $date_to = date('Y-m-d', strtotime(str_replace('-', '/', $request->get('date_to'))));
                $data->where('date','<=',$date_to);
            }
            $datatables =  app('datatables')->of($data)
            ->addColumn('name', function($row){
                        return \ucfirst( $row->first_name)." ".\ucfirst($row->last_name);
                     });
                     return $datatables->make(true);
          }
        }
    }

    public function purchasedRecords()
    {
        return view('AccountDashboard.sale.purchasedRecordsReport');
    }
}
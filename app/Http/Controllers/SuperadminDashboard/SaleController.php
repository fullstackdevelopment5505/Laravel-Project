<?php

namespace App\Http\Controllers\SuperadminDashboard;
 
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str; 
use App\Model\Member;
use App\Model\DataTreeItem;
use App\user;
use DB;
use DataTables;


class SaleController extends Controller
{
   
    public function salePropertyList(Request $request)
    {
		
        if($request->ajax())
        {
			$total = 0;
			// return view('SuperadminDashboard.sales.salePropertyReport');
			$data = DB::table('tbl_purchased_records')->select('tbl_purchased_records.user_id','tbl_purchased_records.report_name AS property_type','tbl_purchased_records.created_at','datatree.Address',
			DB::raw('(points_transaction.point/10) as amount'),DB::raw('((points_transaction.point/10)*20)/100 as tax'),DB::raw('((points_transaction.point/10)*80)/100 as cash'),DB::raw('(CASE WHEN user_detail.f_name <> "" THEN concat(user_detail.f_name," ", user_detail.l_name) ELSE SUBSTRING_INDEX(users.email, "@", 1) END) as name'))
			->Join('user_property', 'tbl_purchased_records.user_prop_id', '=', 'user_property.id')
			->Join('users', 'user_property.user_id', '=', 'users.id')
			->Join('user_detail', 'users.id', '=', 'user_detail.user_id')
			->Join('datatree', 'tbl_purchased_records.property_id', '=', 'datatree.PropertyId')
			->Join('points_transaction', 'tbl_purchased_records.point_id', '=', 'points_transaction.id')->where('user_property.trash','0');
	
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
			usort($data1,array($this, "date_compare_membership")); //sort userdefined array by date
		   // echo "<pre>"; print_r($data); die;
			foreach($data1 as $key => $dat){
				$arr = [];
				foreach($onlyAmout as $k => $dats){
					if($k<=$key){
						array_push($arr,$dats);
		
					}
				}
				$total = array_sum($arr);
				$totalsale[] = array("created_at"=>$dat->created_at ,"name"=>$dat->name ,"property_type"=>$dat->property_type ,"amount"=>$dat->amount ,"tax"=>$dat->tax ,"cash"=>$dat->cash ,"total"=>$total);
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
			 ->addColumn('total', function($row){
				 return "$".number_format($row["total"]);
			 })
			->make(true); 
        }    

        return view('SuperadminDashboard.sales.salePropertyReport');
    }

  
    public function saleMembershipReport(Request $request)
    {
        $report = Member::with('user','user.detail','membership_type');
        
        if($request->ajax())
        {
            
        
            if(!empty($request->get('date_from')) || !empty($request->get('date_to')))
			{
                
                $data = DB::table('tbl_membership')->select('tbl_membership.*','membership_master.type','membership_master.amount','tbl_membership.created_at AS date','user_detail.f_name','user_detail.l_name',
                DB::raw('((membership_master.amount)*20)/100 as tax'),
                DB::raw('((membership_master.amount)*80)/100 as cash'),
                DB::raw('(CASE WHEN user_detail.f_name <> "" THEN concat(user_detail.f_name," ", user_detail.l_name) ELSE SUBSTRING_INDEX(users.email, "@", 1) END) as name'))
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
                $total = 0;
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
				   $total = array_sum($arr);
				   $totalsale[] = array("user_id"=>$dat->user_id ,"date"=>$dat->date ,"name"=>$dat->name ,"type"=>$dat->type ,"cash"=>$dat->cash,"tax"=>$dat->tax ,"amount"=>$dat->amount ,"total"=>$total);
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
                 ->addColumn('total', function($row){
                     return "$".number_format($row["total"], 2, '.', '');
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
				$total=0;
                $data = DB::table('tbl_membership')->select('tbl_membership.*','membership_master.type','membership_master.amount','tbl_membership.created_at as date','user_detail.f_name','user_detail.l_name',
                DB::raw('((membership_master.amount)*20)/100 as tax'),
                DB::raw('((membership_master.amount)*80)/100 as cash'),
                DB::raw('(CASE WHEN user_detail.f_name <> "" THEN concat(user_detail.f_name," ", user_detail.l_name) ELSE SUBSTRING_INDEX(users.email, "@", 1) END) as name')
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
                $total = array_sum($arr);
        
                    $totalsale[] = array("user_id"=>$dat->user_id,"date"=>$dat->date ,"name"=>$dat->name ,"type"=>$dat->type ,"cash"=>$dat->cash,"tax"=>$dat->tax ,"amount"=>$dat->amount ,"total"=>$total);
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
                 ->addColumn('total', function($row){
                     return "$".number_format($row["total"]);
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
        return view('SuperadminDashboard.sales.saleMembershipReport');
    }

    public function addContact(Request $request){
        $inputs = $request->only(['name','email','phoneno','location','type']);
        $validator = Validator::make($inputs,[
            'name' => 'required',
            'email' => 'required|email',
            'phoneno' => 'required|numeric',
            'location'=>'required'
        ]);
        if($validator->fails()){
            $errorMessages = $validator->messages()->toArray();
            return redirect()->back()->with('error','Invalid inputs');
        }
        else{
               $data=Contact::create($inputs);
               return redirect()->back()->with('success','Customer added successfully');
        }
    }
    function saleManagerList(){
        $contact = Contact::select('*')->where('type','sale_manager');
        
        return DataTables::of($contact)
        ->addIndexColumn()
        ->addColumn('message', function($row){

               $btn = '<a href="'. route("saleExecutiveSendMessage") .'" class="edit btn btn-success btn-sm">Message</a>';

                return $btn;
        })
        ->rawColumns(['message'])

        ->make(true);
    }
    function saleExecutiveList(){
        $contact = Contact::select('*')->where('type','sale_executive');
        return DataTables::of($contact)
        ->addIndexColumn()
        ->addColumn('message', function($row){

               $btn = '<a href="'. route("saleExecutiveSendMessage") .'" class="edit btn btn-success btn-sm">Message</a>';
                return $btn;
        })
        
        ->rawColumns(['message'])
        ->make(true);
    }
    function customerEnrolled(){
        $customerEnrolled=Customer::select("*")->count();
        return view('AccountDashboard.dashboard')->with('customerEnrolled',$customerEnrolled);
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
                //    echo $data->toSql();
                //    die;
                //   echo $data->toSql();
                //     $data = $data->paginate(1);
            
                //     return response()->json($data);
            }
        }
    }

    function salePurchasedRecords(Request $request)
    {
        if($request->ajax())
        {
			if(!empty($request->get('date_from_purchase')) || !empty($request->get('date_to_purchase')))
			{
                $data = DB::table('user_property')->select('user_property.created_at AS date'
				,DB::raw('(CASE WHEN count(result_id) >= 1 THEN "Record Purchased" END) as type')
				,DB::raw('count(result_id) as amount')
				,DB::raw('(count(result_id)*20)/100 as tax')
				,DB::raw('(count(result_id)*80)/100 as cash') 
                ,DB::raw('(CASE WHEN user_detail.f_name <> "" THEN concat(user_detail.f_name," ", user_detail.l_name) ELSE SUBSTRING_INDEX(users.email, "@", 1) END) as name'))
				->leftJoin('user_detail', 'user_property.user_id', '=', 'user_detail.user_id')
                ->leftJoin('users', 'user_detail.user_id', '=', 'users.id')
				->where('user_property.trash','0')
				->whereNotNull('result_id');
				
                    if($request->date_from_purchase != '' && $request->date_to_purchase !=''){
                        // echo 'HERE';
                        $membership_start_date_from = date('Y-m-d', strtotime(str_replace('-', '/', $request->get('date_from_purchase'))));
                        $membership_start_date_to = date('Y-m-d', strtotime(str_replace('-', '/', $request->get('date_to_purchase'))));
                        $data->whereBetween('user_property.created_at',array($membership_start_date_from. ' 00:00:00', $membership_start_date_to . ' 23:59:59'));
                    }
                    if($request->date_from_purchase == '' && $request->date_to_purchase !=''){
                        //echo 'HERE2';
                        $membership_start_date_to = date('Y-m-d', strtotime(str_replace('-', '/', $request->get('date_to_purchase'))));
                        $data->where('user_property.created_at','<=',$membership_start_date_to . ' 23:59:59');
                    }
                    if($request->date_from_purchase != '' && $request->date_to_purchase ==''){
                        //echo 'HERE3';
                        $membership_start_date_from = date('Y-m-d', strtotime(str_replace('-', '/', $request->get('date_from_purchase'))));
                        $data->where('user_property.created_at', '>=',$membership_start_date_from . ' 00:00:00');
                    }
                    $data= $data->groupBy('result_id')->get();
                    $totalsale      =       array();
                    $data1 =$data->toarray();
                    $onlyAmout      =     array_column($data1, 'cash');
                    usort($data1,array($this, "date_compare")); //sort userdefined array by date
                    foreach($data1 as $key => $dat){
                        $arr = [];
                        foreach($onlyAmout as $k => $dats){
							if($k<=$key){
								array_push($arr,$dats);
				
							}
						}
						$total = array_sum($arr);
            
                        $totalsale[] = array("date"=>$dat->date ,"name"=>$dat->name ,"tax"=>$dat->tax,"cash"=>$dat->cash,"amount"=>$dat->amount ,"total"=>$total);
                    }
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
                        
                        return "$".floatval($row["cash"]);  
                    }
                })
                ->addColumn('total', function($row){
                    if(fmod($row["total"], 1) !== 0.00){
                        return "$".number_format($row["total"],2);  
                    } else {
                        
                        return "$".floatval($row["total"]);  
                    }
                })
                ->make(true);              
            }
               $data = DB::table('user_property')->select('user_property.created_at AS date'
				,DB::raw('(CASE WHEN count(result_id) >= 1 THEN "Record Purchased" END) as type')
				,DB::raw('count(result_id) as amount')
				,DB::raw('(count(result_id)*20)/100 as tax')
				,DB::raw('(count(result_id)*80)/100 as cash') 
                ,DB::raw('(CASE WHEN user_detail.f_name <> "" THEN concat(user_detail.f_name," ", user_detail.l_name) ELSE SUBSTRING_INDEX(users.email, "@", 1) END) as name'))
				->leftJoin('user_detail', 'user_property.user_id', '=', 'user_detail.user_id')
                ->leftJoin('users', 'user_detail.user_id', '=', 'users.id')
				->where('user_property.trash','0')
				->whereNotNull('result_id')
				->groupBy('result_id')->get();
                
                $totalsale      =       array();
                $data1 =$data->toarray();
                $onlyAmout      =     array_column($data1, 'cash');
				usort($data1,array($this, "date_compare")); //sort userdefined array by date
                foreach($data1 as $key => $dat){
                    $arr = [];
                    foreach($onlyAmout as $k => $dats){
						if($k<=$key){
							array_push($arr,$dats);

						}
					}
					$total = array_sum($arr);

                    $totalsale[] = array("date"=>$dat->date ,"name"=>$dat->name ,"tax"=>$dat->tax,"cash"=>$dat->cash,"amount"=>$dat->amount ,"total"=>$total);
                }
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
						
						return "$".floatval($row["cash"]);  
					}
				})
				->addColumn('total', function($row){
					if(fmod($row["total"], 1) !== 0.00){
						return "$".number_format($row["total"],2);  
					} else {
						
						return "$".floatval($row["total"]);  
					}
				})
				->make(true);
        }  
        return view('SuperadminDashboard.sales.purchasedRecordsReport');
    }

    function totalSaleReport(Request $request){

        if($request->ajax())
        {
            $Expence=DataTreeItem::sum('amount');
			$data = DB::table('tbl_purchased_records')
			->select('tbl_purchased_records.created_at AS date','tbl_purchased_records.report_name as type'
			,DB::raw('(points_transaction.point/10) as amount'),DB::raw('((points_transaction.point/10)*20)/100 as tax')
			,DB::raw('((points_transaction.point/10)*80)/100 as cash'), DB::raw('(CASE WHEN tbl_purchased_records.report_type="1" THEN "Tax1" WHEN tbl_purchased_records.report_type="2" THEN "Tax2" WHEN tbl_purchased_records.report_type="3" THEN "Tax3"  ELSE "Tax4" END) as taxCode')
			, DB::raw('(CASE WHEN tbl_purchased_records.report_type="1" THEN "GL-101" WHEN tbl_purchased_records.report_type="2" THEN "GL-102" WHEN tbl_purchased_records.report_type="3" THEN "GL-103"  ELSE "GL-104" END) as glCode'))
			->Join('user_property', 'tbl_purchased_records.user_prop_id', '=', 'user_property.id')
			->Join('users', 'user_property.user_id', '=', 'users.id')
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


			 $res = $data->where('user_property.trash','0')->orderBy('tbl_purchased_records.created_at','desc')->get();
			 
			$data1 = DB::table('tbl_membership')
			->select('tbl_membership.created_at AS date','tbl_membership.id AS tb_id','tbl_membership.membership_type as type'
			,DB::raw('(CASE WHEN tbl_membership.membership_type="1" THEN "Membership" ELSE "Membership" END) as type'),DB::raw('tbl_deposite.amount as amount'),DB::raw('((tbl_deposite.amount)*20)/100 as tax'),DB::raw('((tbl_deposite.amount)*80)/100 as cash'), DB::raw('(CASE WHEN tbl_membership.membership_type="1" THEN "M125" ELSE "M125" END) as taxCode'), DB::raw('(CASE WHEN tbl_membership.membership_type="1" THEN "M125" ELSE "M125" END) as glCode'))
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

			$data3 = DB::table('user_property')
			->select('user_property.created_at AS date','id AS tb_id','result_id'
			,DB::raw('(CASE WHEN count(result_id) >= 1 THEN "Record Purchased" END) as type')
			,DB::raw('count(result_id) as amount')
			,DB::raw('(count(result_id)*20)/100 as tax'),
			DB::raw('(count(result_id)*80)/100 as cash'), 
			DB::raw('(CASE WHEN result_id !="" THEN "PRTX01"  END) as taxCode'),
			 DB::raw('(CASE WHEN result_id !="" THEN "PRGL01"  END) as glCode'))->whereNotNull('result_id');

			if($request->date_from != '' && $request->date_to !=''){
				// echo 'HERE';
				 $PRecords_start_date_from = date('Y-m-d', strtotime(str_replace('-', '/', $request->get('date_from'))));
				 $PRecords_start_date_to = date('Y-m-d', strtotime(str_replace('-', '/', $request->get('date_to'))));
				 $data3->whereBetween('user_property.created_at',array($PRecords_start_date_from. ' 00:00:00', $PRecords_start_date_to . ' 23:59:59'));
			 }
			 if($request->date_from == '' && $request->date_to !=''){
				 //echo 'HERE2';
				 $PRecords_start_date_to = date('Y-m-d', strtotime(str_replace('-', '/', $request->get('date_to'))));
				 $data3->where('user_property.created_at','<=',$PRecords_start_date_to . ' 23:59:59');
			 }
			 if($request->date_from != '' && $request->date_to ==''){
				 //echo 'HERE3';
				 $PRecords_start_date_from = date('Y-m-d', strtotime(str_replace('-', '/', $request->get('date_from'))));
				 $data3->where('user_property.created_at', '>=',$PRecords_start_date_from . ' 00:00:00');
			 }

			$res2           =       $data3->where('user_property.trash','0')->groupBy('result_id')->get();

			$totdata = array_merge($res->toArray(), $res1->toArray(), $res2->toArray());
		   
			usort($totdata,array($this, "date_compare")); //sort userdefined array by date

			//echo "<pre>"; print_r($totdata); die;
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
        return view('SuperadminDashboard.sales.totalSaleReport');

    }
	public static  function date_compare($a, $b)
    {
        $t1 = strtotime($a->date);
        $t2 = strtotime($b->date);
        return $t1 - $t2;
    }    

    public static  function date_compare_membership($a, $b)
    {
        $t1 = strtotime($a->created_at);
        $t2 = strtotime($b->created_at);
        return $t1 - $t2;
    }   
}
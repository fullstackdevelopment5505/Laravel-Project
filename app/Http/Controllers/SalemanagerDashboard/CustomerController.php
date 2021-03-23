<?php

namespace App\Http\Controllers\SalemanagerDashboard;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Customer;
use DataTables;
use App\Team;
use Validator,Response;
use App\Model\Deposite;
use App\User;
use App\Member;
use App\Model\Saved;

use Auth;
use DB;
use Carbon\Carbon;

class CustomerController extends Controller
{
    public function addCustomer(Request $request){
        $inputs = $request->only(['first_name','last_name','email','phone_number','city']);
        $validator = Validator::make($inputs,[
            'first_name' => 'required',
            'email' => 'required|email',
            'phone_number' => 'required|numeric',
            'city'=>'required'
        ]);
        if($validator->fails()){
            $errorMessages = $validator->messages()->toArray();
            return redirect()->back()->with('error','Invalid inputs');
        }
        else{
            $data=Customer::create($inputs);
            return redirect()->back()->with('success','Customer added successfully');
        }
    }
    function customerList(){
        $userId= Auth::user()->id;           
        $customers = Customer::select("*")->where('sale_manager',$userId);
        return DataTables::of($customers)
        ->addIndexColumn()
        ->addColumn('mergeColumn',function($customers){
            return '<span class="first_name"> '.$customers->first_name.'</span><span class="last_name"> ' .$customers->last_name.'</span>';
        })
        ->addColumn('email',function($customers){  
            return '<span class="first_name">'.$customers->email.'</span>';
        })
        ->addColumn('mobile',function($customers){
            return '<span class="phone_number">'.$customers->phone_number.'</span>';
        })
        ->addColumn('city',function($customers){
            return '<span class="city">'.$customers->city.'</span>';
        })
        ->editColumn('type', function ($customers) {
            if ($customers->type == 0) return '<button class="btn_act2 warning">Non-Member</button>';
            if ($customers->type == 1) return '<button class="btn_act2">Member</button>';
            return 'Cancel';
        }) 
        // ->addColumn('action', '
        // <a href="JavaScript:void()" id="edit-customer"  data-id={{$id}}><i class="fa fa-pencil"></i></a>
        // <a  href={{ route(\'sale_manager.deleteTeam\',$id) }} class="trash"><i class="fa fa-trash"></i></a>
        //    ')
        ->rawColumns(['mergeColumn','email','city','mobile','type'])
        ->make(true);
    }
    
    function deleteCustomer($id){
        $customer = Customer::where('id',$id)->delete();
        return redirect()->back()->with('success','Deleted sucessfully');
    }
    
    public function updateCustomer(Request $request)
    { 
        if($request->has(['id','first_name','email','city','phone_number']) 
        && $inputs=$request->only(['id','first_name','email','city','phone_number'])){
            $id=$request->input('id');
            $first_name=$request->input('first_name');
            $email=$request->input('email');
            $phone_number=$request->input('phone_number');
            $city=$request->input('city');
            $data=array('id'=>$id,'first_name'=>$first_name,'email'=>$email,'phone_number'=>$phone_number,'city'=>$city);
            Customer::where('id',$id)->update($data);
            return redirect()->back()->with('success','Succesfully updated');    
        }else{
                return redirect()->back()->withErrors('Invalid Parameters');    
            }    
    }
    public function getCities($id)
    {
        $cities= DB::table("us_cities")
                    ->where("ID_STATE",$id)
                    ->pluck("city","id");
        return response()->json($cities);
    }
    public function MemberDetail(Request $request,$id,$search_type){
		
		$data = DB::table('users')->where('users.id', $id);
		
		if($search_type == 1){
            $data->LeftJoin('tbl_membership', function($query) use($id){
                //$query->on( 'tbl_membership.user_id', '=',$id );
                $query->where('tbl_membership.user_id', '=' , $id);
                $query->where('tbl_membership.expire_at', '>' , date('Y-m-d').' 00:00:00');
                
            });
            $data->Join('membership_master', 'tbl_membership.membership_type', '=', 'membership_master.id');
			
			

		}
        $data->leftJoin('user_detail', 'users.id', '=', 'user_detail.user_id');
        $data->leftJoin("us_states",function($query){
            $query->on("us_states.ID","=",'user_detail.state');
        });
        $data->leftJoin("us_cities",function($query){
            $query->on("us_cities.ID","=",'user_detail.city');
        });
			/* $query = str_replace(array('?'), array('\'%s\''), $data->toSql());
            $queryss = vsprintf($query, $data->getBindings());
            dump($queryss);
			die; */
			$deposite = "";
        if($search_type == 1){
            $member                     =   $data->orderBy("tbl_membership.id","desc")->get(['users.status AS member_status','users.created_at AS registration_date','us_states.ID AS state_id','us_states.STATE_NAME AS state_name','us_cities.CITY AS city_name','membership_master.type as name','membership_master.type AS membershiptype','users.type AS user_type','users.id AS user_primary_id','users.email', 'tbl_membership.created_at AS membership_purchase_date' , 'tbl_membership.*', 'user_detail.*'])->first();

            $membership_purchase_date   =   Carbon::create($member->membership_purchase_date);
            $expiry_date                =   Carbon::create($member->expire_at);
			
			$date=strtotime($member->expire_at);
			$daysLeft=ceil(($date-time())/(60*60*24));
			
			$deposite = Deposite::where("id",$member->trans_id)->where("user_id",$id)->first();
			
        }
        if($search_type == 0){
			
            $expiry_date = '';
            $daysLeft ='';
            $member                   =   $data->get(['users.status AS member_status','users.created_at AS registration_date','us_states.ID AS state_id','us_states.STATE_NAME AS state_name','us_cities.CITY AS city_name','users.type AS user_type','users.id AS user_primary_id','users.email' ,  'user_detail.*'])->first();
			

		}
		if($member->phone !=""){
            $phone = $member->phone;
            $member->phone = "(".substr($phone, 0, 3).") ".substr($phone, 3, 3)."-".substr($phone,6);

        }
      
		if($member->state_id !=""){
		   
		   $state_manager = User::with('detail')->where('role','4')
			->whereHas('detail', function ($query) use($member) {
				$query->where('state',$member->state_id );
				$query->select('f_name','l_name' );
			})->first();
			
			/* $query = str_replace(array('?'), array('\'%s\''), $state_manager->toSql());
            $queryss = vsprintf($query, $state_manager->getBindings());
            dump($queryss);  */
			
			$city_sale_executive = User::with('detail')->where('role','5')
				->whereHas('detail', function ($query) use($member) {
				$query->where('city',$member->state_id );
				$query->select('f_name','l_name' );
			})->first();
		}
		//die;
        $sale_managerName = "NA";
		$sale_executiveName = "NA";
        if( isset($state_manager) ){
            $sale_managerName = $state_manager->detail->f_name." ".$state_manager->detail->l_name; 

        }
		if( isset($city_sale_executive) ){
            $sale_executiveName = $state_manager->detail->f_name." ".$state_manager->detail->l_name; 

        }
       
        
		
		$data = DB::table('user_property')->where('user_property.status', '1')->where("user_property.user_id",$id)->where("user_property.trash",'0')
       ->LeftJoin('datatree', function($query){
           $query->on( 'user_property.property_id', '=', 'datatree.id');
       })->paginate(5);
       //echo "<pre>"; print_r($interested_properties); die;
       $highly_interested_properties = DB::table('user_property')->where('user_property.status', '2')->where("user_property.user_id",$id)->where("user_property.trash",'0')
       ->LeftJoin('datatree', function($query){
           $query->on( 'user_property.property_id', '=', 'datatree.id');
       })->paginate(5);
	   
	   
		$progressBar = 0;
	   
		if($daysLeft!=''){
			
			$progDiff = strtotime($member->expire_at) - strtotime($member->membership_purchase_date);
			$progExtraDay=abs(round($progDiff / 86400)); 

			$ReDiff = strtotime($member->membership_purchase_date) - strtotime(date("Y/m/d"));
			$ReDay=abs(round($ReDiff / 86400)); 

			$progressBar=round(($ReDay*100)/$progExtraDay);
			//$progressBar = round($daysLeft/100);
			
		}
	   
	   
	   //report purchased
	 
		$report_purchased_data = DB::table('tbl_purchased_records')->select('tbl_purchased_records.report_name',
		'tbl_purchased_records.created_at AS date','points_transaction.point')
		->leftJoin('points_transaction', 'tbl_purchased_records.point_id', '=', 'points_transaction.id')
		->leftJoin('users', 'tbl_purchased_records.user_id', '=', 'users.id')
		->where('tbl_purchased_records.user_id',$id )->get();
		
		$report_purchased_count = $report_purchased_data->count();

        return view('SalemanagerDashboard/member/memberDetail',compact('report_purchased_count','sale_executiveName','sale_managerName','member','expiry_date','daysLeft','search_type','data','highly_interested_properties', 'progressBar' ,'deposite'));
       // return view('SalemanagerDashboard/member/memberDetail',compact('sale_executiveName','sale_managerName','member','expiry_date','daysLeft','search_type','data','highly_interested_properties', 'progressBar'));
    }

    public function memberSearch(Request $request)
    {
                   
        if(!empty($request->all()))
        {
            $search_type =  $request->type;
            $data = DB::table('users')->where('role', '0')
            ->LeftJoin('tbl_membership', function($query){
                $query->on( 'users.id', '=', 'tbl_membership.user_id');
                $query->where('tbl_membership.expire_at', '>' , date('Y-m-d').' 00:00:00');
            })
            ->leftJoin('user_detail', 'users.id', '=', 'user_detail.user_id');                                                      
            if ($search_type == 1) {
                //$data->where('tbl_membership.expire_at', '>=', now());
                $data->whereNotNull('tbl_membership.expire_at') ;
                $data->groupBy('tbl_membership.user_id');
            }
            if ($search_type == 0) {
          
                $data->whereNull('tbl_membership.expire_at');
            }
           
            if( $request->city){
                $data->where('user_detail.city', 'LIKE', "%" . $request->city . "%");
            }
            if( $request->postal_code){
                // return 'here';

                $data->where('postal', 'LIKE', "%" . $request->postal_code . "%");
            }
            
            if( $request->membership_start_date_from ){
                $membership_start_date_from = date('Y-m-d', strtotime(str_replace('-', '/', $request->get('membership_start_date_from'))));
                $data->where('tbl_membership.created_at','>=', $membership_start_date_from);
                
            }
            if($request->membership_start_date_to){
                $membership_start_date_to = date('Y-m-d', strtotime(str_replace('-', '/', $request->get('membership_start_date_to'))));
                $data->where('tbl_membership.created_at  ','<=', $membership_start_date_to);
            }
            

            $customers = $data->get(['users.id AS user_primary_id', 'users.*',
             'tbl_membership.created_at AS membership_purchase_date' , 'tbl_membership.*', 'user_detail.*']);

        
            return view('SalemanagerDashboard/member/memberSearchResult',compact('customers','search_type'));

        
        } else {
            return redirect('salemanager/member');
        }
      
    }

    public function savedSearchList(Request $request){

         if($request->ajax())
        {
			if($request->get('type') == "get_saved_search_detail"){
				$data = Saved::select('search')->where("unique_id",$request->get('unique_id'))->first();
				$data_array = json_decode($data->search);
				return response()->json(['success'=>true,'data'=>$data_array]); 
			}
            if($request->get('type') == "saved_search"){
                if(!empty($request->get('date_from')) || !empty($request->get('date_to')))
                {
                    $data = DB::table('tbl_saved_search')->select('tbl_saved_search.unique_id','tbl_saved_search.created_at AS date','user_detail.f_name','user_detail.l_name')
                    ->leftJoin('users', 'tbl_saved_search.user_id', '=', 'users.id')
                    ->leftJoin('user_detail', 'tbl_saved_search.user_id', '=', 'user_detail.user_id');
                    if($request->date_from != '' && $request->date_to !=''){
                        // echo 'HERE';
                         $membership_start_date_from = date('Y-m-d', strtotime(str_replace('-', '/', $request->get('date_from'))));
                         $membership_start_date_to = date('Y-m-d', strtotime(str_replace('-', '/', $request->get('date_to'))));
                         $data->whereBetween('tbl_saved_search.created_at',array($membership_start_date_from. ' 00:00:00', $membership_start_date_to . ' 23:59:59'));
                     }
                     if($request->date_from == '' && $request->date_to !=''){
                         //echo 'HERE2';
                         $membership_start_date_to = date('Y-m-d', strtotime(str_replace('-', '/', $request->get('date_to'))));
                         $data->where('tbl_saved_search.created_at','<=',$membership_start_date_to . ' 23:59:59');
                     }
                     if($request->date_from != '' && $request->date_to ==''){
                         //echo 'HERE3';
                         $membership_start_date_from = date('Y-m-d', strtotime(str_replace('-', '/', $request->get('date_from'))));
                         $data->where('tbl_saved_search.created_at', '>=',$membership_start_date_from . ' 00:00:00');
                     }
                     $data->where('tbl_saved_search.user_id',$request->get('user_id') );
                     $datatables =  app('datatables')->of($data)
                     ->addColumn('date', function($row){
                         $created_at = date('d-m-Y', strtotime(str_replace('-', '/', $row->date)));
                         return $created_at;
                     })
                     ->addColumn('name', function($row){
                         
                         return \ucfirst( $row->f_name)." ".\ucfirst($row->l_name);
                     })
					 ->addColumn('action', function($row){
					
							return '<a href="#" data-id="'.$row->unique_id.'" class="btn btn-success view_save_search_button">View Detail</a>';
					})->rawColumns(['action']);
                    
     
                     return $datatables->make(true);
                    
                }
                $data = DB::table('tbl_saved_search')->select('tbl_saved_search.unique_id','tbl_saved_search.created_at AS date','user_detail.f_name','user_detail.l_name')
                ->leftJoin('users', 'tbl_saved_search.user_id', '=', 'users.id')
                ->leftJoin('user_detail', 'tbl_saved_search.user_id', '=', 'user_detail.user_id')
                ->where('tbl_saved_search.user_id',$request->get('user_id') );
                $datatables =  app('datatables')->of($data)
                ->addColumn('date', function($row){
                    $created_at = date('d-M-yy', strtotime(str_replace('-', '/', $row->date)));
                    return $created_at;
                })
                ->addColumn('name', function($row){
                    
                    return \ucfirst( $row->f_name)." ".\ucfirst($row->l_name);
                })
				->addColumn('action', function($row){
                    
                    return '<a href="#" data-id="'.$row->unique_id.'" class="btn btn-success view_save_search_button">View Detail</a>';
                })->rawColumns(['action']);

                return $datatables->make(true);
            }

            if($request->get('type') == "purchased_record"){
                if(!empty($request->get('date_from_purchase')) || !empty($request->get('date_to_purchase')))
                {
                    $data = DB::table('tbl_purchased_records')->select('tbl_purchased_records.report_name',
                    'tbl_purchased_records.created_at AS date','points_transaction.point')
                    ->leftJoin('points_transaction', 'tbl_purchased_records.point_id', '=', 'points_transaction.id')
                    ->leftJoin('users', 'tbl_purchased_records.user_id', '=', 'users.id');

                    if($request->date_from_purchase != '' && $request->date_to_purchase !=''){
                        // echo 'HERE';
                         $membership_start_date_from = date('Y-m-d', strtotime(str_replace('-', '/', $request->get('date_from_purchase'))));
                         $membership_start_date_to = date('Y-m-d', strtotime(str_replace('-', '/', $request->get('date_to_purchase'))));
                         $data->whereBetween('tbl_purchased_records.created_at',array($membership_start_date_from. ' 00:00:00', $membership_start_date_to . ' 23:59:59'));
                     }
                     if($request->date_from_purchase == '' && $request->date_to_purchase !=''){
                         //echo 'HERE2';
                         $membership_start_date_to = date('Y-m-d', strtotime(str_replace('-', '/', $request->get('date_to_purchase'))));
                         $data->where('tbl_purchased_records.created_at','<=',$membership_start_date_to . ' 23:59:59');
                     }
                     if($request->date_from_purchase != '' && $request->date_to_purchase ==''){
                         //echo 'HERE3';
                         $membership_start_date_from = date('Y-m-d', strtotime(str_replace('-', '/', $request->get('date_from_purchase'))));
                         $data->where('tbl_purchased_records.created_at', '>=',$membership_start_date_from . ' 00:00:00');
                     }
                     $data->where('tbl_purchased_records.user_id',$request->get('user_id') );
                     $datatables =  app('datatables')->of($data)
                     ->addColumn('date', function($row){
                         $created_at = date('d-M-yy', strtotime(str_replace('-', '/', $row->date)));
                         return $created_at;
                     }) 
					 ->addColumn('time', function($row){
                  
						$created_at = date('h:i A', strtotime(str_replace('-', '/', $row->date)));
						return $created_at;
					});
                    //  ->addColumn('action', '<a href="#" class="btn btn-success">View Detail</a>')
                    //  ->rawColumns(['action']);
                    
     
                     return $datatables->make(true);
                    
                }
                $data = DB::table('tbl_purchased_records')->select('tbl_purchased_records.report_name',
                    'tbl_purchased_records.created_at AS date','points_transaction.point')
                    ->leftJoin('points_transaction', 'tbl_purchased_records.point_id', '=', 'points_transaction.id')
                    ->leftJoin('users', 'tbl_purchased_records.user_id', '=', 'users.id')
                    ->where('tbl_purchased_records.user_id',$request->get('user_id') );
                $datatables =  app('datatables')->of($data)
                ->addColumn('date', function($row){
                    $created_at = date('d-M-yy', strtotime(str_replace('-', '/', $row->date)));
                    return $created_at;
                })
                ->addColumn('time', function($row){
                  
                    $created_at = date('h:i A', strtotime(str_replace('-', '/', $row->date)));
                    return $created_at;
                });

                return $datatables->make(true);
            }
            
            if($request->get('type') == "transaction_record_credit"){
                if(!empty($request->get('date_from_trans')) || !empty($request->get('date_to_trans')))
                {
                    $data = DB::table('points_transaction')->select('points_transaction.created_at AS date','points_transaction.point',
                    'tbl_deposite.amount','tbl_deposite.brand AS payment_method','tbl_deposite.balance_transaction AS txn')
                    ->leftJoin('users', 'points_transaction.user_id', '=', 'users.id')
                    ->leftJoin('tbl_deposite', 'points_transaction.trans_id', '=', 'tbl_deposite.id');

                    if($request->date_from_trans != '' && $request->date_to_trans !=''){
                        // echo 'HERE';
                         $membership_start_date_from = date('Y-m-d', strtotime(str_replace('-', '/', $request->get('date_from_trans'))));
                         $membership_start_date_to = date('Y-m-d', strtotime(str_replace('-', '/', $request->get('date_to_trans'))));
                         $data->whereBetween('points_transaction.created_at',array($membership_start_date_from. ' 00:00:00', $membership_start_date_to . ' 23:59:59'));
                     }
                     if($request->date_from_trans == '' && $request->date_to_trans !=''){
                         //echo 'HERE2';
                         $membership_start_date_to = date('Y-m-d', strtotime(str_replace('-', '/', $request->get('date_to_trans'))));
                         $data->where('points_transaction.created_at','<=',$membership_start_date_to . ' 23:59:59');
                     }
                     if($request->date_from_trans != '' && $request->date_to_trans ==''){
                         //echo 'HERE3';
                         $membership_start_date_from = date('Y-m-d', strtotime(str_replace('-', '/', $request->get('date_from_trans'))));
                         $data->where('points_transaction.created_at', '>=',$membership_start_date_from . ' 00:00:00');
                     }
                     $data->where('points_transaction.user_id',$request->get('user_id') )->where('points_transaction.type',1);
                     $datatables =  app('datatables')->of($data)
                     ->addColumn('date', function($row){
                         $created_at = date('d-M-yy', strtotime(str_replace('-', '/', $row->date)));
                         return $created_at;
                     });
                    //  ->addColumn('action', '<a href="#" class="btn btn-success">View Detail</a>')
                    //  ->rawColumns(['action']);
                    
     
                     return $datatables->make(true);
                    
                }
                $data = DB::table('points_transaction')->select('points_transaction.created_at AS date','points_transaction.point',
                    'tbl_deposite.amount','tbl_deposite.brand AS payment_method','tbl_deposite.balance_transaction AS txn')
                    ->leftJoin('users', 'points_transaction.user_id', '=', 'users.id')
                    ->leftJoin('tbl_deposite', 'points_transaction.trans_id', '=', 'tbl_deposite.id')
                    ->where('points_transaction.user_id',$request->get('user_id') )->where('points_transaction.type',1);
                $datatables =  app('datatables')->of($data)
                ->addColumn('date', function($row){
                    $created_at = date('d-M-yy', strtotime(str_replace('-', '/', $row->date)));
                    return $created_at;
                });

                return $datatables->make(true);
            }


            if($request->get('type') == "transaction_record_debit"){
                if(!empty($request->get('date_from_trans')) || !empty($request->get('date_to_trans')))
                {
                    $data = DB::table('points_transaction')->select('points_transaction.created_at AS date','points_transaction.point',
                   'tbl_purchased_records.report_name AS debit_type')
                    ->leftJoin('users', 'points_transaction.user_id', '=', 'users.id')
                    ->leftJoin('tbl_purchased_records', 'points_transaction.id', '=', 'tbl_purchased_records.point_id');

                    if($request->date_from_trans != '' && $request->date_to_trans !=''){
                         //echo 'HERE';
                         $membership_start_date_from = date('Y-m-d', strtotime(str_replace('-', '/', $request->get('date_from_trans'))));
                         $membership_start_date_to = date('Y-m-d', strtotime(str_replace('-', '/', $request->get('date_to_trans'))));
                         $data->whereBetween('points_transaction.created_at',array($membership_start_date_from. ' 00:00:00', $membership_start_date_to . ' 23:59:59'));
                     }
                     if($request->date_from_trans == '' && $request->date_to_trans !=''){
                         //echo 'HERE2';
                         $membership_start_date_to = date('Y-m-d', strtotime(str_replace('-', '/', $request->get('date_to_trans'))));
                         $data->where('points_transaction.created_at','<=',$membership_start_date_to . ' 23:59:59');
                     }
                     if($request->date_from_trans != '' && $request->date_to_trans ==''){
                         //echo 'HERE3';
                         $membership_start_date_from = date('Y-m-d', strtotime(str_replace('-', '/', $request->get('date_from_trans'))));
                         $data->where('points_transaction.created_at', '>=',$membership_start_date_from . ' 00:00:00');
                     }
                     $data->where('points_transaction.user_id',$request->get('user_id') )->where('points_transaction.type',2);
                     $datatables =  app('datatables')->of($data)
                     ->addColumn('date', function($row){
                         $created_at = date('d-M-yy', strtotime(str_replace('-', '/', $row->date)));
                         return $created_at;
                     });
                    //  ->addColumn('action', '<a href="#" class="btn btn-success">View Detail</a>')
                    //  ->rawColumns(['action']);
                    
     
                     return $datatables->make(true);
                    
                }
                $data = DB::table('points_transaction')->select('points_transaction.created_at AS date','points_transaction.point',
                   'tbl_purchased_records.report_name AS debit_type')
                    ->leftJoin('users', 'points_transaction.user_id', '=', 'users.id')
                    ->leftJoin('tbl_purchased_records', 'points_transaction.id', '=', 'tbl_purchased_records.point_id')
                    ->where('points_transaction.user_id',$request->get('user_id') )->where('points_transaction.type',2);
                $datatables =  app('datatables')->of($data)
                ->addColumn('date', function($row){
                    $created_at = date('d-M-yy', strtotime(str_replace('-', '/', $row->date)));
                    return $created_at;
                });

                return $datatables->make(true);
            }
			
			if($request->get('type') == "#interested_properties"){
                $data = DB::table('user_property')->where('user_property.status', '1')->where("user_property.user_id",$request->get('user_id'))->where("user_property.trash",'0')
                ->LeftJoin('datatree', function($query){
                    $query->on( 'user_property.property_id', '=', 'datatree.id');
                })->paginate(5);
                return view('SalemanagerDashboard/member/propertiesResult', compact('data'));   
                
            } 
            
            if($request->get('type') == "deactivate_member"){
                
                $user = User::where('id', $request->get('user_id'))->update(['status' =>  $request->get('status')]);
                if($user){
                    if($request->get('status') == '1'){
                        $message = "Activated";
                        $button = '<a data-id="0" href="javascript:void(0);" class="btn btn-danger updateStatus">Deactivate <i class="fa fa-user-times"></i></a>';
                    }else{
                         
                        $message = "Deactivated"; 
                        $button = '<a data-id="1" href="javascript:void(0);" class="btn btn-success updateStatus">Activate <i class="fa fa-user-times"></i></a>';
                    }
                    return response()->json(['success'=>$message,'button'=>$button]);
                }
                return  response()->json(['error'=>'Cancelled']);
            }

            if($request->get('type') == "#highly_interested_properties"){
                $highly_interested_properties = DB::table('user_property')->where('user_property.status', '2')->where("user_property.user_id",$request->get('user_id'))->where("user_property.trash",'0')
                ->LeftJoin('datatree', function($query){
                    $query->on( 'user_property.property_id', '=', 'datatree.id');
                })->paginate(5);
               return view('SalemanagerDashboard/member/highPropertiesResult', compact('highly_interested_properties'));   
                
            } 
        }
    }
}

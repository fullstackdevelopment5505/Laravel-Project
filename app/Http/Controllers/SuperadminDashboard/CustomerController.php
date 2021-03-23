<?php

namespace App\Http\Controllers\SuperadminDashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;
use Validator, Response, DB, DataTables;
use App\Model\Customer;
use App\User;
use App\Member;
use App\Model\Saved;
use App\Model\Deposite;
use App\Model\PropertyResultId;
use App\Model\UserProperty;
use Carbon\Carbon;
use App\Model\CancelMembershipRequest;

class CustomerController extends Controller
{
    public function index($value='')
    {
		$customers = User::with('membership', 'member', 'detail')->get();

        return view('SuperadminDashboard.member',compact('customers'));
    }

    public function member(){
        $states =  DB::table('state_county_fib')->groupBy('state_val')->orderBy('id','asc')->get();
        return view('SuperadminDashboard.member.member',compact('states'));
    }

	public function CustomersList(Request $request){
        $states =  DB::table('state_county_fib')->groupBy('state_val')->orderBy('id','asc')->get();
		$name = $request->get('name') ? $request->get('name'):'';
		$postal = $request->get('postal')? $request->get('postal'):'';
		$query = User::with('member','subscription','Image');
		if($request->name!='')
        {
			$query->where('f_name', 'like', "%" . $name . "%");
        }
		if($request->postal!='')
        {
			$query->where('postal', 'like', "%" . $postal . "%");
        }
		if($request->email!='')
        {
           $query->where('email', '=',  $request->email);
        }
		if($request->date_created_start != '' && $request->date_created_end !=''){
			// echo 'HERE';
			$membership_start_date_from = date('Y-m-d', strtotime($request->get('date_created_start')));
			$membership_start_date_to = date('Y-m-d', strtotime($request->get('date_created_end')));
			$query->whereBetween('users.created_at',array($membership_start_date_from. ' 00:00:00', $membership_start_date_to . ' 23:59:59'));
		}
		if($request->date_created_start == '' && $request->date_created_end !=''){
			//echo 'HERE2';
			$membership_start_date_to = date('Y-m-d', strtotime($request->get('date_created_end')));
			$query->where('users.created_at','<=',$membership_start_date_to . ' 23:59:59');
		}
		if($request->date_created_start != '' && $request->date_created_end ==''){
			//echo 'HERE3';
			$membership_start_date_from = date('Y-m-d', strtotime($request->get('date_created_start')));
			$query->where('users.created_at', '>=',$membership_start_date_from . ' 00:00:00');
		}
		$users = $query->join('user_detail','users.id','=','user_detail.user_id')
		->select('users.*',DB::raw('(CASE WHEN email <> "" THEN 1 END) as prospect'),'user_detail.f_name','user_detail.phone','user_detail.postal')
		        ->where('role',0)->get();

		$customers = [];
		$i=0;
		foreach($users as $key => $data){

			if(isset($data->subscription)){
				$end = date('Y-m-d',strtotime($data->subscription->plan_period_end));
				if($end >= date('Y-m-d')){

					$data->prospect = 0;
					array_push($customers,$data);
					$i++;
				}
			}
		}
		if(request()->ajax()) {
			//echo "<pre>"; print_r($users);
			//die;
			//echo "<pre>"; print_r($user); die;
            return DataTables::of($customers)

            ->addColumn('name', function($row){

              return isset($row->f_name)? \ucfirst( $row->f_name) : '';

            })
			->addColumn('accepted_terms', function($row){

				return $row->accepted_terms==1 ? 'Yes' : 'No';

            })
            ->addColumn('join_date', function($row){
                return date('d-M-yy', strtotime(str_replace('-', '/', $row->created_at)));
            })
            ->addColumn('action', function($row) {
				$button = "<a href='".\URL::route('superadmin.member.detail',['id'=>$row->id,'type'=>1])."' class='btn btn-success'>
				<span><strong>View Detail</strong></a>";

			   return $button;
            })
            ->addIndexColumn()
            ->rawColumns(['action'])
            ->make(true);
        }

        return view('SuperadminDashboard.member.CustomersList',compact('states','customers'));
    }

	public function ProspectsList(Request $request){
		$name = $request->get('name') ? $request->get('name'):'';
		$postal = $request->get('postal')? $request->get('postal'):'';
		$states =  DB::table('state_county_fib')->groupBy('state_val')->orderBy('id','asc')->get();
		$query = User::with('member','subscription','Image');


		if($request->name!='')
        {
			$query->where('f_name', 'like', "%" . $name . "%");
        }
		if($request->postal!='')
        {
			$query->where('postal', 'like', "%" . $postal . "%");
        }
		if($request->email!='')
        {
           $query->where('email', '=',  $request->email);
        }
		if($request->date_created_start != '' && $request->date_created_end !=''){
			// echo 'HERE';
			$membership_start_date_from = date('Y-m-d', strtotime($request->get('date_created_start')));
			$membership_start_date_to = date('Y-m-d', strtotime($request->get('date_created_end')));
			$query->whereBetween('users.created_at',array($membership_start_date_from. ' 00:00:00', $membership_start_date_to . ' 23:59:59'));
		}
		if($request->date_created_start == '' && $request->date_created_end !=''){
			//echo 'HERE2';
			$membership_start_date_to = date('Y-m-d', strtotime($request->get('date_created_end')));
			$query->where('users.created_at','<=',$membership_start_date_to . ' 23:59:59');
		}
		if($request->date_created_start != '' && $request->date_created_end ==''){
			//echo 'HERE3';
			$membership_start_date_from = date('Y-m-d', strtotime($request->get('date_created_start')));
			$query->where('users.created_at', '>=',$membership_start_date_from . ' 00:00:00');
		}
		$users = $query->join('user_detail','users.id','=','user_detail.user_id')
				->select('users.*',DB::raw('(CASE WHEN email <> "" THEN 0 END) as prospect'),'user_detail.f_name','user_detail.phone','user_detail.postal')
		        ->where('role',0)->get();
		$prospects = [];
		foreach($users as $key => $data){

			if(isset($data->subscription)){
				$end = date('Y-m-d',strtotime($data->subscription->plan_period_end));
				if($end < date('Y-m-d')){

					$data->prospect = 1;
					array_push($prospects,$data);
				}
				//echo date('Y-m-d',strtotime($end));
				//echo "<br />";

			}else{

				array_push($prospects,$data);
			}

		}
		//echo "<pre>"; print_r(array($prospects));

		//die;

		if(request()->ajax()) {
			//echo "<pre>"; print_r($user); die;
            return DataTables::of($prospects)
            ->addColumn('name', function($row){

              return isset($row->f_name)? \ucfirst( $row->f_name) : '';

            })
			->addColumn('accepted_terms', function($row){

				return $row->accepted_terms==1 ? 'Yes' : 'No';

            })
            ->addColumn('join_date', function($row){
                return date('d-M-yy', strtotime(str_replace('-', '/', $row->created_at)));
            })
            ->addColumn('action', function($row) {
				$button = "<a href='".\URL::route('superadmin.member.detail',['id'=>$row->id,'type'=>0])."' class='btn btn-success'>
				<span><strong>View Detail</strong></a>";

			   return $button;
            })
            ->addIndexColumn()
            ->rawColumns(['action'])
            ->make(true);
        }

        return view('SuperadminDashboard.member.ProspectsList',compact('states','prospects'));
    }

	public function AllMembers(Request $request){
		$states =  DB::table('state_county_fib')->groupBy('state_val')->orderBy('id','asc')->get();
        $query =  User::with('member','subscription');
		if($request->name!='')
        {
			$query->where('f_name', 'like', "%" . $request->name . "%");
        }
		if($request->postal!='')
        {
			$query->where('postal', 'like', "%" .$request->postal . "%");
        }
		if($request->email!='')
        {
           $query->where('email', '=',  $request->email);
        }
		if($request->date_created_start != '' && $request->date_created_end !=''){
			// echo 'HERE';
			$membership_start_date_from = date('Y-m-d', strtotime($request->get('date_created_start')));
			$membership_start_date_to = date('Y-m-d', strtotime($request->get('date_created_end')));
			$query->whereBetween('users.created_at',array($membership_start_date_from. ' 00:00:00', $membership_start_date_to . ' 23:59:59'));
		}
		if($request->date_created_start == '' && $request->date_created_end !=''){
			//echo 'HERE2';
			$membership_start_date_to = date('Y-m-d', strtotime($request->get('date_created_end')));
			$query->where('users.created_at','<=',$membership_start_date_to . ' 23:59:59');
		}
		if($request->date_created_start != '' && $request->date_created_end ==''){
			//echo 'HERE3';
			$membership_start_date_from = date('Y-m-d', strtotime($request->get('date_created_start')));
			$query->where('users.created_at', '>=',$membership_start_date_from . ' 00:00:00');
		}
		$users = $query->join('user_detail','users.id','=','user_detail.user_id')
				->select('users.*',DB::raw('(CASE WHEN email <> "" THEN 1 END) as member_type'),'user_detail.f_name','user_detail.phone','user_detail.postal')
				->where('role',0)
				->get();
		$allMembers = [];
		foreach($users as $key => $data){

			if(isset($data->subscription)){
				$end = date('Y-m-d',strtotime($data->subscription->plan_period_end));
				if($end >= date('Y-m-d')){

					$data->member_type = 1;
					array_push($allMembers,$data);
				}
				if($end < date('Y-m-d')){

					$data->member_type = 0;
					array_push($allMembers,$data);
				}
				//echo date('Y-m-d',strtotime($end));
				//echo "<br />";

			}else{

				$data->member_type = 0;
				array_push($allMembers,$data);
			}

		}


		if(request()->ajax()) {
			//echo "<pre>"; print_r($user); die;
            return DataTables::of($allMembers)
            ->addColumn('name', function($row){

              return isset($row->f_name)? \ucfirst( $row->f_name) : '';

            })
			->addColumn('accepted_terms', function($row){

				return $row->accepted_terms==1 ? 'Yes' : 'No';

            })
			->addColumn('member', function($row){

				return $row->member_type==1 ? 'Customer' : 'Prospect';

            })
            ->addColumn('join_date', function($row){
                return date('d-M-yy', strtotime(str_replace('-', '/', $row->created_at)));
            })
            ->addColumn('action', function($row) {
				$button = "<a href='".\URL::route('superadmin.member.detail',['id'=>$row->id,'type'=>$row->member_type])."' class='btn btn-success'>
				<span><strong>View Detail</strong></a>";

			   return $button;
            })
            ->addIndexColumn()
            ->rawColumns(['action'])
            ->make(true);
        }

        return view('SuperadminDashboard.member.AllMembersList',compact('states','allMembers'));
    }

	public function cancelMembershipTicketDetail($id){
        $data =  CancelMembershipRequest::with('users.details','users.Image','users.subscription')->where('id',$id)->orderBy('created_at','desc')->first();
		$state = isset($data->users->details->state) ? $data->users->details->state : 0;
		$statedata = DB::table('state_county_fib')->where("state_val",$state)->orderBy('id','asc')->pluck('state_name');
		$reason = json_decode($data->reason);
		$profileimage='';
		if(isset($detail->Image)){

			$profileimage=$detail->Image->filename;
		}
		$user_type = '0';

		if(isset($data->users->subscription)){
			if($data->users->subscription->status == "active"){
				$user_type = '1';
			}
		}
		 //echo "<pre>"; print_r($data->users->subscription); die;
        return view('SuperadminDashboard.membershipTicket.TicketDetail',compact('data','reason','user_type','profileimage'));
    }
	public function OpenTicket(){
        $data =  CancelMembershipRequest::select('*',DB::raw("DATE_FORMAT(created_at,'%h:%i %p') AS time"))
		->with('users.details')->where('status','0')->orderBy('tbl_cancel_membership_request.id','desc')->get();
		/* echo "<pre>"; print_r($data);
		die; */
		/*  foreach($data as $k => $v){

			//echo "<pre>"; print_r($v->users);
			echo isset($v->users->email) ? $v->users->email: '' ;
			echo isset($v->users->details->f_name) ? $v->users->details->f_name: '' ;
		}
		die;  */
        return view('SuperadminDashboard.membershipTicket.OpenTicketList',compact('data'));
    }

	public function ClosedTicket(){
        $data =  CancelMembershipRequest::with('users.details')->select('*',DB::raw("DATE_FORMAT(created_at,'%h:%i %p') AS time"))
		->where('status','1')->orderBy('tbl_cancel_membership_request.id','desc')->get();
        return view('SuperadminDashboard.membershipTicket.ClosedTicketList',compact('data'));
    }

	function recursiveArray($array){
		$html = '';
		foreach($array as $key => $value){
			//If $value is an array.
			if(is_array($value)){
				if($key=='state'){
					$html .=  '<tr><td><b>' .$key. '</b></td><td>' .$value['text']. '</td></tr>';

				}else{
					if($value != array_keys($value)){
						$arr = [];
						foreach($value as $key1 => $val){
							if(isset($val['text'])){
								$arr[$key1] = $val['text'];
							}
						}
						if(isset($value['month']) && isset($value['day']) && isset($value['year'])){

							$date =  $value['year']."-".$value['month']."-".$value['day'];
							$daten =   date("d-M-Y", strtotime($date));
							$arr[] =$daten;
						}
						$List = implode(', ', $arr);
						$html .=  '<tr><td><b>' .$key. '</b></td><td>'.$List.' </td></tr>';

					}
				}
				//We need to loop through it.
				//$this->recursiveArray($value);
			} else{
				//It is not an array, so print it out.
				$html .=  '<tr><td><b>' .$key. '</b></td><td>' .$value. '</td></tr>';
			}
		}
		return $html;
	}

	public function savedSearchList(Request $request){

        if($request->ajax())
        {
			if($request->get('type') == "resolve_cancel_membership_request"){

                $ticketdata = CancelMembershipRequest::where('id', $request->get('id'))->where('user_id', $request->get('user_id'))->update(['status' =>  '1']);
                if($ticketdata){
                    return response()->json(['success'=>'Request resolved successfully.']);
                }
                return  response()->json(['error'=>'Invalid request!']);
            }

			if($request->get('type') == "delete_member"){
				if($request->get('user_id') > 0){
					$id = $request->get('user_id');
					DB::table('user_detail')->where('user_id','=',$id)->delete();
					DB::table('tbl_membership')->where('user_id','=',$id)->delete();
					DB::table('user_subscriptions')->where('user_id','=',$id)->delete();
					DB::table('tbl_deposite')->where('user_id','=',$id)->delete();
					DB::table('points_transaction')->where('user_id','=',$id)->delete();
					DB::table('tbl_purchased_records')->where('user_id','=',$id)->delete();
					DB::table('tbl_saved_search')->where('user_id','=',$id)->delete();
					DB::table('results')->where('user_id','=',$id)->delete();
					DB::table('property_result_id')->where('user_id','=',$id)->delete();
					DB::table('user_property')->where('user_id','=',$id)->delete();
					DB::table('tbl_contact_logs')->where('user_id','=',$id)->delete();
					DB::table('tbl_manage_grid')->where('user_id','=',$id)->delete();
					DB::table('images')->where('user_id','=',$id)->delete();
					DB::table('users')->where('id','=',$id)->delete();
					return response()->json(['success'=>'user deleted successfully']);
				}
				return response()->json(['message'=>'error','error' => 'invalid user id']);
			}
			if($request->get('type') == "get_saved_search_detail"){
				$data = Saved::select('search')->where("unique_id",$request->get('unique_id'))->first();
				$data = json_decode($data->search, true);
				//echo "<pre>"; print_r($data); die;
				$html = '<table class="responsive nowrap display" width="100%"><thead><tr><th>Type</th><th>Value</th></tr></thead> <tbody> ';
				$html .= $this->recursiveArray($data);
				$html .= '</tbody> </table>';

				//echo $html; die;
				return response()->json(['success'=>true,'data'=>$html]);
			}
            if($request->get('type') == "saved_search"){
                if(!empty($request->get('date_from')) || !empty($request->get('date_to')))
                {

					$data=Saved::select("*",DB::raw("DATE_FORMAT(created_at,'%d-%b-%Y %H:%i:%s') AS date"));

                    if($request->date_from != '' && $request->date_to !=''){
                        // echo 'HERE';
                        $membership_start_date_from = date('Y-m-d', strtotime($request->get('date_from')));
                        $membership_start_date_to = date('Y-m-d',  strtotime($request->get('date_to')));
                        $data->whereBetween('created_at',array($membership_start_date_from. ' 00:00:00', $membership_start_date_to . ' 23:59:59'));
                     }
                     if($request->date_from == '' && $request->date_to !=''){
                        //echo 'HERE2';
                        $membership_start_date_to = date('Y-m-d', strtotime( $request->get('date_to')));
                        $data->where('created_at','<=',$membership_start_date_to . ' 23:59:59');
                     }
                     if($request->date_from != '' && $request->date_to ==''){
                         //echo 'HERE3';
                        $membership_start_date_from = date('Y-m-d', strtotime( $request->get('date_from')));
                        $data->where('created_at', '>=',$membership_start_date_from . ' 00:00:00');
                     }
                     $data->where('user_id',$request->get('user_id'))->orderBy('id','desc');
                     $datatables =  app('datatables')->of($data)

					->addColumn('action', function($row){
						return '<a href="#" data-id="'.$row->unique_id.'" class="btn btn-success view_save_search_button">View Detail</a>';
					})->rawColumns(['action']);

                    return $datatables->make(true);

                }

				$data=Saved::select("*",DB::raw("DATE_FORMAT(created_at,'%d-%b-%Y %H:%i:%s') AS date"))->where('user_id',$request->get('user_id'))->orderBy('id','desc');

                $datatables =  app('datatables')->of($data)

				->addColumn('action', function($row){

                    return '<a href="#" data-id="'.$row->unique_id.'" class="btn btn-success view_save_search_button">View Detail</a>';
                })->rawColumns(['action']);

                return $datatables->make(true);
            }

            if($request->get('type') == "purchased_record"){
                if(!empty($request->get('date_from_purchase')) || !empty($request->get('date_to_purchase')))
                {
					$member = $request->get('search_type');
					$data = PropertyResultId::select('id','user_id','property_id',DB::raw('DATE_FORMAT(created_at, "%d-%b-%Y %h:%i:%s") as date'),'purchase_group_name',DB::raw('count(result_id) as total'));

					/*  $data = DB::table('tbl_purchased_records')->select('tbl_purchased_records.report_name',
                    'tbl_purchased_records.created_at AS date','points_transaction.point')
                    ->leftJoin('points_transaction', 'tbl_purchased_records.point_id', '=', 'points_transaction.id')
                    ->leftJoin('users', 'tbl_purchased_records.user_id', '=', 'users.id');
					*/

                    if($request->date_from_purchase != '' && $request->date_to_purchase !=''){
                        // echo 'HERE';
                         $membership_start_date_from = date('Y-m-d', strtotime($request->get('date_from_purchase')));
                         $membership_start_date_to = date('Y-m-d', strtotime($request->get('date_to_purchase')));
                         $data->whereBetween('created_at',array($membership_start_date_from. ' 00:00:00', $membership_start_date_to . ' 23:59:59'));
                     }
                     if($request->date_from_purchase == '' && $request->date_to_purchase !=''){
                         //echo 'HERE2';
                         $membership_start_date_to = date('Y-m-d', strtotime($request->get('date_to_purchase')));
                         $data->where('created_at','<=',$membership_start_date_to . ' 23:59:59');
                     }
                     if($request->date_from_purchase != '' && $request->date_to_purchase ==''){
                         //echo 'HERE3';
                         $membership_start_date_from = date('Y-m-d', strtotime($request->get('date_from_purchase')));
                         $data->where('created_at', '>=',$membership_start_date_from . ' 00:00:00');
                     }
                    // $data->where('tbl_purchased_records.user_id',$request->get('user_id') );
					 $data->where('user_id',$request->get('user_id'))->where('trash', '0')->whereNotNull('purchase_group_name')->groupBy('result_id')->orderBy('id','desc');
                     $datatables =  app('datatables')->of($data)
                    /*  ->addColumn('date', function($row){
                         $created_at = date('d-M-yy', strtotime(str_replace('-', '/', $row->date)));
                         return $created_at;
                     })  */
					  ->addColumn('action', function($row) use($member){
						$button = '<a href="#" data-member="'.$member.'" data-user-id="'.$row->user_id.'" data-purchase-group-name="'.$row->purchase_group_name.'" class="btn btn-success purchase_detail_button">View Detail</a>';
						return $button;
					})
                    ->rawColumns(['action']);
                    return $datatables->make(true);

                }
                /* $data = DB::table('tbl_purchased_records')->select('tbl_purchased_records.report_name',
                    'tbl_purchased_records.created_at AS date','points_transaction.point')
                    ->leftJoin('points_transaction', 'tbl_purchased_records.point_id', '=', 'points_transaction.id')
                    ->leftJoin('users', 'tbl_purchased_records.user_id', '=', 'users.id')
                    ->where('tbl_purchased_records.user_id',$request->get('user_id') ); */

				$member = $request->get('search_type');
				$data = PropertyResultId::select('id','user_id','property_id',DB::raw('DATE_FORMAT(created_at, "%d-%b-%Y %h:%i:%s") as date'),'purchase_group_name',DB::raw('count(result_id) as total'))->where('user_id', $request->get('user_id'))->where('trash', '0')->whereNotNull('purchase_group_name')->groupBy('result_id')->orderBy('id','desc');

				$datatables =  app('datatables')->of($data)
                 ->addColumn('action', function($row) use($member){
                    $button = '<a href="#" data-member="'.$member.'" data-user-id="'.$row->user_id.'" data-purchase-group-name="'.$row->purchase_group_name.'" class="btn btn-success purchase_detail_button">View Detail</a>';
                    return $button;
				})
				->rawColumns(['action']);
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
                         $membership_start_date_from = date('Y-m-d', strtotime( $request->get('date_from_trans')));
                         $membership_start_date_to = date('Y-m-d', strtotime( $request->get('date_to_trans')));
                         $data->whereBetween('points_transaction.created_at',array($membership_start_date_from. ' 00:00:00', $membership_start_date_to . ' 23:59:59'));
                     }
                     if($request->date_from_trans == '' && $request->date_to_trans !=''){
                         //echo 'HERE2';
                         $membership_start_date_to = date('Y-m-d', strtotime($request->get('date_to_trans')));
                         $data->where('points_transaction.created_at','<=',$membership_start_date_to . ' 23:59:59');
                     }
                     if($request->date_from_trans != '' && $request->date_to_trans ==''){
                         //echo 'HERE3';
                         $membership_start_date_from = date('Y-m-d', strtotime( $request->get('date_from_trans')));
                         $data->where('points_transaction.created_at', '>=',$membership_start_date_from . ' 00:00:00');
                     }
                     $data->where('points_transaction.user_id',$request->get('user_id') )->where('points_transaction.type',1);
                     $datatables =  app('datatables')->of($data)
                     ->addColumn('date', function($row){
                         $created_at = date('d-M-yy', strtotime(str_replace('-', '/', $row->date)));
                         return $created_at;
                     })->addColumn('amount', function($row){

                         return "$".$row->amount;
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
                })->addColumn('amount', function($row){

                    return "$".$row->amount;
                });

                return $datatables->make(true);
            }


            if($request->get('type') == "transaction_record_debit"){
                if(!empty($request->get('date_from_trans')) || !empty($request->get('date_to_trans')))
                {
                    $data = DB::table('points_transaction')->select('points_transaction.created_at AS date','points_transaction.amount as point',
                   'tbl_purchased_records.report_name AS debit_type')
                    ->leftJoin('users', 'points_transaction.user_id', '=', 'users.id')
                    ->leftJoin('tbl_purchased_records', 'points_transaction.id', '=', 'tbl_purchased_records.point_id');

                    if($request->date_from_trans != '' && $request->date_to_trans !=''){
                         //echo 'HERE';
                         $membership_start_date_from = date('Y-m-d', strtotime($request->get('date_from_trans')));
                         $membership_start_date_to = date('Y-m-d', strtotime( $request->get('date_to_trans')));
                         $data->whereBetween('points_transaction.created_at',array($membership_start_date_from. ' 00:00:00', $membership_start_date_to . ' 23:59:59'));
                     }
                     if($request->date_from_trans == '' && $request->date_to_trans !=''){
                         //echo 'HERE2';
                         $membership_start_date_to = date('Y-m-d', strtotime( $request->get('date_to_trans')));
                         $data->where('points_transaction.created_at','<=',$membership_start_date_to . ' 23:59:59');
                     }
                     if($request->date_from_trans != '' && $request->date_to_trans ==''){
                         //echo 'HERE3';
                         $membership_start_date_from = date('Y-m-d', strtotime( $request->get('date_from_trans')));
                         $data->where('points_transaction.created_at', '>=',$membership_start_date_from . ' 00:00:00');
                     }
                     $data->where('points_transaction.user_id',$request->get('user_id') )->where('points_transaction.type',2)->orderBy('points_transaction.created_at','desc');
                     $datatables =  app('datatables')->of($data)
                     ->addColumn('date', function($row){
                         $created_at = date('d-M-yy', strtotime(str_replace('-', '/', $row->date)));
                         return $created_at;
                     })->addColumn('point', function($row){

						return "$".$row->point;
					});
                    //  ->addColumn('action', '<a href="#" class="btn btn-success">View Detail</a>')
                    //  ->rawColumns(['action']);


                     return $datatables->make(true);

                }
                $data = DB::table('points_transaction')->select('points_transaction.created_at AS date','points_transaction.amount as point',
                   'tbl_purchased_records.report_name AS debit_type')
                    ->leftJoin('users', 'points_transaction.user_id', '=', 'users.id')
                    ->leftJoin('tbl_purchased_records', 'points_transaction.id', '=', 'tbl_purchased_records.point_id')
                    ->where('points_transaction.user_id',$request->get('user_id') )->where('points_transaction.type',2)->orderBy('points_transaction.created_at','desc');
                $datatables =  app('datatables')->of($data)
                ->addColumn('date', function($row){
                    $created_at = date('d-M-yy', strtotime(str_replace('-', '/', $row->date)));
                    return $created_at;
                })->addColumn('point', function($row){

                    return "$".$row->point;
                });

                return $datatables->make(true);
            }

			if($request->get('type') == "#interested_properties"){

				$data=UserProperty::with('datatree')->where([['user_id',$request->get('user_id')],['status','1'],['trash','0']])->orderBy('id','desc')->paginate(5);

                return view('SuperadminDashboard/member/propertiesResult', compact('data'));

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
               $data=UserProperty::with('datatree')->where([['user_id',$request->get('user_id')],['status','2'],['trash','0']])->orderBy('id','desc')->paginate(5);

                return view('SuperadminDashboard/member/highPropertiesResult', compact('data'));

            }

			if($request->get('type') == "purchase_property_detail"){
				$userid 				= 	$request->get('user_id');
				$purchase_group_name 	= 	$request->get('purchase_group_name');
				$member 				= 	$request->get('member');

                return response()->json(['message'=>'success','userid'=>$userid,'name' => $purchase_group_name,'member' => $member]);
            }

        }

    }

    public function PurchaseRecordDetail(Request $request,$userid,$purchase_group_name,$member){
		//$userid 				= 	$request->get('user_id');
		//$purchase_group_name 	= 	$request->get('purchase_group_name');
		$named 					=  	urldecode($purchase_group_name);
		$recent_property_result	= PropertyResultId::select('property_id',DB::raw('DATE_FORMAT(created_at, "%d-%b-%Y %h:%i:%s") as date'))->where('purchase_group_name','LIKE',$named)->where('user_id','=',$userid)->orderBy('id','desc')->get()->toArray();

		$date = $recent_property_result[0]['date'];

		$recent_property_data_tree_id_arr 		= 	array_column($recent_property_result, 'property_id');

		$url = env('APP_WEBSITE_URL');
		 $data=UserProperty::with('logs')->select('datatree.*','trash',DB::raw('CONCAT(SitusHouseNumber, \' \', SitusStreetName, \' \', SitusMode) as address'),
		DB::raw('DATE_FORMAT(user_property.created_at, "%d-%b-%Y %h:%i:%s") as date'),'user_property.status','user_property.opportunity_status','LMSSalePrice as amount',
		'datatree.PropertyId as property_id','user_property.id as prop_id')->join('datatree','datatree.id','=','user_property.property_id')->where('user_property.user_id',$userid)
		->whereIn("user_property.property_id",array_values($recent_property_data_tree_id_arr))->where('trash','0')->orderBy('user_property.id','desc')->get();

		/* echo "<pre>"; print_r($data);
		die; */
	    return view('SuperadminDashboard/member/purchaseRecorddetail', compact('data','userid','member','date','url'));
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
        $data->leftJoin("state_county_fib",function($query){
            $query->on("state_county_fib.state_val","=",'user_detail.state');
        });
        $data->leftJoin("tbl_cities",function($query){
            $query->on("tbl_cities.id","=",'user_detail.city');

        });
		$data->leftJoin("images",function($query) use($id){
            $query->where('images.user_id','=' ,$id);
			 $query->where('images.type', '=' , '1');
        });
			/*  $query = str_replace(array('?'), array('\'%s\''), $data->toSql());
            $queryss = vsprintf($query, $data->getBindings());
            dump($queryss);
			die;  */
			$deposite = "";
        if($search_type == 1){
            $member      =   $data->orderBy("tbl_membership.id","desc")->get(['users.status AS member_status','users.created_at AS registration_date','state_county_fib.state_val AS state_id','state_county_fib.state_name','tbl_cities.city AS city_name','membership_master.type as name','membership_master.type AS membershiptype','users.type AS user_type','users.id AS user_primary_id','users.email', 'tbl_membership.created_at AS membership_purchase_date' ,'filename', 'tbl_membership.*', 'user_detail.*'])->first();

            $membership_purchase_date   =   Carbon::create($member->membership_purchase_date);
            $expiry_date                =   Carbon::create($member->expire_at);

			$date=strtotime($member->expire_at);
			$daysLeft=ceil(($date-time())/(60*60*24));

			$deposite = Deposite::where("id",$member->trans_id)->where("user_id",$id)->first();
			//echo "<pre>"; print_r($deposite); die;

        }

        if($search_type == 0){

            $expiry_date = '';
            $daysLeft ='';
            $member                   =   $data->get(['users.status AS member_status','users.created_at AS registration_date','state_county_fib.state_val AS state_id','state_county_fib.state_name','filename','tbl_cities.city AS city_name','users.type AS user_type','users.id AS user_primary_id','users.email' ,  'user_detail.*'])->first();


		}
		if($member->phone !=""){
            $phone = $member->phone;
            $member->phone = "(".substr($phone, 0, 3).") ".substr($phone, 3, 3)."-".substr($phone,6);

        }


		if($member->state_id !=""){

		   $state_manager = User::with('detail')->where('role','4')
			->whereHas('detail', function ($query) use($member) {
				$query->where('state',$member->state_id );
				$query->select('f_name');
			})->first();

			/* $query = str_replace(array('?'), array('\'%s\''), $state_manager->toSql());
            $queryss = vsprintf($query, $state_manager->getBindings());
            dump($queryss);  */

			$city_sale_executive = User::with('detail')->where('role','5')
				->whereHas('detail', function ($query) use($member) {
				$query->where('city',$member->state_id );
				$query->select('f_name' );
			})->first();
		}
		//die;
        $sale_managerName = "NA";
		$sale_executiveName = "NA";
        if( isset($state_manager) ){
            $sale_managerName = $state_manager->detail->f_name;

        }
		if( isset($city_sale_executive) ){
            $sale_executiveName = $state_manager->detail->f_name;

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
		//echo "<pre>"; print_r($member); die;
        return view('SuperadminDashboard/member/memberDetail',compact('report_purchased_count','sale_executiveName','sale_managerName','member','expiry_date','daysLeft','search_type','data','highly_interested_properties', 'progressBar' ,'deposite'));
    }

    public function memberSearch(Request $request)
    {

        if(!empty($request->all()))
        {
            $search_type =  $request->type;
            $data = DB::table('users')->where('role', '0')->orderBy('users.id','desc')
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
            if( $request->state){

                $data->where('user_detail.state', $request->state);
            }
            if( $request->city){

                $data->where('user_detail.city',  $request->city );
            }
            if( $request->postal_code){

                $data->where('postal', 'LIKE', "%" . $request->postal_code . "%");
            }


            if($request->membership_start_date_from != '' && $request->membership_start_date_to !=''){
                // echo 'HERE';
                 $membership_start_date_from = date('Y-m-d', strtotime(str_replace('-', '/', $request->get('membership_start_date_from'))));
                 $membership_start_date_to = date('Y-m-d', strtotime(str_replace('-', '/', $request->get('membership_start_date_to'))));
                 $data->whereBetween('users.created_at',array($membership_start_date_from. ' 00:00:00', $membership_start_date_to . ' 23:59:59'));
            }
            if($request->membership_start_date_from == '' && $request->membership_start_date_to !=''){
                 //echo 'HERE2';
                 $membership_start_date_to = date('Y-m-d', strtotime(str_replace('-', '/', $request->get('membership_start_date_to'))));
                 $data->where('users.created_at','<=',$membership_start_date_to . ' 23:59:59');
            }
            if($request->membership_start_date_from != '' && $request->membership_start_date_to ==''){
                 //echo 'HERE3';
                 $membership_start_date_from = date('Y-m-d', strtotime(str_replace('-', '/', $request->get('membership_start_date_from'))));
                 $data->where('users.created_at', '>=',$membership_start_date_from . ' 00:00:00');
            }

				 $data->orderBy('users.id','desc');
            $customers = $data->get(['users.id AS user_primary_id','users.created_at AS registration_date', 'users.*', 'tbl_membership.created_at AS membership_purchase_date' , 'tbl_membership.*', 'user_detail.*']);
			//echo "<pre>"; print_r($customers); die;
            //print full query with parameters
            // $query = str_replace(array('?'), array('\'%s\''), $data->toSql());
            // $query = vsprintf($query, $data->getBindings());
            // dump($query);

            return view('SuperadminDashboard/member/memberSearchResult',compact('customers','search_type'));
            // $datatables =  app('datatables')->of($data)
            // ->addColumn('name', function($row){
            //             return \ucfirst( $row->first_name)." ".\ucfirst($row->last_name);
            //          });
            //          return $datatables->make(true);


        } else {
            return redirect('superadmin/member');
        }

    }



}

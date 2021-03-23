<?php

namespace App\Http\Controllers\SalemanagerDashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Customer;
use App\User;
use App\Team;
use App\sale_property_reports;
use Auth;
use DB;
use DataTables;

// use App\Member;
use App\Model\Member;
use App\Model\States;
use App\Model\Report;
use App\Model\UserProperty;
use App\Model\Image;
use App\DataTree;
use App\Charts\SaleChart;
use App\Model\Detail;
use Charts;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class ViewController extends Controller
{
    public function dashboard(Request $request){
  

        $currentMonthSale =DB::table('tbl_purchased_records')
        ->join('user_detail','user_detail.user_id','tbl_purchased_records.user_id')
        ->join('points_transaction','points_transaction.id','tbl_purchased_records.point_id')
        ->select(DB::raw('COUNT(*) as count, YEAR(tbl_purchased_records.created_at) year,
        MONTH(tbl_purchased_records.created_at) month,SUM(points_transaction.point) as point'))
        ->where('user_detail.state','5')
        ->groupBy('year', 'month')
        ->having('month',Carbon::now()->format('m'))
        ->first();

         
        $totalSale =DB::table('tbl_purchased_records')
        ->join('user_detail','user_detail.user_id','tbl_purchased_records.user_id')
        ->join('points_transaction','points_transaction.id','tbl_purchased_records.point_id')
        ->select(DB::raw('COUNT(*) as count, YEAR(tbl_purchased_records.created_at) year,
        MONTH(tbl_purchased_records.created_at) month,SUM(points_transaction.point) as point'))
        ->where('user_detail.state','5')
        ->groupBy('year', 'month')
        // ->having('month',Carbon::now()->subMonth()->month)

        // ->having('month',Carbon::now()->format('m'))
        ->first();
        $totalPoint=$totalSale->point;
        $totalSalePoint=$totalPoint/10;

        $lastMonthSale =DB::table('tbl_purchased_records')
        ->join('user_detail','user_detail.user_id','tbl_purchased_records.user_id')
        ->join('points_transaction','points_transaction.id','tbl_purchased_records.point_id')
        ->select(DB::raw('COUNT(*) as count, YEAR(tbl_purchased_records.created_at) year,
        MONTH(tbl_purchased_records.created_at) month,SUM(points_transaction.point) as point'))
        ->where('user_detail.state','5')
        ->groupBy('year', 'month')
        ->having('month',Carbon::now()->subMonth()->month)
        ->first();
   
        $monthlySaleGraph=DB::table('tbl_purchased_records')
        ->join('user_detail','user_detail.user_id','tbl_purchased_records.user_id')
        ->join('points_transaction','points_transaction.id','tbl_purchased_records.point_id')
        // ->select(DB::raw('DATE_FORMAT(tbl_purchased_records.created_at,'%M')as monthNum')
        // ,DB::raw('SUM(points_transaction.point) as point')))
        ->select(DB::raw('MONTHNAME(tbl_purchased_records.created_at) as month'), 
         DB::raw("DATE_FORMAT(tbl_purchased_records.created_at,'%M') as monthNum"),    
         DB::raw('IFNULL(SUM(points_transaction.point),0) as point'))
        ->where('user_detail.state','5')
        ->groupBy('month')
        ->get();

         $months=['Jan','Feb','March','April','May','June','July','August','Sept','Oct','Nov','Dec'];
        $pointArray=$monthlySaleGraph->toArray();
        
         $pointsGraphArr=array();
        foreach($months as $value){
            $pointsGraphArr[$value] = '';
            foreach($pointArray as $monthval){
                if($value == $monthval->month){

                    $pointsGraphArr[$value] = ($monthval->point)/10;

                }
            }
        }
        $pointsGraphArrKey = array_values($pointsGraphArr);
     // print_r($pointss);
     $pointsGraphArrVal = json_encode($pointsGraphArrKey);
   if($currentMonthSale==""){
       $currentPoints=0;
       $currentMonthPoint=0;
   }else{
          $currentPoints=$currentMonthSale->point;
        $currentMonthPoint=$currentPoints/10; 
   }
	  if($lastMonthSale==""){
		  $lastPoints=0;
		  $lastMonthPoint=0;
	  }else{  
        $lastPoints=$lastMonthSale->point;
		$lastMonthPoint=$lastPoints/10; 

	  }   

        $changeInSale=$currentMonthPoint-$lastMonthPoint;
		if($lastMonthPoint==0){
			  $changePercentage=$changeInSale;

		}else{
	  $changePercentage=($changeInSale/$lastMonthPoint);
        }
	// $cPercentage=$changePercentage/100;
        $trending = DB::table('user_property')
        ->join('user_detail','user_detail.user_id','=','user_property.user_id')
        ->select(DB::raw('count(*) as total'),'user_property.property_id')
        ->where(['user_property.status'=>'2','user_detail.state'=>'5'])
        ->groupBy('property_id')
        // ->having('total', '>' , 1)
        ->take(3)
        ->get();
        $image = ['assets/salemanager/images/pro1.png','assets/superadmin/images/house1.jpg','assets/superadmin/images/house4.jpg'];
        $array =  $trending->toArray();
        $newArr = array();
  
        foreach($array as $key=> $value){
            if( isset($image[$key]) ){
                $newArr[] = array( "image" => $image[$key],"total" =>$value->total,"property_id"=>$value->property_id );    
            }
        }
        
        $employee=User::leftjoin('user_detail','users.id','user_detail.user_id')
        ->select('user_detail.*','users.*')
        ->where(['user_detail.state'=>'5','users.role'=>'5'])
        ->take(6)
        ->get(); 
   
        $empLongBeach= DB::table('user_detail')
        ->join('users', 'users.id', '=', 'user_detail.user_id')
        ->join('images', 'images.user_id', '=', 'users.id')
        ->where(['user_detail.state'=>'5','user_detail.city'=>'2299'])
        ->get();
       
        $empGlendale=  DB::table('user_detail')
        ->join('users', 'users.id', '=', 'user_detail.user_id')
        ->join('images', 'images.user_id', '=', 'users.id')
        ->where(['user_detail.state'=>'5','user_detail.city'=>'2100'])
        ->get();    

        $empPasadena= DB::table('user_detail')
        ->join('users', 'users.id', '=', 'user_detail.user_id')
        ->join('images', 'images.user_id', '=', 'users.id')
        ->where(['user_detail.state'=>'5','user_detail.city'=>'2504'])
        ->get();       

        $empPasadenaImage= DB::table('user_detail')
        ->join('users', 'users.id', '=', 'user_detail.user_id')
        ->join('images', 'images.user_id', '=', 'users.id')
        ->select('images.filename')
        ->where(['user_detail.state'=>'5','user_detail.city'=>'2504'])
        ->get();       


        $locations=DB::table('user_detail')->select('us_cities.LATITUDE','us_cities.LONGITUDE','us_cities.CITY')
        
        ->LeftJoin('us_cities', function($query){
                $query->on( 'us_cities.ID_STATE', '=', 'user_detail.state');
                $query->on( 'us_cities.ID', '=', 'user_detail.city');
            })
        ->LeftJoin('users','user_detail.user_id','=','users.id')   
        ->where(['user_detail.state'=>'5','users.role'=>'5'])
        ->get();

        $recentlyPurchaseReport=DB::table('tbl_purchased_records')
        ->join('users', 'users.id', '=', 'tbl_purchased_records.user_id')
        ->join('user_detail', 'user_detail.user_id', '=', 'users.id')
        ->select('tbl_purchased_records.report_name','tbl_purchased_records.created_at')
        ->where(['user_detail.state'=>'5'])
        ->orderBy('tbl_purchased_records.created_at','desc')
        ->get(); 

        // $customerJoinedLastMonth=DB::table('users')
        // // ->join('tbl_membership','tbl_membership.user_id','=','users.id')
        // ->join('user_detail', 'user_detail.user_id','=','users.id')
        // ->where(['user_detail.state'=>'5','users.reg_status'=>'2'])
        // ->whereMonth(DB::raw('users.created_at'), Carbon::now()->subMonth()->month)
        // ->count();
        $customerJoinedLastMonth=DB::table('users')->where('role','0')
        ->join('tbl_membership','tbl_membership.user_id','=','users.id')
        ->join('user_detail','user_detail.user_id','=','users.id')
        // ->select(DB::raw(COUNT('tbl_membership.user_id')
        ->where([['user_detail.state','=','5'],['tbl_membership.expire_at', '>' , date('Y-m-d').' 00:00:00']])
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
        ->where('user_detail.state','5')
        ->whereMonth(DB::raw('users.created_at'), Carbon::now()->subMonth()->month)
       ->whereNull('tbl_membership.expire_at')->count();


            $customerJoined=DB::table('users')->where('role','0')
            ->join('tbl_membership','tbl_membership.user_id','=','users.id')
            ->join('user_detail','user_detail.user_id','=','users.id')
            ->select('tbl_membership.user_id')
            ->where([['user_detail.state','=','5'],['tbl_membership.expire_at', '>' , date('Y-m-d').' 00:00:00']])
            ->whereMonth(DB::raw('tbl_membership.created_at'), Carbon::now()->format('m'))
            ->groupBy('tbl_membership.user_id')
            ->get()
            ->count();   
          
        //     $data_nonmember = DB::table('users')->where('role', '0')->orderBy('users.id','desc')
        //     ->LeftJoin('tbl_membership', function($query){
        //         $query->on( 'users.id', '=', 'tbl_membership.user_id');
        //         $query->where('tbl_membership.expire_at', '>' , date('Y-m-d').' 00:00:00');
        //     })
        //     ->leftJoin('user_detail', 'users.id', '=', 'user_detail.user_id')
        //     ->select('user_detail.user_id')
        //     ->where('user_detail.state','5')
        //     ->whereMonth(DB::raw('users.created_at'), Carbon::now()->subMonth()->month)
        //    ->whereNull('tbl_membership.expire_at')->count();
    

        //   $customerJoined=DB::table('tbl_membership')
        // ->join('user_detail','user_detail.user_id','=','tbl_membership.user_id')
        // ->where(['user_detail.state'=>'5'])
        // ->get();

       
        $customerEntrolled=DB::table('users')->where('role', '0')->orderBy('users.id','desc')
            ->LeftJoin('tbl_membership', function($query){
                $query->on( 'users.id', '=', 'tbl_membership.user_id');
                $query->where('tbl_membership.expire_at', '>' , date('Y-m-d').' 00:00:00');
            })
            ->leftJoin('user_detail', 'users.id', '=', 'user_detail.user_id')
            ->select('user_detail.user_id')
            ->where('user_detail.state','5')
            ->whereMonth(DB::raw('users.created_at'), Carbon::now()->format('m'))
           ->whereNull('tbl_membership.expire_at')->count();

    //  return   $tags = explode(" ", strtolower($user));

        $customerEntrolled=DB::table('users')->where('role','0')
            // ->join('tbl_membership','tbl_membership.user_id','=','users.id')
            ->join('user_detail','user_detail.user_id','=','users.id')
            ->select('user_detail.user_id')
            ->where([['user_detail.state','=','5']])
            // ->whereMonth(DB::raw('users.created_at'), Carbon::now()->format('m'))
            ->groupBy('user_detail.user_id')
            // ->get();
             ->count();
        
        $sale=sale_property_reports::select('amount')->sum('amount');
    
	
	    $changeInJoinCustomer=$customerJoined-$customerJoinedLastMonth;
		if($customerJoinedLastMonth==0){
			$differenceJoin=$changeInJoinCustomer;
		}else{
			$differenceJoin=$changeInJoinCustomer/$customerJoinedLastMonth;
		}
        $joinPercent=$differenceJoin; 
        // $joinChangePerc=$joinPercent/100;
    
		$changeInEnrollCustomer=$customerEntrolled-$customerEntrolledLastMonth;
		if($customerEntrolledLastMonth==0){
            $differenceEnroll=$changeInEnrollCustomer;
        }else{
            $differenceEnroll=$changeInEnrollCustomer/$customerEntrolledLastMonth;
        }
         $enrollPercent=$differenceEnroll; 
        // $enrollChangePerc=$enrollPercent/100;
        $team=Team::select("*")->get();

        $topExecutiveSale=DB::table('tbl_purchased_records')
        // ->join('data_tree_items','data_tree_items.report','=','tbl_purchased_records.report_name')
        // ->join('user_property','user_property.property_id','=','tbl_purchased_records.user_prop_id')
        ->join('user_detail','user_detail.user_id','=','tbl_purchased_records.user_id')
        // ->join('points_transaction','points_transaction.id','=','tbl_purchased_records.point_id')
        ->join('datatree','datatree.PropertyId','=','tbl_purchased_records.property_id')
        ->select(DB::raw('COUNT(tbl_purchased_records.user_prop_id) as count'),'tbl_purchased_records.user_prop_id',
        'tbl_purchased_records.report_name','datatree.Address','tbl_purchased_records.property_id',
        'datatree.AssessedTotalValue','tbl_purchased_records.created_at')
        ->groupBy('tbl_purchased_records.user_prop_id') 
        ->orderBy('count', 'DESC')
        // ->select('tbl_purchased_records.user_prop_id','tbl_purchased_records.user_id') 
        ->where(['user_detail.state'=>'5'])
        ->take(5)
        ->get();
        
        return view('SalemanagerDashboard.dashboard')->with(['customerEnrolled'=>$customerEntrolled,
        'customerJoined'=>$customerJoined,'team'=>$team,'sale'=>$sale,'newArr'=>$newArr,
        'recentlyPurchaseReport'=>$recentlyPurchaseReport,'image'=>$image,'employee'=>$employee,
        'empLongBeach'=>$empLongBeach,'empGlendale'=>$empGlendale,'empPasadena'=>$empPasadena,
        'locations'=>$locations,'joinPercent'=>$joinPercent,'enrollPercent'=>$enrollPercent,
        'pointsGraphArr'=>$pointsGraphArrVal,'changePercentage'=>$changePercentage,
		'currentMonthPoint'=>$currentMonthPoint,'topExecutiveSale'=>$topExecutiveSale,'totalSalePoint'=>$totalSalePoint]);
    
    }   

    public function properties(){
        $interestedProperty=DB::table('user_property')
        ->join('datatree','datatree.id','user_property.property_id')
        ->join('users','users.id','user_property.user_id')
        ->join('user_detail','user_detail.user_id','users.id')
        ->select('datatree.*','user_property.*')
        ->where(['user_detail.state'=>'5','user_property.status'=>'1','user_property.trash'=>'0'])
        ->get(); 
       
        $highlyInterestedProperty=DB::table('user_property')
        ->join('datatree','datatree.id','user_property.property_id')
        ->join('users','users.id','user_property.user_id')
        ->join('user_detail','user_detail.user_id','users.id')
        ->select('datatree.*','user_property.*')
        ->where(['user_detail.state'=>'5','user_property.status'=>'2','user_property.trash'=>'0'])
        ->get(); 
        
        return view('SalemanagerDashboard.properties')->with(['interestedProperty'=>$interestedProperty,
        'highlyInterestedProperty'=>$highlyInterestedProperty]); 
    }

    public function sale(){
        $earnedToday=DB::table('tbl_purchased_records')
        ->join('user_detail','user_detail.user_id','tbl_purchased_records.user_id')
        ->join('points_transaction','points_transaction.id','tbl_purchased_records.point_id')
        ->select(DB::raw('SUM(points_transaction.point) as point'))
        ->where('user_detail.state','5')
        ->where('tbl_purchased_records.created_at', '>=', Carbon::today())
        ->first();
        
        $pointsToday=$earnedToday->point;
        $earnedTodaySale=$pointsToday/10;
        $previous_week = strtotime("-1 week +1 day");
        $start_week = strtotime("last sunday midnight",$previous_week);
        $end_week = strtotime("next saturday",$start_week);
        $start_week = date("Y-m-d",$start_week);
        $end_week = date("Y-m-d",$end_week);
        $earnedLastWeek=DB::table('tbl_purchased_records')
        ->join('user_detail','user_detail.user_id','tbl_purchased_records.user_id')
        ->join('points_transaction','points_transaction.id','tbl_purchased_records.point_id')
        ->select(DB::raw('SUM(points_transaction.point) as point'))
        ->whereBetween(DB::raw('tbl_purchased_records.created_at'), [$start_week,$end_week])
        ->where('user_detail.state','5')
        ->first();

        $pointsWeek=$earnedLastWeek->point;
        $earnedLastWeekSale=$pointsWeek/10;
        $earnedLastMonth=DB::table('tbl_purchased_records')
        ->join('user_detail','user_detail.user_id','tbl_purchased_records.user_id')
        ->join('points_transaction','points_transaction.id','tbl_purchased_records.point_id')
        ->select(DB::raw('SUM(points_transaction.point) as point'))
        ->whereMonth(DB::raw('tbl_purchased_records.created_at'), Carbon::now()->subMonth()->month)
        ->where('user_detail.state','5')
        ->first();
        $pointsMonth=$earnedLastMonth->point;
        $earnedLastMonthSale=$pointsMonth/10;

        $earnedThisWeek=DB::table('tbl_purchased_records')
        ->join('user_detail','user_detail.user_id','tbl_purchased_records.user_id')
        ->join('points_transaction','points_transaction.id','tbl_purchased_records.point_id')
        ->select(DB::raw('SUM(points_transaction.point) as point'))
        ->whereBetween(DB::raw('tbl_purchased_records.created_at'),[Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
        ->where('user_detail.state','5')
        ->first();
        
        $pointsThisWeek=$earnedThisWeek->point;
        $earnedThisWeekSale=$pointsThisWeek/10;
        $changeInWeekSale=$earnedThisWeekSale-$earnedLastWeekSale;
        if($earnedLastWeekSale=='0'){
            $differenceWeek=$changeInWeekSale;
        }else{
            $differenceWeek=$changeInWeekSale/$earnedLastWeekSale;
        }
        $weekPercent=$differenceWeek; 
        
        $earnedThisMonth=DB::table('tbl_purchased_records')
        ->join('user_detail','user_detail.user_id','tbl_purchased_records.user_id')
        ->join('points_transaction','points_transaction.id','tbl_purchased_records.point_id')
        ->select(DB::raw('COUNT(*) as count, YEAR(tbl_purchased_records.created_at) year,
        MONTH(tbl_purchased_records.created_at) month,SUM(points_transaction.point) as point'))
        ->where('user_detail.state','5')
        ->groupBy('year', 'month')
        ->having('month',Carbon::now()->format('m'))
        ->first();
    
	if($earnedThisMonth==""){
	 $pointsThisMonth=0;
	 $earnedThisMonthSale=0;
	}else{
        $pointsThisMonth=$earnedThisMonth->point;
        $earnedThisMonthSale=$pointsThisMonth/10;
	}
        $changeInMonthSale=$earnedThisMonthSale-$earnedLastMonthSale;
        if($earnedLastMonthSale=='0'){
            $differenceMonth=$changeInMonthSale;
        }else{
            $differenceMonth=$changeInMonthSale/$earnedLastMonthSale;
        }
        $monthPercent=$differenceMonth; 


        // $joinChangePerc=$joinPercent/100;
        $topSeller=DB::table('tbl_purchased_records')
        ->join('user_detail','user_detail.user_id','tbl_purchased_records.user_id')
        ->join('points_transaction','points_transaction.id','tbl_purchased_records.point_id')
        ->select(DB::raw('MAX(points_transaction.point) AS point_max,user_detail.*'))
        ->where(['user_detail.state'=>'5'])
        ->first();

        $firstName = $topSeller->f_name;
        $lastName=$topSeller->l_name;

        $topRanking = DB::table('tbl_purchased_records')
        ->join('user_detail','user_detail.user_id','tbl_purchased_records.user_id')
        ->join('points_transaction','points_transaction.id','tbl_purchased_records.point_id')
        ->join('users','users.id','tbl_purchased_records.user_id')
        ->select(DB::raw('COUNT(tbl_purchased_records.point_id) AS point,user_detail.*'))
        ->groupBy('user_detail.user_id')
        ->orderBy(DB::raw('COUNT(point)'), 'DESC')
        ->where(['user_detail.state'=>'5','users.role'=>'5'])
        ->take(4)
        ->get();

        $topEarning = DB::table('tbl_purchased_records')
        ->join('user_detail','user_detail.user_id','tbl_purchased_records.user_id')
        ->join('points_transaction','points_transaction.id','tbl_purchased_records.point_id')
        ->join('users','users.id','tbl_purchased_records.user_id')
        ->select(DB::raw('SUM(points_transaction.point) AS point,user_detail.*'))
        ->groupBy('user_detail.user_id')
        ->orderBy(DB::raw('SUM(point)'), 'DESC')
        ->where(['user_detail.state'=>'5','users.role'=>'5'])
        ->take(4)
        ->get();

        $recentRecord= DB::table('tbl_purchased_records')
        ->join('user_detail','user_detail.user_id','tbl_purchased_records.user_id')
        ->join('users','users.id','tbl_purchased_records.user_id')
        ->join('points_transaction','points_transaction.id','tbl_purchased_records.point_id')
        ->select(DB::raw('SUM(points_transaction.point) AS point,user_detail.*,users.*,tbl_purchased_records.created_at AS date'))
        // ->orderBy(DB::raw('SUM(point)'), 'DESC')
        ->groupBy('users.id')
        // ->orderBy('tbl_purchased_records.created_at','DESC')
        ->where(['user_detail.state'=>'5','users.role'=>'5'])
        ->get();

        return view('SalemanagerDashboard.sale')->with(['earnedTodaySale'=>$earnedTodaySale,
        'earnedLastWeekSale'=>$earnedLastWeekSale,'earnedLastMonthSale'=>$earnedLastMonthSale,
        'earnedThisWeekSale'=>$earnedThisWeekSale,'earnedThisMonthSale'=>$earnedThisMonthSale,
        'firstName'=>$firstName,'lastName'=>$lastName,'topRanking'=>$topRanking,
        'topEarning'=>$topEarning,'recentRecord'=>$recentRecord,'weekPercent'=>$weekPercent,
        'monthPercent'=>$monthPercent]);
    
    }
    
    public function customer(){
        $cities =  DB::table('us_cities')->select("*")->where('ID_STATE','5')->get();
        return view('SalemanagerDashboard.member.member')->with(['cities'=>$cities]);
    }
    
    public function team(){
        return view('SalemanagerDashboard.team.team');
    }
    public function propertyDetail($id){
        $propertyDetail= DataTree::leftjoin('user_property','user_property.property_id','datatree.id')
        ->select('datatree.*')
        ->where(['datatree.id'=>$id])
        ->first();
        return view('SalemanagerDashboard.propertyDetail')->with('propertyDetail',$propertyDetail);
    }
    public function addTeam(){
        $state=States::select("*")->where('ID','5')->get();
        $city=DB::table('us_cities')->select("*")->where('ID_STATE','5')->get();
        return view('SalemanagerDashboard.team.addTeam')->with(['state'=>$state,'city'=>$city]);
    }
    public function memberList(){
        return view('SalemanagerDashboard.membersList');
    }
    public function nonMemberList(){
        return view('SalemanagerDashboard.nonMemberList');
    }

    public function memberListTable(){
        $customerJoined=DB::table('users')->where('role','0')
        ->join('tbl_membership','tbl_membership.user_id','=','users.id')
        ->join('user_detail','user_detail.user_id','=','users.id')
        ->select('users.username','users.email','user_detail.phone',
        'tbl_membership.created_at','tbl_membership.expire_at','users.id')
        ->where([['user_detail.state','=','5'],['tbl_membership.expire_at', '>' , date('Y-m-d').' 00:00:00']])
        ->groupBy('tbl_membership.user_id');
        return DataTables::of($customerJoined)
        ->addIndexColumn()
        ->addColumn('created_at',function ($customerJoined){
            return date('d/m/y ', strtotime($customerJoined->created_at) );
        })  
        ->addColumn('expire_at',function ($customerJoined){
            return date('d/m/y ', strtotime($customerJoined->expire_at) );
        })
        ->addColumn('action',function ($customerJoined){
             $id=$customerJoined->id;
            return '<a  href="'.route('sale_manager_members',$id).'" 
            class="btn btn-success">View Details</a>';
        })
        ->rawColumns(['created_at','expire_at','action'])
        ->make(true);
    }
    public function nonMemberListTable(){
        
        $customerEnrolled=DB::table('users')->where('role', '0')->orderBy('users.id','desc')
            ->LeftJoin('tbl_membership', function($query){
                $query->on( 'users.id', '=', 'tbl_membership.user_id');
                $query->where('tbl_membership.expire_at', '>' , date('Y-m-d').' 00:00:00');
            })
            ->leftJoin('user_detail', 'users.id', '=', 'user_detail.user_id')
            ->select('users.username','users.email','user_detail.phone','users.created_at','users.id')
            ->where('user_detail.state','5')
           ->whereNull('tbl_membership.expire_at');
        return DataTables::of($customerEnrolled)
        ->addIndexColumn()
        ->addColumn('created_at',function ($customerEnrolled){
            return date('d/m/y ', strtotime($customerEnrolled->created_at) );
        })
        ->addColumn('action',function ($customerEnrolled){
            $id=$customerEnrolled->id;
           return '<a  href="'.route('sale_manager_nonMembers',$id).'"
           class="btn btn-success">View Details</a>';})
        ->rawColumns(['created_at','action'])
        ->make(true);   
    }
    public function membersDetail(Request $request,$id){
       $data = DB::table('users')->where('users.id', $id);
      // $data->Join('tbl_membership', 'users.id', '=', 'tbl_membership.user_id');
  
           $data->LeftJoin('tbl_membership', function($query) use($id){
               //$query->on( 'tbl_membership.user_id', '=',$id );
               $query->where('tbl_membership.user_id', '=' , $id);
               $query->where('tbl_membership.expire_at', '>' , date('Y-m-d').' 00:00:00');
               
           });
        //    $data->Join('membership_master', 'tbl_membership.membership_type', '=', 'membership_master.id');

       
       $data->leftJoin('user_detail', 'users.id', '=', 'user_detail.user_id');
       $data->join("us_states",function($query){
           $query->on("us_states.ID","=",'user_detail.state');
       });
       $data->join("us_cities",function($query){
           $query->on("us_cities.ID","=",'user_detail.city');
       });
    
           $member                     =   $data->get(['users.status AS member_status','us_states.STATE_NAME AS state_name',
           'us_cities.CITY AS city_name','users.type AS user_type','users.id AS user_primary_id','users.email', 'tbl_membership.created_at AS membership_purchase_date' , 'tbl_membership.*', 'user_detail.*'])->first();

           $membership_purchase_date   =   Carbon::create($member->membership_purchase_date);
           $expiry_date                =   Carbon::create($member->expire_at);
           //$now                        =   Carbon::now();
           //$daysLeft                   =   $expiry_date->diffInDays($now); 
           
           $date=strtotime($member->expire_at);
           $daysLeft=ceil(($date-time())/(60*60*24));
           
       
    //    if($search_type == 0){
    //        $expiry_date = '';
    //        $daysLeft ='';
    //        $member                   =   $data->get(['users.status AS member_status','us_states.STATE_NAME AS state_name','us_cities.CITY AS city_name','users.type AS user_type','users.id AS user_primary_id','users.email' ,  'user_detail.*'])->first();
    //    }
      
      
       $state_manager = User::with('detail')->where('role','4')
       ->whereHas('detail', function ($query) use($member) {
           $query->where('state',$member->state );
           $query->select('f_name','l_name' );
       })->first();
       $sale_managerName = "House";
       if( $state_manager ){
           $sale_managerName = $state_manager->detail->f_name." ".$state_manager->detail->l_name; 

       }

       $city_sale_executive = User::with('detail')->where('role','5')
       ->whereHas('detail', function ($query) use($member) {
           $query->where('city',$member->state );
           $query->select('f_name','l_name' );
       })->first();
       $sale_executiveName = "NA";
       if( $city_sale_executive ){
           $sale_executiveName = $state_manager->detail->f_name." ".$state_manager->detail->l_name; 

       }
       
       $data = DB::table('user_property')->where('user_property.status', '1')
       ->where("user_property.user_id",$id)->where("user_property.trash",'0')
      ->LeftJoin('datatree', function($query){
          $query->on( 'user_property.property_id', '=', 'datatree.id');
      })->paginate(5);
      //echo "<pre>"; print_r($interested_properties); die;
      $highly_interested_properties = DB::table('user_property')
      ->where('user_property.status', '2')->where("user_property.user_id",$id)
      ->where("user_property.trash",'0')
      ->LeftJoin('datatree', function($query){
          $query->on( 'user_property.property_id', '=', 'datatree.id');
      })->paginate(5);
      
       $progressBar = 0;
      
       if($daysLeft!=''){
           $progressBar = round(($daysLeft/30) * 100);
       }
      
       return view('SalemanagerDashboard/membersDetail',compact('sale_executiveName',
       'sale_managerName','member','expiry_date','daysLeft','data','highly_interested_properties', 'progressBar'));
   }

    public function nonMemberDetail(Request $request,$id){

        $data = DB::table('users')->where('users.id', $id);
       // $data->Join('tbl_membership', 'users.id', '=', 'tbl_membership.user_id');
      
        $data->leftJoin('user_detail', 'users.id', '=', 'user_detail.user_id');
        $data->join("us_states",function($query){
            $query->on("us_states.ID","=",'user_detail.state');
        });
        $data->join("us_cities",function($query){
            $query->on("us_cities.ID","=",'user_detail.city');
        });
       
       
            $expiry_date = '';
            $daysLeft ='';
            $member =$data->get(['users.status AS member_status','us_states.STATE_NAME AS state_name','us_cities.CITY AS city_name','users.type AS user_type','users.id AS user_primary_id','users.email' ,  'user_detail.*'])->first();
        
       
       
		$state_manager = User::with('detail')->where('role','4')
        ->whereHas('detail', function ($query) use($member) {
            $query->where('state',$member->state );
            $query->select('f_name','l_name' );
        })->first();
        $sale_managerName = "House";
        if( $state_manager ){
            $sale_managerName = $state_manager->detail->f_name." ".$state_manager->detail->l_name; 

        }

        $city_sale_executive = User::with('detail')->where('role','5')
        ->whereHas('detail', function ($query) use($member) {
            $query->where('city',$member->state );
            $query->select('f_name','l_name' );
        })->first();
        $sale_executiveName = "NA";
        if( $city_sale_executive ){
            $sale_executiveName = $state_manager->detail->f_name." ".$state_manager->detail->l_name; 

        }
		
        $data = DB::table('user_property')->where('user_property.status', '1')
        ->where("user_property.user_id",$id)->where("user_property.trash",'0')
       ->LeftJoin('datatree', function($query){
           $query->on( 'user_property.property_id', '=', 'datatree.id');
       })->paginate(5);
       //echo "<pre>"; print_r($interested_properties); die;
       $highly_interested_properties = DB::table('user_property')
       ->where('user_property.status', '2')->where("user_property.user_id",$id)
       ->where("user_property.trash",'0')
       ->LeftJoin('datatree', function($query){
           $query->on( 'user_property.property_id', '=', 'datatree.id');
       })->paginate(5);
	   
	   
		$progressBar = 0;
	   
		if($daysLeft!=''){
			$progressBar = round(($daysLeft/30) * 100);
		}
	   
        return view('SalemanagerDashboard/nonMemberDetail',compact(
        'sale_managerName','member','data','highly_interested_properties'));
    }
    public function messages(){
        return view('SalemanagerDashboard.message.message');
    }
    public function sendMessage(){
        return view('SalemanagerDashboard.message.sendMessage');
    }
    public function viewMessage(){
        return view('SalemanagerDashboard.message.viewMessage');
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

        return view('SalemanagerDashboard.profile')->with(['email'=>$email,'f_name'=>$f_name,'l_name'=>$l_name,
        'add'=>$add,'state'=>$state,'city'=>$city,'phone'=>$phone,'country'=>$country]);
    }
}

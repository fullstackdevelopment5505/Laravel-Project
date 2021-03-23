<?php

namespace App\Http\Controllers\SalemanagerDashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DataTables;
use App\Property;
use App\Model\UserProperty;
class PropertyController extends Controller
{
   


    function activePropertyList(){
        $activeProperty = Property::select('*')->where('status','Active');
        return DataTables::of($activeProperty)
        ->addColumn('property',
            '<div class="inner_data">
                <div class="left_data">
                    <img src='.asset('assets/saleExecutive/images/pros.png').'>
                </div>
                <div class="right_data">
                <h2>{{$name}}</h2>
                <h3>{{$description}}</h3>
                <p>{{$amount}}</p>
                </div>
            </div>'
        )
        ->addColumn('leads','<div class="leads">
         <div class="cont">28 till now + 3 Hot</div>
         <div class="img_lead">
             <div><img src='.asset("assets/saleExecutive/images/t1.png").'></div>
             <div><img src='.asset("assets/saleExecutive/images/t2.png").'></div>
             <div><img src='.asset("assets/saleExecutive/images/t3.png").'></div>
             <div><img src='.asset("assets/saleExecutive/images/t4.png").'></div>
             <div><div class="icon_more_data">+23</div></div>
         </div>
     </div>')
        ->addColumn('stats','<div class="statss">
        <i class="fa fa-line-chart"></i>
        <h6>349 + <span>06</span></h6>
        <p>Total Views</p>
    </div>')
    ->addColumn('status', '<button class="btn_act">Active</button>')
        ->addColumn('action', '
        <div class="actionbtn">
        <ul>
            <li><a href="#"><i class="fa fa-pencil"></i></a></li>
            <li><a href={{ route(\'sale_manager.deleteProperty\',$id) }} class="trash"><i class="fa fa-trash"></i></a></li>
        </ul>
    </div>')
        ->rawColumns(['leads','stats','status','action','property'])
        ->make(true);
    }
    function expiredPropertyList(){
        $expiredProperty = Property::select('*')->where('status','Expired');
        return DataTables::of($expiredProperty)
        ->addColumn('property',

            '<div class="inner_data">
                <div class="left_data">
                    <img src='.asset('assets/saleExecutive/images/pros.png').'>
                </div>
                <div class="right_data">
                <h2>{{$name}}</h2>
                <h3>{{$description}}</h3>
                <p>{{$amount}}</p>
                </div>
            </div>'
        )
        ->addColumn('leads','<div class="leads">
         <div class="cont">28 till now + 3 Hot</div>
         <div class="img_lead">
             <div><img src='.asset("assets/saleExecutive/images/t1.png").'></div>
             <div><img src='.asset("assets/saleExecutive/images/t2.png").'></div>
             <div><img src='.asset("assets/saleExecutive/images/t3.png").'></div>
             <div><img src='.asset("assets/saleExecutive/images/t4.png").'></div>
             <div><div class="icon_more_data">+23</div></div>
         </div>
     </div>')
        ->addColumn('stats','<div class="statss">
        <i class="fa fa-line-chart"></i>
        <h6>349 + <span>06</span></h6>
        <p>Total Views</p>
    </div>')
    ->addColumn('status', '<button class="btn_act danger">Expired</button>')
       
        ->rawColumns(['leads','stats','status','property'])
        ->make(true);
    }
    function draftPropertyList(){
        $draftProperty = Property::select('*')->where('status','Draft');
        return DataTables::of($draftProperty)
        ->addColumn('property',

            '<div class="inner_data">
                <div class="left_data">
                    <img src='.asset('assets/saleExecutive/images/pros.png').'>
                </div>
                <div class="right_data">
                <h2>{{$name}}</h2>
                <h3>{{$description}}</h3>
                <p>{{$amount}}</p>
                </div>
            </div>'
        )
        ->addColumn('leads','<div class="leads">
         <div class="cont">28 till now + 3 Hot</div>
         <div class="img_lead">
             <div><img src='.asset("assets/saleExecutive/images/t1.png").'></div>
             <div><img src='.asset("assets/saleExecutive/images/t2.png").'></div>
             <div><img src='.asset("assets/saleExecutive/images/t3.png").'></div>
             <div><img src='.asset("assets/saleExecutive/images/t4.png").'></div>
             <div><div class="icon_more_data">+23</div></div>
         </div>
     </div>')
        ->addColumn('stats','<div class="statss">
        <i class="fa fa-line-chart"></i>
        <h6>349 + <span>06</span></h6>
        <p>Total Views</p>
    </div>')
    ->addColumn('status', '<button class="btn_act warning">Draft</button>')
       
        ->rawColumns(['leads','stats','status','property'])
        ->make(true);
    }
    function deleteActiveProperty($id){
        $activeProperty = Property::where('id',$id)->delete();
        return redirect()->back()->with('success','Deleted sucessfully');
    }
}

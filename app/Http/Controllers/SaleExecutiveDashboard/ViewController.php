<?php

namespace App\Http\Controllers\SaleExecutiveDashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Customer;
use App\Message;
class ViewController extends Controller
{
    public function dashboard(){
        $customerEntrolled=Customer::count();
        $customerJoined=Customer::select("*")->where('type','member')->count();
        return view('SaleExecutiveDashboard.dashboard')->with(['customerEnrolled'=>$customerEntrolled,
        'customerJoined'=>$customerJoined]);
    }
    public function properties(){
        return view('SaleExecutiveDashboard.properties');
    }
    public function sale(){
        return view('SaleExecutiveDashboard.sale');
    }
    public function customer(){
        return view('SaleExecutiveDashboard.customer');
    }
    public function customerProfile($id){
        $customerDetail=Customer::where('id',$id)->get();
        return view('SaleExecutiveDashboard.customerProfile')->with('customerDetail',$customerDetail);
    }
    public function nonMemberProfile($id){
        $nonMemberDetail=Customer::where('id',$id)->get();
        return view('SaleExecutiveDashboard.nonMemberProfile')->with('nonMemberDetail',$nonMemberDetail);
    }
    public function editProfile(){
        return view('SaleExecutiveDashboard.editProfile');
    }
    public function contact(){
        return view('SaleExecutiveDashboard.contact');
    }
    public function message(){
        $message=Message::select("*")->get();
        return view('SaleExecutiveDashboard.message.message')->with('message',$message);
    }
    public function viewMessage(){
        return view('SaleExecutiveDashboard.message.viewMessage');
    }
    public function replyMessage(){
        return view('SaleExecutiveDashboard.message.replyMessage');
    }
    public function sendMessage(){
        return view('SaleExecutiveDashboard.message.sendMessage');
    }
    public function team(){
        return view('SaleExecutiveDashboard.team.team');
    }
    public function addTeam(){
        return view('SaleExecutiveDashboard.team.addTeam');
    }
}

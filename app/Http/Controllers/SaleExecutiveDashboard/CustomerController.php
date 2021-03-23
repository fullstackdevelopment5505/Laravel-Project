<?php

namespace App\Http\Controllers\SaleExecutiveDashboard;
use App\Customer;
use App\Contact;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use DataTables;

class CustomerController extends Controller
{
    public function addCustomer(Request $request){
        $inputs = $request->only(['name','email','phoneno','location','property_description','type','report_name','price','date']);
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
               $data=Customer::create($inputs);
               return redirect()->back()->with('success','Customer added successfully');
        }
    }
    
    function memberList(){
        $member = Customer::select('*')->where('type','member');
        return DataTables::of($member)
        ->addColumn('commision','12')
        ->addColumn('status','Active')
        ->addColumn('action', '
         <a href={{ route(\'saleExecutiveCustomerProfile\', $id) }} class="btn btn-success">View Detail</a>')
        ->rawColumns(['sale','commision','action'])
        ->make(true);
    }
    function nonMemberList(){
        $member = Customer::select('*')->where('type','non_member');
        return DataTables::of($member)
        ->addIndexColumn()
        ->addColumn('view','<a href={{ route(\'saleExecutiveNonMemberProfile\', $id) }} class="btn btn-success">View </a>')
        ->rawColumns(['view'])
        ->make(true);
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
        return view('SaleExecutiveDashboard.dashboard')->with('customerEnrolled',$customerEnrolled);
    }
    public function memberDetail($id){
        $memberDetail=Customer::where('id',$id)->get();
       
        return view('SaleExecutiveDashboard.customerProfile')->with(['memberDetail'=>$memberDetail]);
    }
}

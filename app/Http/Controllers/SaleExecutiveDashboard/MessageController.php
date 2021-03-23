<?php

namespace App\Http\Controllers\SaleExecutiveDashboard;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Message;
use Validator;

class MessageController extends Controller
{
    public function sendMessage(Request $request){
        $inputs = $request->only(['member','subject','text','type']);
        $validator = Validator::make($inputs,[
            'member' => 'required',
            'subject' => 'required',
            'text'=>'required',
            
        ]);
        if($validator->fails()){
            // $errorMessages = $validator->messages()->toArray();
            // return redirect()->back()->with('error','Invalid inputs');
            return redirect()->back()->withErrors($validator);        

        }
        else{
               $data=Message::create($inputs);
               return redirect()->back()->with('success','Message sent successfully');
        }
    }

    public function replyMessage(Request $request){
        $inputs = $request->only(['member','subject','text','type']);
        $validator = Validator::make($inputs,[
            'member' => 'required',
            'subject' => 'required',
            'text'=>'required'
        ]);
        if($validator->fails()){
            // $errorMessages = $validator->messages()->toArray();
            // return redirect()->back()->with('error','Invalid inputs');
            return redirect()->back()->withErrors($validator);        
        }
        else{
               $data=Message::create($inputs);
               return redirect()->back()->with('success','Message replied successfully');
        }
    }
}

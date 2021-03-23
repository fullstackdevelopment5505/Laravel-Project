<?php

namespace App\Http\Controllers;
use Auth;
use Illuminate\Http\Request;

class CustomerDashboardController extends Controller
{

    public function login(Request $request){
        $email=$request->input('email');
        $password=$request->input('password');
        if(Auth()->attempt(['email','password'])){
          return redirect()->route('dashboard');
        }else{
            return redirect()->back()->with('error','Invalid credentials');
        }


    }
}

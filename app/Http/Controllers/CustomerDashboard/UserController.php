<?php

namespace App\Http\Controllers\CustomerDashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
class UserController extends Controller
{
    public function login(Request $request){
        $email=$request->input('email');
        $password=$request->input('password');
        if(Auth()->attempt(['email'=>$email,'password'=>$password])){
          return redirect()->route('dashboard');
        }else{
            return redirect()->back()->with('error','Invalid credentials');
        }
    }
    public function logout(){
        Auth::logout();
        return redirect()->route('login.show');
    }    
}

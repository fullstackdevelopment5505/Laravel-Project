<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Model\Kickstarter;
use App\Model\Image;
class KickStarterController extends Controller
{

    public function index($value='')
    {
    	$user=Kickstarter::with('profile_image')->orderBy('id','desc')->limit(5)->get();
    	return view('kickstarter.list',compact('user'));
    }

    public function add(Request $request)
    {
    	return view('kickstarter.add');
    }

    public function addDb(Request $request)
    {

    	if($request->hasfile('image'))
    	{
         
            $upld_profile_image = $request->file('image')->store('kickstarter_image');


            $data=array(
            	'user_id'=>uniqid(),
            	'name'=>$request->get('name'),
            	'description'=>$request->get('description')
            );
            $kick=Kickstarter::create($data);

            $image=array(
            	'user_id'=>$kick->id,
            	'type'=>'2',
            	'filename'=>$upld_profile_image
            );
            Image::create($image);
            return Redirect::back()->withSuccess('Successfully Added!!');
        }
    }

    public function destroyMulti(Request $request)
    {
        foreach ($request->get('selected') as $key => $value) {
            Kickstarter::where('id',$value)->delete();
            Image::where('user_id',$value)->where('type','2')->delete();
        }
        echo '1';
    }

    public function show($value='')
    {
    	$user=Kickstarter::with('profile_image')->where('user_id',$value)->first();
    	return view('kickstarter.show',compact('user'));
    }


    public function edit(Request $request)
    {
            $data=array(
            	'name'=>$request->get('name'),
            	'description'=>$request->get('description')
            );
            $kick=Kickstarter::where('id',$request->get('user_id'))->update($data);

         	if($request->hasfile('image'))
    		{
    			$upld_profile_image = $request->file('image')->store('kickstarter_image');
	            $image=array(
	            	'filename'=>$upld_profile_image
	            );
	            Image::where([['user_id',$request->get('user_id')],['type','2']])->update($image);
    		}   
    		return Redirect::back()->withSuccess('Successfully Updated!!');  
    }

}

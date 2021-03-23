<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Search;
class SearchController extends Controller
{
	public function list($value='')
	{
		$user=Search::with('user')->orderBy('id','desc')->get();
		return view('search.list',compact('user')); 
	}


	public function pending($value='')
	{
		$user=Search::with('user')->where('status','0')->orderBy('id','desc')->get();
		return view('search.list',compact('user')); 
	}

	public function closed($value='')
	{
		$user=Search::with('user')->where('status','1')->orderBy('id','desc')->get();
		return view('search.list',compact('user')); 
	}

	public function rejected($value='')
	{
		$user=Search::with('user')->where('status','2')->orderBy('id','desc')->get();
		return view('search.list',compact('user')); 
	}
    public function destroyMulti(Request $request)
    {
        foreach ($request->get('selected') as $key => $value) {
            Search::where('id',$value)->delete();
        }
        echo '1';
    }

    public function show($value='')
    {
    	$data=Search::with('user')->where('id',$value)->first();
    	return view('search.show',compact('data'));
    }

}

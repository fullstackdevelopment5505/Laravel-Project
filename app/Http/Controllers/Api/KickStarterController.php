<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Api\MainController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use App\Model\Kickstarter;
use App\Model\Image;
use DB;
use App\User;

class KickStarterController extends MainController
{
	public function mapKickSavedSearch(Request $request)
	{
	   
	  // $data=Saved::select("*",DB::raw("DATE_FORMAT(created_at,'%d-%b-%Y %H:%i:%s') AS date"))->where('user_id',Auth::id())->orderBy('id','desc')->skip(0)->take(5)->get();
       
	   /* $data = DB::table('saved_search')->select('saved_search.unique_id',
            'saved_search.search','kickstarter.name')
            ->leftJoin('tbl_kickstarter_like', 'saved_search.user_id', '=', 'tbl_kickstarter_like.user_id')
            ->leftJoin('kickstarter', 'tbl_kickstarter_like.user_id', '=', 'kickstarter.id')
            ->where('tbl_kickstarter_like.user_id',Auth::id() )->groupBy('saved_search.user_id')->orderBy('saved_search.id','desc')->get(); */
			
		$kick = Kickstarter::select('id','name','search')->orderBy('id','desc')->get();
		return $this->getResponse(200,'Saved Searches Kickstarter',$kick);
	}
    
	public function listKick(Request $request)
    {

         $id=Auth::check()? Auth::id() : null;
   		$kick=Kickstarter::select('kickstarter.id','kickstarter.user_id','kickstarter.name','kickstarter.description','tbl_kickstarter_like.status')
            ->with('profile_image')
            ->LeftJoin('tbl_kickstarter_like',function($join){
               $join->on('tbl_kickstarter_like.kickstarter_id','=','kickstarter.id');
               $join->where('tbl_kickstarter_like.user_id','=',Auth::id());
            })
            ->orderBy('kickstarter.id','desc')
            ->limit(5)->get();

   		return $this->getResponse(200,'List',$kick,1); 
    }

   public function fullList()
   {
         $kick=Kickstarter::select('kickstarter.id','kickstarter.user_id','kickstarter.name','kickstarter.description','tbl_kickstarter_like.status')
            ->with('profile_image')
            ->LeftJoin('tbl_kickstarter_like',function($join){
               $join->on('tbl_kickstarter_like.kickstarter_id','=','kickstarter.id');
               $join->where('tbl_kickstarter_like.user_id','=',Auth::id());
            })
            ->orderBy('kickstarter.id','desc')
            ->get();

         return $this->getResponse(200,'List',$kick,1); 
   }

   public function listDetail($value='')
   {
   		$kick=Kickstarter::select('kickstarter.id','kickstarter.user_id','kickstarter.name','kickstarter.description','tbl_kickstarter_like.status')
            ->with('profile_image')
            ->LeftJoin('tbl_kickstarter_like',function($join){
               $join->on('tbl_kickstarter_like.kickstarter_id','=','kickstarter.id');
               $join->where('tbl_kickstarter_like.user_id','=',Auth::id());
            })
            ->where('kickstarter.user_id',$value)->first();
			
		$related_kicks = Kickstarter::select('kickstarter.id','kickstarter.user_id','kickstarter.name','kickstarter.description','tbl_kickstarter_like.status')
            ->with('profile_image')
            ->LeftJoin('tbl_kickstarter_like',function($join){
               $join->on('tbl_kickstarter_like.kickstarter_id','=','kickstarter.id');
               $join->where('tbl_kickstarter_like.user_id','=',Auth::id());
            })
			->where('kickstarter.user_id','<>',$value)
            ->orderBy('kickstarter.id','desc')
            ->get();
		
		//return $this->getResponse(200,'List Detail',$kick,1);
		
   		return $this->getResponse(200,'List Detail',(Object)array('detail'=>$kick,'related_kicks'=>$related_kicks));
   }

   public function like(Request $request)
   {
     $count=DB::table('tbl_kickstarter_like')->where([['user_id',Auth::id()],['kickstarter_id',$request->get('id')]])->count();
      if($count==0){
         $data=array(
            'user_id'=>Auth::id(),
            'kickstarter_id'=>$request->get('id')
         );
         DB::table('tbl_kickstarter_like')->insert($data);
      }
      else{
         DB::table('tbl_kickstarter_like')->where([['user_id',Auth::id()],['kickstarter_id',$request->get('id')]])->delete();
      }
      return $this->getResponse(200,'Success');
   }

}

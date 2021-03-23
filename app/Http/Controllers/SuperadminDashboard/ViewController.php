<?php

namespace App\Http\Controllers\SuperadminDashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Validator, Response, DB;
use App\Model\Points;
use App\User;
use App\Category;
use App\NewsRole;
use App\Model\News;
use Carbon\Carbon;

class ViewController extends Controller
{
    public function dashboard(){
        return view('SuperadminDashboard.dashboard');
    }
    public function member(){
        return view('SuperadminDashboard.member');
    }
    public function kickstarter(){
        return view('SuperadminDashboard.kickstarter');
    }
    public function sale(){
        return view('SuperadminDashboard.sale');
    }
    public function purchase(){
        return view('SuperadminDashboard.purchase');
    }
    public function employee(){
        return view('SuperadminDashboard.employee.employee');
    }
    public function employeeHoliday(){
        return view('SuperadminDashboard.employee.holiday');
    }
    public function leaveRequest(){
        return view('SuperadminDashboard.employee.leaveRequest');
    }
    public function employeeAttendance(){
        return view('SuperadminDashboard.employee.attendance');
    }
    public function department(){
        return view('SuperadminDashboard.employee.department');
    }
    public function designation(){
        return view('SuperadminDashboard.employee.designation');
    }
    public function salary(){
        return view('SuperadminDashboard.employee.salary');
    }
    public function wallet(){
		/*  $credit=Points::with('user.details','user')->where('type',1)->whereDate('created_at', Carbon::today())->groupBy('user_id')->orderBy('id','desc')->sum('point'); */

		/* 	$debit=Points::with('user.details','user')->where('type',2)->whereDate('created_at', Carbon::today())->groupBy('user_id')->orderBy('id','desc')->sum('point'); */

		$credit = Points::with('user.details','user')->where('type','1')->whereDate('created_at', Carbon::today())->groupBy('user_id')->orderBy('id','desc')->sum('amount');

		$debit=Points::with('user.details','user')->where('type','2')->whereDate('created_at', Carbon::today())->where('instant',0)->groupBy('user_id')->orderBy('id','desc')->sum('amount');

		$total_credit = Points::with('user.details','user')->where('type','1')->groupBy('user_id')->orderBy('id','desc')->sum('amount');

		$total_debit=Points::with('user.details','user')->where('type','2')->where('instant',0)->groupBy('user_id')->orderBy('id','desc')->sum('amount');

		$total = $total_credit-$total_debit;
        $data =  Points::with('user.details','user')->orderBy('id','desc')->get();
        return view('SuperadminDashboard.wallet', compact('credit','debit','total','data'));
    }
    public function faq(){
        return view('SuperadminDashboard.cms.faq');
    }
    public function about(){
        return view('SuperadminDashboard.cms.about');
    }
    public function privacy(){
        return view('SuperadminDashboard.cms.privacy');
    }
    public function terms(){
        return view('SuperadminDashboard.cms.terms');
    }
    public function message(){
        return view('SuperadminDashboard.message.message');
    }
    public function sendMessage(){
        return view('SuperadminDashboard.message.sendMessage');
    }
    public function viewMessage(){
        return view('SuperadminDashboard.message.viewMessage');
    }
    public function contact(){
        return view('SuperadminDashboard.contacts');
    }
	public function newsCategoryList(){
        $data =  Category::orderBy('id','desc')->get();
        return view('SuperadminDashboard.cms.category', compact('data'));
    }
	public function newsByCategoryId($slug){
        $catData  =  Category::where('category_url',$slug)->pluck('id');

		$categories =  Category::orderBy('id','desc')->get();
		$roles 		=  NewsRole::orderBy('id','desc')->get();
		if(!isset($catData[0])){
			$data =[];
			$cat_id = 0;
			return view('SuperadminDashboard.news.categoryNews', compact('data','categories','roles','cat_id'));
		}
		$cat_id = $catData[0];
		$data = News::with("category_detail",'role_detail')->where('category',$catData[0])->orderBy('id','desc')->get();

		return view('SuperadminDashboard.news.categoryNews', compact('data','categories','roles','cat_id'));
    }
	public function saveNewsCategory(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required'
        ]);

        if ($validator->passes()) {

           // $slug = $this->createSlug($request->get('name'));
			$slug = Str::slug($request->get('name'));
			$cat_data = Category::where('category_url',$slug)->select('id')->first();
			if(isset($cat_data->id)){
				return response()->json(['error'=>'Category already exists.']);
			}
            $data=array(
                'name'=> $request->get('name'),
                'category_url'=>$slug
            );

            //echo "<pre>"; print_r($data); die;
            $catdata = Category::create($data);


			return response()->json(['success'=>'Added new records.']);
        }
    	return response()->json(['error'=>$validator->errors()->all()]);
    }
    public function updateNewsCategory(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required'
        ]);
        //echo "<pre>"; //print_r($request->all());
        if ($validator->passes()) {
            $catdata    =   Category::find($id);

			$slug = $this->createSlug($request->get('name'));
            // On update
			$slug = Str::slug($request->get('name'));
			$cat_data = Category::where('category_url',$slug)->where('id', '<>', $id)->select('id')->first();
			if(isset($cat_data->id)){
				return response()->json(['error'=>'Category already exists.']);
			}

            $catdata->name                  =   $request->get('name');
            $catdata->category_url          =   $slug;

            $updated              =   $catdata->save();
            if($updated){

                return response()->json(['success'=>'Category updated.']);

            }
        }
        return response()->json(['error'=>$validator->errors()->all()]);
    }
	public static  function  createSlug($title, $id = 0)
    {
        // Normalize the title
        $slug = Str::slug($title);

        // Get any that could possibly be related.
        // This cuts the queries down by doing it once.
        $allSlugs = self::getRelatedSlugs($slug, $id);

        // If we haven't used it before then we are all good.
        if (! $allSlugs->contains('url', $slug)){
            return $slug;
        }

        // Just append numbers like a savage until we find not used.
        for ($i = 1; $i <= 10; $i++) {
            $newSlug = $slug.'-'.$i;
            if (! $allSlugs->contains('url', $newSlug)) {
                return $newSlug;
            }
        }

        throw new \Exception('Can not create a unique url');
    }

    public static function getRelatedSlugs($slug, $id = 0)
    {
        return News::select('url')->where('url', 'like', $slug.'%')
            ->where('id', '<>', $id)
            ->get();
    }

    public function newsList(){
        $data 		=  News::with("category_detail",'role_detail')->orderBy('id','desc')->get();
        $categories =  Category::orderBy('id','desc')->get();
		$roles 		=  NewsRole::orderBy('id','desc')->get();
        return view('SuperadminDashboard.cms.news', compact('data','categories','roles'));
    }

	public function saveNews(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'category' => 'required',
			'posted_by_role' => 'required',
			'date' => 'required',
            'small_description' => 'required',
            'description' => 'required',
			'filename'   => '', //punch
            'vimeo_id'    => '', //punch
            'youtube_id'  => '', //punch
        ]);
        //  echo "<pre>"; print_r($request->all()); die;
        if ($validator->passes()) {
            $upld_image = '';
            if ($request->hasFile('filename')) {

                $upld_image = $request->file('filename')->store('news');

            }

            $slug = $this->createSlug($request->get('title'));


            $data=array(
                'title'=> $request->get('title'),
                'category'=> $request->get('category'),
				'date'=> $request->get('date'),
                'posted_by_role'=> $request->get('posted_by_role'),
                'small_description'=>$request->get('small_description'),
                'description'=>$request->get('description'),
                'url'=>$slug,
                'filename'=>$upld_image,
				'vimeo_id'=>$request->get('vimeo_id') ? $request->get('vimeo_id') : '',
				'youtube_id'=>$request->get('youtube_id') ? $request->get('youtube_id') : ''
            );

            //echo "<pre>"; print_r($data); die;
            $news = News::create($data);


			return response()->json(['success'=>'Added new records.']);
        }
    	return response()->json(['error'=>$validator->errors()->all()]);
    }

    public function updateNews(Request $request, $id)
    {

        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'category' => 'required',
			'posted_by_role' => 'required',
			'date' => 'required',
            'small_description' => 'required',
            'description' => 'required'
        ]);
		$validator->sometimes('filename', 'required_without:vimeo_id | required_without:youtube_id', function ($request) {
			if($request->get('file_check') == '1'){

				return false;
			}
		});

		$validator->sometimes('vimeo_id', 'required_without:filename | required_without:youtube_id', function ($request) {
			if($request->get('file_check') == '1'){

				return false;
			}
        });
        $validator->sometimes('youtube_id', 'required_without:filename | required_without:vimeo_id', function ($request) {
			if($request->get('file_check') == '1'){

				return false;
			}
		}); //punch
        if ($validator->passes()) {
            $news    =   News::find($id);

            if ($request->hasFile('filename')) {

                $upld_image = $request->file('filename')->store('news');
                $news->filename    =   $upld_image;
            }

			$slug = $this->createSlug($request->get('title'));
            // On update

            if ($slug != request('slug')) {
                $slug = $this->createSlug($request->title, $id);
            }
			$vimeo_id = request('vimeo_id');
			$youtube_id = request('youtube_id'); //punch
            $media_type = $request->get('media');
			if($media_type == 'vimeo_id'){
                $news->filename    =  '';
                $youtube_id = '';//punch
			}
			if($media_type == 'image'){
                $vimeo_id    =  '';
                $youtube_id = '';//punch

            }
            if($media_type == 'youtube_id'){ //punch
                $news->filename    =  '';
                $vimeo_id    =  '';

			}
            $news->title                =   request('title');
            $news->url                  =   $slug;
            $news->category             =   request('category');
			$news->date             	=   request('date');
			$news->posted_by_role       =   request('posted_by_role');
            $news->small_description    =   request('small_description');
            $news->description          =   request('description');
            $news->vimeo_id          	=   $vimeo_id;
            $news->youtube_id          	=   $youtube_id; //punch

            $updated                =   $news->save();
            if($updated){

                return response()->json(['success'=>'Records updated.']);

            }
        }
        return response()->json(['error'=>$validator->errors()->all()]);
    }

	public function ajaxHandling(Request $request)
    {

        if ($request->get("type") == "getNewsById") {
            if ( $request->id ) {
                $newsdata = News::where('id', $request->id)->first();
                if ($newsdata) {
                    return response()->json(['success'=>true, 'data' => $newsdata]);
                } else {
                    return response()->json(['error'=>true, 'data' => '']);
                }
            } else {
                return response()->json(['error'=>true, 'data' => '']);
            }
        }

        if($request->get("type") == "deleteNews"){

            $news = News::destroy($request->id);
            return response()->json(['success'=>'Delete successfully.']);

        }

		if ($request->get("type") == "getCatById") {
            if ( $request->id ) {
                $catdata = Category::where('id', $request->id)->first();
                if ($catdata) {
                    return response()->json(['success'=>true, 'data' => $catdata]);
                } else {
                    return response()->json(['error'=>true, 'data' => '']);
                }
            } else {
                return response()->json(['error'=>true, 'data' => '']);
            }
        }

        if($request->get("type") == "deleteNewsCategory"){

            $category = Category::destroy($request->id);
            $news = News::where('category',$request->id)->delete();
            return response()->json(['success'=>'Delete successfully.']);

        }

        return response()->json(['error'=>'Invalid request.']);
    }




}

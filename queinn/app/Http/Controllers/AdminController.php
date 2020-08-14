<?php
namespace App\Http\Controllers\AdminAuth;
namespace App\Http\Controllers;

use App\Admin\Stores;
use App\Blogs;
use App\Coupons;
use Illuminate\Http\Request;
//use App\Order;
use DB;
use Validator;
use Auth;
use Response;

class AdminController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    /*public function __construct()
    {
        $this->middleware('adminauth');
    }*/

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::guard('admin_user')->check()){
          return redirect('admin/home');
    	}
    	else{
    		return redirect('admin/login');
    	}
    }
	
	public function home(){

			if(date('l') == 'Sunday'){
				$today = strtotime(date('Y-m-d H:i:s'));
				$next_sat = strtotime('next saturday, 11:59am', $today);
				$start = date('Y-m-d').' 00:00:01';
				$end = date('Y-m-d',$next_sat).' 23:59:59';
			}else if(date('l') == 'Saturday'){
				$today = strtotime(date('Y-m-d H:i:s'));
				$last_sun = strtotime('last sunday, 12pm', $today);
				$start = date('Y-m-d',$last_sun).' 00:00:01';
				$end = date('Y-m-d').' 23:59:59';
			}else{
				$today = strtotime(date('Y-m-d H:i:s'));
				$start_sun = strtotime('last sunday, 12pm', $today);
				$end_sat = strtotime('next saturday, 11:59am', $today);
				$start = date('Y-m-d', $start_sun).' 00:00:01';
				$end = date('Y-m-d', $end_sat).' 23:59:59';
			}


            // Latest Blogs
            $blogs = Blogs::where('visibility', 1)->orderByDesc('created_at')->take(6)->get();
			$totalBlogs = Blogs::all()->count();
            // Total stores
            $store = Stores::all()->count();
            $coupons = Coupons::where('status', 1)->orderByDesc('created_at')->take(6)->with(['store'])->get();

            $coupon_clicks = Coupons::all();

            return view('admin.home',compact('blogs', 'store', 'coupons', 'coupon_clicks', 'totalBlogs'));
	}
	
	public function sendQuickEmail(Request $request){
			$rules = [
				'emailto' => 'required|email',
				'subject' => 'required',
				'message' => 'required'
			];
			
			$validator = Validator::make($request->all(), $rules);	
			
			 $input = $request->all();

			if ($validator->passes()) {
		
					// Store your user in database 
					$title          = 'Dear User';
					$content        = $request->input('message');
					$to             = $request->input('emailto');
					$subject        = $request->input('subject');
					$messagebody    = array('title' => $title, 'content' => $content);
					$template       = 'email-templates.send';
					$header         = array();
					send_smtp_email($to,$subject,$messagebody,$template,$header);  
					return Response::json(['success' => '1']);
			}
				
			return Response::json(['errors' => $validator->errors()]);
	}
}
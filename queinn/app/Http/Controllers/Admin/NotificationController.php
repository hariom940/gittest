<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Notification;
use Auth;
use Validator;
use Session;

class NotificationController extends Controller
{
    public function index(){
			$notification = Notification::where('id', '=', 1)->first();
          	return view('admin.notification',compact('notification'));
	}
	
	public function update(Request $request){
			$notification = Notification::where('id', '=', 1)->first();
			if(!empty($notification)){
						$content	 		= $request->input('content');
						$color 				= $request->input('color');
						$visible 			= $request->input('visible');
						
						
						$notification->content 	= $content;
						$notification->color 	= $color;
						$notification->visible 	= $visible;
						
						
						if($notification->save()){
							Session::flash('message', "Notification saved successfully.");
								return redirect('admin/notification');
						}
			}
	}
}

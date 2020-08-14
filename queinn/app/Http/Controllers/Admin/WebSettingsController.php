<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\WebSettings;
use Auth;
use Validator;
use Session;

class WebSettingsController extends Controller
{
    public function index(){
			$websettings = WebSettings::where('id', '=', 1)->first();
          	return view('admin.web-settings',compact('websettings'));
	}
	
	public function update(Request $request){
			$websettings = WebSettings::where('id', '=', 1)->first();
			if(!empty($websettings)){
						$head_title 		= $request->input('head_title');
						$support_text 		= $request->input('support_text');
						$contact_detail 	= $request->input('contact_detail');
						$facebook_url 		= $request->input('facebook_url');
						$twitter_url		= $request->input('twitter_url');
						$youtube_url		= $request->input('youtube_url');
						$tumblr_url			= $request->input('tumblr_url');
						$insta_url			= $request->input('insta_url');
						$gplus_url			= $request->input('gplus_url');
						$linkedin_url			= $request->input('linkedin_url');

						$websettings->head_title 		= $head_title;
						$websettings->support_text 		= $support_text;
						$websettings->contact_detail 	= $contact_detail;
						$websettings->facebook_url 		= $facebook_url;
						$websettings->twitter_url		= $twitter_url;
						$websettings->youtube_url		= $youtube_url;
						$websettings->tumblr_url		= $tumblr_url;
						$websettings->instagram_url		= $insta_url;
						$websettings->google_plus_url	= $gplus_url;
                        $websettings->linkedin_url      = $linkedin_url;
						
						if($websettings->save()){
							Session::flash('message', "Web Settings saved successfully.");
								return redirect('admin/web-settings');
						}
			}
	}
}

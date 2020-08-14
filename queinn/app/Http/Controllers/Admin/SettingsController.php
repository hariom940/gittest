<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Settings;
use Auth;
use Validator;
use Session;

class SettingsController extends Controller
{
    public function index(){
		if (Auth::guard('admin_user')->check()){
			//$categories = DB::table('categories')->get();
			$settings = DB::table('settings')->where('id', '=', 1)->first();
          	return view('admin.general-settings',compact('settings'));
    	}
    	else{
    		return redirect('admin/login');
    	}
	}
	
	public function updateSettings(Request $request){
			$validator = Validator::make($request->all(),[
					       'site_title' => 'required|min:5',
					       'logo' => 'image|mimes:jpeg,png,jpg,gif,svg|max:1024', 
					     ]);
			if ($validator->fails()) {  
			            return redirect('admin/general-settings')->withErrors($validator)->withInput();
			}
				//MAILCHIMP
				$data["mailchimp_api_key"]	= $request->input('mailchimp_api_key');
				$data["mailchimp_list_id"]	= $request->input('mailchimp_list_id'); 

				$data["paypal_email"]	= $request->input('paypal_email');

				$data["quickbook_application_login"]	= $request->input('quickbook_application_login');
				$data["quickbook_connection_ticket"]	= $request->input('quickbook_connection_ticket');


				$data["site_title"]   		= $request->input('site_title');
				$data["short_title"]   		= $request->input('short_title');
				$data["tagline"]    		= $request->input('tagline');
				$data["website"]    		= $request->input('website');
				$data["from_name"]   		= $request->input('from_name');
				$data["from_email"]   		= $request->input('from_email');
				$data["smtp_host"]    		= $request->input('smtp_host');
				$data["smtp_port"]    		= $request->input('smtp_port');
				$data["smtp_driver"]  		= $request->input('smtp_driver');
				$data["smtp_username"]   	= $request->input('smtp_username');
				$data["smtp_password"]   	= $request->input('smtp_password'); 
				$data["smtp_encryption"] 	= $request->input('smtp_encryption');
				$data["page_title"]      	= $request->input('page_title');
				$data["page_keyword"]    	= $request->input('page_keyword');
				$data["page_description"]  	= $request->input('page_description');
				$data["google_verification"]= $request->input('google_verification');
				$data["updated_at"]         = date('Y-m-d H:i:s');

		     	if ($request->hasFile('logo') || $request->hasFile('favicon'))   {
			         if ($request->hasFile('logo')) { 
			             $image = $request->file('logo');
			             $filename  = 'logo' . '.' . $image->getClientOriginalExtension();
			             $image->move(public_path('assets/uploads/logo/'), $filename);
			             $data["logo"] = "assets/uploads/logo/".$filename;
			         }        
			         if ($request->hasFile('favicon')) {
			              $favicon = $request->file('favicon');
			              $faviconfilename  = 'favicon' . '.' . $favicon->getClientOriginalExtension();
			              $favicon->move(public_path('assets/uploads/logo/'), $faviconfilename);
			              $data["favicon"] = "assets/uploads/logo/".$faviconfilename;
			         }
		        }
			    DB::table('settings')->where('id',1)->update($data);
			    Session::flash('message', "Settings saved successfully.");
			    return redirect('admin/general-settings');
	}
}

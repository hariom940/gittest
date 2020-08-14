<?php

namespace App\Http\Controllers;

use App\ContactDetails;
use Illuminate\Http\Request;
use App\Pages;
use Validator;
use Response;

class ContactController extends Controller
{
    	public function index(){
				$page = Pages::where('slug','contact')->first();
                $contactDetails = ContactDetails::orderBy('name', 'desc')->get();
				return view('contact-us',compact('page', 'contactDetails'));
		}
		
		public function send(Request $request){
			$rules = [
				'name'	  => 'required',
				'email' => 'required|email',
				'message' => 'required'
			];
			
			$validator = Validator::make($request->all(), $rules);	
			
			$input = $request->all();

			if ($validator->passes()) {
		
					// Store your user in database
					$title          = 'Dear Admin';
					$content        = $request->input('message');
					$to             = env('ADMIN_MAIL'); //$request->input('email');
					$subject        = 'Contact Us';
					$messagebody    = array('title' => $title, 'name'=>$request->input('name'), 'subject'=> 'New Query Contact Form', 'phone' => $request->input('phone'), 'email'=>$request->input('email'), 'content' => $content);
					$template       = 'email-templates.contact';
					$header         = array('from_name'=>$request->input('name'), 'from_email'=>$request->input('email'));
					echo send_smtp_email($to,$subject,$messagebody,$template,$header);
					return Response::json(['success' => '1']);
			}
				
			return Response::json(['errors' => $validator->errors()]);
		}
}

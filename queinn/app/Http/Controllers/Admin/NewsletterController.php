<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Newsletter;
use Redirect;
use Session;

class NewsletterController extends Controller
{
    public function index(){
		$subscriptions = Newsletter::orderBy('id', 'desc')->get();
		return view('admin.newsletter-subscription',compact('subscriptions'));
	}
	
	public function deleteSubscription($id){
		$deleteSubscription   = Newsletter::find($id);
		if(!empty($deleteSubscription)){
				$deleteSubscription->delete();
				Session::flash('message', "Subscription deleted successfully.");
				return redirect('admin/newsletter-subscription');
		}else{
				return redirect('admin/newsletter-subscription');
		}
	}
}

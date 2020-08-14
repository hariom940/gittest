<?php

namespace App\Http\Controllers;

use App\Settings;
use Request;
use Response;
use Cookie;
use Session;
use Illuminate\Support\Facades\Auth;
use Anam\Phpcart\Cart;
use Illuminate\Support\Facades\URL;
use App\Libraries\Coupon;
use App\Newsletter;
use Validator;
use App\Coupons;
use App\Products;
use App\Countries;
use App\States;
use App\Libraries\Ups;
use App\Shipping;
use App\User;
use App\Order;
use DHL\Entity\AM\GetQuote;
use DHL\Datatype\AM\PieceType;
use DHL\Client\Web as WebserviceClient;

class AjaxController extends Controller
{

  public function newsletterSubscription(){

	  $rules = [
				'newsletter_email' => 'required|email',
			];
			
			$validator = Validator::make(Request::all(), $rules);	
			
			$input = Request::all();

			if ($validator->passes()) {
					if(Newsletter::where('email',$input['newsletter_email'])->first()){
						return Response::json(['warning' => '2', 'msg'=>'You have already subscribed']);
					}
					$newsletter = new Newsletter();
					$newsletter->email = $input['newsletter_email'];
					$newsletter->created_at = date('Y-m-d H:i:s');
					$newsletter->updated_at = date('Y-m-d H:i:s');
					$newsletter->save();
//					if($newsletter->save()){
//						return Response::json(['success' => '1']);
//					}

          $setting = Settings::first();
          $list_id = $setting->mailchimp_list_id;
          $api_key = $setting->mailchimp_api_key;

          if(empty($list_id)){
              $list_id    = env("MAILCHIMP_LIST_ID", "d60e975f5d");
          }
          if(empty($api_key)){
              $api_key    = env("MAILCHIMP_API_KEY", "d813f4fb69c8566efd4b9a20039b9ea6-us3");
          }

          $email      = $input['newsletter_email'];
          $status     = 'subscribed'; // "subscribed" or "unsubscribed" or "cleaned" or "pending"
          $merge_fields = array('FNAME' => '', 'FPHONE' => '', 'FMSG' => '');

          $result     = mailchimp_subscriber_status($email, $status, $list_id, $api_key, $merge_fields );

          if(!empty($result)){
            $arr = json_decode($result);
            if($arr->status == 'subscribed'){
              return Response::json(['success' => '1', 'msg'=>'Your newsletter request has been successfully subscribed.']);
            }else{
              return Response::json(['warning' => '2', 'msg'=> $arr->detail]);
            }
          }
        }
				
			return Response::json(['errors' => $validator->errors()]);	
	  
  }
  
  public function getStates(){
	  $input = Request::all();
   	  if(Request::isMethod('post') && Request::ajax() && Session::token() == Request::header('X-CSRF-TOKEN')){
		  $country_code = $input['country_code'];
		  $states = getStates($country_code);
		  return response()->view('states',compact('states','country_code'));
		  
		  /*$country = Countries::where('sortname','=',$country_code)->first();
		  if(!empty($country)){
			  $states = States::where('country_id','=',$country->id)->orderBy('name', 'asc')->get();
			  return response()->view('states',compact('states'));
		  }*/
	  }
  }
  
  
}

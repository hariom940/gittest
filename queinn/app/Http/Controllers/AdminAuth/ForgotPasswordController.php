<?php

namespace App\Http\Controllers\AdminAuth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use Auth;
use Validator;
use Hash;
use Mail;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

    /**
     * Create a new controller instance.
     *
     * @return void
     */

    public function __construct()
    {
        $this->middleware('guest');
    }

	

	public function showLinkRequestForm(){
		if (Auth::guard('admin_user')->check()){
          	return redirect('/admin/home');
        }else{
        	return view('adminauth.forgotpassword');
        }
	}

	

	public function forgotPassword(Request $request){
		    $validator = Validator::make($request->all(), [
    			'email' => 'required|email|max:255',  			
    		]);	

			if ($validator->fails()) {
            		return redirect('admin/forgot-password')
                        ->withErrors($validator)
                        ->withInput();
        	}else{
					$authUser = DB::select('select * from admin_users where email = :email', ['email' => $request->input('email')]);
					if($authUser){
						$alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
					    $pass = array(); //remember to declare $pass as an array
						$alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
						for ($i = 0; $i < 8; $i++) {
							$n = rand(0, $alphaLength);
							$pass[] = $alphabet[$n];
						}
					  	$pwd = implode($pass);
					  	$npwd = Hash::make($pwd);
					  	
					  	$emailto        = $request->input('email');      
				        $subject        = 'Forgot Password';  
				        $messagebody    = array('username'=>$request->input('email'),'password'=>$pwd);

				        $template       = 'email-templates.admin-forget';
				        $header         = array();
						send_smtp_email($emailto,$subject,$messagebody,$template,$header);


					/*  Mail::send('email-templates.forget',$data, function ($message) use ($data) {
						$message->from('noreply@ticket-selection.com', 'Ticket Selection');
						$message->to($data['username'])->subject('Forgot Password');
						}); */

				
					    $update = DB::update("UPDATE admin_users SET password='".$npwd."'where email = :email", ['email' => $request->input('email')]);
						return redirect('admin/forgot-password')
							->withMessage('Your password has been reset. Please check your mail.');

					}else{
							return redirect('admin/forgot-password')
								->withErrors("Invalid Email id")
								->withInput();
					}
			}
	}
}


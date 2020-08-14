<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use App\User;
use Validator;
use Illuminate\Http\Request;
use Mail;
use \Crypt;

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
        $page = page('reset-password');
        return view('auth.passwords.email',compact('page'));
    }

    public function reset(Request $request){

        $validator = Validator::make($request->all(), [
            'email' => 'required|email|max:255',
        ]);

        if ($validator->fails()) {
            return redirect('password/reset')
                        ->withErrors($validator)
                        ->withInput();
        }
        else{
        $authUser = User::where('email', $request->input('email'))->first();
        
        if($authUser){
                    $token = Crypt::encrypt($authUser->id);
                    $data =  array('username'=>$request->input('email'), 'token'=>$token);
                    //echo $usermail;
                    $to         = $data['username'];
                    $subject    = 'Reset Password';
                    $messagebody    = $data; 
                    $template       = 'email-templates.forget';
                    $header = array();
                    send_smtp_email($to,$subject,$messagebody,$template,$header);
                     
                    $authUser->token = $token;
                    $authUser->save();

                    return redirect('password/reset')->withMessage('Please check your email. We have sent password reset link.');

        } else {
                return redirect('password/reset')
                        ->withErrors("Please enter a valid email.")
                        ->withInput();
        }
      }
    }
}

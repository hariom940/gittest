<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \Crypt;
Use App\User;

class CronWPResetPasswordEmailsController extends Controller
{
		public function index(){
			$users = User::where('mail_sent','=',0)->limit(100)->get();
			
			foreach($users as $user){
    			$authUser = User::where('email', $user->email)->first();
        	    if($authUser){
                    $token = Crypt::encrypt($authUser->id);
                    $data =  array('username'=>$user->email, 'name'=> $authUser->name.' '.$authUser->last_name, 'token'=>$token);
                    //echo $usermail;
                    $to         = $data['username'];
                    $subject    = 'Update Password';
                    $messagebody    = $data; 
                    $template       = 'email-templates.wordpress-users';
                    $header = array();
                    send_smtp_email($to,$subject,$messagebody,$template,$header);
                     
                    $authUser->token = $token;
                    $authUser->mail_sent = 1;
                    $authUser->save();
                    echo 'Mail sent to '.$user->email.' successfully'.'<br/>';
			    } 
			}
		}
}

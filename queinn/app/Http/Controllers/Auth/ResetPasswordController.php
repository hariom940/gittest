<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use \Crypt;
Use App\User;
use Validator;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = '/my-account';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function showResetForm($token){
         $page = page('reset-password');
         $etoken = Crypt::decrypt($token);
         $user = User::find($etoken);
         if(!empty($user)){
            return view('auth.passwords.reset',compact('user','token','page'));
         }else{
            return redirect('/');
         }

    }

    public function reset(Request $request, $token){
        $data = $this->validate(request(), [
            'email' => 'required|email|max:255',
            'password' => 'required|min:6|confirmed',
        ]);

        $etoken = Crypt::decrypt($token);
        $user = User::where('id',$etoken)->where('email',$request->input('email'))->first();
        if(!empty($user)){
            if($user->token == ''){
                    return redirect('password/reset/'.$token)
                        ->withErrors("Sorry, your password has been already changed")
                        ->withInput();
            }else{
                $user->token    = '';
                $user->password = bcrypt($request->input('password'));
                if($user->save()){
                       return redirect('password/reset/'.$token)->withMessage('Your password has been reset successfully. Please login with new password.');
                }
            }
        }else {
                return redirect('password/reset/'.$token)
                        ->withErrors("Please enter registered email with us.")
                        ->withInput();
        }
    }
}

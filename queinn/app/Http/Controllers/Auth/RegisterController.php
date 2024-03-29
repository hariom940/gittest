<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use App\PointsSettings;
use App\PointsLogs;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
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
	
	/**
     * Show the application registration form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showRegistrationForm()
    {
		$page = page('register');
        return view('auth.register',compact('page'));
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
//        var_dump($data); die;
        return Validator::make($data, [
            'first_name'        => 'required|string|max:255',
            'last_name'         => 'required|string|max:255',
            'email'             => 'required|string|email|max:255|unique:users',
            'phone'             => 'required|numeric|digits:10|unique:users',
            'password'          => 'required|string|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        $user = User::create([
            'name'      => $data['first_name'],
            'last_name' => $data['last_name'],
            'email'     => $data['email'],
            'phone'     => $data['phone'],
            'password'  => bcrypt($data['password']),
        ]);
        

        //Sign Up Points earned
        $pointsSettings = PointsSettings::where('id', '=', 1)->first();
        $new_user = User::find($user->id);
        if(!empty($new_user)){
                
                $pointslogs = new PointsLogs();
                $pointslogs->user_id = $new_user->id;
                $pointslogs->points  = $pointsSettings->earned_account_signup;
                $pointslogs->reason  = 'Points earned for account signup';
                $pointslogs->created_at  = date('Y-m-d H:i:s');
                $pointslogs->updated_at  = date('Y-m-d H:i:s');
                $pointslogs->save();

                $total = $new_user->earned_points + $pointsSettings->earned_account_signup;
                $new_user->earned_points = $total;
                $new_user->save();
        }

        $emailto        = $data['email'];      
        $subject        = 'Your account on Vanagain.com';  
        $messagebody    = array(
                                'name'     => $data['first_name'],
                                'username' => $data['email'],
                            );

        $template       = 'email-templates.registered-user';
        $header         = array('bccemail'=>env('ADMIN_MAIL'));
        send_smtp_email($emailto,$subject,$messagebody,$template,$header);
        return $user;
    }
}

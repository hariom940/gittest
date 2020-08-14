<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
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
        $this->middleware('guest')->except('logout');
    }
	
	public function showLoginForm()
    {
		$page = page('login');
        return view('auth.login',compact('page'));
    }

    //  --------------------- Social Login -------------------

    public function redirectToProvider($provider)
    {
//        echo $provider; die;
        return Socialite::driver($provider)->redirect();
    }

    //    ------------------ Callback function ----------------
    public function handleProviderCallback($provider)
    {
        $user = Socialite::driver($provider)->stateless()->user();

        $first_name = $user->user['name']['givenName'];
        $last_name  = $user->user['name']['familyName'];
        $email      = $user->email;
        $avatar     = $user->avatar;

        $existingUser = User::where('email', $user->email)->first();

        if(empty($existingUser)) {

            $new_user = User::create([
                'name' => $first_name,
                'last_name' => $last_name,
                'email' => $email,
                'featured_image' => $avatar,
            ]);
            auth()->login($new_user, true);
        }
        else{
            auth()->login($existingUser, true);
        }
        return redirect()->to('/my-account');
    }

    public function logout(){
        Auth::logout();
        return redirect('/login');
    }
}

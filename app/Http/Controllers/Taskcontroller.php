<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth; 
use Illuminate\Support\Facades\Hash;
use Validator,Redirect,Response;
use Session;
use Illuminate\Http\Request;
use App\Task;
use Illuminate\Support\Facades\DB;

class Taskcontroller extends Controller
{
  

public function index(){
	
	return view('user_login');
}

    
    	/*$task = DB::table('tasks')
    ->where('email',$request->input('email'))
    ->first();
    if(Hash::check($task->password,Hash::make($request->input('password'))))
    	{ 
    	return view('user_dashboard'); 
        
        }
        else
        	{
        	 echo "Password Wrong";
        	}*/
     public function userlogin(Request $request){
    $email=$request->email;
    $password=$request->password;
    //return $req->all();
    
    $task=Task::where('email',$email)->where('password',$password)->first();

    if($task!==Null){
        //$donor= donor_table::find($check);
        //return $donor;
        return view('user_dashboard',compact('task')); 
    }
    else{
        echo "Email or Password does not match ";
       }
    }


    public function logout() {
         
             return Redirect('user_login');
    }                   
     
 

}

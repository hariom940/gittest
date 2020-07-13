<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller; 
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Validator, Redirect, Response;
use Session;
use App\Task;
use Carbon\Carbon;

class ApisController extends Controller
{
    public $successStatus = 200;

    public function getAllList()   
    {
        $tasks = Task::all();
        return response()->json([ 
            'status'=>'ok',
            'data' =>  $tasks, 
        ], 200);
    }
    public function getTaskInfo($id)  
    { 
        $responseArray = array();
        if(isset($id)){
            $statusCode = 200; 
            $tasks = Task::find($id); 
            $responseArray['status'] = 'ok';
            $responseArray['data'] =  $tasks;

        }else{
            $statusCode = 304; 
            $responseArray['status'] = 'error';
            $responseArray['message'] =  'Please enter Id';
        } 
        return response()->json($responseArray, $statusCode);
    }

    public function addTask(Request $req)  
    {  
        $responseArray = array();

        if($req->input('name') ==''){
            $responseArray['status'] = 'error';
            $responseArray['message'] =  'Please enter name';
            $statusCode = 200;
        }else if($req->input('subtask') ==''){
            $responseArray['status'] = 'error';
            $responseArray['message'] =  'Please enter sub task';
            $statusCode = 200;
        }  else{
            $statusCode = 200; 
            $tasks = Task::find(2); 
            $responseArray['status'] = 'ok';
            $responseArray['data'] =  $tasks;
        }  
        return response()->json($responseArray, $statusCode);
    }
 

public function delete(Request $req){
$tasks=Task::find($req->id);
if($tasks->delete())
{
    return['Result'=>"success","msg"=>"data is deleted!!"];
}

}


   public function update(Request $req, $id){

    $validator = Validator::make($req->all(), [ 
                'name' => 'required', 
                'task_name' => 'required', 
            ]);
     if ($validator->fails()) { 
                return response()->json(['error'=>$validator->errors()], 401);            
            }

$tasks = Task::find($id);
$tasks->name = $req->input('name');
$tasks->task_name = $req->input('task_name');
$tasks->end_date = $req->input('due_date');
 $tasks->status = $req->input('status');

$tasks->save();
return response()->json( $tasks);
    

}


 public function details() 
    { 
        $user = Auth::user(); 
        return response()->json(['success' => $user], $this-> successStatus); 
    } 
/*

      public function login(){
       if(Auth::attempt(['email' => request('email'), 'user_password' => request('user_password')])){
           $user = Auth::user();
           $success['token'] =  $user->createToken('MyApp')->accessToken;
           return response()->json(['success' => $success], $this->successStatus);
       }
       else{
        
           return response()->json(['error'=>'Unauthorised'], 401);
       }
   }
   */



   public function register(Request $request)
   {
        $request->validate([
          'name' => 'required|string',
          'email' => 'required|string|email|unique:users',
          'password' => 'required|string|confirmed'
      ]);
      $user = new User([
          'name' => $request->name,
          'email' => $request->email,
          'password' => bcrypt($request->password)
      ]);
      $user->save();
      return response()->json([
          'message' => 'Successfully created user!'
      ], 201);
   }

   public function getDetails()
   {
       $user = Auth::user();
       return response()->json(['success' => $user], $this->successStatus);
   }

   public function login(Request $request){  
        $request->validate([
          'email' => 'required|string|email',
          'password' => 'required|string' 
      ]);
      $credentials = request(['email', 'password']);
      if(!Auth::attempt($credentials))
          return response()->json([
              'message' => 'Unauthorized'
          ], 401);
      $user = $request->user();
      $tokenResult = $user->createToken('Personal Access Token');
      $token = $tokenResult->token;
      if ($request->remember_me)
          $token->expires_at = Carbon::now()->addWeeks(1);
      $token->save();
      return response()->json([
          'access_token' => $tokenResult->accessToken,
          'token_type' => 'Bearer',
          'expires_at' => Carbon::parse(
              $tokenResult->token->expires_at
          )->toDateTimeString()
      ]);
  }
   
  public function postLogin(Request $request)
  {
    // Validations
    $rules = [
      'email'=>'required|email',
      'password'=>'required|min:5'
    ];
    $validator = Validator::make($request->all(), $rules);
    if ($validator->fails()) {
      // Validation failed
      return response()->json([
        'message' => $validator->messages(),
      ]);
    } else {
      // Fetch User
      $user = User::where('email',$request->email)->first();
      if($user) {
        // Verify the password
        if( password_verify($request->user_password, $user->user_password) ) {
          // Update Token
          $postArray = ['api_token' => $this->apiToken];
          $login = User::where('email',$request->email)->update($postArray);
          
          if($login) {
            return response()->json([
              'name'         => $user->name,
              'email'        => $user->email,
              'access_token' => $this->apiToken,
            ]);
          }
        } else {
          return response()->json([
            'message' => 'Invalid Password',
          ]);
        }
      } else {
        return response()->json([
          'message' => 'User not found',
        ]);
      }
    }
  }

}

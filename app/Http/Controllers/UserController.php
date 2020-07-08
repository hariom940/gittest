<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request; 
use App\User; 
use Illuminate\Support\Facades\Auth; 
use Illuminate\Support\Facades\Hash;
use Validator,Redirect,Response;
use Session;
use App\Task;

class UserController extends Controller
{

 
    public function index()
    {
        return view('login');
    }  
 
    public function registration()
    {
        return view('registration');
    }
     
    public function postLogin(Request $request)
    {

         // select 
        request()->validate([
        'email' => 'required',
        'password' => 'required',
        ]);
 
        $credentials = $request->only('email', 'password');
        //
       
        if (Auth::attempt($credentials)) {

            // Authentication passed...

       $tasks = Task::all();  
       return view('dashboard',compact('tasks'));
           // return redirect()->intended('dashboard',compact('tasks'));
        }
        return Redirect::to("login")->withSuccess('Oppes! You have entered invalid credentials');
    }
 
    public function postRegistration(Request $request)
    {  
        request()->validate([
        'name' => 'required',
        'email' => 'required|email|unique:users',
        'password' => 'required|min:6',
        ]);
         
        $data = $request->all();
 
        $check = $this->create($data);
       
        return Redirect::to("dashboard")->withSuccess('Great! You have Successfully loggedin');
    }
     
    public function dashboard()
    {
 
      if(Auth::check()){
         $tasks = Task::all();  
        return view('dashboard',compact('tasks'));
      }
       return Redirect::to("login")->withSuccess('Opps! You do not have access');
    }
 
    public function create(array $data)
    {
      return User::create([
        'name' => $data['name'],
        'email' => $data['email'],
        'password' => Hash::make($data['password'])
      ]);
    }
     
    public function logout() {
        Session::flush();
        Auth::logout();
        return Redirect('login');
    }


public function insert(Request $req){

 $tasks = new Task();

 $tasks->name = $req->input('name');
 $tasks->task_name = $req->input('task_name');
 $tasks->due_date = $req->input('due_date');
 $tasks->status = $req->input('status');  
 // $tasks->assign_to =  $req->input('name');  
 // $tasks->created_by = $req->input('status');  
 $tasks->sub_task  = implode(',', $req->input('sub_task'));


 $tasks->date = $req->date;
 $tasks->save();
if($tasks->save()){
 
      return Redirect('dashboard');
   // echo "insert sucessfull";
}
else{
    echo "failed";
}
}
 
 public function create_form()
{
    return view('create');
}

public function destroy($id)
    {
        $tasks = Task::find($id)->delete();
        return back()->with('message','Student Deleted Successfull !');
    }


public function edit($id)
    {
        $tasks = Task::find($id);
        return view('edit',compact('tasks'));
    }



public function view($id)
    {
        $tasks = Task::find($id);
        return view('view',compact('tasks'));
    }

public function update(Request $req, $id)
    {

       $tasks = Task::find($id);
      // $tasks = new Task();

 $tasks->name = $req->input('name');
 $tasks->task_name = $req->input('task_name');
 $tasks->due_date = $req->input('due_date');
 $tasks->status = $req->input('status');  
 // $tasks->assign_to =  $req->input('name');  
 // $tasks->created_by = $req->input('status');  
 $tasks->sub_task  = implode(',', $req->input('sub_task'));


 $tasks->date = $req->date;
 $tasks->save();
if($tasks->save()){
 
      return Redirect('dashboard');
   // echo "insert sucessfull";
}
else{
    echo "failed";
}
}

}

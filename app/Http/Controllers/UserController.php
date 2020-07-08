<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Validator, Redirect, Response;
use Session;
use App\Task;

class UserController extends Controller
{


    public function index()
    {
        $value = Session::get('USER_ID');
        if (isset($value)) {
            return Redirect::to("dashboard");
        } else {
            return view('login');
        }
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
        //  echo "<pre>"; print_r($credentials['password']); die;
        //
        $getUserInfo = User::where('email', $credentials['email'])->first()->toArray();
        // $getUserPwd = User::where('email','vishnu@gmail.com')->get()->toArray();
        //  DB::table('users')->where('name', 'John')->first();

        // $hashed = Hash::make('123456');  
        if (\Illuminate\Support\Facades\Hash::check($credentials['password'], $getUserInfo['user_password']) == false) {
            return Redirect::to("login")->withSuccess('Oppes! You have entered invalid credentials');
        } else {
            /* session([
                'USER_ID' =>  $getUserInfo['id'],
                'USER_TYPE' =>  $getUserInfo['user_type']  
            ]);  */
            Session::put([
                'USER_ID' =>  $getUserInfo['id'],
                'USER_TYPE' =>  $getUserInfo['user_type'],
                'USER_NAME' =>  $getUserInfo['name'],
            ]);
            return Redirect::to("dashboard");
        }
    }

    public function postRegistration(Request $request)
    {
        request()->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'user_password' => 'required|min:6',
        ]);
        $data = $request->all();
        $record = new User();
        $record->name = $data['name'];
        $record->email = $data['email'];
        $record->user_password = Hash::make($data['user_password']);
        $record->save();
        return Redirect::to("dashboard")->withSuccess('Great! You have Successfully loggedin');
    }

    public function dashboard()
    {
        $value = Session::get('USER_ID');
        if (isset($value)) {
            $tasks = Task::all();
            return view('dashboard', compact('tasks'));
        } else {
            return Redirect::to("login")->withSuccess('Opps! You do not have access');
        }
    }

    public function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'user_password' =>  'dddd'
        ]);
    }

    public function logout()
    {
        Session::flush();
        Auth::logout();
        return Redirect('login');
    }


    public function insert(Request $req)
    {

        $tasks = new Task();

        $tasks->name = $req->input('name');
        $tasks->task_name = $req->input('task_name');
        $tasks->end_date = $req->input('due_date');
        $tasks->status = $req->input('status');
        // $tasks->assign_to =  $req->input('name');  
        // $tasks->created_by = $req->input('status');  
        $tasks->sub_task  = implode(',', $req->input('sub_task'));


        $tasks->start_date = $req->date;
        $tasks->save();
        if ($tasks->save()) {

            return Redirect('dashboard');
            // echo "insert sucessfull";
        } else {
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
        return back()->with('message', 'Student Deleted Successfull !');
    }


    public function edit($id)
    {
        $tasks = Task::find($id); 
        return view('edit', compact('tasks'));
    }
 
    public function view($id)
    {
        $tasks = Task::find($id);
        return view('view', compact('tasks'));
    }

    public function update(Request $req, $id)
    {

        $tasks = Task::find($id);
        // $tasks = new Task();

        $tasks->name = $req->input('name');
        $tasks->task_name = $req->input('task_name');
        $tasks->end_date = $req->input('due_date');
        $tasks->status = $req->input('status');
        // $tasks->assign_to =  $req->input('name');  
        // $tasks->created_by = $req->input('status');  
        $tasks->sub_task  = implode(',', $req->input('sub_task')); 

        $tasks->start_date = $req->date;
        $tasks->save();
        if ($tasks->save()) {

            return Redirect('dashboard');
            // echo "insert sucessfull";
        } else {
            echo "failed";
        }
    }
}

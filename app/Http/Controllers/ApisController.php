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

class ApisController extends Controller
{


    public function index()
    {
       echo "yes"; die;
    }

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
 
}

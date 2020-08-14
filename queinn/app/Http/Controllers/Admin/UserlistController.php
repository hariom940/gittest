<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Userlist;
use App\Libraries\Slug;
use Validator;
use Session;
class UserlistController extends Controller
{
    public function index(){

		$user_list = Userlist::orderBy('id', 'asc')->get();
		return view('admin.user_list.user_list',compact('user_list'));
	
	}
	
	//Add page form
	public function addPage(){
		return view('admin.user_list.add-page');
	}
	
	//Save page to database
	public function savePage(Request $request){
  
        // Validate the Field
        $this->validate($request,[
            'email'=>'required',
            'password'=>'required',
            
        ]);
        $user_list = new Userlist();
        $user_list->name=$request->name;
        $user_list->email=$request->email;
        $user_list->password=Hash::make($request->password);
        $user_list->address=$request->address; 
        $user_list->save();
        return redirect()->route('user')->with('message','New Student Created Successfull !');

			
	}
	
	//Edit page form
	public function editPage($id){
		$user_list = Userlist::find($id); 
        return view('admin.user_list.edit-page', compact('user_list'));
	
	}
	
	//Update page to database
	public function updatePage($id, Request $request){


		   $this->validate($request,[
            
            'name'=>'required',
            'email'=>'required',
            
        ]);
        $user_list = Userlist::find($id);
        $user_list->name=$request->name;
        $user_list->email=$request->email;
        $user_list->address=$request->address;
        
        
        $user_list->save();
        return redirect()->action('Admin\UserlistController@index');	

	}

	
	//DElETE Page 
	public function deletePage($id){
		 $user_list = Userlist::find($id)->delete();
        return back()->with('message','Student Deleted Successfull !');
	
	
}
}

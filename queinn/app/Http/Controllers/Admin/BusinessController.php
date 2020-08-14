<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Business;
use App\Libraries\Slug;
use Validator;
use Session;
class BusinessController extends Controller
{
    public function index(){
		
		$business = Business::orderBy('id', 'asc')->get();
		return view('admin.business.business',compact('business'));
	}
	
	//Add page form
	public function addPage(){
		return view('admin.business.add-page');
	}
	
	//Save page to database
	public function savePage(Request $request){
   
        // Validate the Field
        $this->validate($request,[
            'email'=>'required',
            'password'=>'required',
            
        ]);
        $business = new Business();
        $business->email=$request->email;
       
        $business->password=Hash::make($request->password);

        $business->business_name=$request->business_name;
        $business->location=$request->location;
        $business->description=$request->description;
        $business->save();
        return redirect()->route('pages')->with('message','New Student Created Successfull !');

			
	}
	
	//Edit page form
	public function editPage($id){
		$business = Business::find($id); 
        return view('admin.business.edit-page', compact('business'));
	
	}
	
	//Update page to database
	public function updatePage($id, Request $request){
		

            $this->validate($request,[  
            'email'=>'required',
            'business_name'=>'required',
            
        ]);
        $business = Business::find($id);
        $business->email=$request->email;
        $business->business_name=$request->business_name;
        $business->location=$request->location;
        $business->description=$request->description; 
        $business->save();
        return redirect()->action('Admin\BusinessController@index');	
        
	}

	
	//DElETE Page 
	public function deletePage($id){
		$business   = Business::find($id);
		if(!empty($business)){	
				$business->delete();
				Session::flash('message', "Page deleted successfully.");
				return redirect('admin/pages');
		}else{
			return redirect('admin/pages');
		}
	}
	
}

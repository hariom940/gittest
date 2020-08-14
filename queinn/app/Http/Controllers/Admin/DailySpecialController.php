<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\DailySpecials;
use App\Libraries\Slug;
use Validator;
use Session;
class DailySpecialController extends Controller
{
    public function index(){
		
		$daily_special = DailySpecials::orderBy('id', 'asc')->get();
		return view('admin.daily_special.daily_special',compact('daily_special'));
	}
	
	//Add page form
	public function addPage(){
		return view('admin.daily_special.add-page');
	}
	
	//Save page to database
	public function savePage(Request $request){
   
        // Validate the Field
        $this->validate($request,[
            'tagline'=>'required',
            'body'=>'required',
            
        ]);
        $daily_special = new DailySpecials();
        $daily_special->tagline=$request->tagline;
        $daily_special->body=$request->body;
        $daily_special->date=$request->date;
       
        $daily_special->save();
        return redirect()->route('daily_special')->with('message','New Student Created Successfull !');

			
	}
	
	//Edit page form
	public function editPage($id){
		$daily_special = DailySpecials::find($id); 
        return view('admin.daily_special.edit-page', compact('daily_special'));
	
	}
	
	//Update page to database
	public function updatePage($id, Request $request){
		

            $this->validate($request,[
            
            'tagline'=>'required',
            'body'=>'required',
            
        ]);
        $daily_special = DailySpecials::find($id);
        $daily_special->tagline=$request->tagline;
        $daily_special->body=$request->body;
        $daily_special->date=$request->date;
        $daily_special->save();
        return redirect()->action('Admin\DailySpecialController@index');	
        
	}

	
	//DElETE Page 
	public function deletePage($id){

           $daily_special = DailySpecials::find($id)->delete();
        return back()->with('message','Student Deleted Successfull !');

	}
	
}

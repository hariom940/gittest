<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Appointment;
use App\Libraries\Slug;
use Validator;
use Session;
class AppointmentController extends Controller
{
    public function index(){
	
		$appointments = Appointment::orderBy('id', 'asc')->get();
		return view('admin.appointment.appointment',compact('appointments'));
	}
	
	//Add page form
	public function addPage(){
		return view('admin.appointment.add-page');
	}
	
	//Save page to database
	public function savePage(Request $request){
   
        // Validate the Field
        $this->validate($request,[
            'order_no'=>'required',
            
            
        ]);
        $appointments = new Appointment();
        $appointments->order_no=$request->order_no;
        $appointments->date=$request->date;
        $appointments->notes=$request->notes;
        $appointments->save();
        return redirect()->route('appointment')->with('message','New Student Created Successfull !');

			
	}
	
	//Edit page form
	public function editPage($id){
		$appointments = Appointment::find($id); 
        return view('admin.appointment.edit-page', compact('appointments'));
	
	}
	
	//Update page to database
	public function updatePage($id, Request $request){
		

            $this->validate($request,[
            
            'order_no'=>'required',
            
            
        ]);
        $appointments = Appointment::find($id);
        $appointments->order_no=$request->order_no;
        $appointments->date=$request->date;
        $appointments->notes=$request->notes;
        $appointments->save();
        return redirect()->action('Admin\AppointmentController@index');	
        
	}

	
	//DElETE Page 
	public function deletePage($id){
		$appointments = Appointment::find($id)->delete();
        return back()->with('message','Student Deleted Successfull !');
		
	}
	
}

<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Order;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Libraries\Slug;
use Validator;
use Session;

class OrderController extends Controller
{
    public function index(){
		
		$order = Order::orderBy('id', 'asc')->get();
		return view('admin.order.order',compact('order'));
	}
	
	
	
	//Save page to database
	public function savePage(Request $request){
   
        // Validate the Field
        $this->validate($request,[
            
            'total_price'=>'required',
            
        ]);
        $order = new Order();
        $order->cart_item=$request->cart_item;
        $order->total_price=$request->total_price;
        $order->payment_method=$request->payment_method;
        
        $order->save();
        return redirect()->route('order')->with('message','New Student Created Successfull !');

			
	}
	
	//Edit page form
	public function editPage($id){
		$order = Order::find($id); 
        return view('admin.order.edit-page', compact('order'));
	
	}
	
	//Update page to database
	public function updatePage($id, Request $request){
		

            $this->validate($request,[
            
            'total_price'=>'required',
            
        ]);
        $order = Order::find($id);
        $order->cart_item=$request->cart_item;
        $order->total_price=$request->total_price;
        $order->payment_method=$request->payment_method;
        
        
        $order->save();
        return redirect()->action('Admin\OrderController@index');	
        
	}

	
	//DElETE Page 
	public function deletePage($id){
		$order = Order::find($id)->delete();
        return back()->with('message','Student Deleted Successfull !');
		
	}
	
}

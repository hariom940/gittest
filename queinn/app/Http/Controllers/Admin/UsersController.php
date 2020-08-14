<?php
namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\BlogComments;
use App\User;
use App\AdminUser;
use App\Order;
use Session;
use Redirect;
use Auth;
use Validator;

class UsersController extends Controller
{
    public function index(){
		$users = User::orderBy('id', 'desc')->get();
		return view('admin.user.users',compact('users'));
   }

   
   //Add USER Form
	public function addUser(){		
		return view('admin.user.add-user');
	}

	
	//Save USER Form
	public function saveUser(request $request){
			$validator = Validator::make($request->all(),[
    			 'name' => 'required',
				 'password'=> 'required|min:6',
				 'email' => 'required|email|unique:users',
				 'featured_image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:5000',
    		]);

			
			if ($validator->fails()) {
            		return redirect('admin/users/add')
                        ->withErrors($validator)
                        ->withInput();
        	}

			
			$name				= $request->input('name');
			$email				= $request->input('email');
			$password			= $request->input('password');	

			$user  = new User();

			$user->name			= $name;
			$user->email		= $email;
			$user->password		= Hash::make($password);
		
			if ($request->hasFile('featured_image'))
			{
				$image = $request->file('featured_image');			
				$filename  = rand(11111,99999) . '.' . $image->getClientOriginalExtension();
				$image->move(public_path('assets/uploads/user/'), $filename);
				$user->featured_image = 'assets/uploads/user/'.$filename;
			}
			

			$user->created_at 	= date('Y-m-d H:i:s');
			$user->updated_at 	= date('Y-m-d H:i:s');

			if($user->save()){
				Session::flash('message', "User added successfully.");
				return redirect('admin/users');
			}else{
				Session::flash('error', "User creation fails. Please try again after some time.");
				return redirect('admin/users');
			}
	}

	

	//EDIT User
	public function editUser($id){
		$editUser   = User::find($id);
		if(!empty($editUser)){
			$allOrders = Order::where('user_id',$id)->orderBy('created_at', 'desc')->get();
        	return view('admin.user.edit-user',compact('editUser','allOrders'));
		}else{
			return redirect('admin/users');
		}
	}

	

	//UPDATE User
	public function updateUser($id, request $request){
		$editUser   = User::find($id);
		if(!empty($editUser)){
        	$validator = Validator::make($request->all(),[
    			 'name' => 'required',
				 'password'=> 'sometimes|nullable|min:6',
				 'email' => 'required|email|unique:users,id,'.$editUser->id,
				 'featured_image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:5000',
    		]);


			if ($validator->fails()) {
            		return redirect('admin/users/edit/'.$id)
                        ->withErrors($validator)
                        ->withInput();
        	}

			$name				= $request->input('name');
			$email				= $request->input('email');
			$password			= $request->input('password');
					

			$editUser->name			= $name;
			$editUser->email		= $email;

			if($password!=''){
				$editUser->password	= Hash::make($password);
			}

			if ($request->hasFile('featured_image'))
			{
				$image = $request->file('featured_image');
				$filename  = rand(11111,99999) . '.' . $image->getClientOriginalExtension();
				$image->move(public_path('assets/uploads/user/'), $filename);
				$editUser->featured_image = 'assets/uploads/user/'.$filename;
			}			

			$editUser->updated_at 	= date('Y-m-d H:i:s');

			if($editUser->save()){
				Session::flash('message', "User updated successfully.");
				return redirect('admin/users');
			}else{
				Session::flash('error', "User updation fails. Please try again after some time.");
				return redirect('admin/users');
			}	
		}else{
			return redirect('admin/users');
		}
	}

	

	//Delete User
	public function deleteUser($id){
		$deleteUser   = User::find($id);
		if(!empty($deleteUser)){
				$deleteUser->delete();
				//DELETE ORDERS AND BLOG COMMENTS DELETE in ENTIRE SITE
				//Orders::where('user_id', '=', $id)->delete();
				BlogComments::where('user_id', '=', $id)->delete();
				Session::flash('message', "User deleted successfully.");
				return redirect('admin/users');
		}else{
			return redirect('admin/users');
		}
	}

   

   	//ADMIN PROFILE

	public function adminProfile(){
		$adminUser   = AdminUser::find('1');
		if(!empty($adminUser)){
			return view('admin.user.admin-user',compact('adminUser'));
		}else{
			return redirect('admin/users');
		}
	}

	

	//UPDATE ADMIN PROFILE
	public function updateAdminProfile(request $request){
		$adminUser   = AdminUser::find('1');
		if(!empty($adminUser)){
			$validator = Validator::make($request->all(),[
    			 'name' => 'required',
				 'password'=> 'sometimes|nullable|min:6',
				 //'email' => 'required|email|unique:admin_users,id,'.$adminUser->id,
				 'featured_image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:5000',
    		]);
			
			if ($validator->fails()) {
            		return redirect('admin/users/profile/')
                        ->withErrors($validator)
                        ->withInput();
        	}

			$name				= $request->input('name');
			//$email				= $request->input('email');
			$password			= $request->input('password');
			$adminUser->name		= $name;
			//$adminUser->email		= $email;

			if($password!=''){
				$adminUser->password	= Hash::make($password);
			}
		

			if ($request->hasFile('featured_image'))
			{
				$image = $request->file('featured_image');
				$filename  = 'admin.' . $image->getClientOriginalExtension();
				$image->move(public_path('assets/uploads/adminuser/'), $filename);
				$adminUser->featured_image = 'assets/uploads/adminuser/'.$filename;
			}

			$adminUser->updated_at = date('Y-m-d H:i:s');
			
			if($adminUser->save()){
				Session::flash('message', "Your profile updated successfully.");
				return redirect('admin/users/profile');
			}else{
				Session::flash('error', "Your profile updation fails. Please try again after some time.");
				return redirect('admin/users/profile');
			}	
		}else{
			return redirect('admin/users');
		}

	}

	/**
	* validate if current logged in admin is superadmin
	*/
	public function isSuperAdmin(){
		if(Auth::guard('admin_user')->user()->role != 1)
			return false;
		return true;
	}

	/**
	* list of all admins
	*/
	public function admins(){
		if(!$this->isSuperAdmin()){
			return redirect('admin/home');
		}
		$admins = AdminUser::where('role', 0)->orderBy('id', 'desc')->get();
		return view('admin.user.admins', compact('admins'));
	}

	/**
	* display the add new admin view
	*/
	public function addAdminView(){
		if(!$this->isSuperAdmin()){
			return redirect('admin/home');
		}
		return view('admin.user.add-admin');
	}

	/**
	* add the new admin into database
	*/
	public function addAdmin(Request $request){
		if(!$this->isSuperAdmin()){
			Session::flash('error', 'You are not authorized.');
			return redirect('admin/admins');
		}
		$validator = Validator::make($request->all(),[
		 	'name' => 'required',
		 	'password'=> 'required|min:6',
 			'email' => 'required|email|unique:admin_users',
		 	'featured_image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:5000',
		]);
		if ($validator->fails()) {
    		return redirect('admin/admin/add')
                ->withErrors($validator)
                ->withInput();
    	}
    	// create new admin object
		$admin  			= new AdminUser();
		$admin->name		= $request->input('name');
		$admin->email		= $request->input('email');
		$admin->password	= Hash::make($request->input('password'));
		$admin->role 		= 0;
		if ($request->hasFile('featured_image'))
		{
			$image = $request->file('featured_image');
			$filename  = 'admin_'.time().'.' . $image->getClientOriginalExtension();
			$image->move(public_path('assets/uploads/adminuser/'), $filename);
			$admin->featured_image = 'assets/uploads/adminuser/'.$filename;
		}
		if(!$admin->save()){
			Session::flash('error', "Admin creation fails. Please try again after some time.");
			return redirect('admin/admins');
		}
		Session::flash('message', "Admin added successfully.");
		return redirect('admin/admins');
	}

	/**
	* delete admin
	*/
	public function deleteAdmin($id){
		if(!$this->isSuperAdmin()){
			Session::flash('error', 'You are not authorized.');
			return redirect('admin/admins');
		}
		$admin = AdminUser::find($id);
		if(!$admin){
			Session::flash('error', 'Admin not found.');
			return redirect('admin/admins');
		}
		if($admin->role == 1){
			Session::flash('error', 'This admin cannot be deleted');
			return redirect('admin/admins');
		}
		if(!$admin->delete()){
			Session::flash('error', 'Admin not deleted. Please try after sometime.');
			return redirect('admin/admins');
		}
		Session::flash('message', 'Admin deleted successfully.');
		return redirect('admin/admins');
	}

	/**
	* display the edit admin view in dashboard.
	*/
	public function editAdminView($id){
		if(!$this->isSuperAdmin()){
			Session::flash('error', 'You are not authorized.');
			return redirect('admin/admins');
		}
		$admin = AdminUser::find($id);
		if(!$admin){
			Session::flash('error', 'Admin not found.');
			return redirect('admin/admins');
		}
		return view('admin.user.edit-admin')->with('admin', $admin);
	}

	/**
	* update the admin details in database.
	*/
	public function editAdmin($id, Request $request) {
		if(!$this->isSuperAdmin()) {
			Session::flash('error', 'You are not authorized.');
			return redirect('admin/admins');
		}

		$validator = Validator::make($request->all(),[
		 	'name' => 'required',
			'email' => 'required|email|unique:admin_users,email,'.$id,
		]);

		if ($validator->fails()) {
    		return redirect()->back()
                ->withErrors($validator)
                ->withInput();
    	}

    	$admin = AdminUser::find($id);
    	
    	if($admin->role == 1){
    		Session::flash('error', 'supper admin cannot be updated from here.');
    		return redirect('admin/admins');
    	}

		$admin->name = $request->input('name');
		$admin->email = $request->input('email');
		if($request->input('password')) {
			$admin->password = Hash::make($request->input('password'));
		}
		if ($request->hasFile('featured_image')) {
			$image = $request->file('featured_image');
			$filename  = 'admin_'.time().'.' . $image->getClientOriginalExtension();
			$image->move(public_path('assets/uploads/adminuser/'), $filename);
			$admin->featured_image = 'assets/uploads/adminuser/'.$filename;
		}
		if(!$admin->save()){
			Session::flash('error', 'Admin details not updated, please try after some time.');
			return redirect()->back();
		}
		Session::flash('message', 'Admin details updated successfully.');
		return redirect('admin/admins');
	}
}


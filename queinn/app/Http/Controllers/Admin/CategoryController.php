<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Libraries\Slug;
use App\Categories;
use Session;
use Redirect;
use Auth;
use Validator;

class CategoryController extends Controller
{
	public function index(){
		if (Auth::guard('admin_user')->check()){
			//$categories = DB::table('categories')->get();
			$categories = Categories::where('parent', '=', 0)->get();
        	$allCategories = Categories::pluck('name','id','slug','image','description')->all();
          	return view('admin.product-categories',compact('categories','allCategories'));
    	}
    	else{
    		return redirect('admin/login');
    	}
	}
	
	public function ProductCategories(Request $request){
		    $validator = Validator::make($request->all(),[
    			'catname' => 'required|min:5',
				 'thumbnail' => 'image|mimes:jpeg,png,jpg,gif,svg|max:5000',
    		]);	
			
			if ($validator->fails()) {
            		return redirect('admin/product-categories')
                        ->withErrors($validator)
                        ->withInput();
        	}
			
			$catname 			= $request->input('catname');
			$catslug 			= $request->input('slug');
			$catparent 			= $request->input('parent');
			$catDescription 	= $request->input('description');
			$page_title     	= $request->input('page_title');
			$page_keyword   	= $request->input('page_keyword');
			$page_description 	= $request->input('page_description');
			
			if($catslug == ''){
				$catslug = str_slug($catname, '-');
			}
			
			$slugClass = new Slug();
    		$newslug = $slugClass->make($catslug, 'categories', 'slug');
			
			
			$filename = '';
			
			if ($request->hasFile('thumbnail'))
			{
				$image = $request->file('thumbnail');
				$filename  = $newslug . '.' . $image->getClientOriginalExtension();
				$image->move(public_path('assets/uploads/'), $filename);
			}
			
			
			$id = DB::table('categories')->insertGetId(
				['name' => $catname, 'slug' => $newslug, 'parent'=> ($catparent == '-1') ? 0 : $catparent, 'image'=>'assets/uploads/'.$filename, 'description' => $catDescription, 'page_title' => $page_title, 'page_keyword' => $page_keyword, 'page_description' => $page_description, 'created_at'=>date('Y-m-d H:i:s'), 'updated_at'=>date('Y-m-d H:i:s')]
			);
			
			if($id){
				Session::flash('message', "Category created successfully.");
				return Redirect::back();
			}else{
				Session::flash('error', "Category creation fails. Please try again after some time.");
				return Redirect::back();
			}							
	}
	
	public function edit($id)
    {
        $editCategory   = Categories::find($id);
		if(!empty($editCategory)){
			$categories = Categories::where('parent', '=', 0)->get();
        	return view('admin.edit-product-categories',compact('categories','editCategory'));
		}else{
			return redirect()->action('Admin\CategoryController@index');
		}
    }
	
	public function updateCategory($id, Request $request){
		 $editCategory   = Categories::find($id);
		 if(!empty($editCategory)){
			 $validator = Validator::make($request->all(),[
    			 'catname' 		=> 'required|min:5',
				 'thumbnail' 	=> 'image|mimes:jpeg,png,jpg,gif,svg|max:5000',
				 'slug'			=> 'unique:categories,slug,'.$id
    		]);	
			
			if ($validator->fails()) {
            		return redirect('admin/product-categories/edit/'.$id)
                        ->withErrors($validator)
                        ->withInput();
        	}
			
			$catname 			= $request->input('catname');
			$catslug 			= $request->input('slug');
			$catparent 			= $request->input('parent');
			$catDescription 	= $request->input('description');
			$page_title     	= $request->input('page_title');
			$page_keyword   	= $request->input('page_keyword');
			$page_description 	= $request->input('page_description');
						
			if($catslug == ''){
				$catslug = str_slug($catname, '-');
				$slugClass = new Slug();
    			$catslug = $slugClass->make($catslug, 'categories', 'slug');
			}
			
			if ($request->hasFile('thumbnail'))
			{
				$image = $request->file('thumbnail');
				$filename  = $catslug . '.' . $image->getClientOriginalExtension();
				$image->move(public_path('assets/uploads/'), $filename);
				DB::table('categories')
            		->where('id',$id)
            		->update(['name' => $catname, 'slug' => $catslug, 'parent'=> ($catparent == '-1') ? 0 : $catparent, 'image'=>'assets/uploads/'.$filename, 'description' => $catDescription, 'page_title' => $page_title, 'page_keyword' => $page_keyword, 'page_description' => $page_description, 'updated_at'=>date('Y-m-d H:i:s')]);
			}else{
				DB::table('categories')
            		->where('id',$id)
            		->update(['name' => $catname, 'slug' => $catslug, 'parent'=> ($catparent == '-1') ? 0 : $catparent, 'description' => $catDescription, 'page_title' => $page_title, 'page_keyword' => $page_keyword, 'page_description' => $page_description, 'updated_at'=>date('Y-m-d H:i:s')]);
			}
			
			
			
			Session::flash('message', "Category updated successfully.");
				return redirect()->action('Admin\CategoryController@index');
			
		 }else{
			 return redirect()->action('Admin\CategoryController@index');
		 }
		
	}
	
	public function deleteCategory($id)
    {
        $delCategory   = Categories::find($id);
		if(!empty($delCategory)){
//		    dd($delCategory->image);
		    if($delCategory->image != "assets/uploads/"){
			    unlink(public_path($delCategory->image));
            }
			if($delCategory->{'parent'} == 0){
				DB::table('categories')->where('parent', '=', $id)->delete();
			}
			DB::table('categories')->where('id', '=', $id)->delete();
			Session::flash('message', "Category deleted successfully.");
				return redirect()->action('Admin\CategoryController@index');
		}else{
			return redirect()->action('Admin\CategoryController@index');
		}
    }
}

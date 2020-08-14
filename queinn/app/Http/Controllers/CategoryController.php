<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Categories;

class CategoryController extends Controller
{
	//ROOT CATEGORY PAGE
    public function index($cat_slug){
		$settings = logo_with_title();
		$page = page($cat_slug);
		
		$category = Categories::where('parent', '=' ,0)->where('slug',$cat_slug)->first();
		return view('category',compact('category','settings','page'));
	}
	
	//CHILD CATEGORY PAGE
	public function categoryDetail($cat_slug, $cat_child_slug){
		$settings = logo_with_title();
		$page = page($cat_slug);
		
		$childCategory = Categories::where('parent', '!=' ,0)->where('slug',$cat_child_slug)->first();
		if(!empty($childCategory)){
			$pid = $childCategory->parent;
			$parentcategory = Categories::where('parent', '=' ,0)->where('slug',$cat_slug)->where('id',$pid)->first();
			if(!empty($parentcategory)){
				$categories = Categories::where('parent', '=', 0)->orderBy('name', 'asc')->get();
				return view('child-category-with-products',compact('parentcategory','categories','childCategory','settings','page'));
			}else{
				return redirect($cat_slug);
			}
		}
		
	}
}

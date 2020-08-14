<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FaqController extends Controller
{
    public function index(){
				$settings 	= logo_with_title();
				$page 		= page('faqs');
				return view('faq',compact('settings','page'));
		}
}

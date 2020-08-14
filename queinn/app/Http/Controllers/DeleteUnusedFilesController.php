<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DeleteUnusedFilesController extends Controller
{
    //

    /**
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function index()
    {
//        dean_delete_unused_files();
        return redirect('/');
    }
}

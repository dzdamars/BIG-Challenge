<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;
use App\Admin;
use App\Group;
use App\Http\Controllers\Controller;

class ErrorController extends Controller
{
    /**
     * Show the profile for the given user.
     *
     * @param  int  $id
     * @return View
     */
    public function index(Request $request)
    {
        $status = $this->fetchMenu($request);

        return view('error.index');
    }
}
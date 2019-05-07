<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ScheduleController extends Controller
{
    /**
     * Show the profile for the given user.
     *
     * @param  int  $id
     * @return View
     */
    public function index(Request $request)
    {
        $status = $this->ceklogin($request,'/schedule/list','/schedule/list');

        if($status['message'] == "error not logged in"){
            return redirect('login?redirect_to='.$status['redirect_to']);
        }
        elseif($status['message'] == "error not have access"){
            return redirect('/error/notauthorize');
        }

        return view('schedule.index');
    }

    public function create(Request $request)
    {
        $status = $this->ceklogin($request,'/schedule/create','/schedule/create');

        if($status['message'] == "error not logged in"){
            return redirect('login?redirect_to='.$status['redirect_to']);
        }
        elseif($status['message'] == "error not have access"){
            return redirect('/error/notauthorize');
        }

        return view('schedule.create');
    }
}
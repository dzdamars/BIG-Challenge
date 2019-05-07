<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    /**
     * Show the profile for the given user.
     *
     * @param  int  $id
     * @return View
     */
    public function index(Request $request)
    {
        $status = $this->ceklogin($request,'/home','/home');

        if($status['message'] == "error not logged in"){
            return redirect('login?redirect_to='.$status['redirect_to']);
        }
        elseif($status['message'] == "error not have access"){
            return redirect('/error/notauthorize');
        }

        $data = array();
        $data['display_name'] = $request->session()->get('display_name');

        return view('dashboard.index', $data);
    }
}
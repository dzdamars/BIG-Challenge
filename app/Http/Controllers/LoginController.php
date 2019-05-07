<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Admin;
use App\Http\Controllers\Controller;

class LoginController extends Controller
{
    /**
     * Show the profile for the given user.
     *
     * @param  int  $id
     * @return View
     */
    public function index(Request $request)
    {
        $data = array();
        
        $redirect_to = $request->query('redirect_to');
        
        // print_r($redirect_to);die();

        if (!isset($redirect_to)) {
            $data['decoded'] = url('/').'/home';
        }else{
            $data['decoded'] = url('/').urldecode($redirect_to);    
        }
        
        $id_admin = $request->session()->get('id_admin');
        
        if($id_admin != ""){
            return redirect('/home');
        }

        return view('login.index',$data);
    }

    public function ajaxrequest(Request $request)
    {
        $response = array();

        $post = $request->all();

        $matchThese = ['username' => $post['username'], 'password' => $post['password']];

        $results = Admin::where($matchThese)->get()->toArray();
        

        if(count($results) != 1){
            $response['status'] = 'error';
            $response['message'] = 'Invalid Username Or Password!';
        }else{
            $request->session()->put('id_admin', $results[0]['id_admin']);
            $request->session()->put('display_name', $results[0]['display_name']);
            $request->session()->put('id_group', $results[0]['id_group']);

            $response['status'] = 'success';
            $response['message'] = 'You have been logged in '.$results[0]['display_name'].'';
        }
        return json_encode($response);
    }

    public function logout(Request $request)
    {
        $request->session()->flush();

        return redirect('login');
    }
}
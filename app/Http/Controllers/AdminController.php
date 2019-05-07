<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;
use App\Admin;
use App\Group;
use App\Http\Controllers\Controller;

class AdminController extends Controller
{
    /**
     * Show the profile for the given user.
     *
     * @param  int  $id
     * @return View
     */
    public function index(Request $request)
    {
        $status = $this->ceklogin($request,'/admin/list','/admin/list');

        if($status['message'] == "error not logged in"){
            return redirect('login?redirect_to='.$status['redirect_to']);
        }
        elseif($status['message'] == "error not have access"){
            return redirect('/error/notauthorize');
        }

        $data = array();
        $data['logged_in'] = $request->session()->get('id_admin');
        $data['dataAdmins'] = DB::table('admin as a')
                            ->join('group as g', 'a.id_group', '=', 'g.id_group')
                            ->select('a.*', 'g.group_name', 'a.id_admin')
                            ->get();


        return view('admin.index',$data);
    }

    public function create(Request $request)
    {
        $status = $this->ceklogin($request,'/admin/create','/admin/create');

        if($status['message'] == "error not logged in"){
            return redirect('login?redirect_to='.$status['redirect_to']);
        }
        elseif($status['message'] == "error not have access"){
            return redirect('/error/notauthorize');
        }
        
        $data = array();
        $data['groups'] = Group::all()->toArray();

        return view('admin.create', $data);
    }

    public function detail(Request $request,$id_admin)
    {
        $status = $this->ceklogin($request,'/admin/list','/admin/detail/'.$id_admin);

        if($status['message'] == "error not logged in"){
            return redirect('login?redirect_to='.$status['redirect_to']);
        }
        elseif($status['message'] == "error not have access"){
            return redirect('/error/notauthorize');
        }
        
        $data = array();
        $data['dataAdmin'] = Admin::where(['id_admin' => $id_admin])->first()->toArray();
        $data['groups'] = Group::all()->toArray();

        return view('admin.detail', $data);
    }

    public function ajaxrequest(Request $request)
    {
        $admin = new Admin;

        $response = array();

        $post = $request->all();
        
        if($post['process'] == "cekUsernameSave")
        {
            
        }
        elseif($post['process'] == "save")   
        {
            $results = Admin::where(['username' => $post['username']])->get()->toArray();

            if(count($results) > 0){
                $response['status'] = 'error';
                $response['message'] = 'Username Has Been Taken !';
            }else{
                $admin->display_name = $post['display_name'];
                $admin->username = $post['username'];
                $admin->password = $post['password'];
                $admin->id_group = $post['group'];

                $saved = $admin->save();

                if(!$saved){
                    $response['status'] = 'error';
                    $response['message'] = 'something really bad has happend :(';
                }else{
                    $response['status'] = 'success';
                    $response['message'] = 'Data Saved !';
                }
            }
        }
        elseif ($post['process'] == "update") 
        {
            $results = Admin::where(['username' => $post['username']])->whereNotIn('id_admin', [$post['id_admin']])->get()->toArray();

            if(count($results) > 0){
                $response['status'] = 'error';
                $response['message'] = 'username has been taken by other admin !';
            }else{
                $adminUpdate = Admin::find($post['id_admin']);
            
                $adminUpdate->display_name = $post['display_name'];
                $adminUpdate->username = $post['username'];
                $adminUpdate->password = $post['password'];
                $adminUpdate->id_group = $post['group'];

                $saved = $adminUpdate->save();

                if(!$saved){
                    $response['status'] = 'error';
                    $response['message'] = 'something really bad has happend :(';
                }else{
                    $response['status'] = 'success';
                    $response['message'] = 'Data Saved !';
                }
            }            
        }
        elseif ($post['process'] == "delete")
        {
            $adminDelete = Admin::find($post['id_admin']);

            $saved = $adminDelete->delete();

            if(!$saved){
                $response['status'] = 'error';
                $response['message'] = 'something really bad has happend :(';
            }else{
                $response['status'] = 'success';
                $response['message'] = 'Data Deleted !';
            }
        }

        return json_encode($response);


    }
}
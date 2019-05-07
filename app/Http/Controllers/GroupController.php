<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Group;
use App\Menu;
use App\AdminAccess;
use App\Http\Controllers\Controller;

class GroupController extends Controller
{
    /**
     * Show the profile for the given user.
     *
     * @param  int  $id
     * @return View
     */
    public function index(Request $request)
    {
        $status = $this->ceklogin($request,'/group/list','/group/list');

        if($status['message'] == "error not logged in"){
            return redirect('login?redirect_to='.$status['redirect_to']);
        }
        elseif($status['message'] == "error not have access"){
            return redirect('/error/notauthorize');
        }

        $data = array();
        $data['dataGroups'] = Group::all()->toArray();


        return view('group.index',$data);
    }

    public function create(Request $request)
    {
        $status = $this->ceklogin($request,'/group/create','/group/create');

        if($status['message'] == "error not logged in"){
            return redirect('login?redirect_to='.$status['redirect_to']);
        }
        elseif($status['message'] == "error not have access"){
            return redirect('/error/notauthorize');
        }
        
        $data = array();
        $data['display_name'] = $request->session()->get('display_name');

        return view('group.create', $data);
    }

    public function detail(Request $request,$id_group)
    {
        $status = $this->ceklogin($request,'/group/list','/group/detail/'.$id_group);

        if($status['message'] == "error not logged in"){
            return redirect('login?redirect_to='.$status['redirect_to']);
        }
        elseif($status['message'] == "error not have access"){
            return redirect('/error/notauthorize');
        }
        
        $data = array();
        $data['dataGroup'] = Group::where(['id_group' => $id_group])->first()->toArray();

        return view('group.detail', $data);
    }

    public function access(Request $request,$id_group)
    {
        $status = $this->ceklogin($request,'/group/list','/group/access/'.$id_group);

        if($status['message'] == "error not logged in"){
            return redirect('login?redirect_to='.$status['redirect_to']);
        }
        elseif($status['message'] == "error not have access"){
            return redirect('/error/notauthorize');
        }

        $menu_level_1 = Menu::where(['level_menu' => '1'])->get()->toArray();

        foreach ($menu_level_1 as $keyTop => $valueTop) {
            $firstchild = Menu::where(['parent_id_menu' => $valueTop['id_menu']])->get()->toArray();
            
            if(count($firstchild) > 0){
                $menu_level_1[$keyTop]['child'] = $firstchild;

                foreach ($firstchild as $keyfirst => $valuefirst) {
                    $secondchild = Menu::where(['parent_id_menu' => $valuefirst['id_menu']])->get()->toArray();
                    
                    if(count($secondchild) > 0){
                        $menu_level_1[$keyTop]['child'][$keyfirst]['grandchild'] = $secondchild;
                    }
                }
            }
        }
        $data = array();
        $data['menu'] = $menu_level_1;
        $data['menu_raw'] = Menu::all()->toArray();
        $data['dataGroup'] = Group::where(['id_group' => $id_group])->first()->toArray();
        $data['has_access'] = array();

        $has_access = AdminAccess::where('id_group', $id_group)->get()->toArray();
        
        foreach ($has_access as $key => $value) {
            array_push($data['has_access'], $value['id_menu']);
        }
        
        // print_r($data['has_access']);die();
        


        return view('group.access', $data);
    }

    public function ajaxrequest(Request $request)
    {
        $group = new Group;

        $response = array();

        $post = $request->all();
        
        if($post['process'] == "save")   
        {
            $group->group_name = $post['group_name'];

            $saved = $group->save();

            if(!$saved){
                $response['status'] = 'error';
                $response['message'] = 'something really bad has happend :(';
            }else{
                $response['status'] = 'success';
                $response['message'] = 'Data Saved !';
            }
        }
        elseif ($post['process'] == "update") 
        {
            $groupUpdate = Group::find($post['id_group']);
        
            $groupUpdate->group_name = $post['group_name'];

            $saved = $groupUpdate->save();

            if(!$saved){
                $response['status'] = 'error';
                $response['message'] = 'something really bad has happend :(';
            }else{
                $response['status'] = 'success';
                $response['message'] = 'Data Saved !';
            }         
        }
        elseif ($post['process'] == "delete")
        {
            $groupDelete = Group::find($post['id_group']);

            $saved = $groupDelete->delete();

            if(!$saved){
                $response['status'] = 'error';
                $response['message'] = 'something really bad has happend :(';
            }else{
                $response['status'] = 'success';
                $response['message'] = 'Data Deleted !';
            }
        }
        elseif ($post['process'] == "update_menu_access") 
        {
            AdminAccess::where('id_group', $post['id_group'])->delete();

            $saved = "";
            foreach ($post['id_menus'] as $key => $id_menu) {
                $admin_access = new AdminAccess;

                $admin_access->id_menu = $id_menu;
                $admin_access->id_group = $post['id_group'];

                $saved = $admin_access->save();
            }

            if($saved == ""){
                $response['status'] = 'error';
                $response['message'] = 'something really bad has happend :(';
            }else{
                $response['status'] = 'success';
                $response['message'] = 'Access Setting Saved !';
            }
        }

        return json_encode($response);


    }
}
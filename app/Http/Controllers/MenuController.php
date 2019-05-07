<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;
use App\Menu;
use App\Http\Controllers\Controller;

class MenuController extends Controller
{
    /**
     * Show the profile for the given user.
     *
     * @param  int  $id
     * @return View
     */
    public function index(Request $request)
    {
        $status = $this->ceklogin($request,'/menu/list','/menu/list');

        if($status['message'] == "error not logged in"){
            return redirect('login?redirect_to='.$status['redirect_to']);
        }
        elseif($status['message'] == "error not have access"){
            return redirect('/error/notauthorize');
        }

        $data = array();
        $data['dataMenus'] = DB::table('menu as m')
                            ->leftJoin('menu as m2', 'm.parent_id_menu', '=', 'm2.id_menu')
                            ->select('m.*', 'm2.text_menu as parent_text_menu', 'm.id_menu')
                            ->get();


        return view('menu.index',$data);
    }

    public function create(Request $request)
    {
        $status = $this->ceklogin($request,'/menu/create','/menu/create');

        if($status['message'] == "error not logged in"){
            return redirect('login?redirect_to='.$status['redirect_to']);
        }
        elseif($status['message'] == "error not have access"){
            return redirect('/error/notauthorize');
        }
        
        $data = array();

        return view('menu.create', $data);
    }

    public function detail(Request $request,$id_menu)
    {
        $status = $this->ceklogin($request,'/menu/list','/menu/detail/'.$id_menu);

        if($status['message'] == "error not logged in"){
            return redirect('login?redirect_to='.$status['redirect_to']);
        }
        elseif($status['message'] == "error not have access"){
            return redirect('/error/notauthorize');
        }
        
        $data = array();
        $data['dataMenu'] = Menu::where(['id_menu' => $id_menu])->first()->toArray();

        return view('menu.detail', $data);
    }

    public function ajaxrequest(Request $request)
    {
        $menu = new Menu;

        $response = array();

        $post = $request->all();
        
        if($post['process'] == "getParent")
        {
            $parent_level = $post['level_menu']-1;
            $results = Menu::where(['level_menu' => $parent_level])->get()->toArray();

            if(count($results) == 0){
                $response['status'] = 'error';
                $response['message'] = "Parent Menu Not Available";
            }else{
                $response['status'] = 'success';
                $response['parent_list'] = $results;
            }
        }
        elseif($post['process'] == "save")   
        {
            $menu->icon = $post['icon'];
            $menu->text_menu = $post['text_menu'];
            $menu->link_menu = $post['link_menu'];
            $menu->parent_id_menu = $post['parent_id_menu'];
            $menu->level_menu = $post['level_menu'];

            $saved = $menu->save();

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
            $menuUpdate = Menu::find($post['id_menu']);
            
            $menuUpdate->icon = $post['icon'];
            $menuUpdate->text_menu = $post['text_menu'];
            $menuUpdate->link_menu = $post['link_menu'];
            $menuUpdate->parent_id_menu = $post['parent_id_menu'];
            $menuUpdate->level_menu = $post['level_menu'];

            $saved = $menuUpdate->save();

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
            $menuDelete = Menu::find($post['id_menu']);

            $saved = $menuDelete->delete();

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
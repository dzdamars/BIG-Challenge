<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

use App\Menu;
use App\AdminAccessMenu;

use View;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function ceklogin(Request $request,$accessed_page,$redirect_to)
    {
        $this->fetchMenu($request);

    	$data = array();
    	$data['message'] = "";
    	$data['redirect_to'] = 	urlencode($redirect_to);
        
    	$id_admin = $request->session()->get('id_admin');
        $id_group = $request->session()->get('id_group');

        if($id_admin == ""){
            $data['message'] = "error not logged in";
            return $data;
        }else{
            $has_access = AdminAccessMenu::where(['id_group' => $id_group,'link_menu' => $accessed_page])->first();
            // print_r($has_access);die();
            if($has_access == ""){
                $data['message'] = "error not have access";
            }else{
            	$data['message'] = "success";
            }

            return $data;
        }
    }

    public function fetchMenu(Request $request)
    {   
        $group_id_logged_in = $request->session()->get('id_group');
        // print_r($group_id_logged_in);die();

        $menu_level_1 = AdminAccessMenu::where(['level_menu' => '1', 'id_group' => $group_id_logged_in])->orderBy('id_menu', 'asc')->get()->toArray();

        foreach ($menu_level_1 as $keyTop => $valueTop) {
            $firstchild = AdminAccessMenu::where(['parent_id_menu' => $valueTop['id_menu'], 'id_group' => $group_id_logged_in])->get()->toArray();
            
            if(count($firstchild) > 0){
                $menu_level_1[$keyTop]['child'] = $firstchild;

                foreach ($firstchild as $keyfirst => $valuefirst) {
                    $secondchild = AdminAccessMenu::where(['parent_id_menu' => $valuefirst['id_menu'], 'id_group' => $group_id_logged_in])->get()->toArray();
                    
                    if(count($secondchild) > 0){
                        $menu_level_1[$keyTop]['child'][$keyfirst]['grandchild'] = $secondchild;
                    }
                }
            }
        }
        
        View::share('menuNav', $menu_level_1);

        $display_name = $request->session()->get('display_name');
        View::share('display_name', $display_name);
    }
}

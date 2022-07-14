<?php

namespace App\Http\Controllers;

use App\Models\System\Menu;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    //
    public function Index(Request $request){
        $userInfo = session('userInfo');
        $menu_list = Menu::query()->get()->toArray();
        $return_menu = [];
        foreach ($menu_list as $menu){
            if ($menu['id'] == $menu['parent_id']){
                $return_menu[($menu['id'])] = $menu;
            }else{
                $return_menu[($menu['parent_id'])]['son'][] = $menu;
            }
        }
//        dd($return_menu);
        return view('Index',[
            'menu'=>$return_menu,
            'userInfo'=>$userInfo
        ]);
    }
}

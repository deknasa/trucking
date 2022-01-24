<?php

namespace App\Http\Controllers;

use App\Helpers\Menu;
use App\Models\Menu as ModelsMenu;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\View;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;


    public function __construct()
    {
        $this->initFunction();
    }

    public function initFunction()
    {
        $this->initMyauth();
        $categories = $this->get_data();
        View::share('sqlmenu', $categories);
    }

    private function initMyauth()
    {
        // $this->request = \Config\Services::request();
        $this->router = Route::current()->getActionMethod();

        $this->arr = [
            'server' => "web.transporindo.com",
            'user' => "sa",
            'pass' => "MDF123!@#ldf1411",
            'db' => DB::connection()->getDatabaseName(),
            'isLogin' => isset($_SESSION['logged_in']) ? 1 : 0,
            'userPK' => isset($_SESSION['userpk']) ? $_SESSION['userpk'] : 0,
            'baseUrl' => URL::to('/')
        ];
    }

    public function get_data($induk = 0)
    {
        $data = array();
        $query = ModelsMenu::leftJoin('acos', 'menu.aco_id', '=', 'acos.id')->where('menu.menuparent', $induk)->orderby(DB::raw('right(menukode,1)'), 'ASC')->get(['menu.id', 'menu.menuname', 'menu.menuicon', 'acos.class', 'acos.method', 'menu.link', 'menu.menukode']);
        foreach ($query as $row) {
            // $check = $this->myauth->hasPermission($row->class, $row->method);
            // $check = \App\Libraries\Myauth::hasPermission($row->class, $row->method);
            // if ($check == true || $row->class == "") {

            $data[] = array(
                'menuid'    => $row->id,
                'menuname'    => $row->menuname,
                'menuicon'    => $row->menuicon,
                'link' => $row->link,
                'menuno' => substr($row->menukode, -1),
                'menukode' => $row->menukode,
                'menuexe'    => $row->class . "/" . $row->method,
                // recursive
                'child'    => $this->get_data($row->id)
            );
            // }
        }
        return $data;
    }
}

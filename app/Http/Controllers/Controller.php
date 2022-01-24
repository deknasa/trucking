<?php

namespace App\Http\Controllers;

use App\Helpers\Menu;
use App\Libraries\Myauth;
use App\Models\Menu as ModelsMenu;
use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\View;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public $myAuthConfig;
    public $myAuth;

    public function __construct()
    {
        $this->setMyAuthConfig();

        $this->initMyauth();

        $this->loadMenu();
    }

    public function setMyAuthConfig(): void
    {
        $database = Config::get('database.connections.' . Config::get('database.default'));

        $this->myAuthConfig = [
            'server' => $database['driver'],
            'user' => $database['username'],
            'pass' => $database['password'],
            'db' => $database['database'],
            'isLogin' => Auth::check() ?? 0,
            'userPK' => Auth::id() ?? 0,
        ];
    }

    public function loadMenu(): void
    {
        $menu = $this->getMenu();
        View::share('sqlmenu', $menu);
    }

    private function initMyauth(): void
    {
        $this->myAuth = new Myauth($this->myAuthConfig);

        View::share('myAuth', $this->myAuth);
    }

    public function getMenu($induk = 0): array
    {
        $data = [];

        $menu = ModelsMenu::leftJoin('acos', 'menu.aco_id', '=', 'acos.id')
            ->where('menu.menuparent', $induk)
            ->orderby(DB::raw('right(menukode,1)'), 'ASC')
            ->get(['menu.id', 'menu.menuname', 'menu.menuicon', 'acos.class', 'acos.method', 'menu.link', 'menu.menukode']);

        foreach ($menu as $row) {
            $hasPermission = $this->myAuth->hasPermission('user', 'index');

            if ($hasPermission) {
                $data[] = array(
                    'menuid' => $row->id,
                    'menuname' => $row->menuname,
                    'menuicon' => $row->menuicon,
                    'link' => $row->link,
                    'menuno' => substr($row->menukode, -1),
                    'menukode' => $row->menukode,
                    'menuexe' => $row->class . "/" . $row->method,
                    'child' => $this->getMenu($row->id)
                );
            }
        }

        return $data;
    }

    public function hasPermission($class, $method): bool
    {
        return $this->myAuth->hasPermission($class, $method);
    }
}

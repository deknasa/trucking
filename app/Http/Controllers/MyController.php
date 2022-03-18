<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\View;
use App\Helpers\Menu;
use App\Libraries\Myauth;
use App\Models\Aco;
use App\Models\Menu as ModelsMenu;
use App\Models\Role;
use App\Models\User;
use App\Models\UserRole;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;

class MyController extends Controller
{
    public $myAuthConfig;
    public $myAuth;
    public $class;
    public $method;
    public $breadcrumb;
    public $httpHeaders = [
        'Accept' => 'application/json',
        'Content-Type' => 'application/json',
    ];

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this::__construct();

            $this->setClass();
            $this->setMethod();
            
            $this->setBreadcrumb($this->class);
            
            $this->setMyAuthConfig();
            
            $this->initMyauth();
            
            $this->myAuth->auth($this->class, $this->method);
            
            $this->loadMenu();

            return $next($request);
        });
    }

    public function setClass(): void
    {
        $uri = Route::current()->uri();

        $class = explode('/', $uri)[0];

        $this->class = $class;
    }

    public function setMethod(): void
    {
        $this->method = Route::current()->getActionMethod();
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

    public function getMenu($induk = 0)
    {
        // $data = [];

        // $menu = ModelsMenu::leftJoin('acos', 'menu.aco_id', '=', 'acos.id')
        //     ->where('menu.menuparent', $induk)
        //     ->orderby(DB::raw('right(menukode,1)'), 'ASC')
        //     ->get(['menu.id', 'menu.aco_id', 'menu.menuseq', 'menu.menuname', 'menu.menuicon', 'acos.class', 'acos.method', 'menu.link', 'menu.menukode']);

        // foreach ($menu as $index => $row) {
        //     $hasPermission = $this->myAuth->hasPermission($row->class, $row->method);

        //     if ($hasPermission || $row->class == null) {
        //         $data[] = [
        //             'menuid' => $row->id,
        //             'aco_id' => $row->aco_id,
        //             'menuname' => $row->menuname,
        //             'menuicon' => $row->menuicon,
        //             'link' => $row->link,
        //             'menuno' => substr($row->menukode, -1),
        //             'menukode' => $row->menukode,
        //             'menuexe' => $row->class . "/" . $row->method,
        //             'class' => $row->class,
        //             'child' => $this->getMenu($row->id),
        //             'menuparent' => $row->menuparent,
        //         ];
        //     }
        // }

        // return $data;


        $results = [];

        $role = UserRole::where('user_id', Auth::id())->first();
        
        $menus = DB::select("
            SELECT DISTINCT menu.id, menu.aco_id, menu.menuseq, menu.menuname, menu.menuicon, acos.class, acos.method, menu.link, menu.menukode, menu.menuparent FROM menu
            LEFT JOIN useracl ON menu.aco_id = useracl.aco_id
            LEFT JOIN acos ON acos.id = menu.aco_id
            WHERE menuparent = $induk AND (useracl.user_id = " . Auth::id() . " OR menu.aco_id = 0)
            UNION ALL
            SELECT DISTINCT menu.id, menu.aco_id, menu.menuseq, menu.menuname, menu.menuicon, acos.class, acos.method, menu.link, menu.menukode, menu.menuparent FROM menu
            LEFT JOIN acl ON menu.aco_id = acl.aco_id
            LEFT JOIN acos ON acos.id = menu.aco_id
            WHERE menuparent = $induk AND (acl.role_id = " . ($role->id ?? 0) . " OR menu.aco_id = 0)
            AND menu.menuname NOT IN (
                SELECT DISTINCT menuname FROM menu
                LEFT JOIN useracl ON menu.aco_id = useracl.aco_id
                LEFT JOIN acos ON acos.id = menu.aco_id
                WHERE menu.menuparent = $induk AND (useracl.user_id = " . Auth::id() . " OR menu.aco_id = 0)
            )
            ORDER BY menu.menukode ASC
        ");

        foreach (collect($menus) as $menu) {
            $results[] = [
                'menuid' => $menu->id,
                'aco_id' => $menu->aco_id,
                'menuname' => $menu->menuname,
                'menuicon' => $menu->menuicon,
                'link' => $menu->link,
                'menuno' => substr($menu->menukode, -1),
                'menukode' => $menu->menukode,
                'menuexe' => $menu->class . "/" . $menu->method,
                'class' => $menu->class,
                'child' => $this->getMenu($menu->id),
                'menuparent' => $menu->menuparent,
            ];
        }

        return $results;
    }

    public function hasPermission($class, $method)
    {
        return $this->myAuth->hasPermission($class, $method);
    }

    public function setBreadcrumb($class): void
    {
        if (!request()->ajax()) {
            $breadcrumbs = [];

            $aco = Aco::where('class', $this->class)->first();

            if (isset($aco)) {
                $menu = ModelsMenu::where('aco_id', $aco->id)->first();

                if (isset($menu)) {
                    $breadcrumbs[] = isset($menu->aco_id) && $menu->aco_id == 0 ? $menu->menuname : '<a href="' . URL::to('/') . '/' . $menu->aco->class . '/' . $menu->aco->method . '">' . $menu->menuname . '</a>';

                    while (null !== $menu = ModelsMenu::find($menu->menuparent)) {
                        $breadcrumbs[] = isset($menu->aco_id) && $menu->aco_id == 0 ? $menu->menuname : '<a href="' . URL::to('/') . '/' . $menu->aco->class . '/' . $menu->aco->method . '">' . $menu->menuname . '</a>';
                    }

                    $this->breadcrumb = join(' / ', array_reverse($breadcrumbs));
                }
            } else {
                $this->breadcrumb = 'Dashboard';
            }
        }
    }

    public function getParameter(string $group, string $subgroup): array
    {
        return (new ParameterController)->get([
            'filters' => json_encode([
                'groupOp' => 'AND',
                'rules' => [
                    [
                        'field' => 'grp',
                        'data' => $group,
                    ],
                    [
                        'field' => 'subgrp',
                        'data' => $subgroup,
                    ],
                ],
            ]),
        ])['rows'];
    }
}

<?php

namespace App\Providers;

use App\Models\Menu;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
// use DB;
use Illuminate\Support\Facades\DB;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // ini_set('max_execution_time', 0);
        $categories = $this->get_data();
        View::share('sqlmenu', $categories);
    }

    public function get_data($induk = 0)
    {
        $data = array();
        $query = Menu::leftJoin('acos', 'menu.aco_id', '=', 'acos.id')->where('menu.menuparent', $induk)->orderby(DB::raw('right(menukode,1)'), 'ASC')->get(['menu.id', 'menu.menuname', 'menu.menuicon', 'acos.class', 'acos.method', 'menu.link', 'menu.menukode']);
        foreach ($query as $row) {
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
        }
        return $data;
    }
}

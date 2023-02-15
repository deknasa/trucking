<?php

namespace App\Providers;

use App\Libraries\Myauth;
use App\Models\Aco;
use App\Models\Menu;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

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
        View::composer('*', function ($view) {
            $uri = Route::current()->uri ?? null;
            $class = explode('/', $uri)[0];
            $method = Route::current() ? Route::current()->getActionMethod() : '';

            $currentMenu = DB::table('menu')
              ->select('menu.id', 'menu.menuparent')
              ->join('acos', 'menu.aco_id', 'acos.id')
              ->where('acos.class', $class)
              ->first();

            $view
                ->with('myAuth', new Myauth())
                ->with('currentMenu', $currentMenu)
                ->with('breadcrumb', $this->setBreadcrumb($class, $method));
        });
    }

    public function setBreadcrumb(string $class, string $method)
    {
        if (!request()->ajax()) {
            $breadcrumbs = [];

            $aco = Aco::where('class', $class)->first();

            if (isset($aco)) {
                $menu = Menu::where('aco_id', $aco->id)->first();

                if (isset($menu)) {
                    $breadcrumbs[] = isset($menu->aco_id) && $menu->aco_id == 0 ? $menu->menuname : '<a href="' . url()->to('/') . '/' . $menu->aco->class . '/' . $menu->aco->method . '">' . $menu->menuname . '</a>';

                    while (null !== $menu = Menu::find($menu->menuparent)) {
                        $breadcrumbs[] = isset($menu->aco_id) && $menu->aco_id == 0 ? $menu->menuname : '<a href="' . url()->to('/') . '/' . $menu->aco->class . '/' . $menu->aco->method . '">' . $menu->menuname . '</a>';
                    }

                    return join(' / ', array_reverse($breadcrumbs)) . ' / ' . $method;
                }
            } else {
                return 'Dashboard';
            }
        }
    }
}

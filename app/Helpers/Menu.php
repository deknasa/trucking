<?php

namespace App\Helpers;

use App\Http\Controllers\Controller;
use App\Models\Menu as ModelsMenu;
use Illuminate\Support\Facades\URL;

class Menu
{
  public function print_recursive_list($data)
  {
    $str = "";
    $current_menu = ModelsMenu::leftJoin('acos', 'menu.aco_id', '=', 'acos.id')
      ->where('acos.class', (new Controller)->class)
      ->first();
    // $current_menu = ModelsMenu::where('menuname', (new Controller)->class)->first();
    foreach ($data as $index => $list) {
      // sintaks untuk mengkondisikan, jika menuexe nya 0(tidak ada), maka dibuat tanda #, tetapi jika ada, maka mengarah ke base_url menuexe nya
      $menuexe = $list['menuexe'] == "0" ? "#" : $list['menuexe'];
      $subchild = Menu::print_recursive_list($list['child']);

      // (request()->is($list['child']) ? 'active' : '')
      if ($list['menuexe'] !== "/") {
        $str .= "<li class='nav-item'><a href='" . URL::to($menuexe) . "' id='" . $list['menukode'] . "' class='nav-link " . (request()->is($list['menuexe']) ? 'active' : '') . "' href='" . $menuexe . "'>
            <i class='" . $list['menuicon'] . " nav-icon'></i>
          <p>" . $list['menuno'] . "." . $list['menuname'] . "</p>
          </a> </li>";
      } else {

        // " . ($current_menu->menuparent == $list['menuid'] ? 'menu-is-opening menu-open' : '') . "
        // ($current_menu[$index]->class == (new Controller)->class ? 'true' : 'false') 
        $str .=
          "<li class='nav-item " . ($current_menu == null ? 0 : ($current_menu->menuparent == $list['menuid'] ? 'menu-is-opening menu-open' : '')) . "'>
          <a href='javascript:void(0)' class='nav-link' id='" . $list['menukode'] . "'>
            <i class='" . $list['menuicon'] . "  nav-icon'></i>
            <p>
            " . $list['menuno'] . ".
            " . $list['menuname'] . "
              <i class='right fas fa-angle-left'></i>
            </p>
          </a>
          <ul class='nav nav-treeview'>
              " . $subchild . "
          </ul>
        </li>";
      }
    }
    return $str;
  }

  public function setBreadcrumb()
  {
    $controller = new Controller;

    return $controller->breadcrumb;
  }
}

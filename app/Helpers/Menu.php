<?php

namespace App\Helpers;

use App\Http\Controllers\MyController;
use App\Models\Menu as ModelsMenu;
use Illuminate\Support\Facades\URL;

class Menu
{
  public function printRecursiveMenu($menus)
  {
    $string = '<ul class="dd-list">';

    foreach ($menus as $menu) {
      $string .= "
          <li class='dd-item " . ($menu['aco_id'] == 0 ? '' : 'dd-nochildren') . "' data-id='$menu[menuid]' data-name='$menu[menuname]'>
              <a href='" . URL::to($menu['menuexe']) . "'>
                <div class='dd-handle font-weight-normal " . ($menu['aco_id'] == 0 ? 'bg-secondary text-white' : '') . "'>
                <i class='$menu[menuicon]'></i> <span> $menu[menuno]. $menu[menuname] </span>
                </div>
              </a>
            " . (count($menu['child']) > 0 ? Menu::printRecursiveMenu($menu['child']) : '') . "
          </li>
      ";
    }

    $string .= '</ul>';

    return $string;
  }

  public function print_recursive_list($data)
  {
    $str = "";
    $current_menu = ModelsMenu::leftJoin('acos', 'menu.aco_id', '=', 'acos.id')
      ->where('acos.class', (new MyController)->class)
      ->first();
    // $current_menu = ModelsMenu::where('menuname', (new MyController)->class)->first();
    if (count($data) > 0) {
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
          // ($current_menu[$index]->class == (new MyController)->class ? 'true' : 'false') 
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
    }
    return $str;
  }

  public function setBreadcrumb()
  {
    $myController = new MyController;
    $myController->setClass();
    $myController->setMethod();
    $myController->setBreadcrumb($myController->class);

    return $myController->breadcrumb . ' / ' . $myController->method;
  }
}

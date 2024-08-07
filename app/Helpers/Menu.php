<?php

namespace App\Helpers;

use App\Http\Controllers\MyController;
use App\Models\Menu as ModelsMenu;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;

class Menu
{
  public function printRecursiveMenuForResequence($menus)
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
            " . (count($menu['child']) > 0 ? Menu::printRecursiveMenuForResequence($menu['child']) : '') . "
          </li>
      ";
    }

    $string .= '</ul>';
    // dd($string);
    return $string;
  }

  public function printRecursiveMenu(array $menus, bool $hasParent = false, $currentMenu)
  {
    $string = $hasParent ? '<ul class="ml-4 nav nav-treeview">' : '';

    foreach ($menus as $menu) {
      if ((count($menu['child']) > 0 || $menu['link'] != '' || $menu['aco_id'] != 0) && $this->hasClickableChild($menu)) {
        $string .= '
          <li class="nav-item">
            <a id="' . (strtolower($menu['menukode'])) . '" href="' . (count($menu['child']) > 0 ? 'javascript:void(0)' : ($menu['link'] != '' ? strtolower(url($menu['link'])) : strtolower(url($menu['menuexe'])))) . '" class="nav-link ' . (@$currentMenu->id == $menu['menuid'] ? 'active hover' : '') . '">
              <i class="nav-icon ' . (strtolower($menu['menuicon']) ?? 'far fa-circle') . '"></i>
              <p>
                ' . $menu['menuname'] . '
                ' . (count($menu['child']) > 0 ? '<i class="right fas fa-angle-left"></i>' : '') . '
              </p>
            </a>
            ' . (count($menu['child']) > 0 ? $this->printRecursiveMenu($menu['child'], true, $currentMenu) : '') . '
          </li>
        ';
      }
    }

    $string .= $hasParent ? '</ul>' : '';
    // dd($string);
    return $string;
  }

  public function hasClickableChild(array $menu): bool
  {
    $result = false;

    if (count($menu['child']) > 0) {
      foreach ($menu['child'] as $menuChild) {
        $clickable = $this->hasClickableChild($menuChild);

        if ($clickable) {
          return true;
        }
      }
    } else {
      return $this->isClickableChild($menu);
    }

    return $result;
  }

  public function isClickableChild(array $menu): bool
  {
    if ($menu['menuparent'] == 0) {
      return true;
    } else {
      return $menu['aco_id'] != 0 && $menu['menuexe'] != '/';
    }
  }

  public function print_recursive_list($data)
  {
    $str = "";
    $current_menu = ModelsMenu::leftJoin('acos', 'menu.aco_id', '=', 'acos.id')
      ->where('acos.class', (new Menu)->myController->class)
      ->first();
    if (count($data) > 0) {
      foreach ($data as $index => $list) {
        // sintaks untuk mengkondisikan, jika menuexe nya 0(tidak ada), maka dibuat tanda #, tetapi jika ada, maka mengarah ke base_url menuexe nya

        $menuexe = $list['menuexe'] == "0" ? "#" : $list['menuexe'];
        $subchild = Menu::print_recursive_list($list['child']);

        if ($list['menuexe'] !== "/") {
          $str .= "<li class='nav-item'><a href='" . URL::to($menuexe) . "' id='" . $list['menukode'] . "' class='nav-link " . (request()->is($list['menuexe']) ? 'active hover' : '') . "' href='" . $menuexe . "'>
            <i class='" . $list['menuicon'] . " nav-icon'></i>
          <p>" . $list['menuno'] . "." . $list['menuname'] . "</p>
          </a> </li>";
        } else {

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
}

<?php

namespace App\Helpers;

class Menu
{
    public function print_recursive_list($data)
    {
        $str = "";
        foreach ($data as $list) {

            // sintaks untuk men-selection menu dan child apa yang dibuka

            // sintaks untuk mengkondisikan, jika menuexe nya 0(tidak ada), maka dibuat tanda #, tetapi jika ada, maka mengarah ke base_url menuexe nya
            $menuexe = $list['menuexe'] == "0" ? "#" : $list['menuexe'];
            $subchild = Menu::print_recursive_list($list['child']);

            if ($list['menuexe'] !== "/") {
                $str .= "<li class='nav-item'><a href='/" . $menuexe . "' id='" . $list['menukode'] . "' class='nav-link' href='" . $menuexe . "'>
            <i class='" . $list['menuicon'] . " nav-icon'></i>
          <p>" . $list['menuno'] . "." . $list['menuname'] . "</p>
          </a> </li>";
            } else {

                $str .=
                    "<li class='nav-item'>
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
}

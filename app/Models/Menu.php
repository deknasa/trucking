<?php

namespace App\Models;

use App\Libraries\Myauth;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Menu extends Model
{
    use HasFactory;

    protected $table = 'menu';
    
    public function aco()
    {
        return $this->belongsTo(Aco::class);
    }

    
    public function getMenu($induk = 0)
    {
        $data = [];

        $menu = Menu::leftJoin('acos', 'menu.aco_id', '=', 'acos.id')
            ->where('menu.menuparent', $induk)
            ->orderby(DB::raw('right(menukode,1)'), 'ASC')
            ->get(['menu.id', 'menu.aco_id', 'menu.menuseq', 'menu.menuname', 'menu.menuicon', 'acos.class', 'acos.method', 'menu.link', 'menu.menukode', 'menu.menuparent']);

        foreach ($menu as $index => $row) {
            $hasPermission = (new Myauth())->hasPermission($row->class, $row->method);

            if ($hasPermission || $row->class == null) {
                $data[] = [
                    'menuid' => $row->id,
                    'aco_id' => $row->aco_id,
                    'menuname' => $row->menuname,
                    'menuicon' => $row->menuicon,
                    'link' => $row->link,
                    'menuno' => substr($row->menukode, -1),
                    'menukode' => $row->menukode,
                    'menuexe' => $row->class . "/" . $row->method,
                    'class' => $row->class,
                    'child' => $this->getMenu($row->id),
                    'menuparent' => $row->menuparent,
                ];
            }
        }

        return $data;
    }
}

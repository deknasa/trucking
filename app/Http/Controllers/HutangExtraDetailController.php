<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HutangExtraDetailController extends MyController
{
    public function jurnalGrid()
    {
        return view('jurnalumum._jurnal');
    }
    public function hutangGrid()
    {
        return view('hutangextraheader._hutang');
    }
    public function detailGrid()
    {
        return view('hutangextraheader._detail');
    }
}

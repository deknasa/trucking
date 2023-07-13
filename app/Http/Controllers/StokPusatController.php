<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StokPusatController extends MyController
{
    public $title = 'Stok Pusat';

    public function index(Request $request)
    {
        $title = $this->title;

        return view('stokpusat.index', compact('title'));
    }

}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StokController  extends MyController
{
    public $title = 'Stok';

    public function index(Request $request)
    {
        $title = $this->title;

        return view('stok.index', compact('title'));
    }
}

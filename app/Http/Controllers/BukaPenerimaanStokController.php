<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BukaPenerimaanStokController extends MyController
{
    public $title = 'Buka Peneriman Stok';
    
    public function index(Request $request)
    {
        $title = $this->title;
        return view('bukapenerimaanstok.index', compact('title'));
    }
}

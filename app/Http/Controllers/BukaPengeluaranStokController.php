<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BukaPengeluaranStokController extends MyController
{
    public $title = 'Buka Pengeluaran Stok';
    
    public function index(Request $request)
    {
        $title = $this->title;
        return view('bukapengeluaranstok.index', compact('title'));
    }
}

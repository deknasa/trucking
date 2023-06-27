<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LaporanKasHarianController extends Controller
{
    public $title = 'Laporan Kas Harian';

    public function index(Request $request)
    {
        $title = $this->title;
        $data = [
            'pagename' => 'Menu Utama Laporan Kas Harian',
        ];
     

        return view('laporankasharian.index', compact('title'));
    }
}

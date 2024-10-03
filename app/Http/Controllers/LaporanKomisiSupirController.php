<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LaporanKomisiSupirController extends MyController
{
    public $title = 'Laporan Komisi Supir';

    public function index(Request $request)
    {
        $title = $this->title;
        $data = [
            'pagename' => 'Menu Utama Laporan Komisi Supir',
        ];

        return view('laporankomisisupir.index', compact('title','data'));
    }

}

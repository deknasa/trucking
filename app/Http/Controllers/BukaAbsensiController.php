<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BukaAbsensiController extends MyController
{
    public $title = 'Buka Absensi';
    
    public function index(Request $request)
    {
        $title = $this->title;
        return view('bukaabsensi.index', compact('title'));
    }
}

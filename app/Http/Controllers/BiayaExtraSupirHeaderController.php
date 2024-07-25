<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BiayaExtraSupirHeaderController extends MyController
{
    public $title = 'Biaya Extra Supir';
   
    public function index(Request $request)
    {
        $title = $this->title;
        
        return view('biayaextrasupirheader.index', compact('title'));
    }
}

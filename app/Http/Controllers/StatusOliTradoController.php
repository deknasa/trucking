<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StatusOliTradoController extends Controller
{
    public $title = 'Status Oli Trado';

    public function index()
    {
        $title = $this->title;

        return view('statusolitrado.index',compact('title'));
    }

    public function export()
    {
        
    }
}

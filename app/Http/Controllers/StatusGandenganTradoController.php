<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StatusGandenganTradoController extends MyController
{
    public $title = 'Status Gandengan Trado';
    public function index(Request $request)
    {
        $title = $this->title;

        return view('statusgandengantrado.index', compact('title'));
    }

}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ExpSimController extends Controller
{
    public $title = 'Exp SIM';

    public function index()
    {
        $title = $this->title;

        return view('expsim.index',compact('title'));
    }
}

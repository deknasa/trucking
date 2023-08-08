<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ExpStnkController extends Controller
{
    public $title = 'Exp STNK';

    public function index()
    {
        $title = $this->title;

        return view('expstnk.index',compact('title'));
    }
}

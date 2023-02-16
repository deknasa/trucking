<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class MandorTripController extends MyController
{
    public $title = 'Mandor Trip';


    public function create()
    {

        $title = $this->title;
        

        return view('inputtrip.index', compact('title'));
    }
    public function history()
    {

        $title = $this->title;
        

        return view('historytrip.index', compact('title'));
    }
    public function list()
    {

        $title = $this->title;
        

        return view('listtrip.index', compact('title'));
    }
   
}

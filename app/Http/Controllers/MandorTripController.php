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
        

        return view('mandortrip.create', compact('title'));
    }
    public function show()
    {

        $title = $this->title;
        

        return view('mandortrip.history', compact('title'));
    }
}

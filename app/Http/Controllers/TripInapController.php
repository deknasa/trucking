<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TripInapController extends Controller
{
    public $title = 'Trip Inap';

    public function index(Request $request)
    {
        $title = $this->title;
       
        return view('tripinap.index', compact('title'));
    }
}

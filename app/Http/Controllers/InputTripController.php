<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class InputTripController extends Controller
{
    public $title = 'input Trip';

    /**
     * @ClassName
     */
    public function index()
    {
        $title = $this->title;
        

        return view('inputtrip.index', compact('title'));
    }
}

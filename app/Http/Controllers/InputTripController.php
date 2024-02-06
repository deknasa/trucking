<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class InputTripController extends MyController
{
    public $title = 'input Trip ( mandor )';

    /**
     * @ClassName
     */
    public function index()
    {
        $title = $this->title;
        

        return view('inputtrip.index', compact('title'));
    }
}

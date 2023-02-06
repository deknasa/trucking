<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ListTripController extends MyController
{
    public $title = 'List Trip';
     /**
     * @ClassName 
     */
    public function index()
    {
        $title = $this->title;
        

        return view('listtrip.index', compact('title'));
    }
}

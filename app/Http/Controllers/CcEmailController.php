<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CcEmailController extends Controller
{
    public $title = 'Cc Email';

    public function index(Request $request)
    {
        $title = $this->title;
       
        return view('ccemail.index', compact('title'));
    }
}
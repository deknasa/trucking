<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BccEmailController extends MyController
{
    public $title = 'Bcc Email';

    public function index(Request $request)
    {
        $title = $this->title;
       
        return view('bccemail.index', compact('title'));
    }
}

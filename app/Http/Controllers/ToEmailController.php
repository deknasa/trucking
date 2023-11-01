<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ToEmailController extends MyController
{
    public $title = 'To Email';

    public function index(Request $request)
    {
        $title = $this->title;
       
        return view('toemail.index', compact('title'));
    }
}

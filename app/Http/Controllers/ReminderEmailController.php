<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReminderEmailController extends Controller
{
    public $title = 'reminder email';

    public function index(Request $request)
    {
        $title = $this->title;
       
        return view('reminderemail.index', compact('title'));
    }
}

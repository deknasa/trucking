<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReminderEmailController extends MyController
{
    public $title = 'reminder email';

    public function index(Request $request)
    {
        $title = $this->title;
       
        return view('reminderemail.index', compact('title'));
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReminderSpkController extends Controller
{
    public $title = 'Reminder SPK';

    public function index()
    {
        $title = $this->title;

        return view('reminderspk.index',compact('title'));
    }
}

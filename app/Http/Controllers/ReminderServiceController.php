<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReminderServiceController extends Controller
{
    public $title = 'Reminder Service';

    public function index()
    {
        $title = $this->title;

        return view('reminderservice.index',compact('title'));
    }
}
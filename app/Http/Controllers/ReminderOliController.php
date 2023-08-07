<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReminderOliController extends Controller
{
    public $title = 'Reminder Pergantian Oli';

    public function index()
    {
        $title = $this->title;

        return view('reminderoli.index',compact('title'));
    }
}

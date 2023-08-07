<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReminderStokController extends Controller
{
    public $title = 'Reminder Stok Minimum';

    public function index()
    {
        $title = $this->title;

        return view('reminderstok.index',compact('title'));
    }

    public function export(){
        
    }
}

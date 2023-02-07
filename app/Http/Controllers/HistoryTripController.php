<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HistoryTripController extends MyController
{
    public $title = 'History Trip';
     /**
     * @ClassName 
     */
    public function index()
    {
        $title = $this->title;
        

        return view('historytrip.index', compact('title'));
    }
}

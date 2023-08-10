<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StatusGandenganTruckController extends MyController
{
    public $title = 'Status Gandengan Truck';

    public function index()
    {
        $title = $this->title;

        return view('statusgandengantruck.index',compact('title'));
    }
    
}

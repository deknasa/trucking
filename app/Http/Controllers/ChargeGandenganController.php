<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ChargeGandenganController extends MyController
{
    public $title = 'reminder charge gandengan';

    /**
     * Fungsi index
     * @ClassName index
     */
    public function index(Request $request)
    {
        $title = $this->title;
        
        return view('chargegandengan.index', compact('title'));
    }

    public function export()
    {
        # code...
    }
    public function report()
    {
        # code...
    }
}

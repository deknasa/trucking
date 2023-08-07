<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SpkHarianController extends Controller
{
    public $title = 'SPK Harian';

    public function index()
    {
        $title = $this->title;

        return view('spkharian.index',compact('title'));
    }
}

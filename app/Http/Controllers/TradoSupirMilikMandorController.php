<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class TradoSupirMilikMandorController extends MyController
{
    public $title = 'Trado Supir Milik Mandor';

    public function index(Request $request)
    {
        $title = $this->title;
       
        return view('tradosupirmilikmandor.index', compact('title'));
    }
}

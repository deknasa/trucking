<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class BlackListSupirController extends MyController
{
    public $title = 'Black List Supir';

    public function index(Request $request)
    {
        $title = $this->title;
       
        return view('blacklistsupir.index', compact('title'));
    }
}

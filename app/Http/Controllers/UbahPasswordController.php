<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UbahPasswordController extends Controller
{
    public $title = 'Ubah Password';

    public function index()
    {
        $title = $this->title;
        

        return view('ubahpassword.index', compact('title'));
    }
}

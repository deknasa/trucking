<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class StokPersediaanController extends MyController
{
    public $title = 'Stok Persediaan';
    
    public function index(Request $request)
    {
        $title = $this->title;
        return view('stokpersediaan.index', compact('title'));
    }

    
}
?>
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ExpAsuransiController extends Controller
{
    public $title = 'Exp Asuransi';

    public function index()
    {
        $title = $this->title;

        return view('expasuransi.index',compact('title'));
    }
}

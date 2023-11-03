<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ImportDataCabangController extends Controller
{
    public $title = 'Hutang Detail';

    public function index(Request $request)
    {
        $title = $this->title;
        return view('importdatacabang.index',compact('title'));
    }
}

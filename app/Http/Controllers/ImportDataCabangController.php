<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ImportDataCabangController extends MyController
{
    public $title = 'Import Data Cabang';

    public function index(Request $request)
    {
        $title = $this->title;
        return view('importdatacabang.index',compact('title'));
    }
}

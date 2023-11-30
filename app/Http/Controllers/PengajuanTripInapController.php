<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PengajuanTripInapController extends Controller
{
    public $title = 'Pengajuan Trip Inap';

    public function index(Request $request)
    {
        $title = $this->title;

        return view('pengajuantripinap.index', compact('title'));
    }
}

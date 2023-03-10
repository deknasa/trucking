<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SuratPengantarApprovalInputTripController extends MyController
{
    public $title = 'Surat Pengantar Approval Input Trip';
    
    public function index(Request $request)
    {
        $title = $this->title;
        return view('suratpengantarapprovalinputtrip.index', compact('title'));
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class SuratPengantarApprovalInputTripController extends MyController
{
    public $title = 'Surat Pengantar Approval Input Trip';
    
    public function index(Request $request)
    {
        $title = $this->title;
        $data = [
            'comboapproval' => $this->comboapproval('list', 'STATUS APPROVAL', 'STATUS APPROVAL'),
        ];
        return view('suratpengantarapprovalinputtrip.index', compact('title','data'));
    }

    public function comboapproval($aksi, $grp, $subgrp)
    {
        $status = [
            'status' => $aksi,
            'grp' => $grp,
            'subgrp' => $subgrp,
        ];

        $response = Http::withHeaders($this->httpHeaders)
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'invoiceheader/comboapproval', $status);

        return $response['data'];
    }
}

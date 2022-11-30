<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class ApprovalTransaksiKasBankHeader  extends MyController
{
    public $title = 'Approval Transaksi Kas Bank';
    
    public function index(Request $request)
    {
        $title = $this->title;
        $data = [            
            'comboapproval' => $this->comboApproval('list')
        ];
        return view('approvaltransaksi.index', compact('title','data'));
    }

    public function comboApproval($aksi)
    {

        $status = [
            'status' => $aksi,
            'grp' => 'STATUS APPROVAL',
            'subgrp' => 'STATUS APPROVAL',
        ];

        $response = Http::withHeaders($this->httpHeaders)
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'hutangbayarheader/comboapproval', $status);

        return $response['data'];
    }
}

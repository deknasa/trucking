<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class ApprovalNotaHeaderController extends MyController
{
    public $title = 'Approval Nota';
    
    public function index(Request $request)
    {
        $title = $this->title;
        $data = [            
            'comboapproval' => $this->comboApproval('list')
        ];
        return view('approvalnota.index', compact('title','data'));
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
?>
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ExpSimController extends MyController
{
    public $title = 'Exp SIM';

    public function index()
    {
        $title = $this->title;
        $data = [
            'combo' => $this->combo('list')
        ];

        return view('expsim.index',compact('title','data'));
    }
    
    public function combo($aksi)
    {

        $status = [
            'status' => $aksi,
            'grp' => 'STATUS EXPIRED',
            'subgrp' => 'STATUS EXPIRED',
        ];

        $response = Http::withHeaders($this->httpHeaders)
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'cabang/combostatus', $status);

        return $response['data'];
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class InvoiceLunasKePusatController extends MyController
{
    public $title = 'Invoice Lunas Ke Pusat';
    
    public function index()
    {

        $title = $this->title;
        $data = [
            'combo' => $this->combo('list'),
        ];

        return view('invoicelunaskepusat.index', compact('title','data'));
    }
    public function combo($aksi)
    {

        $status = [
            'status' => $aksi,
            'grp' => 'STATUS AKTIF',
            'subgrp' => 'STATUS AKTIF',
        ];

        $response = Http::withHeaders($this->httpHeaders)->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'user/combostatus', $status);

        return $response['data'];
    }
       
}
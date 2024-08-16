<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class MandorAbsensiSupirHistoryController extends MyController
{
    public $title = 'Absensi Supir ( Mandor )  History ';
    
    public function index()
    {

        $title = $this->title;
        $data = [
            'combo' => $this->combo('list'),
        ];

        return view('mandorabsensisupir.index_jqgrid', compact('title','data'));
    }
    public function combo($aksi)
    {

        $status = [
            'status' => $aksi,
            'grp' => 'TIDAK ADA TRIP',
            'subgrp' => 'TIDAK ADA TRIP',
        ];

        $response = Http::withHeaders($this->httpHeaders)->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'user/combostatus', $status);

        return $response['data'];
    }
       
}

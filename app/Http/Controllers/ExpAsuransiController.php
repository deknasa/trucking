<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ExpAsuransiController extends MyController
{
    public $title = 'Exp Asuransi';

    public function index()
    {
        $title = $this->title;
        $data = [
            'combo' => $this->combo('list')
        ];

        return view('expasuransi.index',compact('title', 'data'));
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

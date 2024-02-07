<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class BccEmailController extends MyController
{
    public $title = 'Bcc Email';

    public function index(Request $request)
    {
        $title = $this->title;
       
        $data = [
            'comboaktif' => $this->comboList('list','STATUS AKTIF','STATUS AKTIF'),
        ];       
        return view('bccemail.index', compact('title','data'));
    }
    public function comboList($aksi, $grp, $subgrp)
    {

        $status = [
            'status' => $aksi,
            'grp' => $grp,
            'subgrp' => $subgrp,
        ];

        $response = Http::withHeaders($this->httpHeaders)
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'parameter/combolist', $status);

        return $response['data'];
    }
}

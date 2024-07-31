<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class BiayaExtraSupirHeaderController extends MyController
{
    public $title = 'Biaya Extra Supir';

    public function index(Request $request)
    {
        $title = $this->title;

        $data = [
            'combogajisupir' => $this->comboList('list', 'STATUS SUDAH BUKA', 'STATUS SUDAH BUKA'),
        ];

        return view('biayaextrasupirheader.index', compact('title','data'));
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

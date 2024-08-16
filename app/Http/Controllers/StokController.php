<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class StokController  extends MyController
{
    public $title = 'Stok';

    public function index(Request $request)
    {
        $title = $this->title;
        $data = [
            'combo' => $this->comboList('list', 'STATUS AKTIF','STATUS AKTIF'),
            'comboservice' => $this->comboList('list', 'STATUS SERVICE RUTIN', 'STATUS SERVICE RUTIN'),
            'combotanpaclaim' => $this->comboList('list', 'STATUS APPROVAL', 'STATUS APPROVAL'),
            'comboreuse' => $this->comboList('list', 'STATUS REUSE', 'STATUS REUSE'),
            'listbtn' => $this->getListBtn()
        ];
        return view('stok.index', compact('title','data'));
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

    public function report(Request $request)
    {
        // dd($request->all());
        $response = Http::withHeaders($this->httpHeaders)
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'stok', $request->all());

        $stoks = $response['data'];


        $i = 0;
        foreach ($stoks as $index => $params) {

            $statusaktif = $params['statusaktif'];

            $result = json_decode($statusaktif, true);

            $statusaktif = $result['MEMO'];

            $stoks[$i]['statusaktif'] = $statusaktif;

        
            $i++;


        }

        return view('reports.stok', compact('stoks'));
    }
}

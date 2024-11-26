<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class PenjualController extends MyController
{
    public $title = 'Penjual';

    public function index(Request $request){
        
        $title = $this->title;
        $data = [
            'comboaktif' => $this->comboList('list', 'STATUS AKTIF', 'STATUS AKTIF'),
            'listbtn' => $this->getListBtn()
        ];

        return view('penjual.index', compact('title', 'data'));
    }

    public function comboList($aksi, $grp, $subgrp){
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

    public function report(Request $request){
        $response = Http::withHeaders($this->httpHeaders)
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'penjual', $request->all());

        $penjual = $response['data'];
        // dd($request, $response, $penjuals);

        $i = 0;
        foreach ($penjual as $index => $params) {
            $statusaktif = $params['statusaktif'];

            $result = json_decode($statusaktif, true);

            $statusaktif = $result['MEMO'];

            $suppliers[$i]['statusaktif'] = $statusaktif;
            $i++;
        }
        // dd($penjuals);

        return view('reports.penjual', compact('penjual'));
    }
}

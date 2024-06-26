<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class TripTangkiController extends MyController
{
    public $title = 'Trip Tangki';

    public function index(Request $request)
    {
        $title = $this->title;

        $data = [
            'combo' => $this->combo('list'),
            'listbtn' => $this->getListBtn()
        ];

        return view('triptangki.index', compact('title', 'data'));
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

    
    public function report(Request $request)
    {
        $response = Http::withHeaders($this->httpHeaders)
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'triptangki', $request->all());

        $triptangkis = $response['data'];

        $i = 0;
        foreach ($triptangkis as $index => $params) {

            $statusaktif = $params['statusaktif'];

            $result = json_decode($statusaktif, true);

            $statusaktif = $result['MEMO'];

            $triptangkis[$i]['statusaktif'] = $statusaktif;

        
            $i++;


        }

        return view('reports.triptangki', compact('triptangkis'));
    }
}

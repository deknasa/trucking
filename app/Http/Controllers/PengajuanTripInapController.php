<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class PengajuanTripInapController extends MyController
{
    public $title = 'Pengajuan Trip Inap';

    public function index(Request $request)
    {
        $title = $this->title;
        $data = [
            'comboapproval' => $this->comboList('list', 'STATUS APPROVAL', 'STATUS APPROVAL'),
            'combobatas' => $this->comboList('list', 'STATUS APPROVAL', 'STATUS APPROVAL'),
        ];
        return view('pengajuantripinap.index', compact('title','data'));
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
        $response = Http::withHeaders($this->httpHeaders)
        ->withOptions(['verify' => false])
        ->withToken(session('access_token'))
        ->get(config('app.api_url') . 'pengajuantripinap', $request->all());

        $tripinap = $response['data'];
        
        $i = 0;
        foreach ($tripinap as $index => $params) {

            $statusapproval = $params['statusapproval'];

            $result = json_decode($statusapproval, true);

            $statusapproval = $result['MEMO'];


            $tripinap[$i]['statusapproval'] = $statusapproval;

        
            $i++;


        }


        return view('reports.pengajuantripinap', compact('tripinap'));
    }

}

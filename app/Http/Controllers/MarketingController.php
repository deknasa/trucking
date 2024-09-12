<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class MarketingController extends MyController
{
    public $title = 'MARKETING';

    /**
     * @ClassName
     */
    public function index(Request $request)
    {
        $title = $this->title;

        $data = [
            'combo' => $this->comboStatusAktif('list'),
            'listbtn' => $this->getListBtn()
        ];

        return view('marketing.index', compact('title','data'));
    }
    public function comboStatusAktif($aksi)
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
            ->get(config('app.api_url') . 'marketing', $request->all());

        $marketings = $response['data'];



        $i = 0;
        foreach ($marketings as $index => $params) {

            $statusaktif = $params['statusaktif_memo'];

            $result = json_decode($statusaktif, true);

            $statusaktif = $result['MEMO'];

            $marketings[$i]['statusaktif'] = $statusaktif;

        
            $i++;


        }

        return view('reports.merketing', compact('marketings'));
    }

}

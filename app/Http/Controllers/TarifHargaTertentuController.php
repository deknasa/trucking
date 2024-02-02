<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class TarifHargaTertentuController extends MyController
{
   
    public $title = 'Tarif Harga Tertentu';


    /**
     * Fungsi index
     * @ClassName index
     */
    public function index(Request $request)
    {
        $title = $this->title;
        
     

        $data = [
            'statusaktif' => $this->comboStatusAktif('list','STATUS AKTIF','STATUS AKTIF'),
            'statuscabang' => $this->comboStatusAktif('list','STATUS CABANG','STATUS CABANG'),
        ];


        return view('tarifhargatertentu.index', compact('title', 'data'));
    }
    private function combo($aksi)
    {

        $status = [
            'status' => $aksi,
        ];

        // dd($status);
        $response = Http::withHeaders($this->httpHeaders)->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'tarifhargatertentu/combo', $status);


     
            // dd($response['data']);
        return $response['data'];
    }

    
    public function comboStatusAktif($aksi,$grp,$subgrp)
    {

        $status = [
            'status' => $aksi,
            'grp' => $grp,
            'subgrp' => $subgrp,
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
            ->get(config('app.api_url') . 'tarifhargatertentu', $request->all());

        $tarifhargatertentus = $response['data'];

        $i = 0;
        foreach ($tarifhargatertentus as $index => $params) {

            $statusaktif = $params['statusaktif'];
            $statuscabang = $params['statuscabang'];

            $result = json_decode($statusaktif, true);
            $resultcabang = json_decode($statuscabang, true);

            $statusaktif = $result['MEMO'];
            $statuscabang = $resultcabang['MEMO'];

            $tarifhargatertentus[$i]['statusaktif'] = $statusaktif;
            $tarifhargatertentus[$i]['statuscabang'] = $statuscabang;

        
            $i++;


        }

        return view('reports.tarifhargatertentu', compact('tarifhargatertentus'));
    }

    
}

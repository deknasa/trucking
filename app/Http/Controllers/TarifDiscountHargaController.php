<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;

use Illuminate\Contracts\View\View;
use Illuminate\Http\Response;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class TarifDiscountHargaController extends MyController
{
    public $title = 'Tarif Discount Harga';


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


        return view('tarifdiscountharga.index', compact('title', 'data'));
    }
    private function combo($aksi)
    {

        $status = [
            'status' => $aksi,
        ];

        // dd($status);
        $response = Http::withHeaders($this->httpHeaders)->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'tarifdiscountharga/combo', $status);


     
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
            ->get(config('app.api_url') . 'tarifdiscountharga', $request->all());

        $tarifdiscounthargas = $response['data'];

        $i = 0;
        foreach ($tarifdiscounthargas as $index => $params) {

            $statusaktif = $params['statusaktif'];
            $statuscabang = $params['statuscabang'];

            $result = json_decode($statusaktif, true);
            $resultcabang = json_decode($statuscabang, true);

            $statusaktif = $result['MEMO'];
            $statuscabang = $resultcabang['MEMO'];

            $tarifdiscounthargas[$i]['statusaktif'] = $statusaktif;
            $tarifdiscounthargas[$i]['statuscabang'] = $statuscabang;

        
            $i++;


        }

        return view('reports.tarifdiscountharga', compact('tarifdiscounthargas'));
    }

    
}

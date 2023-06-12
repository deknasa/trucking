<?php 

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Response;

class DataRitasiController extends MyController
{
    public $title = 'DataRitasi';

     /**
     * Fungsi index
     * @ClassName index
     */
    public function index(Request $request)
    {
        $title = $this->title;
        $data = [
            'pagename' => 'Menu Utama Data Ritasi',
            'combo' => $this->combo('list')
        ];

        return view('dataritasi.index', compact('title', 'data'));
    }

    public function get($params = []): array
    {
        $params = [
            'offset' => $params['offset'] ?? request()->offset ?? ((request()->page - 1) * request()->rows),
            'limit' => $params['rows'] ?? request()->rows ?? 0,
            'sortIndex' => $params['sidx'] ?? request()->sidx,
            'sortOrder' => $params['sord'] ?? request()->sord,
            'search' => json_decode($params['filters'] ?? request()->filters, 1) ?? [],
        ];
        $response = Http::withHeaders(request()->header())
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'dataritasi', $params);

        $data = [
            'total' => $response['attributes']['totalPages'] ?? [],
            'records' => $response['attributes']['totalRows'] ?? [],
            'rows' => $response['data'] ?? []
        ];

        return $data;
    }

    /**
     * Fungsi create
     * @ClassName create
     */

     public function fieldLength(): Response
     {
         $response = Http::withHeaders($this->httpHeaders)
             ->withToken(session('access_token'))
             ->get(config('app.api_url') . 'dataritasi/field_length');
 
         return response($response['data']);
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
            ->get(config('app.api_url') . 'dataritasi', $request->all());

        $dataritasi = $response['data'];

        $i = 0;
        foreach ($dataritasi as $index => $params) {

            $statusaktif = $params['statusaktif'];

            $result = json_decode($statusaktif, true);

            $statusaktif = $result['MEMO'];

            $dataritasi[$i]['statusaktif'] = $statusaktif;

        
            $i++;


        }

        return view('reports.dataritasi', compact('dataritasi'));
    }

}



?>
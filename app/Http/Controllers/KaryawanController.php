<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class KaryawanController extends MyController
{
    public $title = 'Karyawan';

    public $httpHeaders = [
        'Accept' => 'application/json',
        'Content-Type' => 'application/json',
    ];

    public function index(Request $request)
    {
      
        $title = $this->title;
        $data = [
            'comboaktif' => $this->comboList('list','STATUS AKTIF','STATUS AKTIF'),
            'combostaff' => $this->comboList('list','STATUS STAFF','STATUS STAFF'),
        ];
        return view('karyawan.index', compact('title','data'));
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

    public function get($params = [])
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
            ->get(config('app.api_url') . 'suratpengantar', $params);

        $data = [
            'total' => $response['attributes']['totalPages'] ?? [],
            'records' => $response['attributes']['totalRows'] ?? [],
            'rows' => $response['data'] ?? [],
            'params' => $params ?? [],
            'message' => $response['message'] ?? ''
        ];

        if (request()->ajax()) {
            return response($data, $response->status());
        }
        
        return $data;
    }
    private function combo()
    {
        $response = Http::withHeaders($this->httpHeaders)->withOptions(['verify' => false])
            ->get(config('app.api_url') . 'suratpengantar/combo');
        
        return $response['data'];
    }
    public function export(Request $request)
    {
       
        $params = [
            'offset' => $request->dari - 1,
            'rows' => $request->sampai - $request->dari + 1,
        ];

        $parameters = $this->get($params)['rows'];

        $columns = [
            [
                'label' => 'No',
            ],
            [
                'label' => 'ID',
                'index' => 'id',
            ],
            [
                'label' => 'Group',
                'index' => 'grp',
            ],
            [
                'label' => 'Subgroup',
                'index' => 'subgrp',
            ],
            [
                'label' => 'Text',
                'index' => 'text',
            ],
            [
                'label' => 'Memo',
                'index' => 'memo',
            ],
        ];

        $this->toExcel($this->title, $parameters, $columns);
    }
    public function report(Request $request)
    {
        $response = Http::withHeaders($this->httpHeaders)
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'karyawan', $request->all());

        $karyawans = $response['data'];


        return view('reports.karyawan', compact('karyawans'));
    }
}

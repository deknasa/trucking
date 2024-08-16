<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;

use Illuminate\Contracts\View\View;
use Illuminate\Http\Response;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class QtyTambahGantiOliController extends MyController
{
    public $title = 'QtyTambahGantiOli';


    /**
     * Fungsi index
     * @ClassName index
     */
    public function index(Request $request)
    {
        $title = $this->title;
        
        $data = [
            'combo' => $this->combo('list'),
            'combooli' => $this->combooli('list'),
            'comboservicerutin' => $this->comboservicerutin('list'),
        ];

        return view('qtytambahgantioli.index', compact('title', 'data'));
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
            ->get(config('app.api_url') . 'qtytambahgantioli', $params);

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
    public function create()
    {
        $title = $this->title;

        $data['combo'] = $this->combo('entry');
        $data['combooli'] = $this->combooli('entry');
        $data['comboservicerutin'] = $this->comboservicerutin('entry');

        return view('qtytambahgantioli.add', compact('title', 'data'));
    }

    public function store(Request $request)
    {
        $request['modifiedby'] = Auth::user()->name;
        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ])
            ->withToken(session('access_token'))
            ->post(config('app.api_url') . 'qtytambahgantioli', $request->all());

        return response($response);
    }

    /**
     * Fungsi edit
     * @ClassName edit
     */
    public function edit($id)
    {
        $title = $this->title;
        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Content-Type' => 'application/json'
        ])->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . "qtytambahgantioli/$id");

        $qtytambahgantioli = $response['data'];

        $data['combo'] = $this->combo('entry');
        $data['combooli'] = $this->combooli('entry');

        return view('qtytambahgantioli.edit', compact('title', 'qtytambahgantioli', 'data'));
    }

    public function update(Request $request, $id)
    {
        $request['modifiedby'] = Auth::user()->name;

        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ])
            ->withToken(session('access_token'))
            ->patch(config('app.api_url') . "qtytambahgantioli/$id", $request->all());

        return response($response);
    }


    /**
     * Fungsi delete
     * @ClassName delete
     */
    public function delete($id)
    {
        try {
            $title = $this->title;

            $response = Http::withHeaders([
                'Accept' => 'application/json',
                'Content-Type' => 'application/json'
            ])->withOptions(['verify' => false])
                ->withToken(session('access_token'))
                ->get(config('app.api_url') . "qtytambahgantioli/$id");

            $qtytambahgantioli = $response['data'];

            $data['combo'] = $this->combo('entry');
            $data['combooli'] = $this->combooli('entry');
            $data['comboservicerutin'] = $this->comboservicerutin('entry');

            return view('qtytambahgantioli.delete', compact('title', 'qtytambahgantioli', 'data'));
        } catch (\Throwable $th) {
            return redirect()->route('qtytambahgantioli.index');
        }
    }

    public function destroy($id, Request $request)
    {
        $request['modifiedby'] = Auth::user()->name;

        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Content-Type' => 'application/json'
        ])
            ->withToken(session('access_token'))
            ->delete(config('app.api_url') . "qtytambahgantioli/$id", $request->all());

        return response($response);
    }

    public function fieldLength()
    {
        $response = Http::withHeaders($this->httpHeader)
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'qtytambahgantioli/field_length');

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

    public function combooli($aksi)
    {

        $status = [
            'status' => $aksi,
            'grp' => 'STATUS OLI',
            'subgrp' => 'STATUS OLI',
        ];

        $response = Http::withHeaders($this->httpHeaders)->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'user/combostatus', $status);

        return $response['data'];
    }

    public function comboservicerutin($aksi)
    {

        $status = [
            'status' => $aksi,
            'grp' => 'STATUS SERVICE RUTIN',
            'subgrp' => 'STATUS SERVICE RUTIN',
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
            ->get(config('app.api_url') . 'qtytambahgantioli', $request->all());

        $qtytambahgantiolis = $response['data'];

        $i = 0;
        foreach ($qtytambahgantiolis as $index => $params) {

            $statusaktif = $params['statusaktif'];
            $result = json_decode($statusaktif, true);
            $statusaktif = $result['MEMO'];
            $qtytambahgantiolis[$i]['statusaktif'] = $statusaktif;
        
            $statusoli = $params['statusoli'];
            $result = json_decode($statusoli, true);
            $statusoli = $result['MEMO'];
            $qtytambahgantiolis[$i]['statusoli'] = $statusoli;

            $statusservicerutin = $params['statusservicerutin'];
            $result = json_decode($statusservicerutin, true);
            $statusservicerutin = $result['MEMO'];
            $qtytambahgantiservicerutins[$i]['statusservicerutin'] = $statusservicerutin;

            $i++;


        }

        return view('reports.qtytambahgantioli', compact('qtytambahgantiolis'));
    }

    
}

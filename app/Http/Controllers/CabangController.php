<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;

class CabangController extends MyController
{
    public $title = 'Cabang';

    /**
     * Fungsi index
     * @ClassName index
     */
    public function index(Request $request)
    {
        $title = $this->title;
        $data = [
            'pagename' => 'Menu Utama Cabang',
            'combo' => $this->combo('list','STATUS AKTIF','STATUS AKTIF'),
            'koneksi' => $this->combo('list','STATUS KONEKSI','STATUS KONEKSI'),
            'listbtn' => $this->getListBtn()
        ];

        return view('cabang.index', compact('title', 'data'));
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
            ->get(config('app.api_url') . 'cabang', $params);

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

        return view('cabang.add', compact('title', 'data'));
    }

    public function store(Request $request)
    {
        $request['modifiedby'] = Auth::user()->name;
        $response = Http::withHeaders($this->httpHeaders)
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->post(config('app.api_url') . 'cabang', $request->all());

        return response($response);
    }

    /**
     * Fungsi edit
     * @ClassName edit
     */
    public function edit($id)
    {
        $title = $this->title;
        $response = Http::withHeaders($this->httpHeaders)
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . "cabang/$id");

        $cabang = $response['data'];

        $data['combo'] = $this->combo('entry');

        return view('cabang.edit', compact('title', 'cabang', 'data'));
    }

    public function update(Request $request, $id)
    {
        $request['modifiedby'] = Auth::user()->name;

        $response = Http::withHeaders($this->httpHeaders)
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->patch(config('app.api_url') . "cabang/$id", $request->all());

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

            $response = Http::withHeaders($this->httpHeaders)
                ->withOptions(['verify' => false])
                ->withToken(session('access_token'))
                ->get(config('app.api_url') . "cabang/$id");

            $cabang = $response['data'];

            $data['combo'] = $this->combo('entry');

            return view('cabang.delete', compact('title', 'cabang', 'data'));
        } catch (\Throwable $th) {
            return redirect()->route('cabang.index');
        }
    }

    public function destroy($id, Request $request)
    {
        $request['modifiedby'] = Auth::user()->name;

        $response = Http::withHeaders($this->httpHeaders)
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->delete(config('app.api_url') . "cabang/$id", $request->all());

        return response($response);
    }

    /**
     * @ClassName
     */
    public function report(Request $request)
    {
        $response = Http::withHeaders($this->httpHeaders)
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'cabang', $request->all());

        $cabangs = $response['data'];

        $i = 0;
        foreach ($cabangs as $index => $params) {

            $statusaktif = $params['statusaktif'];

            $result = json_decode($statusaktif, true);

            $statusaktif = $result['MEMO'];


            $cabangs[$i]['statusaktif'] = $statusaktif;

        
            $i++;


        }


        return view('reports.cabang', compact('cabangs'));
    }

    /**
     * @ClassName
     */
    public function export(Request $request)
    {
        $params = [
            'offset' => $request->dari - 1,
            'rows' => $request->sampai - $request->dari + 1,
        ];

        $cabangs = $this->get($params)['rows'];

        $columns = [
            [
                'label' => 'No',
            ],
            [
                'label' => 'ID',
                'index' => 'id',
            ],
            [
                'label' => 'Kode Cabang',
                'index' => 'kodecabang',
            ],
            [
                'label' => 'Nama Cabang',
                'index' => 'namacabang',
            ],
            [
                'label' => 'Status Aktif',
                'index' => 'statusaktif',
            ],
        ];

        $this->toExcel($this->title, $cabangs, $columns);
    }

    public function fieldLength()
    {
        $response = Http::withHeaders($this->httpHeaders)
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'cabang/field_length');

        return response($response['data']);
    }


    public function combo($aksi, $grp, $subgrp)
    {

        $status = [
            'status' => $aksi,
            'grp' => $grp,
            'subgrp' => $subgrp,
        ];

        $response = Http::withHeaders($this->httpHeaders)
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'cabang/combostatus', $status);

        return $response['data'];
    }
}

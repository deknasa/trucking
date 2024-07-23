<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;

class GandenganController extends MyController
{
    public $title = 'Gandengan';

    /**
     * Fungsi index
     * @ClassName index
     */
    public function index(Request $request)
    {
        $title = $this->title;
        $data = [
            'pagename' => 'Menu Utama Gandengan',
            'combo' => $this->combo('list'),
            'listbtn' => $this->getListBtn(),
        ];

        return view('gandengan.index', compact('title', 'data'));
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
            ->get(config('app.api_url') . 'gandengan', $params);

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

        return view('gandengan.add', compact('title', 'data'));
    }

    public function store(Request $request)
    {
        $request['modifiedby'] = Auth::user()->name;
        $response = Http::withHeaders($this->httpHeaders)
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->post(config('app.api_url') . 'gandengan', $request->all());

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
            ->get(config('app.api_url') . "gandengan/$id");

        $gandengan = $response['data'];

        $data['combo'] = $this->combo('entry');

        return view('gandengan.edit', compact('title', 'gandengan', 'data'));
    }

    public function update(Request $request, $id)
    {
        $request['modifiedby'] = Auth::user()->name;

        $response = Http::withHeaders($this->httpHeaders)
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->patch(config('app.api_url') . "gandengan/$id", $request->all());

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
                ->get(config('app.api_url') . "gandengan/$id");

            $gandengan = $response['data'];

            $data['combo'] = $this->combo('entry');

            return view('gandengan.delete', compact('title', 'gandengan', 'data'));
        } catch (\Throwable $th) {
            return redirect()->route('gandengan.index');
        }
    }

    public function destroy($id, Request $request)
    {
        $request['modifiedby'] = Auth::user()->name;

        $response = Http::withHeaders($this->httpHeaders)
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->delete(config('app.api_url') . "gandengan/$id", $request->all());

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
            ->get(config('app.api_url') . 'gandengan', $request->all());

        $gandengans = $response['data'];


        $i = 0;
        foreach ($gandengans as $index => $params) {

            $statusaktif = $params['statusaktif'];

            $result = json_decode($statusaktif, true);

            $statusaktif = $result['MEMO'];

            $gandengans[$i]['statusaktif'] = $statusaktif;
        
            $i++;


        }

        // dd($gandengans);

        return view('reports.gandengan', compact('gandengans'));
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

        $gandengans = $this->get($params)['rows'];

        $columns = [
            [
                'label' => 'No',
            ],
            [
                'label' => 'ID',
                'index' => 'id',
            ],
            [
                'label' => 'GANDENGAN',
                'index' => 'kodegandengan',
            ],
            [
                'label' => 'NO POLISI',
                'index' => 'trado',
            ],
            [
                'label' => 'KETERANGAN',
                'index' => 'keterangan',
            ],
            [
                'label' => 'Status Aktif',
                'index' => 'statusaktif',
            ],
        ];

        $this->toExcel($this->title, $gandengans, $columns);
    }

    public function fieldLength()
    {
        $response = Http::withHeaders($this->httpHeaders)
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'gandengan/field_length');
        return response($response['data']);
    }


    public function combo($aksi)
    {
        $status = [
            'status' => $aksi,
            'grp' => 'STATUS AKTIF',
            'subgrp' => 'STATUS AKTIF',
        ];

        $response = Http::withHeaders($this->httpHeaders)
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'gandengan/combostatus', $status);

        return $response['data'];
    }
}

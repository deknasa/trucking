<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class PenerimaanTruckingController extends MyController
{

    public $title = 'Penerimaan Trucking';

    public function index(Request $request)
    {
        $title = $this->title;
        $data = [
            'combo' => $this->comboStatusAktif('list'),
            'listbtn' => $this->getListBtn()
        ];


        return view('penerimaantrucking.index', compact('title','data'));
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

    public function create()
    {
        $title = $this->title;

        return view('penerimaantrucking.add', compact('title'));
    }

    public function edit($id)
    {
        $title = $this->title;

        $response = Http::withHeaders($this->httpHeaders)
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . "penerimaantrucking/$id");

        $penerimaanTrucking = $response['data'];

        return view('penerimaantrucking.edit', compact('title', 'penerimaanTrucking'));
    }

    public function delete($id)
    {
        try {
            $title = $this->title;

            $response = Http::withHeaders($this->httpHeaders)
                ->withOptions(['verify' => false])
                ->withToken(session('access_token'))
                ->get(config('app.api_url') . "penerimaantrucking/$id");

            $penerimaanTrucking = $response['data'];

            return view('penerimaantrucking.delete', compact('title', 'penerimaanTrucking'));
        } catch (\Throwable $th) {
            return redirect()->route('penerimaantrucking.index');
        }
    }

    public function report(Request $request)
    {
        $response = Http::withHeaders($this->httpHeaders)
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'penerimaantrucking', $request->all());
        $penerimaanTruckings = $response['data'];
        $i = 0;
        foreach ($penerimaanTruckings as $index => $params) {
            $statusaktif = $params['format'];
            $result = json_decode($statusaktif, true);
            $statusaktif = $result['SINGKATAN'];
            $penerimaanTruckings[$i]['format'] = $statusaktif;
            $i++;
        }
        return view('reports.penerimaantrucking', compact('penerimaanTruckings'));
    }
}

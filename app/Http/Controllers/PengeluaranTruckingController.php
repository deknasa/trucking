<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class PengeluaranTruckingController extends MyController
{
    public $title = 'Pengeluaran Trucking';

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


        return view('pengeluarantrucking.index', compact('title', 'data'));
    }

    /**
     * @ClassName
     */
    public function create()
    {
        $title = $this->title;

        return view('pengeluarantrucking.add', compact('title'));
    }

    /**
     * @ClassName
     */
    public function edit($id)
    {
        $title = $this->title;

        $response = Http::withHeaders($this->httpHeaders)
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . "pengeluarantrucking/$id");

        $pengeluaranTrucking = $response['data'];

        return view('pengeluarantrucking.edit', compact('title', 'pengeluaranTrucking'));
    }

    /**
     * @ClassName
     */
    public function delete($id)
    {
        try {
            $title = $this->title;

            $response = Http::withHeaders($this->httpHeaders)
                ->withOptions(['verify' => false])
                ->withToken(session('access_token'))
                ->get(config('app.api_url') . "pengeluarantrucking/$id");

            $pengeluaranTrucking = $response['data'];

            return view('pengeluarantrucking.delete', compact('title', 'pengeluaranTrucking'));
        } catch (\Throwable $th) {
            return redirect()->route('pengeluarantrucking.index');
        }
    }

    /**
     * @ClassName
     */
    public function report(Request $request)
    {
        $response = Http::withHeaders($this->httpHeaders)
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'pengeluarantrucking', $request->all());

        $pengeluaranTruckings = $response['data'];

        $i = 0;
        foreach ($pengeluaranTruckings as $index => $params) {

            $statusaktif = $params['format'];

            $result = json_decode($statusaktif, true);

            $statusaktif = $result['SINGKATAN'];


            $pengeluaranTruckings[$i]['format'] = $statusaktif;


            $i++;
        }

        return view('reports.pengeluarantrucking', compact('pengeluaranTruckings'));
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
}

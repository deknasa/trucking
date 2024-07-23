<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class SubKelompokController extends MyController
{
    public $title = 'Sub Kelompok';
    public $headers = [
        'Accept' => 'application/json',
        'Content-Type' => 'application/json'
    ];

    public function index(Request $request)
    {
        $title = $this->title;
        $data = [
            'combo' => $this->comboStatusAktif('list'),
            'listbtn' => $this->getListBtn()
        ];
        return view('subkelompok.index', compact('title','data'));
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

        $combo = [
            'kelompok' => $this->getKelompok(),
            'statusaktif' => $this->getParameter('STATUS AKTIF', 'STATUS AKTIF'),
        ];

        return view('subkelompok.add', compact('title', 'combo'));
    }

    public function edit($id)
    {
        $title = $this->title;

        $response = Http::withHeaders($this->httpHeaders)
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . "subkelompok/$id");

        $subKelompok = $response['data'];

        $combo = [
            'kelompok' => $this->getKelompok(),
            'statusaktif' => $this->getParameter('STATUS AKTIF', 'STATUS AKTIF'),
        ];

        return view('subkelompok.edit', compact('title', 'subKelompok', 'combo'));
    }


    public function delete($id)
    {
        try {
            $title = $this->title;

            $response = Http::withHeaders($this->httpHeaders)
                ->withOptions(['verify' => false])
                ->withToken(session('access_token'))
                ->get(config('app.api_url') . "subkelompok/$id");

            $subKelompok = $response['data'];

            $combo = [
                'kelompok' => $this->getKelompok(),
                'statusaktif' => $this->getParameter('STATUS AKTIF', 'STATUS AKTIF'),
            ];

            return view('subkelompok.delete', compact('title', 'subKelompok', 'combo'));
        } catch (\Throwable $th) {
            return redirect()->route('subkelompok.index');
        }
    }

    public function getKelompok()
    {
        $response = Http::withHeaders($this->httpHeaders)
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . "kelompok");

        return $response['data'] ?? [];
    }

    public function report(Request $request)
    {
        $response = Http::withHeaders($this->httpHeaders)
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'subkelompok', $request->all());

        $subkelompoks = $response['data'];


        $i = 0;
        foreach ($subkelompoks as $index => $params) {

            $statusaktif = $params['statusaktif'];

            $result = json_decode($statusaktif, true);

            $statusaktif = $result['MEMO'];

            $subkelompoks[$i]['statusaktif'] = $statusaktif;

        
            $i++;


        }

        return view('reports.subkelompok', compact('subkelompoks'));
    }
}

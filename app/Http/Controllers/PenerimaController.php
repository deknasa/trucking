<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class PenerimaController extends MyController
{
    public $title = 'Penerima';

    /**
     * @ClassName
     */
    public function index(Request $request)
    {
        $title = $this->title;
        $data = [
            'pagename' => 'Menu Utama Bank',
            'combo' => $this->comboStatusAktif('list')
        ];

        return view('penerima.index', compact('title','data'));
    }

    /**
     * @ClassName
     */
    public function create()
    {
        $title = $this->title;
        
        $combo = [
            'statusaktif' => $this->getParameter('STATUS AKTIF', 'STATUS AKTIF'),
            'statuskaryawan' => $this->getParameter('STATUS KARYAWAN', 'STATUS KARYAWAN'),
        ];

        return view('penerima.add', compact('title', 'combo'));
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
            ->get(config('app.api_url') . "penerima/$id");

        $penerima = $response['data'];
        $combo = [
            'statusaktif' => $this->getParameter('STATUS AKTIF', 'STATUS AKTIF'),
            'statuskaryawan' => $this->getParameter('STATUS KARYAWAN', 'STATUS KARYAWAN'),
        ];

        return view('penerima.edit', compact('title', 'penerima', 'combo'));
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
                ->get(config('app.api_url') . "penerima/$id");

            $penerima = $response['data'];
            $combo = [
                'statusaktif' => $this->getParameter('STATUS AKTIF', 'STATUS AKTIF'),
                'statuskaryawan' => $this->getParameter('STATUS KARYAWAN', 'STATUS KARYAWAN'),
            ];

            return view('penerima.delete', compact('title', 'penerima', 'combo'));
        } catch (\Throwable $th) {
            return redirect()->route('penerima.index');
        }
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
            ->get(config('app.api_url') . 'cabang/combostatus', $status);

        return $response['data'];
    }
}

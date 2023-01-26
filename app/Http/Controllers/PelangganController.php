<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class PelangganController extends MyController
{
    public $title = 'Pelanggan';

    /**
     * @ClassName
     */
    public function index(Request $request)
    {
        $title = $this->title;
        $data = [
            'pagename' => 'Menu Utama Pelanggan',
            'combo' => $this->combo('list')
        ];

        return view('pelanggan.index', compact('title', 'data'));
    }
    
    /**
     * @ClassName
     */
    public function create()
    {
        $title = $this->title;

        return view('pelanggan.add', compact('title'));
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
            ->get(config('app.api_url') . "pelanggan/$id");

        $pelanggan = $response['data'];

        return view('pelanggan.edit', compact('title', 'pelanggan'));
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
                ->get(config('app.api_url') . "pelanggan/$id");

            $pelanggan = $response['data'];

            return view('pelanggan.delete', compact('title', 'pelanggan'));
        } catch (\Throwable $th) {
            return redirect()->route('pelanggan.index');
        }
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
            ->get(config('app.api_url') . 'pelanggan/combostatus', $status);

        return $response['data'];
    }
}

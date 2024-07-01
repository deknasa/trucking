<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class SupplierController extends MyController
{
    public $title = 'Supplier';

    public function index(Request $request)
    {
        $title = $this->title;

        $data = [            
            'comboaktif' => $this->comboList('list', 'STATUS AKTIF', 'STATUS AKTIF'),
            'combodaftarharga' => $this->comboList('list', 'STATUS DAFTAR HARGA', 'STATUS DAFTAR HARGA'),
            'comboapproval' => $this->comboList('list', 'STATUS APPROVAL', 'STATUS APPROVAL'),
            'combopostingtnl' => $this->comboList('list', 'STATUS POSTING TNL', 'STATUS POSTING TNL'),
            'listbtn' => $this->getListBtn()
        ];

        return view('supplier.index', compact('title', 'data'));
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

    public function create()
    {
        $title = $this->title;

        $combo = [
            'statusaktif' => $this->getParameter('STATUS AKTIF', 'STATUS AKTIF'),
            'statusdaftarharga' => $this->getParameter('STATUS DAFTAR HARGA', 'STATUS DAFTAR HARGA'),
        ];

        return view('supplier.add', compact('title', 'combo'));
    }


    public function edit($id)
    {
        $title = $this->title;

        $combo = [
            'statusaktif' => $this->getParameter('STATUS AKTIF', 'STATUS AKTIF'),
            'statusdaftarharga' => $this->getParameter('STATUS DAFTAR HARGA', 'STATUS DAFTAR HARGA'),
        ];

        $response = Http::withHeaders($this->httpHeaders)
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . "supplier/$id");


        $supplier = $response['data'];

        return view('supplier.edit', compact('title', 'supplier', 'combo'));
    }

    public function delete($id)
    {
        try {
            $title = $this->title;

            $response = Http::withHeaders($this->httpHeaders)
                ->withOptions(['verify' => false])
                ->withToken(session('access_token'))
                ->get(config('app.api_url') . "supplier/$id");

            $combo = [
                'statusaktif' => $this->getParameter('STATUS AKTIF', 'STATUS AKTIF'),
                'statusdaftarharga' => $this->getParameter('STATUS DAFTAR HARGA', 'STATUS DAFTAR HARGA'),
            ];

            $supplier = $response['data'];

            return view('supplier.delete', compact('title', 'supplier', 'combo'));
        } catch (\Throwable $th) {
            return redirect()->route('supplier.index');
        }
    }
    public function report(Request $request)
    {
        $response = Http::withHeaders($this->httpHeaders)
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'supplier', $request->all());

        $suppliers = $response['data'];

        $i = 0;
        foreach ($suppliers as $index => $params) {

            $statusaktif = $params['statusaktif'];
            $statusDaftarHarga = $params['statusdaftarharga'];

            $result = json_decode($statusaktif, true);
            $resultDaftarHarga = json_decode($statusDaftarHarga, true);

            $statusaktif = $result['MEMO'];
            $statusDaftarHarga = $resultDaftarHarga['MEMO'];

            $suppliers[$i]['statusaktif'] = $statusaktif;
            $suppliers[$i]['statusdaftarharga'] = $statusDaftarHarga;
            $i++;
        }

        return view('reports.supplier', compact('suppliers'));
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Http;

class ShipperController extends MyController
{
    public $title = 'Shipper';

    /**
     * @ClassName
     */
    public function index(Request $request)
    {
        $title = $this->title;
        $data = [
            'pagename' => 'Menu Utama Shipper',
            'combo' => $this->combo('list'),
            'listbtn' => $this->getListBtn()
        ];

        return view('shipper.index', compact('title', 'data'));
    }
    
    /**
     * @ClassName
     */
    public function create()
    {
        $title = $this->title;

        return view('shipper.add', compact('title'));
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
            ->get(config('app.api_url') . "shipper/$id");

        $shipper = $response['data'];

        return view('shipper.edit', compact('title', 'shipper'));
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
                ->get(config('app.api_url') . "shipper/$id");

            $shipper = $response['data'];

            return view('shipper.delete', compact('title', 'shipper'));
        } catch (\Throwable $th) {
            return redirect()->route('shipper.index');
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
            ->get(config('app.api_url') . 'shipper/combostatus', $status);

        return $response['data'];
    }
    public function report(Request $request): View
    {
        $response = Http::withHeaders($this->httpHeaders)
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'shipper', $request->all());

        $shippers = $response['data'];

        $i = 0;
        foreach ($shippers as $index => $params) {

            $statusaktif = $params['statusaktif'];

            $result = json_decode($statusaktif, true);

            $statusaktif = $result['MEMO'];

            $shippers[$i]['statusaktif'] = $statusaktif;
            $i++;
        }

        return view('reports.shipper', compact('shippers'));
    }
}

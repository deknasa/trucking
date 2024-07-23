<?php

namespace App\Http\Controllers;


use Illuminate\View\View;
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
            'comboaktif' => $this->comboList('list', 'STATUS AKTIF', 'STATUS AKTIF'),
            'combokaryawan' => $this->comboList('list', 'STATUS KARYAWAN', 'STATUS KARYAWAN'),
            'listbtn' => $this->getListBtn()
        ];

        return view('penerima.index', compact('title','data'));
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
    public function report(Request $request): View
    {
        $response = Http::withHeaders($this->httpHeaders)
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'penerima', $request->all());

        $penerimas = $response['data'];

        $i = 0;
        foreach ($penerimas as $index => $params) {

            $statusaktif = $params['statusaktif'];
            $statusKaryawan = $params['statuskaryawan'];

            $result = json_decode($statusaktif, true);
            $resultKaryawan = json_decode($statusKaryawan, true);

            $statusaktif = $result['MEMO'];
            $statusKaryawan = $resultKaryawan['MEMO'];

            $penerimas[$i]['statusaktif'] = $statusaktif;
            $penerimas[$i]['statuskaryawan'] = $statusKaryawan;
            $i++;
        }

        return view('reports.penerima', compact('penerimas'));
    }

}

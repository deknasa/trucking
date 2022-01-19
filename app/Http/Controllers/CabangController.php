<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;


class CabangController extends Controller
{
    public $title = 'Cabang';
    public $httpHeader = [
        // 'Accept' => 'application/json',
        // 'Content-Type' => 'application/json'
    ];

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $params = [
                'offset' => (($request->page - 1) * $request->rows),
                'limit' => $request->rows,
                'sortIndex' => $request->sidx,
                'sortOrder' => $request->sord,
                'search' => json_decode($request->filters, 1) ?? [],
            ];

            // dd($params);

            $response = Http::withHeaders($request->header())
                ->get('http://localhost/trucking-laravel/public/api/cabang', $params);

            $data = [
                'total' => $response['attributes']['totalPages'],
                'records' => $response['attributes']['totalRows'],
                'rows' => $response['data']
            ];

            return response($data);
        }

        $title = $this->title;
        $data = [
            'pagename' => 'Menu Utama Cabang',
            'combo' => $this->combo('list')
          ];

        return view('cabang.index', compact('title', 'data'));
    }

    public function create()
    {
        $title = $this->title;

          $data['combo'] = $this->combo('entry');
        //   dd($data);

        return view('cabang.add', compact('title', 'data'));
    }

    public function store(Request $request)
    {
        
        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ])->post('http://localhost/trucking-laravel/public/api/cabang', $request->all());
                
        return response($response);
    }

    public function edit($id)
    {
        $title = $this->title;

        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Content-Type' => 'application/json'
        ])->get("http://localhost/trucking-laravel/public/api/cabang/$id");

        $parameter = $response['data'];

        $data['combo'] = $this->combo('entry');

        return view('cabang.edit', compact('title', 'cabang', 'data'));
    }

    public function update(Request $request, $id)
    {
        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ])->patch("http://localhost/trucking-laravel/public/api/cabang/$id", $request->all());

        return response($response);
    }

    public function delete($id)
    {
        try {
            $title = $this->title;

            $response = Http::withHeaders([
                'Accept' => 'application/json',
                'Content-Type' => 'application/json'
            ])->get("http://localhost/trucking-laravel/public/api/cabang/$id");

            $parameter = $response['data'];

            return view('cabang.delete', compact('title', 'cabang'));
        } catch (\Throwable $th) {
            return redirect()->route('cabang.index');
        }
    }

    public function destroy($id)
    {
        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Content-Type' => 'application/json'
        ])->delete("http://localhost/trucking-laravel/public/api/cabang/$id");

        return response($response);
    }

    public function fieldLength()
    {
        $response = Http::withHeaders($this->httpHeader)->get('http://localhost/trucking-laravel/public/api/cabang/field_length');

        return response($response['data']);
    }


    public function combo($aksi)
    {

        $status = [
            'status' => $aksi,
            'grp' => 'STATUS AKTIF',
            'subgrp' => 'STATUS AKTIF',
        ];

        $response = Http::withHeaders($this->httpHeader)
            ->get('http://localhost/trucking-laravel/public/api/cabang/combostatus', $status);

        return $response['data'];
    }
}

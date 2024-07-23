<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class AlatBayarController extends MyController
{
    public $title = 'Alat Bayar';
    public $breadcrumb = '';
    public $access_token = 'tes';
    public $httpHeaders = [
        'Accept' => 'application/json',
        'Content-Type' => 'application/json',
    ];

    // public function __construct()
    // {
    //     $this->middleware(function ($request, $next) {
    //         parent::__construct();

    //         return $next($request);
    //     });
    // }

    public function index(Request $request)
    {
        $title = $this->title;
        
        $data = [
            'combolangsungcair' => $this->comboList('list', 'STATUS LANGSUNG CAIR', 'STATUS LANGSUNG CAIR'),
            'combodefault' => $this->comboList('list', 'STATUS DEFAULT', 'STATUS DEFAULT'),
            'combo' => $this->comboList('list', 'STATUS AKTIF', 'STATUS AKTIF'),
            'listbtn' => $this->getListBtn()
        ];
        return view('alatbayar.index', compact('title','data'));
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


    public function get($params = [])
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
            ->get(config('app.api_url') . 'alatbayar', $params);
        
        $data = [
            'total' => $response['attributes']['totalPages'] ?? [],
            'records' => $response['attributes']['totalRows'] ?? [],
            'rows' => $response['data'] ?? [],
            'params' => $params ?? [],
            'message' => $response['message'] ?? ''
        ];

        if (request()->ajax()) {
            return response($data, $response->status());
        }
        
        return $data;
    }

    public function create()
    {
        $title = $this->title;
        
        $combo = $this->combo();

        return view('alatbayar.add', compact('title','combo'));
    }

    public function store(Request $request): Response
    {
        try {
            $request['modifiedby'] = Auth::user()->name;
            
            $response = Http::withHeaders($this->httpHeaders)->withOptions(['verify' => false])
                ->withToken(session('access_token'))
                ->post(config('app.api_url') . 'alatbayar', $request->all());
            
            return response($response, $response->status());
        } catch (\Throwable $th) {
            dd($th->getMessage());
            throw $th->getMessage();
        }
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $title = $this->title;

        $response = Http::withHeaders($this->httpHeaders)->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . "alatbayar/$id");

        $alatbayar = $response['data'];
        $combo = $this->combo();

        return view('alatbayar.edit', compact('title', 'alatbayar','combo'));
    }

    public function update(Request $request, $id): Response
    {
        $request['modifiedby'] = Auth::user()->name;

        $response = Http::withHeaders($this->httpHeaders)
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->patch(config('app.api_url') . "alatbayar/$id", $request->all());

        return response($response);
    }

    public function delete($id)
    {
        try {
            $title = $this->title;

            $response = Http::withHeaders($this->httpHeaders)
                ->withOptions(['verify' => false])
                ->withToken(session('access_token'))
                ->get(config('app.api_url') . "alatbayar/$id");

            $alatbayar = $response['data'];
            $combo = $this->combo();

            return view('alatbayar.delete', compact('title', 'alatbayar','combo'));
        } catch (\Throwable $th) {
            return redirect()->route('alatbayar.index');
        }
    }

    public function destroy($id, Request $request)
    {
        $request['modifiedby'] = Auth::user()->name;

        $response = Http::withHeaders($this->httpHeaders)
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->delete(config('app.api_url') . "alatbayar/$id", $request->all());

        return response($response);
    }

    public function fieldLength(): Response
    {
        $response = Http::withHeaders($this->httpHeaders)->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'alatbayar/field_length');

        return response($response['data']);
    }

    private function combo()
    {
        $response = Http::withHeaders($this->httpHeaders)->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'alatbayar/combo');
        
        return $response['data'];
    }
    public function report(Request $request)
    {
        $response = Http::withHeaders($this->httpHeaders)
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'alatbayar', $request->all());

        $alatbayars = $response['data'];

        $i = 0;
        foreach ($alatbayars as $index => $params) {

            $statusaktif = $params['statusaktif'];
            $statusLangsungCair = $params['statuslangsungcair'];
            $statusDefault = $params['statusdefault'];

            $result = json_decode($statusaktif, true);
            $resultLangsungCair = json_decode($statusLangsungCair, true);
            $resultDefault = json_decode($statusDefault, true);

            $statusaktif = $result['MEMO'];
            $statusLangsungCair = $resultLangsungCair['MEMO'];
            $statusDefault = $resultDefault['MEMO'];


            $alatbayars[$i]['statusaktif'] = $statusaktif;
            $alatbayars[$i]['statuslangsungcair'] = $statusLangsungCair;
            $alatbayars[$i]['statusdefault'] = $statusDefault;


            $i++;
        }

        return view('reports.alatbayar', compact('alatbayars'));
    }

    
}

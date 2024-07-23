<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class BankController extends MyController
{
    public $title = 'kas / Bank';
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
            'pagename' => 'Menu Utama Bank',
            'combo' => $this->comboStatusAktif('list'),
            'listbtn' => $this->getListBtn()
        ];

        return view('bank.index', compact('title','data'));
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
            ->get(config('app.api_url') . 'bank', $params);

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

        return view('bank.add', compact('title','combo'));
    }

    public function store(Request $request): Response
    {
        try {
            $request['modifiedby'] = Auth::user()->name;
            
            $response = Http::withHeaders($this->httpHeaders)->withOptions(['verify' => false])
                ->withToken(session('access_token'))
                ->post(config('app.api_url') . 'bank', $request->all());
            
            return response($response, $response->status());
        } catch (\Throwable $th) {
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
            ->get(config('app.api_url') . "bank/$id");
        
        $bank = $response['data'];
        $combo = $this->combo();

        return view('bank.edit', compact('title', 'bank','combo'));
    }

    public function update(Request $request, $id): Response
    {
        $request['modifiedby'] = Auth::user()->name;

        $response = Http::withHeaders($this->httpHeaders)->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->patch(config('app.api_url') . "bank/$id", $request->all());

        return response($response);
    }

    public function delete($id)
    {
        try {
            $title = $this->title;

            $response = Http::withHeaders([
                'Accept' => 'application/json',
                'Content-Type' => 'application/json'
            ])
                ->withOptions(['verify' => false])
                ->withToken(session('access_token'))
                ->get(config('app.api_url') . "bank/$id");
            
            $bank = $response['data'];
            $combo = $this->combo();

            return view('bank.delete', compact('title', 'bank','combo'));
        } catch (\Throwable $th) {
            return redirect()->route('bank.index');
        }
    }

    public function destroy($id, Request $request)
    {
        $request['modifiedby'] = Auth::user()->name;

        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Content-Type' => 'application/json'
        ])
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->delete(config('app.api_url') . "bank/$id", $request->all());

        return response($response);
    }

    public function fieldLength(): Response
    {
        $response = Http::withHeaders($this->httpHeaders)->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'bank/field_length');

        return response($response['data']);
    }

    private function combo()
    {
        $response = Http::withHeaders($this->httpHeaders)->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'bank/combo');
        
        return $response['data'];
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
    public function report(Request $request)
    {
        $response = Http::withHeaders($this->httpHeaders)
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'bank', $request->all());

        $banks = $response['data'];

        $i = 0;
        foreach ($banks as $index => $params) {

            $statusaktif = $params['statusaktif'];
            $statusDefault = $params['statusdefault'];
            $formatPenerimaan = $params['formatpenerimaan'];
            $formatPengeluaran = $params['formatpengeluaran'];

            $result = json_decode($statusaktif, true);
            $resultDefault = json_decode($statusDefault, true);
            $resultPengeluaran = json_decode($formatPengeluaran, true);
            $resultPenerimaan = json_decode($formatPenerimaan, true);

            $statusaktif = $result['MEMO'];
            $statusDefault = $resultDefault['MEMO'];
            $formatPenerimaan = $resultPengeluaran['MEMO'];
            $formatPengeluaran = $resultPenerimaan['MEMO'];


            $banks[$i]['statusaktif'] = $statusaktif;
            $banks[$i]['statusdefault'] = $statusDefault;
            $banks[$i]['formatpenerimaan'] = $formatPenerimaan;
            $banks[$i]['formatpengeluaran'] = $formatPengeluaran;


            $i++;
        }

        return view('reports.bank', compact('banks'));
    }
}

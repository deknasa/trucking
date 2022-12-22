<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class SuratPengantarController extends MyController
{
    public $title = 'Surat Pengantar';

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
            'combolongtrip' => $this->comboList('list','STATUS LONGTRIP','STATUS LONGTRIP'),
            'comboperalihan' => $this->comboList('list','STATUS PERALIHAN','STATUS PERALIHAN'),
            'comboritasiomset' => $this->comboList('list','STATUS RITASI OMSET','STATUS RITASI OMSET'),
            'combogudangsama' => $this->comboList('list','STATUS GUDANG SAMA','STATUS GUDANG SAMA'),
            'combobatalmuat' => $this->comboList('list','STATUS BATAL MUAT','STATUS BATAL MUAT')
        ];
        return view('suratpengantar.index', compact('title','data'));
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
            ->get(config('app.api_url') . 'suratpengantar', $params);

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
        $breadcrumb = $this->breadcrumb;
        $combo = $this->combo();

        return view('suratpengantar.add', compact('title', 'breadcrumb','combo'));
    }

    public function store(Request $request): Response
    {
        try {
            $request['modifiedby'] = Auth::user()->name;

            $request['gajisupir'] = str_replace('.', '', $request['gajisupir']);
            $request['gajisupir'] = str_replace(',', '', $request['gajisupir']);

            $request['gajikenek'] = str_replace('.', '', $request['gajikenek']);
            $request['gajikenek'] = str_replace(',', '', $request['gajikenek']);

            $request['komisisupir'] = str_replace('.', '', $request['komisisupir']);
            $request['komisisupir'] = str_replace(',', '', $request['komisisupir']);
        
            $response = Http::withHeaders([
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ])
                ->withToken(session('access_token'))
                ->post(config('app.api_url') . 'suratpengantar', $request->all());
    
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

        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Content-Type' => 'application/json'
        ])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . "suratpengantar/$id");

        $suratpengantar = $response['data'];
        $combo = $this->combo();

        return view('suratpengantar.edit', compact('title', 'suratpengantar','combo'));
    }

    public function update(Request $request, $id): Response
    {
        $request['modifiedby'] = Auth::user()->name;

        $request['gajisupir'] = str_replace('.', '', $request['gajisupir']);
        $request['gajisupir'] = str_replace(',', '', $request['gajisupir']);

        $request['gajikenek'] = str_replace('.', '', $request['gajikenek']);
        $request['gajikenek'] = str_replace(',', '', $request['gajikenek']);

        $request['komisisupir'] = str_replace('.', '', $request['komisisupir']);
        $request['komisisupir'] = str_replace(',', '', $request['komisisupir']);

        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ])
            ->withToken(session('access_token'))
            ->patch(config('app.api_url') . "suratpengantar/$id", $request->all());

        return response($response);
    }

    public function delete($id)
    {
        try {
            $title = $this->title;

            $response = Http::withHeaders($this->httpHeaders)->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . "suratpengantar/$id");

            $suratpengantar = $response['data'];

            $combo = $this->combo();

            return view('suratpengantar.delete', compact('title', 'suratpengantar', 'combo'));
        } catch (\Throwable $th) {
            return redirect()->route('suratpengantar.index');
        }
    }

    public function destroy($id, Request $request)
    {
        $response = Http::withHeaders($this->httpHeaders)->withOptions(['verify' => false])
            ->withToken(session('access_token'))
        ->delete(config('app.api_url') . "suratpengantar/$id", $request->all());

        return response($response);
    }

    // public function delete($id)
    // {
    //     try {
    //         $title = $this->title;

    //         $response = Http::withHeaders([
    //             'Accept' => 'application/json',
    //             'Content-Type' => 'application/json'
    //         ])
    //             ->withToken(session('access_token'))
    //             ->get(config('app.api_url') . "suratpengantar/$id");

    //         $suratpengantar = $response['data'];
    //         $combo = $this->combo();

    //         return view('suratpengantar.delete', compact('title', 'suratpengantar','combo'));
    //     } catch (\Throwable $th) {
    //         return redirect()->route('suratpengantar.index');
    //     }
    // }

    // public function destroy($id, Request $request)
    // {
    //     $request['modifiedby'] = Auth::user()->name;

    //     $response = Http::withHeaders([
    //         'Accept' => 'application/json',
    //         'Content-Type' => 'application/json'
    //     ])
    //         ->withToken(session('access_token'))
    //         ->delete(config('app.api_url') . "suratpengantar/$id", $request->all());

    //     return response($response);
    // }

    public function fieldLength(): Response
    {
        $response = Http::withHeaders($this->httpHeaders)->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'suratpengantar/field_length');

        return response($response['data']);
    }

    public function getGaji(Request $request): Response
    {
        $response = Http::withHeaders($this->httpHeaders)->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'suratpengantar/get_gaji', $request->all());
        
        return response($response['data']);
    }

    private function combo()
    {
        $response = Http::withHeaders($this->httpHeaders)->withOptions(['verify' => false])
            ->get(config('app.api_url') . 'suratpengantar/combo');
        
        return $response['data'];
    }
}

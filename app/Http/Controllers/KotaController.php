<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;

class KotaController extends MyController
{
    public $title = 'KOTA';

    /**
     * @ClassName
     */
    public function index(Request $request)
    {
        $title = $this->title;
        $data = [
            'combo' => $this->comboStatusAktif('list'),
            'listbtn' => $this->getListBtn()
        ];

        return view('kota.index', compact('title', 'data'));
    }

    /**
     * @ClassName
     */
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
            ->get(config('app.api_url') . 'kota', $params);

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

    /**
     * @ClassName
     */
    public function create(): View
    {
        $title = $this->title;
        $combo = $this->combo();

        return view('kota.add', compact('title', 'combo'));
    }

    /**
     * @ClassName
     */
    public function store(Request $request): Response
    {
        try {
            $request['modifiedby'] = Auth::user()->name;

            $response = Http::withHeaders($this->httpHeaders)
                ->withToken(session('access_token'))
                ->post(config('app.api_url') . 'kota', $request->all());

            return response($response, $response->status());
        } catch (\Throwable $th) {
            throw $th->getMessage();
        }
    }

    /**
     * @ClassName
     */
    public function edit($id): View
    {
        $title = $this->title;
        $combo = $this->combo();

        $response = Http::withHeaders($this->httpHeaders)
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . "kota/$id");
        
        $kota = $response['data'];

        return view('kota.edit', compact('title', 'kota', 'combo'));
    }

    /**
     * @ClassName
     */
    public function delete($id)
    {
        // try {
            $title = $this->title;
            $combo = $this->combo();

            $response = Http::withHeaders($this->httpHeaders)
                ->withOptions(['verify' => false])
                ->withToken(session('access_token'))
                ->get(config('app.api_url') . "kota/$id");

            $kota = $response['data'];

            return view('kota.delete', compact('title', 'kota', 'combo'));
        // } catch (\Throwable $th) {
        //     return redirect()->route('kota.index');
        // }
    }

    public function fieldLength(): Response
    {
        $response = Http::withHeaders($this->httpHeaders)
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'kota/field_length');

        return response($response['data']);
    }

    private function combo()
    {
        $response = Http::withHeaders($this->httpHeaders)
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'kota/combo');

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
            ->get(config('app.api_url') . 'user/combostatus', $status);

        return $response['data'];
    }
    public function report(Request $request)
    {
        $response = Http::withHeaders($this->httpHeaders)
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'kota', $request->all());

        $kotas = $response['data'];

        $i = 0;
        foreach ($kotas as $index => $params) {

            $statusaktif = $params['statusaktif'];

            $result = json_decode($statusaktif, true);

            $statusaktif = $result['MEMO'];

            $kotas[$i]['statusaktif'] = $statusaktif;

        
            $i++;
        }

        return view('reports.kota', compact('kotas'));
    }
}

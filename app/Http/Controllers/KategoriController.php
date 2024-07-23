<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;

class KategoriController extends MyController
{
    public $title = 'KATEGORI';

    /**
     * @ClassName
     */
    public function index(Request $request)
    {
        $title = $this->title;
        $data = [
            'pagename' => 'Menu Utama Kategori',
            'combo' => $this->comboStatusAktif('list'),
            'listbtn' => $this->getListBtn()
        ];

        return view('kategori.index', compact('title','data'));
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
            ->get(config('app.api_url') . 'kategori', $params);

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

        return view('kategori.add', compact('title','combo'));
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
                ->post(config('app.api_url') . 'kategori', $request->all());

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

        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Content-Type' => 'application/json'
        ])->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . "kategori/$id");

        $kategori = $response['data'];

        return view('kategori.edit', compact('title', 'kategori','combo'));
    }

    /**
     * @ClassName
     */
    public function update(Request $request, $id): Response
    {
        $request['modifiedby'] = Auth::user()->name;

        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ])
            ->withToken(session('access_token'))
            ->patch(config('app.api_url') . "kategori/$id", $request->all());

        return response($response);
    }

    /**
     * @ClassName
     */
    public function delete($id)
    {
        try {
            $title = $this->title;
            $combo = $this->combo();

            $response = Http::withHeaders([
                'Accept' => 'application/json',
                'Content-Type' => 'application/json'
            ])->withOptions(['verify' => false])
                ->withToken(session('access_token'))
                ->get(config('app.api_url') . "kategori/$id");

            $kategori = $response['data'];

            return view('kategori.delete', compact('title', 'kategori','combo'));
        } catch (\Throwable $th) {
            return redirect()->route('kategori.index');
        }
    }

    /**
     * @ClassName
     */
    public function destroy($id, Request $request)
    {
        $request['modifiedby'] = Auth::user()->name;

        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Content-Type' => 'application/json'
        ])->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->delete(config('app.api_url') . "kategori/$id", $request->all());

        return response($response);
    }

    public function fieldLength(): Response
    {
        $response = Http::withHeaders($this->httpHeaders)
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'kategori/field_length');

        return response($response['data']);
    }

    private function combo()
    {
        $response = Http::withHeaders($this->httpHeaders)->withOptions(['verify' => false])->withToken(session('access_token'))
            ->get(config('app.api_url') . 'kategori/combo');
        
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
            ->get(config('app.api_url') . 'kategori', $request->all());

        $kategoris = $response['data'];



        $i = 0;
        foreach ($kategoris as $index => $params) {

            $statusaktif = $params['status'];

            $result = json_decode($statusaktif, true);

            $statusaktif = $result['MEMO'];

            $kategoris[$i]['statusaktif'] = $statusaktif;

        
            $i++;


        }

        return view('reports.kategori', compact('kategoris'));
    }
}

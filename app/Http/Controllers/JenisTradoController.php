<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;

class JenisTradoController extends MyController
{
    public $title = 'JENIS TRADO';

    /**
     * @ClassName
     */
    public function index(Request $request)
    {
        $title = $this->title;
        $data = [
            'combo' => $this->combo('list'),
            'listbtn' => $this->getListBtn()
        ];
        return view('jenistrado.index', compact('title', 'data'));
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
            ->get(config('app.api_url') . 'jenistrado', $params);

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
        
        $combo = [
            'status' => $this->getParameter('STATUS AKTIF', 'STATUS AKTIF'),
        ];

        return view('jenistrado.add', compact('title', 'combo'));
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
                ->post(config('app.api_url') . 'jenistrado', $request->all());

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

        $response = Http::withHeaders($this->httpHeaders)
        ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . "jenistrado/$id");

        $jenistrado = $response['data'];

        $combo = [
            'status' => $this->getParameter('STATUS AKTIF', 'STATUS AKTIF'),
        ];

        return view('jenistrado.edit', compact('title', 'jenistrado', 'combo'));
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
            ->patch(config('app.api_url') . "jenistrado/$id", $request->all());

        return response($response);
    }

    /**
     * @ClassName
     */
    public function delete($id)
    {
        try {
           
            $title = $this->title;

            $response = Http::withHeaders($this->httpHeaders)->withOptions(['verify' => false])
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
                ->get(config('app.api_url') . "jenistrado/$id");

            $jenistrado = $response['data'];



            $combo = [
                'status' => $this->getParameter('STATUS AKTIF', 'STATUS AKTIF'),
            ];
            
            return view('jenistrado.delete', compact('title', 'jenistrado', 'combo'));
        } catch (\Throwable $th) {
            return redirect()->route('jenistrado.index');
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
        ])
            ->withToken(session('access_token'))
            ->delete(config('app.api_url') . "jenistrado/$id", $request->all());

        return response($response);
    }

    public function fieldLength(): Response
    {
        $response = Http::withHeaders($this->httpHeaders)
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'jenistrado/field_length');

        return response($response['data']);
    }

    public function combo($aksi)
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
            ->get(config('app.api_url') . 'jenistrado', $request->all());

        $jenisTrados = $response['data'];


        $i = 0;
        foreach ($jenisTrados as $index => $params) {

            $statusaktif = $params['statusaktif'];

            $result = json_decode($statusaktif, true);

            $statusaktif = $result['MEMO'];

            $jenisTrados[$i]['statusaktif'] = $statusaktif;

        
            $i++;


        }

        // dd($jenisTrados);

        return view('reports.jenistrado', compact('jenisTrados'));
    }

}

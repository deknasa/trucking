<?php 
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Response;

class MainTypeAkuntansiController extends MyController
{
    public $title = 'Type Kode Perkiraan Pusat';

    /**
     * Fungsi index
     * @ClassName index
     */
    public function index(Request $request)
    {
        $title = $this->title;
        $data = [
            'pagename' => 'Menu Utama TIPE AKUNTANSI',
            'combo' => $this->combo('list'),
            'listbtn' => $this->getListBtn()
        ];

        return view('maintypeakuntansi.index', compact('title', 'data'));
    }

    public function get($params = []): array
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
            ->get(config('app.api_url') . 'maintypeakuntansi', $params);

        $data = [
            'total' => $response['attributes']['totalPages'] ?? [],
            'records' => $response['attributes']['totalRows'] ?? [],
            'rows' => $response['data'] ?? []
        ];

        return $data;
    }

    /**
     * Fungsi create
     * @ClassName create
     */
    public function create()
    {
        $title = $this->title;

        $data['combo'] = $this->combo('entry');

        return view('typeakuntansi.add', compact('title', 'data'));
    }

    public function store(Request $request)
    {
        $request['modifiedby'] = Auth::user()->name;
        $response = Http::withHeaders($this->httpHeaders)
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->post(config('app.api_url') . 'typeakuntansi', $request->all());

        return response($response);
    }

    public function update(Request $request, $id)
    {
        $request['modifiedby'] = Auth::user()->name;

        $response = Http::withHeaders($this->httpHeaders)
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->patch(config('app.api_url') . "maintypeakuntansi/$id", $request->all());

        return response($response);
    }


    /**
     * Fungsi delete
     * @ClassName delete
     */
    public function delete($id)
    {
        try {
            $title = $this->title;

            $response = Http::withHeaders($this->httpHeaders)
                ->withOptions(['verify' => false])
                ->withToken(session('access_token'))
                ->get(config('app.api_url') . "maintypeakuntansi/$id");

            $maintypeakuntansi = $response['data'];

            $data['combo'] = $this->combo('entry');

            return view('maintypeakuntansi.delete', compact('title', 'maintypeakuntansi', 'data'));
        } catch (\Throwable $th) {
            return redirect()->route('maintypeakuntansi.index');
        }
    }

    public function destroy($id, Request $request)
    {
        $request['modifiedby'] = Auth::user()->name;

        $response = Http::withHeaders($this->httpHeaders)
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->delete(config('app.api_url') . "maintypeakuntansi/$id", $request->all());

        return response($response);
    }






    public function fieldLength(): Response
    {
        $response = Http::withHeaders($this->httpHeaders)
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'maintypeakuntansi/field_length');

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
            ->get(config('app.api_url') . 'maintypeakuntansi', $request->all());

        $maintypeakuntansi = $response['data'];

        $i = 0;
        foreach ($maintypeakuntansi as $index => $params) {

            $statusaktif = $params['statusaktif'];

            $result = json_decode($statusaktif, true);

            $statusaktif = $result['MEMO'];

            $maintypeakuntansi[$i]['statusaktif'] = $statusaktif;

        
            $i++;


        }

        return view('reports.maintypeakuntansi', compact('maintypeakuntansi'));
    }
}


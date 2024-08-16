<?php 
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Response;

class AkuntansiController extends MyController
{
    public $title = 'Akuntansi';

    /**
     * Fungsi index
     * @ClassName index
     */
    public function index(Request $request)
    {
        $title = $this->title;
        $data = [
            'pagename' => 'Menu Utama Akuntansi',
            'combo' => $this->combo('list'),
            'listbtn' => $this->getListBtn()
        ];

        return view('akuntansi.index', compact('title', 'data'));
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
            ->get(config('app.api_url') . 'akuntansi', $params);

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

        return view('akuntansi.add', compact('title', 'data'));
    }

    public function store(Request $request)
    {
        $request['modifiedby'] = Auth::user()->name;
        $response = Http::withHeaders($this->httpHeaders)
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->post(config('app.api_url') . 'akuntansi', $request->all());

        return response($response);
    }

    public function update(Request $request, $id)
    {
        $request['modifiedby'] = Auth::user()->name;

        $response = Http::withHeaders($this->httpHeaders)
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->patch(config('app.api_url') . "akuntansi/$id", $request->all());

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
                ->get(config('app.api_url') . "akuntansi/$id");

            $akuntansi = $response['data'];

            $data['combo'] = $this->combo('entry');

            return view('akuntansi.delete', compact('title', 'akuntansi', 'data'));
        } catch (\Throwable $th) {
            return redirect()->route('akuntansi.index');
        }
    }

    public function destroy($id, Request $request)
    {
        $request['modifiedby'] = Auth::user()->name;

        $response = Http::withHeaders($this->httpHeaders)
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->delete(config('app.api_url') . "akuntansi/$id", $request->all());

        return response($response);
    }






    public function fieldLength(): Response
    {
        $response = Http::withHeaders($this->httpHeaders)
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'akuntansi/field_length');

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
            ->get(config('app.api_url') . 'akuntansi', $request->all());

        $akuntansi = $response['data'];

        $i = 0;
        foreach ($akuntansi as $index => $params) {

            $statusaktif = $params['statusaktif'];

            $result = json_decode($statusaktif, true);

            $statusaktif = $result['MEMO'];

            $akuntansi[$i]['statusaktif'] = $statusaktif;

        
            $i++;


        }

        return view('reports.akuntansi', compact('akuntansi'));
    }
}


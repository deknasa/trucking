<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class MenuController extends Controller
{
    public $title = 'Menu';
    public $httpHeader = [
        'Accept' => 'application/json',
        'Content-Type' => 'application/json'
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

            $response = Http::withHeaders($request->header())
                ->get(config('app.api_url') . 'api/menu', $params);

            $data = [
                'total' => $response['attributes']['totalPages'] ?? [],
                'records' => $response['attributes']['totalRows'] ?? [],
                'rows' => $response['data'] ?? []
            ];


            return response($data);
        }


        $title = $this->title;
        $data = [
            'pagename' => 'Menu Utama Menu',
            'combo' => $this->combo('list')
        ];

        return view('menu.index', compact('title', 'data'));
    }

    public function create()
    {
        $title = $this->title;

        $data['combo'] = $this->combo('entry');

        return view('menu.add', compact('title', 'data'));
    }

    public function store(Request $request)
    {

        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ])->post(config('app.api_url') . 'api/menu', $request->all());

        return response($response);
    }

    public function edit($id)
    {
        $title = $this->title;

        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Content-Type' => 'application/json'
        ])->get(config('app.api_url') . "api/menu/$id");

        $menu = $response['data'];

        $data['combo'] = $this->combo('entry');

        return view('menu.edit', compact('title', 'menu', 'data'));
    }

    public function update(Request $request, $id)
    {
        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ])->patch(config('app.api_url') . "api/menu/$id", $request->all());

        return response($response);
    }

    public function delete($id)
    {
        try {
            $title = $this->title;

            $response = Http::withHeaders([
                'Accept' => 'application/json',
                'Content-Type' => 'application/json'
            ])->get(config('app.api_url') . "api/menu/$id");

            $menu = $response['data'];

            $data['combo'] = $this->combo('entry');

            return view('menu.delete', compact('title', 'menu', 'data'));
        } catch (\Throwable $th) {
            return redirect()->route('menu.index');
        }
    }

    public function destroy($id,Request $request)
    {
        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Content-Type' => 'application/json'
        ])->delete(config('app.api_url') . "api/menu/$id", $request->all());

        return response($response);
        
    }

    public function fieldLength()
    {
        $response = Http::withHeaders($this->httpHeader)->get(config('app.api_url') . 'menu/field_length');

        return response($response['data']);
    }


    public function combo($aksi)
    {
        $status = [
            'status' => $aksi,
        ];

        $response = Http::withHeaders($this->httpHeader)
            ->get(config('app.api_url') . 'menu/combomenuparent', $status);

        return $response['data'];
    }

}

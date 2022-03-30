<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;

class ErrorController extends MyController
{
    public $title = 'Error';

    /**
     * Fungsi index
     * @ClassName index
     */
    public function index(Request $request)
    {

        $title = $this->title;
        $data = [
            'pagename' => 'Menu Utama Error'
        ];

        return view('error.index', compact('title', 'data'));
    }

    /**
     * @ClassName
     */
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
            ->get(config('app.api_url') . 'error', $params);

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


        return view('error.add', compact('title'));
    }

    /**
     * @ClassName
     */
    public function store(Request $request)
    {

        $request['modifiedby'] = Auth::user()->name;
        
        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ])
            ->withToken(session('access_token'))
            ->post(config('app.api_url') . 'error', $request->all());

        return response($response, $response->status());
    }

    /**
     * Fungsi edit
     * @ClassName edit
     */
    public function edit($id)
    {
        $title = $this->title;
        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Content-Type' => 'application/json'
        ])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . "error/$id");

        $error = $response['data'];


        return view('error.edit', compact('title', 'error'));
    }

    /**
     * @ClassName
     */
    public function update(Request $request, $id)
    {
        $request['modifiedby'] = Auth::user()->name;

        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ])
            ->withToken(session('access_token'))
            ->patch(config('app.api_url') . "error/$id", $request->all());

        return response($response, $response->status());
    }


    /**
     * Fungsi delete
     * @ClassName delete
     */
    public function delete($id)
    {
        try {
            $title = $this->title;

            $response = Http::withHeaders([
                'Accept' => 'application/json',
                'Content-Type' => 'application/json'
            ])
                ->withToken(session('access_token'))
                ->get(config('app.api_url') . "error/$id");

            $error = $response['data'];


            return view('error.delete', compact('title', 'error'));
        } catch (\Throwable $th) {
            return redirect()->route('error.index');
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
            ->delete(config('app.api_url') . "error/$id", $request->all());

        return response($response, $response->status());
    }

    /**
     * @ClassName
     */
    public function report(Request $request)
    {
        $response = Http::withHeaders($this->httpHeaders)
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'error', $request->all());
        
        $errors = $response['data'];

        return view('reports.error', compact('errors'));
    }

    /**
     * @ClassName
     */
    public function export(Request $request)
    {
        $params = [
            'offset' => $request->dari - 1,
            'rows' => $request->sampai - $request->dari + 1,
        ];

        $errors = $this->get($params)['rows'];

        $columns = [
            [
                'label' => 'No',
            ],
            [
                'label' => 'ID',
                'index' => 'id',
            ],
            [
                'label' => 'Kode Error',
                'index' => 'kodeerror',
            ],
            [
                'label' => 'Keterangan',
                'index' => 'keterangan',
            ],
        ];

        $this->toExcel($this->title, $errors, $columns);
    }

    public function fieldLength()
    {
        $response = Http::withHeaders($this->httpHeaders)
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'error/field_length');

        return response($response['data'], $response->status());
    }


}

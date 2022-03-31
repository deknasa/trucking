<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;

class UserRoleController extends MyController
{
    public $title = 'User Role';

    /**
     * Fungsi index
     * @ClassName index
     */
    public function index(Request $request)
    {
        $title = $this->title;

        return view('userrole.index', compact('title'));
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
            ->get(config('app.api_url') . 'userrole', $params);

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

    public function detail(Request $request)
    {
        if ($request->ajax()) {
            $params = [
                'offset' => (($request->page - 1) * $request->rows),
                'limit' => $request->rows,
                'sortIndex' => $request->sidx,
                'sortOrder' => $request->sord,
                'search' => json_decode($request->filters, 1) ?? [],
                'user_id' => $request->user_id,
            ];

            $response = Http::withHeaders($request->header())
                ->get(config('app.api_url') . 'userrole/detail', $params);

            $data = [
                'total' => $response['attributes']['totalPages'] ?? [],
                'records' => $response['attributes']['totalRows'] ?? [],
                'rows' => $response['data'] ?? []
            ];

            return response($data);
        }
    }

    /**
     * Fungsi create
     * @ClassName create
     */
    public function create(Request $request)
    {
        $title = $this->title;
        $list = [
            'detail' => $this->detaillist($request->user_id  ?? '0'),
        ];
        $data['combo'] = $this->combo('entry');


        $user_id = '0';

        return view('userrole.add', compact('title', 'list', 'user_id', 'data'));
    }

    public function store(Request $request)
    {
        $request['modifiedby'] = Auth::user()->name;

        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ])
            ->withToken(session('access_token'))
            ->post(config('app.api_url') . 'userrole', $request->all());

        return response($response, $response->status());
    }

    /**
     * Fungsi edit
     * @ClassName edit
     */
    public function edit($id)
    {
        $title = $this->title;

        $response = Http::withHeaders($this->httpHeaders)->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . "userrole/$id");

        $userrole = $response['data'];

        $list = [
            'detail' => $this->detaillist($userrole['user_id']  ?? '0'),
        ];

        $data['combo'] = $this->combo('entry');

        $user_id = $userrole['user_id'];

        return view('userrole.edit', compact('title', 'userrole', 'list', 'user_id', 'data'));
    }

    public function update(Request $request, $id)
    {
        $request['modifiedby'] = Auth::user()->name;

        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ])
            ->withToken(session('access_token'))
            ->patch(config('app.api_url') . "userrole/$id", $request->all());

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
                ->get(config('app.api_url') . "userrole/$id");


            $userrole = $response['data'];
            $list = [
                'detail' => $this->detaillist($userrole['user_id']  ?? '0'),
            ];
            $data['combo'] = $this->combo('entry');

            $user_id = $userrole['user_id'];



            return view('userrole.delete', compact('title', 'userrole', 'list', 'user_id', 'data'));
        } catch (\Throwable $th) {
            return redirect()->route('userrole.index');
        }
    }

    public function destroy($id, Request $request)
    {
        $request['modifiedby'] = Auth::user()->name;
        $response = Http::withHeaders($this->httpHeaders)->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->delete(config('app.api_url') . "userrole/$id", $request->all());

        return response($response, $response->status());
    }

    /**
     * @ClassName
     */
    public function report(Request $request)
    {
        $params['offset'] = $request->dari - 1;
        $params['rows'] = $request->sampai - $request->dari + 1;

        $userroles = $this->get($params)['rows'];

        return view('reports.userrole', compact('userroles'));
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

        $userroles = $this->get($params)['rows'];

        $columns = [
            [
                'label' => 'No',
            ],
            [
                'label' => 'ID',
                'index' => 'id',
            ],
            [
                'label' => 'User ID',
                'index' => 'user_id',
            ],
            [
                'label' => 'User',
                'index' => 'user',
            ],
            [
                'label' => 'Name',
                'index' => 'name',
            ],
        ];

        $this->toExcel($this->title, $userroles, $columns);
    }

    public function fieldLength()
    {
        $response = Http::withHeaders($this->httpHeaders)->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'userrole/field_length');

        return response($response['data'], $response->status());
    }

    public function detaillist($user_id)
    {
        $status = [
            'user_id' => $user_id,
        ];
        $response = Http::withHeaders($this->httpHeaders)->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'userrole/detaillist', $status);

        return $response['data'];
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
            ->get(config('app.api_url') . 'userrole/combostatus', $status);

        return $response['data'];
    }
}

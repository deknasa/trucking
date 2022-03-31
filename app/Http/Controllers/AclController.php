<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;

class AclController extends MyController
{
    public $title = 'Acl';

    /**
     * Fungsi index
     * @ClassName index
     */
    public function index(Request $request)
    {
        $title = $this->title;

        $data = [
            'pagename' => 'Menu Utama Acl',
        ];

        return view('acl.index', compact('title', 'data'));
    }

    public function get($params = [])
    {
        $params = [
            'offset' => ((request()->page - 1) * request()->rows),
            'limit' => request()->rows,
            'sortIndex' => request()->sidx,
            'sortOrder' => request()->sord,
            'search' => json_decode(request()->filters, 1) ?? [],

        ];

        $response = Http::withHeaders(request()->header())
            ->get(config('app.api_url') . 'acl', $params);

        $data = [
            'total' => $response['attributes']['totalPages'] ?? [],
            'records' => $response['attributes']['totalRows'] ?? [],
            'rows' => $response['data'] ?? []
        ];

        if (request()->ajax()) {
            return response($data);
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
                'role_id' => $request->role_id,

            ];

            $response = Http::withHeaders($request->header())
                ->withToken(session('access_token'))
                ->get(config('app.api_url') . 'acl/detail', $params);

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
            'detail' => $this->detaillist($request->role_id  ?? '0'),
        ];
        $data['combo'] = $this->combo('entry');

        $role_id = '0';
        //   dd($data);
        return view('acl.add', compact('title', 'list', 'role_id', 'data'));
    }

    public function store(Request $request)
    {

        $request['modifiedby'] = Auth::user()->name;

        $response = Http::withHeaders($this->httpHeaders)->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->post(config('app.api_url') . 'acl', $request->all());



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
            ->get(config('app.api_url') . "acl/$id");

        $acl = $response['data'];
        $list = [
            'detail' => $this->detaillist($acl['role_id']  ?? '0'),
        ];
        $data['combo'] = $this->combo('entry');

        $role_id = $acl['role_id'];
        return view('acl.edit', compact('title', 'acl', 'list', 'role_id', 'data'));
    }

    public function update(Request $request, $id)
    {
        $request['modifiedby'] = Auth::user()->name;
        $response = Http::withHeaders($this->httpHeaders)->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->patch(config('app.api_url') . "acl/$id", $request->all());

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
                ->get(config('app.api_url') . "acl/$id");


            $acl = $response['data'];
            $list = [
                'detail' => $this->detaillist($acl['role_id']  ?? '0'),
            ];
            $data['combo'] = $this->combo('entry');

            $role_id = $acl['role_id'];



            return view('acl.delete', compact('title', 'acl', 'list', 'role_id', 'data'));
        } catch (\Throwable $th) {
            return redirect()->route('acl.index');
        }
    }

    public function destroy($id, Request $request)
    {
        $request['modifiedby'] = Auth::user()->name;
        $response = Http::withHeaders($this->httpHeaders)->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->delete(config('app.api_url') . "acl/$id", $request->all());

        return response($response, $response->status());
    }

    /**
     * @ClassName
     */
    public function report(Request $request)
    {
        $params['offset'] = $request->dari - 1;
        $params['rows'] = $request->sampai - $request->dari + 1;

        $acls = $this->get($params)['rows'];

        return view('reports.acl', compact('acls'));
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

        $acls = $this->get($params)['rows'];

        $columns = [
            [
                'label' => 'No',
            ],
            [
                'label' => 'ID',
                'index' => 'id',
            ],
            [
                'label' => 'Role ID',
                'index' => 'role_id',
            ],
            [
                'label' => 'Role Name',
                'index' => 'rolename',
            ],
        ];

        $this->toExcel($this->title, $acls, $columns);
    }

    public function fieldLength()
    {
        $response = Http::withHeaders($this->httpHeaders)->withOptions(['verify' => false])->get(config('app.api_url') . 'acl/field_length');

        return response($response['data'], $response->status());
    }

    public function detaillist($role_id)
    {
        $status = [
            'role_id' => $role_id,
        ];
        $response = Http::get(config('app.api_url') . 'acl/detaillist', $status);
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
            ->get(config('app.api_url') . 'acl/combostatus', $status);

        return $response['data'];
    }
}

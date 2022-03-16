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
        if ($request->ajax()) {
            $params = [
                'offset' => (($request->page - 1) * $request->rows),
                'limit' => $request->rows,
                'sortIndex' => $request->sidx,
                'sortOrder' => $request->sord,
                'search' => json_decode($request->filters, 1) ?? [],

            ];

            $response = Http::withHeaders($request->header())
                ->get(config('app.api_url') . 'acl', $params);

            $data = [
                'total' => $response['attributes']['totalPages'] ?? [],
                'records' => $response['attributes']['totalRows'] ?? [],
                'rows' => $response['data'] ?? []
            ];


            return response($data);
        }


        $title = $this->title;
        $data = [
            'pagename' => 'Menu Utama Acl',
        ];

        return view('acl.index', compact('title', 'data'));
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

            // dump(config('app.api_url') . 'acl/detail');
            // dd($params);

            $response = Http::withHeaders($request->header())
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

        $response = Http::withHeaders($this->httpHeaders)->post(config('app.api_url') . 'acl', $request->all());



        return response($response);
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
        ])->get(config('app.api_url') . "acl/$id");

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
        $response = Http::withHeaders($this->httpHeaders)->patch(config('app.api_url') . "acl/$id", $request->all());

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

            $response = Http::withHeaders([
                'Accept' => 'application/json',
                'Content-Type' => 'application/json'
            ])->get(config('app.api_url') . "acl/$id");


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
        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Content-Type' => 'application/json'
        ])->delete(config('app.api_url') . "acl/$id", $request->all());



        return response($response);
    }

    public function fieldLength()
    {
        $response = Http::withHeaders($this->httpHeaders)->get(config('app.api_url') . 'acl/field_length');

        return response($response['data']);
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

        $response = Http::withHeaders($this->httpHeaders)
            ->get(config('app.api_url') . 'acl/combostatus', $status);

        return $response['data'];
    }
}

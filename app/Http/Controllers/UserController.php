<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;


class UserController extends Controller
{
    public $title = 'User';
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
                ->get(config('app.api_url') . 'user', $params);

            $data = [
                'total' => $response['attributes']['totalPages'] ?? [],
                'records' => $response['attributes']['totalRows'] ?? [],
                'rows' => $response['data'] ?? []
            ];


            return response($data);
        }


        $title = $this->title;
        $data = [
            'pagename' => 'Menu Utama User',
            'combo' => $this->combo('list'),
            'combocabang' => $this->combocabang('list')
        ];

        return view('user.index', compact('title', 'data'));
    }

    public function create()
    {
        $title = $this->title;

        $data['combo'] = $this->combo('entry');
        $data['combocabang'] = $this->combocabang('entry');

        return view('user.add', compact('title', 'data'));
    }

    public function store(Request $request)
    {
        $request['modifiedby']=Auth::user()->name;
        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ])->post(config('app.api_url') . 'user', $request->all());

        return response($response);
    }

    public function edit($id)
    {
        $title = $this->title;

        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Content-Type' => 'application/json'
        ])->get(config('app.api_url') . "user/$id");

        $user = $response['data'];

        $data['combo'] = $this->combo('entry');
        $data['combocabang'] = $this->combocabang('entry');

        return view('user.edit', compact('title', 'user', 'data'));
    }

    public function update(Request $request, $id)
    {
        $request['modifiedby']=Auth::user()->name;
        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ])->patch(config('app.api_url') . "user/$id", $request->all());

        return response($response);
    }

    public function delete($id)
    {
        try {
            $title = $this->title;

            $response = Http::withHeaders([
                'Accept' => 'application/json',
                'Content-Type' => 'application/json'
            ])->get(config('app.api_url') . "user/$id");

            $user = $response['data'];

            $data['combo'] = $this->combo('entry');
            $data['combocabang'] = $this->combocabang('entry');

            return view('user.delete', compact('title', 'user', 'data'));
        } catch (\Throwable $th) {
            return redirect()->route('user.index');
        }
    }

    public function destroy($id,Request $request)
    {
        $request['modifiedby']=Auth::user()->name;
        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Content-Type' => 'application/json'
        ])->delete(config('app.api_url') . "user/$id", $request->all());

        return response($response);
        
    }

    public function fieldLength()
    {
        $response = Http::withHeaders($this->httpHeader)->get(config('app.api_url') . 'user/field_length');

        return response($response['data']);
    }


    public function combo($aksi)
    {

        $status = [
            'status' => $aksi,
            'grp' => 'STATUS AKTIF',
            'subgrp' => 'STATUS AKTIF',
        ];

        $response = Http::withHeaders($this->httpHeader)
            ->get(config('app.api_url') . 'user/combostatus', $status);

        return $response['data'];
    }

    public function combocabang($aksi)
    {

        $status = [
            'status' => $aksi,
        ];

        $response = Http::withHeaders($this->httpHeader)
            ->get(config('app.api_url') . 'user/combocabang', $status);

        return $response['data'];
    }

    
}

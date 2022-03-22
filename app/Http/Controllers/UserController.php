<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;


class UserController extends MyController
{
    public $title = 'User';

    /**
     * @ClassName
     */
    public function index(Request $request)
    {
        $title = $this->title;
        $data = [
            'pagename' => 'Menu Utama User',
            'combo' => $this->combo('list'),
            'combocabang' => $this->combocabang('list'),
        ];
        
        return view('user.index', compact('title', 'data'));
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
            ->get(config('app.api_url') . 'user', $params);

        $data = [
            'total' => $response['attributes']['totalPages'] ?? [],
            'records' => $response['attributes']['totalRows'] ?? [],
            'rows' => $response['data'] ?? []
        ];

        return $data;
    }

    /**
     * @ClassName
     */
    public function create()
    {
        $title = $this->title;

        $data['combo'] = $this->combo('entry');
        $data['combocabang'] = $this->combocabang('entry');

        return view('user.add', compact('title', 'data'));
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
            ->post(config('app.api_url') . 'user', $request->all());

        return response($response);
    }

    /**
     * @ClassName
     */
    public function edit($id)
    {
        $title = $this->title;

        $response = Http::withHeaders($this->httpHeaders)
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . "user/$id");

        $user = $response['data'];

        $data['combo'] = $this->combo('entry');
        $data['combocabang'] = $this->combocabang('entry');

        return view('user.edit', compact('title', 'user', 'data'));
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
            ->patch(config('app.api_url') . "user/$id", $request->all());

        return response($response);
    }

    /**
     * @ClassName
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
                ->get(config('app.api_url') . "user/$id");

            $user = $response['data'];

            $data['combo'] = $this->combo('entry');
            $data['combocabang'] = $this->combocabang('entry');

            return view('user.delete', compact('title', 'user', 'data'));
        } catch (\Throwable $th) {
            return redirect()->route('user.index');
        }
    }

    /**
     * @ClassName
     */
    public function destroy($id, Request $request)
    {
        $request['modifiedby'] = Auth::user()->name;
        $response = Http::withHeaders($this->httpHeaders)
            ->withToken(session('access_token'))
            ->delete(config('app.api_url') . "user/$id", $request->all());

        return response($response);
    }

    /**
     * @ClassName
     */
    public function report(Request $request): View
    {
        $params['offset'] = $request->dari - 1;
        $params['rows'] = $request->sampai - $request->dari + 1;

        $users = $this->get($params)['rows'];

        return view('reports.user', compact('users'));
    }
    
    /**
     * @ClassName
     */
    public function export(Request $request): void
    {
        $params = [
            'offset' => $request->dari - 1,
            'rows' => $request->sampai - $request->dari + 1,
        ];

        $users = $this->get($params)['rows'];

        dd($users);
        $columns = [
            [
                'label' => 'No',
            ],
            [
                'label' => 'ID',
                'index' => 'id',
            ],
            [
                'label' => 'User',
                'index' => 'user',
            ],
            [
                'label' => 'Name',
                'index' => 'name',
            ],
            [
                'label' => 'Cabang id',
                'index' => 'cabang_id',
            ],
            [
                'label' => 'Karyawan id',
                'index' => 'karyawan_id',
            ],
            [
                'label' => 'Dashboard',
                'index' => 'dashboard',
            ],
            [
                'label' => 'Statusaktif',
                'index' => 'statusaktif',
            ],
        ];

        $this->toExcel($this->title, $users, $columns);
    }

    public function fieldLength()
    {
        $response = Http::withHeaders($this->httpHeaders)
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'user/field_length');

        return response($response['data']);
    }

    public function combo($aksi)
    {
        $status = [
            'status' => $aksi,
            'grp' => 'STATUS AKTIF',
            'subgrp' => 'STATUS AKTIF',
        ];

        $response = Http::withHeaders($this->httpHeaders)
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'user/combostatus', $status);

        return $response['data'];
    }

    public function getuserid(Request $request)
    {
        $status = [
            'user' => $request['user'],
        ];

        $response = Http::withHeaders($this->httpHeaders)
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'user/getuserid', $status);

        return $response['data'];
    }

    public function combocabang($aksi)
    {
        $status = [
            'status' => $aksi,
        ];

        $response = Http::withHeaders($this->httpHeaders)
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'user/combocabang', $status);

        return $response['data'];
    }
}

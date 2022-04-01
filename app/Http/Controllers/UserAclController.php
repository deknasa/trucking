<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use stdClass;

class UserAclController extends MyController
{
    public $title = 'User Acl';

    /**
     * @ClassName
     */
    public function index(Request $request)
    {
        $title = $this->title;

        return view('useracl.index', compact('title'));
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
            ->get(config('app.api_url') . 'useracl', $params);

        $data = [
            'total' => $response['attributes']['totalPages'] ?? [],
            'records' => $response['attributes']['totalRows'] ?? [],
            'rows' => $response['data'] ?? []
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
                ->get(config('app.api_url') . 'useracl/detail', $params);

            $data = [
                'total' => $response['attributes']['totalPages'] ?? [],
                'records' => $response['attributes']['totalRows'] ?? [],
                'rows' => $response['data'] ?? []
            ];

            return response($data);
        }
    }

    /**
     * @ClassName
     */
    public function create(Request $request)
    {
        $title = $this->title;

        $list = [
            'detail' => $this->detaillist($request->user_id  ?? '0'),
        ];

        $data['combo'] = $this->combo('entry');

        $user_id = '0';

        return view('useracl.add', compact('title', 'list', 'user_id', 'data'));
    }

    public function store(Request $request)
    {
        $request['modifiedby'] = Auth::user()->name;

        $response = Http::withHeaders($this->httpHeaders)->withOptions(['verify' => false])->withToken(session('access_token'))->post(config('app.api_url') . 'useracl', $request->all());

        return response($response);
    }

    /**
     * @ClassName
     */
    public function edit($id)
    {
        $title = $this->title;

        $response = Http::withHeaders($this->httpHeaders)->withOptions(['verify' => false])->withToken(session('access_token'))->get(config('app.api_url') . "useracl/$id");

        $useracl = $response['data'];

        $list = [
            'detail' => $this->detaillist($useracl['user_id']  ?? '0'),
        ];

        $data['combo'] = $this->combo('entry');

        $user_id = $useracl['user_id'];

        return view('useracl.edit', compact('title', 'useracl', 'list', 'user_id', 'data'));
    }

    public function update(Request $request, $id)
    {
        $request['modifiedby'] = Auth::user()->name;

        $response = Http::withHeaders($this->httpHeaders)->withOptions(['verify' => false])->withToken(session('access_token'))->patch(config('app.api_url') . "useracl/$id", $request->all());

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
            ])->get(config('app.api_url') . "useracl/$id");

            $useracl = $response['data'];

            $list = [
                'detail' => $this->detaillist($useracl['user_id']  ?? '0'),
            ];

            $data['combo'] = $this->combo('entry');

            $user_id = $useracl['user_id'];

            return view('useracl.delete', compact('title', 'useracl', 'list', 'user_id', 'data'));
        } catch (\Throwable $th) {
            return redirect()->route('useracl.index');
        }
    }

    public function destroy($id, Request $request)
    {
        $request['modifiedby'] = Auth::user()->name;

        $response = Http::withHeaders($this->httpHeaders)->withOptions(['verify' => false])->delete(config('app.api_url') . "useracl/$id", $request->all());

        return response($response);
    }

    public function fieldLength()
    {
        $response = Http::withHeaders($this->httpHeaders)->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'useracl/field_length');

        return response($response['data']);
    }

    public function detaillist($user_id)
    {
        $status = [
            'user_id' => $user_id,
        ];

        $response = Http::withHeaders($this->httpHeaders)->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'useracl/detaillist', $status);

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
            ->get(config('app.api_url') . 'useracl/combostatus', $status);

        return $response['data'];
    }

    /**
     * @ClassName
     */
    public function report(Request $request): View
    {
        $response = Http::withHeaders($this->httpHeaders)->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'useracl', $request->all());
        
        $useracls = $response['data'];

        return view('reports.useracl', compact('useracls'));
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

        $useracls = $this->get($params)['rows'];

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
        ];

        $this->toExcel($this->title, $useracls, $columns);
    }
}

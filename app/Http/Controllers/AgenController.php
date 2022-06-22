<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\View\View;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class AgenController extends MyController
{
    public $title = 'Agen';

      /**
     * Fungsi index
     * @ClassName index
     */
    public function index(Request $request)
    {
        $title = $this->title;
        $breadcrumb = $this->breadcrumb;
        $combo = [
            'statusaktif' => $this->getParameter('STATUS AKTIF', 'STATUS AKTIF'),
            'statusapproval' => $this->getParameter('STATUS APPROVAL', 'STATUS APPROVAL'),
            'statustas' => $this->getParameter('STATUS TAS', 'STATUS TAS'),
        ];

        return view('agen.index', compact('title', 'breadcrumb', 'combo'));
    }

    /**
     * @ClassName
     */
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
            ->get(config('app.api_url') . 'agen', $params);

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

   /**
     * Fungsi create
     * @ClassName create
     */
    public function create(): View
    {
        $title = $this->title;
        $breadcrumb = $this->breadcrumb;

        $combo = [
            'statusaktif' => $this->getParameter('STATUS AKTIF', 'STATUS AKTIF'),
            'statusapproval' => $this->getParameter('STATUS APPROVAL', 'STATUS APPROVAL'),
            'statustas' => $this->getParameter('STATUS TAS', 'STATUS TAS'),
        ];

        return view('agen.add', compact('title', 'breadcrumb', 'combo'));
    }

    /**
     * @ClassName
     */
    public function store(Request $request): Response
    {
        try {
            /* Unformat top */
            $request->top = str_replace('.', '', $request->top);
            $request->top = str_replace(',', '.', $request->top);

            $request->merge([
                'top' => $request->top
            ]);

            $request['modifiedby'] = Auth::user()->name;

            $response = Http::withHeaders([
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ])
                ->withToken(session('access_token'))
                ->post(config('app.api_url') . 'agen', $request->all());

            return response($response, $response->status());
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /**
     * Fungsi edit
     * @ClassName edit
     */
    public function edit($id): View
    {
        $title = $this->title;

        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Content-Type' => 'application/json'
        ])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . "agen/$id");

        $agen = $response['data'];

        $combo = [
            'statusaktif' => $this->getParameter('STATUS AKTIF', 'STATUS AKTIF'),
            'statusapproval' => $this->getParameter('STATUS APPROVAL', 'STATUS APPROVAL'),
            'statustas' => $this->getParameter('STATUS TAS', 'STATUS TAS'),
        ];

        return view('agen.edit', compact('title', 'agen', 'combo'));
    }

    public function update(Request $request, $id): Response
    {
        /* Unformat top */
        $request->top = str_replace('.', '', $request->top);
        $request->top = str_replace(',', '.', $request->top);

        $request->merge([
            'top' => $request->top
        ]);

        $request['modifiedby'] = Auth::user()->name;

        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ])
            ->withToken(session('access_token'))
            ->patch(config('app.api_url') . "agen/$id", $request->all());

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
            ])
                ->withToken(session('access_token'))
                ->get(config('app.api_url') . "agen/$id");

            $agen = $response['data'];

            $combo = [
                'statusaktif' => $this->getParameter('STATUS AKTIF', 'STATUS AKTIF'),
                'statusapproval' => $this->getParameter('STATUS APPROVAL', 'STATUS APPROVAL'),
                'statustas' => $this->getParameter('STATUS TAS', 'STATUS TAS'),
            ];

            return view('agen.delete', compact('title', 'agen', 'combo'));
        } catch (\Throwable $th) {
            return redirect()->route('agen.index');
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
            ->delete(config('app.api_url') . "agen/$id", $request->all());

        return response($response);
    }

    public function fieldLength(): Response
    {
        $response = Http::withHeaders($this->httpHeaders)->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'agen/field_length');

        return response($response['data']);
    }

    /**
     * @ClassName
     */
    public function report(Request $request): View
    {
        $response = Http::withHeaders($this->httpHeaders)->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'agen', $request->all());
        
        $agens = $response['data'];

        return view('reports.agen', compact('agens'));
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

        $agens = $this->get($params)['rows'];
        
        $columns = [
            [
                'label' => 'No',
            ],
            [
                'label' => 'Kode Agen',
                'index' => 'kodeagen',
            ],
            [
                'label' => 'Nama Agen',
                'index' => 'namaagen',
            ],
            [
                'label' => 'Keterangan',
                'index' => 'keterangan',
            ],
            [
                'label' => 'Status Aktif',
                'index' => 'statusaktif',
            ],
            [
                'label' => 'Nama Perusahaan',
                'index' => 'namaperusahaan',
            ],
            [
                'label' => 'Alamat',
                'index' => 'alamat',
            ],
            [
                'label' => 'No Telp',
                'index' => 'notelp',
            ],
            [
                'label' => 'No Hp',
                'index' => 'nohp',
            ],
            [
                'label' => 'Contact Person',
                'index' => 'contactperson',
            ],
            [
                'label' => 'TOP',
                'index' => 'top',
            ],
            [
                'label' => 'Status Approval',
                'index' => 'statusapproval',
            ],
            [
                'label' => 'User approval',
                'index' => 'userapproval',
            ],
            [
                'label' => 'Tgl Approval',
                'index' => 'tglapproval',
            ],
            [
                'label' => 'Status Tas',
                'index' => 'statustas',
            ],
            [
                'label' => 'Jenis Emkl',
                'index' => 'jenisemkl',
            ],
        ];

        $this->toExcel($this->title, $agens, $columns);
    }
}

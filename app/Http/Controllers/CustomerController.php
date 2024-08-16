<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\View\View;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class CustomerController extends MyController
{
    public $title = 'Customer';

    /**
     * Fungsi index
     * @ClassName index
     */
    public function index(Request $request)
    {
        $title = $this->title;
        
        $combo = [
            'statusaktif' => $this->getParameter('STATUS AKTIF', 'STATUS AKTIF'),
            'statusapproval' => $this->getParameter('STATUS APPROVAL', 'STATUS APPROVAL'),
            'statustas' => $this->getParameter('STATUS TAS', 'STATUS TAS'),
            'jenisemkl' => $this->getJenisEmkl(),
            'listbtn' => $this->getListBtn()
        ];

        return view('customer.index', compact('title', 'combo'));
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
            ->get(config('app.api_url') . 'customer', $params);

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
        

        $combo = [
            'statusaktif' => $this->getParameter('STATUS AKTIF', 'STATUS AKTIF'),
            'statustas' => $this->getParameter('STATUS TAS', 'STATUS TAS'),
            'jenisemkl' => $this->getJenisEmkl(),
        ];

        return view('customer.add', compact('title', 'combo'));
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

            $response = Http::withHeaders($this->httpHeaders)
                ->withOptions(['verify' => false])
                ->withToken(session('access_token'))
                ->post(config('app.api_url') . 'customer', $request->all());

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

        $response = Http::withHeaders($this->httpHeaders)
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . "customer/$id");

        $customer = $response['data'];

        $combo = [
            'statusaktif' => $this->getParameter('STATUS AKTIF', 'STATUS AKTIF'),
            'statustas' => $this->getParameter('STATUS TAS', 'STATUS TAS'),
            'jenisemkl' => $this->getJenisEmkl(),
        ];

        return view('customer.edit', compact('title', 'customer', 'combo'));
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

        $response = Http::withHeaders($this->httpHeaders)
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->patch(config('app.api_url') . "customer/$id", $request->all());

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
                ->get(config('app.api_url') . "customer/$id");

            $customer = $response['data'];

            $combo = [
                'statusaktif' => $this->getParameter('STATUS AKTIF', 'STATUS AKTIF'),
                'statustas' => $this->getParameter('STATUS TAS', 'STATUS TAS'),
                'jenisemkl' => $this->getJenisEmkl(),
            ];

            return view('customer.delete', compact('title', 'customer', 'combo'));
        } catch (\Throwable $th) {
            return redirect()->route('customer.index');
        }
    }

    /**
     * @ClassName
     */
    public function destroy($id, Request $request)
    {
        $request['modifiedby'] = Auth::user()->name;

        $response = Http::withHeaders($this->httpHeaders)
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->delete(config('app.api_url') . "customer/$id", $request->all());

        return response($response);
    }

    public function fieldLength(): Response
    {
        $response = Http::withHeaders($this->httpHeaders)
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'customer/field_length');

        return response($response['data']);
    }

    /**
     * @ClassName
     */
    public function report(Request $request): View
    {
        $response = Http::withHeaders($this->httpHeaders)
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'customer', $request->all());

        $customers = $response['data'];

        $i = 0;
        foreach ($customers as $index => $params) {

            $statusaktif = $params['statusaktif'];
            $statusApproval = $params['statusapproval'];
            $statusTas = $params['statustas'];

            $result = json_decode($statusaktif, true);
            $resultApproval = json_decode($statusApproval, true);
            $resultTas = json_decode($statusTas, true);

            $statusaktif = $result['MEMO'];
            $statusApproval = $resultApproval['MEMO'];
            $statusTas = $resultTas['MEMO'];

            $customers[$i]['statusaktif'] = $statusaktif;
            $customers[$i]['statusapproval'] = $statusApproval;
            $customers[$i]['statustas'] = $statusTas;
            $i++;
        }

        return view('reports.customer', compact('customers'));
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

        $customers = $this->get($params)['rows'];

        $columns = [
            [
                'label' => 'No',
            ],
            [
                'label' => 'Kode customer',
                'index' => 'kodecustomer',
            ],
            [
                'label' => 'Nama customer',
                'index' => 'namacustomer',
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
                'label' => 'No Telepon',
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

        $this->toExcel($this->title, $customers, $columns);
    }
}

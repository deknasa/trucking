<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\View\View;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;


class PenerimaanHeaderController extends MyController
{
    public $title = 'penerimaan';

    /**
     * @ClassName
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

        return view('penerimaan.index', compact('title', 'breadcrumb', 'combo'));
    }

    // /**
    //  * Fungsi get
    //  * @ClassName get
    //  */
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
            ->get(config('app.api_url') . 'penerimaan', $params);

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
        
        $combo = $this->combo();

        return view('penerimaan.add', compact('title', 'breadcrumb', 'combo'));
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
            ->get(config('app.api_url') . "penerimaan/$id");
        $penerimaan = $response['data'];

        $combo = $this->combo();

        return view('penerimaan.edit', compact('title', 'penerimaan', 'combo'));
    }

    // /**
    //  * Fungsi delete
    //  * @ClassName delete
    //  */
    public function delete($id)
    {
        try {
            $title = $this->title;

            $response = Http::withHeaders($this->httpHeaders)
                ->withOptions(['verify' => false])
                ->withToken(session('access_token'))
                ->get(config('app.api_url') . "penerimaan/$id");

            $penerimaan = $response['data'];
            $combo = $this->combo();

            return view('penerimaan.delete', compact('title', 'combo', 'penerimaan'));
        } catch (\Throwable $th) {
            return redirect()->route('penerimaan.index');
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
            ->delete(config('app.api_url') . "agen/$id", $request->all());

        return response($response);
    }

    public function fieldLength(): Response
    {
        $response = Http::withHeaders($this->httpHeaders)
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'agen/field_length');

        return response($response['data']);
    }

    // /**
    //  * Fungsi getNoBukti
    //  * @ClassName getNoBukti
    //  */
    public function getNoBukti($group, $subgroup, $table)
    {
        $params = [
            'group' => $group,
            'subgroup' => $subgroup,
            'table' => $table
        ];

        $response = Http::withHeaders($this->httpHeaders)
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . "running_number", $params);

        $noBukti = $response['data'] ?? 'No bukti tidak ditemukan';

        return $noBukti;
    }

    // /**
    //  * Fungsi combo
    //  * @ClassName combo
    //  */
    private function combo()
    {
        $response = Http::withHeaders($this->httpHeaders)
            ->withToken(session('access_token'))
            ->withOptions(['verify' => false])
            ->get(config('app.api_url') . 'penerimaan/combo');
        return $response['data'];
    }

}
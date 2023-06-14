<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use stdClass;

class OrderanTruckingController extends MyController
{
    public $title = 'Orderan Trucking';

    /**
     * @ClassName
     */
    public function index(Request $request)
    {
        $title = $this->title;
        
        $data = [
            'combolangsir' => $this->combo('list','STATUS LANGSIR','STATUS LANGSIR'),
            'comboperalihan' => $this->combo('list','STATUS PERALIHAN','STATUS PERALIHAN'),

        ];

        
        return view('orderantrucking.index', compact('title', 'data'));   
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
            ->get(config('app.api_url') . 'orderantrucking', $params);

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
     * @ClassName
     */
    public function create(): View
    {
        $title = $this->title;
        $combo = $this->combo();

        return view('orderantrucking.add', compact('title','combo'));
    }


    public function fieldLength(): Response
    {
        $response = Http::withHeaders($this->httpHeaders)
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'orderantrucking/field_length');

        return response($response['data']);
    }


    public function combo($aksi, $grp, $subgrp)
    {

        $status = [
            'status' => $aksi,
            'grp' => $grp,
            'subgrp' => $subgrp,
        ];

        $response = Http::withHeaders($this->httpHeaders)
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'parameter/combolist', $status);

        return $response['data'];
        
                
    }

    public function export(Request $request):void
    {
        //FETCH HEADER
        $id = $request->id;
        $data = Http::withHeaders($request->header())
        ->withOptions(['verify' => false])
        ->withToken(session('access_token'))
        ->get(config('app.api_url') .'orderantrucking/'.$id.'/export');

        $orderantrucking = $data['data'];

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', $orderantrucking['judul']);
        $sheet->setCellValue('A2', $orderantrucking['judulLaporan']);
        $sheet->getStyle("A1")->getFont()->setSize(14);
        $sheet->getStyle("A2")->getFont()->setSize(12);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal('center');
        $sheet->getStyle('A2')->getAlignment()->setHorizontal('center');
        $sheet->mergeCells('A1:B1');
        $sheet->mergeCells('A2:B2');

        $writer = new Xlsx($spreadsheet);
        $filename = 'Laporan Orderan Trucking  ' . date('dmYHis');
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }

}

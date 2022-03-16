<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class LogTrailController extends MyController
{
    public $title = 'Logtrail';

    /**
     * Fungsi index
     * @ClassName index
     */
    public function index(Request $request)
    {
        $title = $this->title;
        $breadcrumb = $this->breadcrumb;

        return view('logtrail.index', compact('title', 'breadcrumb'));
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
            ->get(config('app.api_url') . 'logtrail', $params);

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

        return view('logtrail.add', compact('title', 'breadcrumb'));
    }

    public function store(Request $request): Response
    {
        try {
            $request['modifiedby'] = Auth::user()->name;

            $response = Http::withHeaders([
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ])
                ->withToken(session('access_token'))
                ->post(config('app.api_url') . 'logtrail', $request->all());

            return response($response, $response->status());
        } catch (\Throwable $th) {
            throw $th->getMessage();
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
            ->get(config('app.api_url') . "logtrail/$id");

        $logtrail = $response['data'];

        return view('logtrail.edit', compact('title', 'logtrail'));
    }

    public function update(Request $request, $id): Response
    {
        $request['modifiedby'] = Auth::user()->name;

        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ])
            ->withToken(session('access_token'))
            ->patch(config('app.api_url') . "logtrail/$id", $request->all());

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
                ->get(config('app.api_url') . "logtrail/$id");

            $logtrail = $response['data'];

            return view('logtrail.delete', compact('title', 'logtrail'));
        } catch (\Throwable $th) {
            return redirect()->route('logtrail.index');
        }
    }

    public function destroy($id, Request $request)
    {
        $request['modifiedby'] = Auth::user()->name;

        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Content-Type' => 'application/json'
        ])
            ->withToken(session('access_token'))
            ->delete(config('app.api_url') . "logtrail/$id", $request->all());

        return response($response);
    }

    public function fieldLength(): Response
    {
        $response = Http::withHeaders($this->httpHeaders)
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'logtrail/field_length');

        return response($response['data']);
    }

    public function report(Request $request): View
    {
        $params['offset'] = $request->dari - 1;
        $params['rows'] = $request->sampai - $request->dari + 1;

        $parameters = $this->get($params)['rows'];

        return view('reports.logtrail', compact('parameters'));
    }

    public function export(Request $request): void
    {
        $params = [
            'offset' => $request->dari - 1,
            'rows' => $request->sampai - $request->dari + 1,
        ];

        $parameters = $this->get($params);

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'Laporan Logtrail');
        $sheet->getStyle("A1")->getFont()->setSize(20);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal('center');
        $sheet->mergeCells('A1:E1');

        $sheet->setCellValue('A2', 'No');
        $sheet->setCellValue('B2', 'ID');
        $sheet->setCellValue('C2', 'Group');
        $sheet->setCellValue('D2', 'Sub Group');
        $sheet->setCellValue('E2', 'Nama Logtrail');
        $sheet->setCellValue('F2', 'Memo');
        $sheet->setCellValue('G2', 'ModifiedBy');
        $sheet->setCellValue('H2', 'ModifiedOn');

        $sheet->getColumnDimension('C')->setAutoSize(true);
        $sheet->getColumnDimension('D')->setAutoSize(true);
        $sheet->getColumnDimension('E')->setAutoSize(true);
        $sheet->getColumnDimension('F')->setAutoSize(true);
        $sheet->getColumnDimension('G')->setAutoSize(true);
        $sheet->getColumnDimension('H')->setAutoSize(true);

        $no = 1;
        $x = 3;
        foreach ($parameters['rows'] as $row) {
            $sheet->setCellValue('A' . $x, $no++);
            $sheet->setCellValue('B' . $x, $row['id']);
            $sheet->setCellValue('C' . $x, $row['grp']);
            $sheet->setCellValue('D' . $x, $row['subgrp']);
            $sheet->setCellValue('E' . $x, $row['text']);
            $sheet->setCellValue('F' . $x, $row['memo']);
            $sheet->setCellValue('G' . $x, $row['modifiedby']);
            $sheet->setCellValue('H' . $x,  date("d-m-Y H:i:s", strtotime($row['updated_at'])));
            $lastCell = 'H' . $x;
            $x++;
        }

        $sheet->setCellValue('E' . $x, "=ROWS(E3:" . $lastCell . ")");

        $styleArray = array(
            'borders' => array(
                'allBorders' => array(
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ),
            ),
        );

        $sheet->getStyle('A2:H2')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('FF02c4f5');
        $sheet->getStyle('A2:' . $lastCell)->applyFromArray($styleArray);

        $writer = new Xlsx($spreadsheet);
        $filename = 'laporanParameter' . date('dmYHis');

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }

    public function header(Request $request)
    {
        $params = [
            'id' => $request->id
        ];

        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Content-Type' => 'application/json'
        ])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . "logtrail/header", $params);

        $data = [
            'total' => $response['attributes']['totalPages'] ?? [],
            'records' => $response['attributes']['totalRows'] ?? [],
            'rows' => $response['data'] ?? [],
            'params' => $params ?? [],
            'message' => $response['message'] ?? ''
        ];

        return response($data, $response->status());
    }

    public function detail(Request $request)
    {
        $params = [
            'id' => $request->id
        ];

        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Content-Type' => 'application/json'
        ])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . "logtrail/detail", $params);

        $data = [
            'total' => $response['attributes']['totalPages'] ?? [],
            'records' => $response['attributes']['totalRows'] ?? [],
            'rows' => $response['data'] ?? [],
            'params' => $params ?? [],
            'message' => $response['message'] ?? ''
        ];

        return response($data, $response->status());
    }
}

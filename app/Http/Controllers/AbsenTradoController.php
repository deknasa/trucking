<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class AbsenTradoController extends MyController
{
    public $title = 'Absen Trado';

    
    /**
     * @ClassName
     */
    public function index(Request $request)
    {
        $title = $this->title;
        
        $data = [
            'combo' => $this->combo('list'),
            'listbtn' => $this->getListBtn()
        ];

        return view('absentrado.index', compact('title', 'data'));
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
            ->get(config('app.api_url') . 'absen_trado', $params);

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
        
        $combo = [
            'status' => $this->getParameter('STATUS AKTIF', 'STATUS AKTIF'),
        ];

        return view('absentrado.add', compact('title', 'combo'));
    }

    /**
     * @ClassName
     */
    public function store(Request $request): Response
    {
        try {
            $request['modifiedby'] = Auth::user()->name;

            $response = Http::withHeaders([
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ])
                ->withToken(session('access_token'))
                ->post(config('app.api_url') . 'absen_trado', $request->all());

            return response($response, $response->status());
        } catch (\Throwable $th) {
            throw $th->getMessage();
        }
    }

    /**
     * @ClassName
     */
    public function edit($id): View
    {
        $title = $this->title;

        $response = Http::withHeaders($this->httpHeaders)
        ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . "absen_trado/$id");

        $absenTrado = $response['data'];

        $combo = [
            'status' => $this->getParameter('STATUS AKTIF', 'STATUS AKTIF'),
        ];

        return view('absentrado.edit', compact('title', 'absenTrado', 'combo'));
    }

    /**
     * @ClassName
     */
    public function update(Request $request, $id): Response
    {
        $request['modifiedby'] = Auth::user()->name;

        $response = Http::withHeaders($this->httpHeaders)->withOptions(['verify' => false])
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->patch(config('app.api_url') . "absen_trado/$id", $request->all());

        return response($response, $response->status());
    }

    /**
     * @ClassName
     */
    public function delete($id)
    {
        try {
            $title = $this->title;

            $response = Http::withHeaders($this->httpHeaders)->withOptions(['verify' => false])
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
                ->get(config('app.api_url') . "absen_trado/$id");

            $absenTrado = $response['data'];



            $combo = [
                'status' => $this->getParameter('STATUS AKTIF', 'STATUS AKTIF'),
            ];
            
            return view('absentrado.delete', compact('title', 'absenTrado', 'combo'));
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /**
     * @ClassName
     */
    public function destroy($id, Request $request)
    {
        $request['modifiedby'] = Auth::user()->name;
        $response = Http::withHeaders($this->httpHeaders)->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->delete(config('app.api_url') . "absen_trado/$id", $request->all());

        return response($response, $response->status());
    }

    public function fieldLength(): Response
    {
        $response = Http::withHeaders($this->httpHeaders)->withOptions(['verify' => false])
        ->withOptions(['verify' => false])
        ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'absen_trado/field_length');

        return response($response['data']);
    }

    /**
     * @ClassName
     */
    public function report(Request $request)
    {
        $response = Http::withHeaders($this->httpHeaders)
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'absentrado', $request->all());

        $absentrados = $response['data'];

        $i = 0;
        foreach ($absentrados as $index => $params) {

            $statusaktif = $params['statusaktif'];

            $result = json_decode($statusaktif, true);

            $statusaktif = $result['MEMO'];

            $absentrados[$i]['statusaktif'] = $statusaktif;

        
            $i++;


        }

        return view('reports.absentrado', compact('absentrados'));
    }

    /**
     * @ClassName
     */
    // public function export(Request $request): void
    // {

    //     $params = [
    //         'offset' => $request->dari - 1,
    //         'rows' => $request->sampai - $request->dari + 1,
    //     ];

    //     $absenTrados = $this->get($params);

    //     $spreadsheet = new Spreadsheet();
    //     $sheet = $spreadsheet->getActiveSheet();
    //     $sheet->setCellValue('A1', 'Laporan AbsenTrado');
    //     $sheet->getStyle("A1")->getFont()->setSize(20);
    //     $sheet->getStyle('A1')->getAlignment()->setHorizontal('center');
    //     $sheet->mergeCells('A1:E1');

    //     $sheet->setCellValue('A2', 'No');
    //     $sheet->setCellValue('B2', 'ID');
    //     $sheet->setCellValue('C2', 'Kode Absen');
    //     $sheet->setCellValue('D2', 'Keterangan');
    //     $sheet->setCellValue('E2', 'Status');
    //     $sheet->setCellValue('F2', 'ModifiedBy');
    //     $sheet->setCellValue('G2', 'ModifiedOn');

    //     $sheet->getColumnDimension('C')->setAutoSize(true);
    //     $sheet->getColumnDimension('D')->setAutoSize(true);
    //     $sheet->getColumnDimension('E')->setAutoSize(true);
    //     $sheet->getColumnDimension('F')->setAutoSize(true);
    //     $sheet->getColumnDimension('G')->setAutoSize(true);

    //     $no = 1;
    //     $x = 3;
    //     foreach ($absenTrados['rows'] as $row) {
    //         $sheet->setCellValue('A' . $x, $no++);
    //         $sheet->setCellValue('B' . $x, $row['id']);
    //         $sheet->setCellValue('C' . $x, $row['kodeabsen']);
    //         $sheet->setCellValue('D' . $x, $row['keterangan']);
    //         $sheet->setCellValue('E' . $x, $row['statusaktif']);
    //         $sheet->setCellValue('F' . $x, $row['modifiedby']);
    //         $sheet->setCellValue('G' . $x, date("d-m-Y H:i:s", strtotime($row['updated_at'])));
    //         $lastCell = 'G' . $x;
    //         $x++;
    //     }

    //     $sheet->setCellValue('E' . $x, "=ROWS(E3:" . $lastCell . ")");

    //     $styleArray = array(
    //         'borders' => array(
    //             'allBorders' => array(
    //                 'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
    //             ),
    //         ),
    //     );

    //     $sheet->getStyle('A2:G2')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('FF02c4f5');
    //     $sheet->getStyle('A2:' . $lastCell)->applyFromArray($styleArray);

    //     $writer = new Xlsx($spreadsheet);
    //     $filename = 'laporanAbsenTrado' . date('dmYHis');

    //     header('Content-Type: application/vnd.ms-excel');
    //     header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
    //     header('Cache-Control: max-age=0');

    //     $writer->save('php://output');
    // }

    public function combo($aksi)
    {

        $status = [
            'status' => $aksi,
            'grp' => 'STATUS AKTIF',
            'subgrp' => 'STATUS AKTIF',
        ];

        $response = Http::withHeaders($this->httpHeaders)
        ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'user/combostatus', $status);

        return $response['data'];
    }

    public function getStatus(): array
    {
        return (new ParameterController)->get([
            'filters' => json_encode([
                'groupOp' => 'AND',
                'rules' => [
                    [
                        'field' => 'grp',
                        'data' => 'STATUS AKTIF',
                    ],
                    [
                        'field' => 'subgrp',
                        'data' => 'STATUS AKTIF',
                    ],
                ],
            ]),
        ])['rows'];
    }
}

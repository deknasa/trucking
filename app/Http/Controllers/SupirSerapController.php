<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class SupirSerapController extends MyController
{
    public $title = 'Supir Serap';

    public function index(Request $request)
    {
        $title = $this->title;
        $data = [
            'combo' => $this->comboList('list', 'STATUS APPROVAL', 'STATUS APPROVAL'),
        ];

        return view('supirserap.index', compact('title', 'data'));
    }

    public function comboList($aksi, $grp, $subgrp)
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

    public function report(Request $request)
    {
        $supirSerap = Http::withHeaders($request->header())
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'supirserap/export?forReport=true&dari=' . $request->dari . '&sampai=' . $request->sampai);
        $data = $supirSerap['data'];
        $judul = $supirSerap['judul'];
        return view('reports.supirserap', compact('data', 'judul'));
    }

    public function export(Request $request): void
    {
        $supirSerap = Http::withHeaders($request->header())
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'supirserap/export?forReport=true&dari=' . $request->dari . '&sampai=' . $request->sampai);
        $data = $supirSerap['data'];
        if (count($data) == 0) {
            throw new \Exception('TIDAK ADA DATA');
        }

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1',  $supirSerap['judul']);
        $sheet->getStyle("A1")->getFont()->setSize(16)->setBold(true);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal('center');
        $sheet->mergeCells('A1:I1');

        $sheet->setCellValue('A2', 'LAPORAN SUPIR SERAP');
        $sheet->setCellValue('A3', 'Dari : ' . $request->dari);
        $sheet->setCellValue('A4', 'Sampai : ' . $request->sampai);
        $sheet->getStyle("A2:A4")->getFont()->setBold(true);
        $detail_table_header_row = 6;
        $detail_start_row = $detail_table_header_row + 1;

        $styleArray = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
            ],
        ];

        $alphabets = range('A', 'Z');
        $detail_columns = [
            [
                'label' => 'NO'
            ],
            [
                'label' => 'TGL ABSENSI',
                'index' => 'tglabsensi',
            ],
            [
                'label' => 'TRADO',
                'index' => 'trado_id',
            ],
            [
                'label' => 'SUPIR',
                'index' => 'supir_id',
            ],
            [
                'label' => 'SUPIR SERAP',
                'index' => 'supirserap_id',
            ],
            // [
            //     'label' => 'Status Approval',
            //     'index' => 'statusapproval',
            // ],
            // [
            //     'label' => 'User Approval',
            //     'index' => 'userapproval',
            // ],
            // [
            //     'label' => 'Tgl Approval',
            //     'index' => 'tglapproval',
            // ],
        ];

        foreach ($detail_columns as $detail_columns_index => $detail_column) {
            $sheet->setCellValue($alphabets[$detail_columns_index] . $detail_table_header_row, $detail_column['label'] ?? $detail_columns_index + 1);
        }
        $sheet->getStyle("A$detail_table_header_row:E$detail_table_header_row")->applyFromArray($styleArray)->getFont()->setBold(true);
        $no = 1;
        foreach ($data as $response_index => $response_detail) {

            $dateValue = ($response_detail['tglabsensi'] != null) ? Date::PHPToExcel(date('Y-m-d', strtotime($response_detail['tglabsensi']))) : '';
            $tglApproval = ($response_detail['tglapproval'] != null) ? Date::PHPToExcel(date('Y-m-d', strtotime($response_detail['tglapproval']))) : '';
            $sheet->setCellValue("A$detail_start_row", $no++);
            $sheet->setCellValue("B$detail_start_row", $dateValue);
            $sheet->setCellValue("C$detail_start_row", $response_detail['trado_id']);
            $sheet->setCellValue("D$detail_start_row", $response_detail['supir_id']);
            $sheet->setCellValue("E$detail_start_row", $response_detail['supirserap_id']);
            // $sheet->setCellValue("F$detail_start_row", $response_detail['statusapprovaltext']);
            // $sheet->setCellValue("G$detail_start_row", $response_detail['userapproval']);
            // $sheet->setCellValue("H$detail_start_row", $tglApproval);



            $sheet->getStyle("A$detail_start_row:E$detail_start_row")->applyFromArray($styleArray);
            $sheet->getStyle("B$detail_start_row")->getNumberFormat()->setFormatCode('dd-mm-yyyy');
            // $sheet->getStyle("H$detail_start_row")->getNumberFormat()->setFormatCode('dd-mm-yyyy');
            $detail_start_row++;
        }

        $sheet->getColumnDimension('A')->setWidth(5);
        $sheet->getColumnDimension('B')->setAutoSize(true);
        $sheet->getColumnDimension('C')->setAutoSize(true);
        $sheet->getColumnDimension('D')->setAutoSize(true);
        $sheet->getColumnDimension('E')->setAutoSize(true);
        $sheet->getColumnDimension('F')->setAutoSize(true);
        $sheet->getColumnDimension('G')->setAutoSize(true);
        $sheet->getColumnDimension('H')->setAutoSize(true);

        $writer = new Xlsx($spreadsheet);
        $filename = 'LAPORAN SUPIR SERAP ' . date('dmYHis');
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class ReminderOliController extends MyController
{
    public $title = 'Reminder Pergantian Oli';

    public function index()
    {
        $title = $this->title;
        $data = [
            'combo' => $this->combo('list')
        ];

        return view('reminderoli.index',compact('title','data'));
    }
    
    public function combo($aksi)
    {

        $status = [
            'status' => $aksi,
            'grp' => 'STATUS PERGANTIAN',
            'subgrp' => 'STATUS PERGANTIAN',
        ];

        $response = Http::withHeaders($this->httpHeaders)
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'cabang/combostatus', $status);

        return $response['data'];
    }

    // public function export(Request $request): void
    // {
    //     $detailParams = [
    //         'forExport' => true,
    //         'status' => $request->status
    //     ];
    //     $header = Http::withHeaders(request()->header())
    //         ->withOptions(['verify' => false])
    //         ->withToken(session('access_token'))
    //         ->get(config('app.api_url') . 'reminderoli', $detailParams);

    //     $data = $header['data'];
    //     if(count($data) == 0){
    //         throw new \Exception('TIDAK ADA DATA');
    //     }
    //     $spreadsheet = new Spreadsheet();
    //     $sheet = $spreadsheet->getActiveSheet();
    //     $sheet->setCellValue('A1', $data[0]['judul']);
    //     $sheet->getStyle("A1")->getFont()->setSize(16);
    //     $sheet->getStyle('A1')->getAlignment()->setHorizontal('center');
    //     $sheet->mergeCells('A1:F1');

    //     $sheet->setCellValue('A2', $data[0]['judulLaporan']);
    //     $sheet->getStyle("A2")->getFont()->setSize(12);
    //     $sheet->getStyle('A2')->getAlignment()->setHorizontal('center');
    //     $sheet->mergeCells('A2:F2');

    //     $detail_table_header_row = 5;
    //     $detail_start_row = 6;

    //     $styleArray = array(
    //         'borders' => array(
    //             'allBorders' => array(
    //                 'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
    //             ),
    //         ),
    //     );

    //     $style_number = [
    //         'alignment' => [
    //             'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT,
    //         ],

    //         'borders' => [
    //             'top' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
    //             'right' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
    //             'bottom' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
    //             'left' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN]
    //         ]
    //     ];


    //     $alphabets = range('A', 'Z');

    //     $detail_columns = [
    //         [
    //             'label' => 'No',
    //             'index' => '',
    //         ],
    //         [
    //             'label' => 'No Pol',
    //             'index' => 'nopol',
    //         ],
    //         [
    //             'label' => 'Tanggal',
    //             'index' => 'tanggal',
    //         ],
    //         [
    //             'label' => 'Status Reminder',
    //             'index' => 'status',
    //         ],
    //         [
    //             'label' => 'KM',
    //             'index' => 'km'
    //         ],
    //         [
    //             'label' => 'KM Perjalanan',
    //             'index' => 'kmperjalanan'
    //         ]
    //     ];


    //     foreach ($detail_columns as $detail_columns_index => $detail_column) {
    //         $sheet->setCellValue($alphabets[$detail_columns_index] . $detail_table_header_row, $detail_column['label'] ?? $detail_columns_index + 1);
    //     }
    //     $sheet->getStyle("A$detail_table_header_row:F$detail_table_header_row")->applyFromArray($styleArray)->getFont()->setBold(true);

    //     // LOOPING DETAIL
    //     $dataRow = $detail_table_header_row + 2;
    //     $previousRow = $dataRow - 1; // Initialize the previous row number
    //     $a = 1;
    //     foreach ($data as $response_index => $response_detail) {

    //         // foreach ($detail_columns as $detail_columns_index => $detail_column) {
    //         //     $sheet->setCellValue($alphabets[$detail_columns_index] . $detail_start_row, isset($detail_column['index']) ? $response_detail[$detail_column['index']] : $response_index + 1);
    //         // }

    //         $sheet->setCellValue("A$detail_start_row", $a);
    //         $sheet->setCellValue("B$detail_start_row", $response_detail['nopol']);
    //         $sheet->setCellValue("C$detail_start_row", date('d-m-Y', strtotime($response_detail['tanggal'])));
    //         $sheet->setCellValue("D$detail_start_row", $response_detail['status']);
    //         $sheet->setCellValue("E$detail_start_row", $response_detail['km']);
    //         $sheet->setCellValue("F$detail_start_row", $response_detail['kmperjalanan']);

           

    //         $sheet->getStyle("A$detail_start_row:F$detail_start_row")->applyFromArray($styleArray);
    //         $sheet->getStyle("E$detail_start_row:F$detail_start_row")->applyFromArray($style_number)->getNumberFormat()->setFormatCode("#,##0.00");

    //         $a++;
    //         $dataRow++;
    //         $detail_start_row++;
    //     }

    //     $sheet->getColumnDimension('A')->setAutoSize(true);
    //     $sheet->getColumnDimension('B')->setAutoSize(true);
    //     $sheet->getColumnDimension('C')->setAutoSize(true);
    //     $sheet->getColumnDimension('D')->setAutoSize(true);
    //     $sheet->getColumnDimension('E')->setAutoSize(true);
    //     $sheet->getColumnDimension('F')->setAutoSize(true);

    //     $writer = new Xlsx($spreadsheet);
    //     $filename = 'Laporan Reminder Oli' . date('dmYHis');
    //     header('Content-Type: application/vnd.ms-excel');
    //     header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
    //     header('Cache-Control: max-age=0');

    //     $writer->save('php://output');
    // }
}

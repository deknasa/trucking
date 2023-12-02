<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class InvoiceLunasKePusatController extends MyController
{
    public $title = 'Invoice Lunas Ke Pusat';

    public function index()
    {

        $title = $this->title;
        $data = [
            'combo' => $this->combo('list'),
        ];

        return view('invoicelunaskepusat.index', compact('title', 'data'));
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
            ->get(config('app.api_url') . 'user/combostatus', $status);

        return $response['data'];
    }

    public function export(Request $request): void
    {
        //FETCH HEADER
        $detailParams = [
            'periode' => $request->periode,
            'limit' => 0,
            'sortIndex' => 'invoiceheader_id'
        ];
        $getData = Http::withHeaders($request->header())
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'invoicelunaskepusat/export', $detailParams);
        $data = $getData['data'];

        $bulan = $this->getBulan(substr($request->periode, 0, 2));
        $tahun = substr($request->periode, 3, 4);

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', $getData['judul']);
        $sheet->getStyle("A1")->getFont()->setSize(16)->setBold(true);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal('center');
        $sheet->mergeCells('A1:G1');

        $sheet->setCellValue('A2', 'LAPORAN INVOICE LUNAS KE PUSAT');
        $sheet->setCellValue('A3', 'PERIODE : ' . $bulan . ' - ' . $tahun);

        $sheet->getStyle("A2")->getFont()->setBold(true);
        $sheet->getStyle("A3:B3")->getFont()->setBold(true);

        $detail_table_header_row = 5;
        $detail_start_row = $detail_table_header_row + 1;

        $styleArray = array(
            'borders' => array(
                'allBorders' => array(
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ),
            ),
        );

        $style_number = [
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT,
            ],

            'borders' => [
                'top' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
                'right' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
                'bottom' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
                'left' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN]
            ]
        ];

        $alphabets = range('A', 'Z');

        $detail_columns = [
            [
                'label' => 'TGL BUKTI',
                'index' => 'tglbukti',
            ],
            [
                'label' => 'NO BUKTI',
                'index' => 'nobukti',
            ],
            [
                'label' => 'CUSTOMER',
                'index' => 'agen_id',
            ],
            [
                'label' => 'NOMINAL',
                'index' => 'nominal'
            ],
            [
                'label' => 'TGL BAYAR',
                'index' => 'tglbayar',
            ],
            [
                'label' => 'BAYAR',
                'index' => 'bayar'
            ],
            [
                'label' => 'SISA',
                'index' => 'sisa'
            ]
        ];


        foreach ($detail_columns as $detail_columns_index => $detail_column) {
            $sheet->setCellValue($alphabets[$detail_columns_index] . $detail_table_header_row, $detail_column['label'] ?? $detail_columns_index + 1);
        }
        $sheet->getStyle("A$detail_table_header_row:G$detail_table_header_row")->applyFromArray($styleArray)->getFont()->setBold(true);

        foreach ($data as $response_index => $response_detail) {


            $dateValue = ($response_detail['tglbukti'] != null) ? Date::PHPToExcel(date('Y-m-d', strtotime($response_detail['tglbukti']))) : '';
            $tglBayar = ($response_detail['tglbayar'] != null) ? Date::PHPToExcel(date('Y-m-d', strtotime($response_detail['tglbayar']))) : '';

            $sheet->setCellValue("A$detail_start_row", $dateValue);
            $sheet->setCellValue("B$detail_start_row", $response_detail['nobukti']);
            $sheet->setCellValue("C$detail_start_row", $response_detail['agen_id']);
            $sheet->setCellValue("D$detail_start_row", $response_detail['nominal']);
            $sheet->setCellValue("E$detail_start_row", $tglBayar);
            $sheet->setCellValue("F$detail_start_row", $response_detail['bayar']);

            $rumus = "=D$detail_start_row-F$detail_start_row";
            $sheet->setCellValue("G$detail_start_row", $rumus);


            $sheet->getStyle("A$detail_start_row:G$detail_start_row")->applyFromArray($styleArray);
            $sheet->getStyle("D$detail_start_row")->applyFromArray($style_number)->getNumberFormat()->setFormatCode("#,##0.00_);(#,##0.00)");
            $sheet->getStyle("F$detail_start_row:G$detail_start_row")->applyFromArray($style_number)->getNumberFormat()->setFormatCode("#,##0.00_);(#,##0.00)");
            $sheet->getStyle("A$detail_start_row")->getNumberFormat()->setFormatCode('dd-mm-yyyy');
            $sheet->getStyle("E$detail_start_row")->getNumberFormat()->setFormatCode('dd-mm-yyyy');

            $detail_start_row++;
        }

        $sheet->getStyle("A$detail_start_row:G$detail_start_row")->applyFromArray($styleArray);
        $sheet->mergeCells('A' . $detail_start_row . ':C' . $detail_start_row);
        $sheet->setCellValue("A$detail_start_row", 'Total')->getStyle('A' . $detail_start_row . ':C' . $detail_start_row)->applyFromArray($styleArray)->getFont()->setBold(true);

        $sheet->setCellValue("D$detail_start_row", "=SUM(D6:D" . ($detail_start_row - 1) . ")")->getStyle("D$detail_start_row")->applyFromArray($style_number)->getFont()->setBold(true);
        $sheet->setCellValue("F$detail_start_row", "=SUM(F6:F" . ($detail_start_row - 1) . ")")->getStyle("F$detail_start_row")->applyFromArray($style_number)->getFont()->setBold(true);

        $sheet->setCellValue("G$detail_start_row",  "=SUM(G6:G" . ($detail_start_row - 1) . ")")->getStyle("G$detail_start_row")->applyFromArray($style_number)->getFont()->setBold(true);

        $sheet->getStyle("D$detail_start_row")->getNumberFormat()->setFormatCode("#,##0.00_);(#,##0.00)");
        $sheet->getStyle("F$detail_start_row")->getNumberFormat()->setFormatCode("#,##0.00_);(#,##0.00)");
        $sheet->getStyle("G$detail_start_row")->getNumberFormat()->setFormatCode("#,##0.00_);(#,##0.00)");

        $sheet->getColumnDimension('A')->setWidth(12);
        $sheet->getColumnDimension('B')->setAutoSize(true);
        $sheet->getColumnDimension('C')->setAutoSize(true);
        $sheet->getColumnDimension('D')->setAutoSize(true);
        $sheet->getColumnDimension('E')->setAutoSize(true);
        $sheet->getColumnDimension('F')->setAutoSize(true);
        $sheet->getColumnDimension('G')->setAutoSize(true);

        $writer = new Xlsx($spreadsheet);
        $filename = 'LAPORAN INVOICE LUNAS KE PUSAT' . date('dmYHis');
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }

    public function getBulan($bln)
    {
        switch ($bln) {
            case 1:
                return "JANUARI";
                break;
            case 2:
                return "FEBRUARI";
                break;
            case 3:
                return "MARET";
                break;
            case 4:
                return "APRIL";
                break;
            case 5:
                return "MEI";
                break;
            case 6:
                return "JUNI";
                break;
            case 7:
                return "JULI";
                break;
            case 8:
                return "AGUSTUS";
                break;
            case 9:
                return "SEPTEMBER";
                break;
            case 10:
                return "OKTOBER";
                break;
            case 11:
                return "NOVEMBER";
                break;
            case 12:
                return "DESEMBER";
                break;
        }
    }
}

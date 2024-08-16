<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class TarifTangkiController extends MyController
{
    public $title = 'TARIF TANGKI';

    /**
     * @ClassName
     */
    public function index(Request $request)
    {
        $title = $this->title;
        $data = [
            'combo' => $this->combocetak('list', 'STATUS AKTIF', 'STATUS AKTIF'),
            'combopenyesuaianharga' => $this->combocetak('list', 'PENYESUAIAN HARGA', 'PENYESUAIAN HARGA'),
            'listbtn' => $this->getListBtn()
        ];

        return view('tariftangki.index', compact('title', 'data'));
    }

    public function combocetak($aksi, $grp, $subgrp)
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

    public function export(Request $request): void
    {
        $detailParams = [
            'dari' => $request->dari,
            'sampai' => $request->sampai,
        ];

        $header = Http::withHeaders(request()->header())
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'tariftangki/getExport', $detailParams);

        $data = $header['data'];

        if (count($data) == 0) {
            throw new \Exception('TIDAK ADA DATA');
        }

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', $data[0]['judul']);
        $sheet->getStyle("A1")->getFont()->setSize(12)->setBold(true);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal('center');
        $sheet->mergeCells('A1:I1');
        $sheet->setCellValue('A2',  $data[0]['judulLaporan']);
        $sheet->getStyle("A2")->getFont()->setSize(12)->setBold(true);
        $sheet->getStyle('A2')->getAlignment()->setHorizontal('center');
        $sheet->mergeCells('A2:I2');

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

        $detail_columns = [
            [
                'label' => 'No',
            ],
            [
                'label' => 'Tujuan',
                'index' => 'tujuan',
            ],
            [
                'label' => 'Penyesuaian',
                'index' => 'penyesuaian',
            ],
            [
                'label' => 'Nominal',
                'index' => 'nominal',
            ],
            [
                'label' => 'Tgl Mulai Berlaku',
                'index' => 'tglmulaiberlaku',
            ],
            [
                'label' => 'Status Penyesuaian Harga',
                'index' => 'statuspenyesuaianharga',
            ],
            [
                'label' => 'Upah Supir',
                'index' => 'upahsupirtangki',
            ],
            [
                'label' => 'Keterangan',
                'index' => 'keterangan',
            ],
            [
                'label' => 'Status Aktif',
                'index' => 'statusaktif',
            ],
        ];

        $detail_table_header_row = 4;
        $detail_start_row = $detail_table_header_row + 1;
        $alphabets = range('A', 'Z');

        foreach ($detail_columns as $detail_columns_index => $detail_column) {
            $sheet->setCellValue($alphabets[$detail_columns_index] . $detail_table_header_row, strtoupper($detail_column['label']) ?? $detail_columns_index + 1);
        }
        $sheet->getStyle("A$detail_table_header_row:I$detail_table_header_row")->applyFromArray($styleArray);
        $no = 1;
        foreach ($data as $response_index => $response_detail) {

            $dateValue = ($response_detail['tglmulaiberlaku'] != null) ? Date::PHPToExcel(date('Y-m-d', strtotime($response_detail['tglmulaiberlaku']))) : '';
            $sheet->setCellValue("A$detail_start_row", $no++);
            $sheet->setCellValue("B$detail_start_row", $response_detail['tujuan']);
            $sheet->setCellValue("C$detail_start_row", $response_detail['penyesuaian']);
            $sheet->setCellValue("D$detail_start_row", $response_detail['nominal']);
            $sheet->setCellValue("E$detail_start_row", $dateValue);
            $sheet->setCellValue("F$detail_start_row", $response_detail['statuspenyesuaianharga']);
            $sheet->setCellValue("G$detail_start_row", $response_detail['upahsupirtangki']);
            $sheet->setCellValue("H$detail_start_row", $response_detail['keterangan']);
            $sheet->setCellValue("I$detail_start_row", $response_detail['statusaktif']);


            $sheet->getStyle("E$detail_start_row")->getNumberFormat()->setFormatCode('dd-mm-yyyy');
            $sheet->getStyle("A$detail_start_row:I$detail_start_row")->applyFromArray($styleArray);
            $sheet->getStyle("D$detail_start_row")->applyFromArray($style_number)->getNumberFormat()->setFormatCode("#,##0.00_);(#,##0.00)");

            $detail_start_row++;
        }

        $sheet->getColumnDimension('A')->setAutoSize(true);
        $sheet->getColumnDimension('B')->setAutoSize(true);
        $sheet->getColumnDimension('C')->setAutoSize(true);
        $sheet->getColumnDimension('D')->setAutoSize(true);
        $sheet->getColumnDimension('E')->setAutoSize(true);
        $sheet->getColumnDimension('F')->setAutoSize(true);
        $sheet->getColumnDimension('G')->setAutoSize(true);
        $sheet->getColumnDimension('H')->setAutoSize(true);
        $sheet->getColumnDimension('I')->setAutoSize(true);

        $writer = new Xlsx($spreadsheet);
        $filename = 'LAPORAN TARIF TANGKI' . date('dmYHis');
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }

    public function report(Request $request)
    {
        $detailParams = [
            'dari' => $request->dari,
            'sampai' => $request->sampai,
        ];
        $header = Http::withHeaders(request()->header())
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'tariftangki/getExport', $detailParams);

        $data = $header['data'];
        return view('reports.laporantariftangki', compact('data'));
    }
}

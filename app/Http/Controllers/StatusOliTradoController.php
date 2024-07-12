<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class StatusOliTradoController extends MyController
{
    public $title = 'Status Oli Trado';

    public function index()
    {
        $title = $this->title;

        return view('statusolitrado.index', compact('title'));
    }

    public function export(Request $request): void
    {

        $detailParams = [
            'forExport' => true,
            'status' => $request->status,
            'dari' => $request->dari,
            'sampai' => $request->sampai,
            'trado_id' => $request->trado_id,
        ];
        $header = Http::withHeaders(request()->header())
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'statusolitrado', $detailParams);

        $data = $header['data'];

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', $data[0]['judul'] ?? '');
        $sheet->getStyle("A1")->getFont()->setSize(16)->setBold(true);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal('center');
        $sheet->mergeCells('A1:G1');

        $sheet->setCellValue('A2', $data[0]['judulLaporan'] ?? '');
        $sheet->getStyle("A2")->getFont()->setBold(true);
        $sheet->mergeCells('A2:G2');
        $sheet->setCellValue('A3', 'PERIODE : ' . date('d-M-Y', strtotime($detailParams['dari'])) . ' s/d ' . date('d-M-Y', strtotime($detailParams['sampai'])));
        $sheet->setCellValue('A4', 'TRADO : ' . $request->trado);
        $sheet->setCellValue('A5', 'STATUS : ' . $request->statustext);


        $sheet->getStyle("A3:A5")->getFont()->setBold(true);
        $detail_table_header_row = 7;
        $detail_start_row = 8;

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
                'label' => 'No',
                'index' => '',
            ],
            [
                'label' => 'No Pol',
                'index' => 'nopol',
            ],
            [
                'label' => 'Tanggal',
                'index' => 'tanggal',
            ],
            [
                'label' => 'Status Oli',
                'index' => 'status',
            ],
            [
                'label' => 'Stok',
                'index' => 'kodestok'
            ],
            [
                'label' => 'Qty',
                'index' => 'qty'
            ],
            [
                'label' => 'Satuan',
                'index' => 'satuan'
            ]
        ];


        foreach ($detail_columns as $detail_columns_index => $detail_column) {
            $sheet->setCellValue($alphabets[$detail_columns_index] . $detail_table_header_row, $detail_column['label'] ?? $detail_columns_index + 1);
        }
        $sheet->getStyle("A$detail_table_header_row:G$detail_table_header_row")->applyFromArray($styleArray)->getFont()->setBold(true);

        // LOOPING DETAIL
        $dataRow = $detail_table_header_row + 2;
        $previousRow = $dataRow - 1; // Initialize the previous row number
        $a = 1;
        if (is_array($data) || is_iterable($data)) {
            foreach ($data as $response_index => $response_detail) {

                // foreach ($detail_columns as $detail_columns_index => $detail_column) {
                //     $sheet->setCellValue($alphabets[$detail_columns_index] . $detail_start_row, isset($detail_column['index']) ? $response_detail[$detail_column['index']] : $response_index + 1);
                // }
                $dateValue = ($response_detail['tanggal'] != null) ? Date::PHPToExcel(date('Y-m-d', strtotime($response_detail['tanggal']))) : '';

                $sheet->setCellValue("A$detail_start_row", $a);
                $sheet->setCellValue("B$detail_start_row", $response_detail['nopol']);
                $sheet->setCellValue("C$detail_start_row", $dateValue);
                $sheet->setCellValue("D$detail_start_row", $response_detail['status']);
                $sheet->setCellValue("E$detail_start_row", $response_detail['kodestok']);
                $sheet->setCellValue("F$detail_start_row", $response_detail['qty']);
                $sheet->setCellValue("G$detail_start_row", $response_detail['satuan']);



                $sheet->getStyle("A$detail_start_row:G$detail_start_row")->applyFromArray($styleArray);
                $sheet->getStyle("F$detail_start_row")->applyFromArray($style_number)->getNumberFormat()->setFormatCode("#,##0.00_);(#,##0.00)");
                $sheet->getStyle("C$detail_start_row")->getNumberFormat()->setFormatCode('dd-mm-yyyy');

                $a++;
                $dataRow++;
                $detail_start_row++;
            }
        }

        $sheet->getColumnDimension('A')->setWidth(4);
        $sheet->getColumnDimension('B')->setAutoSize(true);
        $sheet->getColumnDimension('C')->setAutoSize(true);
        $sheet->getColumnDimension('D')->setAutoSize(true);
        $sheet->getColumnDimension('E')->setAutoSize(true);
        $sheet->getColumnDimension('F')->setAutoSize(true);
        $sheet->getColumnDimension('G')->setAutoSize(true);

        $writer = new Xlsx($spreadsheet);
        $filename = 'Laporan Status Oli ' . date('dmYHis');
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }
    public function exportdetail(Request $request): void
    {
        $detailParams = [
            'forExport' => true,
            'trado_id' => $request->trado_id,
        ];
        $header = Http::withHeaders(request()->header())
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'statusolitradodetail', $detailParams);

        $data = $header['data'];
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', $data[0]['judul'] ?? '');
        $sheet->getStyle("A1")->getFont()->setSize(16)->setBold(true);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal('center');
        $sheet->mergeCells('A1:G1');

        $sheet->setCellValue('A2', $data[0]['judulLaporan'] ?? '');
        $sheet->getStyle("A2")->getFont()->setBold(true);
        $sheet->mergeCells('A2:G2');
        $sheet->setCellValue('A3', 'PERIODE : ' . date('d-M-Y', strtotime($request->dari)) . ' s/d ' . date('d-M-Y', strtotime($request->sampai)));
        $sheet->setCellValue('A4', 'TRADO : ' . $request->trado);
        $sheet->setCellValue('A5', 'STATUS : ' . $request->statustext);


        $sheet->getStyle("A3:A5")->getFont()->setBold(true);
        $detail_table_header_row = 7;
        $detail_start_row = 8;

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
                'label' => 'No',
                'index' => '',
            ],
            [
                'label' => 'Tgl Bukti',
                'index' => 'tglbukti',
            ],
            [
                'label' => 'stok',
                'index' => 'namastok',
            ],
            [
                'label' => 'No Bukti',
                'index' => 'nobukti',
            ],
            [
                'label' => 'Qty',
                'index' => 'qty',
            ],
            [
                'label' => 'Keterangan',
                'index' => 'keterangan',
            ],
            [
                'label' => 'Urut',
                'index' => 'urut',
            ],
            [
                'label' => 'Jarak',
                'index' => 'jarak',
            ],
            [
                'label' => 'Keterangan Tambahan',
                'index' => 'keterangantambahan',
            ],
            [
                'label' => 'Selisih',
                'index' => 'selisih',
            ],
           
        ];


        foreach ($detail_columns as $detail_columns_index => $detail_column) {
            $sheet->setCellValue($alphabets[$detail_columns_index] . $detail_table_header_row, $detail_column['label'] ?? $detail_columns_index + 1);
        }
        $sheet->getStyle("A$detail_table_header_row:J$detail_table_header_row")->applyFromArray($styleArray)->getFont()->setBold(true);

        // LOOPING DETAIL
        $dataRow = $detail_table_header_row + 2;
        $previousRow = $dataRow - 1; // Initialize the previous row number
        $a = 1;
        if (is_array($data) || is_iterable($data)) {
            foreach ($data as $response_index => $response_detail) {

                // foreach ($detail_columns as $detail_columns_index => $detail_column) {
                //     $sheet->setCellValue($alphabets[$detail_columns_index] . $detail_start_row, isset($detail_column['index']) ? $response_detail[$detail_column['index']] : $response_index + 1);
                // }
                $dateValue = ($response_detail['tglbukti'] != null) ? Date::PHPToExcel(date('Y-m-d', strtotime($response_detail['tglbukti']))) : '';

                $sheet->setCellValue("A$detail_start_row", $a);
                $sheet->setCellValue("B$detail_start_row", $dateValue);
                $sheet->setCellValue("C$detail_start_row", $response_detail['namastok']);
                $sheet->setCellValue("D$detail_start_row", $response_detail['nobukti']);
                $sheet->setCellValue("E$detail_start_row", $response_detail['qty']);
                $sheet->setCellValue("F$detail_start_row", $response_detail['keterangan']);
                $sheet->setCellValue("G$detail_start_row", $response_detail['urut']);
                $sheet->setCellValue("H$detail_start_row", $response_detail['jarak']);
                $sheet->setCellValue("I$detail_start_row", $response_detail['keterangantambahan']);
                $sheet->setCellValue("J$detail_start_row", $response_detail['selisih']);




                $sheet->getStyle("A$detail_start_row:J$detail_start_row")->applyFromArray($styleArray);
                $sheet->getStyle("E$detail_start_row")->applyFromArray($style_number)->getNumberFormat()->setFormatCode("#,##0.00_);(#,##0.00)");
                $sheet->getStyle("G$detail_start_row")->applyFromArray($style_number)->getNumberFormat()->setFormatCode("#,##0.00_);(#,##0.00)");
                $sheet->getStyle("H$detail_start_row")->applyFromArray($style_number)->getNumberFormat()->setFormatCode("#,##0.00_);(#,##0.00)");
                $sheet->getStyle("J$detail_start_row")->applyFromArray($style_number)->getNumberFormat()->setFormatCode("#,##0.00_);(#,##0.00)");
                $sheet->getStyle("B$detail_start_row")->getNumberFormat()->setFormatCode('dd-mm-yyyy');

                $a++;
                $dataRow++;
                $detail_start_row++;
            }
        }

        $sheet->getColumnDimension('A')->setWidth(4);
        $sheet->getColumnDimension('B')->setAutoSize(true);
        $sheet->getColumnDimension('C')->setAutoSize(true);
        $sheet->getColumnDimension('D')->setAutoSize(true);
        $sheet->getColumnDimension('E')->setAutoSize(true);
        $sheet->getColumnDimension('F')->setWidth(30);
        $sheet->getColumnDimension('G')->setAutoSize(true);
        $sheet->getColumnDimension('H')->setAutoSize(true);
        $sheet->getColumnDimension('I')->setWidth(30);
        $sheet->getColumnDimension('J')->setAutoSize(true);

        $writer = new Xlsx($spreadsheet);
        $filename = 'Laporan Status Oli ' . date('dmYHis');
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }
}

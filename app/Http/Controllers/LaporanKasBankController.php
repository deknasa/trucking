<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class LaporanKasBankController extends MyController
{
    public $title = 'Laporan Kas/Bank';

    public function index(Request $request)
    {
        $title = $this->title;
        $data = [
            'pagename' => 'Menu Utama Laporan Kas/Bank',
            'defaultperiode' => $this->defaultperiode(),
        ];

        return view('laporankasbank.index', compact('title', 'data'));
    }

    public function defaultperiode()
    {

        $status = [
            'grp' => "PERIODE DATA",
            'subgrp' => "PERIODE DATA",
        ];

        $response = Http::withHeaders($this->httpHeaders)
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'parameter/getdegfault', $status);

        return $response['data'];
    }
    public function report(Request $request)
    {
        $detailParams = [
            'dari' => $request->dari,
            'sampai' => $request->sampai,
            'bank_id' => $request->bank_id,
            'bank' => $request->bank,
            'periodedata_id' => $request->periodedata_id,
            'periodedata' => $request->periodedata,
        ];
        $header = Http::withHeaders(request()->header())
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'laporankasbank/report', $detailParams);

        $jumlah['jumlah'] = 1;
        if (session('cabang') == 'PUSAT') {
            $data = $header['data'];
            if (count($data) > 1) {
                array_shift($data);
                $jumlah['jumlah'] = 2;
            }
        } else {
            $data = $header['data'];
        }
        $infopemeriksa = $header['infopemeriksa'];
        $datasaldo = $header['datasaldo'];
        $dataCabang['namacabang'] = $header['namacabang'];
        $printer['tipe'] = $request->printer;
        $cabang['cabang'] = session('cabang');

        $user = Auth::user();
        return view('reports.laporankasbank', compact('data', 'dataCabang', 'user', 'detailParams', 'printer', 'cabang', 'datasaldo', 'infopemeriksa', 'jumlah'));
    }

    public function export(Request $request): void
    {
        $detailParams = [
            'dari' => $request->dari,
            'sampai' => $request->sampai,
            'bank_id' => $request->bank_id,
            'bank' => $request->bank,
            'periodedata_id' => $request->periodedata_id,
            'periodedata' => $request->periodedata,
        ];

        $header = Http::withHeaders(request()->header())
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'laporankasbank/export', $detailParams);

        $data = $header['data'];

        if (count($data) == 0) {
            throw new \Exception('TIDAK ADA DATA');
        }
        $namacabang = $header['namacabang'];

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', $data[0]['judul']);
        $sheet->getStyle("A1")->getFont()->setSize(16)->setBold(true);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal('center');
        $sheet->mergeCells('A1:G1');

        $sheet->setCellValue('A2', $data[0]['judulLaporan'] . ' - ' . $namacabang);
        $sheet->mergeCells('A2:B2');
        $sheet->setCellValue('A3', 'Tanggal : ' . date('d-M-Y', strtotime($detailParams['dari'])) . ' s/d ' . date('d-M-Y', strtotime($detailParams['sampai'])));
        $sheet->mergeCells('A3:B3');
        $sheet->setCellValue('A4', 'Buku Kas/Bank : ' . $request->bank);
        $sheet->mergeCells('A4:B4');

        $sheet->getStyle("A2")->getFont()->setBold(true);
        $sheet->getStyle("A3:B3")->getFont()->setBold(true);
        $sheet->getStyle("A4:B4")->getFont()->setBold(true);

        $detail_table_header_row = 7;
        $detail_start_row = $detail_table_header_row + 2;

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

        $sheet->setCellValue('A7', 'Buku Kas/Bank');
        $sheet->setCellValue('B7', $data[0]['namabank']);

        $alphabets = range('A', 'Z');

        $detail_columns = [
            [
                'label' => 'Tgl Bukti',
                'index' => 'tglbukti',
            ],
            [
                'label' => 'No Bukti',
                'index' => 'nobukti',
            ],
            [
                'label' => 'Nama Perkiraan',
                'index' => 'keterangancoa',
            ],
            [
                'label' => 'Keterangan',
                'index' => 'keterangan',
            ],
            [
                'label' => 'Debet',
                'index' => 'debet'
            ],
            [
                'label' => 'Kredit',
                'index' => 'kredit'
            ],
            [
                'label' => 'Saldo',
                'index' => 'saldo'
            ]
        ];


        foreach ($detail_columns as $detail_columns_index => $detail_column) {
            $sheet->setCellValue($alphabets[$detail_columns_index] . $detail_table_header_row, $detail_column['label'] ?? $detail_columns_index + 1);
        }
        $sheet->getStyle("A$detail_table_header_row:G$detail_table_header_row")->applyFromArray($styleArray)->getFont()->setBold(true);
        $cabang = DB::table('parameter')->from(db::raw("parameter a with (readuncommitted)"))
            ->select(
                'a.text as keterangan'
            )
            ->where('grp', 'CABANG')
            ->where('subgrp', 'CABANG')
            ->first();
        // LOOPING DETAIL
        $dataRow = $detail_table_header_row + 2;
        $previousRow = $dataRow - 1; // Initialize the previous row number

        foreach ($data as $response_index => $response_detail) {

            foreach ($detail_columns as $detail_columns_index => $detail_column) {
                $sheet->setCellValue($alphabets[$detail_columns_index] . $detail_start_row, isset($detail_column['index']) ? $response_detail[$detail_column['index']] : $response_index + 1);
            }
            if ($cabang == 'PUSAT') {
                $sheet->setCellValue("A$detail_start_row", $response_detail['tglbukti']);
            } else {
                $dateValue = ($response_detail['tglbukti'] != null) ? Date::PHPToExcel(date('Y-m-d', strtotime($response_detail['tglbukti']))) : '';
                $sheet->setCellValue("A$detail_start_row", $dateValue);
                $sheet->getStyle("A$detail_start_row")
                    ->getNumberFormat()
                    ->setFormatCode('dd-mm-yyyy');
            }
            $sheet->setCellValue("B$detail_start_row", $response_detail['nobukti']);
            $sheet->setCellValue("C$detail_start_row", $response_detail['keterangancoa']);
            $sheet->setCellValue("D$detail_start_row", $response_detail['keterangan']);
            $sheet->setCellValue("E$detail_start_row", $response_detail['debet']);
            $sheet->setCellValue("F$detail_start_row", $response_detail['kredit']);

            if ($response_detail['nobukti'] == 'SALDO AWAL') {
                $sheet->setCellValue('G' . $dataRow, $response_detail['saldo']);
            } else {
                if ($dataRow > $detail_table_header_row + 1) {
                    $sheet->setCellValue('G' . $dataRow, '=(G' . $previousRow . '+E' . $dataRow . ')-F' . $dataRow);
                }
            }

            $sheet->getStyle("A$detail_start_row:G$detail_start_row")->applyFromArray($styleArray);
            $sheet->getStyle("E$detail_start_row:G$detail_start_row")->applyFromArray($style_number)->getNumberFormat()->setFormatCode("#,##0.00_);(#,##0.00)");

            // $sheet->getStyle("D$detail_start_row")->getAlignment()->setWrapText(true);
            $previousRow = $dataRow; // Update the previous row number

            $dataRow++;
            $detail_start_row++;
        }

        $sheet->mergeCells('A' . $detail_start_row . ':D' . $detail_start_row);
        $sheet->setCellValue("A$detail_start_row", 'Total')->getStyle('A' . $detail_start_row . ':D' . $detail_start_row)->applyFromArray($styleArray)->getFont()->setBold(true);

        $sheet->setCellValue("E$detail_start_row", "=SUM(E9:E" . ($dataRow - 1) . ")")->getStyle("E$detail_start_row")->applyFromArray($style_number)->getFont()->setBold(true);

        $sheet->setCellValue("F$detail_start_row",  "=SUM(F9:F" . ($dataRow - 1) . ")")->getStyle("F$detail_start_row")->applyFromArray($style_number)->getFont()->setBold(true);
        $sheet->setCellValue("G$detail_start_row",  "=G" . ($dataRow - 1))->getStyle("G$detail_start_row")->applyFromArray($style_number)->getFont()->setBold(true);

        $sheet->getStyle("E$detail_start_row")->getNumberFormat()->setFormatCode("#,##0.00_);(#,##0.00)");
        $sheet->getStyle("F$detail_start_row")->getNumberFormat()->setFormatCode("#,##0.00_);(#,##0.00)");
        $sheet->getStyle("G$detail_start_row")->getNumberFormat()->setFormatCode("#,##0.00_);(#,##0.00)");

        $sheet->getColumnDimension('A')->setAutoSize(true);
        $sheet->getColumnDimension('B')->setAutoSize(true);
        $sheet->getColumnDimension('C')->setWidth(25);
        $sheet->getColumnDimension('D')->setWidth(72);
        $sheet->getColumnDimension('E')->setAutoSize(true);
        $sheet->getColumnDimension('F')->setAutoSize(true);
        $sheet->getColumnDimension('G')->setAutoSize(true);

        $writer = new Xlsx($spreadsheet);
        $filename = 'LAPORAN KAS BANK' . date('dmYHis');
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }
}

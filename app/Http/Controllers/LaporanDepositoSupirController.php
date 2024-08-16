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


class LaporanDepositoSupirController extends MyController
{
    public $title = 'Laporan Deposito Supir';

    public function index(Request $request)
    {
        $title = $this->title;
        $data = [
            'pagename' => 'Menu Utama Laporan Deposito Supir',
            'defaultperiode' => $this->defaultperiode(),
        ];

        return view('laporandepositosupir.index', compact('title','data'));
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
            'sampai' => $request->sampai,
            'periodedata_id' => $request->periodedata_id,
        ];

        $header = Http::withHeaders(request()->header())
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'laporandepositosupir/report', $detailParams);

        $data = $header['data'];
        $dataCabang['namacabang'] = $header['namacabang'];
        $user = Auth::user();
        return view('reports.laporandepositosupir', compact('data','dataCabang', 'user', 'detailParams'));
    }

    public function export(Request $request): void
    {
        $detailParams = [
            'sampai' => $request->sampai,
            'periodedata_id' => $request->periodedata_id,
        ];

        $header = Http::withHeaders(request()->header())
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'laporandepositosupir/export', $detailParams);

        $data = $header['data'];

        if(count($data) == 0){
            throw new \Exception('TIDAK ADA DATA');
        }
        $namacabang = $header['namacabang'];

        $disetujui = $data[0]['disetujui'] ?? '';
        $diperiksa = $data[0]['diperiksa'] ?? '';
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        
        $sheet->setCellValue('A1', $data[0]['judul']);
        $sheet->getStyle("A1")->getFont()->setSize(16)->setBold(true);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal('center');
        $sheet->mergeCells('A1:G1');
        
        $sheet->setCellValue('A2', $namacabang);
        $sheet->getStyle("A2")->getFont()->setSize(16)->setBold(true);
        $sheet->getStyle('A2')->getAlignment()->setHorizontal('center');
        $sheet->mergeCells('A2:G2');
        
        
        $englishMonths = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
        $indonesianMonths = ['JANUARI', 'FEBRUARI', 'MARET', 'APRIL', 'MEI', 'JUNI', 'JULI', 'AGUSTUS', 'SEPTEMBER', 'OKTOBER', 'NOVEMBER', 'DESEMBER'];
        $tglsampai = str_replace($englishMonths, $indonesianMonths, date('d - M - Y', strtotime($request->sampai)));
        
        $sheet->setCellValue('A3', strtoupper('Laporan Deposito Supir'));
        $sheet->getStyle("A3")->getFont()->setBold(true);
        $sheet->mergeCells('A3:G3');

        $sheet->setCellValue('A4', strtoupper( 'Periode: ' . $tglsampai ));
        $sheet->getStyle("A4")->getFont()->setBold(true);
        $sheet->mergeCells('A4:G4');


        $header_start_row = 6;
        $detail_start_row = $header_start_row + 1;

        $alphabets = range('A', 'Z');

        $header_columns = [
            [
                'label' => 'Supir',
                'index' => 'namasupir',
            ],
            [
                'label' => 'Keterangan',
                'index' => 'keterangandeposito',
            ],
            [
                'label' => 'Saldo Awal',
                'index' => 'saldo',
            ],
            [
                'label' => 'Nominal Deposito',
                'index' => 'deposito',
            ],
            [
                'label' => 'Penarikan',
                'index' => 'penarikan',
            ],
            [
                'label' => 'Total',
                'index' => 'total',
            ],
        ];

        $styleArray = array(
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
            ],
        );

        $styleArray2 = [
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
            ],
            'borders' => [
                'top' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
                'right' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
                'bottom' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
                'left' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN]
            ]
        ];

        $styleArray3 = [
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER
            ],
            'font' => [
                'bold' => true,
            ],
        ];

        $style_number = [
            'font' => [
                'bold' => true,
            ],
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

        // set header
        foreach ($header_columns as $data_columns_index => $data_column) {
            $sheet->setCellValue($alphabets[$data_columns_index] . $header_start_row, $data_column['label']);
            $sheet->getStyle($alphabets[$data_columns_index] . $header_start_row)->getFont()->setBold(true);
        }

        // group data by Keterangan
        $data_by_keterangan = [];
        foreach ($data as $row_index => $row_data) {
            $keterangan = $row_data['keterangan'];
            if (!isset($data_by_keterangan[$keterangan])) {
                $data_by_keterangan[$keterangan] = [];
            }
            $data_by_keterangan[$keterangan][] = $row_data;
        }
        // Set detail grouped by Keterangan
        foreach ($data_by_keterangan as $keterangan => $rows) {
            $sheet->setCellValue('A' . $detail_start_row, $keterangan);
            $sheet->mergeCells("A$detail_start_row:F$detail_start_row");
            $sheet->getStyle("A$detail_start_row")->getFont()->setBold(true);

            foreach ($header_columns as $data_columns_index => $data_column) {
                foreach ($rows as $row_index => $row_data) {
                    if($data_column['index'] == 'total'){
                        $baris = $detail_start_row + $row_index + 1;
                        $sheet->setCellValue($alphabets[$data_columns_index] . ($detail_start_row + $row_index + 1), "=C$baris+D$baris-E$baris");
                    }else{
                        $sheet->setCellValue($alphabets[$data_columns_index] . ($detail_start_row + $row_index + 1), $row_data[$data_column['index']]);
                    }
                }
            }
            $detail_start_row += count($rows) + 2;
        }
        
        //format decimal
        $sheet->getStyle("A7:A$detail_start_row")->applyFromArray($styleArray)->getNumberFormat()->setFormatCode("0.0");
        
        //total
        $total_start_row = $detail_start_row;
        $sheet->mergeCells('A' . $total_start_row . ':B' . $total_start_row);
        $sheet->setCellValue("A$total_start_row", 'Total')->getStyle('A' . $total_start_row . ':E' . $total_start_row)->applyFromArray($styleArray2)->getFont()->setBold(true);
        
        $totalnomdeposito = "=SUM(C7:C" . ($detail_start_row-2) . ")";
        $sheet->setCellValue("C$total_start_row", $totalnomdeposito)->getStyle("C$total_start_row")->applyFromArray($style_number);

        $totalnomdeposito = "=SUM(D7:D" . ($detail_start_row-2) . ")";
        $sheet->setCellValue("D$total_start_row", $totalnomdeposito)->getStyle("D$total_start_row")->applyFromArray($style_number);

        $totalpenarikan = "=SUM(E7:E" . ($detail_start_row-2) . ")";
        $sheet->setCellValue("E$total_start_row", $totalpenarikan)->getStyle("E$total_start_row")->applyFromArray($style_number);

        $total = "=SUM(F7:F" . ($detail_start_row-2) . ")";
        $sheet->setCellValue("F$total_start_row", $total)->getStyle("F$total_start_row")->applyFromArray($style_number);
        
        //format currency
        $currency_columns = ['C', 'D', 'E', 'F'];
        foreach ($currency_columns as $column) {
            $column_start = $header_start_row + 1;
            $column_end = $detail_start_row - 1;
            for ($i = $column_start; $i <= $column_end; $i++) {
                $cell = $column . $i;
                $sheet->getStyle($cell)->getNumberFormat()->setFormatCode("#,##0.00_);(#,##0.00)");

            }
            // $sheet->setCellValue('F' . $detail_start_row, "=C$detail_start_row+D$detail_start_row-E$detail_start_row")->getStyle("F$detail_start_row")->applyFromArray($style_number)->getFont()->setBold(true);
        }
        $sheet->getStyle("C$total_start_row")->getNumberFormat()->setFormatCode("#,##0.00_);(#,##0.00)");
        $sheet->getStyle("D$total_start_row")->getNumberFormat()->setFormatCode("#,##0.00_);(#,##0.00)");
        $sheet->getStyle("E$total_start_row")->getNumberFormat()->setFormatCode("#,##0.00_);(#,##0.00)");
        $sheet->getStyle("F$total_start_row")->getNumberFormat()->setFormatCode("#,##0.00_);(#,##0.00)");


        // set diketahui dibuat
        $ttd_start_row = $total_start_row + 2;
        $sheet->setCellValue("A$ttd_start_row", 'Disetujui Oleh,');
        $sheet->setCellValue("B$ttd_start_row", 'Diperiksa Oleh,');
        $sheet->setCellValue("C$ttd_start_row", 'Disusun Oleh,');

        $sheet->setCellValue("A" . ($ttd_start_row + 3), '( ' . $disetujui . ' )');
        $sheet->setCellValue("B" . ($ttd_start_row + 3), '( ' . $diperiksa . ' )');
        $sheet->setCellValue("C" . ($ttd_start_row + 3), '(                )');


        //style header
        $sheet->getColumnDimension('A')->setAutoSize(true);
        $sheet->getColumnDimension('C')->setAutoSize(true);
        $sheet->getColumnDimension('D')->setAutoSize(true);
        $sheet->getColumnDimension('E')->setAutoSize(true);
        $sheet->getColumnDimension('F')->setAutoSize(true);
        $sheet->getColumnDimension('B')->setWidth(50);        

        $sheet->getStyle("A4")->applyFromArray($styleArray3);
        $sheet->getStyle("B4")->applyFromArray($styleArray3);
        $sheet->getStyle("C4")->applyFromArray($styleArray3);
        $sheet->getStyle("D4")->applyFromArray($styleArray3);
        $sheet->getStyle("E4")->applyFromArray($styleArray3);
        $sheet->getStyle("F4")->applyFromArray($styleArray3);

        $writer = new Xlsx($spreadsheet);
        $filename = 'LAPORAN DEPOSITO SUPIR ' . date('dmYHis');
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class LaporanNeracaController extends MyController
{
    public $title = 'Laporan Neraca';

    public function index(Request $request)
    {
        $title = $this->title;
        $data = [
            'pagename' => 'Menu Utama Laporan Neraca',
        ];

        return view('laporanneraca.index', compact('title'));
    }

    public function report(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');
        $detailParams = [
            'judul' => 'PT. TRANSPORINDO AGUNG SEJAHTERA',
            'judullaporan' => 'Laporan Neraca',
            'tanggal_cetak' => date('d-m-Y H:i:s'),
            'sampai' => $request->sampai
        ];

        $header = Http::withHeaders(request()->header())
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'laporanneraca/report', $detailParams);

        $data = $header['data'];


        $user = Auth::user();

        return view('reports.laporanneraca', compact('data', 'user', 'detailParams'));
    }

    public function export(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');
        $detailParams = [
            'judul' => 'PT. TRANSPORINDO AGUNG SEJAHTERA',
            'judullaporan' => 'Laporan Neraca',
            'tanggal_cetak' => date('d-m-Y H:i:s'),
            'sampai' => $request->sampai
        ];

        $header = Http::withHeaders(request()->header())
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'laporanneraca/export', $detailParams);

        $data = $header['data'];

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', 'PT. TRANSPORINDO AGUNG SEJAHTERA');
        $sheet->setCellValue('A2', 'Laporan Neraca');
        $sheet->setCellValue('A3', 'Periode: ' . $request->sampai);

        // $sheet->getStyle("A1")->getFont()->setSize(20)->setBold(true);

        $sheet->getStyle('A1')->getAlignment()->setHorizontal('center');
        $sheet->getStyle('A2')->getAlignment()->setHorizontal('left');
        $sheet->mergeCells('A1:B1');
        $sheet->mergeCells('A2:B2');
        $sheet->mergeCells('A3:B3');
        $sheet->mergeCells('A4:B4');

        $header_start_row = 6;
        $detail_start_row = 7;
        $baris = $detail_start_row+3;

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

        ];

        $alphabets = range('A', 'Z');



        $header_columns = [

            [
                'label' => 'KETERANGAN',
                'index' => 'keteranganmain',
            ],

            [
                'label' => 'NILAI',
                'index' => 'Nominal',
            ],
        ];

        foreach ($header_columns as $data_columns_index => $data_column) {
            $sheet->setCellValue($alphabets[$data_columns_index] . $header_start_row, $data_column['label'] ?? $data_columns_index + 1);
        }

        $lastColumn = $alphabets[$data_columns_index];
        $sheet->getStyle("A$header_start_row:$lastColumn$header_start_row")->getFont()->setBold(true);

        // Merge sel B dan C pada baris header
        $sheet->mergeCells("B$header_start_row:C$header_start_row");

        if (is_array($data) || is_iterable($data)) {
            // Menulis data dan melakukan grup berdasarkan kolom "KeteranganMain"
            $previous_keterangan_main = '';
            $previous_keterangan_type = '';
            $total_per_keterangan_type = 0;
            $total_start_row = 0;
            $a = 0;
            $b = 0;
            $c = 0;
            $e = 0;
            foreach ($data as $response_detail) {
                $keterangan_main = $response_detail['TipeMaster'];
                $keterangan_type = $response_detail['KeteranganType'];
                $a = $a + 1;
                if ($keterangan_main != $previous_keterangan_main) {
                    // if ($keterangan_main == 'PASSIVA') {
                    //     $baris = $baris+$a; 
                    //     $sheet->setCellValue("D$baris", "Total $previous_keterangan_main");
                    //     $c = 1;
                     
                    // }
                    if ($previous_keterangan_main != '') {
                        if ($total_per_keterangan_type > 0) {
                            $sheet->mergeCells("A$total_start_row:A$total_start_row");
                            $sheet->setCellValue('C' . ($total_start_row - 1), "=SUM(B$total_start_row:B" . ($detail_start_row - 1) . ")");
                            $sheet->getStyle("C" . ($total_start_row - 1))->getFont()->setBold(true);
                            $sheet->getStyle("C" . ($total_start_row - 1))->getNumberFormat()->setFormatCode("#,##0.00");

                        }
                        $total_per_keterangan_type = 0;
                        
                    }
                    $sheet->setCellValue("A$detail_start_row", $keterangan_main);
                 
                    $sheet->mergeCells("A$detail_start_row:A$detail_start_row");
                    $detail_start_row++;


                    $previous_keterangan_type = '';
                    $total_start_row = $detail_start_row;
                }
                
               
                if ($keterangan_type != $previous_keterangan_type) {
                 
                    if ($previous_keterangan_type != '') {
                       
                        $sheet->mergeCells("A$total_start_row:A$total_start_row");
                        $sheet->setCellValue('C' . ($total_start_row - 1), "=SUM(B$total_start_row:B" . ($detail_start_row - 1) . ")");
                        $sheet->getStyle("C" . ($total_start_row - 1))->getFont()->setBold(true);
                        $sheet->getStyle("C" . ($total_start_row - 1))->getNumberFormat()->setFormatCode("#,##0.00");
                        $sheet->setCellValue('C' . $total_start_row, '');
                    }

                    // $d = $detail_start_row+$c;
                    
                    $sheet->setCellValue("A$detail_start_row", $keterangan_type);
                    $sheet->mergeCells("A$detail_start_row:A$detail_start_row");
                    $detail_start_row++;
                    
                    $total_start_row = $detail_start_row;

                    
                }
            
                $sheet->setCellValue("A$detail_start_row", "      " . $response_detail['KeteranganCoa']);
                $sheet->setCellValue("B$detail_start_row", $response_detail['Nominal']);
                $sheet->getStyle("B$detail_start_row")->getNumberFormat()->setFormatCode("#,##0.00");

                $total_per_keterangan_type += $response_detail['Nominal'];

                $detail_start_row++;

                $previous_keterangan_main = $keterangan_main;
                $previous_keterangan_type = $keterangan_type;
            }

            if ($previous_keterangan_main != '') {
                if ($total_per_keterangan_type > 0) {
                    $sheet->mergeCells("A$total_start_row:A$total_start_row");
                    $sheet->setCellValue('C' . ($total_start_row - 1), "=SUM(B$total_start_row:B" . ($detail_start_row - 1) . ")");
                    $sheet->getStyle("C" . ($total_start_row - 1))->getFont()->setBold(true);
                    $sheet->getStyle("C" . ($total_start_row - 1))->getNumberFormat()->setFormatCode("#,##0.00");
                }

              
            }
        }


        // Set format ribuan untuk kolom B dan C pada grup terakhir
        $sheet->getStyle("B$total_start_row:C$detail_start_row")
            ->getNumberFormat()
            ->setFormatCode("#,##0.00");

        //ukuran kolom
        $sheet->getColumnDimension('A')->setAutoSize(true);
        $sheet->getColumnDimension('B')->setAutoSize(true);
        $sheet->getColumnDimension('C')->setAutoSize(true);




        $writer = new Xlsx($spreadsheet);
        $filename = 'EXPORTLAPORANNERACA' . date('dmYHis');
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }
}

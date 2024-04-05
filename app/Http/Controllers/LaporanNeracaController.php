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
            'idcabang' => $this->comboList('ID CABANG','ID CABANG'),
        ];
        $getCabang = $this->getCabang($data['idcabang']['text']);
        $cabang  = $getCabang['data'];
        

        return view('laporanneraca.index', compact('title','data','cabang'));
    }
    
    public function comboList($grp, $subgrp)
    {
        $status = [
            'grp' => $grp,
            'subgrp' => $subgrp,
        ];

        $response = Http::withHeaders($this->httpHeaders)
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'parameter/getparamfirst', $status);

        return $response;
    }
    public function getCabang($id)
    {
        $response = Http::withHeaders($this->httpHeaders)
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . "cabang/$id");

        return $response;
    }

    public function report(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');
        $detailParams = [
            'judul' => 'PT. TRANSPORINDO AGUNG SEJAHTERA',
            'judullaporan' => 'Laporan Neraca',
            'tanggal_cetak' => date('d-m-Y H:i:s'),
            'sampai' => $request->sampai,
            'cabang_id' => $request->cabang_id,
        ];

        $header = Http::withHeaders(request()->header())
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'laporanneraca/report', $detailParams);

        $data = $header['data'];
        $dataheader = $header['dataheader'];

        $user = Auth::user();
        $printer['tipe'] = $request->printer;

        return view('reports.laporanneraca', compact('data','dataheader', 'user', 'detailParams','printer'));
    }

    public function export(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');
        $detailParams = [
            'judul' => 'PT. TRANSPORINDO AGUNG SEJAHTERA',
            'judullaporan' => 'Laporan Neraca',
            'tanggal_cetak' => date('d-m-Y H:i:s'),
            'sampai' => $request->sampai,
            'cabang_id' => $request->cabang_id,
        ];

        $header = Http::withHeaders(request()->header())
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'laporanneraca/export', $detailParams);

        $data = $header['data'];
        
        if(count($data) == 0){
            throw new \Exception('TIDAK ADA DATA');
        }
        $dataheader = $header['dataheader'];

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $bulan = $this->getBulan(substr($request->sampai,0,2));
        $tahun = substr($request->sampai,3,4);

        $sheet->setCellValue('A1', $data[0]['CmpyName']);
        $sheet->setCellValue('A2', $dataheader['cabang'] ?? '');
        $sheet->setCellValue('A3', 'LAPORAN NERACA');
        $sheet->setCellValue('A4', 'PERIODE : '. $bulan .' - '.$tahun);

        $sheet->getStyle("A1")->getFont()->setSize(16)->setBold(true);
        $sheet->getStyle("A2")->getFont()->setSize(16)->setBold(true);
        $sheet->getStyle("A3")->getFont()->setBold(true);
        $sheet->getStyle("A4")->getFont()->setBold(true);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal('center');

        // $sheet->getStyle("A1")->getFont()->setSize(20)->setBold(true);

        $sheet->getStyle('A1')->getAlignment()->setHorizontal('center');
        $sheet->getStyle('A2')->getAlignment()->setHorizontal('center');
        $sheet->mergeCells('A1:C1');
        $sheet->mergeCells('A2:C2');
        // $sheet->mergeCells('A3:B3');
        // $sheet->mergeCells('A4:B4');

        $header_start_row = 6;
        $detail_start_row = 7;
        $baris = $detail_start_row + 3;

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
        $sheet->getStyle("A$header_start_row:C$header_start_row")->applyFromArray($styleArray)->getFont()->setBold(true);

        // Merge sel B dan C pada baris header
        $sheet->mergeCells("B$header_start_row:C$header_start_row");

        if (is_array($data) || is_iterable($data)) {
            // Menulis data dan melakukan grup berdasarkan kolom "KeteranganMain"
            $previous_keterangan_main = '';
            $previous_keterangan_type = '';
            $total_per_keterangan_type = 0;
            $total_start_row = 0;
            $total_start_row_per_main = 0;
            $start_last_main = 0;
            
            $start_row_main = 0;
            $a = 0;
            $b = 0;
            $c = 0;
            $e = 0;
            foreach ($data as $response_detail) {
                $keterangan_main = $response_detail['TipeMaster'];
                $keterangan_type = $response_detail['KeteranganType'];
                $a = $a + 1;
                
                if ($keterangan_main != $previous_keterangan_main) {
                    if ($previous_keterangan_main != '') {

                        if ($total_per_keterangan_type > 0) {
                            // $sheet->mergeCells("A$total_start_row:A$total_start_row");
                            $sheet->setCellValue('C' . ($total_start_row - 1), "=SUM(B$total_start_row:B" . ($detail_start_row - 1) . ")");
                            $sheet->getStyle("C" . ($total_start_row - 1))->applyFromArray($styleArray)->getFont()->setBold(true);
                            $sheet->getStyle("C" . ($total_start_row - 1))->getNumberFormat()->setFormatCode("#,##0.00_);(#,##0.00)");
                            $sheet->getStyle("A$total_start_row:C$total_start_row")->applyFromArray($styleArray);
                        }
                        $total_per_keterangan_type = 0;
                        if ($total_start_row_per_main > 0) {
                            $sheet->setCellValue("A$detail_start_row", "TOTAL $previous_keterangan_main");
                            $sheet->setCellValue("C$detail_start_row", "=SUM(B$start_row_main:B" . ($detail_start_row - 1) . ")");
                            $sheet->getStyle("C$detail_start_row")->applyFromArray($styleArray)->getFont()->setBold(true);
                            $sheet->getStyle("C$detail_start_row")->getNumberFormat()->setFormatCode("#,##0.00_);(#,##0.00)");
                            $sheet->getStyle("A$detail_start_row:C$detail_start_row")->applyFromArray($styleArray);
                            $detail_start_row += 2;
                        }
                        $total_start_row_per_main = 0;
                    }
                    $start_last_main = $detail_start_row;

                    $sheet->setCellValue("A$detail_start_row", $keterangan_main);
                    $sheet->getStyle("A$detail_start_row:C$detail_start_row")->applyFromArray($styleArray);
                    // $sheet->mergeCells("A$detail_start_row:A$detail_start_row");
                    $detail_start_row++;


                    $previous_keterangan_type = '';
                    $total_start_row = $detail_start_row;

                    $total_start_row_per_main = $detail_start_row;
                }


                if ($keterangan_type != $previous_keterangan_type) {

                    if ($previous_keterangan_type != '') {
                        // $sheet->mergeCells("A$total_start_row:A$total_start_row");
                        $sheet->setCellValue('C' . ($total_start_row - 1), "=SUM(B$total_start_row:B" . ($detail_start_row - 1) . ")");
                        $sheet->getStyle("C" . ($total_start_row - 1))->applyFromArray($styleArray)->getFont()->setBold(true);
                        $sheet->getStyle("C" . ($total_start_row - 1))->getNumberFormat()->setFormatCode("#,##0.00_);(#,##0.00)");
                        // $sheet->setCellValue('C' . $total_start_row, '');
                        $sheet->getStyle("A$total_start_row:C$total_start_row")->applyFromArray($styleArray);
                        // $start_last_main = $total_start_row;
                    } else {
                        $start_row_main = $detail_start_row;
                    }

                    // $d = $detail_start_row+$c;

                    $sheet->setCellValue("A$detail_start_row", $keterangan_type);
                    $sheet->getStyle("A$detail_start_row:C$detail_start_row")->applyFromArray($styleArray);
                    // $sheet->mergeCells("A$detail_start_row:A$detail_start_row");
                    $detail_start_row++;

                    $total_start_row = $detail_start_row;
                }
                
                $sheet->setCellValue("A$detail_start_row", "      " . $response_detail['KeteranganCoa']);
                $sheet->setCellValue("B$detail_start_row", $response_detail['Nominal']);
                if($response_detail['selisih'] != 0){
                    
                    $sheet->setCellValue("C$detail_start_row", "X");
                    $sheet->setCellValue("D$detail_start_row", $response_detail['nominalbanding']);
                    $sheet->getStyle("D$detail_start_row")->getNumberFormat()->setFormatCode("#,##0.00_);(#,##0.00)");
                    $sheet->getStyle("C$detail_start_row:D$detail_start_row")->getFont()->setBold(true);
                }
                $sheet->getStyle("B$detail_start_row")->getNumberFormat()->setFormatCode("#,##0.00_);(#,##0.00)");

                $total_per_keterangan_type += $response_detail['Nominal'];

                $detail_start_row++;
                $sheet->getStyle("A$detail_start_row:C$detail_start_row")->applyFromArray($styleArray);
                $total_start_row_per_main = $detail_start_row;
                $previous_keterangan_main = $keterangan_main;
                $previous_keterangan_type = $keterangan_type;
            }

            if ($previous_keterangan_main != '') {
                if ($total_per_keterangan_type > 0) {
                    // $sheet->mergeCells("A$total_start_row:A$total_start_row");
                    $sheet->setCellValue('C' . ($total_start_row - 1), "=SUM(B$total_start_row:B" . ($detail_start_row - 1) . ")");
                    $sheet->getStyle("C" . ($total_start_row - 1))->applyFromArray($styleArray)->getFont()->setBold(true);
                    $sheet->getStyle("C" . ($total_start_row - 1))->getNumberFormat()->setFormatCode("#,##0.00_);(#,##0.00)");
                    $sheet->getStyle("A$total_start_row:C$total_start_row")->applyFromArray($styleArray);
                }

                $sheet->setCellValue("A$detail_start_row", "TOTAL $previous_keterangan_main");
                $sheet->setCellValue("C$detail_start_row", "=SUM(B$start_last_main:B" . ($detail_start_row - 1) . ")");
                $sheet->getStyle("C$detail_start_row")->applyFromArray($styleArray)->getFont()->setBold(true);
                $sheet->getStyle("C$detail_start_row")->getNumberFormat()->setFormatCode("#,##0.00_);(#,##0.00)");
                $sheet->getStyle("A$total_start_row:B$total_start_row")->applyFromArray($styleArray);
            }
        }


        // Set format ribuan untuk kolom B dan C pada grup terakhir
        $sheet->getStyle("B$total_start_row:C$detail_start_row")
            ->getNumberFormat()
            ->setFormatCode("#,##0.00_);(#,##0.00)");

        //ukuran kolom
        $sheet->getColumnDimension('A')->setAutoSize(true);
        $sheet->getColumnDimension('B')->setAutoSize(true);
        $sheet->getColumnDimension('C')->setAutoSize(true);
        $sheet->getColumnDimension('D')->setAutoSize(true);




        $writer = new Xlsx($spreadsheet);
        $filename = 'LAPORAN NERACA ' . date('dmYHis');
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

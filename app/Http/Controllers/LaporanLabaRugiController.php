<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Menu;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class LaporanLabaRugiController extends MyController
{
    public $title = 'Laporan Laba Rugi';

    public function index(Request $request)
    {
        $title = $this->title;
        $data = [
            'idcabang' => $this->comboList('ID CABANG','ID CABANG'),
        ];
        $getCabang = $this->getCabang($data['idcabang']['text']);
        $cabang  = $getCabang['data'];
        return view('laporanlabarugi.index', compact('title','data','cabang'));
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
            'judullaporan' => 'Laporan Laba Rugi',
            'tanggal_cetak' => date('d-m-Y H:i:s'),
            'sampai' => $request->sampai,
            'cabang_id' => $request->cabang_id,

        ];
        $header = Http::withHeaders(request()->header())
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'laporanlabarugi/report', $detailParams);


        if ($header->successful()) {
            $data = $header['data'];
            $user = Auth::user();
            // return response()->json(['url' => route('reports.laporanlabarugi', compact('data', 'user', 'detailParams'))]);
            return view('reports.laporanlabarugi', compact('data', 'user', 'detailParams'));
        } else {
            return response()->json($header->json(), $header->status());
        }
    }

    public function export(Request $request)
    {
        $detailParams = [
            'judul' => 'PT. TRANSPORINDO AGUNG SEJAHTERA',
            'judullaporan' => 'Laporan  Laba Rugi',
            'tanggal_cetak' => date('d-m-Y H:i:s'),
            'sampai' => $request->sampai,
            'cabang_id' => $request->cabang_id,


        ];

        $responses = Http::withHeaders($request->header())
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'laporanlabarugi/export', $detailParams);

        if ($responses->successful()) {
            $pengeluaran = $responses['data'];
            $disetujui = $pengeluaran[0]['disetujui'] ?? '';
            $diperiksa = $pengeluaran[0]['diperiksa'] ?? '';
            $user = Auth::user();
            // dd($pengeluaran);
            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();

            $sheet->setCellValue('A1', $pengeluaran[0]['CmpyName']);
            $sheet->setCellValue('A2', 'Laporan Laba Rugi');
            $sheet->setCellValue('A3', 'Periode: ' . $request->sampai);

            $sheet->getStyle("A1")->getFont()->setSize(16)->setBold(true);

            $sheet->getStyle('A1')->getAlignment()->setHorizontal('center');
            $sheet->getStyle('A2')->getAlignment()->setHorizontal('left');
            $sheet->mergeCells('A1:C1');
            $sheet->mergeCells('A2:B2');
            $sheet->mergeCells('A3:B3');
            $sheet->mergeCells('A4:B4');

            $header_start_row = 6;
            $detail_start_row = 7;

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

            $sheet->mergeCells("B$header_start_row:C$header_start_row");
            $totalDebet = 0;
            $totalKredit = 0;
            $totalSaldo = 0;
            // $no = 1;
            if (is_array($pengeluaran) || is_iterable($pengeluaran)) {
                // $no = 1;

                // Menambahkan baris untuk Pendapatan
                // $sheet->setCellValue("A$detail_start_row", $no);
                // Tulis label "Pendapatan :" pada kolom "A"
                $previous_keterangan_main = '';
                $previous_keterangan_type = '';
                $total_per_keterangan_type = 0;
                $total_start_row = 0;
                $total_start_row_per_main = 0;
                $start_last_main = 0;
                $start_row_main = 0;
                $rowPendapatan = '';

                // Gabungkan sel pada kolom "A" untuk label "Pendapatan :"
                $sheet->mergeCells("A$detail_start_row:A$detail_start_row");
                $sheet->getStyle("A$detail_start_row:C$detail_start_row")->applyFromArray($styleArray);

                // $detail_start_row++;

                foreach ($pengeluaran as $response_detail) {
                    $keterangan_main = $response_detail['keteranganmain'];
                    $keterangan_type = $response_detail['KeteranganParent'];

                    if ($keterangan_main != $previous_keterangan_main) {
                        if ($previous_keterangan_main != '') {

                            if ($total_per_keterangan_type > 0) {
                                // $sheet->mergeCells("A$total_start_row:A$total_start_row");
                                $sheet->setCellValue('C' . ($total_start_row - 1), "=SUM(B$total_start_row:B" . ($detail_start_row - 1) . ")");
                                $sheet->getStyle("C" . ($total_start_row - 1))->applyFromArray($styleArray)->getFont()->setBold(true);
                                $sheet->getStyle("C" . ($total_start_row - 1))->getNumberFormat()->setFormatCode("#,##0.00");
                                $sheet->getStyle("A$total_start_row:C$total_start_row")->applyFromArray($styleArray);
                            }
                            $total_per_keterangan_type = 0;
                            if ($total_start_row_per_main > 0) {
                                if ($previous_keterangan_main == 'PENDAPATAN :') {
                                    $rowPendapatan = "C$detail_start_row";
                                }
                                $sheet->setCellValue("A$detail_start_row", "TOTAL $previous_keterangan_main");
                                $sheet->setCellValue("C$detail_start_row", "=SUM(B$start_row_main:B" . ($detail_start_row - 1) . ")");
                                $sheet->getStyle("C$detail_start_row")->applyFromArray($styleArray)->getFont()->setBold(true);
                                $sheet->getStyle("C$detail_start_row")->getNumberFormat()->setFormatCode("#,##0.00");
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
                            $sheet->getStyle("C" . ($total_start_row - 1))->getNumberFormat()->setFormatCode("#,##0.00");
                            $sheet->setCellValue('C' . $total_start_row, '');
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

                    $sheet->setCellValue("A$detail_start_row", "      " . $response_detail['keterangancoa']);
                    $sheet->setCellValue("B$detail_start_row", $response_detail['Nominal']);
                    $sheet->getStyle("B$detail_start_row")->getNumberFormat()->setFormatCode("#,##0.00");

                    $total_per_keterangan_type = $detail_start_row;

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
                        $sheet->getStyle("C" . ($total_start_row - 1))->getNumberFormat()->setFormatCode("#,##0.00");
                        $sheet->getStyle("A$total_start_row:C$total_start_row")->applyFromArray($styleArray);
                    }
                    $sheet->setCellValue("A$detail_start_row", "TOTAL $previous_keterangan_main");
                    $sheet->setCellValue("C$detail_start_row", "=SUM(B$start_last_main:B" . ($detail_start_row - 1) . ")");
                    $sheet->getStyle("C$detail_start_row")->applyFromArray($styleArray)->getFont()->setBold(true);
                    $sheet->getStyle("C$detail_start_row")->getNumberFormat()->setFormatCode("#,##0.00");
                    $sheet->getStyle("A$total_start_row:B$total_start_row")->applyFromArray($styleArray);
                }
            }

            //ukuran kolom
            $sheet->getColumnDimension('A')->setAutoSize(true);
            $sheet->getColumnDimension('B')->setAutoSize(true);



            // menambahkan sel Total pada baris terakhir + 1
            // $sheet->setCellValue("A" . ($detail_start_row + 1), 'Total');
            // $sheet->setCellValue("D" . ($detail_start_row + 1), "=SUM(D5:D" . $detail_start_row . ")");
            // $sheet->setCellValue("E" . ($detail_start_row + 1), "=SUM(E5:E" . $detail_start_row . ")");


            //FORMAT
            // set format ribuan untuk kolom D dan E
            $sheet->getStyle("B" . ($detail_start_row + 1) . ":B" . ($detail_start_row + 1))->getNumberFormat()->setFormatCode("#,##0.00");
            $sheet->getStyle("A" . ($detail_start_row + 1) . ":$lastColumn" . ($detail_start_row + 1))->getFont()->setBold(true);


            $detail_start_row++;
            
            $sheet->setCellValue("A$detail_start_row", "LABA (RUGI) BERSIH : ");
            $sheet->setCellValue("C$detail_start_row", "=$rowPendapatan-ABS(C" . ($detail_start_row - 1) . ")");
            $sheet->getStyle("A$detail_start_row:B$detail_start_row")->applyFromArray($styleArray);            
            $sheet->mergeCells("A$detail_start_row:B$detail_start_row");
            $sheet->getStyle("C$detail_start_row")->applyFromArray($styleArray)->getFont()->setBold(true);
            $sheet->getStyle("C$detail_start_row")->getNumberFormat()->setFormatCode("#,##0.00");

            $sheet->getColumnDimension('A')->setAutoSize(true);
            $sheet->getColumnDimension('B')->setAutoSize(true);
            $sheet->getColumnDimension('C')->setAutoSize(true);



            $writer = new Xlsx($spreadsheet);
            $filename = 'EXPORTLAPORANLABARUGI' . date('dmYHis');
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
            header('Cache-Control: max-age=0');

            $writer->save('php://output');
        } else {
            return response()->json($responses->json(), $responses->status());
        }
    }
}

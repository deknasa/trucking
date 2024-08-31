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
            'idcabang' => $this->comboList('ID CABANG', 'ID CABANG'),
        ];
        $getCabang = $this->getCabang($data['idcabang']['text']);
        $cabang  = $getCabang['data'];
        return view('laporanlabarugi.index', compact('title', 'data', 'cabang'));
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
            $dataheader = $header['dataheader'];
            $user = Auth::user();
            // return response()->json(['url' => route('reports.laporanlabarugi', compact('data', 'user', 'detailParams'))]);
            return view('reports.laporanlabarugi', compact('data', 'dataheader', 'user', 'detailParams'));
        } else {
            return response()->json($header->json(), $header->status());
        }
    }

    // public function export(Request $request)
    // {
    //     $detailParams = [
    //         'judul' => 'PT. TRANSPORINDO AGUNG SEJAHTERA',
    //         'judullaporan' => 'Laporan  Laba Rugi',
    //         'tanggal_cetak' => date('d-m-Y H:i:s'),
    //         'sampai' => $request->sampai,
    //         'cabang_id' => $request->cabang_id,


    //     ];

    //     $responses = Http::withHeaders($request->header())
    //         ->withOptions(['verify' => false])
    //         ->withToken(session('access_token'))
    //         ->get(config('app.api_url') . 'laporanlabarugi/export', $detailParams);

    //     $pengeluaran = $responses['data'];

    //     if (count($pengeluaran) == 0) {
    //         throw new \Exception('TIDAK ADA DATA');
    //     }

    //     $disetujui = $pengeluaran[0]['disetujui'] ?? '';
    //     $diperiksa = $pengeluaran[0]['diperiksa'] ?? '';
        
    //     $dataheader = $responses['dataheader'];
    //     $user = Auth::user();
    //     // dd($pengeluaran);
    //     $spreadsheet = new Spreadsheet();
    //     $sheet = $spreadsheet->getActiveSheet();
    //     $bulan = $this->getBulan(substr($request->sampai, 0, 2));
    //     $tahun = substr($request->sampai, 3, 4);

    //     $sheet->setCellValue('A1', $pengeluaran[0]['CmpyName'] ?? '');
    //     $sheet->setCellValue('A2', $dataheader['cabang'] ?? '');
    //     $sheet->setCellValue('A3', 'LAPORAN LABA RUGI');
    //     $sheet->setCellValue('A4', 'PERIODE : ' . $bulan . ' - ' . $tahun);
    //     $sheet->setCellValue('A5',  $pengeluaran[0]['Cabang'] ?? '');

    //     $sheet->getStyle("A1")->getFont()->setSize(16)->setBold(true);
    //     $sheet->getStyle("A2")->getFont()->setSize(16)->setBold(true);
    //     $sheet->getStyle("A3")->getFont()->setBold(true);
    //     $sheet->getStyle("A4")->getFont()->setBold(true);
    //     $sheet->getStyle("A5")->getFont()->setBold(true);

    //     $sheet->getStyle('A1')->getAlignment()->setHorizontal('center');
    //     $sheet->getStyle('A2')->getAlignment()->setHorizontal('center');
    //     $sheet->mergeCells('A1:C1');
    //     $sheet->mergeCells('A2:C2');
    //     $sheet->mergeCells('A3:B3');
    //     $sheet->mergeCells('A4:B4');
    //     $sheet->mergeCells('A5:B5');

    //     $header_start_row = 6;
    //     $detail_start_row = 7;

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

    //     ];

    //     $alphabets = range('A', 'Z');



    //     $header_columns = [

    //         [
    //             'label' => 'KETERANGAN',
    //             'index' => 'keteranganmain',
    //         ],

    //         [
    //             'label' => 'NILAI',
    //             'index' => 'Nominal',
    //         ],
    //     ];

    //     foreach ($header_columns as $data_columns_index => $data_column) {
    //         $sheet->setCellValue($alphabets[$data_columns_index] . $header_start_row, $data_column['label'] ?? $data_columns_index + 1);
    //     }

    //     $lastColumn = $alphabets[$data_columns_index];
    //     $sheet->getStyle("A$header_start_row:C$header_start_row")->applyFromArray($styleArray)->getFont()->setBold(true);

    //     $sheet->mergeCells("B$header_start_row:C$header_start_row");
    //     $totalDebet = 0;
    //     $totalKredit = 0;
    //     $totalSaldo = 0;
    //     // $no = 1;
    //     if (is_array($pengeluaran) || is_iterable($pengeluaran)) {
    //         // $no = 1;
    //         foreach ($pengeluaran as $row) {
    //             $keteranganmain = $row['keteranganmain'];
    //             $KeteranganParent = $row['KeteranganParent'];
    //             $groupedData[$keteranganmain][$KeteranganParent][] = $row;
    //         }
    //         // Menambahkan baris untuk Pendapatan
    //         // $sheet->setCellValue("A$detail_start_row", $no);
    //         // Tulis label "Pendapatan :" pada kolom "A"
    //         $previous_keterangan_main = '';
    //         $previous_keterangan_type = '';
    //         $total_per_keterangan_type = 0;
    //         $total_start_row = 0;
    //         $total_start_row_per_main = 0;
    //         $start_last_main = 0;
    //         $start_row_main = 0;
    //         $rowPendapatan = '';

    //         // Gabungkan sel pada kolom "A" untuk label "Pendapatan :"
    //         $sheet->mergeCells("A$detail_start_row:A$detail_start_row");
    //         $sheet->getStyle("A$detail_start_row:C$detail_start_row")->applyFromArray($styleArray);

    //         $sumLaba = [];
    //         foreach ($groupedData as $keteranganmain => $group) {
    //             $sheet->setCellValue("A$detail_start_row", $keteranganmain)->getStyle("A$detail_start_row:C$detail_start_row")->applyFromArray($styleArray)->getFont()->setBold(true);
    //             $startRowMain = $detail_start_row;
    //             $detail_start_row++;
    //             $prevKetParent = '';
    //             $startRowParent = 0;
    //             foreach ($group as $KeteranganParent => $row) {
    //                 $startRowParent = $detail_start_row;
    //                 $sheet->setCellValue("A$detail_start_row", "      " . $KeteranganParent)->getStyle("A" . ($detail_start_row) . ":C" . ($detail_start_row))->applyFromArray($styleArray)->getFont()->setBold(true);
    //                 $detail_start_row++;

    //                 foreach ($row as $response_detail) {
    //                     $sheet->setCellValue("A$detail_start_row", "            " . $response_detail['keterangancoa']);
    //                     $sheet->setCellValue("B$detail_start_row", $response_detail['Nominal']);

    //                     $sheet->getStyle("A" . ($detail_start_row) . ":C" . ($detail_start_row))->applyFromArray($styleArray);
    //                     $sheet->getStyle("B$detail_start_row")->getNumberFormat()->setFormatCode("#,##0.00_);(#,##0.00)");
    //                     $detail_start_row++;
    //                 }
    //                 $totalPerParent = "=SUM(B" . ($startRowParent + 1) . ":B" . ($detail_start_row - 1) . ")";
    //                 $sheet->setCellValue("C$startRowParent", $totalPerParent)->getStyle("C$startRowParent")->getFont()->setBold(true);
    //                 $sheet->getStyle("C$startRowParent")->getNumberFormat()->setFormatCode("#,##0.00_);(#,##0.00)");
    //             }
    //             $sheet->getStyle("A" . ($detail_start_row) . ":C" . ($detail_start_row))->applyFromArray($styleArray)->getFont()->setBold(true);

    //             $totalPerMain = "=SUM(B" . ($startRowMain) . ":B" . ($detail_start_row - 1) . ")";
    //             $sheet->setCellValue("A$detail_start_row", "TOTAL $keteranganmain");
    //             $sheet->setCellValue("C$detail_start_row", $totalPerMain);
    //             $sheet->getStyle("C$detail_start_row")->getNumberFormat()->setFormatCode("#,##0.00_);(#,##0.00)");
    //             array_push($sumLaba, 'C' . $detail_start_row);

    //             $detail_start_row += 2;
    //         }
    //         $totalLaba = "=" . implode('+', $sumLaba);
    //         $detail_start_row--;
    //         $sheet->getStyle("A" . ($detail_start_row) . ":C" . ($detail_start_row))->applyFromArray($styleArray)->getFont()->setBold(true);
    //         $sheet->setCellValue("A$detail_start_row", "LABA (RUGI) BERSIH : ");
    //         $sheet->setCellValue("C$detail_start_row", $totalLaba)->getStyle("C$detail_start_row");
    //         $sheet->getStyle("C$detail_start_row")->getNumberFormat()->setFormatCode("#,##0.00_);(#,##0.00)");
    //     }

    //     //ukuran kolom
    //     $sheet->getColumnDimension('A')->setAutoSize(true);
    //     $sheet->getColumnDimension('B')->setAutoSize(true);
    //     $sheet->getColumnDimension('C')->setAutoSize(true);



    //     // menambahkan sel Total pada baris terakhir + 1
    //     // $sheet->setCellValue("A" . ($detail_start_row + 1), 'Total');
    //     // $sheet->setCellValue("D" . ($detail_start_row + 1), "=SUM(D5:D" . $detail_start_row . ")");
    //     // $sheet->setCellValue("E" . ($detail_start_row + 1), "=SUM(E5:E" . $detail_start_row . ")");


    //     //FORMAT
    //     // set format ribuan untuk kolom D dan E
    //     // $sheet->getStyle("B" . ($detail_start_row + 1) . ":B" . ($detail_start_row + 1))->getNumberFormat()->setFormatCode("#,##0.00_);(#,##0.00)_);(#,##0.00_);(#,##0.00))");
    //     // $sheet->getStyle("A" . ($detail_start_row + 1) . ":$lastColumn" . ($detail_start_row + 1))->getFont()->setBold(true);


    //     $detail_start_row++;

    //     // $sheet->setCellValue("A$detail_start_row", "LABA (RUGI) BERSIH : ");
    //     // $sheet->setCellValue("C$detail_start_row", "=$rowPendapatan-ABS(C" . ($detail_start_row - 1) . ")");
    //     // $sheet->getStyle("A$detail_start_row:B$detail_start_row")->applyFromArray($styleArray);            
    //     // $sheet->mergeCells("A$detail_start_row:B$detail_start_row");
    //     // $sheet->getStyle("C$detail_start_row")->applyFromArray($styleArray)->getFont()->setBold(true);
    //     // $sheet->getStyle("C$detail_start_row")->getNumberFormat()->setFormatCode("#,##0.00_);(#,##0.00)_);(#,##0.00_);(#,##0.00))");

    //     $sheet->getColumnDimension('A')->setAutoSize(true);
    //     $sheet->getColumnDimension('B')->setAutoSize(true);
    //     $sheet->getColumnDimension('C')->setAutoSize(true);



    //     $writer = new Xlsx($spreadsheet);
    //     $filename = 'LAPORAN LABA RUGI ' . date('dmYHis');
    //     header('Content-Type: application/vnd.ms-excel');
    //     header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
    //     header('Cache-Control: max-age=0');

    //     $writer->save('php://output');
    // }

    // public function getBulan($bln)
    // {
    //     switch ($bln) {
    //         case 1:
    //             return "JANUARI";
    //             break;
    //         case 2:
    //             return "FEBRUARI";
    //             break;
    //         case 3:
    //             return "MARET";
    //             break;
    //         case 4:
    //             return "APRIL";
    //             break;
    //         case 5:
    //             return "MEI";
    //             break;
    //         case 6:
    //             return "JUNI";
    //             break;
    //         case 7:
    //             return "JULI";
    //             break;
    //         case 8:
    //             return "AGUSTUS";
    //             break;
    //         case 9:
    //             return "SEPTEMBER";
    //             break;
    //         case 10:
    //             return "OKTOBER";
    //             break;
    //         case 11:
    //             return "NOVEMBER";
    //             break;
    //         case 12:
    //             return "DESEMBER";
    //             break;
    //     }
    // }
}

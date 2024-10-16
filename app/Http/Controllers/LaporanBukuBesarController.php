<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;


class LaporanBukuBesarController extends MyController
{
    public $title = 'Laporan Buku Besar';

    public function index(Request $request)
    {
        $title = $this->title;
        $data = [
            'idcabang' => $this->comboList('ID CABANG', 'ID CABANG'),
        ];
        $getCabang = $this->getCabang($data['idcabang']['text']);
        $cabang  = $getCabang['data'];
        return view('laporanbukubesar.index', compact('title', 'data', 'cabang'));
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
        $detailParams = [
            'dari' => $request->dari,
            'sampai' => $request->sampai,
            'coadari_id' => $request->coadari_id,
            'coasampai_id' => $request->coasampai_id,
            'coadari' => $request->coadari,
            'coasampai' => $request->coasampai,
            'cabang_id' => $request->cabang_id,
        ];

        $header = Http::withHeaders(request()->header())
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'laporanbukubesar/report', $detailParams);

        // dd($header);

        $data = $header['data'];
        $dataheader = $header['dataheader'];
        $printer['tipe'] = $request->printer;
        $user = Auth::user();
        $cabang['cabang'] = session('cabang');
        // dd($data, $dataheader);
        return view('reports.laporanbukubesar', compact('data', 'user', 'dataheader', 'printer','cabang'));
    }

    // public function export(Request $request): void
    // {
    //     $detailParams = [
    //         'dari' => $request->dari,
    //         'sampai' => $request->sampai,
    //         'coadari_id' => $request->coadari_id,
    //         'coasampai_id' => $request->coasampai_id,
    //         'coadari' => $request->coadari,
    //         'coasampai' => $request->coasampai,
    //         'cabang_id' => $request->cabang_id,
    //     ];

    //     $responses = Http::withHeaders($request->header())
    //         ->withOptions(['verify' => false])
    //         ->withToken(session('access_token'))
    //         ->get(config('app.api_url') . 'laporanbukubesar/export', $detailParams);

    //     $bukubesar = $responses['data'];
        
    //     if(count($bukubesar) == 0){
    //         throw new \Exception('TIDAK ADA DATA');
    //     }
    //     $dataheader = $responses['dataheader'];
    //     $user = Auth::user();

    //     $spreadsheet = new Spreadsheet();
    //     $sheet = $spreadsheet->getActiveSheet();
    //     $sheet->setCellValue('A1', $bukubesar[0]['judul']);
    //     $sheet->getStyle("A1")->getFont()->setSize(20)->setBold(true);
    //     $sheet->getStyle('A1')->getAlignment()->setHorizontal('center');
    //     $sheet->mergeCells('A1:F1');

    //     $sheet->setCellValue('A2', $dataheader['cabang']);
    //     $sheet->getStyle("A2")->getFont()->setSize(16)->setBold(true);
    //     $sheet->getStyle('A2')->getAlignment()->setHorizontal('center');
    //     $sheet->mergeCells('A2:F2');
    //     $sheet->setCellValue('A3', 'Buku Besar Divisi Trucking');
    //     $sheet->getStyle("A3")->getFont()->setSize(16)->setBold(true);
    //     $sheet->getStyle('A3')->getAlignment()->setHorizontal('center');
    //     $sheet->mergeCells('A3:F3');

    //     $sheet->setCellValue('A4', 'Periode : ' . $dataheader['dari'] . ' s/d ' . $dataheader['sampai']);
    //     $sheet->getStyle("A4")->getFont()->setSize(12)->setBold(true);
    //     $sheet->getStyle('A4')->getAlignment()->setHorizontal('center');
    //     $sheet->mergeCells('A4:F4');

    //     $sheet->setCellValue('A5', 'No Perk. : ' .  $dataheader['coadari'] . ' s/d ' . $dataheader['coasampai']);
    //     $sheet->getStyle("A5")->getFont()->setSize(12)->setBold(true);
    //     $sheet->getStyle('A5')->getAlignment()->setHorizontal('center');
    //     $sheet->mergeCells('A5:F5');

    //     $sheet->setCellValue('A6', ' ' . $dataheader['ketcoadari'] . ' s/d ' . $dataheader['ketcoasampai']);
    //     $sheet->getStyle("A6")->getFont()->setSize(12)->setBold(true);
    //     $sheet->getStyle('A6')->getAlignment()->setHorizontal('center');
    //     $sheet->mergeCells('A6:F6');

    //     $detail_table_header_row = 7;
    //     $detail_start_row = $detail_table_header_row + 1;

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
    //             'label' => 'Tanggal',
    //             'index' => 'tglbukti',
    //         ],
    //         [
    //             'label' => 'No Bukti',
    //             'index' => 'nobukti',
    //         ],
    //         [
    //             'label' => 'Keterangan',
    //             'index' => 'keterangan',
    //         ],
    //         [
    //             'label' => 'Debet',
    //             'index' => 'debet'
    //         ],
    //         [
    //             'label' => 'Kredit',
    //             'index' => 'kredit'
    //         ],
    //         [
    //             'label' => 'Saldo',
    //             'index' => 'Saldo'
    //         ]
    //     ];


    //     // foreach ($detail_columns as $detail_columns_index => $detail_column) {
    //     //     $sheet->setCellValue($alphabets[$detail_columns_index] . $detail_table_header_row, $detail_column['label'] ?? $detail_columns_index + 1);
    //     // }
    //     // $sheet->getStyle("A$detail_table_header_row:F$detail_table_header_row")->getFont()->setBold(true);

    //     // LOOPING DETAIL
    //     $totalKredit = 0;
    //     $totalDebet = 0;
    //     $totalSaldo = 0;
    //     $prevKeteranganCoa = null;
    //     // dd($bukubesar);
    //     $groupedData = [];
    //     if (is_array($bukubesar)) {
    //         foreach ($bukubesar as $row) {
    //             $coa = $row['coa'];
    //             if (!isset($groupedData[$coa])) {
    //                 $groupedData[$coa] = [];
    //             }
    //             $groupedData[$coa][] = $row;
    //         }
    //     }
    //     // dd($groupedData);
    //     // foreach ($bukubesar as $response_index => $response_detail) {

    //     //     if ($response_detail['keterangancoa'] !== $prevKeteranganCoa) {
    //     //         $detail_start_row++;

    //     //         $sheet->setCellValue("A$detail_start_row", $response_detail['coa'].' '.$response_detail['keterangancoa']);
    //     //         $sheet->getStyle("A$detail_start_row")->getFont()->setSize(12)->setBold(true);
    //     //         $sheet->getStyle("A$detail_start_row")->getAlignment()->setHorizontal('center');
    //     //         $sheet->mergeCells("A$detail_start_row:F$detail_start_row");
    //     //         $detail_start_row++;
    //     //     }
    //     //     foreach ($detail_columns as $detail_columns_index => $detail_column) {
    //     //         $sheet->setCellValue($alphabets[$detail_columns_index] . $detail_start_row, isset($detail_column['index']) ? $response_detail[$detail_column['index']] : $response_index + 1);
    //     //     }

    //     //     $sheet->setCellValue("A$detail_start_row", $response_detail['tglbukti']);
    //     //     $sheet->setCellValue("B$detail_start_row", $response_detail['nobukti']);
    //     //     $sheet->setCellValue("C$detail_start_row", $response_detail['keterangan']);
    //     //     $sheet->setCellValue("D$detail_start_row", number_format((float) $response_detail['debet'], '2', ',', '.'));
    //     //     $sheet->setCellValue("E$detail_start_row", number_format((float) $response_detail['kredit'], '2', ',', '.'));
    //     //     $sheet->setCellValue("F$detail_start_row", number_format((float) $response_detail['Saldo'], '2', ',', '.'));

    //     //     $sheet->getStyle("A$detail_start_row:F$detail_start_row")->applyFromArray($styleArray);
    //     //     $sheet->getStyle("D$detail_start_row:F$detail_start_row")->applyFromArray($style_number);

    //     //     $totalKredit += $response_detail['kredit'];
    //     //     $totalDebet += $response_detail['debet'];
    //     //     $totalSaldo += $response_detail['Saldo'];
    //     //     $detail_start_row++;
    //     //     $prevKeteranganCoa = $response_detail['keterangancoa'];
    //     // }
    //     // $detail_start_row++;
    //     // $sheet->mergeCells('A' . $detail_start_row . ':C' . $detail_start_row);
    //     // $sheet->setCellValue("A$detail_start_row", 'Total')->getStyle('A' . $detail_start_row . ':C' . $detail_start_row)->applyFromArray($styleArray)->getFont()->setBold(true);
    //     // $sheet->setCellValue("D$detail_start_row", number_format((float) $totalDebet, '2', ',', '.'))->getStyle("D$detail_start_row")->applyFromArray($style_number)->getFont()->setBold(true);
    //     // $sheet->setCellValue("E$detail_start_row", number_format((float) $totalKredit, '2', ',', '.'))->getStyle("E$detail_start_row")->applyFromArray($style_number)->getFont()->setBold(true);
    //     // $sheet->setCellValue("F$detail_start_row", number_format((float) $totalSaldo, '2', ',', '.'))->getStyle("F$detail_start_row")->applyFromArray($style_number)->getFont()->setBold(true);
    //     if (is_array($bukubesar)) {
    //         // dd($groupedData)
    //         foreach ($groupedData as $coa => $group) {
    //             $sheet->mergeCells("A$detail_start_row:F$detail_start_row");
    //             $sheet->setCellValue("A$detail_start_row", 'Kode Perkiraan : ' . $coa . ' (' . $group[0]['keterangancoa'] . ')')->getStyle('A' . $detail_start_row . ':F' . $detail_start_row);
    //             // $sheet->getStyle("A$detail_start_row")->getFont()->setSize(12)->setBold(true);
    //             // $sheet->getStyle("A$detail_start_row")->getAlignment()->setHorizontal('center');
    //             $detail_start_row++;

    //             // table header
    //             foreach ($detail_columns as $detail_columns_index => $detail_column) {
    //                 $sheet->setCellValue($alphabets[$detail_columns_index] . $detail_start_row, $detail_column['label'] ?? $detail_columns_index + 1);
    //             }
    //             $sheet->getStyle("A$detail_start_row:F$detail_start_row")->getFont()->setBold(true);
    //             $detail_start_row++;


    //             $dataRow = $detail_table_header_row + 2;
    //             $previousRow = $dataRow - 1;
    //             foreach ($group as $response_index => $response_detail) {
    //                 // ... (your existing code for filling in details)
    //                 $dateValue = ($response_detail['tglbukti'] != null) ? Date::PHPToExcel(date('Y-m-d', strtotime($response_detail['tglbukti']))) : '';

    //                 $sheet->setCellValue("A$detail_start_row", $dateValue);
    //                 $sheet->setCellValue("B$detail_start_row", ($response_detail['nobukti'] == '') ? $response_detail['keterangan'] : $response_detail['nobukti']);
    //                 $sheet->setCellValue("C$detail_start_row", ($response_detail['keterangan'] == 'SALDO AWAL') ? '' : $response_detail['keterangan']);
    //                 $sheet->setCellValue("D$detail_start_row", ($response_detail['keterangan'] == 'SALDO AWAL') ? 0 : $response_detail['debet']);
    //                 $sheet->setCellValue("E$detail_start_row", ($response_detail['keterangan'] == 'SALDO AWAL') ? 0 : $response_detail['kredit']);

    //                 if ($response_detail['nobukti'] == '') {
    //                     $sheet->setCellValue('F' . $detail_start_row, $response_detail['Saldo']);
    //                     $previousRow = $detail_start_row;
    //                 } else {
    //                     if ($detail_start_row > $detail_table_header_row + 1) {
    //                         $sheet->setCellValue('F' . $detail_start_row, '=(F' . $previousRow . '+D' . $detail_start_row . ')-E' . $detail_start_row);
    //                     }
    //                 }
    //                 // $sheet->setCellValue("F$detail_start_row", $response_detail['Saldo']);
    //                 // $sheet->getStyle("C$detail_start_row")->getAlignment()->setWrapText(true);
    //                 // $sheet->getColumnDimension('C')->setWidth(150);
    //                 $sheet->getStyle("A$detail_start_row")->getNumberFormat()->setFormatCode('dd-mm-yyyy');
    //                 $sheet->getStyle("D$detail_start_row:F$detail_start_row")->getNumberFormat()->setFormatCode("#,##0.00_);(#,##0.00)");
    //                 $totalKredit += $response_detail['kredit'];
    //                 $totalDebet += $response_detail['debet'];
    //                 $totalSaldo += $response_detail['Saldo'];
    //                 $previousRow = $detail_start_row;
    //                 $detail_start_row++;
    //                 $prevKeteranganCoa = $response_detail['keterangancoa'];
    //             }
    //             // Display the group totals at the end of the group
    //             // $sheet->mergeCells('A' . $detail_start_row . ':C' . $detail_start_row);
    //             $sheet->setCellValue("C$detail_start_row", 'Total')->getStyle('C' . $detail_start_row)->getFont()->setBold(true);
    //             $sheet->setCellValue("D$detail_start_row", "=SUM(D" . ($detail_start_row - count($group)) . ":D" . ($detail_start_row - 1) . ")")->getStyle("D$detail_start_row")->getFont()->setBold(true);
    //             $sheet->setCellValue("E$detail_start_row", "=SUM(E" . ($detail_start_row - count($group)) . ":E" . ($detail_start_row - 1) . ")")->getStyle("E$detail_start_row")->getFont()->setBold(true);
    //             // $sheet->setCellValue("F$detail_start_row", "=F" . ($detail_start_row - 1))->getStyle("F$detail_start_row")->applyFromArray($style_number)->getFont()->setBold(true);

    //             $sheet->getStyle("D$detail_start_row:F$detail_start_row")->getNumberFormat()->setFormatCode("#,##0.00_);(#,##0.00)");
    //             $detail_start_row += 2; // Add an empty row between groups
    //         }
    //     }

    //     $ttd_start_row = $detail_start_row + 2;
    //     $sheet->setCellValue("A$ttd_start_row", 'Disetujui Oleh,');
    //     $sheet->setCellValue("C$ttd_start_row", 'Diperiksa Oleh,');
    //     $sheet->setCellValue("F$ttd_start_row", 'Disusun Oleh,');

    //     $sheet->setCellValue("A" . ($ttd_start_row + 3), '(                )');
    //     $sheet->setCellValue("C" . ($ttd_start_row + 3), '(                )');
    //     $sheet->setCellValue("F" . ($ttd_start_row + 3), '(                )');

    //     $sheet->getColumnDimension('C')->setWidth(87);
    //     $sheet->getColumnDimension('A')->setWidth(12);
    //     $sheet->getColumnDimension('B')->setWidth(18);
    //     $sheet->getColumnDimension('D')->setAutoSize(true);
    //     $sheet->getColumnDimension('E')->setAutoSize(true);
    //     $sheet->getColumnDimension('F')->setAutoSize(true);



    //     $writer = new Xlsx($spreadsheet);
    //     $filename = 'LAPORAN BUKU BESAR ' . date('dmYHis');
    //     header('Content-Type: application/vnd.ms-excel');
    //     header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
    //     header('Cache-Control: max-age=0');

    //     $writer->save('php://output');
    // }
}

<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use PHPExcel_Shared_Date;

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


class LaporanKasGantungController extends MyController
{
    public $title = 'Laporan Kas Gantung';

    public function index(Request $request)
    {
        $title = $this->title;
        $bank = DB::table('bank')->where('tipe','KAS')->first();
        $data = [
            'pagename' => 'Menu Utama Laporan Kas Gantung',
            'bank_id' => $bank->id,
            'bank' => $bank->namabank
        ];
        return view('laporankasgantung.index', compact('title','data'));
    }

    public function report(Request $request)
    {
        $detailParams = [
            'periode' => $request->periode,
            'bank_id' => $request->bank_id,
            'bank' => $request->bank,
        ];

        $header = Http::withHeaders(request()->header())
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'laporankasgantung/report', $detailParams);


        $data = $header['data'];
        $dataCabang['namacabang'] = $header['namacabang'];
        $user = Auth::user();

        $printer['tipe'] = $request->printer;

        $cabang['cabang'] = session('cabang');

        return view('reports.laporankasgantung', compact('data', 'dataCabang', 'user', 'detailParams', 'printer','cabang'));
    }


    // public function export(Request $request): void
    // {
    //     $detailParams = [
    //         'periode' => $request->periode,
    //         'bank_id' => $request->bank_id,
    //     ];
    //     $responses = Http::withHeaders($request->header())
    //         ->withOptions(['verify' => false])
    //         ->withToken(session('access_token'))
    //         ->get(config('app.api_url') . 'laporankasgantung/export', $detailParams);

    //     $pengeluaran = $responses['data'];
    //     if (count($pengeluaran) == 0) {
    //         throw new \Exception('TIDAK ADA DATA');
    //     }
    //     $namacabang = $responses['namacabang'];
    //     $disetujui = $pengeluaran[0]['disetujui'] ?? '';
    //     $diperiksa = $pengeluaran[0]['diperiksa'] ?? '';
    //     $user = Auth::user();

    //     $spreadsheet = new Spreadsheet();
    //     $sheet = $spreadsheet->getActiveSheet();

    //     $sheet->setCellValue('A1', $pengeluaran[0]['judul'] ?? '');
    //     $sheet->getStyle("A1")->getFont()->setSize(16)->setBold(true);
    //     $sheet->getStyle('A1')->getAlignment()->setHorizontal('center');
    //     $sheet->mergeCells('A1:F1');
    //     $sheet->setCellValue('A2', $namacabang ?? '');
    //     $sheet->getStyle("A2")->getFont()->setSize(16)->setBold(true);
    //     $sheet->getStyle('A2')->getAlignment()->setHorizontal('center');
    //     $sheet->mergeCells('A2:F2');
    //     $sheet->setCellValue('A3',  $pengeluaran[0]['judulLaporan'] ?? '');
    //     $sheet->mergeCells('A3:B3');
    //     $sheet->setCellValue('A4', 'Periode: ' . date('d-M-Y', strtotime($request->periode)));
    //     $sheet->mergeCells('A4:B4');
    //     $sheet->getStyle("A3")->getFont()->setBold(true);
    //     $sheet->getStyle("A4:B4")->getFont()->setBold(true);

    //     $sheet->getStyle("A1")->getFont()->setSize(16)->setBold(true);
    //     $sheet->getStyle('A1')->getAlignment()->setHorizontal('center');


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

    //         'borders' => [
    //             'top' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
    //             'right' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
    //             'bottom' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
    //             'left' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN]
    //         ]
    //     ];

    //     $alphabets = range('A', 'Z');



    //     $header_columns = [
    //         [
    //             'label' => 'Tgl Bukti',
    //             'index' => 'tanggal',
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
    //             'index' => 'debet',
    //         ],
    //         [
    //             'label' => 'Kredit',
    //             'index' => 'kredit',
    //         ],
    //         [
    //             'label' => 'Saldo',
    //             'index' => 'Saldo',
    //         ],
    //     ];


    //     foreach ($header_columns as $data_columns_index => $data_column) {
    //         $sheet->setCellValue($alphabets[$data_columns_index] . $header_start_row, $data_column['label'] ?? $data_columns_index + 1);
    //     }

    //     $sheet->getStyle("A$header_start_row:F$header_start_row")->applyFromArray($styleArray)->getFont()->setBold(true);


    //     $lastColumn = $alphabets[$data_columns_index];
    //     $sheet->getStyle("A$header_start_row:$lastColumn$header_start_row")->getFont()->setBold(true);
    //     $totalDebet = 0;
    //     $totalKredit = 0;
    //     $totalSaldo = 0;
    //     $dataRow = $header_start_row + 1;
    //     $previousRow = $dataRow - 1; 
    //     if (is_array($pengeluaran) || is_iterable($pengeluaran)) {
    //         foreach ($pengeluaran as $response_index => $response_detail) {

    //             foreach ($header_columns as $detail_columns_index => $detail_column) {
    //                 $sheet->setCellValue($alphabets[$detail_columns_index] . $detail_start_row, isset($detail_column['index']) ? $response_detail[$detail_column['index']] : $response_index + 1);
    //             }

    //             $dateValue = ($response_detail['tanggal'] != null) ? Date::PHPToExcel(date('Y-m-d', strtotime($response_detail['tanggal']))) : '';
    //             $sheet->setCellValue("A$detail_start_row", $dateValue);
    //             $sheet->getStyle("A$detail_start_row")
    //                 ->getNumberFormat()
    //                 ->setFormatCode('dd-mm-yyyy');
    //             $sheet->setCellValue("B$detail_start_row", $response_detail['nobukti']);
    //             $sheet->setCellValue("C$detail_start_row", $response_detail['keterangan']);
    //             $sheet->setCellValue("D$detail_start_row", $response_detail['debet']);
    //             $sheet->setCellValue("E$detail_start_row", $response_detail['kredit']);

    //             if ($detail_start_row == 7) {
    //                 $sheet->setCellValue('F' . $detail_start_row, $response_detail['Saldo']);
    //             } else {
    //                 if ($dataRow > $header_start_row + 1) {
    //                     $sheet->setCellValue('F' . $dataRow, '=(F' . $previousRow . '+D' . $dataRow . ')-E' . $dataRow);
    //                 }
    //             }

    //             $sheet->getStyle("A$detail_start_row:F$detail_start_row")->applyFromArray($styleArray);
    //             $sheet->getStyle("D$detail_start_row:F$detail_start_row")->getNumberFormat()->setFormatCode("#,##0.00");
    //             $sheet->getStyle("A$detail_start_row:A$detail_start_row")->getNumberFormat()->setFormatCode('dd-mm-yyyy');

    //             $previousRow = $dataRow;
    //             $totalKredit += $response_detail['kredit'];
    //             $totalDebet += $response_detail['debet'];
    //             $totalSaldo += $response_detail['Saldo'];
    //             $detail_start_row++;
    //             $dataRow++;
    //         }
    //     }


    //     //ukuran kolom
    //     $sheet->getColumnDimension('A')->setAutoSize(true);
    //     $sheet->getColumnDimension('B')->setAutoSize(true);
    //     $sheet->getColumnDimension('C')->setWidth(72);
    //     $sheet->getColumnDimension('D')->setAutoSize(true);
    //     $sheet->getColumnDimension('E')->setAutoSize(true);
    //     $sheet->getColumnDimension('F')->setAutoSize(true);

    //     // menambahkan sel Total pada baris terakhir + 1
    //     // $sheet->setCellValue("A" . ($detail_start_row ), 'Total');
    //     $total_start_row = $detail_start_row;
    //     $sheet->mergeCells('A' . $total_start_row . ':C' . $total_start_row);
    //     $sheet->setCellValue("A$total_start_row", 'Total')->getStyle('A' . $total_start_row . ':C' . $total_start_row)->applyFromArray($styleArray)->getFont()->setBold(true);

    //     $totalDebet = "=SUM(D7:D" . ($detail_start_row - 1) . ")";
    //     $sheet->setCellValue("D" . ($detail_start_row), "=SUM(D7:D" . $detail_start_row . ")");
    //     $sheet->setCellValue("D$total_start_row", $totalDebet)->getStyle("D$total_start_row")->applyFromArray($style_number)->getFont()->setBold(true);
    //     $sheet->setCellValue("D$total_start_row", $totalDebet)->getStyle("D$total_start_row")->getNumberFormat()->setFormatCode("#,##0.00");

    //     $totalKredit = "=SUM(E7:E" . ($detail_start_row - 1) . ")";
    //     $sheet->setCellValue("E" . ($detail_start_row), "=SUM(E7:E" . $detail_start_row . ")");
    //     $sheet->setCellValue("E$total_start_row", $totalKredit)->getStyle("E$total_start_row")->applyFromArray($style_number)->getFont()->setBold(true);
    //     $sheet->setCellValue("E$total_start_row", $totalKredit)->getStyle("E$total_start_row")->getNumberFormat()->setFormatCode("#,##0.00");

    //     $totalSaldo = "=D" . $total_start_row . "-E" . $total_start_row;
    //     $sheet->setCellValue("F$total_start_row", $totalSaldo)->getStyle("F$total_start_row")->applyFromArray($style_number)->getFont()->setBold(true);
    //     $sheet->setCellValue("F$total_start_row", $totalSaldo)->getStyle("F$total_start_row")->getNumberFormat()->setFormatCode("#,##0.00");



    //     //FORMAT
    //     // set format ribuan untuk kolom D dan E
    //     $sheet->getStyle("D" . ($detail_start_row) . ":E" . ($detail_start_row))->getNumberFormat()->setFormatCode("#,##0.00");
    //     $sheet->getStyle("A" . ($detail_start_row) . ":$lastColumn" . ($detail_start_row))->getFont()->setBold(true);


    //     //persetujuan
    //     $sheet->mergeCells('A' . ($detail_start_row + 3) . ':B' . ($detail_start_row + 3));
    //     $sheet->setCellValue('A' . ($detail_start_row + 3), 'Disetujui Oleh,');
    //     $sheet->mergeCells('C' . ($detail_start_row + 3) . ($detail_start_row + 3));
    //     $sheet->setCellValue('C' . ($detail_start_row + 3), 'Diperiksa Oleh');
    //     $sheet->mergeCells('D' . ($detail_start_row + 3) . ':E' . ($detail_start_row + 3));
    //     $sheet->setCellValue('D' . ($detail_start_row + 3), 'Disusun Oleh,');


    //     $sheet->mergeCells('A' . ($detail_start_row + 6) . ':B' . ($detail_start_row + 6));
    //     $sheet->setCellValue('A' . ($detail_start_row + 6), '( ' . $disetujui . ' )');
    //     $sheet->mergeCells('C' . ($detail_start_row + 6) . ($detail_start_row + 6));
    //     $sheet->setCellValue('C' . ($detail_start_row + 6), '( ' . $diperiksa . ' )');
    //     $sheet->mergeCells('D' . ($detail_start_row + 6) . ':E' . ($detail_start_row + 6));
    //     $sheet->setCellValue('D' . ($detail_start_row + 6), '(                                 )');


    //     // style persetujuan
    //     $sheet->getStyle('A' . ($detail_start_row + 3))->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
    //     $sheet->getStyle('A' . ($detail_start_row + 3))->getFont()->setSize(12);
    //     $sheet->getStyle('C' . ($detail_start_row + 3))->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
    //     $sheet->getStyle('C' . ($detail_start_row + 3))->getFont()->setSize(12);
    //     $sheet->getStyle('D' . ($detail_start_row + 3))->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
    //     $sheet->getStyle('D' . ($detail_start_row + 3))->getFont()->setSize(12);


    //     $sheet->getStyle('A' . ($detail_start_row + 6))->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
    //     $sheet->getStyle('A' . ($detail_start_row + 6))->getFont()->setSize(12);
    //     $sheet->getStyle('C' . ($detail_start_row + 6))->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
    //     $sheet->getStyle('C' . ($detail_start_row + 6))->getFont()->setSize(12);
    //     $sheet->getStyle('D' . ($detail_start_row + 6))->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
    //     $sheet->getStyle('D' . ($detail_start_row + 6))->getFont()->setSize(12);

    //     // mengatur border top dan bottom pada cell Total
    //     $border_style = [
    //         'borders' => [
    //             'top' => ['borderStyle' => 'thin', 'color' => ['rgb' => '000000']],
    //             'bottom' => ['borderStyle' => 'thin', 'color' => ['rgb' => '000000']]
    //         ]
    //     ];
    //     $sheet->getStyle("A" . ($detail_start_row) . ":$lastColumn" . ($detail_start_row))->applyFromArray($border_style);





    //     $writer = new Xlsx($spreadsheet);
    //     $filename = 'EXPORTKASGANTUNG' . date('dmYHis');
    //     header('Content-Type: application/vnd.ms-excel');
    //     header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
    //     header('Cache-Control: max-age=0');

    //     $writer->save('php://output');
    // }
}

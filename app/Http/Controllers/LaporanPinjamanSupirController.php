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
use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;


class LaporanPinjamanSupirController extends MyController
{
    public $title = 'Laporan Pinjaman Supir';

    public function index(Request $request)
    {
        $title = $this->title;
        $data = [
            'pagename' => 'Menu Utama Laporan Pinjaman Supir',
        ];

        return view('laporanpinjamansupir.index', compact('title'));
    }

    public function report(Request $request)
    {
        $detailParams = [
            'sampai' => $request->sampai,
            'jenis' => $request->jenis,
        ];
        $header = Http::withHeaders(request()->header())
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'laporanpinjamansupir/report', $detailParams);
            
        if ($header->successful()) {
            $data = $header['data'];
            $user = Auth::user();
            $cabang = session('cabang');
            return view('reports.laporanpinjamansupir', compact('data', 'user', 'detailParams','cabang'));
        } else {
            return response()->json($header->json(), $header->status());
        }
    }

    // public function export(Request $request): void
    // {
    //     $detailParams = [
    //         'sampai' => $request->sampai,
    //         'jenis' => $request->jenis,
    //     ];

    //     $header = Http::withHeaders(request()->header())
    //         ->withOptions(['verify' => false])
    //         ->withToken(session('access_token'))
    //         ->get(config('app.api_url') . 'laporanpinjamansupir/export', $detailParams);

    //     $data = $header['data'];
    //     if(count($data) == 0){
    //         throw new \Exception('TIDAK ADA DATA');
    //     }
    //     $disetujui = $data[0]['disetujui'] ?? '';
    //     $diperiksa = $data[0]['diperiksa'] ?? '';

    //     $spreadsheet = new Spreadsheet();
    //     $sheet = $spreadsheet->getActiveSheet();
        
    //     $sheet->setCellValue('A1', $data[0]['judul'] ?? '');
    //     $sheet->getStyle("A1")->getFont()->setSize(16)->setBold(true);
    //     $sheet->getStyle('A1')->getAlignment()->setHorizontal('center');
    //     $sheet->mergeCells('A1:G1');        
    //     $sheet->setCellValue('A2',  $data[0]['judulLaporan'] ?? '');
    //     $sheet->mergeCells('A2:B2');        
    //     $sheet->setCellValue('A3', 'Periode: ' . date('d-M-Y', strtotime($request->sampai)) );
    //     $sheet->mergeCells('A3:B3');       
    //     $sheet->getStyle("A2")->getFont()->setBold(true);
    //     $sheet->getStyle("A3:B3")->getFont()->setBold(true);        
        

    //     // $sheet = $spreadsheet->getActiveSheet();
    //     // $sheet->setCellValue('b1', 'LAPORAN PINJAMAN SUPIR');
    //     $sheet->getStyle("A1")->getFont()->setSize(16)->setBold(true);
    //     $sheet->getStyle('A1')->getAlignment()->setHorizontal('center');

    //     // $sheet->setCellValue('A4', 'PERIODE');
    //     // $sheet->getStyle("A4")->getFont()->setSize(12)->setBold(true);

    //     // $sheet->setCellValue('B4', $request->periode);
    //     // $sheet->setCellValue('B4', ':'." ".$request->periode);
    //     // $sheet->getStyle("B4")->getFont()->setSize(12)->setBold(true);


    //     $detail_table_header_row = 5;
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

    //     $header_columns = [
    //         [
    //             'label' => 'Tgl Bukti',
    //             'index' => 'tglbukti',
    //         ],
    //         [
    //             'label' => 'No Bukti',
    //             'index' => 'nobukti',
    //         ],
    //         [
    //             'label' => 'Nama Supir',
    //             'index' => 'namasupir',
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

    //     foreach ($header_columns as $detail_columns_index => $detail_column) {
    //         $sheet->setCellValue($alphabets[$detail_columns_index] . $detail_table_header_row, $detail_column['label'] ?? $detail_columns_index + 1);
    //     }
    //     $sheet->getStyle("A$detail_table_header_row:G$detail_table_header_row")->applyFromArray($styleArray)->getFont()->setBold(true);

    //     // LOOPING DETAIL
    //     $totalDebet = 0;
    //     $totalKredit = 0;
    //     $totalSaldo = 0;
    //     $dataRow = $detail_table_header_row + 1;
    //     $previousRow = $dataRow - 1; // Initialize the previous row number
    //     foreach ($data as $response_index => $response_detail) {

    //         foreach ($header_columns as $detail_columns_index => $detail_column) {
    //             $sheet->setCellValue($alphabets[$detail_columns_index] . $detail_start_row, isset($detail_column['index']) ? $response_detail[$detail_column['index']] : $response_index + 1);
    //         }

    //         $dateValue = ($response_detail['tglbukti'] != null) ? Date::PHPToExcel(date('Y-m-d',strtotime($response_detail['tglbukti']))) : ''; 
    //         $sheet->setCellValue("A$detail_start_row", $dateValue);
    //         $sheet->getStyle("A$detail_start_row") 
    //         ->getNumberFormat() 
    //         ->setFormatCode('dd-mm-yyyy');
    //         $sheet->setCellValue("B$detail_start_row", $response_detail['nobukti']);
    //         $sheet->setCellValue("C$detail_start_row", $response_detail['namasupir']);
    //         $sheet->setCellValue("D$detail_start_row", $response_detail['keterangan']);
    //         $sheet->setCellValue("E$detail_start_row", $response_detail['debet']);
    //         $sheet->setCellValue("F$detail_start_row", $response_detail['kredit']);
    //         // $sheet->setCellValue("F$detail_start_row", $response_detail['Saldo']);

    //         if($detail_start_row == 6){
    //             $sheet->setCellValue('G' . $detail_start_row, $response_detail['Saldo']);
    //         }else{
    //             if ($dataRow > $detail_table_header_row + 1) {
    //                 $sheet->setCellValue('G' . $dataRow, '=(G' . $previousRow . '+E' . $dataRow . ')-F' . $dataRow);
    //             }
    //         }

    //         $sheet->getStyle("A$detail_start_row:G$detail_start_row")->applyFromArray($styleArray);
    //          $sheet->getStyle("E$detail_start_row:G$detail_start_row")->getNumberFormat()->setFormatCode("#,##0.00_);(#,##0.00)");
    //          $sheet->getStyle("A$detail_start_row:A$detail_start_row")->getNumberFormat()->setFormatCode('dd-mm-yyyy');
           
    //         //  $sheet->getStyle("D$detail_start_row")->getAlignment()->setWrapText(true);
    //          $sheet->getColumnDimension('D')->setWidth(100);
    //          $previousRow = $dataRow; // Update the previous row number

    //          $dataRow++;
    //        $totalKredit += $response_detail['kredit'];
    //         $totalDebet += $response_detail['debet'];
    //         $totalSaldo += $response_detail['Saldo'];
    //         $detail_start_row++;
    //     }



    //    //total
    //    $total_start_row = $detail_start_row;
    //    $sheet->mergeCells('A' . $total_start_row . ':D' . $total_start_row);
    //    $sheet->setCellValue("A$total_start_row", 'Total')->getStyle('A' . $total_start_row . ':D' . $total_start_row)->applyFromArray($styleArray)->getFont()->setBold(true);

    //    $totalDebet = "=SUM(E6:E" . ($detail_start_row-1) . ")";
    //    $sheet->setCellValue("E$total_start_row", $totalDebet)->getStyle("E$total_start_row")->applyFromArray($style_number);
    //    $sheet->setCellValue("E$total_start_row", $totalDebet)->getStyle("E$total_start_row")->getNumberFormat()->setFormatCode("#,##0.00_);(#,##0.00)");

    //    $totalKredit = "=SUM(F6:F" . ($detail_start_row-1) . ")";
    //    $sheet->setCellValue("F$total_start_row", $totalKredit)->getStyle("F$total_start_row")->applyFromArray($style_number);
    //    $sheet->setCellValue("F$total_start_row", $totalKredit)->getStyle("F$total_start_row")->getNumberFormat()->setFormatCode("#,##0.00_);(#,##0.00)");

    //    $totalSaldo = "=E".$total_start_row."-F" .$total_start_row;
    //    $sheet->setCellValue("G$total_start_row", $totalSaldo)->getStyle("G$total_start_row")->applyFromArray($style_number);
    //    $sheet->setCellValue("G$total_start_row", $totalSaldo)->getStyle("G$total_start_row")->getNumberFormat()->setFormatCode("#,##0.00_);(#,##0.00)");

    //     $ttd_start_row = $detail_start_row + 2;
    //     $sheet->setCellValue("A$ttd_start_row", 'Disetujui Oleh,');
    //     $sheet->setCellValue("D$ttd_start_row", 'Diperiksa Oleh,');
    //     $sheet->setCellValue("G$ttd_start_row", 'Disusun Oleh,');

    //     $sheet->setCellValue("A" . ($ttd_start_row + 3), '( ' . $disetujui . ' )');
    //     $sheet->setCellValue("D" . ($ttd_start_row + 3), '( ' . $diperiksa . ' )');
    //     $sheet->setCellValue("G" . ($ttd_start_row + 3), '(                )');

    //     $sheet->getColumnDimension('A')->setAutoSize(true);
    //     $sheet->getColumnDimension('B')->setAutoSize(true);
    //     $sheet->getColumnDimension('C')->setAutoSize(true);
    //     $sheet->getColumnDimension('D')->setWidth(72);
    //     $sheet->getColumnDimension('E')->setAutoSize(true);
    //     $sheet->getColumnDimension('F')->setAutoSize(true);
    //     $sheet->getColumnDimension('G')->setAutoSize(true);



    //     $writer = new Xlsx($spreadsheet);
    //     $filename = 'LAPORAN PINJAMAN SUPIR' . date('dmYHis');
    //     header('Content-Type: application/vnd.ms-excel');
    //     header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
    //     header('Cache-Control: max-age=0');

    //     $writer->save('php://output');
    // }
}

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


class LaporanHutangBBMController extends MyController
{
    public $title = 'Laporan Hutang BBM';

    public function index(Request $request)
    {
        $title = $this->title;
        $data = [
            'pagename' => 'Menu Utama Laporan Hutang BBM',
        ];

        return view('laporanhutangbbm.index', compact('title'));
    }

    public function report(Request $request)
    {
        $detailParams = [
            'sampai' => $request->sampai,
            'jenis' => $request->jenis,
        ];

        // dd($detailParams);

        $header = Http::withHeaders(request()->header())
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'laporanhutangbbm/report', $detailParams);


        $data = $header['data'];
        $dataCabang['namacabang'] = $header['namacabang'];
        $user = Auth::user();
        $cabang['cabang'] = session('cabang');
        return view('reports.laporanhutangbbm', compact('data','dataCabang', 'user', 'detailParams','cabang'));
    }
    
    // public function export(Request $request): void
    // {
    //     $detailParams = [
    //         'sampai' => $request->sampai,
    //     ];

    //     $header = Http::withHeaders(request()->header())
    //         ->withOptions(['verify' => false])
    //         ->withToken(session('access_token'))
    //         ->get(config('app.api_url') . 'laporanhutangbbm/export', $detailParams);

    //     $data = $header['data'];

    //     if(count($data) == 0){
    //         throw new \Exception('TIDAK ADA DATA');
    //     }
    //     $namacabang = $header['namacabang'];

    //     $disetujui = $data[0]['disetujui'] ?? '';
    //     $diperiksa = $data[0]['diperiksa'] ?? '';

    //     $spreadsheet = new Spreadsheet();
    //     $sheet = $spreadsheet->getActiveSheet();

    //     $sheet = $spreadsheet->getActiveSheet();
    //     $englishMonths = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
    //     $indonesianMonths = ['JANUARI', 'FEBRUARI', 'MARET', 'APRIL', 'MEI', 'JUNI', 'JULI', 'AGUSTUS', 'SEPTEMBER', 'OKTOBER', 'NOVEMBER', 'DESEMBER'];
    //     $tanggal = str_replace($englishMonths, $indonesianMonths, date('d - M - Y', strtotime($request->sampai)));

    //     $sheet->setCellValue('A1', $data[0]['judul'] ?? '');
    //     $sheet->setCellValue('A2', $namacabang ?? '');
    //     $sheet->setCellValue('A3', $data[0]['judulLaporan'] ?? '');
    //     $sheet->setCellValue('A4', 'PERIODE : ' . $tanggal);
    //     $sheet->getStyle("A1")->getFont()->setSize(16)->setBold(true);
    //     $sheet->getStyle('A1')->getAlignment()->setHorizontal('center');
    //     $sheet->getStyle("A2")->getFont()->setSize(16)->setBold(true);
    //     $sheet->getStyle('A2')->getAlignment()->setHorizontal('center');
    //     $sheet->getStyle("A3")->getFont()->setBold(true);        
    //     $sheet->getStyle("A4")->getFont()->setBold(true);

    //     $sheet->mergeCells('A1:F1');
    //     $sheet->mergeCells('A2:F2');


    //     $detail_table_header_row = 6;
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
    //             'label' => 'Tanggal',
    //             'index' => 'tanggal',
    //         ],
    //         [
    //             'label' => 'Keterangan',
    //             'index' => 'keterangan',
    //         ],
    //         [
    //             'label' => 'Nominal',
    //             'index' => 'nominal',
    //         ],
    //         [
    //             'label' => 'Saldo',
    //             'index' => 'Saldo',
    //         ],

    //     ];

    //     foreach ($header_columns as $detail_columns_index => $detail_column) {
    //         $sheet->setCellValue($alphabets[$detail_columns_index] . $detail_table_header_row, $detail_column['label'] ?? $detail_columns_index + 1);
    //     }
    //     $sheet->getStyle("A$detail_table_header_row:D$detail_table_header_row")->applyFromArray($styleArray)->getFont()->setBold(true);

    //     // LOOPING DETAIL
    //     $totalNominal = 0;

    //     foreach ($data as $response_index => $response_detail) {

    //         foreach ($header_columns as $detail_columns_index => $detail_column) {
    //             $sheet->setCellValue($alphabets[$detail_columns_index] . $detail_start_row, isset($detail_column['index']) ? $response_detail[$detail_column['index']] : $response_index + 1);
    //         }
    //         $dateValue = ($response_detail['tanggal'] != null) ? Date::PHPToExcel(date('Y-m-d',strtotime($response_detail['tanggal']))) : ''; 
    //         $sheet->setCellValue("A$detail_start_row", $dateValue);
    //         $sheet->setCellValue("B$detail_start_row", $response_detail['keterangan']);
    //         $sheet->setCellValue("C$detail_start_row", $response_detail['nominal']);
    //         $sheet->setCellValue("D$detail_start_row", $response_detail['Saldo']);


    //         $sheet->getStyle("A$detail_start_row:D$detail_start_row")->applyFromArray($styleArray);
    //         $sheet->getStyle("C$detail_start_row:D$detail_start_row")->getNumberFormat()->setFormatCode("#,##0.00_);(#,##0.00)");
    //         $sheet->getStyle("A$detail_start_row:A$detail_start_row")->getNumberFormat()->setFormatCode('dd-mm-yyyy');


    //         $totalNominal += $response_detail['nominal'];
    //         $detail_start_row++;
    //     }



    //     //total
    //     $total_start_row = $detail_start_row;
    //     $sheet->mergeCells('A' . $total_start_row . ':B' . $total_start_row);
    //     $sheet->setCellValue("A$total_start_row", 'Total')->getStyle('A' . $total_start_row . ':B' . $total_start_row)->applyFromArray($styleArray)->getFont()->setBold(true);

    //     $totalFull = "=SUM(C6:C" . ($detail_start_row - 1) . ")";
    //     $sheet->setCellValue("C$total_start_row", $totalFull)->getStyle("C$total_start_row")->applyFromArray($style_number)->getFont()->setBold(true);;
    //     $sheet->setCellValue("C$total_start_row", $totalFull)->getStyle("C$total_start_row")->getNumberFormat()->setFormatCode("#,##0.00_);(#,##0.00)");

    //     $sheet->getStyle("D$detail_start_row:D$detail_start_row")->applyFromArray($styleArray);

    //     $ttd_start_row = $detail_start_row + 2;
    //     $sheet->setCellValue("A$ttd_start_row", 'Disetujui Oleh,');
    //     $sheet->setCellValue("B$ttd_start_row", 'Diperiksa Oleh,');
    //     $sheet->setCellValue("C$ttd_start_row", 'Disusun Oleh,');

    //     $sheet->setCellValue("A" . ($ttd_start_row + 3), '( ' . $disetujui . ' )');
    //     $sheet->setCellValue("B" . ($ttd_start_row + 3), '( ' . $diperiksa . ' )');
    //     $sheet->setCellValue("C" . ($ttd_start_row + 3), '(                )');

    //     $sheet->getColumnDimension('A')->setWidth(28);
    //     $sheet->getColumnDimension('B')->setWidth(100);
    //     $sheet->getColumnDimension('C')->setAutoSize(true);
    //     $sheet->getColumnDimension('D')->setAutoSize(true);



    //     $writer = new Xlsx($spreadsheet);
    //     $filename = 'LAPORAN HUTANG BBM ' . date('dmYHis');
    //     header('Content-Type: application/vnd.ms-excel');
    //     header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
    //     header('Cache-Control: max-age=0');

    //     $writer->save('php://output');
    // }
}

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


class LaporanTripTradoController extends MyController
{
    public $title = 'Laporan Trip Trado';

    public function index(Request $request)
    {
        $title = $this->title;
        $data = [
            'pagename' => 'Menu Utama Laporan Trip Trado',
        ];

        return view('laporantriptrado.index', compact('title'));
    }

    public function report(Request $request)
    {
        $detailParams = [
            'sampai' => $request->sampai,
            'dari' => $request->dari,
        ];
        
        $header = Http::withHeaders(request()->header())
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'laporantriptrado/report', $detailParams);

        $data = $header['data'];
        $dataCabang['namacabang'] = $header['namacabang'];
        $user = Auth::user();
        $cabang['cabang'] = session('cabang');

        return view('reports.laporantriptrado', compact('data','dataCabang', 'user', 'detailParams','cabang'));
    }
    
    // public function export(Request $request): void
    // {
    //     $detailParams = [
    //         'sampai' => $request->sampai,
    //         'dari' => $request->dari,
    //     ];
        
    //     $header = Http::withHeaders(request()->header())
    //         ->withOptions(['verify' => false])
    //         ->withToken(session('access_token'))
    //         ->get(config('app.api_url') . 'laporantriptrado/report', $detailParams);

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
    //     $sheet->setCellValue('A1', $data[0]['judul']);
    //     $sheet->setCellValue('A2', $namacabang);
    //     $sheet->getStyle("A1")->getFont()->setSize(16)->setBold(true);
    //     $sheet->getStyle('A1')->getAlignment()->setHorizontal('center');
    //     $sheet->mergeCells('A1:F1');
    //     $sheet->getStyle("A2")->getFont()->setSize(16)->setBold(true);
    //     $sheet->getStyle('A2')->getAlignment()->setHorizontal('center');
    //     $sheet->mergeCells('A2:F2');
        
    //     $sheet->setCellValue('A3', $data[0]['judulLaporan']);
    //     $sheet->setCellValue('A4', 'PERIODE : '.date('d-M-Y', strtotime($detailParams['dari'])) . ' s/d ' . date('d-M-Y', strtotime($detailParams['sampai'])));
    //     $sheet->getStyle("A3")->getFont()->setBold(true);        
    //     $sheet->getStyle("A4")->getFont()->setBold(true);
    //     $sheet->mergeCells('A4:B4');


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
    //             'label' => 'No Polisi',
    //             'index' => 'NoPol',
    //         ],
    //         [
    //             'label' => 'Trip Full',
    //             'index' => 'full',
    //         ],
    //         [
    //             'label' => 'Trip Empty',
    //             'index' => 'empty',
    //         ],
    //         [
    //             'label' => 'Supir',
    //             'index' => 'NamaSupir',
    //         ],
    //         [
    //             'label' => 'Full Port',
    //             'index' => 'fullport',
    //         ],
    //         [
    //             'label' => 'Empty Port',
    //             'index' => 'emptyport',
    //         ],
           
    //     ];

    //     foreach ($header_columns as $detail_columns_index => $detail_column) {
    //         $sheet->setCellValue($alphabets[$detail_columns_index] . $detail_table_header_row, $detail_column['label'] ?? $detail_columns_index + 1);
    //     }
    //     $sheet->getStyle("A$detail_table_header_row:F$detail_table_header_row")->applyFromArray($styleArray)->getFont()->setBold(true);

    //     // LOOPING DETAIL
    //     $totalFull = 0;
    //     $totalEmpty = 0;
    //     $totalFullPort = 0;
    //     $totalEmptyPort = 0;
       
    //     foreach ($data as $response_index => $response_detail) {

    //         foreach ($header_columns as $detail_columns_index => $detail_column) {
    //             $sheet->setCellValue($alphabets[$detail_columns_index] . $detail_start_row, isset($detail_column['index']) ? $response_detail[$detail_column['index']] : $response_index + 1);
    //         }

    //         $sheet->setCellValue("A$detail_start_row", $response_detail['NoPol']);
    //         $sheet->setCellValue("B$detail_start_row", $response_detail['full']);
    //         $sheet->setCellValue("C$detail_start_row", $response_detail['empty']);
    //         $sheet->setCellValue("D$detail_start_row", $response_detail['NamaSupir']);
    //         $sheet->setCellValue("E$detail_start_row", $response_detail['fullport']);
    //         $sheet->setCellValue("F$detail_start_row", $response_detail['emptyport']);
           

    //         $sheet->getStyle("A$detail_start_row:F$detail_start_row")->applyFromArray($styleArray);
    //          $sheet->getStyle("B$detail_start_row:C$detail_start_row")->getNumberFormat()->setFormatCode("#,##0.00_);(#,##0.00)");
    //          $sheet->getStyle("E$detail_start_row:F$detail_start_row")->getNumberFormat()->setFormatCode("#,##0.00_);(#,##0.00)");
    //         //  $sheet->getStyle("A$detail_start_row:A$detail_start_row")->getNumberFormat()->setFormatCode('dd-mm-yyyy');
           

    //        $totalFull += $response_detail['full'];
    //        $totalEmpty += $response_detail['empty'];
    //        $totalFullPort += $response_detail['fullport'];
    //        $totalEmptyPort += $response_detail['emptyport'];
    //         $detail_start_row++;
    //     }



    //    //total
    //    $total_start_row = $detail_start_row;
    //    $sheet->mergeCells('A' . $total_start_row . ':A' . $total_start_row);
    //    $sheet->setCellValue("A$total_start_row", 'Total')->getStyle('A' . $total_start_row . ':A' . $total_start_row)->applyFromArray($styleArray)->getFont()->setBold(true);

    //    $totalFull = "=SUM(B6:B" . ($detail_start_row-1) . ")";
    //    $sheet->setCellValue("B$total_start_row", $totalFull)->getStyle("B$total_start_row")->applyFromArray($style_number)->getFont()->setBold(true);
    //    $sheet->setCellValue("B$total_start_row", $totalFull)->getStyle("B$total_start_row")->getNumberFormat()->setFormatCode("#,##0.00_);(#,##0.00)");

    //    $totalEmpty= "=SUM(C6:C" . ($detail_start_row-1) . ")";
    //    $sheet->setCellValue("C$total_start_row", $totalEmpty)->getStyle("C$total_start_row")->applyFromArray($style_number)->getFont()->setBold(true);
    //    $sheet->setCellValue("C$total_start_row", $totalEmpty)->getStyle("C$total_start_row")->getNumberFormat()->setFormatCode("#,##0.00_);(#,##0.00)");

    //    $totalFullPort= "=SUM(E6:E" . ($detail_start_row-1) . ")";
    //    $sheet->setCellValue("E$total_start_row", $totalFullPort)->getStyle("E$total_start_row")->applyFromArray($style_number)->getFont()->setBold(true);
    //    $sheet->setCellValue("E$total_start_row", $totalFullPort)->getStyle("E$total_start_row")->getNumberFormat()->setFormatCode("#,##0.00_);(#,##0.00)");

    //    $totalEmptyPort= "=SUM(F6:F" . ($detail_start_row-1) . ")";
    //    $sheet->setCellValue("F$total_start_row", $totalEmptyPort)->getStyle("F$total_start_row")->applyFromArray($style_number)->getFont()->setBold(true);
    //    $sheet->setCellValue("F$total_start_row", $totalEmptyPort)->getStyle("F$total_start_row")->getNumberFormat()->setFormatCode("#,##0.00_);(#,##0.00)");

    //    $sheet->getStyle("D$detail_start_row:D$detail_start_row")->applyFromArray($styleArray);

    //     $ttd_start_row = $detail_start_row + 2;
    //     $sheet->setCellValue("A$ttd_start_row", 'Disetujui Oleh,');
    //     $sheet->setCellValue("B$ttd_start_row", 'Diperiksa Oleh,');
    //     $sheet->setCellValue("C$ttd_start_row", 'Disusun Oleh,');

    //     $sheet->setCellValue("A" . ($ttd_start_row + 3), '( ' . $disetujui . ' )');
    //     $sheet->setCellValue("B" . ($ttd_start_row + 3), '( ' . $diperiksa . ' )');
    //     $sheet->setCellValue("C" . ($ttd_start_row + 3), '(                )');

    //     $sheet->getColumnDimension('A')->setAutoSize(true);
    //     $sheet->getColumnDimension('B')->setAutoSize(true);
    //     $sheet->getColumnDimension('C')->setAutoSize(true);
    //     $sheet->getColumnDimension('D')->setAutoSize(true);
    //     $sheet->getColumnDimension('E')->setAutoSize(true);
    //     $sheet->getColumnDimension('F')->setAutoSize(true);



    //     $writer = new Xlsx($spreadsheet);
    //     $filename = 'LAPORAN TRIP TRADO ' . date('dmYHis');
    //     header('Content-Type: application/vnd.ms-excel');
    //     header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
    //     header('Cache-Control: max-age=0');

    //     $writer->save('php://output');
    // }
}

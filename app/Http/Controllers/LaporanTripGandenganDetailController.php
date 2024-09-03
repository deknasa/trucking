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


class LaporanTripGandenganDetailController extends MyController
{
    public $title = 'Laporan Trip Gandengan Detail';

    public function index(Request $request)
    {
        $title = $this->title;
        $data = [
            'pagename' => 'Menu Utama Laporan Trip Gandengan Detail',
        ];

        return view('laporantripgandengandetail.index', compact('title'));
    }

    public function report(Request $request)
    {
        $detailParams = [
            'sampai' => $request->sampai,
            'dari' => $request->dari,
            'gandengandari' => $request->gandengandari,
            'gandengansampai' => $request->gandengansampai,
            'gandengandari_id' => $request->gandengandari_id,
            'gandengansampai_id' => $request->gandengansampai_id,
        ];

        $header = Http::withHeaders(request()->header())
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'laporantripgandengandetail/report', $detailParams);

        $data = $header['data'];
        // dd($data);
        $user = Auth::user();
        return view('reports.laporantripgandengandetail', compact('data', 'user', 'detailParams'));
    }

    // public function export(Request $request): void
    // {
    //     $detailParams = [
    //         'sampai' => $request->sampai,
    //         'dari' => $request->dari,
    //         'gandengandari' => $request->gandengandari,
    //         'gandengansampai' => $request->gandengansampai,
    //         'gandengandari_id' => $request->gandengandari_id,
    //         'gandengansampai_id' => $request->gandengansampai_id,
    //     ];

    //     $header = Http::withHeaders(request()->header())
    //         ->withOptions(['verify' => false])
    //         ->withToken(session('access_token'))
    //         ->get(config('app.api_url') . 'laporantripgandengandetail/export', $detailParams);

    //     $data = $header['data'];
    //     if(count($data) == 0){
    //         throw new \Exception('TIDAK ADA DATA');
    //     }
    //     $disetujui = $data[0]['disetujui'] ?? '';
    //     $diperiksa = $data[0]['diperiksa'] ?? '';
    //     $spreadsheet = new Spreadsheet();
    //     $sheet = $spreadsheet->getActiveSheet();

    //     $sheet->setCellValue('A1', $data[0]['judul'] ?? '');
    //     $sheet->setCellValue('A2', $data[0]['judulLaporan'] ?? '');
    //     $sheet->setCellValue('A3', 'PERIODE : ' .date('d-M-Y', strtotime($detailParams['dari'])) . ' s/d ' . date('d-M-Y', strtotime($detailParams['sampai'])));
    //     // $sheet = $spreadsheet->getActiveSheet();
    //     // $sheet->setCellValue('b1', 'LAPORAN PINJAMAN SUPIR');
    //     $sheet->getStyle("A1")->getFont()->setSize(16)->setBold(true);
    //     $sheet->getStyle('A1')->getAlignment()->setHorizontal('center');
    //     $sheet->getStyle("A2")->getFont()->setBold(true);        
    //     $sheet->getStyle("A3")->getFont()->setBold(true);

    //     // $sheet->setCellValue('A4', 'PERIODE');
    //     // $sheet->getStyle("A4")->getFont()->setSize(12)->setBold(true);

    //     // $sheet->setCellValue('B4', $request->periode);
    //     // $sheet->setCellValue('B4', ':'." ".$request->periode);
    //     // $sheet->getStyle("B4")->getFont()->setSize(12)->setBold(true);

    //     $sheet->mergeCells('A1:I1');

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
    //             'label' => 'Gandengan',
    //             'index' => 'gandengan',
    //         ],
    //         [
    //             'label' => 'Tanggal',
    //             'index' => 'tanggal',
    //         ],
    //         [
    //             'label' => 'No SP',
    //             'index' => 'nosp',
    //         ],
    //         [
    //             'label' => 'Supir',
    //             'index' => 'supir',
    //         ],
    //         [
    //             'label' => 'No Container',
    //             'index' => 'nocont',
    //         ],
    //         [
    //             'label' => 'No Plat',
    //             'index' => 'noplat',
    //         ],
    //         [
    //             'label' => 'Rute',
    //             'index' => 'rute',
    //         ],
    //         [
    //             'label' => 'Container',
    //             'index' => 'cont',
    //         ],
    //         [
    //             'label' => 'Keterangan',
    //             'index' => 'keterangan',
    //         ],


    //     ];

    //     foreach ($header_columns as $detail_columns_index => $detail_column) {
    //         $sheet->setCellValue($alphabets[$detail_columns_index] . $detail_table_header_row, $detail_column['label'] ?? $detail_columns_index + 1);
    //     }
    //     $sheet->getStyle("A$detail_table_header_row:I$detail_table_header_row")->applyFromArray($styleArray)->getFont()->setBold(true);

    //     // LOOPING DETAIL
    //     $dataRow = $detail_table_header_row + 1;
    //     $previousRow = $dataRow - 1; // Initialize the previous row number
    //     foreach ($data as $response_index => $response_detail) {

    //         foreach ($header_columns as $detail_columns_index => $detail_column) {
    //             $sheet->setCellValue($alphabets[$detail_columns_index] . $detail_start_row, isset($detail_column['index']) ? $response_detail[$detail_column['index']] : $response_index + 1);
    //         }
    //         $dateValue = ($response_detail['tanggal'] != null) ? Date::PHPToExcel(date('Y-m-d',strtotime($response_detail['tanggal']))) : ''; 
            
    //         $sheet->setCellValue("A$detail_start_row", $response_detail['gandengan']);
    //         $sheet->setCellValue("B$detail_start_row", $dateValue);
    //         $sheet->setCellValue("C$detail_start_row", $response_detail['nosp']);
    //         $sheet->setCellValue("D$detail_start_row", $response_detail['supir']);
    //         $sheet->setCellValue("E$detail_start_row", $response_detail['nocont']);
    //         $sheet->setCellValue("F$detail_start_row", $response_detail['noplat']);
    //         $sheet->setCellValue("G$detail_start_row", $response_detail['rute']);
    //         $sheet->setCellValue("H$detail_start_row", $response_detail['cont']);
    //         $sheet->setCellValue("I$detail_start_row", $response_detail['keterangan']);
          
    //         $sheet->getStyle("A$detail_start_row:I$detail_start_row")->applyFromArray($styleArray);
    //         $sheet->getStyle("B$detail_start_row:B$detail_start_row")->getNumberFormat()->setFormatCode('dd-mm-yyyy');

    //         $dataRow++;
    //         $detail_start_row++;
    //     }

    //     $ttd_start_row = $detail_start_row + 2;
    //     $sheet->setCellValue("A$ttd_start_row", 'Disetujui Oleh,');
    //     $sheet->setCellValue("C$ttd_start_row", 'Diperiksa Oleh,');
    //     $sheet->setCellValue("F$ttd_start_row", 'Disusun Oleh,');

    //     $sheet->setCellValue("A" . ($ttd_start_row + 3), '( ' . $disetujui . ' )');
    //     $sheet->setCellValue("C" . ($ttd_start_row + 3), '( ' . $diperiksa . ' )');
    //     $sheet->setCellValue("F" . ($ttd_start_row + 3), '(                )');

    //     $sheet->getColumnDimension('A')->setWidth(16);
    //     $sheet->getColumnDimension('B')->setAutoSize(true);
    //     $sheet->getColumnDimension('C')->setAutoSize(true);
    //     $sheet->getColumnDimension('D')->setWidth(28);
    //     $sheet->getColumnDimension('E')->setAutoSize(true);
    //     $sheet->getColumnDimension('F')->setAutoSize(true);
    //     $sheet->getColumnDimension('G')->setAutoSize(true);
    //     $sheet->getColumnDimension('H')->setAutoSize(true);
    //     $sheet->getColumnDimension('I')->setWidth(50);



    //     $writer = new Xlsx($spreadsheet);
    //     $filename = 'LAPORAN TRIP GANDENGAN DETAIL ' . date('dmYHis');
    //     header('Content-Type: application/vnd.ms-excel');
    //     header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
    //     header('Cache-Control: max-age=0');

    //     $writer->save('php://output');
    // }
}

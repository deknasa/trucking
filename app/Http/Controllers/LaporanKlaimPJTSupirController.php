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


class LaporanKlaimPJTSupirController extends MyController
{
    public $title = 'Laporan Klaim PJT Supir';

    public function index(Request $request)
    {
        $title = $this->title;
        $data = [
            'pagename' => 'Menu Utama Laporan Klaim PJT Supir',
        ];

        return view('laporanklaimpjtsupir.index', compact('title'));
    }

    public function report(Request $request)
    {
        $detailParams = [
            'sampai' => $request->sampai,
            'dari' => $request->dari,
            'kelompok' => $request->kelompok,
            'kelompok_id' => $request->kelompok_id,
        ];

        $header = Http::withHeaders(request()->header())
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'laporanklaimpjtsupir/report', $detailParams);

        if ($header->successful()) {
            $data = $header['data'];
            $dataCabang['namacabang'] = $header['namacabang'];
            $user = Auth::user();
            $cabang['cabang'] = session('cabang');
            return view('reports.laporanklaimpjtsupir', compact('data', 'dataCabang', 'user', 'detailParams','cabang'));
        } else {
            return response()->json($header->json(), $header->status());
        }
    }

    // public function export(Request $request): void
    // {
    //     $detailParams = [
    //         'sampai' => $request->sampai,
    //         'dari' => $request->dari,
    //         'kelompok' => $request->kelompok,
    //         'kelompok_id' => $request->kelompok_id,
    //     ];

    //     $kelompok = ($request->kelompok_id != '') ? $request->kelompok : 'SEMUA';
    //     $header = Http::withHeaders(request()->header())
    //         ->withOptions(['verify' => false])
    //         ->withToken(session('access_token'))
    //         ->get(config('app.api_url') . 'laporanklaimpjtsupir/export', $detailParams);

    //     $data = $header['data'];
    //     if(count($data) == 0){
    //         throw new \Exception('TIDAK ADA DATA');
    //     }
    //     $namacabang = $header['namacabang'];
    //     $disetujui = $data[0]['disetujui'] ?? '';
    //     $diperiksa = $data[0]['diperiksa'] ?? '';

    //     $spreadsheet = new Spreadsheet();
    //     $sheet = $spreadsheet->getActiveSheet();
    //     $sheet->setCellValue('A1', $data[0]['judul'] ?? '');
    //     $sheet->setCellValue('A2', $namacabang ?? '');
    //     $sheet->setCellValue('A3', $data[0]['judulLaporan'] ?? '');
    //     $sheet->setCellValue('A4', 'PERIODE : ' .date('d-M-Y', strtotime($detailParams['dari'])) . ' s/d ' . date('d-M-Y', strtotime($detailParams['sampai'])));
    //     $sheet->setCellValue('A5', 'KELOMPOK : '.$kelompok);
    //     $sheet->getStyle("A1")->getFont()->setSize(16)->setBold(true);
    //     $sheet->getStyle('A1')->getAlignment()->setHorizontal('center');
    //     $sheet->mergeCells('A1:F1');
    //     $sheet->getStyle("A2")->getFont()->setSize(16)->setBold(true);
    //     $sheet->getStyle('A2')->getAlignment()->setHorizontal('center');
    //     $sheet->mergeCells('A2:F2');
    //     $sheet->getStyle("A2")->getFont()->setBold(true);        
    //     $sheet->getStyle("A3")->getFont()->setBold(true);        
    //     $sheet->getStyle("A4")->getFont()->setBold(true);
    //     $sheet->getStyle("A5")->getFont()->setBold(true);

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

    //     $header_columns = [
    //         [
    //             'label' => 'No Bukti',
    //             'index' => 'nobukti',
    //         ],
    //         [
    //             'label' => 'Tanggal',
    //             'index' => 'tglbukti',
    //         ],
    //         [
    //             'label' => 'Keterangan',
    //             'index' => 'keterangan',
    //         ],
    //         [
    //             'label' => 'Supir',
    //             'index' => 'namasupir',
    //         ],
    //         [
    //             'label' => 'Nama Stok',
    //             'index' => 'namastok',
    //         ],
    //         [
    //             'label' => 'Nominal',
    //             'index' => 'nominal',
    //         ],

    //     ];

    //     foreach ($header_columns as $detail_columns_index => $detail_column) {
    //         $sheet->setCellValue($alphabets[$detail_columns_index] . $detail_table_header_row, $detail_column['label'] ?? $detail_columns_index + 1);
    //     }
    //     $sheet->getStyle("A$detail_table_header_row:F$detail_table_header_row")->applyFromArray($styleArray)->getFont()->setBold(true);

    //     // LOOPING DETAIL
    //     foreach ($data as $response_index => $response_detail) {

    //         foreach ($header_columns as $detail_columns_index => $detail_column) {
    //             $sheet->setCellValue($alphabets[$detail_columns_index] . $detail_start_row, isset($detail_column['index']) ? $response_detail[$detail_column['index']] : $response_index + 1);
    //         }
    //         $dateValue = ($response_detail['tglbukti'] != null) ? Date::PHPToExcel(date('Y-m-d',strtotime($response_detail['tglbukti']))) : ''; 

    //         $sheet->setCellValue("A$detail_start_row", $response_detail['nobukti']);
    //         $sheet->setCellValue("B$detail_start_row", $dateValue);
    //         $sheet->setCellValue("C$detail_start_row", $response_detail['keterangan']);
    //         $sheet->setCellValue("D$detail_start_row", $response_detail['namasupir']);
    //         $sheet->setCellValue("E$detail_start_row", $response_detail['namastok']);
    //         $sheet->setCellValue("F$detail_start_row", $response_detail['nominal']);

    //         $sheet->getStyle("A$detail_start_row:F$detail_start_row")->applyFromArray($styleArray);
    //         $sheet->getStyle("F$detail_start_row")->getNumberFormat()->setFormatCode("#,##0.00_);(#,##0.00)");
    //         $sheet->getStyle("B$detail_start_row")->getNumberFormat()->setFormatCode('dd-mm-yyyy');


    //         $detail_start_row++;
    //     }



    //     //total
    //     $total_start_row = $detail_start_row;
    //     $sheet->mergeCells('A' . $total_start_row . ':E' . $total_start_row);
    //     $sheet->setCellValue("A$total_start_row", 'Total')->getStyle('A' . $total_start_row . ':E' . $total_start_row)->applyFromArray($styleArray)->getFont()->setBold(true);

    //     $totalDebet = "=SUM(F7:F" . ($detail_start_row - 1) . ")";
    //     $sheet->setCellValue("F$total_start_row", $totalDebet)->getStyle("F$total_start_row")->applyFromArray($style_number)->getFont()->setBold(true);
    //     $sheet->setCellValue("F$total_start_row", $totalDebet)->getStyle("F$total_start_row")->getNumberFormat()->setFormatCode("#,##0.00_);(#,##0.00)");

    //     $ttd_start_row = $detail_start_row + 2;
    //     $sheet->setCellValue("A$ttd_start_row", 'Disetujui Oleh,');
    //     $sheet->setCellValue("C$ttd_start_row", 'Diperiksa Oleh,');
    //     $sheet->setCellValue("F$ttd_start_row", 'Disusun Oleh,');

    //     $sheet->setCellValue("A" . ($ttd_start_row + 3), '( ' . $disetujui . ' )');
    //     $sheet->setCellValue("C" . ($ttd_start_row + 3), '( ' . $diperiksa . ' )');
    //     $sheet->setCellValue("F" . ($ttd_start_row + 3), '(                )');

    //     $sheet->getColumnDimension('A')->setWidth(20);
    //     $sheet->getColumnDimension('B')->setAutoSize(true);
    //     $sheet->getColumnDimension('C')->setWidth(68);
    //     $sheet->getColumnDimension('D')->setWidth(16);
    //     $sheet->getColumnDimension('E')->setWidth(32);
    //     $sheet->getColumnDimension('F')->setAutoSize(true);



    //     $writer = new Xlsx($spreadsheet);
    //     $filename = 'LAPORAN KLAIM PJT SUPIR ' . date('dmYHis');
    //     header('Content-Type: application/vnd.ms-excel');
    //     header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
    //     header('Cache-Control: max-age=0');

    //     $writer->save('php://output');
    // }
}

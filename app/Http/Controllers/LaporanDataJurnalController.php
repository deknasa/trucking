<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class LaporanDataJurnalController extends MyController
{
    public $title = 'Laporan Data Jurnal';

    public function index(Request $request)
    {
        $title = $this->title;
        
        return view('laporandatajurnal.index', compact('title'));
    }

    // public function export(Request $request): void
    // {
    //     $detailParams = [
    //         'dari' => $request->dari,
    //         'sampai' => $request->sampai,
    //     ];

    //     $responses = Http::withHeaders($request->header())
    //         ->withOptions(['verify' => false])
    //         ->withToken(session('access_token'))
    //         ->get(config('app.api_url') . 'laporandatajurnal/export', $detailParams);

    //     $bukubesar = $responses['data'];
        
    //     if(count($bukubesar) == 0){
    //         throw new \Exception('TIDAK ADA DATA');
    //     }

    //     $namacabang = $responses['namacabang'];
    //     $dataheader = $detailParams;
    //     $user = Auth::user();

    //     $spreadsheet = new Spreadsheet();
    //     $sheet = $spreadsheet->getActiveSheet();
    //     $sheet->setCellValue('A1', $bukubesar[0]['judul']);
    //     $sheet->getStyle("A1")->getFont()->setSize(20)->setBold(true);
    //     $sheet->getStyle('A1')->getAlignment()->setHorizontal('center');
    //     $sheet->mergeCells('A1:I1');

    //     $sheet->setCellValue('A2', $namacabang);
    //     $sheet->getStyle("A2")->getFont()->setSize(16)->setBold(true);
    //     $sheet->getStyle('A2')->getAlignment()->setHorizontal('center');
    //     $sheet->mergeCells('A2:I2');

    //     $sheet->setCellValue('A3', 'Laporan Data Jurnal');
    //     $sheet->getStyle("A3")->getFont()->setSize(16)->setBold(true);
    //     $sheet->getStyle('A3')->getAlignment()->setHorizontal('center');
    //     $sheet->mergeCells('A3:I3');

    //     $sheet->setCellValue('A4', 'Periode : ' . $dataheader['dari'] . ' s/d ' . $dataheader['sampai']);
    //     $sheet->getStyle("A4")->getFont()->setSize(12)->setBold(true);
    //     $sheet->getStyle('A4')->getAlignment()->setHorizontal('center');
    //     $sheet->mergeCells('A4:I4');

       

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
    //             'label' => 'Coa Debet',
    //             'index' => 'CoaDebet'
    //         ],
    //         [
    //             'label' => 'Coa Kredit',
    //             'index' => 'CoaKredit'
    //         ],
    //         [
    //             'label' => 'Keterangan Coa Debet',
    //             'index' => 'KetCoaDebet'
    //         ],
    //         [
    //             'label' => 'Keterangan Coa Kredit',
    //             'index' => 'KetCoaKredit'
    //         ],
    //         [
    //             'label' => 'Debet',
    //             'index' => 'Debet'
    //         ],
    //         [
    //             'label' => 'Kredit',
    //             'index' => 'Kredit'
    //         ],
    //         [
    //             'label' => 'Keterangan',
    //             'index' => 'keterangan',
    //         ],
    //     ];

    //     foreach ($detail_columns as $detail_columns_index => $detail_column) {
    //         $sheet->setCellValue($alphabets[$detail_columns_index] . $detail_start_row, $detail_column['label'] ?? $detail_columns_index + 1);
    //     }
    //     $sheet->getStyle("A$detail_start_row:I$detail_start_row")->getFont()->setBold(true);
    //     $sheet->getStyle("A$detail_start_row:I$detail_start_row")->applyFromArray($styleArray);
    //     $detail_start_row++;


    //     $dataRow = $detail_table_header_row + 2;
    //     $first_row = $dataRow;
    //     foreach ($bukubesar as $response_index => $response_detail) {
    //         foreach ($detail_columns as $detail_columns_index => $detail_column) {
    //             $data = $response_detail[$detail_column['index']];
    //             if ($detail_column['index'] == 'tglbukti') {
    //                 $data = ($response_detail['tglbukti'] != null) ? Date::PHPToExcel(date('Y-m-d', strtotime($response_detail['tglbukti']))) : '';
    //             }
    //             $sheet->setCellValue($alphabets[$detail_columns_index] . $dataRow,   $data  ?? $detail_columns_index + 1);
    //             if ($detail_column['index'] == 'tglbukti') {
    //                 $sheet->getStyle($alphabets[$detail_columns_index] . $dataRow) 
    //                 ->getNumberFormat() 
    //                 ->setFormatCode('dd-mm-yyyy');
    //             }
    //             $sheet->getStyle($alphabets[$detail_columns_index] . $dataRow)->applyFromArray($styleArray);

    //         }
    //         $sheet->getStyle("G$dataRow:H$dataRow")->applyFromArray($style_number)->getNumberFormat()->setFormatCode("#,##0.00_);(#,##0.00)");

    //         $dataRow++;
    //     }
    //     $last_detail=$dataRow -1;
    //     $total_start_row = $dataRow;
    //     $sheet->mergeCells('A' . $total_start_row . ':F' . $total_start_row);
    //     $sheet->setCellValue("A$total_start_row", 'Total')->getStyle('A' . $total_start_row . ':F' . $total_start_row)->applyFromArray($styleArray)->getFont()->setBold(true);
    //     $sheet->setCellValue("G$total_start_row", "=SUM(G$first_row:G$last_detail)")->getStyle("G$total_start_row")->applyFromArray($style_number)->getFont()->setBold(true);
    //     $sheet->setCellValue("H$total_start_row", "=SUM(H$first_row:H$last_detail)")->getStyle("H$total_start_row")->applyFromArray($style_number)->getFont()->setBold(true);
    //     $sheet->getStyle("G$total_start_row")->getNumberFormat()->setFormatCode("#,##0.00_);(#,##0.00)");
    //     $sheet->getStyle("H$total_start_row")->getNumberFormat()->setFormatCode("#,##0.00_);(#,##0.00)");
    //     $sheet->getStyle('A' . $total_start_row . ':I' . $total_start_row)->applyFromArray($styleArray);

    //     $detail_start_row = $dataRow;
    //     $detail_start_row += 2; // Add an empty row between groups
       
         
    //     $ttd_start_row = $detail_start_row + 2;
    //     $sheet->setCellValue("A$ttd_start_row", 'Disetujui Oleh,');
    //     $sheet->setCellValue("C$ttd_start_row", 'Diperiksa Oleh,');
    //     $sheet->setCellValue("F$ttd_start_row", 'Disusun Oleh,');

    //     $sheet->setCellValue("A" . ($ttd_start_row + 3), '(                )');
    //     $sheet->setCellValue("C" . ($ttd_start_row + 3), '(                )');
    //     $sheet->setCellValue("F" . ($ttd_start_row + 3), '(                )');

    //     $sheet->getColumnDimension('A')->setWidth(12);
    //     $sheet->getColumnDimension('B')->setAutoSize(true);
    //     $sheet->getColumnDimension('C')->setWidth(12);
    //     $sheet->getColumnDimension('D')->setWidth(12);
    //     $sheet->getColumnDimension('E')->setWidth(30);
    //     $sheet->getColumnDimension('F')->setWidth(30);
    //     $sheet->getColumnDimension('G')->setAutoSize(true);
    //     $sheet->getColumnDimension('H')->setAutoSize(true);
    //     $sheet->getColumnDimension('I')->setWidth(30);



    //     $writer = new Xlsx($spreadsheet);
    //     $filename = 'LAPORAN DATA JURNAL ' . date('dmYHis');
    //     header('Content-Type: application/vnd.ms-excel');
    //     header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
    //     header('Cache-Control: max-age=0');

    //     $writer->save('php://output');
    // }
}

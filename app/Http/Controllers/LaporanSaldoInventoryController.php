<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;


use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class LaporanSaldoInventoryController extends MyController
{
    public $title = 'Laporan Saldo Inventory';

    public function index(Request $request)
    {
        $title = $this->title;
        $data = [
            'pagename' => 'Menu Utama Laporan Saldo Inventory',
        ];

        return view('laporansaldoinventory.index', compact('title'));
    }

    public function report(Request $request)
    {

        $detailParams = [
            'kelompok_id' => $request->kelompok_id,
            'statusreuse' => $request->statusreuse,
            'statusban' => $request->statusban,
            'jenislaporan' => $request->jenislaporan,
            'filter' => $request->filter,
            'jenistgltampil' => $request->jenistgltampil,
            'priode' => $request->priode,
            'stokdari_id' => $request->stokdari_id,
            'stoksampai_id' => $request->stoksampai_id,
            'dataFilter' => $request->dataFilter,
        ];

        $header = Http::withHeaders(request()->header())
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'laporansaldoinventory/report', $detailParams);

        $data = $header['data'];
        $user = Auth::user();
        $opname['opname'] = $header['opname'];
        $dataCabang['namacabang'] = $header['namacabang'];

        return view('reports.laporansaldoinventory', compact('data','dataCabang', 'user', 'detailParams', 'opname'));
    }

    public function export(Request $request): void
    {
        $detailParams = [
            'kelompok_id' => $request->kelompok_id,
            'statusreuse' => $request->statusreuse,
            'statusban' => $request->statusban,
            'jenislaporan' => $request->jenislaporan,
            'filter' => $request->filter,
            'jenistgltampil' => $request->jenistgltampil,
            'priode' => $request->priode,
            'stokdari_id' => $request->stokdari_id,
            'stoksampai_id' => $request->stoksampai_id,
            'dataFilter' => $request->dataFilter,
        ];

    //     $header = Http::withHeaders(request()->header())
    //         ->withOptions(['verify' => false])
    //         ->withToken(session('access_token'))
    //         ->get(config('app.api_url') . 'laporansaldoinventory/report', $detailParams);

    //     $data = $header['data'];
    //     $disetujui = $data[0]['disetujui'] ?? '';
    //     $diperiksa = $data[0]['diperiksa'] ?? '';

    //     $user = Auth::user();

    //     $format = \PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_DATE_DMYMINUS;

    //     $data = $header['data'];
    //     $namacabang = $header['namacabang'];
    //     $spreadsheet = new Spreadsheet();
    //     $sheet = $spreadsheet->getActiveSheet();

    //     $sheet->setCellValue('A1', $header['judul']);
    //     $sheet->getStyle("A1")->getFont()->setSize(20)->setBold(true);
    //     $sheet->getStyle('A1')->getAlignment()->setHorizontal('center');
    //     $sheet->mergeCells('A1:G1');
    //     $sheet->setCellValue('A2', $namacabang);
    //     $sheet->getStyle("A2")->getFont()->setSize(20)->setBold(true);
    //     $sheet->getStyle('A2')->getAlignment()->setHorizontal('center');
    //     $sheet->mergeCells('A2:G2');

    //     $sheet->setCellValue('A3', 'LAPORAN SALDO INVENTORY');
    //     $sheet->getStyle("A3")->getFont()->setSize(16)->setBold(true);
    //     $sheet->getStyle('A3')->getAlignment()->setHorizontal('center');
    //     $sheet->mergeCells('A3:G3');

    //     $sheet->setCellValue('A5', 'PERIODE');
    //     $sheet->getStyle("A5")->getFont()->setSize(12)->setBold(true);
    //     $sheet->getStyle("B5")->getFont()->setSize(12)->setBold(true);

    //     $sheet->setCellValue('B5', ': ' . $request->priode);

    //     $sheet->setCellValue('A6', 'STOK');
    //     $sheet->getStyle("A6")->getFont()->setSize(12)->setBold(true);
    //     $sheet->getStyle("B6")->getFont()->setSize(12)->setBold(true);

    //     $stokdari = $data[0]['stokdari'] ?? " ";
    //     $stoksampai = $data[0]['stoksampai'] ?? " ";
    //     $kategori = $data[0]['kategori'] ?? "ALL";
    //     $lokasi = $data[0]['lokasi'] ?? " ";
    //     $namalokasi = $data[0]['namalokasi'] ?? " ";
    //     $sheet->setCellValue('B5', ': ' .  $stokdari . " S/D" . " " . $stoksampai);
    //     $kelompok = ($request->kelompok != '') ? $request->kelompok : 'ALL';

    //     $sheet->setCellValue('A7', 'KATEGORI');
    //     $sheet->getStyle("A7")->getFont()->setSize(12)->setBold(true);
    //     $sheet->getStyle("B7")->getFont()->setSize(12)->setBold(true);
    //     $sheet->setCellValue('B7', ': ' . $kelompok);

    //     $sheet->setCellValue('A8', $lokasi);
    //     $sheet->getStyle("A8")->getFont()->setSize(12)->setBold(true);
    //     $sheet->getStyle("B8")->getFont()->setSize(12)->setBold(true);
    //     $sheet->setCellValue('B8', ': ' . $namalokasi);

    //     $sheet->getStyle("C5")->getFont()->setSize(12)->setBold(true);

    //     $detail_table_header_row = 9;
    //     $detail_start_row = $detail_table_header_row + 1;

    //     $alphabets = range('A', 'Z');

    //     $styleArray = array(
    //         'borders' => array(
    //             'allBorders' => array(
    //                 'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
    //             ),
    //         ),
    //     );
    //     $styleHeader = [

    //         'alignment' => [
    //             'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
    //             'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
    //         ],
    //         'borders' => [
    //             'allBorders' => [
    //                 'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
    //             ],
    //         ],
    //     ];
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

    //     $header_columns = [
    //         [
    //             "index" => "vulkanisir ke/no",
    //             "label" => "Vulkanisir Ke/No",
    //         ],
    //         [
    //             "index" => "Nm. Brg",
    //             "label" => "Nama Barang",
    //         ],
    //         [
    //             "index" => "Tanggal",
    //             "label" => "Tanggal",
    //         ],
    //         [
    //             "index" => "QTY",
    //             "label" => "Qty",
    //         ],
    //         [
    //             "index" => "Satuan",
    //             "label" => "Satuan",
    //         ],
    //         [
    //             "index" => "Saldo",
    //             "label" => "Nominal",
    //         ]
    //     ];




    //     // LOOPING DETAIL
    //     $previous_kategori = '';
    //     $start_row_main = 0;
    //     $no = 1;
    //     if (is_array($data) || is_iterable($data)) {
    //         $cellQty = [];
    //         $cellTotal = [];
    //         foreach ($data as $response_index => $response_detail) {

    //             $kategori = $response_detail['kategori'];
    //             if ($kategori != $previous_kategori) {
    //                 if ($previous_kategori != '') {

    //                     $cellQty[] = "D$detail_start_row";
    //                     $cellTotal[] = "F$detail_start_row";
    //                     $sheet->setCellValue("B$detail_start_row", "TOTAL $previous_kategori");
    //                     $sheet->setCellValue("D$detail_start_row", "=SUM(D$start_row_main:D" . ($detail_start_row - 1) . ")");
    //                     $sheet->setCellValue("F$detail_start_row", "=SUM(F$start_row_main:F" . ($detail_start_row - 1) . ")");

    //                     $sheet->getStyle("A$detail_start_row:F$detail_start_row")->applyFromArray($styleArray)->getFont()->setBold(true);
    //                     $sheet->getStyle("D$detail_start_row")->applyFromArray($style_number)->getFont()->setBold(true);
    //                     $sheet->getStyle("F$detail_start_row")->applyFromArray($style_number)->getFont()->setBold(true);
    //                     $sheet->getStyle("D$detail_start_row")->getNumberFormat()->setFormatCode("#,##0.00");
    //                     $sheet->getStyle("F$detail_start_row")->getNumberFormat()->setFormatCode("#,##0.00");
    //                     $detail_start_row += 2;
    //                 }
    //                 if ($previous_kategori == '') {
    //                     foreach ($header_columns as $detail_columns_index => $detail_column) {
    //                         $sheet->setCellValue($alphabets[$detail_columns_index] . $detail_start_row, $detail_column['label'] ?? $detail_columns_index + 1);
    //                     }
    //                     $sheet->getStyle("A$detail_start_row:F$detail_start_row")->applyFromArray($styleHeader)->getFont()->setBold(true);
    //                     $detail_start_row++;
    //                 }

    //                 $start_row_main = $detail_start_row;
    //                 if ($kategori == 'BAN') {
    //                     $sheet->setCellValue('A' . ($detail_start_row), 'Vulkan Ke');
    //                 } else {
    //                     $sheet->setCellValue('A' . ($detail_start_row), 'No');
    //                 }
    //                 $sheet->setCellValue('B' . ($detail_start_row), $response_detail['kategori']);
    //                 $sheet->getStyle("A$detail_start_row")->applyFromArray($styleHeader)->getFont()->setBold(true);
    //                 $sheet->getStyle("B$detail_start_row:F$detail_start_row")->applyFromArray($styleArray)->getFont()->setBold(true);
    //                 $detail_start_row++;
    //                 $detail_start_row = $detail_start_row;
    //             }

    //             if ($kategori == 'BAN') {
    //                 $sheet->setCellValue("A$detail_start_row", $response_detail['vulkanisirke']);
    //             } else {
    //                 $sheet->setCellValue("A$detail_start_row", $no++);
    //             }
    //             $sheet->setCellValue("B$detail_start_row", $response_detail['namabarang']);
    //             $sheet->setCellValue("C$detail_start_row", date('d-m-Y', strtotime($response_detail['tanggal'])));
    //             $sheet->setCellValue("D$detail_start_row", $response_detail['qty']);
    //             $sheet->setCellValue("E$detail_start_row", $response_detail['satuan']);
    //             $sheet->setCellValue("F$detail_start_row", $response_detail['nominal']);

    //             $sheet->getStyle("A$detail_start_row:F$detail_start_row")->applyFromArray($styleArray);
    //             $sheet->getStyle("D$detail_start_row")->getNumberFormat()->setFormatCode("#,##0.00");
    //             $sheet->getStyle("F$detail_start_row")->getNumberFormat()->setFormatCode("#,##0.00");

    //             $detail_start_row++;
    //             $previous_kategori = $kategori;
    //         }

    //         if ($previous_kategori != '') {
    //             $cellQty[] = "D$detail_start_row";
    //             $cellTotal[] = "F$detail_start_row";
    //             $sheet->setCellValue("B$detail_start_row", "TOTAL $previous_kategori");
    //             $sheet->setCellValue("D$detail_start_row", "=SUM(D$start_row_main:D" . ($detail_start_row - 1) . ")");
    //             $sheet->setCellValue("F$detail_start_row", "=SUM(F$start_row_main:F" . ($detail_start_row - 1) . ")");

    //             $sheet->getStyle("A$detail_start_row:F$detail_start_row")->applyFromArray($styleArray)->getFont()->setBold(true);
    //             $sheet->getStyle("D$detail_start_row")->applyFromArray($style_number)->getFont()->setBold(true);
    //             $sheet->getStyle("F$detail_start_row")->applyFromArray($style_number)->getFont()->setBold(true);
    //             $sheet->getStyle("D$detail_start_row")->getNumberFormat()->setFormatCode("#,##0.00");
    //             $sheet->getStyle("F$detail_start_row")->getNumberFormat()->setFormatCode("#,##0.00");
    //         }
    //         $detail_start_row++;


    //         $qty = implode("+", $cellQty);
    //         $total = implode("+", $cellTotal);
    //         $sheet->setCellValue("B$detail_start_row", "GRAND TOTAL");
    //         $sheet->setCellValue("D$detail_start_row", "=$qty");
    //         $sheet->setCellValue("F$detail_start_row", "=$total");

    //         $sheet->getStyle("A$detail_start_row:F$detail_start_row")->applyFromArray($styleArray)->getFont()->setBold(true);
    //         $sheet->getStyle("D$detail_start_row")->applyFromArray($style_number)->getFont()->setBold(true);
    //         $sheet->getStyle("F$detail_start_row")->applyFromArray($style_number)->getFont()->setBold(true);
    //         $sheet->getStyle("D$detail_start_row")->getNumberFormat()->setFormatCode("#,##0.00");
    //         $sheet->getStyle("F$detail_start_row")->getNumberFormat()->setFormatCode("#,##0.00");
    //     }
    //     // set diketahui dibuat
    //     $ttd_start_row = $detail_start_row + 2;
    //     $sheet->setCellValue("B$ttd_start_row", 'Disetujui Oleh,');
    //     $sheet->setCellValue("D$ttd_start_row", 'Diperiksa Oleh,');
    //     $sheet->setCellValue("F$ttd_start_row", 'Disusun Oleh,');

    //     $sheet->setCellValue("B" . ($ttd_start_row + 3), '( ' . $disetujui . ' )');
    //     $sheet->setCellValue("D" . ($ttd_start_row + 3), '( ' . $diperiksa . ' )');
    //     $sheet->setCellValue("F" . ($ttd_start_row + 3), '(                )');


    //     //style header
    //     $sheet->getColumnDimension('A')->setAutoSize(true);
    //     $sheet->getColumnDimension('B')->setAutoSize(true);
    //     $sheet->getColumnDimension('C')->setAutoSize(true);
    //     $sheet->getColumnDimension('D')->setAutoSize(true);
    //     $sheet->getColumnDimension('E')->setAutoSize(true);
    //     $sheet->getColumnDimension('F')->setAutoSize(true);
    //     $sheet->getColumnDimension('G')->setAutoSize(true);
    //     $sheet->getColumnDimension('H')->setAutoSize(true);
    //     $sheet->getColumnDimension('I')->setAutoSize(true);
    //     $sheet->getColumnDimension('J')->setAutoSize(true);

    //     $writer = new Xlsx($spreadsheet);
    //     $filename = 'LAPORAN SALDO INVENTORY' . date('dmYHis');
    //     header('Content-Type: application/vnd.ms-excel');
    //     header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
    //     header('Cache-Control: max-age=0');

    //     $writer->save('php://output');
    }
}

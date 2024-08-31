<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\RedirectResponse;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;


class KartuStokController extends MyController
{
    public $title = 'Kartu Stok';

    public function index(Request $request)
    {
        $title = $this->title;
        $data = [
            'pagename' => 'Menu Utama Kartu Stok',
        ];

        return view('kartustok.index', compact('title'));
    }

    public function report(Request $request)
    {
        $detailParams = [
            'stokdari_id' => $request->stokdari_id,
            'stoksampai_id' => $request->stoksampai_id,
            'dari' => $request->dari,
            'sampai' => $request->sampai,
            'filter' => $request->filter,
            'datafilter' => $request->datafilter,
            'statustampil' => $request->statustampil,
            'kelompok_id' => $request->kelompok_id,
            'limit' => 0
        ];


        $header = Http::withHeaders(request()->header())
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'kartustok/report', $detailParams);

        $data = $header['data'];
        $dataHeader = $header['dataheader'];


        foreach ($data as $response_index => $response_detail) {
            $tglBukti = $response_detail["tglbukti"];
            $timeStamp = strtotime($tglBukti);
            $dateTglBukti = date('d-m-Y', $timeStamp);

            $data[$response_index]["tglbukti"] = $dateTglBukti;
        }
        return view('reports.kartustok', compact('data', 'dataHeader'));
    }

    // public function export(Request $request): void
    // {
    //     $detailParams = [
    //         'stokdari_id' => $request->stokdari_id,
    //         'stoksampai_id' => $request->stoksampai_id,
    //         'dari' => $request->dari,
    //         'sampai' => $request->sampai,
    //         'filter' => $request->filter,
    //         'datafilter' => $request->datafilter,
    //         'statustampil' => $request->statustampil,
    //         'kelompok_id' => $request->kelompok_id,
    //         'limit' => 0
    //     ];

    //     $responses = Http::withHeaders($request->header())
    //         ->withOptions(['verify' => false])
    //         ->withToken(session('access_token'))
    //         ->get(config('app.api_url') . 'kartustok/export', $detailParams);


    //     $dataHeader = $responses['dataheader'];
    //     $kartustok = $responses['data'];
    //     $user = Auth::user();

    //     $spreadsheet = new Spreadsheet();
    //     $sheet = $spreadsheet->getActiveSheet();
    //     $sheet->setCellValue('A1', $dataHeader['judul']);
    //     $sheet->getStyle("A1")->getFont()->setSize(16);
    //     $sheet->getStyle("A1")->getFont()->setBold(true);
    //     $sheet->getStyle('A1')->getAlignment()->setHorizontal('center');
    //     $sheet->mergeCells('A1:K1');
    //     $sheet->setCellValue('A2', $dataHeader['namacabang']);
    //     $sheet->getStyle("A2")->getFont()->setSize(16);
    //     $sheet->getStyle("A2")->getFont()->setBold(true);
    //     $sheet->getStyle('A2')->getAlignment()->setHorizontal('center');
    //     $sheet->mergeCells('A2:K2');
    //     $sheet->setCellValue('A3', 'Laporan Kartu Stok');
    //     $sheet->getStyle("A3")->getFont()->setBold(true);
    //     $sheet->setCellValue('A4', 'Periode : ' . $dataHeader['dari'] . ' s/d ' . $dataHeader['sampai']);
    //     $sheet->getStyle("A4")->getFont()->setBold(true);
    //     $sheet->setCellValue('A5', 'Stok : ' . $dataHeader['stokdari'] . ' s/d ' . $dataHeader['stoksampai']);
    //     $sheet->getStyle("A5")->getFont()->setBold(true);
    //     $sheet->setCellValue('A6', $dataHeader['filter'] . ' : ' . $dataHeader['datafilter']);
    //     $sheet->getStyle("A6")->getFont()->setBold(true);


    //     $header_start_row = 4;
    //     $header_right_start_row = 4;
    //     $detail_table_header_row = 9;
    //     $detail_start_row = $detail_table_header_row + 1;
    //     $mergecell_start_row = 8;

    //     $alphabets = range('A', 'Z');
    //     // $header_columns = [
    //     //     [
    //     //         'label' => 'Periode',
    //     //         'index' => 'dari',
    //     //     ],
    //     //     [
    //     //         'label' => 'stok',
    //     //         'index' => 'stokdari',
    //     //     ],
    //     //     [
    //     //         'label' => 'Gudang',
    //     //         'index' => 'datafilter',
    //     //     ],
    //     // ];

    //     // $header_right_columns = [

    //     //     [
    //     //         'label' => 's/d',
    //     //         'index' => 'sampai',
    //     //     ],
    //     // ];
    //     // $underheader_right_columns = [

    //     //     [
    //     //         'label' => 's/d',
    //     //         'index' => 'stoksampai',
    //     //     ],
    //     // ];

    //     $detail_columns = [
    //         [
    //             'label' => 'Kd Brg',
    //             'index' => 'kodebarang',
    //         ],
    //         [
    //             'label' => 'Nama Barang',
    //             'index' => 'namabarang',
    //         ],
    //         [
    //             'label' => 'Tanggal',
    //             'index' => 'tglbukti',
    //         ],
    //         [
    //             'label' => 'No Bukti',
    //             'index' => 'nobukti',
    //         ],
    //         [
    //             'label' => 'Kategori',
    //             'index' => 'kategori_id',
    //         ],
    //         [
    //             'label' => 'QTY',
    //             'index' => 'qtymasuk'
    //         ],
    //         [
    //             'label' => 'Nominal',
    //             'index' => 'nilaimasuk'
    //         ],
    //         [
    //             'label' => 'QTY',
    //             'index' => 'qtykeluar'
    //         ],
    //         [
    //             'label' => 'Nominal',
    //             'index' => 'nilaikeluar'
    //         ],
    //         [
    //             'label' => 'QTY',
    //             'index' => 'qtysaldo'
    //         ],
    //         [
    //             'label' => 'Nominal',
    //             'index' => 'nilaisaldo'
    //         ],
    //     ];
    //     // foreach ($header_columns as $header_column) {
    //     //     $sheet->setCellValue('A' . $header_start_row, $header_column['label']);
    //     //     $sheet->setCellValue('B' . $header_start_row++, ': ' . $dataHeader[$header_column['index']]);
    //     // }

    //     // foreach ($header_right_columns as $header_right_column) {
    //     //     $sheet->setCellValue('D' . $header_right_start_row, $header_right_column['label']);
    //     //     $sheet->setCellValue('E' . $header_right_start_row++, $dataHeader['sampai']);
    //     // }
    //     // foreach ($underheader_right_columns as $header_right_column) {
    //     //     $sheet->setCellValue('D5', $header_right_column['label']);
    //     //     $sheet->setCellValue('E5', $dataHeader['stoksampai']);
    //     // }


    //     foreach ($detail_columns as $detail_columns_index => $detail_column) {
    //         $sheet->setCellValue($alphabets[$detail_columns_index] . $detail_table_header_row, $detail_column['label'] ?? $detail_columns_index + 1);
    //     }
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

    //     $sheet->getStyle("A$detail_table_header_row:K$detail_table_header_row")->applyFromArray($styleArray);

    //     // LOOPING DETAIL
    //     foreach ($kartustok as $response_index => $response_detail) {

    //         foreach ($detail_columns as $detail_columns_index => $detail_column) {
    //             $sheet->setCellValue($alphabets[$detail_columns_index] . $detail_start_row, isset($detail_column['index']) ? $response_detail[$detail_column['index']] : $response_index + 1);
    //         }

    //         $sheet->setCellValue("A$detail_start_row", $response_detail['kodebarang']);
    //         $sheet->setCellValue("B$detail_start_row", $response_detail['namabarang']);

    //         $dateValue = ($response_detail['tglbukti'] != null) ? Date::PHPToExcel(date('Y-m-d', strtotime($response_detail['tglbukti']))) : '';
    //         $sheet->setCellValue("C$detail_start_row", $dateValue);
    //         $sheet->getStyle("C$detail_start_row")
    //             ->getNumberFormat()
    //             ->setFormatCode('dd-mm-yyyy');
    //         $sheet->setCellValue("D$detail_start_row", $response_detail['nobukti']);
    //         $sheet->setCellValue("E$detail_start_row", $response_detail['kategori_id']);
    //         $sheet->setCellValue("F$detail_start_row",  $response_detail['qtymasuk'])->getStyle("F$detail_start_row")->getNumberFormat()->setFormatCode("#,##0.00_);(#,##0.00)");
    //         $sheet->setCellValue("G$detail_start_row",  $response_detail['nilaimasuk'])->getStyle("G$detail_start_row")->getNumberFormat()->setFormatCode("#,##0.00_);(#,##0.00)");
    //         $sheet->setCellValue("H$detail_start_row",  $response_detail['qtykeluar'])->getStyle("H$detail_start_row")->getNumberFormat()->setFormatCode("#,##0.00_);(#,##0.00)");
    //         $sheet->setCellValue("I$detail_start_row",  $response_detail['nilaikeluar'])->getStyle("I$detail_start_row")->getNumberFormat()->setFormatCode("#,##0.00_);(#,##0.00)");
    //         $sheet->setCellValue("J$detail_start_row",  $response_detail['qtysaldo'])->getStyle("J$detail_start_row")->getNumberFormat()->setFormatCode("#,##0.00_);(#,##0.00)");
    //         $sheet->setCellValue("K$detail_start_row",  $response_detail['nilaisaldo'])->getStyle("K$detail_start_row")->getNumberFormat()->setFormatCode("#,##0.00_);(#,##0.00)");

    //         $sheet->getStyle("A$detail_start_row:J$detail_start_row")->applyFromArray($styleArray);
    //         $sheet->getStyle("F$detail_start_row:K$detail_start_row")->applyFromArray($style_number);
    //         $detail_start_row++;
    //     }

    //     $sheet->mergeCells('A' . $mergecell_start_row . ':E' . $mergecell_start_row);
    //     $sheet->mergeCells('F' . $mergecell_start_row . ':G' . $mergecell_start_row);
    //     $sheet->mergeCells('H' . $mergecell_start_row . ':I' . $mergecell_start_row);
    //     $sheet->mergeCells('J' . $mergecell_start_row . ':K' . $mergecell_start_row);
    //     $sheet->setCellValue("A$mergecell_start_row", '')->getStyle('A' . $mergecell_start_row . ':E' . $mergecell_start_row)->applyFromArray($styleArray);
    //     $sheet->setCellValue("F$mergecell_start_row", 'Masuk')->getStyle('F' . $mergecell_start_row . ':G' . $mergecell_start_row)->applyFromArray($styleArray)->getFont();
    //     $sheet->getStyle("F$mergecell_start_row")->getAlignment()->setHorizontal('center');
    //     $sheet->setCellValue("H$mergecell_start_row", 'Keluar')->getStyle('H' . $mergecell_start_row . ':I' . $mergecell_start_row)->applyFromArray($styleArray)->getFont();
    //     $sheet->getStyle("H$mergecell_start_row")->getAlignment()->setHorizontal('center');
    //     $sheet->setCellValue("J$mergecell_start_row", 'Saldo')->getStyle('J' . $mergecell_start_row . ':K' . $mergecell_start_row)->applyFromArray($styleArray)->getFont();
    //     $sheet->getStyle("J$mergecell_start_row")->getAlignment()->setHorizontal('center');

    //     $sheet->getColumnDimension('A')->setWidth(39);
    //     $sheet->getColumnDimension('B')->setWidth(39);
    //     $sheet->getColumnDimension('C')->setAutoSize(true);
    //     $sheet->getColumnDimension('D')->setAutoSize(true);
    //     $sheet->getColumnDimension('E')->setAutoSize(true);
    //     $sheet->getColumnDimension('F')->setAutoSize(true);
    //     $sheet->getColumnDimension('G')->setAutoSize(true);
    //     $sheet->getColumnDimension('H')->setAutoSize(true);
    //     $sheet->getColumnDimension('I')->setAutoSize(true);
    //     $sheet->getColumnDimension('J')->setAutoSize(true);
    //     $sheet->getColumnDimension('K')->setAutoSize(true);

    //     $writer = new Xlsx($spreadsheet);
    //     $filename = 'Kartu Stok  ' . date('dmYHis');
    //     header('Content-Type: application/vnd.ms-excel');
    //     header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
    //     header('Cache-Control: max-age=0');

    //     $writer->save('php://output');
    // }
}

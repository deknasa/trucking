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

class LaporanPemakaianStokController extends MyController
{
    public $title = 'Laporan Pemakaian Barang';

    public function index(Request $request)
    {
        $title = $this->title;
        $data = [
            'pagename' => 'Menu Utama Laporan Pemakaian Stok',
        ];

        return view('laporanpemakaianstok.index', compact('title'));
    }

    public function report(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');
        $detailParams = [
            'judul' => 'PT. TRANSPORINDO AGUNG SEJAHTERA',
            'judullaporan' => 'Laporan Pemakaian Stok',
            'tanggal_cetak' => date('d-m-Y H:i:s'),
            'sampai' => $request->sampai,

        ];
        $header = Http::withHeaders(request()->header())
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'laporanpemakaianstok/report', $detailParams);


        if ($header->successful()) {
            $data = $header['data'];
            $user = Auth::user();
            // return response()->json(['url' => route('reports.laporanpemakaianstok', compact('data', 'user', 'detailParams'))]);
            return view('reports.laporanpemakaianstok', compact('data', 'user', 'detailParams'));
        } else {
            return response()->json($header->json(), $header->status());
        }
    }

    // public function export(Request $request): void
    // {
    //     $detailParams = [
    //         'judul' => 'PT. TRANSPORINDO AGUNG SEJAHTERA',
    //         'judullaporan' => 'Laporan  Pemakaian Stok',
    //         'tanggal_cetak' => date('d-m-Y H:i:s'),
    //         'sampai' => $request->sampai,
    //     ];

    //     $responses = Http::withHeaders($request->header())
    //         ->withOptions(['verify' => false])
    //         ->withToken(session('access_token'))
    //         ->get(config('app.api_url') . 'laporanpemakaianstok/export', $detailParams);

    //     $pengeluaran = $responses['data'];

    //     if(count($pengeluaran) == 0){
    //         throw new \Exception('TIDAK ADA DATA');
    //     }

    //     $namacabang = $responses['namacabang'];
    //     $disetujui = $pengeluaran[0]['disetujui'] ?? '';
    //     $diperiksa = $pengeluaran[0]['diperiksa'] ?? '';
    //     $user = Auth::user();

    //     $spreadsheet = new Spreadsheet();
    //     $sheet = $spreadsheet->getActiveSheet();

    //     $sheet->setCellValue('A1', $pengeluaran[0]['judul']);
    //     $sheet->getStyle("A1")->getFont()->setSize(16)->setBold(true);
    //     $sheet->getStyle('A1')->getAlignment()->setHorizontal('center');
    //     $sheet->mergeCells('A1:J1');

    //     $sheet->setCellValue('A2', $namacabang);
    //     $sheet->getStyle("A2")->getFont()->setSize(16)->setBold(true);
    //     $sheet->getStyle('A2')->getAlignment()->setHorizontal('center');
    //     $sheet->mergeCells('A2:J2');

    //     $englishMonths = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
    //     $indonesianMonths = ['JANUARI', 'FEBRUARI', 'MARET', 'APRIL', 'MEI', 'JUNI', 'JULI', 'AGUSTUS', 'SEPTEMBER', 'OKTOBER', 'NOVEMBER', 'DESEMBER'];

    //     $sheet->setCellValue('A3', strtoupper('Laporan Pemakaian Stok'));
    //     $sheet->getStyle("A3")->getFont()->setBold(true);
    //     $sheet->mergeCells('A3:J3');

    //     $sheet->setCellValue('A4', strtoupper( 'Bulan ' . date('M-Y', strtotime($pengeluaran[0]['tglbukti'])) ));
    //     $sheet->getStyle("A4")->getFont()->setBold(true);
    //     $sheet->mergeCells('A4:J4');

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

    //     ];

    //     $alphabets = range('A', 'Z');

    //     $header_columns = [
    //         [
    //             "label" => "No",
    //             "index" => 'no',
    //         ],
    //         [
    //             "label" => "No Bukti",
    //             "index" => 'nobukti',
    //         ],
    //         [
    //             "label" => "Tanggal",
    //             "index" => 'tglbukti',
    //         ],
    //         [
    //             "label" => "No Pol/Gandengan",
    //             "index" => 'kodetrado',
    //         ],
    //         [
    //             "label" => "Nama Stock",
    //             "index" => 'namastok',
    //         ],
    //         [
    //             "label" => "Qty",
    //             "index" => 'qty',
    //         ],
    //         [
    //             "label" => "Satuan",
    //             "index" => 'satuan',
    //         ],
    //         [
    //             "label" => "Harga",
    //             "index" => 'harga',
    //         ],
    //         [
    //             "label" => "Nominal",
    //             "index" => 'nominal',
    //         ],
    //         [
    //             "label" => "Saldo",
    //             "index" => 'saldo',
    //         ],
    //         [
    //             "label" => "Keterangan",
    //             "index" => 'keterangan',
    //         ],
    //     ];

    //     foreach ($header_columns as $data_columns_index => $data_column) {
    //         $sheet->setCellValue($alphabets[$data_columns_index] . $header_start_row, $data_column['label'] ?? $data_columns_index + 1);
    //     }

    //     $lastColumn = $alphabets[$data_columns_index];
    //     $sheet->getStyle("A$header_start_row:$lastColumn$header_start_row")->getFont()->setBold(true);

    //     $rowAwal = 7;
    //     $no = 1;
    //     if (is_array($pengeluaran) || is_iterable($pengeluaran)) {
    //         // Menulis data dan melakukan grup berdasarkan kolom "KeteranganMain"

    //         $previous_kodetrado = '';
    //         // dd($pengeluaran);
    //         foreach ($pengeluaran as $response_detail) {
    //             $kodetrado = $response_detail['kodetrado'];

    //             if ($previous_kodetrado !== $kodetrado) {
    //                 $detail_start_row++;
    //             }
    //             foreach ($header_columns as $data_columns_index => $data_column) {
    //                 if ($data_column['index'] == 'no') {
    //                     $value = $no;
    //                 } else if ($data_column['index'] == 'saldo') {
    //                     if ($previous_kodetrado != '') {
    //                         if ($previous_kodetrado !== $kodetrado) {
    //                             $value = "=SUM(I$rowAwal:I" . ($detail_start_row - 2) . ")";
    //                             $rowAwal = $detail_start_row;
    //                         } else {
    //                             $value = '';
    //                         }
    //                     }
    //                 } else {
    //                     $value = $response_detail[$data_column['index']];
    //                 }

    //                 if ($data_column['index'] == 'tglbukti') {
    //                     $value = date('d-m-Y', strtotime($value));
    //                 }

    //                 if ($data_column['index'] == 'saldo') {
    //                     if ($previous_kodetrado != '') {
    //                         $sheet->setCellValue($alphabets[$data_columns_index] . ($detail_start_row - 2), $value);
    //                     }
    //                 } else if ($data_column['index'] == 'tglbukti') {
    //                     $dateValue = ($value != null) ? Date::PHPToExcel(date('Y-m-d',strtotime($value))) : ''; 
    //                     $sheet->setCellValue($alphabets[$data_columns_index] . ($detail_start_row ), $dateValue);
    //                     $sheet->getStyle($alphabets[$data_columns_index] . ($detail_start_row )) 
    //                     ->getNumberFormat() 
    //                     ->setFormatCode('dd-mm-yyyy');
    //                     // $sheet->setCellValue($alphabets[$data_columns_index] . ($detail_start_row - 2), $dateValue);
                        
    //                 } else {
    //                     $sheet->setCellValue($alphabets[$data_columns_index] . $detail_start_row, $value);
    //                 }
    //             }

    //             // Tingkatkan nomor baris
    //             $detail_start_row++;
    //             $no++;
    //             $previous_kodetrado = $kodetrado;
    //         }

    //         $value = "=SUM(I$rowAwal:I" . ($detail_start_row - 1) . ")";
    //         $sheet->setCellValue($alphabets[9] . ($detail_start_row - 1), $value);
    //     }
    //     //ukuran kolom
    //     foreach ($header_columns as $data_columns_index => $data_column) {

    //         if ($data_column['index'] == 'kodetrado') {
    //             $sheet->getColumnDimension($alphabets[$data_columns_index])->setWidth(12);
    //         } else if ($data_column['index'] == 'namastok') {
    //             $sheet->getColumnDimension($alphabets[$data_columns_index])->setWidth(33);
    //         } else if ($data_column['index'] == 'qty') {
    //             $sheet->getColumnDimension($alphabets[$data_columns_index])->setWidth(7);
    //         } else if ($data_column['index'] == 'keterangan') {
    //             $sheet->getColumnDimension($alphabets[$data_columns_index])->setWidth(63);
    //         } else {
    //             $sheet->getColumnDimension($alphabets[$data_columns_index])->setAutoSize(true);
    //         }
    //     }
    //     $detail_start_row++;
    //     // menambahkan sel Total pada baris terakhir + 1
    //     $sheet->setCellValue("B" . ($detail_start_row), 'TOTAL');
    //     $sheet->setCellValue("F" . ($detail_start_row), "=SUM(F" . ($header_start_row + 1) . ":F" . ($detail_start_row - 2) . ")");
    //     $sheet->setCellValue("I" . ($detail_start_row), "=SUM(I" . ($header_start_row + 1) . ":I" . ($detail_start_row - 2) . ")");
    //     $sheet->setCellValue("J" . ($detail_start_row), "=SUM(J" . ($header_start_row + 1) . ":J" . ($detail_start_row - 2) . ")");

    //     //FORMAT
    //     $numberColumn = [
    //         "qty",
    //         "satuan",
    //         "harga",
    //         "nominal",
    //         "saldo"
    //     ];
    //     foreach ($header_columns as $data_columns_index => $data_column) {
    //         if (in_array($data_column['index'], $numberColumn)) {
    //             $sheet->getStyle($alphabets[$data_columns_index] . ($header_start_row + 2) . ":" . $alphabets[$data_columns_index] . ($detail_start_row + 2))->getNumberFormat()->setFormatCode("#,##0.00_);(#,##0.00)");
    //         }
    //     }
        
    //     $ttd_start_row = $detail_start_row + 2;
    //     $sheet->setCellValue("B$ttd_start_row", 'Disetujui Oleh,');
    //     $sheet->setCellValue("D$ttd_start_row", 'Diperiksa Oleh,');
    //     $sheet->setCellValue("F$ttd_start_row", 'Disusun Oleh,');

    //     $sheet->setCellValue("B" . ($ttd_start_row + 3), '( ' . $disetujui . ' )');
    //     $sheet->setCellValue("D" . ($ttd_start_row + 3), '( ' . $diperiksa . ' )');
    //     $sheet->setCellValue("F" . ($ttd_start_row + 3), '(                )');

    //     //persetujuan
    //     // $sheet->mergeCells('A' . ($detail_start_row + 3) . ':B' . ($detail_start_row + 3));
    //     // $sheet->setCellValue('A' . ($detail_start_row + 3), 'Disetujui Oleh,');
    //     // $sheet->mergeCells('C' . ($detail_start_row + 3). ($detail_start_row + 3));
    //     // $sheet->setCellValue('C' . ($detail_start_row + 3), 'Diperiksa Oleh');
    //     // $sheet->mergeCells('D' . ($detail_start_row + 3) . ':E' . ($detail_start_row + 3));
    //     // $sheet->setCellValue('D' . ($detail_start_row + 3), 'Disusun Oleh,');


    //     // $sheet->mergeCells('A' . ($detail_start_row + 6) . ':B' . ($detail_start_row + 6));
    //     // $sheet->setCellValue('A' . ($detail_start_row + 6), '( ' . $disetujui . ' )');
    //     // $sheet->mergeCells('C' . ($detail_start_row + 6) . ($detail_start_row + 6));
    //     // $sheet->setCellValue('C' . ($detail_start_row + 6), '( ' . $diperiksa . ' )');
    //     // $sheet->mergeCells('D' . ($detail_start_row + 6) . ':E' . ($detail_start_row + 6));
    //     // $sheet->setCellValue('D' . ($detail_start_row + 6), '(                                          )');


    //     // style persetujuan
    //     // $sheet->getStyle('A' . ($detail_start_row + 3))->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
    //     // $sheet->getStyle('A' . ($detail_start_row + 3))->getFont()->setSize(12);
    //     // $sheet->getStyle('C' . ($detail_start_row + 3))->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
    //     // $sheet->getStyle('C' . ($detail_start_row + 3))->getFont()->setSize(12);
    //     // $sheet->getStyle('D' . ($detail_start_row + 3))->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
    //     // $sheet->getStyle('D' . ($detail_start_row + 3))->getFont()->setSize(12);


    //     // $sheet->getStyle('A' . ($detail_start_row + 6))->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
    //     // $sheet->getStyle('A' . ($detail_start_row + 6))->getFont()->setSize(12);
    //     // $sheet->getStyle('C' . ($detail_start_row + 6))->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
    //     // $sheet->getStyle('C' . ($detail_start_row + 6))->getFont()->setSize(12);
    //     // $sheet->getStyle('D' . ($detail_start_row + 6))->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
    //     // $sheet->getStyle('D' . ($detail_start_row + 6))->getFont()->setSize(12);

    //     // mengatur border top dan bottom pada cell Total
    //     // $border_style = [
    //     //     'borders' => [
    //     //         'top' => ['borderStyle' => 'thin', 'color' => ['rgb' => '000000']],
    //     //         'bottom' => ['borderStyle' => 'thin', 'color' => ['rgb' => '000000']]
    //     //     ]
    //     // ];
    //     // $sheet->getStyle("A" . ($detail_start_row + 1) . ":$lastColumn" . ($detail_start_row + 1))->applyFromArray($border_style);


    //     $writer = new Xlsx($spreadsheet);
    //     $filename = 'EXPORT LAPORAN PEMAKAIAN BARANG' . date('dmYHis');
    //     header('Content-Type: application/vnd.ms-excel');
    //     header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
    //     header('Cache-Control: max-age=0');

    //     $writer->save('php://output');
    // }
}

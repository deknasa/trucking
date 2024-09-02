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

class LaporanStokController extends MyController
{
    public $title = 'Laporan Stok';

    public function index(Request $request)
    {
        $title = $this->title;
        $data = [
            'pagename' => 'Menu Utama Laporan Stok',
        ];

        return view('laporanstok.index', compact('title'));
    }

    public function report(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');
        $detailParams = [
            'judul' => 'PT. TRANSPORINDO AGUNG SEJAHTERA',
            'judullaporan' => 'Laporan Stok',
            'tanggal_cetak' => date('d-m-Y H:i:s'),
            'sampai' => $request->sampai,
            'jenislaporan' => $request->jenislaporan,

        ];
        $header = Http::withHeaders(request()->header())
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'laporanstok/report', $detailParams);


        if ($header->successful()) {
            $data = $header['data'];
            $user = Auth::user();
            // return response()->json(['url' => route('reports.laporanstok', compact('data', 'user', 'detailParams'))]);
            return view('reports.laporanstok', compact('data', 'user', 'detailParams'));
        } else {
            return response()->json($header->json(), $header->status());
        }
    }

    public function export(Request $request): void
    {
        $detailParams = [
            'judul' => 'PT. TRANSPORINDO AGUNG SEJAHTERA',
            'judullaporan' => 'Laporan  Stok',
            'tanggal_cetak' => date('d-m-Y H:i:s'),
            'sampai' => $request->sampai,
            'jenislaporan' => $request->jenislaporan,



        ];

    //     $responses = Http::withHeaders($request->header())
    //         ->withOptions(['verify' => false])
    //         ->withToken(session('access_token'))
    //         ->get(config('app.api_url') . 'laporanstok/export', $detailParams);

    //     $pengeluaran = $responses['data'];

    //     if(count($pengeluaran) == 0){
    //         throw new \Exception('TIDAK ADA DATA');
    //     }
        
    //     $judul = $pengeluaran[0]['judul'] ?? '';
    //     $namacabang = $responses['namacabang'];

    //     $disetujui = $pengeluaran[0]['disetujui'] ?? '';
    //     $diperiksa = $pengeluaran[0]['diperiksa'] ?? '';
    //     $user = Auth::user();
    //     // dd($pengeluaran);
    //     $spreadsheet = new Spreadsheet();
    //     $sheet = $spreadsheet->getActiveSheet();

    //     $sheet->setCellValue('A1', $judul);
    //     $sheet->getStyle("A1")->getFont()->setSize(16)->setBold(true);
    //     $sheet->getStyle('A1')->getAlignment()->setHorizontal('center');
    //     $sheet->mergeCells('A1:K1');
    //     $sheet->setCellValue('A2', $namacabang);
    //     $sheet->getStyle("A2")->getFont()->setSize(16)->setBold(true);
    //     $sheet->getStyle('A2')->getAlignment()->setHorizontal('center');
    //     $sheet->mergeCells('A2:K2');

    //     $sheet->setCellValue('A3', strtoupper('Laporan Pemakaian Stok'));
    //     $sheet->getStyle("A3")->getFont()->setBold(true);
    //     $sheet->mergeCells('A3:K3');

    //     $sheet->setCellValue('A4', strtoupper( 'Bulan ' . date('M-Y', strtotime($pengeluaran[0]['tglbukti'])) ));
    //     $sheet->getStyle("A4")->getFont()->setBold(true);
    //     $sheet->mergeCells('A4:K4');
    //     $sheet->getColumnDimension('I')->setWidth(60);  
    //     // $sheet->setCellValue('A1', $pengeluaran[0]['judul']);
    //     // $sheet->setCellValue('A2', 'Laporan Stok');
    //     // $sheet->setCellValue('A3', 'Bulan ' . date('M-Y', strtotime($pengeluaran[0]['tgldari'])));
    //     // $sheet->getStyle("A1")->getFont()->setSize(16)->setBold(true);

    //     // $sheet->getStyle('A1')->getAlignment()->setHorizontal('center');
    //     // // $sheet->getStyle('A2')->getAlignment()->setHorizontal('left');
    //     // $sheet->mergeCells('A1:K1');
    //     // $sheet->mergeCells('A2:K2');
    //     // $sheet->mergeCells('A3:K3');

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
    //             "label" => "Nama Stock",
    //             "index" => 'namabarang',
    //         ],
    //         [
    //             "label" => "Qty Masuk",
    //             "index" => 'qtymasuk',
    //         ],
    //         [
    //             "label" => "Nominal Masuk",
    //             "index" => 'nominalmasuk',
    //         ],
    //         [
    //             "label" => "Qty Keluar",
    //             "index" => 'qtykeluar',
    //         ],
    //         [
    //             "label" => "Nominal Keluar",
    //             "index" => 'nominalkeluar',
    //         ],
    //         [
    //             "label" => "Keterangan",
    //             "index" => 'keterangan',
    //         ],
    //         [
    //             "label" => "Qty Saldo",
    //             "index" => 'qtysaldo',
    //         ],
    //         [
    //             "label" => "Nominal Saldo",
    //             "index" => 'nominalsaldo',
    //         ],

    //     ];

    //     foreach ($header_columns as $data_columns_index => $data_column) {
    //         $sheet->setCellValue($alphabets[$data_columns_index] . $header_start_row, $data_column['label'] ?? $data_columns_index + 1);
    //     }

    //     $lastColumn = $alphabets[$data_columns_index];
    //     $sheet->getStyle("A$header_start_row:$lastColumn$header_start_row")->getFont()->setBold(true);

    //     $no = 1;
    //     if (is_array($pengeluaran) || is_iterable($pengeluaran)) {
    //         foreach ($pengeluaran as $response_detail) {
    //             if ($no != 1) {
    //                 if ($response_detail['baris'] == 1) {
    //                     $detail_start_row++;
    //                 }
    //             }
    //             foreach ($header_columns as $data_columns_index => $data_column) {
    //                 if ($data_column['index'] == 'no') {
    //                     $value = $no;
    //                 } else {
    //                     $value = $response_detail[$data_column['index']];
    //                 }

    //                 if ($data_column['index'] == 'tglbukti') {
    //                     $value = date('d-m-Y', strtotime($value));
    //                 }
    //                 if ($data_column['index'] == 'nominalsaldo') {
    //                     if ($response_detail['baris'] != 1) {
    //                         $value = '=(F' . ($detail_start_row) . '-H' . $detail_start_row . ')';
    //                         // $value = $response_detail[$data_column['index']];
    //                     }
    //                 }
    //                 if ($data_column['index'] == 'qtysaldo') {
    //                     if ($response_detail['baris'] != 1) {
    //                         $value = '=(J' . ($detail_start_row - 1) . '+E' . $detail_start_row . ')-G' . $detail_start_row;
    //                     }
    //                 }

    //                 if ($data_column['index'] == 'tglbukti') {
    //                     $dateValue = ($value != null) ? Date::PHPToExcel(date('Y-m-d',strtotime($value))) : ''; 
    //                     $sheet->setCellValue($alphabets[$data_columns_index] . $detail_start_row, $dateValue);
    //                     $sheet->getStyle($alphabets[$data_columns_index] . $detail_start_row) 
    //                     ->getNumberFormat() 
    //                     ->setFormatCode('dd-mm-yyyy');
                        
    //                 } else{
    //                     $sheet->setCellValue($alphabets[$data_columns_index] . $detail_start_row, $value);
    //                 }
    //             }


    //             // Tingkatkan nomor baris
    //             $detail_start_row++;
    //             $no++;
    //         }
    //     }
    //     //ukuran kolom
    //     foreach ($header_columns as $data_columns_index => $data_column) {
    //         if ($data_column['index'] == 'namabarang') {
    //             $sheet->getColumnDimension($alphabets[$data_columns_index])->setWidth(50);
    //         } else if ($data_column['index'] == 'keterangan') {
    //                 $sheet->getColumnDimension($alphabets[$data_columns_index])->setWidth(72);
    //             } else {
    //             $sheet->getColumnDimension($alphabets[$data_columns_index])->setAutoSize(true);
    //         }
    //     }

    //     $detail_start_row++;
    //     // menambahkan sel Total pada baris terakhir + 1
    //     $sheet->setCellValue("B" . ($detail_start_row), 'TOTAL');
    //     $sheet->setCellValue("F" . ($detail_start_row), "=SUM(F" . ($header_start_row + 1) . ":F" . $detail_start_row . ")");
    //     $sheet->setCellValue("H" . ($detail_start_row), "=SUM(H" . ($header_start_row + 1) . ":H" . $detail_start_row . ")");
    //     $sheet->setCellValue("K" . ($detail_start_row), "=SUM(K" . ($header_start_row + 1) . ":K" . $detail_start_row . ")");


    //     //FORMAT
    //     $numberColumn = [
    //         "qtymasuk",
    //         "nominalmasuk",
    //         "qtykeluar",
    //         "nominalkeluar",
    //         "qtysaldo",
    //         "nominalsaldo"
    //     ];
    //     foreach ($header_columns as $data_columns_index => $data_column) {
    //         if (in_array($data_column['index'], $numberColumn)) {
    //             $sheet->getStyle($alphabets[$data_columns_index] . ($header_start_row + 1) . ":" . $alphabets[$data_columns_index] . ($detail_start_row + 1))->getNumberFormat()->setFormatCode("#,##0.00_);(#,##0.00)");
    //         }
    //     }
    //     // $sheet->getStyle("A$header_start_row:$lastColumn$header_start_row")->getFont()->setBold(true);

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

    //     $sheet->getColumnDimension('A')->setAutoSize(true);
    //     $sheet->getColumnDimension('B')->setAutoSize(true);
    //     $sheet->getColumnDimension('C')->setAutoSize(true);
    //     $sheet->getColumnDimension('D')->setWidth(38);
    //     $sheet->getColumnDimension('E')->setAutoSize(true);
    //     $sheet->getColumnDimension('F')->setAutoSize(true);
    //     $sheet->getColumnDimension('G')->setAutoSize(true);        
    //     $sheet->getColumnDimension('H')->setAutoSize(true);        
    //     $sheet->getColumnDimension('I')->setWidth(60);        
    //     $sheet->getColumnDimension('J')->setAutoSize(true);        
    //     $sheet->getColumnDimension('K')->setAutoSize(true);        

    //     $writer = new Xlsx($spreadsheet);
    //     $filename = 'LAPORAN PEMAKAIAN BARANG ' . date('dmYHis');
    //     header('Content-Type: application/vnd.ms-excel');
    //     header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
    //     header('Cache-Control: max-age=0');

    //     $writer->save('php://output');
    }
}

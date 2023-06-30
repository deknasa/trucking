<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Menu;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class LaporanKartuHutangPerSupplierController extends MyController
{
    public $title = 'Laporan Kartu Hutang Per Supplier';

    public function index(Request $request)
    {
        $title = $this->title;
        $data = [
            'pagename' => 'Menu Utama Laporan Kartu Hutang Per Supplier',
        ];

        return view('laporankartuhutangpersupplier.index', compact('title'));
    }

    public function report(Request $request)
    {
        $detailParams = [
            'dari' => $request->dari,
            'sampai' => $request->sampai,
            'supplierdari' => $request->supplierdari,
            'suppliersampai' => $request->suppliersampai,
            'supplierdari_id' => $request->supplierdari_id,
            'suppliersampai_id' => $request->suppliersampai_id,
            
        ];
        $header = Http::withHeaders(request()->header())
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'laporankartuhutangpersupplier/report', $detailParams);

        $data = $header['data'];
        $user = Auth::user();
        // dd($data);
        return view('reports.laporankartuhutangpersupplier', compact('data', 'user', 'detailParams'));
    }

    public function export(Request $request): void
    {
        $detailParams = [
            'dari' => $request->dari,
            'sampai' => $request->sampai,
            'supplierdari' => $request->supplierdari,
            'suppliersampai' => $request->suppliersampai,
            'supplierdari_id' => $request->supplierdari_id,
            'suppliersampai_id' => $request->suppliersampai_id,

        ];
       
        $responses = Http::withHeaders($request->header())
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'laporankartuhutangpersupplier/export', $detailParams);
        
        $pengeluaran = $responses['data'];
        $user = Auth::user();
        // dd($pengeluaran);
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
      
        $sheet->setCellValue('A1', 'PT. TRANSPORINDO AGUNG SEJAHTERA');
        $sheet->setCellValue('A2', 'Laporan Kartu Hutang Per Supplier');
        
        // $sheet->getStyle("A1")->getFont()->setSize(20)->setBold(true);
    
        $sheet->getStyle('A1')->getAlignment()->setHorizontal('center');
        $sheet->getStyle('A2')->getAlignment()->setHorizontal('left');
        $sheet->setCellValue('A3', 'Periode: ' . $request->dari . ' S/D ' . $request->sampai);
        $sheet->setCellValue('A4', 'Agen: ' . $request->supplierdari . ' S/D ' . $request->suppliersampai);
        $sheet->mergeCells('A1:I1');
        $sheet->mergeCells('A2:I2');
        $sheet->mergeCells('A3:I3');
        $sheet->mergeCells('A4:I4');
       
        $header_start_row = 6;
        $detail_start_row = 7;


        $styleArray = array(
            'borders' => array(
                'allBorders' => array(
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ),
            ),
        );

        $style_number = [
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT,
            ],

        ];

        $alphabets = range('A', 'Z');

        
        
        $header_columns = [
            [
                'label' => 'NO',
            ],
            [
                'label' => 'NO BUKTI',
                'index' => 'nobukti',
            ],
            [
                'label' => 'NAMA SUPPLIER',
                'index' => 'namasupplier',
            ],
            [
                'label' => 'TANGGAL',
                'index' => 'tglbukti',
            ],
            [
                'label' => 'TGL JATUH TEMPO',
                'index' => 'tgljatuhtempo',
            ],
            [
                'label' => 'CICILAN',
                'index' => 'cicil',
            ],
            [
                'label' => 'NOMINAL',
                'index' => 'nominal',
            ],
            [
                'label' => 'BAYAR',
                'index' => 'bayar',
            ],
            [
                'label' => 'SALDO',
                'index' => 'Saldo',
            ],
            [
                'label' => 'KETERANGAN',
                'index' => 'keterangan',
            ],
            
        ];

        
        foreach ($header_columns as $data_columns_index => $data_column) {
            $sheet->setCellValue($alphabets[$data_columns_index] . $header_start_row, $data_column['label'] ?? $data_columns_index + 1);
        }

        $lastColumn = $alphabets[$data_columns_index];
        $sheet->getStyle("A$header_start_row:$lastColumn$header_start_row")->getFont()->setBold(true);
        $totalDebet = 0;
        $totalKredit = 0;
        $totalSaldo = 0;
        $no = 1;
        if (is_array($pengeluaran) || is_iterable($pengeluaran)) {
 foreach ($pengeluaran as $response_index => $response_detail) {

            foreach ($header_columns as $detail_columns_index => $detail_column) {
                $sheet->setCellValue($alphabets[$detail_columns_index] . $detail_start_row, isset($detail_column['index']) ? $response_detail[$detail_column['index']] : $response_index + 1);
            }
            $sheet->setCellValue("A$detail_start_row", $no);
            $sheet->setCellValue("B$detail_start_row", $response_detail['nobukti']);
            $sheet->setCellValue("C$detail_start_row", $response_detail['namasupplier']);
            $sheet->setCellValue("D$detail_start_row", date('d-m-Y', strtotime($response_detail['tglbukti'])));
            $sheet->setCellValue("E$detail_start_row", date('d-m-Y', strtotime($response_detail['tgljatuhtempo'])));
            $sheet->setCellValue("F$detail_start_row", $response_detail['cicil']);
            $sheet->setCellValue("G$detail_start_row", $response_detail['nominal']);
            $sheet->setCellValue("H$detail_start_row", $response_detail['bayar']);
            $sheet->setCellValue("I$detail_start_row", $response_detail['Saldo']);
            $sheet->setCellValue("J$detail_start_row", $response_detail['keterangan']);
            
            $sheet->getStyle("A$detail_start_row:J$detail_start_row")->applyFromArray($styleArray);
            $sheet->getStyle("C$detail_start_row:J$detail_start_row")->getNumberFormat()->setFormatCode("#,##0.00");
            // $sheet->getStyle("B$detail_start_row:B$detail_start_row")->getNumberFormat()->setFormatCode('dd-mm-yyyy');
            // $sheet->getStyle("D$detail_start_row:D$detail_start_row")->getNumberFormat()->setFormatCode('dd-mm-yyyy');
            

        //    $totalKredit += $response_detail['kredit'];
        //     $totalDebet += $response_detail['debet'];
        //     $totalSaldo += $response_detail['Saldo'];
            $detail_start_row++;
            $no++;
        }
        }
       

        //ukuran kolom
        $sheet->getColumnDimension('A')->setAutoSize(true);
        $sheet->getColumnDimension('B')->setAutoSize(true);
        $sheet->getColumnDimension('C')->setAutoSize(true);
        $sheet->getColumnDimension('D')->setAutoSize(true);
        $sheet->getColumnDimension('E')->setAutoSize(true);
        $sheet->getColumnDimension('F')->setAutoSize(true);
        $sheet->getColumnDimension('G')->setAutoSize(true);
        $sheet->getColumnDimension('H')->setAutoSize(true);
        $sheet->getColumnDimension('I')->setAutoSize(true);
        $sheet->getColumnDimension('J')->setAutoSize(true);


// menambahkan sel Total pada baris terakhir + 1
// $sheet->setCellValue("A" . ($detail_start_row + 1), 'Total');
// $sheet->setCellValue("D" . ($detail_start_row + 1), "=SUM(D5:D" . $detail_start_row . ")");
// $sheet->setCellValue("E" . ($detail_start_row + 1), "=SUM(E5:E" . $detail_start_row . ")");


//FORMAT
// set format ribuan untuk kolom D dan E
$sheet->getStyle("D".($detail_start_row+1).":E".($detail_start_row+1))->getNumberFormat()->setFormatCode("#,##0.00");
$sheet->getStyle("A" . ($detail_start_row + 1) . ":$lastColumn" . ($detail_start_row + 1))->getFont()->setBold(true);


//persetujuan
// $sheet->mergeCells('A' . ($detail_start_row + 3) . ':B' . ($detail_start_row + 3));
// $sheet->setCellValue('A' . ($detail_start_row + 3), 'Disetujui Oleh,');
// $sheet->mergeCells('C' . ($detail_start_row + 3). ($detail_start_row + 3));
// $sheet->setCellValue('C' . ($detail_start_row + 3), 'Diperiksa Oleh');
// $sheet->mergeCells('D' . ($detail_start_row + 3) . ':E' . ($detail_start_row + 3));
// $sheet->setCellValue('D' . ($detail_start_row + 3), 'Disusun Oleh,');


// $sheet->mergeCells('A' . ($detail_start_row + 6) . ':B' . ($detail_start_row + 6));
// $sheet->setCellValue('A' . ($detail_start_row + 6), '( Bpk. Hasan )');
// $sheet->mergeCells('C' . ($detail_start_row + 6) . ($detail_start_row + 6));
// $sheet->setCellValue('C' . ($detail_start_row + 6), '( RINA )');
// $sheet->mergeCells('D' . ($detail_start_row + 6) . ':E' . ($detail_start_row + 6));
// $sheet->setCellValue('D' . ($detail_start_row + 6), '(                                          )');


// style persetujuan
// $sheet->getStyle('A' . ($detail_start_row + 3))->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
// $sheet->getStyle('A' . ($detail_start_row + 3))->getFont()->setSize(12);
// $sheet->getStyle('C' . ($detail_start_row + 3))->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
// $sheet->getStyle('C' . ($detail_start_row + 3))->getFont()->setSize(12);
// $sheet->getStyle('D' . ($detail_start_row + 3))->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
// $sheet->getStyle('D' . ($detail_start_row + 3))->getFont()->setSize(12);


// $sheet->getStyle('A' . ($detail_start_row + 6))->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
// $sheet->getStyle('A' . ($detail_start_row + 6))->getFont()->setSize(12);
// $sheet->getStyle('C' . ($detail_start_row + 6))->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
// $sheet->getStyle('C' . ($detail_start_row + 6))->getFont()->setSize(12);
// $sheet->getStyle('D' . ($detail_start_row + 6))->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
// $sheet->getStyle('D' . ($detail_start_row + 6))->getFont()->setSize(12);

// mengatur border top dan bottom pada cell Total
// $border_style = [
//     'borders' => [
//         'top' => ['borderStyle' => 'thin', 'color' => ['rgb' => '000000']],
//         'bottom' => ['borderStyle' => 'thin', 'color' => ['rgb' => '000000']]
//     ]
// ];
// $sheet->getStyle("A" . ($detail_start_row + 1) . ":$lastColumn" . ($detail_start_row + 1))->applyFromArray($border_style);


        $writer = new Xlsx($spreadsheet);
        $filename = 'EXPORTLAPORANKARTUHUTANGPERSUPPLIER' . date('dmYHis');
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');

    }

}

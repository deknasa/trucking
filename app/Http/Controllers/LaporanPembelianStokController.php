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


class LaporanPembelianStokController extends MyController
{
    public $title = 'Laporan Pembelian Stok';

    public function index(Request $request)
    {
        $title = $this->title;
        $data = [
            'pagename' => 'Menu Utama Laporan Pembelian Stok',
        ];

        return view('laporanpembelianstok.index', compact('title'));
    }

    public function get($params = []): array
    {
        $params = [
            'offset' => $params['offset'] ?? request()->offset ?? ((request()->page - 1) * request()->rows),
            'limit' => $params['rows'] ?? request()->rows ?? 0,
            'sortIndex' => $params['sidx'] ?? request()->sidx,
            'sortOrder' => $params['sord'] ?? request()->sord,
            'search' => json_decode($params['filters'] ?? request()->filters, 1) ?? [],
        ];

        $response = Http::withHeaders(request()->header())
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'laporanpembelianstok', $params);

        $data = [
            'total' => $response['attributes']['totalPages'] ?? [],
            'records' => $response['attributes']['totalRows'] ?? [],
            'rows' => $response['data'] ?? []
        ];

        return $data;
    }


    public function report(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta'); 
        $detailParams = [
            'judul' => 'PT. TRANSPORINDO AGUNG SEJAHTERA',
            'judullaporan' => 'Laporan  Pembelian',
            'tanggal_cetak' => date('d-m-Y H:i:s'),
            'dari' => $request->dari,
            'sampai' => $request->sampai,
            'stokdari' => $request->stokdari,
            'stoksampai' => $request->stoksampai,
            'stokdari_id' => $request->stokdari_id,
            'stoksampai_id' => $request->stoksampai_id,

        ];
        // dd($detailParams);
        $header = Http::withHeaders(request()->header())
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'laporanpembelianstok/report', $detailParams);
        $data = $header['data'];
 
        // $dataHeader = $header['dataheader'];
        $user = Auth::user();
        // dd($data);
        return view('reports.laporanpembelianstok', compact('data', 'user', 'detailParams'));

    }





    public function export(Request $request): void
    {
        $detailParams = [
            'judul' => 'PT. TRANSPORINDO AGUNG SEJAHTERA',
            'judullaporan' => 'Laporan  Pembelian Stok',
            'tanggal_cetak' => date('d-m-Y H:i:s'),
            'dari' => $request->dari,
            'sampai' => $request->sampai,
            'stokdari' => $request->stokdari,
            'stoksampai' => $request->stoksampai,
            'stokdari_id' => $request->stokdari_id,
            'stoksampai_id' => $request->stoksampai_id,

        ];
       
        $responses = Http::withHeaders($request->header())
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'laporanpembelianstok/export', $detailParams);
        
        $pengeluaran = $responses['data'];
        $user = Auth::user();
        // dd($pengeluaran);
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
      
        $sheet->setCellValue('A1', 'PT. TRANSPORINDO AGUNG SEJAHTERA');
        $sheet->setCellValue('A2', 'Laporan Pembelian Stok');
        $sheet->setCellValue('A3', 'Periode: ' . $request->dari . ' S/D ' . $request->sampai);
        $sheet->setCellValue('A4', 'Stok: ' . $request->stokdari . ' S/D ' . $request->stoksampai);
        
        // $sheet->getStyle("A1")->getFont()->setSize(20)->setBold(true);
    
        $sheet->getStyle('A1')->getAlignment()->setHorizontal('center');
        $sheet->getStyle('A2')->getAlignment()->setHorizontal('left');
        $sheet->mergeCells('A1:L1');
        $sheet->mergeCells('A2:L2');
        $sheet->mergeCells('A3:L3');
        $sheet->mergeCells('A4:L4');
       
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
                'label' => 'No',
            ],
            [
                'label' => 'No Bukti',
                'index' => 'nobukti',
            ],
            [
                'label' => 'Tanggal Bukti',
                'index' => 'tglbukti',
            ],
            [
                'label' => 'Nama Supplier',
                'index' => 'namasupplier',
            ],
            [
                'label' => 'Stok',
                'index' => 'stok_id',
            ],
            [
                'label' => 'Nama Stok',
                'index' => 'namastok',
            ],
            [
                'label' => 'Qty',
                'index' => 'qty',
            ],
            [
                'label' => 'HARGA',
                'index' => 'harga',
            ],
            [
                'label' => 'NOMINAL DISKON',
                'index' => 'nominaldiscount',
            ],
            [
                'label' => 'TOTAL',
                'index' => 'total',
            ],
            [
                'label' => 'Satuan',
                'index' => 'satuan',
            ],
            [
                'label' => 'Keterangan',
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
            $sheet->setCellValue("C$detail_start_row", date('d-m-Y', strtotime($response_detail['tglbukti'])));
            $sheet->setCellValue("D$detail_start_row", $response_detail['namasupplier']);
            $sheet->setCellValue("E$detail_start_row", $response_detail['stok_id']);
            $sheet->setCellValue("F$detail_start_row", $response_detail['namastok']);
            $sheet->setCellValue("G$detail_start_row", $response_detail['qty']);
            $sheet->setCellValue("H$detail_start_row", $response_detail['harga']);
            $sheet->setCellValue("I$detail_start_row", $response_detail['nominaldiscount']);
            $sheet->setCellValue("J$detail_start_row", $response_detail['total']);
            $sheet->setCellValue("K$detail_start_row", $response_detail['satuan']);
            $sheet->setCellValue("L$detail_start_row", $response_detail['keterangan']);
            
            $sheet->getStyle("A$detail_start_row:L$detail_start_row")->applyFromArray($styleArray);
            $sheet->getStyle("C$detail_start_row:L$detail_start_row")->getNumberFormat()->setFormatCode("#,##0.00");
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
        $sheet->getColumnDimension('K')->setAutoSize(true);
        $sheet->getColumnDimension('L')->setAutoSize(true);



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
        $filename = 'EXPORTPEMBELIANSTOK' . date('dmYHis');
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');

    }

}

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


class LaporanPemotonganPinjamanPerEBSController extends MyController
{
    public $title = 'Laporan Pemotongan Pinjaman Per EBS';

    public function index(Request $request)
    {
        $title = $this->title;
        $data = [
            'pagename' => 'Menu Utama Laporan Pemotongan Pinjaman Per EBS',
        ];

        return view('laporanpemotonganpinjamanperebs.index', compact('title'));
    }

    public function report(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta'); 
        $detailParams = [
            'judul' => 'PT. TRANSPORINDO AGUNG SEJAHTERA',
            'judullaporan' => 'Laporan Pemotongan Pinjaman Per EBS',
            'tanggal_cetak' => date('d-m-Y H:i:s'),
            'sampai' => $request->sampai,
            'dari' => $request->dari,
        ];

        $header = Http::withHeaders(request()->header())
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'laporanpemotonganpinjamanperebs/report', $detailParams);
        
        $data = $header['data'];
        $user = Auth::user();
        // dd($data);
        return view('reports.laporanpemotonganpinjamanperebs', compact('data', 'user', 'detailParams'));
    }

    public function export(Request $request): void
    {
        $detailParams = [
            'judul' => 'PT. TRANSPORINDO AGUNG SEJAHTERA',
            'judullaporan' => 'Laporan Pemotongan Pinjaman Per EBS',
            'tanggal_cetak' => date('d-m-Y H:i:s'),
            'sampai' => $request->sampai,
            'dari' => $request->dari,
        ];
       
        $responses = Http::withHeaders($request->header())
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'laporanpemotonganpinjamanperebs/export', $detailParams);
        
        $pengeluaran = $responses['data'];
        $disetujui = $pengeluaran[0]['disetujui'] ?? '';
        $diperiksa = $pengeluaran[0]['diperiksa'] ?? '';
        $user = Auth::user();
        // dd($pengeluaran);
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
      
        $sheet->setCellValue('A1', $pengeluaran[0]['judul'] ?? '');
        $sheet->setCellValue('A2', $pengeluaran[0]['judulLaporan'] ?? '');
        
        // $sheet->getStyle("A1")->getFont()->setSize(20)->setBold(true);
    
        $sheet->getStyle('A1')->getAlignment()->setHorizontal('center');
        $sheet->getStyle('A2')->getAlignment()->setHorizontal('left');
        $sheet->mergeCells('A1:T1');
        $sheet->mergeCells('A2:T2');
       
        $header_start_row = 4;
        $detail_start_row = 5;

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
                'label' => 'NO BUKTI',
                'index' => 'nobukti',
            ],
            [
                'label' => 'TGL BUKTI',
                'index' => 'tglbukti',
            ],
            [
                'label' => 'GAJI SUPIR NO BUKTI',
                'index' => 'gajisupir_nobukti',
            ],
            [
                'label' => 'NAMA SUPIR',
                'index' => 'namasupir',
            ],
            [
                'label' => 'TOTAL',
                'index' => 'total',
            ],
            [
                'label' => 'UANG JALAN',
                'index' => 'uangjalan',
            ],
            [
                'label' => 'BBM',
                'index' => 'bbm',
            ],
            [
                'label' => 'POTONGAN PINJAMAN',
                'index' => 'potonganpinjaman',
            ],
            [
                'label' => 'DEPOSITO',
                'index' => 'deposito',
            ],
            [
                'label' => 'POTONGAN PINJAMAN SEMUA',
                'index' => 'potonganpinjamansemua',
            ],
            [
                'label' => 'NO POLISI',
                'index' => 'nopolisi',
            ],
            [
                'label' => 'TGL DARI',
                'index' => 'tgldari',
            ],
            [
                'label' => 'TGL SAMPAI',
                'index' => 'tglsampai',
            ],
            [
                'label' => 'KOMISI SUPIR',
                'index' => 'komisisupir',
            ],
            [
                'label' => 'TOL SUPIR',
                'index' => 'tolsupir',
            ],
            [
                'label' => 'VOUCHER',
                'index' => 'voucher',
            ],
            [
                'label' => 'TGL DARI',
                'index' => 'tanggaldari',
            ],
            [
                'label' => 'TGL SAMPAI',
                'index' => 'tanggalsampai',
            ],
            [
                'label' => 'KETERANGAN PINJAMAN SUPIR',
                'index' => 'keteranganpinjamansupir',
            ],
            [
                'label' => 'KETERANGAN PINJAMAN SUPIR SEMUA',
                'index' => 'keteranganpinjamansupirsemua',
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
        if (is_array($pengeluaran) || is_iterable($pengeluaran)) {
 foreach ($pengeluaran as $response_index => $response_detail) {

            foreach ($header_columns as $detail_columns_index => $detail_column) {
                $sheet->setCellValue($alphabets[$detail_columns_index] . $detail_start_row, isset($detail_column['index']) ? $response_detail[$detail_column['index']] : $response_index + 1);
            }

            $sheet->setCellValue("A$detail_start_row", $response_detail['nobukti']);
            $sheet->setCellValue("B$detail_start_row", date('d-m-Y', strtotime($response_detail['tglbukti'])));
            $sheet->setCellValue("D$detail_start_row", $response_detail['gajisupir_nobukti']);
            $sheet->setCellValue("D$detail_start_row", $response_detail['namasupir']);
            $sheet->setCellValue("E$detail_start_row", $response_detail['total']);
            $sheet->setCellValue("F$detail_start_row", $response_detail['uangjalan']);
            $sheet->setCellValue("G$detail_start_row", $response_detail['bbm']);
            $sheet->setCellValue("H$detail_start_row", $response_detail['potonganpinjaman']);
            $sheet->setCellValue("I$detail_start_row", $response_detail['deposito']);
            $sheet->setCellValue("J$detail_start_row", $response_detail['potonganpinjamansemua']);
            $sheet->setCellValue("K$detail_start_row", $response_detail['nopolisi']);
            $sheet->setCellValue("L$detail_start_row", $response_detail['tgldari']);
            $sheet->setCellValue("M$detail_start_row", $response_detail['tglsampai']);
            $sheet->setCellValue("N$detail_start_row", $response_detail['komisisupir']);
            $sheet->setCellValue("O$detail_start_row", $response_detail['tolsupir']);
            $sheet->setCellValue("P$detail_start_row", $response_detail['voucher']);
            $sheet->setCellValue("Q$detail_start_row", $response_detail['tanggaldari']);
            $sheet->setCellValue("R$detail_start_row", $response_detail['tanggalsampai']);
            $sheet->setCellValue("S$detail_start_row", $response_detail['keteranganpinjamansupir']);
            $sheet->setCellValue("T$detail_start_row", $response_detail['keteranganpinjamansupirsemua']);

            
            $sheet->getStyle("A$detail_start_row:T$detail_start_row")->applyFromArray($styleArray);
            $sheet->getStyle("C$detail_start_row:T$detail_start_row")->getNumberFormat()->setFormatCode("#,##0.00");
            // $sheet->getStyle("B$detail_start_row:B$detail_start_row")->getNumberFormat()->setFormatCode('dd-mm-yyyy');
            // $sheet->getStyle("D$detail_start_row:D$detail_start_row")->getNumberFormat()->setFormatCode('dd-mm-yyyy');
            

        //    $totalKredit += $response_detail['kredit'];
        //     $totalDebet += $response_detail['debet'];
        //     $totalSaldo += $response_detail['Saldo'];
            $detail_start_row++;
        }
        }
       

        //ukuran kolom
        $sheet->getColumnDimension('A')->setWidth(30);
        $sheet->getColumnDimension('B')->setWidth(20);
        $sheet->getColumnDimension('C')->setWidth(20);
        $sheet->getColumnDimension('D')->setWidth(35);
        $sheet->getColumnDimension('E')->setWidth(20);
        $sheet->getColumnDimension('F')->setWidth(20);
        $sheet->getColumnDimension('G')->setWidth(20);
        $sheet->getColumnDimension('H')->setWidth(30);
        $sheet->getColumnDimension('I')->setWidth(20);
        $sheet->getColumnDimension('J')->setWidth(30);
        $sheet->getColumnDimension('K')->setWidth(20);
        $sheet->getColumnDimension('L')->setWidth(20);
        $sheet->getColumnDimension('M')->setWidth(20);
        $sheet->getColumnDimension('N')->setWidth(20);
        $sheet->getColumnDimension('O')->setWidth(20);
        $sheet->getColumnDimension('P')->setWidth(20);
        $sheet->getColumnDimension('Q')->setWidth(20);
        $sheet->getColumnDimension('R')->setWidth(20);
        $sheet->getColumnDimension('S')->setWidth(150);
        $sheet->getColumnDimension('T')->setWidth(150);

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
// $sheet->setCellValue('A' . ($detail_start_row + 6), '( ' . $disetujui . ' )');
// $sheet->mergeCells('C' . ($detail_start_row + 6) . ($detail_start_row + 6));
// $sheet->setCellValue('C' . ($detail_start_row + 6), '( ' . $diperiksa . ' )');
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
        $filename = 'EXPORTPEMOTONGANPINJAMANPEREBS' . date('dmYHis');
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');

    }


}

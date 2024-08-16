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


class LaporanSupirLebihDariTradoController extends MyController
{
    public $title = 'Laporan Supir 1 Lebih Dari 1 Trado';

    public function index(Request $request)
    {
        $title = $this->title;
        $data = [
            'pagename' => 'Menu Utama Laporan Supir 1 Lebih Dari 1 Trado',
        ];

        return view('laporansupirlebihdaritrado.index', compact('title'));
    }

    public function report(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta'); 
        $detailParams = [
            'sampai' => $request->sampai,
            'dari' => $request->dari,
            'judul' => 'PT. TRANSPORINDO AGUNG SEJAHTERA',
            'judullaporan' => 'Laporan 1 Supir Lebih Dari 1 Trado',
            'tanggal_cetak' => date('d-m-Y H:i:s'),
        ];

        $header = Http::withHeaders(request()->header())
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'laporansupirlebihdaritrado/report', $detailParams);

        $data = $header['data'];
        $dataCabang['namacabang'] = $header['namacabang'];
        $user = Auth::user();
        // dd($data);
        return view('reports.laporansupirlebihdaritrado', compact('data','dataCabang', 'user', 'detailParams'));
        

    }

    public function export(Request $request): void
    {
        $detailParams = [
            // 'judul' => 'PT. TRANSPORINDO AGUNG SEJAHTERA',
            // 'judullaporan' => 'Laporan Uang Jalan',
            'dari' => $request->dari,
            'sampai' => $request->sampai,
    
        ];
        // dd($detailParams);
       
        $responses = Http::withHeaders($request->header())
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'laporansupirlebihdaritrado/export', $detailParams);
        
        $pengeluaran = $responses['data'];
        if(count($pengeluaran) == 0){
            throw new \Exception('TIDAK ADA DATA');
        }
        $namacabang = $responses['namacabang'];
        $disetujui = $pengeluaran[0]['disetujui'] ?? '';
        $diperiksa = $pengeluaran[0]['diperiksa'] ?? '';
        $user = Auth::user();
        // dd($pengeluaran);
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
      
      
        $sheet->setCellValue('A1', $pengeluaran[0]['judul'] ?? '');
        $sheet->setCellValue('A2', $namacabang ?? '');
        $sheet->setCellValue('A3', $pengeluaran[0]['judulLaporan'] ?? '');
        $sheet->setCellValue('A4', 'PERIODE : ' .date('d-M-Y', strtotime($detailParams['dari'])) . ' s/d ' . date('d-M-Y', strtotime($detailParams['sampai'])));
       
        $sheet->getStyle("A1")->getFont()->setSize(16)->setBold(true);
    
        $sheet->getStyle('A1')->getAlignment()->setHorizontal('center');
        $sheet->mergeCells('A1:C1');
        $sheet->getStyle("A2")->getFont()->setSize(16)->setBold(true);
    
        $sheet->getStyle('A2')->getAlignment()->setHorizontal('center');
        $sheet->mergeCells('A2:C2');
        $sheet->getStyle("A3")->getFont()->setBold(true);        
        $sheet->getStyle("A4")->getFont()->setBold(true);
       
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
                'label' => 'Nama Supir',
                'index' => 'namasupir',
            ],
            [
                'label' => 'Tanggal Bukti',
                'index' => 'tglbukti',
            ],
            [
                'label' => 'Jumlah',
                'index' => 'jumlah',
            ],
            
        ];

        
        foreach ($header_columns as $data_columns_index => $data_column) {
            $sheet->setCellValue($alphabets[$data_columns_index] . $header_start_row, $data_column['label'] ?? $data_columns_index + 1);
        }

        $lastColumn = $alphabets[$data_columns_index];
        $sheet->getStyle("A$header_start_row:$lastColumn$header_start_row")->getFont()->setBold(true);
        $sheet->getStyle("A$header_start_row:$lastColumn$header_start_row")->applyFromArray($styleArray);
        
        $totalDebet = 0;
        $totalKredit = 0;
        $totalSaldo = 0;
        if (is_array($pengeluaran) || is_iterable($pengeluaran)) {
 foreach ($pengeluaran as $response_index => $response_detail) {

            foreach ($header_columns as $detail_columns_index => $detail_column) {
                $sheet->setCellValue($alphabets[$detail_columns_index] . $detail_start_row, isset($detail_column['index']) ? $response_detail[$detail_column['index']] : $response_index + 1);
            }
            $dateValue = ($response_detail['tglbukti'] != null) ? Date::PHPToExcel(date('Y-m-d',strtotime($response_detail['tglbukti']))) : ''; 
            
            $sheet->setCellValue("A$detail_start_row", $response_detail['namasupir']);
            $sheet->setCellValue("B$detail_start_row", $dateValue);
            $sheet->setCellValue("C$detail_start_row", $response_detail['jumlah']);

            $sheet->getStyle("C$detail_start_row")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
            $sheet->getStyle("A$detail_start_row:C$detail_start_row")->applyFromArray($styleArray);
            $sheet->getStyle("C$detail_start_row:C$detail_start_row")->getNumberFormat()->setFormatCode("#,##0.00_);(#,##0.00)");
            $sheet->getStyle("B$detail_start_row")->getNumberFormat()->setFormatCode('dd-mm-yyyy');
            // $sheet->getStyle("D$detail_start_row:D$detail_start_row")->getNumberFormat()->setFormatCode('dd-mm-yyyy');
            

        //    $totalKredit += $response_detail['kredit'];
        //     $totalDebet += $response_detail['debet'];
        //     $totalSaldo += $response_detail['Saldo'];
            $detail_start_row++;
        }
        }
       

        //ukuran kolom
        $sheet->getColumnDimension('A')->setWidth(40);
        $sheet->getColumnDimension('B')->setWidth(20);
        $sheet->getColumnDimension('C')->setWidth(20);
        // $sheet->getColumnDimension('D')->setWidth(18);
        // $sheet->getColumnDimension('E')->setWidth(18);
        // $sheet->getColumnDimension('F')->setWidth(18);

// menambahkan sel Total pada baris terakhir + 1
// $sheet->setCellValue("A" . ($detail_start_row + 1), 'Total');
// $sheet->setCellValue("D" . ($detail_start_row + 1), "=SUM(D5:D" . $detail_start_row . ")");
// $sheet->setCellValue("E" . ($detail_start_row + 1), "=SUM(E5:E" . $detail_start_row . ")");


//FORMAT
// set format ribuan untuk kolom D dan E
$sheet->getStyle("D".($detail_start_row+1).":E".($detail_start_row+1))->getNumberFormat()->setFormatCode("#,##0.00");
$sheet->getStyle("A" . ($detail_start_row + 1) . ":$lastColumn" . ($detail_start_row + 1))->getFont()->setBold(true);


//persetujuan
$sheet->mergeCells('A' . ($detail_start_row + 3) . ':A' . ($detail_start_row + 3));
$sheet->setCellValue('A' . ($detail_start_row + 3), 'Disetujui Oleh,');
$sheet->mergeCells('B' . ($detail_start_row + 3) . ':B' . ($detail_start_row + 3));
$sheet->setCellValue('B' . ($detail_start_row + 3), 'Diperiksa Oleh');
$sheet->mergeCells('C' . ($detail_start_row + 3) . ':C' . ($detail_start_row + 3));
$sheet->setCellValue('C' . ($detail_start_row + 3), 'Disusun Oleh,');


$sheet->mergeCells('A' . ($detail_start_row + 6) . ':A' . ($detail_start_row + 6));
$sheet->setCellValue('A' . ($detail_start_row + 6), '( ' . $disetujui . ' )');
$sheet->mergeCells('B' . ($detail_start_row + 6)  . ':B' . ($detail_start_row + 6));
$sheet->setCellValue('B' . ($detail_start_row + 6), '( ' . $diperiksa . ' )');
$sheet->mergeCells('C' . ($detail_start_row + 6) . ':C' . ($detail_start_row + 6));
$sheet->setCellValue('C' . ($detail_start_row + 6), '(                      )');


// style persetujuan
$sheet->getStyle('A' . ($detail_start_row + 3))->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
$sheet->getStyle('A' . ($detail_start_row + 3))->getFont()->setSize(12);
$sheet->getStyle('B' . ($detail_start_row + 3))->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
$sheet->getStyle('B' . ($detail_start_row + 3))->getFont()->setSize(12);
$sheet->getStyle('C' . ($detail_start_row + 3))->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
$sheet->getStyle('C' . ($detail_start_row + 3))->getFont()->setSize(12);


$sheet->getStyle('A' . ($detail_start_row + 6))->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
$sheet->getStyle('A' . ($detail_start_row + 6))->getFont()->setSize(12);
$sheet->getStyle('B' . ($detail_start_row + 6))->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
$sheet->getStyle('B' . ($detail_start_row + 6))->getFont()->setSize(12);
$sheet->getStyle('C' . ($detail_start_row + 6))->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
$sheet->getStyle('C' . ($detail_start_row + 6))->getFont()->setSize(12);

// mengatur border top dan bottom pada cell Total
// $border_style = [
//     'borders' => [
//         'top' => ['borderStyle' => 'thin', 'color' => ['rgb' => '000000']],
//         'bottom' => ['borderStyle' => 'thin', 'color' => ['rgb' => '000000']]
//     ]
// ];
// $sheet->getStyle("A" . ($detail_start_row + 1) . ":$lastColumn" . ($detail_start_row + 1))->applyFromArray($border_style);


      


        $writer = new Xlsx($spreadsheet);
        $filename = 'LAPORAN 1 SUPIR LEBIH DARI 1 TRADO ' . date('dmYHis');
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');

    }
}

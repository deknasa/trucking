<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use PHPExcel_Shared_Date;

use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;


class LaporanKasGantungController extends MyController
{
    public $title = 'Laporan Kas Gantung';

    public function index(Request $request)
    {
        $title = $this->title;
        $data = [
            'pagename' => 'Menu Utama Laporan Kas Gantung',
        ];
        return view('laporankasgantung.index', compact('title'));
    }

    public function report(Request $request)
    {
        $detailParams = [
            'periode' => $request->periode,
        ];

        $header = Http::withHeaders(request()->header())
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'laporankasgantung/report', $detailParams);
          
        $data = $header['data'];
        $user = Auth::user();
    //   dd($data);
        return view('reports.laporankasgantung', compact('data', 'user', 'detailParams'));
    }


    public function export(Request $request): void
    {
        $detailParams = [
            'periode' => $request->periode,
        ];
        $responses = Http::withHeaders($request->header())
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'laporankasgantung/export', $detailParams);
        
        $pengeluaran = $responses['data'];
        $user = Auth::user();
        
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        
        $sheet->setCellValue('A1', 'LAPORAN KAS GANTUNG');
        
        $sheet->getStyle("A1")->getFont()->setSize(20)->setBold(true);
    
        $sheet->getStyle('A1')->getAlignment()->setHorizontal('center');
        $sheet->mergeCells('A1:F3');
       
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
                'label' => 'Tanggal',
                'index' => 'tanggal',
            ],
            [
                'label' => 'No Bukti',
                'index' => 'nobukti',
            ],
            [
                'label' => 'Keterangan',
                'index' => 'keterangan',
            ],
            [
                'label' => 'Debet',
                'index' => 'debet',
            ],
            [
                'label' => 'Kredit',
                'index' => 'kredit',
            ],
            [
                'label' => 'Saldo',
                'index' => 'Saldo',
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

            $sheet->setCellValue("A$detail_start_row", $response_detail['tanggal']);
            $sheet->setCellValue("B$detail_start_row", $response_detail['nobukti']);
            $sheet->setCellValue("C$detail_start_row", $response_detail['keterangan']);
            $sheet->setCellValue("D$detail_start_row", $response_detail['debet']);
            $sheet->setCellValue("E$detail_start_row", $response_detail['kredit']);
            $sheet->setCellValue("F$detail_start_row", $response_detail['Saldo']);

            $sheet->getStyle("A$detail_start_row:F$detail_start_row")->applyFromArray($styleArray);
             $sheet->getStyle("D$detail_start_row:F$detail_start_row")->getNumberFormat()->setFormatCode("#,##0.00");
             $sheet->getStyle("A$detail_start_row:A$detail_start_row")->getNumberFormat()->setFormatCode('dd-mm-yyyy');
           

           $totalKredit += $response_detail['kredit'];
            $totalDebet += $response_detail['debet'];
            $totalSaldo += $response_detail['Saldo'];
            $detail_start_row++;
        }
        }
       

        //ukuran kolom
        $sheet->getColumnDimension('A')->setWidth(15);
        $sheet->getColumnDimension('B')->setWidth(20);
        $sheet->getColumnDimension('C')->setWidth(120);
        $sheet->getColumnDimension('D')->setWidth(18);
        $sheet->getColumnDimension('E')->setWidth(18);
        $sheet->getColumnDimension('F')->setWidth(18);

// menambahkan sel Total pada baris terakhir + 1
$sheet->setCellValue("A" . ($detail_start_row + 1), 'Total');
$sheet->setCellValue("D" . ($detail_start_row + 1), "=SUM(D5:D" . $detail_start_row . ")");
$sheet->setCellValue("E" . ($detail_start_row + 1), "=SUM(E5:E" . $detail_start_row . ")");


//FORMAT
// set format ribuan untuk kolom D dan E
$sheet->getStyle("D".($detail_start_row+1).":E".($detail_start_row+1))->getNumberFormat()->setFormatCode("#,##0.00");
$sheet->getStyle("A" . ($detail_start_row + 1) . ":$lastColumn" . ($detail_start_row + 1))->getFont()->setBold(true);


//persetujuan
$sheet->mergeCells('A' . ($detail_start_row + 3) . ':B' . ($detail_start_row + 3));
$sheet->setCellValue('A' . ($detail_start_row + 3), 'Disetujui Oleh,');
$sheet->mergeCells('C' . ($detail_start_row + 3). ($detail_start_row + 3));
$sheet->setCellValue('C' . ($detail_start_row + 3), 'Diperiksa Oleh');
$sheet->mergeCells('D' . ($detail_start_row + 3) . ':E' . ($detail_start_row + 3));
$sheet->setCellValue('D' . ($detail_start_row + 3), 'Disusun Oleh,');


$sheet->mergeCells('A' . ($detail_start_row + 6) . ':B' . ($detail_start_row + 6));
$sheet->setCellValue('A' . ($detail_start_row + 6), '( Bpk. Hasan )');
$sheet->mergeCells('C' . ($detail_start_row + 6) . ($detail_start_row + 6));
$sheet->setCellValue('C' . ($detail_start_row + 6), '( RINA )');
$sheet->mergeCells('D' . ($detail_start_row + 6) . ':E' . ($detail_start_row + 6));
$sheet->setCellValue('D' . ($detail_start_row + 6), '(                                          )');


// style persetujuan
$sheet->getStyle('A' . ($detail_start_row + 3))->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
$sheet->getStyle('A' . ($detail_start_row + 3))->getFont()->setSize(12);
$sheet->getStyle('C' . ($detail_start_row + 3))->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
$sheet->getStyle('C' . ($detail_start_row + 3))->getFont()->setSize(12);
$sheet->getStyle('D' . ($detail_start_row + 3))->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
$sheet->getStyle('D' . ($detail_start_row + 3))->getFont()->setSize(12);


$sheet->getStyle('A' . ($detail_start_row + 6))->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
$sheet->getStyle('A' . ($detail_start_row + 6))->getFont()->setSize(12);
$sheet->getStyle('C' . ($detail_start_row + 6))->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
$sheet->getStyle('C' . ($detail_start_row + 6))->getFont()->setSize(12);
$sheet->getStyle('D' . ($detail_start_row + 6))->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
$sheet->getStyle('D' . ($detail_start_row + 6))->getFont()->setSize(12);

// mengatur border top dan bottom pada cell Total
$border_style = [
    'borders' => [
        'top' => ['borderStyle' => 'thin', 'color' => ['rgb' => '000000']],
        'bottom' => ['borderStyle' => 'thin', 'color' => ['rgb' => '000000']]
    ]
];
$sheet->getStyle("A" . ($detail_start_row + 1) . ":$lastColumn" . ($detail_start_row + 1))->applyFromArray($border_style);


      


        $writer = new Xlsx($spreadsheet);
        $filename = 'EXPORTKASGANTUNG' . date('dmYHis');
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');

    }

   
}
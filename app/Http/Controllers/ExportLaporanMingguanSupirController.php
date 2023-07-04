<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class ExportLaporanMingguanSupirController extends Controller
{
    public $title = 'Export Laporan Mingguan Supir';

    public function index(Request $request)
    {
        $title = $this->title;
        $data = [
            'pagename' => 'Menu Utama Export Laporan Mingguan Supir',
        ];

        return view('exportlaporanmingguansupir.index', compact('title'));
    }

    public function export(Request $request): void
    {
        $detailParams = [
            'dari' => $request->dari,
            'sampai' => $request->sampai,
            'tradodari_id' => $request->tradodari_id,
            'tradosampai_id' => $request->tradosampai_id,
            'tradodari' => $request->tradodari,
            'tradosampai' => $request->tradosampai,
            
        ];


        $header = Http::withHeaders(request()->header())
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'exportlaporanmingguansupir/export', $detailParams);

        $data = $header['data'];

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('b1', 'LAPORAN MINGGUAN SUPIR');
        $sheet->getStyle("B1")->getFont()->setSize(20)->setBold(true);
        $sheet->getStyle('B1')->getAlignment()->setHorizontal('center');

        $sheet->setCellValue('A4', 'PERIODE');
        $sheet->getStyle("A4")->getFont()->setSize(12)->setBold(true);

        $sheet->setCellValue('B4', $request->dari);
        $sheet->setCellValue('B4', ':'." ".$request->dari. " s/d ".$request->sampai);
        $sheet->getStyle("B4")->getFont()->setSize(12)->setBold(true);

        $sheet->mergeCells('B1:I3');

        $detail_table_header_row = 6;
        $detail_start_row = $detail_table_header_row + 1;

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

            'borders' => [
                'top' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
                'right' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
                'bottom' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
                'left' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN]
            ]
        ];

        $styleArray2 = [
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
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
                'label' => 'NO POLISI',
                'index' => 'nopol',
            ],
            [
                'label' => 'NAMA SUPIR',
                'index' => 'namasupir',
            ],
            [
                'label' => 'RUTE',
                'index' => 'rute',
            ],
            [
                'label' => 'QTY',
                'index' => 'qty',
            ],
            [
                'label' => 'LOKASI MUAT',
                'index' => 'lokasimuat',
            ],
            [
                'label' => 'NO CONT SEAL',
                'index' => 'nocontseal',
            ],
            [
                'label' => 'EMKL',
                'index' => 'emkl',
            ],
            [
                'label' => 'SP FULL',
                'index' => 'spfull',
            ],
            [
                'label' => 'SP EMPTY',
                'index' => 'spempty',
            ],
            [
                'label' => 'SP FULL EMPTY',
                'index' => 'spfullempty',
            ],
            [
                'label' => 'JOB TRUCKING',
                'index' => 'jobtrucking',
            ],
            [
                'label' => 'OMSET',
                'index' => 'omset',
            ],
            [
                'label' => 'INVOICE',
                'index' => 'invoice',
            ],
            [
                'label' => 'GAJI SUPIR',
                'index' => 'gajisupir',
            ],
            [
                'label' => 'NO BUKTI EBS',
                'index' => 'nobuktiebs',
            ],
           
        ];

        foreach ($header_columns as $detail_columns_index => $detail_column) {
            $sheet->setCellValue($alphabets[$detail_columns_index] . $detail_table_header_row, $detail_column['label'] ?? $detail_columns_index + 1);
        }
        $sheet->getStyle("A$detail_table_header_row:Q$detail_table_header_row")->applyFromArray($styleArray)->getFont()->setBold(true);

        // LOOPING DETAIL
        $totalDebet = 0;
        $totalKredit = 0;
        $totalSaldo = 0;
        foreach ($data as $response_index => $response_detail) {

            foreach ($header_columns as $detail_columns_index => $detail_column) {
                $sheet->setCellValue($alphabets[$detail_columns_index] . $detail_start_row, isset($detail_column['index']) ? $response_detail[$detail_column['index']] : $response_index + 1);
            }

            $sheet->setCellValue("A$detail_start_row", $response_detail['nobukti']);
            $sheet->setCellValue("B$detail_start_row", $response_detail['tglbukti']);
            $sheet->setCellValue("C$detail_start_row", $response_detail['nopol']);
            $sheet->setCellValue("D$detail_start_row", $response_detail['namasupir']);
            $sheet->setCellValue("E$detail_start_row", $response_detail['rute']);
            $sheet->setCellValue("F$detail_start_row", $response_detail['qty']);
            $sheet->setCellValue("G$detail_start_row", $response_detail['lokasimuat']);
            $sheet->setCellValue("H$detail_start_row", $response_detail['nocontseal']);
            $sheet->setCellValue("I$detail_start_row", $response_detail['emkl']);
            $sheet->setCellValue("J$detail_start_row", $response_detail['spfull']);
            $sheet->setCellValue("K$detail_start_row", $response_detail['spempty']);
            $sheet->setCellValue("L$detail_start_row", $response_detail['spfullempty']);
            $sheet->setCellValue("M$detail_start_row", $response_detail['jobtrucking']);
            $sheet->setCellValue("N$detail_start_row", $response_detail['omset']);
            $sheet->setCellValue("O$detail_start_row", $response_detail['invoice']);
            $sheet->setCellValue("P$detail_start_row", $response_detail['gajisupir']);
            $sheet->setCellValue("Q$detail_start_row", $response_detail['nobuktiebs']);

            $sheet->getStyle("A$detail_start_row:Q$detail_start_row")->applyFromArray($styleArray);
            $sheet->getStyle("I$detail_start_row:L$detail_start_row")->applyFromArray($styleArray2);
            $sheet->getStyle("N$detail_start_row:N$detail_start_row")->getNumberFormat()->setFormatCode("#,##0.00");
            $sheet->getStyle("P$detail_start_row:P$detail_start_row")->getNumberFormat()->setFormatCode("#,##0.00");
            $sheet->getStyle("B$detail_start_row:B$detail_start_row")->getNumberFormat()->setFormatCode('dd-mm-yyyy');
           

        //    $totalKredit += $response_detail['kredit'];
        //     $totalDebet += $response_detail['debet'];
        //     $totalSaldo += $response_detail['Saldo'];
            $detail_start_row++;
        }
        $rowKosong = "";

       //total
       $total_start_row = $detail_start_row;
       $sheet->mergeCells('A' . $total_start_row . ':M' . $total_start_row);
       $sheet->setCellValue("A$total_start_row", 'Total :')->getStyle('A' . $total_start_row . ':M' . $total_start_row)->applyFromArray($styleArray)->getFont()->setBold(true);

       $totalDebet = "=SUM(N7:N" . ($detail_start_row-1) . ")";
       $sheet->setCellValue("N$total_start_row", $totalDebet)->getStyle("N$total_start_row")->applyFromArray($style_number)->getFont()->setBold(true);
       $sheet->setCellValue("N$total_start_row", $totalDebet)->getStyle("N$total_start_row")->getNumberFormat()->setFormatCode("#,##0.00");

       $totalKredit = "=SUM(P7:P" . ($detail_start_row-1) . ")";
       $sheet->setCellValue("P$total_start_row", $totalKredit)->getStyle("P$total_start_row")->applyFromArray($style_number)->getFont()->setBold(true);
       $sheet->setCellValue("P$total_start_row", $totalKredit)->getStyle("P$total_start_row")->getNumberFormat()->setFormatCode("#,##0.00");

       $sheet->setCellValue("O$total_start_row", $rowKosong)->getStyle("O$total_start_row")->applyFromArray($style_number);
       $sheet->setCellValue("Q$total_start_row", $rowKosong)->getStyle("Q$total_start_row")->applyFromArray($style_number);


    //     $ttd_start_row = $detail_start_row + 2;
    //     $sheet->setCellValue("A$ttd_start_row", 'Disetujui Oleh,');
    //     $sheet->setCellValue("C$ttd_start_row", 'Diperiksa Oleh,');
    //     $sheet->setCellValue("F$ttd_start_row", 'Disusun Oleh,');

    //     $sheet->setCellValue("A" . ($ttd_start_row + 3), '( Bpk. Hasan )');
    //     $sheet->setCellValue("C" . ($ttd_start_row + 3), '( Rina )');
    //     $sheet->setCellValue("F" . ($ttd_start_row + 3), '(                )');

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
        $sheet->getColumnDimension('M')->setAutoSize(true);
        $sheet->getColumnDimension('N')->setAutoSize(true);
        $sheet->getColumnDimension('O')->setAutoSize(true);
        $sheet->getColumnDimension('P')->setAutoSize(true);
        $sheet->getColumnDimension('Q')->setAutoSize(true);



        $writer = new Xlsx($spreadsheet);
        $filename = 'LAPORAN MINGGUAN SUPIR' . date('dmYHis');
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');

    
    }
}

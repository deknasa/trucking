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


class LaporanPenyesuaianBarangController extends MyController
{
    public $title = 'Laporan Penyesuaian Barang';

    public function index(Request $request)
    {
        $title = $this->title;
        $data = [
            'pagename' => 'Menu Utama Laporan Penyesuaian Barang',
        ];

        return view('laporanpenyesuaianbarang.index', compact('title'));
    }

    public function report(Request $request)
    {
      
        $detailParams = [
            'dari' => $request->dari,
            'sampai' => $request->sampai,
        ];

        $header = Http::withHeaders(request()->header())
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'laporanpenyesuaianbarang/report', $detailParams);

        $data = $header['data'];
        $user = Auth::user();
        return view('reports.laporanpenyesuaianbarang', compact('data', 'user', 'detailParams'));
    }

    public function export(Request $request): void
    {
        $detailParams = [
            'dari' => $request->dari,
            'sampai' => $request->sampai,
        ];
       

        $header = Http::withHeaders(request()->header())
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'laporanpenyesuaianbarang/export', $detailParams);

        $data = $header['data'];

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('b1', 'LAPORAN PENYESUAIAN BARANG');
        $sheet->getStyle("B1")->getFont()->setSize(20)->setBold(true);
        $sheet->getStyle('B1')->getAlignment()->setHorizontal('center');
        $sheet->mergeCells('B1:I3');

        $sheet->setCellValue('A4', 'PERIODE');
        $sheet->getStyle("A4")->getFont()->setSize(12)->setBold(true);
        $sheet->getStyle("B4")->getFont()->setSize(12)->setBold(true);

        $sheet->setCellValue('B4',': '. $request->dari." S/D"." ".$request->sampai);
        $sheet->getStyle("C4")->getFont()->setSize(12)->setBold(true);

        $detail_table_header_row = 6;
        $detail_start_row = $detail_table_header_row + 1;

        $alphabets = range('A', 'Z');

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

        $header_columns = [
            [
                'label' => 'No Polisi',
                'index' => 'nopolisi',
            ],
            [
                'label' => 'No Bukti',
                'index' => 'nobukti',
            ],
            [
                'label' => 'TGL bukti',
                'index' => 'tglbukti',
            ],
            [
                'label' => 'Keterangan',
                'index' => 'keterangan',
            ],
            [
                'label' => 'Kode Stok',
                'index' => 'stok_id',
            ],
            [
                'label' => 'Nama Stok',
                'index' => 'namastok',
            ],
            [
                'label' => 'Gudang',
                'index' => 'gudang',
            ],
            [
                'label' => 'QTY',
                'index' => 'qty',
            ],
            [
                'label' => 'Harga',
                'index' => 'harga',
            ],
            [
                'label' => 'Nominal',
                'index' => 'nominal',
            ],
        ];

        

        foreach ($header_columns as $detail_columns_index => $detail_column) {
            $sheet->setCellValue($alphabets[$detail_columns_index] . $detail_table_header_row, $detail_column['label'] ?? $detail_columns_index + 1);
        }
        $sheet->getStyle("A$detail_table_header_row:J$detail_table_header_row")->applyFromArray($styleArray)->getFont()->setBold(true);

        // LOOPING DETAIL
        $totalDebet = 0;
        $totalKredit = 0;
        $totalSaldo = 0;
        foreach ($data as $response_index => $response_detail) {

            foreach ($header_columns as $detail_columns_index => $detail_column) {
                $sheet->setCellValue($alphabets[$detail_columns_index] . $detail_start_row, isset($detail_column['index']) ? $response_detail[$detail_column['index']] : $response_index + 1);
            }

            $sheet->setCellValue("A$detail_start_row", $response_detail['nopolisi']);
            $sheet->setCellValue("B$detail_start_row", $response_detail['nobukti']);
            $sheet->setCellValue("C$detail_start_row", $response_detail['tglbukti']);
            $sheet->setCellValue("D$detail_start_row", $response_detail['keterangan']);
            $sheet->setCellValue("E$detail_start_row", $response_detail['stok_id']);
            $sheet->setCellValue("F$detail_start_row", $response_detail['namastok']);
            $sheet->setCellValue("G$detail_start_row", $response_detail['gudang']);
            $sheet->setCellValue("H$detail_start_row", $response_detail['qty']);
            $sheet->setCellValue("I$detail_start_row", $response_detail['harga']);
            $sheet->setCellValue("J$detail_start_row", $response_detail['nominal']);

            $sheet->getStyle("A$detail_start_row:J$detail_start_row")->applyFromArray($styleArray);
             $sheet->getStyle("I$detail_start_row:J$detail_start_row")->getNumberFormat()->setFormatCode("#,##0.00");
             $sheet->getStyle("C$detail_start_row:C$detail_start_row")->getNumberFormat()->setFormatCode('dd-mm-yyyy');


           $totalKredit += $response_detail['harga'];
            $totalDebet += $response_detail['nominal'];
            $detail_start_row++;
        }

         //total
       $total_start_row = $detail_start_row;
       $sheet->mergeCells('A' . $total_start_row . ':H' . $total_start_row);
       $sheet->setCellValue("A$total_start_row", 'Total')->getStyle('A' . $total_start_row . ':H' . $total_start_row)->applyFromArray($styleArray)->getFont()->setBold(true);


       $totalKredit = "=SUM(I6:I" . ($detail_start_row-1) . ")";
       $sheet->setCellValue("I$total_start_row", $totalKredit)->getStyle("I$total_start_row")->applyFromArray($style_number);
       $sheet->setCellValue("I$total_start_row", $totalKredit)->getStyle("I$total_start_row")->getNumberFormat()->setFormatCode("#,##0.00");

       $totalSaldo = "=SUM(J6:J" . ($detail_start_row-1) . ")";
       $sheet->setCellValue("J$total_start_row", $totalSaldo)->getStyle("J$total_start_row")->applyFromArray($style_number);
       $sheet->setCellValue("J$total_start_row", $totalSaldo)->getStyle("J$total_start_row")->getNumberFormat()->setFormatCode("#,##0.00");

        // set diketahui dibuat
        $ttd_start_row = $detail_start_row + 2;
        $sheet->setCellValue("C$ttd_start_row", 'Disetujui Oleh,');
        $sheet->setCellValue("E$ttd_start_row", 'Diperiksa Oleh,');
        $sheet->setCellValue("G$ttd_start_row", 'Disusun Oleh,');

        $sheet->setCellValue("C" . ($ttd_start_row + 3), '( Bpk. Hasan )');
        $sheet->setCellValue("E" . ($ttd_start_row + 3), '( Rina )');
        $sheet->setCellValue("G" . ($ttd_start_row + 3), '(                )');


        //style header
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

        // $sheet->getStyle("A4")->applyFromArray($styleArray3);
        // $sheet->getStyle("B4")->applyFromArray($styleArray3);
        // $sheet->getStyle("C4")->applyFromArray($styleArray3);
        // $sheet->getStyle("D4")->applyFromArray($styleArray3);
        // $sheet->getStyle("E4")->applyFromArray($styleArray3);
        // $sheet->getStyle("F4")->applyFromArray($styleArray3);
        // $sheet->getStyle("G4")->applyFromArray($styleArray3);
        // $sheet->getStyle("H4")->applyFromArray($styleArray3);
        // $sheet->getStyle("I4")->applyFromArray($styleArray3);
        // $sheet->getStyle("J4")->applyFromArray($styleArray3);
        // $sheet->getStyle("A")->applyFromArray($styleArray);
        // $sheet->getStyle("E")->applyFromArray($styleArray);


        $writer = new Xlsx($spreadsheet);
        $filename = 'LAPORAN PENYESUAIAN BARANG' . date('dmYHis');
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }
}



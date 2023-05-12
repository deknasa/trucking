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


class LaporanKeteranganPinjamanSupirController extends MyController
{
    public $title = 'Laporan Keterangan Pinjaman Supir';

    public function index(Request $request)
    {
        $title = $this->title;
        $data = [
            'pagename' => 'Menu Utama Laporan Keterangan Pinjaman Supir',
        ];

        return view('laporanketeranganpinjamansupir.index', compact('title'));
    }

    public function report(Request $request)
    {
        $detailParams = [
            'periode' => $request->periode,
            'jenis' => $request->jenis,
        ];

        $header = Http::withHeaders(request()->header())
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'laporanketeranganpinjamansupir/report', $detailParams);

        $data = $header['data'];
        $user = Auth::user();
        return view('reports.laporanketeranganpinjamansupir', compact('data', 'user', 'detailParams'));
    }
    public function export(Request $request): void
    {
        $detailParams = [
            'periode' => $request->periode,
            'jenis' => $request->jenis,
        ];

        $header = Http::withHeaders(request()->header())
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'laporanketeranganpinjamansupir/export', $detailParams);

        $data = $header['data'];

      

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('b1', 'LAPORAN KETERANGAN PINJAMAN SUPIR');
        $sheet->getStyle("B1")->getFont()->setSize(20)->setBold(true);
        $sheet->getStyle('B1')->getAlignment()->setHorizontal('center');
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

        foreach ($header_columns as $detail_columns_index => $detail_column) {
            $sheet->setCellValue($alphabets[$detail_columns_index] . $detail_table_header_row, $detail_column['label'] ?? $detail_columns_index + 1);
        }
        $sheet->getStyle("A$detail_table_header_row:F$detail_table_header_row")->applyFromArray($styleArray)->getFont()->setBold(true);

        // LOOPING DETAIL
        $totalDebet = 0;
        $totalKredit = 0;
        $totalSaldo = 0;
        foreach ($data as $response_index => $response_detail) {

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



       //total
       $total_start_row = $detail_start_row;
       $sheet->mergeCells('A' . $total_start_row . ':C' . $total_start_row);
       $sheet->setCellValue("A$total_start_row", 'Total :')->getStyle('A' . $total_start_row . ':C' . $total_start_row)->applyFromArray($styleArray)->getFont()->setBold(true);

       $totalDebet = "=SUM(D6:D" . ($detail_start_row-1) . ")";
       $sheet->setCellValue("D$total_start_row", $totalDebet)->getStyle("D$total_start_row")->applyFromArray($style_number);
       $sheet->setCellValue("D$total_start_row", $totalDebet)->getStyle("D$total_start_row")->getNumberFormat()->setFormatCode("#,##0.00");

       $totalKredit = "=SUM(E6:E" . ($detail_start_row-1) . ")";
       $sheet->setCellValue("E$total_start_row", $totalKredit)->getStyle("E$total_start_row")->applyFromArray($style_number);
       $sheet->setCellValue("E$total_start_row", $totalKredit)->getStyle("E$total_start_row")->getNumberFormat()->setFormatCode("#,##0.00");

       $totalSaldo = "=SUM(F6:F" . ($detail_start_row-1) . ")";
       $sheet->setCellValue("F$total_start_row", $totalSaldo)->getStyle("F$total_start_row")->applyFromArray($style_number);
       $sheet->setCellValue("F$total_start_row", $totalSaldo)->getStyle("F$total_start_row")->getNumberFormat()->setFormatCode("#,##0.00");

        $ttd_start_row = $detail_start_row + 2;
        $sheet->setCellValue("A$ttd_start_row", 'Disetujui Oleh,');
        $sheet->setCellValue("C$ttd_start_row", 'Diperiksa Oleh,');
        $sheet->setCellValue("F$ttd_start_row", 'Disusun Oleh,');

        $sheet->setCellValue("A" . ($ttd_start_row + 3), '( Bpk. Hasan )');
        $sheet->setCellValue("C" . ($ttd_start_row + 3), '( Rina )');
        $sheet->setCellValue("F" . ($ttd_start_row + 3), '(                )');

        $sheet->getColumnDimension('A')->setAutoSize(true);
        $sheet->getColumnDimension('B')->setAutoSize(true);
        $sheet->getColumnDimension('C')->setAutoSize(true);
        $sheet->getColumnDimension('D')->setAutoSize(true);
        $sheet->getColumnDimension('E')->setAutoSize(true);
        $sheet->getColumnDimension('F')->setAutoSize(true);



        $writer = new Xlsx($spreadsheet);
        $filename = 'LAPORAN KETERANGAN PINJAMAN SUPIR' . date('dmYHis');
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }

}

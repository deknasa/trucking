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

class LaporanRekapTitipanEmklController extends MyController
{
    public $title = 'Laporan Rekap Titipan EMKL';

    public function index(Request $request)
    {
        $title = $this->title;

        $data = [
            'pagename' => 'Menu Utama Laporan Rekap Titipan EMKL',
        ];

        return view('laporanrekaptitipanemkl.index', compact('title'));
    }

    

    public function report(Request $request)
    {
        $detailParams = [
            'periode' => $request->periode,
        ];

        $header = Http::withHeaders(request()->header())
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'laporanrekaptitipanemkl/report', $detailParams);

        $data = $header['data'];
        $user = Auth::user();
        return view('reports.laporanrekaptitipanemkl', compact('data', 'user', 'detailParams'));
    }

    public function export(Request $request): void
    {
        $detailParams = [
            'periode' => $request->periode,
        ];

        $responses = Http::withHeaders($request->header())
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'laporanrekaptitipanemkl/export', $detailParams);

        $pengeluaran = $responses['data'];

        // dd($pengeluaran);
        $user = Auth::user();
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', $pengeluaran[0]['judul']);
        $sheet->setCellValue('A2', $pengeluaran[0]['judullaporan']);
        $sheet->setCellValue('A3', 'Periode: ' . $request->periode);

        $sheet->getStyle("A1")->getFont()->setSize(16)->setBold(true);

        $sheet->getStyle('A1')->getAlignment()->setHorizontal('center');
        $sheet->getStyle('A2')->getAlignment()->setHorizontal('left');
        $sheet->mergeCells('A1:E1');

        $header_start_row = 5;
        $detail_start_row = 6;

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

            'borders' => array(
                'allBorders' => array(
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ),
            ),
        ];

        $alphabets = range('A', 'Z');



        $header_columns = [
            [
                "index"=>"nobukti",
                "label"=>"NO BUKTI"
            ],
            [
                "index"=>"tglbukti",
                "label"=>"TGL BUKTI"
            ],
            [
                "index"=>"keterangan",
                "label"=>"KETERANGAN"
            ],
            [
                "index"=>"nominal",
                "label"=>"NOMINAL"
            ],
            
        ];

        $tradoPrev = null;
        foreach ($header_columns as $data_columns_index => $data_column) {
            $sheet->setCellValue($alphabets[$data_columns_index] . $header_start_row, $data_column['label'] ?? $data_columns_index + 1);
        }

        $lastColumn = $alphabets[$data_columns_index];
        $sheet->getStyle("A$header_start_row:$lastColumn$header_start_row")->applyFromArray($styleArray)->getFont()->setBold(true);

        if (is_array($pengeluaran) || is_iterable($pengeluaran)) {
            foreach ($pengeluaran as $response_index => $response_detail) {

                foreach ($header_columns as $detail_columns_index => $detail_column) {
                    $sheet->setCellValue($alphabets[$detail_columns_index] . $detail_start_row, isset($detail_column['index']) ? $response_detail[$detail_column['index']] : $response_index + 1);
                }


                $sheet->setCellValue("A$detail_start_row", $response_detail['nobukti']);
                $sheet->setCellValue("B$detail_start_row", date('d-m-Y', strtotime($response_detail['tglbukti'])));
                $sheet->setCellValue("C$detail_start_row", $response_detail['keterangan']);
                $sheet->setCellValue("D$detail_start_row", $response_detail['nominal']);
                // $sheet->setCellValue("E$detail_start_row", $response_detail['saldo']);
                $sheet->getColumnDimension('C')->setWidth(150);


                $sheet->getStyle("A$detail_start_row:D$detail_start_row")->applyFromArray($styleArray);
                $sheet->getStyle("D$detail_start_row")->getNumberFormat()->setFormatCode("#,##0.00");
                // $sheet->getStyle("E$detail_start_row")->getNumberFormat()->setFormatCode("#,##0.00");
                $detail_start_row++;
            }
        }

        //total
        $total_start_row = $detail_start_row;
        $sheet->mergeCells('A' . $total_start_row . ':C' . $total_start_row);
        $sheet->setCellValue("A$total_start_row", 'Total')->getStyle('A' . $total_start_row . ':C' . $total_start_row)->applyFromArray($styleArray)->getFont()->setBold(true);

        // $totalDebet = "=SUM(E6:E" . ($detail_start_row - 1) . ")";
        // $sheet->setCellValue("E$total_start_row", $totalDebet)->getStyle("E$total_start_row")->applyFromArray($style_number);
        // $sheet->setCellValue("E$total_start_row", $totalDebet)->getStyle("E$total_start_row")->getNumberFormat()->setFormatCode("#,##0.00");
        $totalDebet = "=SUM(D6:D" . ($detail_start_row - 1) . ")";
        $sheet->setCellValue("D$total_start_row", $totalDebet)->getStyle("D$total_start_row")->applyFromArray($style_number);
        $sheet->setCellValue("D$total_start_row", $totalDebet)->getStyle("D$total_start_row")->getNumberFormat()->setFormatCode("#,##0.00");

        $ttd_start_row = $detail_start_row + 2;
        $sheet->setCellValue("A$ttd_start_row", 'Disetujui Oleh,');
        $sheet->setCellValue("C$ttd_start_row", 'Diperiksa Oleh,');
        $sheet->setCellValue("E$ttd_start_row", 'Disusun Oleh,');

        $sheet->setCellValue("A" . ($ttd_start_row + 3), '( Bpk. Hasan )');
        $sheet->setCellValue("C" . ($ttd_start_row + 3), '( Rina )');
        $sheet->setCellValue("E" . ($ttd_start_row + 3), '(                )');

        //ukuran kolom
        $sheet->getColumnDimension('A')->setAutoSize(true);
        $sheet->getColumnDimension('B')->setAutoSize(true);
        $sheet->getColumnDimension('D')->setAutoSize(true);
        // $sheet->getColumnDimension('E')->setAutoSize(true);



        $writer = new Xlsx($spreadsheet);
        $filename = 'Laporan Rekap Titipan EMKL' . date('dmYHis');
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }
}

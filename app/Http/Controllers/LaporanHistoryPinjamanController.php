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


class LaporanHistoryPinjamanController extends MyController
{
    public $title = 'Export Laporan History Pinjaman';

    public function index(Request $request)
    {
        $title = $this->title;
        $data = [
            'pagename' => 'Menu Utama Export Laporan History Pinjaman',
        ];

        return view('laporanhistorypinjaman.index', compact('title'));
    }

    public function report(Request $request)
    {
        $detailParams = [
            'supirdari_id' => $request->supirdari_id,
            'supirsampai_id' => $request->supirsampai_id,
        ];

        $responses = Http::withHeaders($request->header())
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'laporanhistorypinjaman/report', $detailParams);
        // dd($responses['data']);
        $data = $responses['data'];
        $user = Auth::user();

        return view('reports.laporanhistorypinjaman', compact('data', 'user', 'detailParams'));
    }

    public function export(Request $request)
    {
        $detailParams = [
            'supirdari_id' => $request->supirdari_id,
            'supirsampai_id' => $request->supirsampai_id,
        ];

        $responses = Http::withHeaders($request->header())
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'laporanhistorypinjaman/export', $detailParams);

        $pengeluaran = $responses['data'];
        $user = Auth::user();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'Laporan History Pinjaman ');
        $sheet->getStyle("A1")->getFont()->setSize(20)->setBold(true);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal('center');
        $sheet->mergeCells('A1:E1');

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
                'index' => 'tglbukti',
            ],
            [
                'label' => 'No Bukti',
                'index' => 'nobukti',
            ],
            [
                'label' => 'Nama Supir',
                'index' => 'namasupir',
            ],
            [
                'label' => 'Nominal',
                'index' => 'nominal',
            ],
            [
                'label' => 'Saldo',
                'index' => 'Saldo',
            ],
        ];

        foreach ($header_columns as $data_columns_index => $data_column) {
            $sheet->setCellValue($alphabets[$data_columns_index] . $header_start_row, $data_column['label'] ?? $data_columns_index + 1);
        }
        $totalnominal = 0;
        $totalSaldo = 0;
        foreach ($pengeluaran as $response_index => $response_detail) {
            $totalnominal += $response_detail['nominal'];
            $totalSaldo += $response_detail['Saldo'];
            foreach ($header_columns as $data_columns_index => $data_column) {
                if (($data_column['index'] == 'nominal') || ($data_column['index'] == 'Saldo')) {
                    // $response_detail[$data_column['index']] = (number_format((float) $response_detail[$data_column['index']], '2', '.', ','))->applyFromArray($style_number);
                    $sheet->setCellValue($alphabets[$data_columns_index] . $detail_start_row, $response_detail[$data_column['index']])->getStyle($alphabets[$data_columns_index] . $detail_start_row)->applyFromArray($style_number)->getNumberFormat()->setFormatCode("#,##0.00");
                } else {
                    $sheet->setCellValue($alphabets[$data_columns_index] . $detail_start_row, $response_detail[$data_column['index']]);
                }
            }
            $detail_start_row++;
        }

        $lastColumn = $alphabets[$data_columns_index];
        $sheet->getStyle("A$header_start_row:$lastColumn$header_start_row")->getFont()->setBold(true);

        $sheet->getColumnDimension('A')->setAutoSize(true);
        $sheet->getColumnDimension('B')->setAutoSize(true);
        $sheet->getColumnDimension('C')->setAutoSize(true);
        $sheet->getColumnDimension('D')->setAutoSize(true);
        $sheet->getColumnDimension('E')->setAutoSize(true);
        // $sheet->getColumnDimension('F')->setAutoSize(true);
        $total_start_row = $detail_start_row;
        // $sheet->setCellValue("A$total_start_row", 'Total')->getStyle('A'.$total_start_row.':C'.$total_start_row)->getFont()->setBold(true);

        // $sheet->setCellValue("D$total_start_row", number_format((float) $totalnominal, '2', '.', ','))->getStyle("D$detail_start_row")->applyFromArray($style_number)->getFont()->setBold(true);
        // $sheet->setCellValue("E$total_start_row", number_format((float) $totalSaldo, '2', '.', ','))->getStyle("E$detail_start_row")->applyFromArray($style_number)->getFont()->setBold(true);



        $writer = new Xlsx($spreadsheet);
        $filename = 'LAPORANHISTORYPINJAMAN' . date('dmYHis');
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }
}

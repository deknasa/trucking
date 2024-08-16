<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class LaporanArusDanaPusatController extends MyController
{
    public $title = 'LAPORAN ARUS DANA PUSAT-CABANG MINGGUAN';

    public function index(Request $request)
    {
        $title = $this->title;
        $data = [
            'pagename' => 'Menu Utama LAPORAN ARUS DANA PUSAT-CABANG MINGGUAN',
        ];

        return view('laporanarusdanapusat.index', compact('title'));
    }
    public function report(Request $request)
    {
        $detailParams = [
            'tgldari' => $request->tgldari,
            'tglsampai' => $request->tglsampai,
            'cabang_id' => $request->cabang_id,
            'cabang' => $request->cabang,
            'minggu' => $request->minggu,
        ];

        $header = Http::withHeaders(request()->header())
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'laporanarusdanapusat/report', $detailParams);

        $data = $header['data'];

        $user = Auth::user();
        return view('reports.laporanarusdanapusat', compact('data', 'user'));
    }

    public function export(Request $request): void
    {
        $detailParams = [
            'tgldari' => $request->tgldari,
            'tglsampai' => $request->tglsampai,
            'cabang_id' => $request->cabang_id,
            'cabang' => $request->cabang,
            'minggu' => $request->minggu,
        ];
        $header = Http::withHeaders(request()->header())
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'laporanarusdanapusat/export', $detailParams);

        $data = $header['data'];

        if (count($data) == 0) {
            throw new \Exception('TIDAK ADA DATA');
        }
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', $data[0]['judul']);
        $sheet->getStyle("A1")->getFont()->setSize(16)->setBold(true);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal('center');
        $sheet->mergeCells('A1:G1');
        $sheet->setCellValue('A2', $data[0]['judulLaporan']);
        $sheet->mergeCells('A2:D2');

        $sheet->getStyle("A2")->getFont()->setBold(true);

        $detail_table_header_row = 4;
        $detail_start_row = 4;

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

        $detail_columns = [
            [
                'label' => 'TANGGAL',
                'index' => 'tglbukti',
            ],
            [
                'label' => 'KETERANGAN',
                'index' => 'keterangan',
            ],
            [
                'label' => 'DEBET',
                'index' => 'debet'
            ],
            [
                'label' => 'KREDIT',
                'index' => 'kredit'
            ],
            [
                'label' => 'SALDO',
                'index' => 'saldo'
            ]
        ];
        $supplier = '';
        $groupedData = [];
        if (is_array($data)) {

            foreach ($data as $row) {
                $namacabang = $row['namacabang'];
                $groupedData[$namacabang][] = $row;
            }
        }

        if (is_array($data) || is_iterable($data)) {
            foreach ($groupedData as $namacabang => $group) {
                foreach ($detail_columns as $data_columns_index => $data_column) {

                    $sheet->setCellValue($alphabets[$data_columns_index] . $detail_start_row, $data_column['label'] ?? $data_columns_index + 1);
                    $lastColumn = $alphabets[$data_columns_index];
                    $sheet->getStyle("A$detail_start_row:$lastColumn$detail_start_row")->applyFromArray($styleArray)->getFont()->setBold(true);
                }
                $detail_start_row++;
                $sheet->mergeCells("A$detail_start_row:E$detail_start_row");
                $sheet->setCellValue("A$detail_start_row", $namacabang . ' ' . $group[0]['mingguke'])->getStyle("A$detail_start_row:E$detail_start_row")->applyFromArray($styleArray)->getFont()->setBold(true);
                $detail_start_row++;

                foreach ($group as $response_detail) {

                    $tanggal = ($response_detail['tanggal'] != null) ? Date::PHPToExcel(date('Y-m-d', strtotime($response_detail['tanggal']))) : '';
                    $sheet->setCellValue("A$detail_start_row", $tanggal);
                    $sheet->setCellValue("B$detail_start_row", $response_detail['keterangan']);
                    $sheet->setCellValue("C$detail_start_row", $response_detail['debet']);
                    $sheet->setCellValue("D$detail_start_row", $response_detail['kredit']);
                    $sheet->setCellValue("E$detail_start_row", $response_detail['saldo']);
                    $sheet->getStyle("A$detail_start_row")->getNumberFormat()->setFormatCode('dd-mm-yyyy');
                    $sheet->getStyle("C$detail_start_row")->getNumberFormat()->setFormatCode("#,##0.00_);(#,##0.00)");
                    $sheet->getStyle("D$detail_start_row")->getNumberFormat()->setFormatCode("#,##0.00_);(#,##0.00)");
                    $sheet->getStyle("E$detail_start_row")->getNumberFormat()->setFormatCode("#,##0.00_);(#,##0.00)");
                    $sheet->getStyle("A$detail_start_row:E$detail_start_row")->applyFromArray($styleArray);
                    $detail_start_row++;
                    
                }

                
                $detail_start_row++;
            }
        }

        $sheet->getColumnDimension('A')->setAutoSize(true);
        $sheet->getColumnDimension('B')->setWidth(70);
        $sheet->getColumnDimension('C')->setAutoSize(true);
        $sheet->getColumnDimension('D')->setAutoSize(true);
        $sheet->getColumnDimension('E')->setAutoSize(true);

        $writer = new Xlsx($spreadsheet);
        $filename = 'LAPORAN ARUS DANA PUSAT' . date('dmYHis');
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }
}

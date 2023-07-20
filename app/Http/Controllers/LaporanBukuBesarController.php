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


class LaporanBukuBesarController extends MyController
{
    public $title = 'Laporan Buku Besar';

    public function index(Request $request)
    {
        $title = $this->title;
        $data = [
            'pagename' => 'Menu Utama Laporan Buku Besar',
        ];

        return view('laporanbukubesar.index', compact('title'));
    }

    public function report(Request $request)
    {
        $detailParams = [
            'dari' => $request->dari,
            'sampai' => $request->sampai,
            'coadari_id' => $request->coadari_id,
            'coasampai_id' => $request->coasampai_id,
            'coadari' => $request->coadari,
            'coasampai' => $request->coasampai,
        ];

        $header = Http::withHeaders(request()->header())
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'laporanbukubesar/report', $detailParams);

        $data = $header['data'];
        $dataheader = $header['dataheader'];
        $user = Auth::user();
        return view('reports.laporanbukubesar', compact('data', 'user', 'dataheader'));
    }

    public function export(Request $request): void
    {
        $detailParams = [
            'dari' => $request->dari,
            'sampai' => $request->sampai,
            'coadari_id' => $request->coadari_id,
            'coasampai_id' => $request->coasampai_id,
        ];

        $responses = Http::withHeaders($request->header())
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'laporanbukubesar/report', $detailParams);

        $bukubesar = $responses['data'];
        $dataheader = $responses['dataheader'];
        $user = Auth::user();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'TAS ' . $dataheader['cabang']);
        $sheet->getStyle("A1")->getFont()->setSize(20)->setBold(true);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal('center');
        $sheet->mergeCells('A1:F1');

        $sheet->setCellValue('A2', 'Buku Besar Divisi Trucking');
        $sheet->getStyle("A2")->getFont()->setSize(16)->setBold(true);
        $sheet->getStyle('A2')->getAlignment()->setHorizontal('center');
        $sheet->mergeCells('A2:F2');

        $sheet->setCellValue('A3', 'Periode : ' . $dataheader['dari'] . ' s/d ' . $dataheader['sampai']);
        $sheet->getStyle("A3")->getFont()->setSize(12)->setBold(true);
        $sheet->getStyle('A3')->getAlignment()->setHorizontal('center');
        $sheet->mergeCells('A3:F3');

        $sheet->setCellValue('A4', 'No Perk. : ' .  $dataheader['coadari'] . ' s/d ' . $dataheader['coasampai']);
        $sheet->getStyle("A4")->getFont()->setSize(12)->setBold(true);
        $sheet->getStyle('A4')->getAlignment()->setHorizontal('center');
        $sheet->mergeCells('A4:F4');

        $sheet->setCellValue('A5', ' ' . $dataheader['ketcoadari'] . ' s/d ' . $dataheader['ketcoasampai']);
        $sheet->getStyle("A5")->getFont()->setSize(12)->setBold(true);
        $sheet->getStyle('A5')->getAlignment()->setHorizontal('center');
        $sheet->mergeCells('A5:F5');

        $detail_table_header_row = 7;
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

        $detail_columns = [
            [
                'label' => 'Tgl Bukti',
                'index' => 'tglbukti',
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
                'index' => 'debet'
            ],
            [
                'label' => 'Kredit',
                'index' => 'kredit'
            ],
            [
                'label' => 'Saldo',
                'index' => 'saldo'
            ]
        ];


        foreach ($detail_columns as $detail_columns_index => $detail_column) {
            $sheet->setCellValue($alphabets[$detail_columns_index] . $detail_table_header_row, $detail_column['label'] ?? $detail_columns_index + 1);
        }
        $sheet->getStyle("A$detail_table_header_row:F$detail_table_header_row")->applyFromArray($styleArray)->getFont()->setBold(true);

        // LOOPING DETAIL
        $totalKredit = 0;
        $totalDebet = 0;
        $totalSaldo = 0;
        foreach ($bukubesar as $response_index => $response_detail) {

            foreach ($detail_columns as $detail_columns_index => $detail_column) {
                $sheet->setCellValue($alphabets[$detail_columns_index] . $detail_start_row, isset($detail_column['index']) ? $response_detail[$detail_column['index']] : $response_index + 1);
            }

            $sheet->setCellValue("A$detail_start_row", $response_detail['tglbukti']);
            $sheet->setCellValue("B$detail_start_row", $response_detail['nobukti']);
            $sheet->setCellValue("C$detail_start_row", $response_detail['keterangan']);
            $sheet->setCellValue("D$detail_start_row", number_format((float) $response_detail['debet'], '2', ',', '.'));
            $sheet->setCellValue("E$detail_start_row", number_format((float) $response_detail['kredit'], '2', ',', '.'));
            $sheet->setCellValue("F$detail_start_row", number_format((float) $response_detail['saldo'], '2', ',', '.'));

            $sheet->getStyle("A$detail_start_row:F$detail_start_row")->applyFromArray($styleArray);
            $sheet->getStyle("D$detail_start_row:F$detail_start_row")->applyFromArray($style_number);

            $totalKredit += $response_detail['kredit'];
            $totalDebet += $response_detail['debet'];
            $totalSaldo += $response_detail['saldo'];
            $detail_start_row++;
        }

        $sheet->mergeCells('A' . $detail_start_row . ':C' . $detail_start_row);
        $sheet->setCellValue("A$detail_start_row", 'Total')->getStyle('A' . $detail_start_row . ':C' . $detail_start_row)->applyFromArray($styleArray)->getFont()->setBold(true);
        $sheet->setCellValue("D$detail_start_row", number_format((float) $totalDebet, '2', ',', '.'))->getStyle("D$detail_start_row")->applyFromArray($style_number)->getFont()->setBold(true);
        $sheet->setCellValue("E$detail_start_row", number_format((float) $totalKredit, '2', ',', '.'))->getStyle("E$detail_start_row")->applyFromArray($style_number)->getFont()->setBold(true);
        $sheet->setCellValue("F$detail_start_row", number_format((float) $totalSaldo, '2', ',', '.'))->getStyle("F$detail_start_row")->applyFromArray($style_number)->getFont()->setBold(true);


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
        $filename = 'Laporan Kas/Bank' . date('dmYHis');
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }
}

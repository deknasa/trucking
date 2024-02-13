<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class LaporanApprovalStokReuseController extends MyController
{
    public $title = 'Laporan Approval Stok Reuse';
    public function index(Request $request)
    {
        $title = $this->title;
        return view('laporanapprovalstokreuse.index', compact('title'));
    }

    public function report(Request $request)
    {
        $detailParams = [
            'stok_id' => $request->stok_id,
            'stok' => $request->stok,
        ];

        $header = Http::withHeaders($request->header())
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'laporanapprovalstokreuse/report', $detailParams);

        $data = $header['data'];
        $dataheader = $header['dataheader'];
        $printer['tipe'] = $request->printer;
        $user = Auth::user();
        return view('reports.laporanapprovalstokreuse', compact('data', 'dataheader','printer','user'));
    }

    public function export(Request $request): void
    {
        $detailParams = [
            'stok_id' => $request->stok_id,
            'stok' => $request->stok,
        ];

        $responses = Http::withHeaders($request->header())
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'laporanapprovalstokreuse/export', $detailParams);

            // dd($responses->json());
        $stok = $responses['data'];
        if(count($stok) == 0){
            throw new \Exception('TIDAK ADA DATA');
        }
        
        // $dataheader = $responses['dataheader'];
        $user = Auth::user();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', $stok[0]['judul']);
        $sheet->getStyle("A1")->getFont()->setSize(20)->setBold(true);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal('center');
        $sheet->mergeCells('A1:C1');

        $sheet->setCellValue('A2', 'Laporan Approval Stok Reuse');
        $sheet->getStyle("A2")->getFont()->setSize(16)->setBold(true);
        $sheet->getStyle('A2')->getAlignment()->setHorizontal('center');
        $sheet->mergeCells('A2:C2');

        $sheet->setCellValue('A3', 'STOK : ' . $stok[0]['namastok']);
        $sheet->getStyle("A3")->getFont()->setSize(12)->setBold(true);
        $sheet->getStyle('A3')->getAlignment()->setHorizontal('center');
        $sheet->mergeCells('A3:C3');

        // $sheet->setCellValue('A4', 'No Perk. : ' .  $dataheader['coadari'] . ' s/d ' . $dataheader['coasampai']);
        // $sheet->getStyle("A4")->getFont()->setSize(12)->setBold(true);
        // $sheet->getStyle('A4')->getAlignment()->setHorizontal('center');
        // $sheet->mergeCells('A4:F4');

        // $sheet->setCellValue('A5', ' ' . $dataheader['ketcoadari'] . ' s/d ' . $dataheader['ketcoasampai']);
        // $sheet->getStyle("A5")->getFont()->setSize(12)->setBold(true);
        // $sheet->getStyle('A5')->getAlignment()->setHorizontal('center');
        // $sheet->mergeCells('A5:F5');

        $detail_table_header_row = 5;
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
                'label' => 'No Bukti',
                'index' => 'nobukti',
            ],
            [
                'label' => 'Tanggal',
                'index' => 'tglbukti',
            ],
            [
                'label' => 'Lokasi',
                'index' => 'lokasi',
            ],
        ];


        foreach ($detail_columns as $detail_columns_index => $detail_column) {
            $sheet->setCellValue($alphabets[$detail_columns_index] . $detail_table_header_row, $detail_column['label'] ?? $detail_columns_index + 1);
        }
        $sheet->getStyle("A$detail_table_header_row:C$detail_table_header_row")->getFont()->setBold(true);

        if (is_array($stok)) {
            foreach ($detail_columns as $detail_columns_index => $detail_column) {
                $sheet->setCellValue($alphabets[$detail_columns_index] . $detail_table_header_row, $detail_column['label'] ?? $detail_columns_index + 1);
            }
            $sheet->getStyle("A$detail_table_header_row:C$detail_table_header_row")->getFont()->setBold(true);
        }
        // dd($groupedData);
        foreach ($stok as $response_index => $response_detail) {
            
            $dateValue = ($response_detail['tglbukti'] != null) ? Date::PHPToExcel(date('Y-m-d', strtotime($response_detail['tglbukti']))) : '';
            $lokasi = $this->persediaan($response_detail['gudang'], $response_detail['kodetrado'], $response_detail['kodegandengan']);
            $sheet->setCellValue("A$detail_start_row", $response_detail['nobukti']);
            $sheet->setCellValue("B$detail_start_row", $dateValue);
            $sheet->setCellValue("C$detail_start_row", $lokasi['value']);
            $sheet->getStyle("B$detail_start_row")->getNumberFormat()->setFormatCode('dd-mm-yyyy');
            $detail_start_row++;
        }
        $sheet->getStyle("A$detail_table_header_row:" . "C".($detail_start_row-1))->applyFromArray($styleArray);
        $ttd_start_row = $detail_start_row + 2;
        $sheet->setCellValue("A$ttd_start_row", 'Disetujui Oleh,');
        $sheet->setCellValue("C$ttd_start_row", 'Diperiksa Oleh,');
        $sheet->setCellValue("D$ttd_start_row", 'Disusun Oleh,');

        $sheet->setCellValue("A" . ($ttd_start_row + 3), '(                )');
        $sheet->setCellValue("C" . ($ttd_start_row + 3), '(                )');
        $sheet->setCellValue("D" . ($ttd_start_row + 3), '(                )');

        $sheet->getColumnDimension('C')->setWidth(24);
        $sheet->getColumnDimension('A')->setWidth(24);
        $sheet->getColumnDimension('B')->setWidth(18);
        $sheet->getColumnDimension('D')->setAutoSize(true);
        $sheet->getColumnDimension('E')->setAutoSize(true);
        $sheet->getColumnDimension('F')->setAutoSize(true);



        $writer = new Xlsx($spreadsheet);
        $filename = 'LAPORAN BUKU BESAR ' . date('dmYHis');
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }

    public function persediaan($gudang, $trado, $gandengan)
    {
        $kolom = null;
        $value = 0;
        if (!empty($gudang)) {
            $kolom = "Gudang";
            $value = $gudang;
        } elseif (!empty($trado)) {
            $kolom = "Trado";
            $value = $trado;
        } elseif (!empty($gandengan)) {
            $kolom = "Gandengan";
            $value = $gandengan;
        }
        return [
            "column" => $kolom,
            "value" => $value
        ];
    }
}

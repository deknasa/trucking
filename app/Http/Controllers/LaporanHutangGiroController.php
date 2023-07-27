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


class LaporanHutangGiroController extends MyController
{
    public $title = 'Laporan Hutang Giro';

    public function index(Request $request)
    {
        $title = $this->title;
        $data = [
            'pagename' => 'Menu Utama Laporan Hutang Giro',
        ];

        return view('laporanhutanggiro.index', compact('title'));
    }

    public function get($params = []): array
    {
        $params = [
            'offset' => $params['offset'] ?? request()->offset ?? ((request()->page - 1) * request()->rows),
            'limit' => $params['rows'] ?? request()->rows ?? 0,
            'sortIndex' => $params['sidx'] ?? request()->sidx,
            'sortOrder' => $params['sord'] ?? request()->sord,
            'search' => json_decode($params['filters'] ?? request()->filters, 1) ?? [],
        ];

        $response = Http::withHeaders(request()->header())
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'laporanhutanggiro', $params);

        $data = [
            'total' => $response['attributes']['totalPages'] ?? [],
            'records' => $response['attributes']['totalRows'] ?? [],
            'rows' => $response['data'] ?? []
        ];

        return $data;
    }


    public function report(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');
        $detailParams = [
            'judul' => 'PT. TRANSPORINDO AGUNG SEJAHTERA',
            'judullaporan' => 'Laporan  Hutang Giro',
            'tanggal_cetak' => date('d-m-Y H:i:s'),
            'periode' => $request->periode,
        ];


        // dd($detailParams);
        $header = Http::withHeaders(request()->header())
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'laporanhutanggiro/report', $detailParams);
        $data = $header['data'];



        // $dataHeader = $header['dataheader'];
        $user = Auth::user();
        // dd($data);
        return view('reports.laporanhutanggiro', compact('data', 'user', 'detailParams'));
    }





    public function export(Request $request): void
    {
        $detailParams = [
            'judul' => 'PT. TRANSPORINDO AGUNG SEJAHTERA',
            'judullaporan' => 'Laporan  Hutang Giro',
            'tanggal_cetak' => date('d-m-Y H:i:s'),
            'periode' => $request->periode,

        ];

        $responses = Http::withHeaders($request->header())
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'laporanhutanggiro/export', $detailParams);

        $pengeluaran = $responses['data'];
        $user = Auth::user();
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', $pengeluaran[0]['judul']);
        $sheet->setCellValue('A2', $pengeluaran[0]['judulLaporan']);
        $sheet->setCellValue('A3', 'Periode: ' . $request->periode);

        // $sheet->getStyle("A1")->getFont()->setSize(20)->setBold(true);

        $sheet->getStyle("A1")->getFont()->setSize(16)->setBold(true);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal('center');
        $sheet->getStyle('A2')->getAlignment()->setHorizontal('left');
        $sheet->mergeCells('A1:F1');

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
                'label' => 'NO BUKTI',
                'index' => 'nobukti',
            ],
            [
                'label' => 'TANGGAL BUKTI',
                'index' => 'tglbukti',
            ],
            [
                'label' => 'KETERANGAN',
                'index' => 'keterangan',
            ],
            [
                'label' => 'NO WARKAT',
                'index' => 'nowarkat',
            ],
            [
                'label' => 'TGL JATUH TEMPO',
                'index' => 'tgljatuhtempo',
            ],
            [
                'label' => 'NOMINAL',
                'index' => 'nominal',
            ],

        ];


        foreach ($header_columns as $data_columns_index => $data_column) {
            $sheet->setCellValue($alphabets[$data_columns_index] . $header_start_row, $data_column['label'] ?? $data_columns_index + 1);
        }

        $lastColumn = $alphabets[$data_columns_index];
        $sheet->getStyle("A$header_start_row:$lastColumn$header_start_row")->applyFromArray($styleArray)->getFont()->setBold(true);
        $totalDebet = 0;
        if (is_array($pengeluaran) || is_iterable($pengeluaran)) {
            foreach ($pengeluaran as $response_index => $response_detail) {

                foreach ($header_columns as $detail_columns_index => $detail_column) {
                    $sheet->setCellValue($alphabets[$detail_columns_index] . $detail_start_row, isset($detail_column['index']) ? $response_detail[$detail_column['index']] : $response_index + 1);
                }

                $sheet->setCellValue("A$detail_start_row", $response_detail['nobukti']);
                $sheet->setCellValue("B$detail_start_row", date('d-m-Y', strtotime($response_detail['tglbukti'])));
                $sheet->setCellValue("C$detail_start_row", $response_detail['keterangan']);
                $sheet->setCellValue("D$detail_start_row", $response_detail['nowarkat']);
                $sheet->setCellValue("E$detail_start_row", date('d-m-Y', strtotime($response_detail['tgljatuhtempo'])));
                $sheet->setCellValue("F$detail_start_row", $response_detail['nominal']);

                $sheet->getStyle("C$detail_start_row")->getAlignment()->setWrapText(true);
                $sheet->getColumnDimension('C')->setWidth(100);

                $sheet->getStyle("A$detail_start_row:F$detail_start_row")->applyFromArray($styleArray);
                $sheet->getStyle("F$detail_start_row")->getNumberFormat()->setFormatCode("#,##0.00");
                $detail_start_row++;
            }
        }

        //total
        $total_start_row = $detail_start_row;
        $sheet->mergeCells('A' . $total_start_row . ':E' . $total_start_row);
        $sheet->setCellValue("A$total_start_row", 'Total')->getStyle('A' . $total_start_row . ':E' . $total_start_row)->applyFromArray($styleArray)->getFont()->setBold(true);

        $totalDebet = "=SUM(F6:F" . ($detail_start_row - 1) . ")";
        $sheet->setCellValue("F$total_start_row", $totalDebet)->getStyle("F$total_start_row")->applyFromArray($style_number);
        $sheet->setCellValue("F$total_start_row", $totalDebet)->getStyle("F$total_start_row")->getNumberFormat()->setFormatCode("#,##0.00");
        
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
        $sheet->getColumnDimension('E')->setAutoSize(true);
        $sheet->getColumnDimension('F')->setAutoSize(true);



        $writer = new Xlsx($spreadsheet);
        $filename = 'LAPORAN HUTANG GIRO' . date('dmYHis');
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }
}

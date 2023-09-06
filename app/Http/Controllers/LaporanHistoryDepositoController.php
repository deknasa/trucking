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

class LaporanHistoryDepositoController extends MyController
{
    public $title = 'Laporan History Deposito';

    public function index(Request $request)
    {
        $title = $this->title;
        $data = [
            'pagename' => 'Menu Utama Laporan History Deposito',
        ];

        return view('laporanhistorydeposito.index', compact('title'));
    }

    public function report(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');
        $detailParams = [
            'judul' => 'PT. TRANSPORINDO AGUNG SEJAHTERA',
            'judullaporan' => 'Laporan History Deposito',
            'tanggal_cetak' => date('d-m-Y H:i:s'),
            'supirdari_id' => $request->supirdari_id,
            'supirdari' => $request->supirdari,
        ];

        $header = Http::withHeaders(request()->header())
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'laporanhistorydeposito/report', $detailParams);

        $data = $header['data'];
        $user = Auth::user();
        // dd($data);
        return view('reports.laporanhistorydeposito', compact('data', 'user', 'detailParams'));
    }

    public function export(Request $request): void
    {
        $detailParams = [
            'judul' => 'PT. TRANSPORINDO AGUNG SEJAHTERA',
            'judullaporan' => 'Laporan History Deposito',
            'tanggal_cetak' => date('d-m-Y H:i:s'),
            'supirdari_id' => $request->supirdari_id,
            'supirdari' => $request->supirdari,

        ];

        $responses = Http::withHeaders($request->header())
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'laporanhistorydeposito/export', $detailParams);

        $pengeluaran = $responses['data'];

        $disetujui = $pengeluaran[0]['disetujui'] ?? '';
        $diperiksa = $pengeluaran[0]['diperiksa'] ?? '';
        $user = Auth::user();
        // dd($pengeluaran);
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', 'PT. TRANSPORINDO AGUNG SEJAHTERA');
        $sheet->setCellValue('A2', 'Laporan History Deposito');
        $sheet->setCellValue('A3', 'SUPIR: ' . $request->supirdari);

        // $sheet->getStyle("A1")->getFont()->setSize(20)->setBold(true);

        $sheet->getStyle('A1')->getAlignment()->setHorizontal('center');
        $sheet->getStyle('A2')->getAlignment()->setHorizontal('left');
        $sheet->mergeCells('A1:E1');
        $sheet->mergeCells('A2:E2');
        $sheet->mergeCells('A3:E3');
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
                'label' => 'NOMINAL',
                'index' => 'nominal',
            ],
            [
                'label' => 'SALDO',
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

                $sheet->setCellValue("A$detail_start_row", $response_detail['nobukti']);
                $sheet->setCellValue("B$detail_start_row", date('d-m-Y', strtotime($response_detail['tglbukti'])));
                $sheet->setCellValue("C$detail_start_row", $response_detail['keterangan']);
                $sheet->setCellValue("D$detail_start_row", $response_detail['nominal']);
                $sheet->setCellValue("E$detail_start_row", $response_detail['Saldo']);


                $sheet->getStyle("A$detail_start_row:E$detail_start_row")->applyFromArray($styleArray);
                $sheet->getStyle("C$detail_start_row:E$detail_start_row")->getNumberFormat()->setFormatCode("#,##0.00");
                // $sheet->getStyle("B$detail_start_row:B$detail_start_row")->getNumberFormat()->setFormatCode('dd-mm-yyyy');
                // $sheet->getStyle("D$detail_start_row:D$detail_start_row")->getNumberFormat()->setFormatCode('dd-mm-yyyy');


                //    $totalKredit += $response_detail['kredit'];
                //     $totalDebet += $response_detail['debet'];
                //     $totalSaldo += $response_detail['Saldo'];
                $detail_start_row++;
            }
        }


        //ukuran kolom
        $sheet->getColumnDimension('A')->setAutoSize(true);
        $sheet->getColumnDimension('B')->setAutoSize(true);
        $sheet->getColumnDimension('D')->setAutoSize(true);
        $sheet->getColumnDimension('E')->setAutoSize(true);
        $sheet->getColumnDimension('C')->setWidth(150);


        // menambahkan sel Total pada baris terakhir + 1
        // $sheet->setCellValue("A" . ($detail_start_row + 1), 'Total');
        // $sheet->setCellValue("D" . ($detail_start_row + 1), "=SUM(D5:D" . $detail_start_row . ")");
        // $sheet->setCellValue("E" . ($detail_start_row + 1), "=SUM(E5:E" . $detail_start_row . ")");


        //FORMAT
        // set format ribuan untuk kolom D dan E
        $sheet->getStyle("D" . ($detail_start_row + 1) . ":E" . ($detail_start_row + 1))->getNumberFormat()->setFormatCode("#,##0.00");
        $sheet->getStyle("A" . ($detail_start_row + 1) . ":$lastColumn" . ($detail_start_row + 1))->getFont()->setBold(true);


        // persetujuan
        $sheet->mergeCells('A' . ($detail_start_row + 3) . ':B' . ($detail_start_row + 3));
        $sheet->setCellValue('A' . ($detail_start_row + 3), 'Disetujui Oleh,');
        $sheet->mergeCells('C' . ($detail_start_row + 3) . ($detail_start_row + 3));
        $sheet->setCellValue('C' . ($detail_start_row + 3), 'Diperiksa Oleh');
        $sheet->mergeCells('D' . ($detail_start_row + 3) . ':E' . ($detail_start_row + 3));
        $sheet->setCellValue('D' . ($detail_start_row + 3), 'Disusun Oleh,');


        $sheet->mergeCells('A' . ($detail_start_row + 6) . ':B' . ($detail_start_row + 6));
        $sheet->setCellValue('A' . ($detail_start_row + 6), '( ' . $disetujui . ' )');
        $sheet->mergeCells('C' . ($detail_start_row + 6) . ($detail_start_row + 6));
        $sheet->setCellValue('C' . ($detail_start_row + 6), '( ' . $diperiksa . ' )');
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
        // $border_style = [
        //     'borders' => [
        //         'top' => ['borderStyle' => 'thin', 'color' => ['rgb' => '000000']],
        //         'bottom' => ['borderStyle' => 'thin', 'color' => ['rgb' => '000000']]
        //     ]
        // ];
        // $sheet->getStyle("A" . ($detail_start_row + 1) . ":$lastColumn" . ($detail_start_row + 1))->applyFromArray($border_style);


        $writer = new Xlsx($spreadsheet);
        $filename = 'EXPORTHISTORYDEPOSITO' . date('dmYHis');
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }
}

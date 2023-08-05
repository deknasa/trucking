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

class LaporanKartuHutangPerSupplierController extends MyController
{
    public $title = 'Laporan Kartu Hutang Per Supplier';

    public function index(Request $request)
    {
        $title = $this->title;
        $data = [
            'pagename' => 'Menu Utama Laporan Kartu Hutang Per Supplier',
        ];

        return view('laporankartuhutangpersupplier.index', compact('title'));
    }

    public function report(Request $request)
    {
        $detailParams = [
            'dari' => $request->dari,
            'sampai' => $request->sampai,
            'supplierdari' => $request->supplierdari,
            'suppliersampai' => $request->suppliersampai,
            'supplierdari_id' => $request->supplierdari_id,
            'suppliersampai_id' => $request->suppliersampai_id,

        ];
        $header = Http::withHeaders(request()->header())
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'laporankartuhutangpersupplier/report', $detailParams);

        $data = $header['data'];
        $user = Auth::user();
        // dd($data);
        return view('reports.laporankartuhutangpersupplier', compact('data', 'user', 'detailParams'));
    }

    public function export(Request $request): void
    {
        $detailParams = [
            'dari' => $request->dari,
            'sampai' => $request->sampai,
            'supplierdari' => $request->supplierdari,
            'suppliersampai' => $request->suppliersampai,
            'supplierdari_id' => $request->supplierdari_id,
            'suppliersampai_id' => $request->suppliersampai_id,

        ];

        $responses = Http::withHeaders($request->header())
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'laporankartuhutangpersupplier/export', $detailParams);

        $pengeluaran = $responses['data'];
        $user = Auth::user();
        // dd($pengeluaran);
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', 'PT. TRANSPORINDO AGUNG SEJAHTERA');
        $sheet->setCellValue('A2', 'Laporan Kartu Hutang Per Supplier');

        $sheet->getStyle("A1")->getFont()->setSize(16)->setBold(true);

        $sheet->getStyle('A1')->getAlignment()->setHorizontal('center');
        $sheet->getStyle('A2')->getAlignment()->setHorizontal('left');
        $sheet->setCellValue('A3', 'Periode: ' . $request->dari);
        $sheet->setCellValue('A4', 'Agen: ' . $request->supplierdari . ' S/D ' . $request->suppliersampai);
        $sheet->mergeCells('A1:J1');
        $sheet->mergeCells('A2:J2');
        $sheet->mergeCells('A3:J3');
        $sheet->mergeCells('A4:J4');

        $header_start_row = 6;
        $detail_start_row = 7;


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
                'label' => 'NO',
            ],
            [
                'label' => 'NO BUKTI',
                'index' => 'nobukti',
            ],
            [
                'label' => 'NAMA SUPPLIER',
                'index' => 'namasupplier',
            ],
            [
                'label' => 'TANGGAL',
                'index' => 'tglbukti',
            ],
            [
                'label' => 'TGL JATUH TEMPO',
                'index' => 'tgljatuhtempo',
            ],
            [
                'label' => 'CICILAN',
                'index' => 'cicil',
            ],
            [
                'label' => 'NOMINAL',
                'index' => 'nominal',
            ],
            [
                'label' => 'BAYAR',
                'index' => 'bayar',
            ],
            [
                'label' => 'SALDO',
                'index' => 'Saldo',
            ],
            [
                'label' => 'KETERANGAN',
                'index' => 'keterangan',
            ],

        ];


        foreach ($header_columns as $data_columns_index => $data_column) {
            $sheet->setCellValue($alphabets[$data_columns_index] . $header_start_row, $data_column['label'] ?? $data_columns_index + 1);
        }

        $lastColumn = $alphabets[$data_columns_index];

        $sheet->getStyle("A$header_start_row:$lastColumn$header_start_row")->getFont()->setBold(true);
        $sheet->getStyle("A$header_start_row:$lastColumn$header_start_row")->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

        $totalDebet = 0;
        $totalKredit = 0;
        $totalSaldo = 0;
        $no = 1;
        if (is_array($pengeluaran) || is_iterable($pengeluaran)) {
            foreach ($pengeluaran as $response_index => $response_detail) {

                foreach ($header_columns as $detail_columns_index => $detail_column) {
                    $sheet->setCellValue($alphabets[$detail_columns_index] . $detail_start_row, isset($detail_column['index']) ? $response_detail[$detail_column['index']] : $response_index + 1);
                }
                $sheet->setCellValue("A$detail_start_row", $no);
                $sheet->setCellValue("B$detail_start_row", $response_detail['nobukti']);
                $sheet->setCellValue("C$detail_start_row", $response_detail['namasupplier']);
                $sheet->setCellValue("D$detail_start_row", date('d-m-Y', strtotime($response_detail['tglbukti'])));
                $sheet->setCellValue("E$detail_start_row", date('d-m-Y', strtotime($response_detail['tgljatuhtempo'])));
                $sheet->setCellValue("F$detail_start_row", $response_detail['cicil']);
                $sheet->setCellValue("G$detail_start_row", $response_detail['nominal']);
                $sheet->setCellValue("H$detail_start_row", $response_detail['bayar']);
                $sheet->setCellValue("I$detail_start_row", $response_detail['Saldo']);
                $sheet->setCellValue("J$detail_start_row", $response_detail['keterangan']);

                $sheet->getStyle("A$detail_start_row:J$detail_start_row")->applyFromArray($styleArray);
                $sheet->getStyle("C$detail_start_row:J$detail_start_row")->getNumberFormat()->setFormatCode("#,##0.00");
                // $sheet->getStyle("B$detail_start_row:B$detail_start_row")->getNumberFormat()->setFormatCode('dd-mm-yyyy');
                // $sheet->getStyle("D$detail_start_row:D$detail_start_row")->getNumberFormat()->setFormatCode('dd-mm-yyyy');

                $sheet->getStyle("J$detail_start_row")->getAlignment()->setWrapText(true);
                $sheet->getColumnDimension('J')->setWidth(100);

                //    $totalKredit += $response_detail['kredit'];
                //     $totalDebet += $response_detail['debet'];
                //     $totalSaldo += $response_detail['Saldo'];
                $detail_start_row++;
                $no++;
            }
        }


        //ukuran kolom
        $sheet->getColumnDimension('A')->setAutoSize(true);
        $sheet->getColumnDimension('B')->setAutoSize(true);
        $sheet->getColumnDimension('C')->setAutoSize(true);
        $sheet->getColumnDimension('D')->setAutoSize(true);
        $sheet->getColumnDimension('E')->setAutoSize(true);
        $sheet->getColumnDimension('F')->setAutoSize(true);
        $sheet->getColumnDimension('G')->setAutoSize(true);
        $sheet->getColumnDimension('H')->setAutoSize(true);
        $sheet->getColumnDimension('I')->setAutoSize(true);


        $rowKosong = "";
        // menambahkan sel Total pada baris terakhir + 1

        $total_start_row = $detail_start_row;
        $sheet->mergeCells('A' . $total_start_row . ':F' . $total_start_row);
        $sheet->setCellValue("A$total_start_row", 'Total')->getStyle('A' . $total_start_row . ':F' . $total_start_row)->applyFromArray($styleArray)->getFont()->setBold(true);

        $totalNominal = "=SUM(G7:G" . ($detail_start_row - 1) . ")";
        $sheet->setCellValue("G$total_start_row", $totalNominal)->getStyle("G$total_start_row")->applyFromArray($style_number)->getFont()->setBold(true);
        $sheet->setCellValue("G$total_start_row", $totalNominal)->getStyle("G$total_start_row")->getNumberFormat()->setFormatCode("#,##0.00");
        $sheet->setCellValue("G$total_start_row", $totalNominal)->getStyle("G$total_start_row")->applyFromArray($styleArray);

        $totalBayar = "=SUM(H7:H" . ($detail_start_row - 1) . ")";
        $sheet->setCellValue("H$total_start_row", $totalBayar)->getStyle("H$total_start_row")->applyFromArray($style_number)->getFont()->setBold(true);
        $sheet->setCellValue("H$total_start_row", $totalBayar)->getStyle("H$total_start_row")->getNumberFormat()->setFormatCode("#,##0.00");
        $sheet->setCellValue("H$total_start_row", $totalBayar)->getStyle("H$total_start_row")->applyFromArray($styleArray);

        // $totalSaldo = "=SUM(I7:I" . ($detail_start_row - 1) . ")";
        // $sheet->setCellValue("I$total_start_row", $totalSaldo)->getStyle("I$total_start_row")->applyFromArray($style_number)->getFont()->setBold(true);
        // $sheet->setCellValue("I$total_start_row", $totalSaldo)->getStyle("I$total_start_row")->getNumberFormat()->setFormatCode("#,##0.00");
        // $sheet->setCellValue("I$total_start_row", $totalSaldo)->getStyle("I$total_start_row")->applyFromArray($styleArray);

        $sheet->setCellValue("I$total_start_row", $rowKosong)->getStyle("I$total_start_row")->applyFromArray($styleArray);
        $sheet->setCellValue("J$total_start_row", $rowKosong)->getStyle("J$total_start_row")->applyFromArray($styleArray);
      


        //FORMAT
        // set format ribuan untuk kolom D dan E
        $sheet->getStyle("D" . ($detail_start_row + 1) . ":E" . ($detail_start_row + 1))->getNumberFormat()->setFormatCode("#,##0.00");
        $sheet->getStyle("A" . ($detail_start_row + 1) . ":$lastColumn" . ($detail_start_row + 1))->getFont()->setBold(true);


        //persetujuan
        // $sheet->mergeCells('A' . ($detail_start_row + 3) . ':B' . ($detail_start_row + 3));
        // $sheet->setCellValue('A' . ($detail_start_row + 3), 'Disetujui Oleh,');
        // $sheet->mergeCells('C' . ($detail_start_row + 3). ($detail_start_row + 3));
        // $sheet->setCellValue('C' . ($detail_start_row + 3), 'Diperiksa Oleh');
        // $sheet->mergeCells('D' . ($detail_start_row + 3) . ':E' . ($detail_start_row + 3));
        // $sheet->setCellValue('D' . ($detail_start_row + 3), 'Disusun Oleh,');


        // $sheet->mergeCells('A' . ($detail_start_row + 6) . ':B' . ($detail_start_row + 6));
        // $sheet->setCellValue('A' . ($detail_start_row + 6), '( Bpk. Hasan )');
        // $sheet->mergeCells('C' . ($detail_start_row + 6) . ($detail_start_row + 6));
        // $sheet->setCellValue('C' . ($detail_start_row + 6), '( RINA )');
        // $sheet->mergeCells('D' . ($detail_start_row + 6) . ':E' . ($detail_start_row + 6));
        // $sheet->setCellValue('D' . ($detail_start_row + 6), '(                                          )');


        // style persetujuan
        // $sheet->getStyle('A' . ($detail_start_row + 3))->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        // $sheet->getStyle('A' . ($detail_start_row + 3))->getFont()->setSize(12);
        // $sheet->getStyle('C' . ($detail_start_row + 3))->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        // $sheet->getStyle('C' . ($detail_start_row + 3))->getFont()->setSize(12);
        // $sheet->getStyle('D' . ($detail_start_row + 3))->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        // $sheet->getStyle('D' . ($detail_start_row + 3))->getFont()->setSize(12);


        // $sheet->getStyle('A' . ($detail_start_row + 6))->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        // $sheet->getStyle('A' . ($detail_start_row + 6))->getFont()->setSize(12);
        // $sheet->getStyle('C' . ($detail_start_row + 6))->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        // $sheet->getStyle('C' . ($detail_start_row + 6))->getFont()->setSize(12);
        // $sheet->getStyle('D' . ($detail_start_row + 6))->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        // $sheet->getStyle('D' . ($detail_start_row + 6))->getFont()->setSize(12);

        // mengatur border top dan bottom pada cell Total
        // $border_style = [
        //     'borders' => [
        //         'top' => ['borderStyle' => 'thin', 'color' => ['rgb' => '000000']],
        //         'bottom' => ['borderStyle' => 'thin', 'color' => ['rgb' => '000000']]
        //     ]
        // ];
        // $sheet->getStyle("A" . ($detail_start_row + 1) . ":$lastColumn" . ($detail_start_row + 1))->applyFromArray($border_style);

        $ttd_start_row = $detail_start_row + 2;
        $sheet->setCellValue("B$ttd_start_row", 'Disetujui Oleh,');
        $sheet->setCellValue("D$ttd_start_row", 'Diperiksa Oleh,');
        $sheet->setCellValue("F$ttd_start_row", 'Disusun Oleh,');

        $sheet->setCellValue("B" . ($ttd_start_row + 3), '( Bpk. Hasan )');
        $sheet->setCellValue("D" . ($ttd_start_row + 3), '( Rina )');
        $sheet->setCellValue("F" . ($ttd_start_row + 3), '(                )');

        $writer = new Xlsx($spreadsheet);
        $filename = 'LAPORAN KARTU HUTANG PER SUPPLIER' . date('dmYHis');
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }
}

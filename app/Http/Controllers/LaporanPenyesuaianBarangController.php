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

        $header_start_row = 4;
        $detail_start_row = $header_start_row + 1;

        $alphabets = range('A', 'Z');

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
                'label' => 'Tanggal Bukti',
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

        $styleArray = array(
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
            ],
        );

        $styleArray2 = [
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
            ],
            'borders' => [
                'top' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
                'right' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
                'bottom' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
                'left' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN]
            ]
        ];

        $styleArray3 = [
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER
            ],
            'font' => [
                'bold' => true,
            ],
        ];

        $style_number = [
            'font' => [
                'bold' => true,
            ],
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


        // set header
        foreach ($header_columns as $data_columns_index => $data_column) {
            $sheet->setCellValue($alphabets[$data_columns_index] . $header_start_row, $data_column['label']);
        }

        // group data by Keterangan
        $data_by_keterangan = [];
        foreach ($data as $row_index => $row_data) {
            $keterangan = $row_data['keterangan'];
            if (!isset($data_by_keterangan[$keterangan])) {
                $data_by_keterangan[$keterangan] = [];
            }
            $data_by_keterangan[$keterangan][] = $row_data;
        }

        // Set detail grouped by Keterangan
        foreach ($data_by_keterangan as $keterangan => $rows) {
            $sheet->setCellValue('A' . $detail_start_row, $keterangan);
            foreach ($header_columns as $data_columns_index => $data_column) {
                foreach ($rows as $row_index => $row_data) {
                    $sheet->setCellValue($alphabets[$data_columns_index] . ($detail_start_row + $row_index + 1), $row_data[$data_column['index']]);
                }
            }
            $detail_start_row += count($rows) + 2;
        }

        //total
        $total_start_row = $detail_start_row;
        $sheet->mergeCells('A' . $total_start_row . ':I' . $total_start_row);
        $sheet->setCellValue("A$total_start_row", 'Total :')->getStyle('A' . $total_start_row . ':J' . $total_start_row)->applyFromArray($styleArray2)->getFont()->setBold(true);

        $totalnomdeposito = "=SUM(J6:J" . ($detail_start_row-2) . ")";
        $sheet->setCellValue("J$total_start_row", $totalnomdeposito)->getStyle("J$total_start_row")->applyFromArray($style_number);

        //format currency
        $currency_columns = ['I', 'J'];
        foreach ($currency_columns as $column) {
            $column_start = $header_start_row + 1;
            $column_end = $detail_start_row - 1;
            for ($i = $column_start; $i <= $column_end; $i++) {
                $cell = $column . $i;
                $sheet->getStyle($cell)->getNumberFormat()->setFormatCode("#,##0.00");
            }
        }
        $currency_columns = ['C'];
        foreach ($currency_columns as $column) {
            $column_start = $header_start_row + 1;
            $column_end = $detail_start_row - 1;
            for ($i = $column_start; $i <= $column_end; $i++) {
                $cell = $column . $i;
                $sheet->getStyle($cell)->getNumberFormat()->setFormatCode('dd-mm-yyyy');
            }
        }
        $sheet->getStyle("I$total_start_row")->getNumberFormat()->setFormatCode("#,##0.00");
        $sheet->getStyle("J$total_start_row")->getNumberFormat()->setFormatCode("#,##0.00");

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

        $sheet->getStyle("A4")->applyFromArray($styleArray3);
        $sheet->getStyle("B4")->applyFromArray($styleArray3);
        $sheet->getStyle("C4")->applyFromArray($styleArray3);
        $sheet->getStyle("D4")->applyFromArray($styleArray3);
        $sheet->getStyle("E4")->applyFromArray($styleArray3);
        $sheet->getStyle("F4")->applyFromArray($styleArray3);
        $sheet->getStyle("G4")->applyFromArray($styleArray3);
        $sheet->getStyle("H4")->applyFromArray($styleArray3);
        $sheet->getStyle("I4")->applyFromArray($styleArray3);
        $sheet->getStyle("J4")->applyFromArray($styleArray3);
        $sheet->getStyle("A")->applyFromArray($styleArray);
        $sheet->getStyle("E")->applyFromArray($styleArray);


        $writer = new Xlsx($spreadsheet);
        $filename = 'LAPORAN PENYESUAIAN BARANG' . date('dmYHis');
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }
}



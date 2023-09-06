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


class LaporanDepositoSupirController extends MyController
{
    public $title = 'Laporan Deposito Supir';

    public function index(Request $request)
    {
        $title = $this->title;
        $data = [
            'pagename' => 'Menu Utama Laporan Deposito Supir',
        ];

        return view('laporandepositosupir.index', compact('title'));
    }

    public function report(Request $request)
    {
        $detailParams = [
            'sampai' => $request->sampai,
        ];

        $header = Http::withHeaders(request()->header())
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'laporandepositosupir/report', $detailParams);

        $data = $header['data'];
        $user = Auth::user();
        return view('reports.laporandepositosupir', compact('data', 'user', 'detailParams'));
    }

    public function export(Request $request): void
    {
        $detailParams = [
            'sampai' => $request->sampai,
        ];

        $header = Http::withHeaders(request()->header())
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'laporandepositosupir/export', $detailParams);

        $data = $header['data'];

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        
        $sheet->setCellValue('A1', 'PT. TRANSPORINDO AGUNG SEJAHTERA');
        $sheet->setCellValue('A2', 'Laporan Deposito Supir');
        $sheet->setCellValue('A3', 'Periode: ' . $request->sampai);
        $sheet->getStyle("A1")->getFont()->setSize(16)->setBold(true);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal('center');
        $sheet->mergeCells('A1:G1');

        $header_start_row = 5;
        $detail_start_row = $header_start_row + 1;

        $alphabets = range('A', 'Z');

        $header_columns = [
            [
                'label' => 'Deposito Ke',
                'index' => 'cicil',
            ],
            [
                'label' => 'Supir',
                'index' => 'namasupir',
            ],
            [
                'label' => 'Keterangan',
                'index' => 'keterangandeposito',
            ],
            [
                'label' => 'Nominal',
                'index' => 'saldo',
            ],
            [
                'label' => 'Nominal Deposito',
                'index' => 'deposito',
            ],
            [
                'label' => 'Penarikan',
                'index' => 'penarikan',
            ],
            [
                'label' => 'Total',
                'index' => 'total',
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
        
        //format decimal
        $sheet->getStyle("A6:A$detail_start_row")->applyFromArray($styleArray)->getNumberFormat()->setFormatCode("0.0");
        
        //total
        $total_start_row = $detail_start_row;
        $sheet->mergeCells('A' . $total_start_row . ':D' . $total_start_row);
        $sheet->setCellValue("A$total_start_row", 'Total')->getStyle('A' . $total_start_row . ':F' . $total_start_row)->applyFromArray($styleArray2)->getFont()->setBold(true);
        
        $totalnomdeposito = "=SUM(E6:E" . ($detail_start_row-2) . ")";
        $sheet->setCellValue("E$total_start_row", $totalnomdeposito)->getStyle("E$total_start_row")->applyFromArray($style_number);

        $totalpenarikan = "=SUM(F6:F" . ($detail_start_row-2) . ")";
        $sheet->setCellValue("F$total_start_row", $totalpenarikan)->getStyle("F$total_start_row")->applyFromArray($style_number);

        $total = "=SUM(G6:G" . ($detail_start_row-2) . ")";
        $sheet->setCellValue("G$total_start_row", $total)->getStyle("G$total_start_row")->applyFromArray($style_number);
        
        //format currency
        $currency_columns = ['D', 'E', 'F', 'G'];
        foreach ($currency_columns as $column) {
            $column_start = $header_start_row + 1;
            $column_end = $detail_start_row - 1;
            for ($i = $column_start; $i <= $column_end; $i++) {
                $cell = $column . $i;
                $sheet->getStyle($cell)->getNumberFormat()->setFormatCode("#,##0.00");
            }
        }
        $sheet->getStyle("E$total_start_row")->getNumberFormat()->setFormatCode("#,##0.00");
        $sheet->getStyle("F$total_start_row")->getNumberFormat()->setFormatCode("#,##0.00");
        $sheet->getStyle("G$total_start_row")->getNumberFormat()->setFormatCode("#,##0.00");

        // set diketahui dibuat
        $ttd_start_row = $total_start_row + 2;
        $sheet->setCellValue("B$ttd_start_row", 'Disetujui');
        $sheet->setCellValue("C$ttd_start_row", 'Diketahui');
        $sheet->setCellValue("D$ttd_start_row", 'Dibuat');
        $sheet->getStyle("B$ttd_start_row:D$ttd_start_row")->applyFromArray($styleArray);

        $sheet->mergeCells("B" . ($ttd_start_row + 1) . ":B" . ($ttd_start_row + 3));
        $sheet->mergeCells("C" . ($ttd_start_row + 1) . ":C" . ($ttd_start_row + 3));
        $sheet->mergeCells("D" . ($ttd_start_row + 1) . ":D" . ($ttd_start_row + 3));
        $sheet->getStyle("B" . ($ttd_start_row + 1) . ":B" . ($ttd_start_row + 3))->applyFromArray($styleArray);
        $sheet->getStyle("C" . ($ttd_start_row + 1) . ":C" . ($ttd_start_row + 3))->applyFromArray($styleArray);
        $sheet->getStyle("D" . ($ttd_start_row + 1) . ":D" . ($ttd_start_row + 3))->applyFromArray($styleArray);


        //style header
        $sheet->getColumnDimension('A')->setAutoSize(true);
        $sheet->getColumnDimension('B')->setAutoSize(true);
        $sheet->getColumnDimension('D')->setAutoSize(true);
        $sheet->getColumnDimension('E')->setAutoSize(true);
        $sheet->getColumnDimension('F')->setAutoSize(true);
        $sheet->getColumnDimension('G')->setAutoSize(true);
        $sheet->getColumnDimension('C')->setWidth(150);        

        $sheet->getStyle("A4")->applyFromArray($styleArray3);
        $sheet->getStyle("B4")->applyFromArray($styleArray3);
        $sheet->getStyle("C4")->applyFromArray($styleArray3);
        $sheet->getStyle("D4")->applyFromArray($styleArray3);
        $sheet->getStyle("E4")->applyFromArray($styleArray3);
        $sheet->getStyle("F4")->applyFromArray($styleArray3);
        $sheet->getStyle("G4")->applyFromArray($styleArray3);

        $writer = new Xlsx($spreadsheet);
        $filename = 'LAPORANDEPOSITO' . date('dmYHis');
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }
}

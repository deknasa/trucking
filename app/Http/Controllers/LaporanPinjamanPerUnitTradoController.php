<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class LaporanPinjamanPerUnitTradoController extends Controller
{
    public $title = 'Laporan Pinjaman Per Unit Trado';

    public function index(Request $request)
    {
        $title = $this->title;
        $data = [
            'pagename' => 'Menu Utama Laporan Pinjaman Per Unit Trado',
        ];

        return view('laporanpinjamanperunittrado.index', compact('title'));
    }

    public function report(Request $request)
    {
        $detailParams = [
            'trado_id' => $request->trado_id,
            'trado' => $request->trado,
        ];

        $header = Http::withHeaders(request()->header())
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'laporanpinjamanperunittrado/report', $detailParams);

        $data = $header['data'];
        $user = Auth::user();
        return view('reports.laporanpinjamanperunittrado', compact('data', 'user', 'detailParams'));
    }

    public function export(Request $request): void
    {
        $detailParams = [
            'trado_id' => $request->trado_id,
            'trado' => $request->trado,
        ];

        $header = Http::withHeaders(request()->header())
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'laporanpinjamanperunittrado/export', $detailParams);

        $data = $header['data'];
        
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', $data[0]['judul']);
        $sheet->getStyle("A1")->getFont()->setSize(20);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal('center');
        $sheet->mergeCells('A1:D1');

        $sheet->setCellValue('A2', $data[0]['judulLaporan']);
        $sheet->getStyle("A2")->getFont()->setSize(16);
        $sheet->getStyle('A2')->getAlignment()->setHorizontal('center');
        $sheet->mergeCells('A2:D2');

        $sheet->setCellValue('A4', 'Trado');
        $sheet->setCellValue('B4', ': ' . $detailParams['trado']);

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

            // 'borders' => [
            //     'top' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
            //     'right' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
            //     'bottom' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
            //     'left' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN]
            // ]
        ];


        $alphabets = range('A', 'Z');


        $currentRow = 5;
        $currentSupir = '';
        $totalNominal = 0;

        foreach ($data as $item) {
            if ($item['namasupir'] !== $currentSupir) {
                if ($currentSupir !== '') {
                    $currentRow++;
                    $sheet->mergeCells('A' . ($currentRow-1) . ':C' . ($currentRow-1));
                    $sheet->setCellValue('A' . ($currentRow-1), 'Total Pinjaman '.$currentSupir);
                    $sheet->setCellValue('D' . ($currentRow-1), $totalNominal);
                    $sheet->getStyle('A' . ($currentRow-1) . ':D' . ($currentRow-1))->applyFromArray($styleArray)->getFont()->setBold(true);
                    $sheet->getStyle('D' . ($currentRow-1))->applyFromArray($style_number)->getFont()->setBold(true);
                    $sheet->getStyle('A' . ($currentRow-1) . ':D' . ($currentRow-1))->getNumberFormat()->setFormatCode("#,##0.00");
                }

                $currentSupir = $item['namasupir'];
                $totalNominal = 0;

                $currentRow++;
                $sheet->setCellValue('A' . $currentRow, $currentSupir);
                $sheet->getStyle('A' . $currentRow)->getFont()->setBold(true);
                $currentRow++;
                $sheet->setCellValue('A' . $currentRow, 'No Bukti');
                $sheet->setCellValue('B' . $currentRow, 'Tanggal');
                $sheet->setCellValue('C' . $currentRow, 'Keterangan');
                $sheet->setCellValue('D' . $currentRow, 'Saldo');
                $headerStyle = $sheet->getStyle('A' . $currentRow . ':D' . $currentRow)->applyFromArray($styleArray);
                $headerStyle->getFont()->setBold(true);
                $headerStyle->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $currentRow++;
            }

            $sheet->setCellValue('A' . $currentRow, $item['pengeluarantrucking_nobukti']);
            $sheet->setCellValue('B' . $currentRow, date('d-m-Y', strtotime($item['tglbukti'])));
            $sheet->setCellValue('C' . $currentRow, $item['keterangan']);
            $sheet->setCellValue('D' . $currentRow, $item['nominal']);
            $sheet->getStyle("D$currentRow")->applyFromArray($style_number)->getNumberFormat()->setFormatCode("#,##0.00");
            $sheet->getStyle("C$currentRow")->getAlignment()->setWrapText(true);
            $sheet->getColumnDimension('C')->setWidth(160);
            $totalNominal += $item['nominal'];
            $currentRow++;
        }
        $sheet->mergeCells('A' . $currentRow . ':C' . $currentRow);
        $sheet->setCellValue('A' . $currentRow, 'Total Pinjaman '.$currentSupir);
        $sheet->setCellValue('D' . $currentRow, $totalNominal);        
        $sheet->getStyle('A' . $currentRow . ':D' . $currentRow)->applyFromArray($styleArray)->getFont()->setBold(true);
        $sheet->getStyle('D' . $currentRow)->applyFromArray($style_number)->getFont()->setBold(true);
        $sheet->getStyle('A' . $currentRow . ':D' . $currentRow)->getNumberFormat()->setFormatCode("#,##0.00");
        $sheet->getColumnDimension('A')->setAutoSize(true);
        $sheet->getColumnDimension('B')->setAutoSize(true);
        $sheet->getColumnDimension('C')->setAutoSize(true);
        $sheet->getColumnDimension('D')->setAutoSize(true);

        $writer = new Xlsx($spreadsheet);
        $filename = 'LaporanPinjamanPerUnitTrado' . date('dmYHis');
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }
}
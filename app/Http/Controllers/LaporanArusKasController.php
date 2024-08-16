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
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;


class LaporanArusKasController extends MyController
{
    public $title = 'Laporan Arus Kas / Bank';

    public function index(Request $request)
    {
        $title = $this->title;
        $data = [
            'pagename' => 'Menu Utama Laporan Arus Kas / Bank',
        ];
        return view('laporanaruskas.index', compact('title'));
    }

    public function report(Request $request)
    {
        $detailParams = [
            'periode' => $request->periode,
        ];

        $header = Http::withHeaders(request()->header())
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'laporanaruskas/report', $detailParams);

        $data = $header['data'];
        $saldo = $header['saldo'];
        $user = Auth::user();
        return view('reports.laporanaruskas', compact('data', 'saldo', 'user', 'detailParams'));
    }

    public function export(Request $request): void
    {
        $detailParams = [
            'periode' => $request->periode,
        ];
        $header = Http::withHeaders(request()->header())
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'laporanaruskas/export', $detailParams);

        $data = $header['data'];
        $saldo = $header['saldo'];

        if (count($data) == 0) {
            throw new \Exception('TIDAK ADA DATA');
        }

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', $data[0]['judul']);
        $sheet->setCellValue('A2', $data[0]['judulLaporan']);

        $sheet->getStyle("A1")->getFont()->setSize(16)->setBold(true);
        $sheet->getStyle("A2")->getFont()->setBold(true);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal('center');
        $sheet->mergeCells('A1:C1');
        $styleArray = array(
            'borders' => array(
                'allBorders' => array(
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ),
            ),
        );
        $styleArray2 = array(
            'borders' => array(
                'left' => array(
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ),
                'right' => array(
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
        $sheet->setCellValue('A4', 'TRUCKING')->getStyle("A4")->applyFromArray($styleArray)->getFont()->setBold(true);
        $sheet->getStyle("A4:C4")->applyFromArray($styleArray)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->setCellValue('B4', $data[0]['periodeawal'])->getStyle("B4")->applyFromArray($styleArray)->getFont()->setBold(true);
        $sheet->setCellValue('C4', $data[0]['periodeakhir'])->getStyle("C4")->applyFromArray($styleArray)->getFont()->setBold(true);

        if (is_array($data)) {

            foreach ($data as $row) {
                $jenisarus = $row['jenisarus'];
                $type = $row['type'];
                $groupedData[$jenisarus][$type][] = $row;
            }
        }

        $detail_start_row = 5;
        if (is_array($data) || is_iterable($data)) {
            $startSelisihAwal = '';
            $endSelisihAwal = '';
            $startSelisihAkhir = '';
            $endSelisihAkhir = '';
            $startSaldoAwal = '';
            $startSaldoAkhir = '';

            foreach ($groupedData as $jenisarus => $group) {
                $sheet->setCellValue("A$detail_start_row", $jenisarus)->getStyle("A$detail_start_row")->getFont()->setBold(true);
                $sheet->getStyle("A$detail_start_row")->applyFromArray($styleArray2)->getFont()->setUnderline(true);
                $sheet->getStyle("B$detail_start_row")->applyFromArray($styleArray2);
                $sheet->getStyle("C$detail_start_row")->applyFromArray($styleArray2);
                $detail_start_row++;
                if ($jenisarus == 'ARUS KAS/BANK MASUK') {
                    $sheet->setCellValue("A$detail_start_row", 'SALDO AWAL')->getStyle("A$detail_start_row")->getFont()->setBold(true);
                }
                $sheet->getStyle("A$detail_start_row")->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                $sheet->setCellValue("B$detail_start_row", $saldo['nominalawal'])->getStyle("B$detail_start_row")->getFont()->setBold(true);
                $sheet->getStyle("B$detail_start_row")->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                $sheet->setCellValue("C$detail_start_row", $saldo['nominalakhir'])->getStyle("C$detail_start_row")->getFont()->setBold(true);
                $sheet->getStyle("B$detail_start_row:C$detail_start_row")->getNumberFormat()->setFormatCode("#,##0.00_);(#,##0.00)");
                $sheet->getStyle("C$detail_start_row")->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                if ($startSaldoAwal == '') {
                    $startSaldoAwal = "B$detail_start_row";
                }
                if ($startSaldoAkhir == '') {
                    $startSaldoAkhir = "C$detail_start_row";
                }
                $detail_start_row++;

                foreach ($group as $type => $row) {
                    $sheet->setCellValue("A$detail_start_row", '* ' . $type)->getStyle("A$detail_start_row")->getFont()->setBold(true);

                    $sheet->getStyle("A$detail_start_row")->applyFromArray($styleArray2);
                    $sheet->getStyle("B$detail_start_row")->applyFromArray($styleArray2);
                    $sheet->getStyle("C$detail_start_row")->applyFromArray($styleArray2);
                    $detail_start_row++;

                    $awalCell = 'B' . ($detail_start_row);
                    $akhirCell = 'C' . ($detail_start_row);
                    foreach ($row as $response_detail) {
                        $sheet->setCellValue("A$detail_start_row", $response_detail['keterangancoa'])->getStyle("A$detail_start_row")->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                        $sheet->setCellValue("B$detail_start_row", $response_detail['nominalawal'])->getStyle("B$detail_start_row")->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                        $sheet->setCellValue("C$detail_start_row", $response_detail['nominalakhir'])->getStyle("C$detail_start_row")->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                        // $sheet->getStyle("A$detail_start_row")->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

                        $sheet->getStyle("B$detail_start_row:C$detail_start_row")->getNumberFormat()->setFormatCode("#,##0.00_);(#,##0.00)");
                        $detail_start_row++;
                    }
                }
                $sheet->setCellValue("A$detail_start_row", "TOTAL $jenisarus")->getStyle("A$detail_start_row")->getFont()->setBold(true);
                $sheet->setCellValue("B$detail_start_row", "=SUM($awalCell:B$detail_start_row)")->getStyle("B$detail_start_row")->getFont()->setBold(true);
                $sheet->setCellValue("C$detail_start_row", "=SUM($akhirCell:C$detail_start_row)")->getStyle("C$detail_start_row")->getFont()->setBold(true);
                $sheet->getStyle("B$detail_start_row:C$detail_start_row")->getNumberFormat()->setFormatCode("#,##0.00_);(#,##0.00)");
                $sheet->getStyle("A$detail_start_row:C$detail_start_row")->applyFromArray($styleArray);
                if ($startSelisihAwal == '') {
                    $startSelisihAwal = "B$detail_start_row";
                } else {
                    $endSelisihAwal = "B$detail_start_row";
                }
                if ($startSelisihAkhir == '') {
                    $startSelisihAkhir = "C$detail_start_row";
                } else {
                    $endSelisihAkhir = "C$detail_start_row";
                }
                $detail_start_row++;
            }

            $rowSelisisih = $detail_start_row;
            $sheet->setCellValue("A$detail_start_row", "SELISIH ARUS KAS/BANK MASUK DAN KELUAR")->getStyle("A$detail_start_row")->getFont()->setBold(true);
            $sheet->setCellValue("B$detail_start_row", "=$startSelisihAwal+$endSelisihAwal")->getStyle("A$detail_start_row")->getFont()->setBold(true);
            $sheet->setCellValue("C$detail_start_row", "=$startSelisihAkhir+$endSelisihAkhir")->getStyle("A$detail_start_row")->getFont()->setBold(true);
            $sheet->getStyle("B$detail_start_row:C$detail_start_row")->getNumberFormat()->setFormatCode("#,##0.00_);(#,##0.00)");
            $sheet->getStyle("A$detail_start_row:C$detail_start_row")->applyFromArray($styleArray);
            $detail_start_row++;
            
            $sheet->setCellValue("A$detail_start_row", "SISA SALDO KAS/BANK")->getStyle("A$detail_start_row")->getFont()->setBold(true);
            $sheet->setCellValue("B$detail_start_row", "=$startSaldoAwal+B$rowSelisisih")->getStyle("A$detail_start_row")->getFont()->setBold(true);
            $sheet->setCellValue("C$detail_start_row", "=$startSaldoAkhir+C$rowSelisisih")->getStyle("A$detail_start_row")->getFont()->setBold(true);
            $sheet->getStyle("B$detail_start_row:C$detail_start_row")->getNumberFormat()->setFormatCode("#,##0.00_);(#,##0.00)");
            $sheet->getStyle("A$detail_start_row:C$detail_start_row")->applyFromArray($styleArray);
        }

        $sheet->getColumnDimension('B')->setAutoSize(true);
        $sheet->getColumnDimension('C')->setAutoSize(true);
        $sheet->getColumnDimension('A')->setAutoSize(true);
        $writer = new Xlsx($spreadsheet);
        $filename = 'LAPORAN ARUS KAS' . date('dmYHis');
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }
}

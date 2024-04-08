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


class LaporanRitasiGandenganController extends MyController
{
    public $title = 'Export Laporan Ritasi Gandengan';

    public function index(Request $request)
    {
        $title = $this->title;
        $data = [
            'pagename' => 'Menu Utama Export Laporan Ritasi Gandengan',
        ];

        return view('laporanritasigandengan.index', compact('title'));
    }

    public function export(Request $request): void
    {
        $detailParams = [
            'periode' => $request->periode,
        ];

        $header = Http::withHeaders(request()->header())
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'laporanritasigandengan/export', $detailParams);

        $ritasi = $header['data'];
        if(count($ritasi) == 0){
            throw new \Exception('TIDAK ADA DATA');
        }
        // echo json_encode($data);
        // die;
        // dd($ritasi);
        date_default_timezone_set("Asia/Jakarta");
        
        $namacabang = $header['namacabang'];

        $monthNum  = intval(substr($request->periode, 0, 2));
        $yearNum  = substr($request->periode, 3);
        $monthName = $this->getBulan($monthNum);

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        // $sheet->setCellValue('A1', 'Laporan Ritasi Gandengan : ' . $monthName . ' - ' . $yearNum);
        $sheet->setCellValue('A1', $header['judul'] ?? '');
        $sheet->setCellValue('A2', $namacabang ?? '');
        $sheet->setCellValue('A3','LAPORAN RITASI GANDENGAN');
        $sheet->setCellValue('A4', 'PERIODE : ' . $monthName . ' - ' . $yearNum);
        $sheet->getStyle("A1")->getFont()->setSize(16)->setBold(true);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal('center');
        $sheet->getStyle("A2")->getFont()->setSize(16)->setBold(true);
        $sheet->getStyle('A2')->getAlignment()->setHorizontal('center');
        $sheet->getStyle("A3")->getFont()->setBold(true);        
        $sheet->getStyle("A4")->getFont()->setBold(true);

        $sheet->mergeCells('A1:AG1');
        $sheet->mergeCells('A2:AG2');
        $totalTanggal = count($ritasi[0]) - 1;

        // SET DATA
        $rowIndex = 7;
        $columnIndex = 1;
        foreach ($ritasi as $data) {
            $noPol = $data['gandengan']; // Ganti 'no_pol' dengan indeks yang sesuai
            $sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $noPol);
            // Initialize total variable for each row
            $totalForRow = 0;

            // Iterate over the date fields
            for ($i = 1; $i <= $totalTanggal; $i++) {
                $tgl = $data[$i];
                $sheet->setCellValueByColumnAndRow($columnIndex + $i, $rowIndex, $tgl);
               
                if(is_numeric($tgl)){
                    $totalForRow += $tgl;
                }else{
                    $sheet->getStyleByColumnAndRow($columnIndex + $i, $rowIndex)->getFont()->setColor(new \PhpOffice\PhpSpreadsheet\Style\Color(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_RED));
                }
            }

            $lastColumn = $columnIndex + ($totalTanggal+1);
            $sheet->setCellValueByColumnAndRow($lastColumn, $rowIndex, $totalForRow);
        
            $rowIndex++;
        }


        // SET HEADER
        $columnIndexHeader = 2;
        $sheet->setCellValue('A6', 'Gandengan');
        for ($i = 1; $i <= $totalTanggal; $i++) {
            $cell = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($columnIndexHeader) . '6';
            $sheet->setCellValue($cell, $i);
            $columnIndexHeader++;
        }

        $cell = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($columnIndexHeader) . '6';
        $sheet->setCellValue($cell, 'Total');
        $cellRange = "A6:$cell";

        $cell = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($columnIndexHeader) . $rowIndex;
        $cellFooter = "A" . $rowIndex . ":$cell";

        $styleArray = [
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'color' => [
                    'rgb' => 'FFFF00', // Warna kuning (kode RGB)
                ],
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['rgb' => '000000'], // Warna border (kode RGB)
                ],
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
            ],
        ];


        $styleBody = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['rgb' => '000000'], // Warna border (kode RGB)
                ],
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
            ],
        ];

        $sheet->getStyle($cellRange)->applyFromArray($styleArray);
        $sheet->getStyle($cellFooter)->applyFromArray($styleArray);


        for ($columnIndex = 1; $columnIndex <= $columnIndexHeader; $columnIndex++) {
            $columnLabel = $this->alphabetLoop($columnIndex);
            $sheet->getColumnDimension($columnLabel)->setAutoSize(true);

            if ($columnLabel != 'A') {

                $cellBody = $columnLabel . "7:" . $columnLabel . $rowIndex;
                $sheet->getStyle($cellBody)->applyFromArray($styleBody);
            }
        }

        //NOTE GRAND TOTAL
        $sheet->setCellValue("A" . ($rowIndex), 'Grand Total');
        for ($columnIndex = 1; $columnIndex <= $columnIndexHeader; $columnIndex++) {
            $columnLabel = $this->alphabetLoop($columnIndex);
            if ($columnLabel != 'A') {

                $cellBody = $columnLabel . "7:" . $columnLabel . $rowIndex;
                $sheet->setCellValue($columnLabel . ($rowIndex), "=SUM(" . $columnLabel . "7:" . $columnLabel . $rowIndex . ")");
            }
        }

        $writer = new Xlsx($spreadsheet);
        $filename = 'LAPORAN RITASI GANDENGAN ' . date('dmYHis');
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }

    public function alphabetLoop($num)
    {
        $alphabet = range('A', 'Z');
        $loop = [];

        while ($num > 0) {
            $remainder = ($num - 1) % 26;
            array_unshift($loop, $alphabet[$remainder]);
            $num = (int)(($num - $remainder) / 26);
        }

        return implode('', $loop);
    }

    public function getBulan($bln)
    {
        switch ($bln) {
            case 1:
                return "JANUARI";
                break;
            case 2:
                return "FEBRUARI";
                break;
            case 3:
                return "MARET";
                break;
            case 4:
                return "APRIL";
                break;
            case 5:
                return "MEI";
                break;
            case 6:
                return "JUNI";
                break;
            case 7:
                return "JULI";
                break;
            case 8:
                return "AGUSTUS";
                break;
            case 9:
                return "SEPTEMBER";
                break;
            case 10:
                return "OKTOBER";
                break;
            case 11:
                return "NOVEMBER";
                break;
            case 12:
                return "DESEMBER";
                break;
        }
    }
}

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


class ExportLaporanKasGantungController extends MyController
{
    public $title = 'Export Laporan Kas Gantung';

    public function index(Request $request)
    {
        $title = $this->title;
        $data = [
            'pagename' => 'Menu Utama Export Laporan Kas Gantung',
        ];

        return view('exportlaporankasgantung.index', compact('title'));
    }

    public function export(Request $request): void
    {
        $detailParams = [
            'periode' => $request->periode,
            'bank_id' => $request->bank_id,
            'bank' => $request->bank
        ];

        // dd(config('app.api_url') . 'exportlaporankasgantung/export', $detailParams);

        $header = Http::withHeaders(request()->header())
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'exportlaporankasgantung/export', $detailParams);

        $data = $header['data'];

        $dataDua = $header['dataDua'];

        $spreadsheet = new Spreadsheet();
        $alphabets = array_merge(range('A', 'Z'), range('AA', 'AZ'), range('BA', 'BZ'), range('CA', 'CZ'));
        $sheetIndex = 0;
        $sheetDates = array_unique(array_column($data, 'tgl'));
        // dd( $sheetDates);

        // Create cell styles
        $boldStyle = [
            'font' => ['bold' => true],
        ];

        $borderStyle = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
            ],
        ];

        // Laporan Gantung
        foreach ($sheetDates as $date) {
            $sheet = $spreadsheet->createSheet($sheetIndex);
            $spreadsheet->setActiveSheetIndex($sheetIndex);
            $sheet->setTitle($date);
            $sheetIndex++;

            $sheet->setCellValue('A1', $data[0]['judul']);
            $sheet->getStyle("A1")->getFont()->setSize(20);
            $sheet->getStyle('A1')->getAlignment()->setHorizontal('center');
            $sheet->mergeCells('A1:J1');

            $sheet->setCellValue('A2', 'LAPORAN KAS GANTUNG');
            $sheet->getStyle("A2")->getFont()->setSize(16);
            $sheet->getStyle('A2')->getAlignment()->setHorizontal('center');
            $sheet->mergeCells('A2:J2');

            $headerRow = 4;
            $columnIndex = 0;
            $headerColumns = [
                'tgl' => 'TANGGAL',
                'nobukti' => 'NO BUKTI',
                'perkiraan' => 'PERKIRAAN',
                'keterangan' => 'KETERANGAN',
                'debet' => 'DEBET',
                'kredit' => 'KREDIT',
                'saldo' => 'SALDO',
            ];

            foreach ($headerColumns as $index => $label) {
                $sheet->setCellValue($alphabets[$columnIndex] . $headerRow, $label);
                $sheet->getColumnDimension($alphabets[$columnIndex])->setAutoSize(true);
                $sheet->getStyle($alphabets[$columnIndex] . $headerRow)->applyFromArray($boldStyle);
                $sheet->getStyle($alphabets[$columnIndex] . $headerRow)->applyFromArray($borderStyle);
                $columnIndex++;
            }

            $filteredData = array_filter($data, function ($row) use ($date) {
                return $row['tgl'] == $date && $row['jenislaporan'] != 'LAPORAN REKAP' && $row['jenislaporan'] != 'LAPORAN REKAP 01';
            });

            $dataRow = $headerRow + 1;
            $columnIndex = 0;
            $lastColumnIndex = array_search('saldo', array_keys($headerColumns)); // Get the index of the "saldo" column
            $rowNumber = 1; // Initial row number

            $totalDebet = 0;
            $totalKredit = 0;

            $previousRow = $dataRow - 1; // Initialize the previous row number

            foreach ($filteredData as $row) {
                // $sheet->setCellValue('A' . $dataRow, $rowNumber); // Set row number
                // $sheet->getStyle('A' . $dataRow)->applyFromArray($borderStyle);

                $columnIndex = 0; // Reset column index for each row
                foreach ($row as $index => $value) {
                    if ($columnIndex > $lastColumnIndex) {
                        break; // Exit the loop if the column index exceeds the index of the "saldo" column
                    }
                    $sheet->setCellValue($alphabets[$columnIndex] . $dataRow, $value);
                    $sheet->getStyle($alphabets[$columnIndex] . $dataRow)->applyFromArray($borderStyle);

                    // Apply number format to debet, kredit, and saldo columns
                    if ($index == 'debet' || $index == 'kredit' || $index == 'saldo') {
                        $sheet->getStyle($alphabets[$columnIndex] . $dataRow)->getNumberFormat()->setFormatCode("#,##0.00");
                        $sheet->getStyle($alphabets[$columnIndex] . $dataRow)->getNumberFormat()->applyFromArray($boldStyle);
                    }

                    // Apply date format to tgl column
                    if ($index == 'tgl') {
                        $sheet->getStyle($alphabets[$columnIndex] . $dataRow)->getNumberFormat()->setFormatCode('dd-mm-yyyy');
                    }

                    if ($index == 'debet') {
                        $totalDebet += $value;
                    }
                    if ($index == 'kredit') {
                        $totalKredit += $value;
                    }

                    $columnIndex++;
                }

                // Add the formula to the current row's J column
                if ($dataRow == $headerRow + 1) {
                    $sheet->setCellValue('G' . $dataRow, '=(E' . $dataRow . '-F' . $dataRow . ')');
                }
                if ($dataRow > $headerRow + 1) {
                    $sheet->setCellValue('G' . $dataRow, '=(G' . $previousRow . '+E' . $dataRow . ')-F' . $dataRow);
                }
                $sheet->getStyle('G' . $dataRow)->applyFromArray($borderStyle);
                $sheet->getStyle('G' . $dataRow)->getNumberFormat()->setFormatCode("#,##0.00");

                $previousRow = $dataRow; // Update the previous row number

                $dataRow++;
                $rowNumber++; // Increment row number
            }


            // Setelah perulangan selesai, tambahkan total ke sheet
            $sheet->setCellValue('E' . $dataRow, "=SUM(E5:E" . ($dataRow - 1) . ")");
            $sheet->getStyle('E' . $dataRow)->applyFromArray($borderStyle);
            $sheet->getStyle('E' . $dataRow)->applyFromArray($boldStyle);
            $sheet->getStyle('E' . $dataRow)->getNumberFormat()->setFormatCode("#,##0.00");

            $sheet->setCellValue('F' . $dataRow, "=SUM(F5:F" . ($dataRow - 1) . ")");
            $sheet->getStyle('F' . $dataRow)->applyFromArray($borderStyle);
            $sheet->getStyle('F' . $dataRow)->applyFromArray($boldStyle);
            $sheet->getStyle('F' . $dataRow)->getNumberFormat()->setFormatCode("#,##0.00");

            $sheet->setCellValue('G' . $dataRow, "=(E" . ($dataRow) . "-F" . ($dataRow)  . ")");
            $sheet->getStyle('G' . $dataRow)->applyFromArray($borderStyle);
            $sheet->getStyle('G' . $dataRow)->applyFromArray($boldStyle);
            $sheet->getStyle('G' . $dataRow)->getNumberFormat()->setFormatCode("#,##0.00");

            // Merge cells untuk menampilkan teks "TOTAL"
            $sheet->mergeCells('A' . $dataRow . ':D' . $dataRow);
            $sheet->setCellValue('A' . $dataRow, 'TOTAL:');
            $sheet->getStyle('A' . $dataRow . ':D' . $dataRow)->applyFromArray($boldStyle);
            $sheet->getStyle('A' . $dataRow . ':D' . $dataRow)->applyFromArray($borderStyle);
            $sheet->getStyle('A' . $dataRow . ':D' . $dataRow)->getAlignment()->setHorizontal('right');
        }

        // rekapitulasi
        // Laporan Rekap Perkiraan
        $rekapPerkiraanSheet = $spreadsheet->createSheet($sheetIndex);
        $spreadsheet->setActiveSheetIndex($sheetIndex);
        $rekapPerkiraanSheet->setTitle('REKAPITULASI');
        $sheetIndex++;

        $rekapPerkiraanSheet->setCellValue('A1', $data[0]['judul']);
        $rekapPerkiraanSheet->getStyle("A1")->getFont()->setSize(20);
        $rekapPerkiraanSheet->getStyle('A1')->getAlignment()->setHorizontal('center');
        $rekapPerkiraanSheet->mergeCells('A1:E1');

        $rekapPerkiraanSheet->setCellValue('A2', 'LAPORAN REKAP KAS GANTUNG');
        $rekapPerkiraanSheet->getStyle("A2")->getFont()->setSize(16);
        $rekapPerkiraanSheet->getStyle('A2')->getAlignment()->setHorizontal('center');
        $rekapPerkiraanSheet->mergeCells('A2:E2');

        $rekapPerkiraanHeaderRow = 4;
        $rekapPerkiraanColumnIndex = 0;
        $rekapPerkiraanHeaderColumns = [
            'tglbukti' => 'TANGGAL',
            'nobukti' => 'NO BUKTI',
            'keterangan' => 'KETERANGAN',
            'nominal' => 'NOMINAL',
            'nominalbayar' => 'NOMINAL BAYAR',
            'sisa' => 'SISA',

        ];


        foreach ($rekapPerkiraanHeaderColumns as $index => $label) {
            $rekapPerkiraanSheet->setCellValue($alphabets[$rekapPerkiraanColumnIndex] . $rekapPerkiraanHeaderRow, $label);
            $rekapPerkiraanSheet->getColumnDimension($alphabets[$rekapPerkiraanColumnIndex])->setAutoSize(true);
            $rekapPerkiraanSheet->getStyle($alphabets[$rekapPerkiraanColumnIndex] . $rekapPerkiraanHeaderRow)->applyFromArray($boldStyle);
            $rekapPerkiraanSheet->getStyle($alphabets[$rekapPerkiraanColumnIndex] . $rekapPerkiraanHeaderRow)->applyFromArray($borderStyle);
            $rekapPerkiraanColumnIndex++;
        }

        $rekapPerkiraanDataRow = $rekapPerkiraanHeaderRow + 1;
        $rekapPerkiraanColumnIndex = 0;
        $rekapPerkiraanRowNumber = 1; // Initial row number

        foreach ($dataDua as $row) {
            $rekapPerkiraanColumnIndex = 0;
            // $rekapPerkiraanSheet->setCellValue('A' . $rekapPerkiraanDataRow, $rekapPerkiraanRowNumber); // Set nomor baris
            // $rekapPerkiraanSheet->getStyle('A' . $rekapPerkiraanDataRow)->applyFromArray($borderStyle);

            $rekapPerkiraanSheet->setCellValue($alphabets[$rekapPerkiraanColumnIndex] . $rekapPerkiraanDataRow, $row['tglbukti']);
            $rekapPerkiraanSheet->getColumnDimension($alphabets[$rekapPerkiraanColumnIndex])->setAutoSize(true);
            $rekapPerkiraanSheet->getStyle($alphabets[$rekapPerkiraanColumnIndex] . $rekapPerkiraanDataRow)->applyFromArray($borderStyle);
            $rekapPerkiraanColumnIndex++;

            $rekapPerkiraanSheet->setCellValue($alphabets[$rekapPerkiraanColumnIndex] . $rekapPerkiraanDataRow, $row['nobukti']);
            $rekapPerkiraanSheet->getColumnDimension($alphabets[$rekapPerkiraanColumnIndex])->setAutoSize(true);
            $rekapPerkiraanSheet->getStyle($alphabets[$rekapPerkiraanColumnIndex] . $rekapPerkiraanDataRow)->applyFromArray($borderStyle);
            $rekapPerkiraanColumnIndex++;

            $rekapPerkiraanSheet->setCellValue($alphabets[$rekapPerkiraanColumnIndex] . $rekapPerkiraanDataRow, $row['keterangan']);
            $rekapPerkiraanSheet->getColumnDimension($alphabets[$rekapPerkiraanColumnIndex])->setAutoSize(true);
            $rekapPerkiraanSheet->getStyle($alphabets[$rekapPerkiraanColumnIndex] . $rekapPerkiraanDataRow)->applyFromArray($borderStyle);
            if ($row['jenis'] == "1") {
                $rekapPerkiraanSheet->getStyle("A$rekapPerkiraanDataRow:F$rekapPerkiraanDataRow")->applyFromArray($boldStyle);
            }
            $rekapPerkiraanColumnIndex++;


            $rekapPerkiraanSheet->setCellValue($alphabets[$rekapPerkiraanColumnIndex] . $rekapPerkiraanDataRow, $row['nominal']);
            $rekapPerkiraanSheet->getColumnDimension($alphabets[$rekapPerkiraanColumnIndex])->setAutoSize(true);
            $rekapPerkiraanSheet->getStyle($alphabets[$rekapPerkiraanColumnIndex] . $rekapPerkiraanDataRow)->applyFromArray($borderStyle);
            $rekapPerkiraanSheet->getStyle($alphabets[$rekapPerkiraanColumnIndex] . $rekapPerkiraanDataRow)->getNumberFormat()->setFormatCode("#,##0.00");
            $rekapPerkiraanColumnIndex++;

            $rekapPerkiraanSheet->setCellValue($alphabets[$rekapPerkiraanColumnIndex] . $rekapPerkiraanDataRow, $row['nominalbayar']);
            $rekapPerkiraanSheet->getColumnDimension($alphabets[$rekapPerkiraanColumnIndex])->setAutoSize(true);
            $rekapPerkiraanSheet->getStyle($alphabets[$rekapPerkiraanColumnIndex] . $rekapPerkiraanDataRow)->applyFromArray($borderStyle);
            $rekapPerkiraanSheet->getStyle($alphabets[$rekapPerkiraanColumnIndex] . $rekapPerkiraanDataRow)->getNumberFormat()->setFormatCode("#,##0.00");
            $rekapPerkiraanColumnIndex++;

            $rekapPerkiraanSheet->setCellValue($alphabets[$rekapPerkiraanColumnIndex] . $rekapPerkiraanDataRow, $row['sisa']);
            $rekapPerkiraanSheet->getColumnDimension($alphabets[$rekapPerkiraanColumnIndex])->setAutoSize(true);
            $rekapPerkiraanSheet->getStyle($alphabets[$rekapPerkiraanColumnIndex] . $rekapPerkiraanDataRow)->applyFromArray($borderStyle);
            $rekapPerkiraanSheet->getStyle($alphabets[$rekapPerkiraanColumnIndex] . $rekapPerkiraanDataRow)->getNumberFormat()->setFormatCode("#,##0.00");
            $rekapPerkiraanColumnIndex++;




            $rekapPerkiraanDataRow++;
            $rekapPerkiraanColumnIndex = 0;
            $rekapPerkiraanRowNumber++;
        }




        // Menghitung total kolom D (nominaldebet)
        $rekapPerkiraanSheet->setCellValue('D' . $rekapPerkiraanDataRow, "=SUM(D5:D" . ($rekapPerkiraanDataRow - 1) . ")");
        $rekapPerkiraanSheet->getStyle('D' . $rekapPerkiraanDataRow)->applyFromArray($borderStyle);
        $rekapPerkiraanSheet->getStyle('D' . $rekapPerkiraanDataRow)->applyFromArray($boldStyle);
        $rekapPerkiraanSheet->getStyle('D' . $rekapPerkiraanDataRow)->getNumberFormat()->setFormatCode("#,##0.00");

        // Menghitung total kolom E (nominalkredit)
        $rekapPerkiraanSheet->setCellValue('E' . $rekapPerkiraanDataRow, "=SUM(E5:E" . ($rekapPerkiraanDataRow - 1) . ")");
        $rekapPerkiraanSheet->getStyle('E' . $rekapPerkiraanDataRow)->applyFromArray($borderStyle);
        $rekapPerkiraanSheet->getStyle('E' . $rekapPerkiraanDataRow)->applyFromArray($boldStyle);
        $rekapPerkiraanSheet->getStyle('E' . $rekapPerkiraanDataRow)->getNumberFormat()->setFormatCode("#,##0.00");

        // Merge cells A hingga C dan tampilkan tulisan "TOTAL:"
        $rekapPerkiraanSheet->mergeCells('A' . $rekapPerkiraanDataRow . ':C' . $rekapPerkiraanDataRow);
        $rekapPerkiraanSheet->setCellValue('A' . $rekapPerkiraanDataRow, 'TOTAL:');
        $rekapPerkiraanSheet->getStyle('A' . $rekapPerkiraanDataRow . ':C' . $rekapPerkiraanDataRow)->applyFromArray($boldStyle);
        $rekapPerkiraanSheet->getStyle('A' . $rekapPerkiraanDataRow . ':C' . $rekapPerkiraanDataRow)->applyFromArray($borderStyle);
        $rekapPerkiraanSheet->getStyle('A' . $rekapPerkiraanDataRow . ':C' . $rekapPerkiraanDataRow)->getAlignment()->setHorizontal('right');


        // end rekapitulasi

        $writer = new Xlsx($spreadsheet);
        $filename = 'LAPORAN KAS GANTUNG ' . date('dmYHis');
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
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

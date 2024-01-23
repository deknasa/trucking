<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

class LaporanKasHarianController extends MyController
{
    public $title = 'Laporan Kas Harian';

    public function index(Request $request)
    {
        $title = $this->title;
        $data = [
            'pagename' => 'Menu Utama Laporan Kas Harian',
        ];


        return view('laporankasharian.index', compact('title'));
    }

    public function export(Request $request): void
    {
        $detailParams = [
            'periode' => $request->periode,
            'bank_id' => $request->bank_id,
            'bank' => $request->bank
        ];

        // dd(config('app.api_url') . 'exportlaporankasharian/export', $detailParams);

        $header = Http::withHeaders(request()->header())
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'exportlaporankasharian/export', $detailParams);

        $data = $header['data'];
       
        $dataDua = $header['dataDua'];



        $spreadsheet = new Spreadsheet();
        $alphabets = array_merge(range('A', 'Z'), range('AA', 'AZ'), range('BA', 'BZ'), range('CA', 'CZ'));
        $sheetIndex = 0;
        $sheetDates = array_unique(array_column($data, 'tgl'));

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

        // Laporan Harian
        foreach ($sheetDates as $date) {
            $sheet = $spreadsheet->createSheet($sheetIndex);
            $spreadsheet->setActiveSheetIndex($sheetIndex);
            $sheet->setTitle($date);
            $sheetIndex++;

            $sheet->setCellValue('A1', 'PT. TRANSPORINDO AGUNG SEJAHTERA');
            $sheet->getStyle("A1")->getFont()->setSize(12);
            $sheet->getStyle('A1')->getAlignment()->setHorizontal('center');
            $sheet->mergeCells('A1:K1');

            $sheet->setCellValue('A2', 'LAPORAN KAS HARIAN');
            $sheet->getStyle("A2")->getFont()->setSize(12);
            $sheet->getStyle('A2')->getAlignment()->setHorizontal('left');
            $sheet->mergeCells('A2:K2');

            $headerRow = 4;
            $columnIndex = 0;
            $headerColumns = [
                'no' => 'NO',
                'jenislaporan' => 'JENIS LAPORAN',
                'jenis' => 'JENIS',
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
                $sheet->setCellValue('A' . $dataRow, $rowNumber); // Set row number
                $sheet->getStyle('A' . $dataRow)->applyFromArray($borderStyle);

                $columnIndex = 1; // Reset column index for each row
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
                if ($dataRow > $headerRow + 1) {
                    $sheet->setCellValue('J' . $dataRow, '=(J' . $previousRow . '+H' . $dataRow . ')-I' . $dataRow);
                }
                $sheet->getStyle('J' . $dataRow)->applyFromArray($borderStyle);
                $sheet->getStyle('J' . $dataRow)->getNumberFormat()->setFormatCode("#,##0.00");

                $previousRow = $dataRow; // Update the previous row number

                $dataRow++;
                $rowNumber++; // Increment row number
            }


            // Setelah perulangan selesai, tambahkan total ke sheet
            $sheet->setCellValue('H' . $dataRow, "=SUM(H5:H" . ($dataRow - 1) . ")");
            $sheet->getStyle('H' . $dataRow)->applyFromArray($borderStyle);
            $sheet->getStyle('H' . $dataRow)->applyFromArray($boldStyle);
            $sheet->getStyle('H' . $dataRow)->getNumberFormat()->setFormatCode("#,##0.00");

            $sheet->setCellValue('I' . $dataRow, "=SUM(I5:I" . ($dataRow - 1) . ")");
            $sheet->getStyle('I' . $dataRow)->applyFromArray($borderStyle);
            $sheet->getStyle('I' . $dataRow)->applyFromArray($boldStyle);
            $sheet->getStyle('I' . $dataRow)->getNumberFormat()->setFormatCode("#,##0.00");

            // Merge cells untuk menampilkan teks "TOTAL"
            $sheet->mergeCells('A' . $dataRow . ':G' . $dataRow);
            $sheet->setCellValue('A' . $dataRow, 'TOTAL:');
            $sheet->getStyle('A' . $dataRow . ':G' . $dataRow)->applyFromArray($boldStyle);
            $sheet->getStyle('A' . $dataRow . ':G' . $dataRow)->applyFromArray($borderStyle);
            $sheet->getStyle('A' . $dataRow . ':G' . $dataRow)->getAlignment()->setHorizontal('right');
        }

        // Laporan Rekap
        $rekapSheet = $spreadsheet->createSheet($sheetIndex);
        $spreadsheet->setActiveSheetIndex($sheetIndex);
        $rekapSheet->setTitle('LAPORAN REKAP');
        $sheetIndex++;

        $rekapSheet->setCellValue('A1', 'PT. TRANSPORINDO AGUNG SEJAHTERA');
        $rekapSheet->getStyle("A1")->getFont()->setSize(12);
        $rekapSheet->getStyle('A1')->getAlignment()->setHorizontal('center');
        $rekapSheet->mergeCells('A1:K1');

        $rekapSheet->setCellValue('A2', 'LAPORAN REKAP');
        $rekapSheet->getStyle("A2")->getFont()->setSize(12);
        $rekapSheet->getStyle('A2')->getAlignment()->setHorizontal('left');
        $rekapSheet->mergeCells('A2:K2');

        $rekapHeaderRow = 4;
        $rekapColumnIndex = 0;
        $rekapHeaderColumns = [
            'no' => 'NO',
            'jenislaporan' => 'JENIS LAPORAN',
            'jenis' => 'JENIS',
            'tgl' => 'TANGGAL',
            'nobukti' => 'NO BUKTI',
            'perkiraan' => 'PERKIRAAN',
            'keterangan' => 'KETERANGAN',
            'debet' => 'DEBET',
            'kredit' => 'KREDIT',
            'saldo' => 'SALDO',
        ];

        foreach ($rekapHeaderColumns as $index => $label) {
            $rekapSheet->setCellValue($alphabets[$rekapColumnIndex] . $rekapHeaderRow, $label);
            $rekapSheet->getColumnDimension($alphabets[$rekapColumnIndex])->setAutoSize(true);
            $rekapSheet->getStyle($alphabets[$rekapColumnIndex] . $rekapHeaderRow)->applyFromArray($boldStyle);
            $rekapSheet->getStyle($alphabets[$rekapColumnIndex] . $rekapHeaderRow)->applyFromArray($borderStyle);
            $rekapColumnIndex++;
        }

        $filteredRekapData = array_filter($data, function ($row) {
            return $row['jenislaporan'] == 'LAPORAN REKAP';
        });

        $rekapDataRow = $rekapHeaderRow + 1;
        $rekapColumnIndex = 0;
        $lastRekapColumnIndex = array_search('saldo', array_keys($rekapHeaderColumns)); // Get the index of the "saldo" column
        $rekapRowNumber = 1; // Initial row number

        $totalDebet = 0;
        $totalKredit = 0;

        $previousRow = $rekapDataRow - 1; // Initialize the previous row number

        foreach ($filteredRekapData as $row) {
            $rekapSheet->setCellValue('A' . $rekapDataRow, $rekapRowNumber); // Set row number
            $rekapSheet->getStyle('A' . $rekapDataRow)->applyFromArray($borderStyle);

            $rekapColumnIndex = 1; // Reset column index for each row
            foreach ($row as $index => $value) {
                if ($rekapColumnIndex > $lastRekapColumnIndex) {
                    break; // Exit the loop if the column index exceeds the index of the "saldo" column
                }
                $rekapSheet->setCellValue($alphabets[$rekapColumnIndex] . $rekapDataRow, $value);
                $rekapSheet->getStyle($alphabets[$rekapColumnIndex] . $rekapDataRow)->applyFromArray($borderStyle);

                // Apply number format to debet, kredit, and saldo columns
                if ($index == 'debet' || $index == 'kredit' || $index == 'saldo') {
                    $rekapSheet->getStyle($alphabets[$rekapColumnIndex] . $rekapDataRow)->getNumberFormat()->setFormatCode("#,##0.00");
                }

                // Apply date format to tgl column
                if ($index == 'tgl') {
                    $rekapSheet->getStyle($alphabets[$rekapColumnIndex] . $rekapDataRow)->getNumberFormat()->setFormatCode('dd-mm-yyyy');
                }

                if ($index == 'debet') {
                    $totalDebet += $value;
                }
                if ($index == 'kredit') {
                    $totalKredit += $value;
                }

                $rekapColumnIndex++;
            }

             // Add the formula to the current row's J column
             if ($rekapDataRow > $rekapHeaderRow + 1) {
                $rekapSheet->setCellValue('J' . $rekapDataRow, '=(J' . $previousRow . '+H' . $rekapDataRow . ')-I' . $rekapDataRow);
            }
            $rekapSheet->getStyle('J' . $rekapDataRow)->applyFromArray($borderStyle);
            $rekapSheet->getStyle('J' . $rekapDataRow)->getNumberFormat()->setFormatCode("#,##0.00");

            $previousRow = $rekapDataRow; // Update the previous row number


            $rekapDataRow++;
            $rekapRowNumber++; // Increment row number
        }

        // Setelah perulangan selesai, tambahkan total ke sheet
        $rekapSheet->setCellValue('H' . $rekapDataRow, "=SUM(H5:H" . ($rekapDataRow - 1) . ")");
        $rekapSheet->getStyle('H' . $rekapDataRow)->applyFromArray($borderStyle);
        $rekapSheet->getStyle('H' . $rekapDataRow)->applyFromArray($boldStyle);
        $rekapSheet->getStyle('H' . $rekapDataRow)->getNumberFormat()->setFormatCode("#,##0.00");

        $rekapSheet->setCellValue('I' . $rekapDataRow, "=SUM(I5:I" . ($rekapDataRow - 1) . ")");
        $rekapSheet->getStyle('I' . $rekapDataRow)->applyFromArray($borderStyle);
        $rekapSheet->getStyle('I' . $rekapDataRow)->applyFromArray($boldStyle);
        $rekapSheet->getStyle('I' . $rekapDataRow)->getNumberFormat()->setFormatCode("#,##0.00");

        // Merge cells untuk menampilkan teks "TOTAL"
        $rekapSheet->mergeCells('A' . $rekapDataRow . ':G' . $rekapDataRow);
        $rekapSheet->setCellValue('A' . $rekapDataRow, 'TOTAL:');
        $rekapSheet->getStyle('A' . $rekapDataRow . ':G' . $rekapDataRow)->applyFromArray($boldStyle);
        $rekapSheet->getStyle('A' . $rekapDataRow . ':G' . $rekapDataRow)->applyFromArray($borderStyle);
        $rekapSheet->getStyle('A' . $rekapDataRow . ':G' . $rekapDataRow)->getAlignment()->setHorizontal('right');



        // Laporan Rekap 01
        $rekap01Sheet = $spreadsheet->createSheet($sheetIndex);
        $spreadsheet->setActiveSheetIndex($sheetIndex);
        $rekap01Sheet->setTitle('LAPORAN REKAP 01');
        $sheetIndex++;

        $rekap01Sheet->setCellValue('A1', 'PT. TRANSPORINDO AGUNG SEJAHTERA');
        $rekap01Sheet->getStyle("A1")->getFont()->setSize(12);
        $rekap01Sheet->getStyle('A1')->getAlignment()->setHorizontal('center');
        $rekap01Sheet->mergeCells('A1:K1');

        $rekap01Sheet->setCellValue('A2', 'LAPORAN REKAP 01');
        $rekap01Sheet->getStyle("A2")->getFont()->setSize(12);
        $rekap01Sheet->getStyle('A2')->getAlignment()->setHorizontal('left');
        $rekap01Sheet->mergeCells('A2:K2');

        $rekap01HeaderRow = 4;
        $rekap01ColumnIndex = 0;
        $rekap01HeaderColumns = [
            'no' => 'NO',
            'jenislaporan' => 'JENIS LAPORAN',
            'jenis' => 'JENIS',
            'tgl' => 'TANGGAL',
            'nobukti' => 'NO BUKTI',
            'perkiraan' => 'PERKIRAAN',
            'keterangan' => 'KETERANGAN',
            'debet' => 'DEBET',
            'kredit' => 'KREDIT',
            'saldo' => 'SALDO',
        ];

        foreach ($rekap01HeaderColumns as $index => $label) {
            $rekap01Sheet->setCellValue($alphabets[$rekap01ColumnIndex] . $rekap01HeaderRow, $label);
            $rekap01Sheet->getColumnDimension($alphabets[$rekap01ColumnIndex])->setAutoSize(true);
            $rekap01Sheet->getStyle($alphabets[$rekap01ColumnIndex] . $rekap01HeaderRow)->applyFromArray($boldStyle);
            $rekap01Sheet->getStyle($alphabets[$rekap01ColumnIndex] . $rekap01HeaderRow)->applyFromArray($borderStyle);
            $rekap01ColumnIndex++;
        }

        $filteredRekap01Data = array_filter($data, function ($row) {
            return $row['jenislaporan'] == 'LAPORAN REKAP 01';
        });

        $rekap01DataRow = $rekap01HeaderRow + 1;
        $rekap01ColumnIndex = 0;
        $lastRekap01ColumnIndex = array_search('saldo', array_keys($rekap01HeaderColumns)); // Get the index of the "saldo" column
        $rekap01RowNumber = 1; // Initial row number

        $previousRow = $rekapDataRow - 1; // Initialize the previous row number $previousRow = $rekapDataRow - 1; // Initialize the previous row number

        foreach ($filteredRekap01Data as $row) {
            $rekap01Sheet->setCellValue('A' . $rekap01DataRow, $rekap01RowNumber); // Set row number
            $rekap01Sheet->getStyle('A' . $rekap01DataRow)->applyFromArray($borderStyle);

            $rekap01ColumnIndex = 1; // Reset column index for each row
            foreach ($row as $index => $value) {
                if ($rekap01ColumnIndex > $lastRekap01ColumnIndex) {
                    break; // Exit the loop if the column index exceeds the index of the "saldo" column
                }
                $rekap01Sheet->setCellValue($alphabets[$rekap01ColumnIndex] . $rekap01DataRow, $value);
                $rekap01Sheet->getStyle($alphabets[$rekap01ColumnIndex] . $rekap01DataRow)->applyFromArray($borderStyle);

                // Apply number format to debet, kredit, and saldo columns
                if ($index == 'debet' || $index == 'kredit' || $index == 'saldo') {
                    $rekap01Sheet->getStyle($alphabets[$rekap01ColumnIndex] . $rekap01DataRow)->getNumberFormat()->setFormatCode("#,##0.00");
                }

                // Apply date format to tgl column
                if ($index == 'tgl') {
                    $rekap01Sheet->getStyle($alphabets[$rekap01ColumnIndex] . $rekap01DataRow)->getNumberFormat()->setFormatCode('dd-mm-yyyy');
                }

                $rekap01ColumnIndex++;
            }

            // Add the formula to the current row's J column
            if ($rekap01DataRow > $rekap01HeaderRow+ 1) {
                $rekap01Sheet->setCellValue('J' . $rekap01DataRow, '=(J' . $previousRow . '+H' . $rekap01DataRow . ')-I' . $rekap01DataRow);
            }
            $rekap01Sheet->getStyle('J' . $rekap01DataRow)->applyFromArray($borderStyle);
            $rekap01Sheet->getStyle('J' . $rekap01DataRow)->getNumberFormat()->setFormatCode("#,##0.00");

            $previousRow = $rekap01DataRow; // Update the previous row number

            $rekap01DataRow++;
            $rekap01RowNumber++; // Increment row number
        }

        // Setelah perulangan selesai, tambahkan total ke sheet
        $rekap01Sheet->setCellValue('H' . $rekap01DataRow, "=SUM(H5:H" . ($rekap01DataRow - 1) . ")");
        $rekap01Sheet->getStyle('H' . $rekap01DataRow)->applyFromArray($borderStyle);
        $rekap01Sheet->getStyle('H' . $rekap01DataRow)->applyFromArray($boldStyle);
        $rekap01Sheet->getStyle('H' . $rekap01DataRow)->getNumberFormat()->setFormatCode("#,##0.00");

        $rekap01Sheet->setCellValue('I' . $rekap01DataRow, "=SUM(I5:I" . ($rekap01DataRow - 1) . ")");
        $rekap01Sheet->getStyle('I' . $rekap01DataRow)->applyFromArray($borderStyle);
        $rekap01Sheet->getStyle('I' . $rekap01DataRow)->applyFromArray($boldStyle);
        $rekap01Sheet->getStyle('I' . $rekap01DataRow)->getNumberFormat()->setFormatCode("#,##0.00");

        // Merge cells untuk menampilkan teks "TOTAL"
        $rekap01Sheet->mergeCells('A' . $rekap01DataRow . ':G' . $rekap01DataRow);
        $rekap01Sheet->setCellValue('A' . $rekap01DataRow, 'TOTAL:');
        $rekap01Sheet->getStyle('A' . $rekap01DataRow . ':G' . $rekap01DataRow)->applyFromArray($boldStyle);
        $rekap01Sheet->getStyle('A' . $rekap01DataRow . ':G' . $rekap01DataRow)->applyFromArray($borderStyle);
        $rekap01Sheet->getStyle('A' . $rekap01DataRow . ':G' . $rekap01DataRow)->getAlignment()->setHorizontal('right');


        // Laporan Rekap Perkiraan
        $rekapPerkiraanSheet = $spreadsheet->createSheet($sheetIndex);
        $spreadsheet->setActiveSheetIndex($sheetIndex);
        $rekapPerkiraanSheet->setTitle('REKAP PERKIRAAN');
        $sheetIndex++;

        $rekapPerkiraanSheet->setCellValue('A1', 'PT. TRANSPORINDO AGUNG SEJAHTERA');
        $rekapPerkiraanSheet->getStyle("A1")->getFont()->setSize(12);
        $rekapPerkiraanSheet->getStyle('A1')->getAlignment()->setHorizontal('center');
        $rekapPerkiraanSheet->mergeCells('A1:K1');

        $rekapPerkiraanSheet->setCellValue('A2', 'LAPORAN REKAP PERKIRAAN');
        $rekapPerkiraanSheet->getStyle("A2")->getFont()->setSize(12);
        $rekapPerkiraanSheet->getStyle('A2')->getAlignment()->setHorizontal('left');
        $rekapPerkiraanSheet->mergeCells('A2:K2');

        $rekapPerkiraanHeaderRow = 4;
        $rekapPerkiraanColumnIndex = 0;
        $rekapPerkiraanHeaderColumns = [
            'no' => 'NO',
            'coa' => 'COA',
            'perkiraan' => 'PERKIRAAN',
            'nominaldebet' => 'NOMINAL DEBET',
            'nominalkredit' => 'NOMINAL KREDIT',
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
            $rekapPerkiraanColumnIndex = 1;
            $rekapPerkiraanSheet->setCellValue('A' . $rekapPerkiraanDataRow, $rekapPerkiraanRowNumber); // Set nomor baris
            $rekapPerkiraanSheet->getStyle('A' . $rekapPerkiraanDataRow)->applyFromArray($borderStyle);

            $rekapPerkiraanSheet->setCellValue($alphabets[$rekapPerkiraanColumnIndex] . $rekapPerkiraanDataRow, $row['coa']);
            $rekapPerkiraanSheet->getColumnDimension($alphabets[$rekapPerkiraanColumnIndex])->setAutoSize(true);
            $rekapPerkiraanSheet->getStyle($alphabets[$rekapPerkiraanColumnIndex] . $rekapPerkiraanDataRow)->applyFromArray($borderStyle);
            $rekapPerkiraanColumnIndex++;

            $rekapPerkiraanSheet->setCellValue($alphabets[$rekapPerkiraanColumnIndex] . $rekapPerkiraanDataRow, $row['perkiraan']);
            $rekapPerkiraanSheet->getColumnDimension($alphabets[$rekapPerkiraanColumnIndex])->setAutoSize(true);
            $rekapPerkiraanSheet->getStyle($alphabets[$rekapPerkiraanColumnIndex] . $rekapPerkiraanDataRow)->applyFromArray($borderStyle);
            $rekapPerkiraanColumnIndex++;

            $rekapPerkiraanSheet->setCellValue($alphabets[$rekapPerkiraanColumnIndex] . $rekapPerkiraanDataRow, $row['nominaldebet']);
            $rekapPerkiraanSheet->getColumnDimension($alphabets[$rekapPerkiraanColumnIndex])->setAutoSize(true);
            $rekapPerkiraanSheet->getStyle($alphabets[$rekapPerkiraanColumnIndex] . $rekapPerkiraanDataRow)->applyFromArray($borderStyle);
            $rekapPerkiraanSheet->getStyle($alphabets[$rekapPerkiraanColumnIndex] . $rekapPerkiraanDataRow)->getNumberFormat()->setFormatCode("#,##0.00");
            $rekapPerkiraanColumnIndex++;

            $rekapPerkiraanSheet->setCellValue($alphabets[$rekapPerkiraanColumnIndex] . $rekapPerkiraanDataRow, $row['nominalkredit']);
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

        $writer = new Xlsx($spreadsheet);
        $filename = 'LAPORAN KAS HARIAN ' . date('dmYHis');
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }
}

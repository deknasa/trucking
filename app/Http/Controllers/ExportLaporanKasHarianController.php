<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;


class ExportLaporanKasHarianController extends MyController
{
    public $title = 'Export Laporan Kas Harian';

    public function index(Request $request)
    {
        $title = $this->title;
        $data = [
            'pagename' => 'Menu Utama Export Laporan Kas Harian',
        ];

        return view('exportlaporankasharian.index', compact('title'));
    }

    public function export(Request $request): void
    {
        $detailParams = [
            'periode' => $request->periode,
            'bank_id' => $request->bank_id,
            'bank' => $request->bank
        ];
        if ($request->bank_id == 1) {
            $kasbank = 'KAS HARIAN';
            $norek = '';
        } else {
            $kasbank = 'BANK';
            $norek = '(' . $request->bank . ')';
        }
        // dd(config('app.api_url') . 'exportlaporankasharian/export', $detailParams);

        $header = Http::withHeaders(request()->header())
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'exportlaporankasharian/export', $detailParams);

        $data = $header['data'];
        if(count($data) == 0){
            throw new \Exception('TIDAK ADA DATA');
        }
        
        $dataDua = $header['dataDua'];
        $namacabang = $header['namacabang'];

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
        $englishMonths = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
        $indonesianMonths = ['JANUARI', 'FEBRUARI', 'MARET', 'APRIL', 'MEI', 'JUNI', 'JULI', 'AGUSTUS', 'SEPTEMBER', 'OKTOBER', 'NOVEMBER', 'DESEMBER'];

        // Laporan Harian
        foreach ($sheetDates as $date) {
            $sheet = $spreadsheet->createSheet($sheetIndex);
            $spreadsheet->setActiveSheetIndex($sheetIndex);
            $sheet->setTitle(ltrim(date('d', strtotime($date)), 0));
            $sheetIndex++;

            $sheet->setCellValue('A1', $data[0]['judul']);
            $sheet->getStyle("A1")->getFont()->setSize(16)->setBold(true);
            $sheet->getStyle('A1')->getAlignment()->setHorizontal('center');
            $sheet->mergeCells('A1:H1');
            $sheet->setCellValue('A2', $namacabang);
            $sheet->getStyle("A2")->getFont()->setSize(16)->setBold(true);
            $sheet->getStyle('A2')->getAlignment()->setHorizontal('center');
            $sheet->mergeCells('A2:H2');


            $tanggal = str_replace($englishMonths, $indonesianMonths, date('d - M - Y', strtotime($date)));

            $sheet->setCellValue('A3', 'LAPORAN ' . $kasbank . ' ' . $norek);
            $sheet->getStyle("A3")->getFont()->setBold(true);
            // $sheet->mergeCells('A2:H2');

            $sheet->setCellValue('A4', 'PER ' . $tanggal);
            $sheet->getStyle("A4")->getFont()->setBold(true);
            // $sheet->mergeCells('A3:H3');

            $headerRow = 6;
            $columnIndex = 0;
            $headerColumns = [
                'no' => 'No',
                'tgl' => 'Tanggal',
                'nobukti' => 'No Bukti',
                'perkiraan' => 'Perkiraan',
                'keterangan' => 'Keterangan',
                'debet' => 'Debet',
                'kredit' => 'Kredit',
                'saldo' => 'Saldo',
            ];

            foreach ($headerColumns as $index => $label) {
                $sheet->setCellValue($alphabets[$columnIndex] . $headerRow, $label);
                if ($index == 'keterangan') {
                    $sheet->getColumnDimension($alphabets[$columnIndex])->setWidth(71);
                } else if ($index == 'no') {
                    $sheet->getColumnDimension($alphabets[$columnIndex])->setWidth(4);
                } else {
                    $sheet->getColumnDimension($alphabets[$columnIndex])->setAutoSize(true);
                }
                $sheet->getStyle($alphabets[$columnIndex] . $headerRow)->applyFromArray($boldStyle);
                // $sheet->getStyle($alphabets[$columnIndex] . $headerRow)->applyFromArray($borderStyle);
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
                // $sheet->getStyle('A' . $dataRow)->applyFromArray($borderStyle);
                unset($row['jenislaporan']);
                unset($row['jenis']);
                $columnIndex = 1; // Reset column index for each row
                foreach ($row as $index => $value) {
                    if ($columnIndex > $lastColumnIndex) {
                        break; // Exit the loop if the column index exceeds the index of the "saldo" column
                    }

                    if ($index == 'tgl') {
                        $dateValue = ($value != null) ? Date::PHPToExcel(date('Y-m-d', strtotime($value))) : '';
                        $sheet->setCellValue($alphabets[$columnIndex] . $dataRow, $dateValue);
                    } else {
                        $sheet->setCellValue($alphabets[$columnIndex] . $dataRow, $value);
                    }
                    // $sheet->getStyle($alphabets[$columnIndex] . $dataRow)->applyFromArray($borderStyle);

                    // Apply number format to debet, kredit, and saldo columns
                    if ($index == 'debet' || $index == 'kredit' || $index == 'saldo') {
                        $sheet->getStyle($alphabets[$columnIndex] . $dataRow)->getNumberFormat()->setFormatCode("#,##0.00_);(#,##0.00)");
                        // $sheet->getStyle($alphabets[$columnIndex] . $dataRow)->getNumberFormat()->applyFromArray($boldStyle);
                    }

                    // Apply date format to tgl column
                    if ($index == 'tgl') {
                        $sheet->getStyle($alphabets[$columnIndex] . $dataRow)
                            ->getNumberFormat()
                            ->setFormatCode('dd-mm-yyyy');
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
                    $sheet->setCellValue('H' . $dataRow, '=(H' . $previousRow . '+F' . $dataRow . ')-G' . $dataRow);
                }
                // $sheet->getStyle('H' . $dataRow)->applyFromArray($borderStyle);
                $sheet->getStyle('H' . $dataRow)->getNumberFormat()->setFormatCode("#,##0.00_);(#,##0.00)");

                $previousRow = $dataRow; // Update the previous row number

                $dataRow++;
                $rowNumber++; // Increment row number
            }


            // Setelah perulangan selesai, tambahkan total ke sheet
            $sheet->setCellValue('F' . $dataRow, "=SUM(F6:F" . ($dataRow - 1) . ")");
            // $sheet->getStyle('F' . $dataRow)->applyFromArray($borderStyle);
            $sheet->getStyle('F' . $dataRow)->applyFromArray($boldStyle);
            $sheet->getStyle('F' . $dataRow)->getNumberFormat()->setFormatCode("#,##0.00_);(#,##0.00)");

            $sheet->setCellValue('G' . $dataRow, "=SUM(G6:G" . ($dataRow - 1) . ")");
            // $sheet->getStyle('G' . $dataRow)->applyFromArray($borderStyle);
            $sheet->getStyle('G' . $dataRow)->applyFromArray($boldStyle);
            $sheet->getStyle('G' . $dataRow)->getNumberFormat()->setFormatCode("#,##0.00_);(#,##0.00)");

            // Merge cells untuk menampilkan teks "TOTAL"
            $sheet->mergeCells('A' . $dataRow . ':E' . $dataRow);
            $sheet->setCellValue('A' . $dataRow, 'TOTAL:');
            $sheet->getStyle('A' . $dataRow . ':H' . $dataRow)->applyFromArray($boldStyle);
            // $sheet->getStyle('A' . $dataRow . ':H' . $dataRow)->applyFromArray($borderStyle);
            $sheet->getStyle('A' . $dataRow . ':E' . $dataRow)->getAlignment()->setHorizontal('right');
        }

        // Laporan Rekap
        $rekapSheet = $spreadsheet->createSheet($sheetIndex);
        $spreadsheet->setActiveSheetIndex($sheetIndex);
        $rekapSheet->setTitle('LAPORAN REKAP');
        $sheetIndex++;

        $bulan = $this->getBulan(substr($request->periode, 0, 2));
        $tahun = substr($request->periode, 3, 4);

        $rekapSheet->setCellValue('A1', $data[0]['judul']);
        $rekapSheet->getStyle("A1")->getFont()->setSize(16)->setBold(true);
        $rekapSheet->getStyle('A1')->getAlignment()->setHorizontal('center');
        $rekapSheet->mergeCells('A1:H1');
        $rekapSheet->setCellValue('A2', $namacabang);
        $rekapSheet->getStyle("A2")->getFont()->setSize(16)->setBold(true);
        $rekapSheet->getStyle('A2')->getAlignment()->setHorizontal('center');
        $rekapSheet->mergeCells('A2:H2');

        $rekapSheet->setCellValue('A3', 'LAPORAN REKAP ' . $kasbank . ' ' . $norek);
        $rekapSheet->getStyle("A3")->getFont()->setBold(true);
        // $rekapSheet->getStyle('A2')->getAlignment()->setHorizontal('center');
        // $rekapSheet->mergeCells('A2:H2');

        $rekapSheet->setCellValue('A4', 'PERIODE ' . $bulan . ' - ' . $tahun);
        $rekapSheet->getStyle("A4")->getFont()->setBold(true);
        // $rekapSheet->getStyle('A3')->getAlignment()->setHorizontal('center');
        // $rekapSheet->mergeCells('A3:H3');

        $rekapHeaderRow = 6;
        $rekapColumnIndex = 0;
        $rekapHeaderColumns = [
            // 'no' => 'No',
            'tgl' => 'Tanggal',
            'nobukti' => 'No Bukti',
            'perkiraan' => 'Perkiraan',
            'keterangan' => 'Keterangan',
            'debet' => 'Debet',
            'kredit' => 'Kredit',
            'saldo' => 'Saldo',
        ];

        foreach ($rekapHeaderColumns as $index => $label) {
            $rekapSheet->setCellValue($alphabets[$rekapColumnIndex] . $rekapHeaderRow, $label);
            if ($index == 'keterangan') {
                $rekapSheet->getColumnDimension($alphabets[$rekapColumnIndex])->setWidth(70);
            } else if ($index == 'no') {
                $rekapSheet->getColumnDimension($alphabets[$rekapColumnIndex])->setWidth(4);
            } else if ($index == 'tgl') {
                $rekapSheet->getColumnDimension($alphabets[$rekapColumnIndex])->setWidth(12);
            } else if ($index == 'perkiraan') {
                $rekapSheet->getColumnDimension($alphabets[$rekapColumnIndex])->setWidth(25);
            } else {
                $rekapSheet->getColumnDimension($alphabets[$rekapColumnIndex])->setAutoSize(true);
            }
            $rekapSheet->getStyle($alphabets[$rekapColumnIndex] . $rekapHeaderRow)->applyFromArray($boldStyle);
            // $rekapSheet->getStyle($alphabets[$rekapColumnIndex] . $rekapHeaderRow)->applyFromArray($borderStyle);
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
            // $rekapSheet->setCellValue('A' . $rekapDataRow, $rekapRowNumber); // Set row number
            // $rekapSheet->getStyle('A' . $rekapDataRow)->applyFromArray($borderStyle);
            unset($row['jenislaporan']);
            unset($row['jenis']);
            $rekapColumnIndex = 0; // Reset column index for each row
            foreach ($row as $index => $value) {
                if ($rekapColumnIndex > $lastRekapColumnIndex) {
                    break; // Exit the loop if the column index exceeds the index of the "saldo" column
                }
                if ($index == 'tgl') {
                    $dateValue = ($value != null) ? Date::PHPToExcel(date('Y-m-d', strtotime($value))) : '';
                    $rekapSheet->setCellValue($alphabets[$rekapColumnIndex] . $rekapDataRow, $dateValue);
                } else {
                    $rekapSheet->setCellValue($alphabets[$rekapColumnIndex] . $rekapDataRow, $value);
                    // $rekapSheet->getStyle($alphabets[$rekapColumnIndex] . $rekapDataRow)->applyFromArray($borderStyle);
                }
                // Apply number format to debet, kredit, and saldo columns
                if ($index == 'debet' || $index == 'kredit' || $index == 'saldo') {
                    $rekapSheet->getStyle($alphabets[$rekapColumnIndex] . $rekapDataRow)->getNumberFormat()->setFormatCode("#,##0.00_);(#,##0.00)");
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
                $rekapSheet->setCellValue('G' . $rekapDataRow, '=(G' . $previousRow . '+E' . $rekapDataRow . ')-F' . $rekapDataRow);
            }
            // $rekapSheet->getStyle('H' . $rekapDataRow)->applyFromArray($borderStyle);
            $rekapSheet->getStyle('G' . $rekapDataRow)->getNumberFormat()->setFormatCode("#,##0.00_);(#,##0.00)");

            $previousRow = $rekapDataRow; // Update the previous row number


            $rekapDataRow++;
            $rekapRowNumber++; // Increment row number
        }

        // Setelah perulangan selesai, tambahkan total ke sheet
        $rekapSheet->setCellValue('E' . $rekapDataRow, "=SUM(E6:E" . ($rekapDataRow - 1) . ")");
        // $rekapSheet->getStyle('F' . $rekapDataRow)->applyFromArray($borderStyle);
        $rekapSheet->getStyle('E' . $rekapDataRow)->applyFromArray($boldStyle);
        $rekapSheet->getStyle('E' . $rekapDataRow)->getNumberFormat()->setFormatCode("#,##0.00_);(#,##0.00)");

        $rekapSheet->setCellValue('F' . $rekapDataRow, "=SUM(F6:F" . ($rekapDataRow - 1) . ")");
        // $rekapSheet->getStyle('G' . $rekapDataRow)->applyFromArray($borderStyle);
        $rekapSheet->getStyle('F' . $rekapDataRow)->applyFromArray($boldStyle);
        $rekapSheet->getStyle('F' . $rekapDataRow)->getNumberFormat()->setFormatCode("#,##0.00_);(#,##0.00)");

        // Merge cells untuk menampilkan teks "TOTAL"
        $rekapSheet->mergeCells('A' . $rekapDataRow . ':D' . $rekapDataRow);
        $rekapSheet->setCellValue('A' . $rekapDataRow, 'TOTAL:');
        $rekapSheet->getStyle('A' . $rekapDataRow . ':G' . $rekapDataRow)->applyFromArray($boldStyle);
        // $rekapSheet->getStyle('A' . $rekapDataRow . ':H' . $rekapDataRow)->applyFromArray($borderStyle);
        $rekapSheet->getStyle('A' . $rekapDataRow . ':D' . $rekapDataRow)->getAlignment()->setHorizontal('right');



        // Laporan Rekap 01
        $rekap01Sheet = $spreadsheet->createSheet($sheetIndex);
        $spreadsheet->setActiveSheetIndex($sheetIndex);
        $rekap01Sheet->setTitle('LAPORAN REKAP 01');
        $sheetIndex++;

        $periode = str_replace($englishMonths, $indonesianMonths, date('M - Y', strtotime($request->periode)));
        $rekap01Sheet->setCellValue('A1', $data[0]['judul']);
        $rekap01Sheet->getStyle("A1")->getFont()->setSize(16)->setBold(true);
        $rekap01Sheet->getStyle('A1')->getAlignment()->setHorizontal('center');
        $rekap01Sheet->mergeCells('A1:H1');
        $rekap01Sheet->setCellValue('A2', $namacabang);
        $rekap01Sheet->getStyle("A2")->getFont()->setSize(16)->setBold(true);
        $rekap01Sheet->getStyle('A2')->getAlignment()->setHorizontal('center');
        $rekap01Sheet->mergeCells('A2:H2');

        $rekap01Sheet->setCellValue('A3', 'LAPORAN REKAP 01 ' . $kasbank . ' ' . $norek);
        $rekap01Sheet->getStyle("A3")->getFont()->setBold(true);
        // $rekap01Sheet->getStyle('A2')->getAlignment()->setHorizontal('center');
        // $rekap01Sheet->mergeCells('A2:H2');

        $rekap01Sheet->setCellValue('A4', 'PERIODE ' . $bulan . ' - ' . $tahun);
        $rekap01Sheet->getStyle("A4")->getFont()->setBold(true);
        // $rekap01Sheet->getStyle('A3')->getAlignment()->setHorizontal('center');
        // $rekap01Sheet->mergeCells('A3:H3');

        $rekap01HeaderRow = 6;
        $rekap01ColumnIndex = 0;
        $rekap01HeaderColumns = [
            // 'no' => 'No',
            'tgl' => 'Tanggal',
            'nobukti' => 'No Bukti',
            'perkiraan' => 'Perkiraan',
            'keterangan' => 'Keterangan',
            'debet' => 'Debet',
            'kredit' => 'Kredit',
            'saldo' => 'Saldo',
        ];

        foreach ($rekap01HeaderColumns as $index => $label) {
            $rekap01Sheet->setCellValue($alphabets[$rekap01ColumnIndex] . $rekap01HeaderRow, $label);
            if ($index == 'keterangan') {
                $rekap01Sheet->getColumnDimension($alphabets[$rekap01ColumnIndex])->setWidth(70);
            } else if ($index == 'tgl') {
                $rekap01Sheet->getColumnDimension($alphabets[$rekap01ColumnIndex])->setWidth(12);
            } else if ($index == 'no') {
                $rekap01Sheet->getColumnDimension($alphabets[$rekap01ColumnIndex])->setWidth(4);
            } else if ($index == 'perkiraan') {
                $rekap01Sheet->getColumnDimension($alphabets[$rekap01ColumnIndex])->setWidth(25);
            } else {
                $rekap01Sheet->getColumnDimension($alphabets[$rekap01ColumnIndex])->setAutoSize(true);
            }
            $rekap01Sheet->getStyle($alphabets[$rekap01ColumnIndex] . $rekap01HeaderRow)->applyFromArray($boldStyle);
            // $rekap01Sheet->getStyle($alphabets[$rekap01ColumnIndex] . $rekap01HeaderRow)->applyFromArray($borderStyle);
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
            // $rekap01Sheet->setCellValue('A' . $rekap01DataRow, $rekap01RowNumber); // Set row number
            // $rekap01Sheet->getStyle('A' . $rekap01DataRow)->applyFromArray($borderStyle);

            unset($row['jenislaporan']);
            unset($row['jenis']);
            $rekap01ColumnIndex = 0; // Reset column index for each row
            foreach ($row as $index => $value) {
                if ($rekap01ColumnIndex > $lastRekap01ColumnIndex) {
                    break; // Exit the loop if the column index exceeds the index of the "saldo" column
                }
                if ($index == 'tgl') {
                    $dateValue = ($value != null) ? Date::PHPToExcel(date('Y-m-d', strtotime($value))) : '';
                    $rekap01Sheet->setCellValue($alphabets[$rekap01ColumnIndex] . $rekap01DataRow, $dateValue);
                } else {
                    $rekap01Sheet->setCellValue($alphabets[$rekap01ColumnIndex] . $rekap01DataRow, $value);
                    // $rekap01Sheet->getStyle($alphabets[$rekap01ColumnIndex] . $rekap01DataRow)->applyFromArray($borderStyle);
                }
                // Apply number format to debet, kredit, and saldo columns
                if ($index == 'debet' || $index == 'kredit' || $index == 'saldo') {
                    $rekap01Sheet->getStyle($alphabets[$rekap01ColumnIndex] . $rekap01DataRow)->getNumberFormat()->setFormatCode("#,##0.00_);(#,##0.00)");
                }

                // Apply date format to tgl column
                if ($index == 'tgl') {
                    $rekap01Sheet->getStyle($alphabets[$rekap01ColumnIndex] . $rekap01DataRow)->getNumberFormat()->setFormatCode('dd-mm-yyyy');
                }

                $rekap01ColumnIndex++;
            }

            // Add the formula to the current row's J column
            if ($rekap01DataRow > $rekap01HeaderRow + 1) {
                $rekap01Sheet->setCellValue('G' . $rekap01DataRow, '=(G' . $previousRow . '+E' . $rekap01DataRow . ')-F' . $rekap01DataRow);
            }
            // $rekap01Sheet->getStyle('H' . $rekap01DataRow)->applyFromArray($borderStyle);
            $rekap01Sheet->getStyle('G' . $rekap01DataRow)->getNumberFormat()->setFormatCode("#,##0.00_);(#,##0.00)");

            $previousRow = $rekap01DataRow; // Update the previous row number

            $rekap01DataRow++;
            $rekap01RowNumber++; // Increment row number
        }

        // Setelah perulangan selesai, tambahkan total ke sheet
        $rekap01Sheet->setCellValue('E' . $rekap01DataRow, "=SUM(E6:E" . ($rekap01DataRow - 1) . ")");
        // $rekap01Sheet->getStyle('F' . $rekap01DataRow)->applyFromArray($borderStyle);
        $rekap01Sheet->getStyle('E' . $rekap01DataRow)->applyFromArray($boldStyle);
        $rekap01Sheet->getStyle('E' . $rekap01DataRow)->getNumberFormat()->setFormatCode("#,##0.00_);(#,##0.00)");

        $rekap01Sheet->setCellValue('F' . $rekap01DataRow, "=SUM(F6:F" . ($rekap01DataRow - 1) . ")");
        // $rekap01Sheet->getStyle('G' . $rekap01DataRow)->applyFromArray($borderStyle);
        $rekap01Sheet->getStyle('F' . $rekap01DataRow)->applyFromArray($boldStyle);
        $rekap01Sheet->getStyle('F' . $rekap01DataRow)->getNumberFormat()->setFormatCode("#,##0.00_);(#,##0.00)");

        // Merge cells untuk menampilkan teks "TOTAL"
        $rekap01Sheet->mergeCells('A' . $rekap01DataRow . ':D' . $rekap01DataRow);
        $rekap01Sheet->setCellValue('A' . $rekap01DataRow, 'TOTAL:');
        $rekap01Sheet->getStyle('A' . $rekap01DataRow . ':G' . $rekap01DataRow)->applyFromArray($boldStyle);
        // $rekap01Sheet->getStyle('A' . $rekap01DataRow . ':H' . $rekap01DataRow)->applyFromArray($borderStyle);
        $rekap01Sheet->getStyle('A' . $rekap01DataRow . ':D' . $rekap01DataRow)->getAlignment()->setHorizontal('right');


        // Laporan Rekap Perkiraan
        $rekapPerkiraanSheet = $spreadsheet->createSheet($sheetIndex);
        $spreadsheet->setActiveSheetIndex($sheetIndex);
        $rekapPerkiraanSheet->setTitle('REKAP PERKIRAAN');
        $sheetIndex++;
        $periode = str_replace($englishMonths, $indonesianMonths, date('M - Y', strtotime($request->periode)));

        $rekapPerkiraanSheet->setCellValue('A1', $data[0]['judul']);
        $rekapPerkiraanSheet->getStyle("A1")->getFont()->setSize(16)->setBold(true);
        $rekapPerkiraanSheet->getStyle('A1')->getAlignment()->setHorizontal('center');
        $rekapPerkiraanSheet->mergeCells('A1:E1');
        $rekapPerkiraanSheet->setCellValue('A2', $namacabang);
        $rekapPerkiraanSheet->getStyle("A2")->getFont()->setSize(16)->setBold(true);
        $rekapPerkiraanSheet->getStyle('A2')->getAlignment()->setHorizontal('center');
        $rekapPerkiraanSheet->mergeCells('A2:E2');

        $rekapPerkiraanSheet->setCellValue('A3', 'LAPORAN REKAP PERKIRAAN');
        $rekapPerkiraanSheet->getStyle("A3")->getFont()->setBold(true);
        // $rekapPerkiraanSheet->getStyle('A2')->getAlignment()->setHorizontal('center');
        // $rekapPerkiraanSheet->mergeCells('A2:E2');

        $rekapPerkiraanSheet->setCellValue('A4', 'PERIODE ' . $bulan . ' - ' . $tahun);
        $rekapPerkiraanSheet->getStyle("A4")->getFont()->setBold(true);
        // $rekapPerkiraanSheet->getStyle('A3')->getAlignment()->setHorizontal('center');
        // $rekapPerkiraanSheet->mergeCells('A3:E3');

        $rekapPerkiraanHeaderRow = 6;
        $rekapPerkiraanColumnIndex = 0;
        $rekapPerkiraanHeaderColumns = [
            'no' => 'No',
            'coa' => 'Coa',
            'perkiraan' => 'Perkiraan',
            'nominaldebet' => 'Nominal Debet',
            'nominalkredit' => 'Nominal Kredit',
        ];

        foreach ($rekapPerkiraanHeaderColumns as $index => $label) {
            $rekapPerkiraanSheet->setCellValue($alphabets[$rekapPerkiraanColumnIndex] . $rekapPerkiraanHeaderRow, $label);
            if ($index == 'no') {
                $rekapPerkiraanSheet->getColumnDimension($alphabets[$rekapPerkiraanColumnIndex])->setWidth(4);
            } else {
                $rekapPerkiraanSheet->getColumnDimension($alphabets[$rekapPerkiraanColumnIndex])->setAutoSize(true);
            }
            $rekapPerkiraanSheet->getStyle($alphabets[$rekapPerkiraanColumnIndex] . $rekapPerkiraanHeaderRow)->applyFromArray($boldStyle);
            // $rekapPerkiraanSheet->getStyle($alphabets[$rekapPerkiraanColumnIndex] . $rekapPerkiraanHeaderRow)->applyFromArray($borderStyle);
            $rekapPerkiraanColumnIndex++;
        }

        $rekapPerkiraanDataRow = $rekapPerkiraanHeaderRow + 1;
        $rekapPerkiraanColumnIndex = 0;
        $rekapPerkiraanRowNumber = 1; // Initial row number

        foreach ($dataDua as $row) {
            $rekapPerkiraanColumnIndex = 1;
            $rekapPerkiraanSheet->setCellValue('A' . $rekapPerkiraanDataRow, $rekapPerkiraanRowNumber); // Set nomor baris
            // $rekapPerkiraanSheet->getStyle('A' . $rekapPerkiraanDataRow)->applyFromArray($borderStyle);

            $rekapPerkiraanSheet->setCellValue($alphabets[$rekapPerkiraanColumnIndex] . $rekapPerkiraanDataRow, $row['coa']);
            $rekapPerkiraanSheet->getColumnDimension($alphabets[$rekapPerkiraanColumnIndex])->setAutoSize(true);
            // $rekapPerkiraanSheet->getStyle($alphabets[$rekapPerkiraanColumnIndex] . $rekapPerkiraanDataRow)->applyFromArray($borderStyle);
            $rekapPerkiraanColumnIndex++;

            $rekapPerkiraanSheet->setCellValue($alphabets[$rekapPerkiraanColumnIndex] . $rekapPerkiraanDataRow, $row['perkiraan']);
            $rekapPerkiraanSheet->getColumnDimension($alphabets[$rekapPerkiraanColumnIndex])->setAutoSize(true);
            // $rekapPerkiraanSheet->getStyle($alphabets[$rekapPerkiraanColumnIndex] . $rekapPerkiraanDataRow)->applyFromArray($borderStyle);
            $rekapPerkiraanColumnIndex++;

            $rekapPerkiraanSheet->setCellValue($alphabets[$rekapPerkiraanColumnIndex] . $rekapPerkiraanDataRow, $row['nominaldebet']);
            $rekapPerkiraanSheet->getColumnDimension($alphabets[$rekapPerkiraanColumnIndex])->setAutoSize(true);
            // $rekapPerkiraanSheet->getStyle($alphabets[$rekapPerkiraanColumnIndex] . $rekapPerkiraanDataRow)->applyFromArray($borderStyle);
            $rekapPerkiraanSheet->getStyle($alphabets[$rekapPerkiraanColumnIndex] . $rekapPerkiraanDataRow)->getNumberFormat()->setFormatCode("#,##0.00_);(#,##0.00)");
            $rekapPerkiraanColumnIndex++;

            $rekapPerkiraanSheet->setCellValue($alphabets[$rekapPerkiraanColumnIndex] . $rekapPerkiraanDataRow, $row['nominalkredit']);
            $rekapPerkiraanSheet->getColumnDimension($alphabets[$rekapPerkiraanColumnIndex])->setAutoSize(true);
            // $rekapPerkiraanSheet->getStyle($alphabets[$rekapPerkiraanColumnIndex] . $rekapPerkiraanDataRow)->applyFromArray($borderStyle);
            $rekapPerkiraanSheet->getStyle($alphabets[$rekapPerkiraanColumnIndex] . $rekapPerkiraanDataRow)->getNumberFormat()->setFormatCode("#,##0.00_);(#,##0.00)");
            $rekapPerkiraanColumnIndex++;

            $rekapPerkiraanDataRow++;
            $rekapPerkiraanColumnIndex = 0;
            $rekapPerkiraanRowNumber++;
        }




        // Menghitung total kolom D (nominaldebet)
        $rekapPerkiraanSheet->setCellValue('D' . $rekapPerkiraanDataRow, "=SUM(D6:D" . ($rekapPerkiraanDataRow - 1) . ")");
        // $rekapPerkiraanSheet->getStyle('D' . $rekapPerkiraanDataRow)->applyFromArray($borderStyle);
        $rekapPerkiraanSheet->getStyle('D' . $rekapPerkiraanDataRow)->applyFromArray($boldStyle);
        $rekapPerkiraanSheet->getStyle('D' . $rekapPerkiraanDataRow)->getNumberFormat()->setFormatCode("#,##0.00_);(#,##0.00)");

        // Menghitung total kolom E (nominalkredit)
        $rekapPerkiraanSheet->setCellValue('E' . $rekapPerkiraanDataRow, "=SUM(E6:E" . ($rekapPerkiraanDataRow - 1) . ")");
        // $rekapPerkiraanSheet->getStyle('E' . $rekapPerkiraanDataRow)->applyFromArray($borderStyle);
        $rekapPerkiraanSheet->getStyle('E' . $rekapPerkiraanDataRow)->applyFromArray($boldStyle);
        $rekapPerkiraanSheet->getStyle('E' . $rekapPerkiraanDataRow)->getNumberFormat()->setFormatCode("#,##0.00_);(#,##0.00)");

        // Merge cells A hingga C dan tampilkan tulisan "TOTAL:"
        $rekapPerkiraanSheet->mergeCells('A' . $rekapPerkiraanDataRow . ':C' . $rekapPerkiraanDataRow);
        $rekapPerkiraanSheet->setCellValue('A' . $rekapPerkiraanDataRow, 'TOTAL:');
        $rekapPerkiraanSheet->getStyle('A' . $rekapPerkiraanDataRow . ':C' . $rekapPerkiraanDataRow)->applyFromArray($boldStyle);
        // $rekapPerkiraanSheet->getStyle('A' . $rekapPerkiraanDataRow . ':C' . $rekapPerkiraanDataRow)->applyFromArray($borderStyle);
        $rekapPerkiraanSheet->getStyle('A' . $rekapPerkiraanDataRow . ':C' . $rekapPerkiraanDataRow)->getAlignment()->setHorizontal('right');

        $writer = new Xlsx($spreadsheet);
        $filename = 'LAPORAN ' . $kasbank . ' ' . $norek . ' ' . date('dmYHis');
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

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class LaporanMingguanSupirBedaMandorController extends Controller
{
    public $title = 'Export Laporan Mingguan Supir (Beda Mandor)';

    public function index(Request $request)
    {
        $title = $this->title;
        return view('laporanmingguansupirbedamandor.index', compact('title'));
    }

    public function export(Request $request): void
    {
        $detailParams = [
            'dari' => $request->dari,
            'sampai' => $request->sampai,
            'tradodari_id' => $request->tradodari_id,
            'tradosampai_id' => $request->tradosampai_id,
            'tradodari' => $request->tradodari,
            'tradosampai' => $request->tradosampai,

        ];


        $header = Http::withHeaders(request()->header())
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'laporanmingguansupirbedamandor/export', $detailParams);

        // dd(config('app.api_url') . 'exportlaporanmingguansupir/export', $detailParams);

        $data = $header['data'];
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $detail_table_header_row = 1;
        $detail_start_row = $detail_table_header_row + 1;

        $styleArray = array(
            'borders' => array(
                'allBorders' => array(
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ),
            ),
        );
        $styleHeader = [
            'alignment' => [
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
            ],
        ];

        $style_number = [
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT,
            ],
        ];

        $styleArray2 = [
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT,
            ],
            'font' => [
                'bold' => true,
            ],
        ];

        $sheet->setCellValue("A$detail_table_header_row", 'Tanggal')->getStyle("A1")->applyFromArray($styleHeader)->getFont()->setSize(14)->setBold(true);
        $sheet->mergeCells("A$detail_table_header_row:A" . ($detail_table_header_row + 2));
        $sheet->setCellValue("B$detail_table_header_row", 'No')->getStyle("B1")->applyFromArray($styleHeader)->getFont()->setSize(14)->setBold(true);
        $sheet->mergeCells("B$detail_table_header_row:C" . ($detail_table_header_row + 2));
        $sheet->setCellValue("D$detail_table_header_row", 'Rute')->getStyle("D1")->applyFromArray($styleHeader)->getFont()->setSize(14)->setBold(true);
        $sheet->mergeCells("D$detail_table_header_row:D" . ($detail_table_header_row + 2));
        $sheet->setCellValue("E$detail_table_header_row", 'Qty')->getStyle("E1")->applyFromArray($styleHeader)->getFont()->setSize(14)->setBold(true);
        $sheet->mergeCells("E$detail_table_header_row:E" . ($detail_table_header_row + 2));
        $sheet->setCellValue("F$detail_table_header_row", 'Lokasi Muat')->getStyle("F1")->applyFromArray($styleHeader)->getFont()->setSize(14)->setBold(true);
        $sheet->mergeCells("F$detail_table_header_row:F" . ($detail_table_header_row + 2));
        $sheet->setCellValue("G$detail_table_header_row", 'No Container/Seal')->getStyle("G1")->applyFromArray($styleHeader)->getFont()->setSize(14)->setBold(true);
        $sheet->mergeCells("G$detail_table_header_row:G" . ($detail_table_header_row + 2));
        $sheet->setCellValue("H$detail_table_header_row", 'EMKL')->getStyle("H1")->applyFromArray($styleHeader)->getFont()->setSize(14)->setBold(true);
        $sheet->mergeCells("H$detail_table_header_row:H" . ($detail_table_header_row + 2));
        $sheet->setCellValue("I$detail_table_header_row", 'No SP')->getStyle("I1")->applyFromArray($styleHeader)->getFont()->setSize(14)->setBold(true);
        $sheet->mergeCells("I$detail_table_header_row:K$detail_table_header_row");
        $sheet->setCellValue("I" . ($detail_table_header_row + 1), 'Full')->getStyle("I2")->applyFromArray($styleHeader)->getFont()->setSize(14)->setBold(true);
        $sheet->mergeCells("I" . ($detail_table_header_row + 1) . ":I" . ($detail_table_header_row + 2));
        $sheet->setCellValue("J" . ($detail_table_header_row + 1), 'Empty')->getStyle("J2")->applyFromArray($styleHeader)->getFont()->setSize(14)->setBold(true);
        $sheet->mergeCells("J" . ($detail_table_header_row + 1) . ":J" . ($detail_table_header_row + 2));
        $sheet->setCellValue("K" . ($detail_table_header_row + 1), 'Full/Empty')->getStyle("K2")->applyFromArray($styleHeader)->getFont()->setSize(14)->setBold(true);
        $sheet->mergeCells("K" . ($detail_table_header_row + 1) . ":K" . ($detail_table_header_row + 2));
        $sheet->setCellValue("L$detail_table_header_row", 'No Job')->getStyle("L1")->applyFromArray($styleHeader)->getFont()->setSize(14)->setBold(true);
        $sheet->mergeCells("L$detail_table_header_row:L" . ($detail_table_header_row + 2));
        $sheet->setCellValue("M$detail_table_header_row", 'Omset')->getStyle("M1")->applyFromArray($styleHeader)->getFont()->setSize(14)->setBold(true);
        $sheet->mergeCells("M$detail_table_header_row:M" . ($detail_table_header_row + 2));
        $sheet->setCellValue("N$detail_table_header_row", 'Omset Tambahan')->getStyle("N1")->applyFromArray($styleHeader)->getFont()->setSize(14)->setBold(true);
        $sheet->mergeCells("N$detail_table_header_row:N" . ($detail_table_header_row + 2));
        $sheet->setCellValue("O$detail_table_header_row", 'Total Omset')->getStyle("O1")->applyFromArray($styleHeader)->getFont()->setSize(14)->setBold(true);
        $sheet->mergeCells("O$detail_table_header_row:O" . ($detail_table_header_row + 2));
        $sheet->setCellValue("P$detail_table_header_row", 'Omset Extra BBM')->getStyle("P1")->applyFromArray($styleHeader)->getFont()->setSize(14)->setBold(true);
        $sheet->mergeCells("P$detail_table_header_row:P" . ($detail_table_header_row + 2));
        $sheet->setCellValue("Q$detail_table_header_row", 'Inv')->getStyle("Q1")->applyFromArray($styleHeader)->getFont()->setSize(14)->setBold(true);
        $sheet->mergeCells("Q$detail_table_header_row:Q" . ($detail_table_header_row + 2));
        $sheet->setCellValue("R$detail_table_header_row", 'Biaya Operasional')->getStyle("R1")->applyFromArray($styleHeader)->getFont()->setSize(14)->setBold(true);
        $sheet->mergeCells("R$detail_table_header_row:AG$detail_table_header_row");
        $sheet->setCellValue("R" . ($detail_table_header_row + 1), 'Borongan')->getStyle("R2")->applyFromArray($styleHeader)->getFont()->setSize(14)->setBold(true);
        $sheet->mergeCells("R" . ($detail_table_header_row + 1) . ":R" . ($detail_table_header_row + 2));
        $sheet->setCellValue("S" . ($detail_table_header_row + 1), 'EBS')->getStyle("S2")->applyFromArray($styleHeader)->getFont()->setSize(14)->setBold(true);
        $sheet->mergeCells("S" . ($detail_table_header_row + 1) . ":S" . ($detail_table_header_row + 2));
        $sheet->setCellValue("T" . ($detail_table_header_row + 1), 'No Pengeluaran EBS')->getStyle("T2")->applyFromArray($styleHeader)->getFont()->setSize(14)->setBold(true);
        $sheet->mergeCells("T" . ($detail_table_header_row + 1) . ":T" . ($detail_table_header_row + 2));
        $sheet->setCellValue("U" . ($detail_table_header_row + 1), 'Voucher')->getStyle("U2")->applyFromArray($styleHeader)->getFont()->setSize(14)->setBold(true);
        $sheet->mergeCells("U" . ($detail_table_header_row + 1) . ":U" . ($detail_table_header_row + 2));
        $sheet->setCellValue("V" . ($detail_table_header_row + 1), 'No Voucher')->getStyle("V2")->applyFromArray($styleHeader)->getFont()->setSize(14)->setBold(true);
        $sheet->mergeCells("V" . ($detail_table_header_row + 1) . ":V" . ($detail_table_header_row + 2));
        $sheet->setCellValue("W" . ($detail_table_header_row + 1), 'Komisi Supir')->getStyle("W2")->applyFromArray($styleHeader)->getFont()->setSize(14)->setBold(true);
        $sheet->mergeCells("W" . ($detail_table_header_row + 1) . ":W" . ($detail_table_header_row + 2));
        $sheet->setCellValue("X" . ($detail_table_header_row + 1), 'Komisi Kenek ')->getStyle("X2")->applyFromArray($styleHeader)->getFont()->setSize(14)->setBold(true);
        $sheet->mergeCells("X" . ($detail_table_header_row + 1) . ":X" . ($detail_table_header_row + 2));

        $sheet->setCellValue("Y" . ($detail_table_header_row + 1), 'No Bukti Komisi')->getStyle("Y2")->applyFromArray($styleHeader)->getFont()->setSize(14)->setBold(true);
        $sheet->mergeCells("Y" . ($detail_table_header_row + 1) . ":Y" . ($detail_table_header_row + 2));
        $sheet->setCellValue("Z" . ($detail_table_header_row + 1), '')->getStyle("Z")->applyFromArray($styleHeader)->getFont()->setSize(14)->setBold(true);
        $sheet->mergeCells("Z" . ($detail_table_header_row + 1) . ":Z" . ($detail_table_header_row + 2));
        $sheet->setCellValue("AA" . ($detail_table_header_row + 1), 'G. Lain')->getStyle("AA2")->applyFromArray($styleHeader)->getFont()->setSize(14)->setBold(true);
        $sheet->mergeCells("AA" . ($detail_table_header_row + 1) . ":AA" . ($detail_table_header_row + 2));
        $sheet->setCellValue("AB" . ($detail_table_header_row + 1), 'G. LAIN')->getStyle("AB2")->applyFromArray($styleHeader)->getFont()->setSize(14)->setBold(true);
        $sheet->mergeCells("AB" . ($detail_table_header_row + 1) . ":AB" . ($detail_table_header_row + 2));
        $sheet->setCellValue("AC" . ($detail_table_header_row + 1), 'Ket')->getStyle("AC2")->applyFromArray($styleHeader)->getFont()->setSize(14)->setBold(true);
        $sheet->mergeCells("AC" . ($detail_table_header_row + 1) . ":AC" . ($detail_table_header_row + 2));

        $sheet->setCellValue("AD" . ($detail_table_header_row + 1), 'Rp')->getStyle("AD2")->applyFromArray($styleHeader)->getFont()->setSize(14)->setBold(true);
        $sheet->mergeCells("AD" . ($detail_table_header_row + 1) . ":AI" . ($detail_table_header_row + 1));
        $sheet->setCellValue("AD" . ($detail_table_header_row + 2), 'Tol')->getStyle("AD3")->applyFromArray($styleHeader)->getFont()->setSize(14)->setBold(true);
        $sheet->mergeCells("AD" . ($detail_table_header_row + 2) . ":AD" . ($detail_table_header_row + 2));
        $sheet->setCellValue("AF" . ($detail_table_header_row + 2), '')->getStyle("AF3")->applyFromArray($styleHeader)->getFont()->setSize(14)->setBold(true);
        $sheet->mergeCells("AF" . ($detail_table_header_row + 2) . ":AF" . ($detail_table_header_row + 2));
        $sheet->setCellValue("AG" . ($detail_table_header_row + 2), 'Ritasi')->getStyle("AG3")->applyFromArray($styleHeader)->getFont()->setSize(14)->setBold(true);
        $sheet->mergeCells("AG" . ($detail_table_header_row + 2) . ":AG" . ($detail_table_header_row + 2));
        $sheet->setCellValue("AH" . ($detail_table_header_row + 2), 'Extra Bbm')->getStyle("AH3")->applyFromArray($styleHeader)->getFont()->setSize(14)->setBold(true);
        $sheet->mergeCells("AH" . ($detail_table_header_row + 2) . ":AH" . ($detail_table_header_row + 2));
        $sheet->setCellValue("AI" . ($detail_table_header_row + 2), 'Ket')->getStyle("AI3")->applyFromArray($styleHeader)->getFont()->setSize(14)->setBold(true);
        $sheet->mergeCells("AI" . ($detail_table_header_row + 2) . ":AI" . ($detail_table_header_row + 2));
        $sheet->setCellValue("AJ$detail_table_header_row", 'Biaya')->getStyle("AJ1")->applyFromArray($styleHeader)->getFont()->setSize(14)->setBold(true);
        $sheet->mergeCells("AJ" . ($detail_table_header_row) . ":AK" . ($detail_table_header_row));
        $sheet->setCellValue("AJ" . ($detail_table_header_row + 1), 'Kas Gantung Supir')->getStyle("AJ2")->applyFromArray($styleHeader)->getFont()->setSize(14)->setBold(true);
        $sheet->mergeCells("AJ" . ($detail_table_header_row + 1) . ":AJ" . ($detail_table_header_row + 2));
        $sheet->setCellValue("AK" . ($detail_table_header_row + 1), '')->getStyle("AK2")->applyFromArray($styleHeader)->getFont()->setSize(14)->setBold(true);
        $sheet->mergeCells("AK" . ($detail_table_header_row + 1) . ":AK" . ($detail_table_header_row + 2));
        $sheet->setCellValue("AL" . ($detail_table_header_row + 1), '')->getStyle("AL2")->applyFromArray($styleHeader)->getFont()->setSize(14)->setBold(true);
        $sheet->mergeCells("AL" . ($detail_table_header_row + 1) . ":AL" . ($detail_table_header_row + 2));
        $sheet->setCellValue("AM$detail_table_header_row", 'Total Biaya')->getStyle("AM1")->applyFromArray($styleHeader)->getFont()->setSize(14)->setBold(true);
        $sheet->mergeCells("AM$detail_table_header_row:AM" . ($detail_table_header_row + 2));
        $sheet->setCellValue("AN$detail_table_header_row", 'Laba')->getStyle("AN1")->applyFromArray($styleHeader)->getFont()->setSize(14)->setBold(true);
        $sheet->mergeCells("AN$detail_table_header_row:AN" . ($detail_table_header_row + 2));
        $sheet->setCellValue("AO$detail_table_header_row", 'No Trip')->getStyle("AO1")->applyFromArray($styleHeader)->getFont()->setSize(14)->setBold(true);
        $sheet->mergeCells("AO$detail_table_header_row:AO" . ($detail_table_header_row + 2));
        $sheet->setCellValue("AP$detail_table_header_row", 'Bongkar/Muat')->getStyle("AP1")->applyFromArray($styleHeader)->getFont()->setSize(14)->setBold(true);
        $sheet->mergeCells("AP$detail_table_header_row:AP" . ($detail_table_header_row + 2));
        $sheet->setCellValue("AQ$detail_table_header_row", 'Panjar')->getStyle("AQ1")->applyFromArray($styleHeader)->getFont()->setSize(14)->setBold(true);
        $sheet->mergeCells("AQ$detail_table_header_row:AQ" . ($detail_table_header_row + 2));
        $sheet->setCellValue("AR$detail_table_header_row", 'Liter')->getStyle("AR1")->applyFromArray($styleHeader)->getFont()->setSize(14)->setBold(true);
        $sheet->mergeCells("AR$detail_table_header_row:AR" . ($detail_table_header_row + 2));
        $sheet->setCellValue("AS$detail_table_header_row", 'Mandor Supir')->getStyle("AS1")->applyFromArray($styleHeader)->getFont()->setSize(14)->setBold(true);
        $sheet->mergeCells("AS$detail_table_header_row:AS" . ($detail_table_header_row + 2));
        $sheet->getStyle("AS$detail_table_header_row")->getAlignment()->setWrapText(true);
        $sheet->setCellValue("AT$detail_table_header_row", 'Mandor Trado')->getStyle("AT1")->applyFromArray($styleHeader)->getFont()->setSize(14)->setBold(true);
        $sheet->mergeCells("AT$detail_table_header_row:AT" . ($detail_table_header_row + 2));
        $sheet->getStyle("AT$detail_table_header_row")->getAlignment()->setWrapText(true);


        $rowIndex = 4;
        $previous_nopol = null;
        // $group = [];
        $groupRowCount = 0;
        $sheet->setCellValue("A4", "periode : " . $request->dari . " s/d " . $request->sampai);
        foreach ($data as $response_index => $response_detail) {
            $nopol = $response_detail['nopol'];

            if ($nopol != $previous_nopol) {
                if ($previous_nopol !== null) {
                    // $rowIndex++; // Move to the next row
                    // $sheet->setCellValue("A$rowIndex", 'Total')->getStyle("A$rowIndex")->applyFromArray($styleHeader)->getFont()->setBold(true);

                    // Calculate the total for the previous group and set it in the next column
                    $startTotalIndex = $rowIndex - $groupRowCount;
                    $endTotalIndex = $rowIndex - 1;

                    $sheet->setCellValue("M$rowIndex", "=SUM(M$startTotalIndex:M$endTotalIndex)")->getStyle("M$rowIndex")->applyFromArray($styleArray2)->getNumberFormat()->setFormatCode("#,##0.00_);(#,##0.00)");
                    $sheet->setCellValue("N$rowIndex", "=SUM(N$startTotalIndex:N$endTotalIndex)")->getStyle("N$rowIndex")->applyFromArray($styleArray2)->getNumberFormat()->setFormatCode("#,##0.00_);(#,##0.00)");
                    $sheet->setCellValue("O$rowIndex", "=SUM(O$startTotalIndex:O$endTotalIndex)")->getStyle("O$rowIndex")->applyFromArray($styleArray2)->getNumberFormat()->setFormatCode("#,##0.00_);(#,##0.00)");
                    $sheet->setCellValue("R$rowIndex", "=SUM(R$startTotalIndex:R$endTotalIndex)")->getStyle("R$rowIndex")->applyFromArray($styleArray2)->getNumberFormat()->setFormatCode("#,##0.00_);(#,##0.00)");
                    $sheet->setCellValue("U$rowIndex", "=SUM(U$startTotalIndex:U$endTotalIndex)")->getStyle("U$rowIndex")->applyFromArray($styleArray2)->getNumberFormat()->setFormatCode("#,##0.00_);(#,##0.00)");
                    $sheet->setCellValue("W$rowIndex", "=SUM(W$startTotalIndex:W$endTotalIndex)")->getStyle("W$rowIndex")->applyFromArray($styleArray2)->getNumberFormat()->setFormatCode("#,##0.00_);(#,##0.00)");
                    $sheet->setCellValue("X$rowIndex", "=SUM(X$startTotalIndex:X$endTotalIndex)")->getStyle("X$rowIndex")->applyFromArray($styleArray2)->getNumberFormat()->setFormatCode("#,##0.00_);(#,##0.00)");
                    $sheet->setCellValue("AB$rowIndex", "=SUM(AB$startTotalIndex:AB$endTotalIndex)")->getStyle("AB$rowIndex")->applyFromArray($styleArray2)->getNumberFormat()->setFormatCode("#,##0.00_);(#,##0.00)");
                    $sheet->setCellValue("Z$rowIndex", "=SUM(Z$startTotalIndex:Z$endTotalIndex)")->getStyle("Z$rowIndex")->applyFromArray($styleArray2)->getNumberFormat()->setFormatCode("#,##0.00_);(#,##0.00)");
                    $sheet->setCellValue("AA$rowIndex", "=SUM(AA$startTotalIndex:AA$endTotalIndex)")->getStyle("AA$rowIndex")->applyFromArray($styleArray2)->getNumberFormat()->setFormatCode("#,##0.00_);(#,##0.00)");
                    $sheet->setCellValue("AD$rowIndex", "=SUM(AD$startTotalIndex:AD$endTotalIndex)")->getStyle("AD$rowIndex")->applyFromArray($styleArray2)->getNumberFormat()->setFormatCode("#,##0.00_);(#,##0.00)");
                    $sheet->setCellValue("AE$rowIndex", "=SUM(AE$startTotalIndex:AE$endTotalIndex)")->getStyle("AE$rowIndex")->applyFromArray($styleArray2)->getNumberFormat()->setFormatCode("#,##0.00_);(#,##0.00)");
                    $sheet->setCellValue("AG$rowIndex", "=SUM(AG$startTotalIndex:AG$endTotalIndex)")->getStyle("AG$rowIndex")->applyFromArray($styleArray2)->getNumberFormat()->setFormatCode("#,##0.00_);(#,##0.00)");
                    $sheet->setCellValue("AH$rowIndex", "=SUM(AH$startTotalIndex:AH$endTotalIndex)")->getStyle("AH$rowIndex")->applyFromArray($styleArray2)->getNumberFormat()->setFormatCode("#,##0.00_);(#,##0.00)");
                    $sheet->setCellValue("AJ$rowIndex", "=SUM(AJ$startTotalIndex:AJ$endTotalIndex)")->getStyle("AJ$rowIndex")->applyFromArray($styleArray2)->getNumberFormat()->setFormatCode("#,##0.00_);(#,##0.00)");
                    $sheet->setCellValue("AK$rowIndex", "=SUM(AK$startTotalIndex:AK$endTotalIndex)")->getStyle("AK$rowIndex")->applyFromArray($styleArray2)->getNumberFormat()->setFormatCode("#,##0.00_);(#,##0.00)");
                    $sheet->setCellValue("AL$rowIndex", "=SUM(AL$startTotalIndex:AL$endTotalIndex)")->getStyle("AL$rowIndex")->applyFromArray($styleArray2)->getNumberFormat()->setFormatCode("#,##0.00_);(#,##0.00)");
                    $sheet->setCellValue("AM$rowIndex", "=SUM(AM$startTotalIndex:AM$endTotalIndex)")->getStyle("AM$rowIndex")->applyFromArray($styleArray2)->getNumberFormat()->setFormatCode("#,##0.00_);(#,##0.00)");
                    $sheet->setCellValue("AN$rowIndex", "=O$rowIndex-AM$rowIndex")->getStyle("AN$rowIndex")->applyFromArray($styleArray2)->getNumberFormat()->setFormatCode("#,##0.00_);(#,##0.00)");
                    $groupRowCount = 0;
                    $rowIndex++;
                    $rowIndex++; // Move to the next row
                }
                $sheet->setCellValue("C$rowIndex", $nopol);
                $rowIndex++;

                // Store the starting row index of the current group
                $groupStartIndex = $rowIndex;
            }
            $dateValue = ($response_detail['tglbukti'] != null) ? Date::PHPToExcel(date('Y-m-d', strtotime($response_detail['tglbukti']))) : '';

            $sheet->setCellValue("A$rowIndex", $dateValue);
            $sheet->getStyle("A$rowIndex")->getNumberFormat()->setFormatCode('dd-mm-yyyy');
            $sheet->setCellValue("C$rowIndex", $response_detail['namasupir']);
            $sheet->setCellValue("D$rowIndex", $response_detail['rute']);
            $sheet->setCellValue("E$rowIndex", $response_detail['qty']);
            $sheet->setCellValue("F$rowIndex", $response_detail['lokasimuat']);
            $sheet->setCellValue("G$rowIndex", $response_detail['nocontseal']);
            $sheet->setCellValue("H$rowIndex", $response_detail['emkl']);
            $sheet->setCellValue("I$rowIndex", $response_detail['spfull']);
            $sheet->setCellValue("J$rowIndex", $response_detail['spempty']);
            $sheet->setCellValue("K$rowIndex", $response_detail['spfullempty']);
            $sheet->setCellValue("L$rowIndex", $response_detail['jobtrucking']);
            $sheet->setCellValue("M$rowIndex", $response_detail['omset'])->getStyle("M$rowIndex")->applyFromArray($style_number)->getNumberFormat()->setFormatCode("#,##0.00_);(#,##0.00)");
            $sheet->setCellValue("N$rowIndex", $response_detail['omsettambahan'])->getStyle("N$rowIndex")->applyFromArray($style_number)->getNumberFormat()->setFormatCode("#,##0.00_);(#,##0.00)");
            $sheet->setCellValue("O$rowIndex", "=(M$rowIndex+N$rowIndex)")->getStyle("O$rowIndex")->applyFromArray($style_number)->getNumberFormat()->setFormatCode("#,##0.00_);(#,##0.00)");
            $sheet->setCellValue("P$rowIndex", $response_detail['omsetextrabbm'])->getStyle("P$rowIndex")->applyFromArray($style_number)->getNumberFormat()->setFormatCode("#,##0.00_);(#,##0.00)");
            $sheet->setCellValue("Q$rowIndex", $response_detail['invoice']);
            $sheet->setCellValue("R$rowIndex", $response_detail['borongan'])->getStyle("R$rowIndex")->applyFromArray($style_number)->getNumberFormat()->setFormatCode("#,##0.00_);(#,##0.00)");
            $sheet->setCellValue("S$rowIndex", $response_detail['nobuktiebs']);
            $sheet->setCellValue("T$rowIndex", $response_detail['pengeluarannobuktiebs']);
            $sheet->setCellValue("U$rowIndex", $response_detail['voucher'])->getStyle("U$rowIndex")->applyFromArray($style_number)->getNumberFormat()->setFormatCode("#,##0.00_);(#,##0.00)");
            $sheet->setCellValue("V$rowIndex", $response_detail['novoucher']);
            $sheet->setCellValue("W$rowIndex", $response_detail['komisi'])->getStyle("W$rowIndex")->applyFromArray($style_number)->getNumberFormat()->setFormatCode("#,##0.00_);(#,##0.00)");
            $sheet->setCellValue("X$rowIndex", $response_detail['gajikenek'])->getStyle("X$rowIndex")->applyFromArray($style_number)->getNumberFormat()->setFormatCode("#,##0.00_);(#,##0.00)");

            $sheet->setCellValue("Y$rowIndex", $response_detail['nobuktikbtkomisi']);
            $sheet->setCellValue("Z$rowIndex", $response_detail['gajimingguan'])->getStyle("Z$rowIndex")->applyFromArray($style_number)->getNumberFormat()->setFormatCode("#,##0.00_);(#,##0.00)");
            $sheet->setCellValue("AA$rowIndex", $response_detail['gajilain'])->getStyle("AA$rowIndex")->applyFromArray($style_number)->getNumberFormat()->setFormatCode("#,##0.00_);(#,##0.00)");
            $sheet->setCellValue("AB$rowIndex", $response_detail['uanglain'])->getStyle("AB$rowIndex")->applyFromArray($style_number)->getNumberFormat()->setFormatCode("#,##0.00_);(#,##0.00)");
            $sheet->setCellValue("AC$rowIndex", $response_detail['ket']);

            $sheet->setCellValue("AD$rowIndex", $response_detail['tolsupir'])->getStyle("AD$rowIndex")->applyFromArray($style_number)->getNumberFormat()->setFormatCode("#,##0.00_);(#,##0.00)");
            $sheet->setCellValue("AE$rowIndex", $response_detail['uangbon'])->getStyle("AE$rowIndex")->applyFromArray($style_number)->getNumberFormat()->setFormatCode("#,##0.00_);(#,##0.00)");
            $sheet->setCellValue("AF$rowIndex", $response_detail['nobuktikbtebs2']);
            $sheet->setCellValue("AG$rowIndex", $response_detail['ritasi'])->getStyle("AG$rowIndex")->applyFromArray($style_number)->getNumberFormat()->setFormatCode("#,##0.00_);(#,##0.00)");
            $sheet->setCellValue("AH$rowIndex", $response_detail['extrabbm'])->getStyle("AH$rowIndex")->applyFromArray($style_number)->getNumberFormat()->setFormatCode("#,##0.00_);(#,##0.00)");
            $sheet->setCellValue("AI$rowIndex", $response_detail['ketuanglain']);
            $sheet->setCellValue("AJ$rowIndex", $response_detail['uangjalan'])->getStyle("AJ$rowIndex")->applyFromArray($style_number)->getNumberFormat()->setFormatCode("#,##0.00_);(#,##0.00)");
            $sheet->setCellValue("AK$rowIndex", $response_detail['uangbbm'])->getStyle("AK$rowIndex")->applyFromArray($style_number)->getNumberFormat()->setFormatCode("#,##0.00_);(#,##0.00)");
            $sheet->setCellValue("AL$rowIndex", $response_detail['uangmakan'])->getStyle("AL$rowIndex")->applyFromArray($style_number)->getNumberFormat()->setFormatCode("#,##0.00_);(#,##0.00)");
            $sheet->setCellValue("AM$rowIndex", $response_detail['totalbiaya'])->getStyle("AM$rowIndex")->applyFromArray($style_number)->getNumberFormat()->setFormatCode("#,##0.00_);(#,##0.00)");
            $sheet->setCellValue("AN$rowIndex", "=O$rowIndex-AM$rowIndex")->getStyle("AN$rowIndex")->applyFromArray($style_number)->getNumberFormat()->setFormatCode("#,##0.00_);(#,##0.00)");
            $sheet->setCellValue("AO$rowIndex", $response_detail['nobukti']);
            $sheet->setCellValue("AP$rowIndex", $response_detail['bongkarmuat'])->getStyle("AP$rowIndex")->applyFromArray($style_number)->getNumberFormat()->setFormatCode("#,##0.00_);(#,##0.00)");
            $sheet->setCellValue("AQ$rowIndex", $response_detail['panjar']);
            $sheet->setCellValue("AR$rowIndex", $response_detail['liter'])->getStyle("AR$rowIndex")->applyFromArray($style_number)->getNumberFormat()->setFormatCode("#,##0.00_);(#,##0.00)");
            $sheet->setCellValue("AS$rowIndex", $response_detail['mandorsupir']);
            $sheet->setCellValue("AT$rowIndex", $response_detail['mandortrado']);

            $rowIndex++;

            // Store the current group details in an array
            $group[] = $response_detail;
            $sheet->getColumnDimension('A')->setWidth(12);
            $previous_nopol = $nopol;
            $groupRowCount++;
        }

        // Add total and calculate the total for the last group
        if ($previous_nopol !== null) {
            // $rowIndex++;
            // $sheet->setCellValue("A$rowIndex", 'Total')->getStyle("A$rowIndex")->applyFromArray($styleHeader)->getFont()->setBold(true);

            $startTotalIndex = $groupStartIndex;
            $endTotalIndex = $rowIndex - 1;

            $sheet->setCellValue("M$rowIndex", "=SUM(M$startTotalIndex:M$endTotalIndex)")->getStyle("M$rowIndex")->applyFromArray($styleArray2)->getNumberFormat()->setFormatCode("#,##0.00_);(#,##0.00)");
            $sheet->setCellValue("N$rowIndex", "=SUM(N$startTotalIndex:N$endTotalIndex)")->getStyle("N$rowIndex")->applyFromArray($styleArray2)->getNumberFormat()->setFormatCode("#,##0.00_);(#,##0.00)");
            $sheet->setCellValue("O$rowIndex", "=SUM(O$startTotalIndex:O$endTotalIndex)")->getStyle("O$rowIndex")->applyFromArray($styleArray2)->getNumberFormat()->setFormatCode("#,##0.00_);(#,##0.00)");
            $sheet->setCellValue("R$rowIndex", "=SUM(R$startTotalIndex:R$endTotalIndex)")->getStyle("R$rowIndex")->applyFromArray($styleArray2)->getNumberFormat()->setFormatCode("#,##0.00_);(#,##0.00)");
            $sheet->setCellValue("U$rowIndex", "=SUM(U$startTotalIndex:U$endTotalIndex)")->getStyle("U$rowIndex")->applyFromArray($styleArray2)->getNumberFormat()->setFormatCode("#,##0.00_);(#,##0.00)");
            $sheet->setCellValue("W$rowIndex", "=SUM(W$startTotalIndex:W$endTotalIndex)")->getStyle("W$rowIndex")->applyFromArray($styleArray2)->getNumberFormat()->setFormatCode("#,##0.00_);(#,##0.00)");
            $sheet->setCellValue("X$rowIndex", "=SUM(X$startTotalIndex:X$endTotalIndex)")->getStyle("X$rowIndex")->applyFromArray($styleArray2)->getNumberFormat()->setFormatCode("#,##0.00_);(#,##0.00)");
            $sheet->setCellValue("AB$rowIndex", "=SUM(AB$startTotalIndex:AB$endTotalIndex)")->getStyle("AB$rowIndex")->applyFromArray($styleArray2)->getNumberFormat()->setFormatCode("#,##0.00_);(#,##0.00)");
            $sheet->setCellValue("Z$rowIndex", "=SUM(Z$startTotalIndex:Z$endTotalIndex)")->getStyle("Z$rowIndex")->applyFromArray($styleArray2)->getNumberFormat()->setFormatCode("#,##0.00_);(#,##0.00)");
            $sheet->setCellValue("AA$rowIndex", "=SUM(AA$startTotalIndex:AA$endTotalIndex)")->getStyle("AA$rowIndex")->applyFromArray($styleArray2)->getNumberFormat()->setFormatCode("#,##0.00_);(#,##0.00)");
            $sheet->setCellValue("AD$rowIndex", "=SUM(AD$startTotalIndex:AD$endTotalIndex)")->getStyle("AD$rowIndex")->applyFromArray($styleArray2)->getNumberFormat()->setFormatCode("#,##0.00_);(#,##0.00)");
            $sheet->setCellValue("AE$rowIndex", "=SUM(AE$startTotalIndex:AE$endTotalIndex)")->getStyle("AE$rowIndex")->applyFromArray($styleArray2)->getNumberFormat()->setFormatCode("#,##0.00_);(#,##0.00)");
            $sheet->setCellValue("AG$rowIndex", "=SUM(AG$startTotalIndex:AG$endTotalIndex)")->getStyle("AG$rowIndex")->applyFromArray($styleArray2)->getNumberFormat()->setFormatCode("#,##0.00_);(#,##0.00)");
            $sheet->setCellValue("AH$rowIndex", "=SUM(AH$startTotalIndex:AH$endTotalIndex)")->getStyle("AH$rowIndex")->applyFromArray($styleArray2)->getNumberFormat()->setFormatCode("#,##0.00_);(#,##0.00)");
            $sheet->setCellValue("AJ$rowIndex", "=SUM(AJ$startTotalIndex:AJ$endTotalIndex)")->getStyle("AJ$rowIndex")->applyFromArray($styleArray2)->getNumberFormat()->setFormatCode("#,##0.00_);(#,##0.00)");
            $sheet->setCellValue("AK$rowIndex", "=SUM(AK$startTotalIndex:AK$endTotalIndex)")->getStyle("AK$rowIndex")->applyFromArray($styleArray2)->getNumberFormat()->setFormatCode("#,##0.00_);(#,##0.00)");
            $sheet->setCellValue("AL$rowIndex", "=SUM(AL$startTotalIndex:AL$endTotalIndex)")->getStyle("AL$rowIndex")->applyFromArray($styleArray2)->getNumberFormat()->setFormatCode("#,##0.00_);(#,##0.00)");
            $sheet->setCellValue("AM$rowIndex", "=SUM(AM$startTotalIndex:AM$endTotalIndex)")->getStyle("AM$rowIndex")->applyFromArray($styleArray2)->getNumberFormat()->setFormatCode("#,##0.00_);(#,##0.00)");
            $sheet->setCellValue("AN$rowIndex", "=SUM(O$rowIndex-AM$rowIndex)")->getStyle("AN$rowIndex")->applyFromArray($styleArray2)->getNumberFormat()->setFormatCode("#,##0.00_);(#,##0.00)");
        }
        $sheet->getColumnDimension('B')->setAutoSize(true);
        $sheet->getColumnDimension('C')->setAutoSize(true);
        $sheet->getColumnDimension('D')->setAutoSize(true);
        $sheet->getColumnDimension('E')->setAutoSize(true);
        $sheet->getColumnDimension('F')->setAutoSize(true);
        $sheet->getColumnDimension('G')->setAutoSize(true);
        $sheet->getColumnDimension('H')->setAutoSize(true);
        $sheet->getColumnDimension('I')->setAutoSize(true);
        $sheet->getColumnDimension('J')->setAutoSize(true);
        $sheet->getColumnDimension('K')->setAutoSize(true);
        $sheet->getColumnDimension('L')->setAutoSize(true);
        $sheet->getColumnDimension('M')->setAutoSize(true);
        $sheet->getColumnDimension('N')->setAutoSize(true);
        $sheet->getColumnDimension('O')->setAutoSize(true);
        $sheet->getColumnDimension('P')->setAutoSize(true);
        $sheet->getColumnDimension('Q')->setAutoSize(true);
        $sheet->getColumnDimension('R')->setAutoSize(true);
        $sheet->getColumnDimension('S')->setAutoSize(true);
        $sheet->getColumnDimension('T')->setAutoSize(true);
        $sheet->getColumnDimension('U')->setAutoSize(true);
        $sheet->getColumnDimension('V')->setAutoSize(true);
        $sheet->getColumnDimension('W')->setAutoSize(true);
        $sheet->getColumnDimension('X')->setAutoSize(true);
        $sheet->getColumnDimension('Y')->setAutoSize(true);
        $sheet->getColumnDimension('Z')->setAutoSize(true);
        $sheet->getColumnDimension('AA')->setAutoSize(true);
        $sheet->getColumnDimension('AB')->setAutoSize(true);
        $sheet->getColumnDimension('AC')->setAutoSize(true);
        $sheet->getColumnDimension('AD')->setAutoSize(true);
        $sheet->getColumnDimension('AE')->setAutoSize(true);
        $sheet->getColumnDimension('AF')->setAutoSize(true);
        $sheet->getColumnDimension('AG')->setAutoSize(true);
        $sheet->getColumnDimension('AH')->setAutoSize(true);
        $sheet->getColumnDimension('AI')->setAutoSize(true);
        $sheet->getColumnDimension('AJ')->setAutoSize(true);
        $sheet->getColumnDimension('AK')->setAutoSize(true);
        $sheet->getColumnDimension('AL')->setAutoSize(true);
        $sheet->getColumnDimension('AM')->setAutoSize(true);
        $sheet->getColumnDimension('AN')->setAutoSize(true);
        $sheet->getColumnDimension('AO')->setAutoSize(true);
        $sheet->getColumnDimension('AP')->setAutoSize(true);
        $sheet->getColumnDimension('AQ')->setAutoSize(true);
        $sheet->getColumnDimension('AR')->setAutoSize(true);



        $writer = new Xlsx($spreadsheet);
        $filename = 'LAPORAN MINGGUAN SUPIR (BEDA MANDOR)' . date('dmYHis');
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }
}

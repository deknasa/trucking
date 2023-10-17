<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class ExportLaporanMingguanSupirController extends Controller
{
    public $title = 'Export Laporan Mingguan Supir';

    public function index(Request $request)
    {
        $title = $this->title;
        $data = [
            'pagename' => 'Menu Utama Export Laporan Mingguan Supir',
        ];

        return view('exportlaporanmingguansupir.index', compact('title'));
    }

    public function export1($data, $dari,$sampai,$tradodari_id,$tradosampai_id,$tradodari,$tradosampai)
    {

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
        $sheet->setCellValue("O$detail_table_header_row", 'Omset Extra BBM')->getStyle("O1")->applyFromArray($styleHeader)->getFont()->setSize(14)->setBold(true);
        $sheet->mergeCells("O$detail_table_header_row:N" . ($detail_table_header_row + 2));
        $sheet->setCellValue("P$detail_table_header_row", 'Inv')->getStyle("P1")->applyFromArray($styleHeader)->getFont()->setSize(14)->setBold(true);
        $sheet->mergeCells("P$detail_table_header_row:O" . ($detail_table_header_row + 2));
        $sheet->setCellValue("Q$detail_table_header_row", 'Gaji')->getStyle("Q1")->applyFromArray($styleHeader)->getFont()->setSize(14)->setBold(true);
        $sheet->mergeCells("Q$detail_table_header_row:AG$detail_table_header_row");
        $sheet->setCellValue("R" . ($detail_table_header_row + 1), 'Borongan')->getStyle("R2")->applyFromArray($styleHeader)->getFont()->setSize(14)->setBold(true);
        $sheet->mergeCells("R" . ($detail_table_header_row + 1) . ":R" . ($detail_table_header_row + 2));
        $sheet->setCellValue("R" . ($detail_table_header_row + 1), 'EBS')->getStyle("R2")->applyFromArray($styleHeader)->getFont()->setSize(14)->setBold(true);
        $sheet->mergeCells("R" . ($detail_table_header_row + 1) . ":R" . ($detail_table_header_row + 2));
        $sheet->setCellValue("S" . ($detail_table_header_row + 1), 'No Pengeluaran EBS')->getStyle("S2")->applyFromArray($styleHeader)->getFont()->setSize(14)->setBold(true);
        $sheet->mergeCells("S" . ($detail_table_header_row + 1) . ":S" . ($detail_table_header_row + 2));
        $sheet->setCellValue("T" . ($detail_table_header_row + 1), 'Voucher')->getStyle("T2")->applyFromArray($styleHeader)->getFont()->setSize(14)->setBold(true);
        $sheet->mergeCells("T" . ($detail_table_header_row + 1) . ":T" . ($detail_table_header_row + 2));
        $sheet->setCellValue("U" . ($detail_table_header_row + 1), 'No Voucher')->getStyle("U2")->applyFromArray($styleHeader)->getFont()->setSize(14)->setBold(true);
        $sheet->mergeCells("U" . ($detail_table_header_row + 1) . ":U" . ($detail_table_header_row + 2));
        $sheet->setCellValue("V" . ($detail_table_header_row + 1), 'G. Supir')->getStyle("V2")->applyFromArray($styleHeader)->getFont()->setSize(14)->setBold(true);
        $sheet->mergeCells("V" . ($detail_table_header_row + 1) . ":V" . ($detail_table_header_row + 2));
        $sheet->setCellValue("W" . ($detail_table_header_row + 1), 'Komisi')->getStyle("W2")->applyFromArray($styleHeader)->getFont()->setSize(14)->setBold(true);
        $sheet->mergeCells("W" . ($detail_table_header_row + 1) . ":W" . ($detail_table_header_row + 2));
        $sheet->setCellValue("X" . ($detail_table_header_row + 1), 'G. Kernek')->getStyle("X2")->applyFromArray($styleHeader)->getFont()->setSize(14)->setBold(true);
        $sheet->mergeCells("X" . ($detail_table_header_row + 1) . ":X" . ($detail_table_header_row + 2));
        $sheet->setCellValue("Y" . ($detail_table_header_row + 1), 'G. Mingguan')->getStyle("Y2")->applyFromArray($styleHeader)->getFont()->setSize(14)->setBold(true);
        $sheet->mergeCells("Y" . ($detail_table_header_row + 1) . ":Y" . ($detail_table_header_row + 2));
        $sheet->setCellValue("Z" . ($detail_table_header_row + 1), 'G. LAIN')->getStyle("Z2")->applyFromArray($styleHeader)->getFont()->setSize(14)->setBold(true);
        $sheet->mergeCells("Z" . ($detail_table_header_row + 1) . ":Z" . ($detail_table_header_row + 2));
        $sheet->setCellValue("AA" . ($detail_table_header_row + 1), 'Ket')->getStyle("AA2")->applyFromArray($styleHeader)->getFont()->setSize(14)->setBold(true);
        $sheet->mergeCells("AA" . ($detail_table_header_row + 1) . ":AA" . ($detail_table_header_row + 2));
        $sheet->setCellValue("AB" . ($detail_table_header_row + 1), 'No Bukti Komisi')->getStyle("AB2")->applyFromArray($styleHeader)->getFont()->setSize(14)->setBold(true);
        $sheet->mergeCells("AB" . ($detail_table_header_row + 1) . ":AB" . ($detail_table_header_row + 2));
        $sheet->setCellValue("AC" . ($detail_table_header_row + 1), 'Lain')->getStyle("AC2")->applyFromArray($styleHeader)->getFont()->setSize(14)->setBold(true);
        $sheet->mergeCells("AC" . ($detail_table_header_row + 1) . ":AH" . ($detail_table_header_row + 1));
        $sheet->setCellValue("AC" . ($detail_table_header_row + 2), 'U. Lain')->getStyle("AC3")->applyFromArray($styleHeader)->getFont()->setSize(14)->setBold(true);
        $sheet->mergeCells("AC" . ($detail_table_header_row + 2) . ":AC" . ($detail_table_header_row + 2));
        $sheet->setCellValue("AD" . ($detail_table_header_row + 2), 'U. Bon')->getStyle("AD3")->applyFromArray($styleHeader)->getFont()->setSize(14)->setBold(true);
        $sheet->mergeCells("AD" . ($detail_table_header_row + 2) . ":AD" . ($detail_table_header_row + 2));
        $sheet->setCellValue("AE" . ($detail_table_header_row + 2), 'No Bukti KBT EBS2')->getStyle("AE3")->applyFromArray($styleHeader)->getFont()->setSize(14)->setBold(true);
        $sheet->mergeCells("AE" . ($detail_table_header_row + 2) . ":AE" . ($detail_table_header_row + 2));
        $sheet->setCellValue("AF" . ($detail_table_header_row + 2), 'Ritasi')->getStyle("AF3")->applyFromArray($styleHeader)->getFont()->setSize(14)->setBold(true);
        $sheet->mergeCells("AF" . ($detail_table_header_row + 2) . ":AF" . ($detail_table_header_row + 2));
        $sheet->setCellValue("AG" . ($detail_table_header_row + 2), 'Extra Bbm')->getStyle("AG3")->applyFromArray($styleHeader)->getFont()->setSize(14)->setBold(true);
        $sheet->mergeCells("AG" . ($detail_table_header_row + 2) . ":AG" . ($detail_table_header_row + 2));
        $sheet->setCellValue("AH" . ($detail_table_header_row + 2), 'Ket')->getStyle("AH3")->applyFromArray($styleHeader)->getFont()->setSize(14)->setBold(true);
        $sheet->mergeCells("AH" . ($detail_table_header_row + 2) . ":AH" . ($detail_table_header_row + 2));
        $sheet->setCellValue("AI$detail_table_header_row", 'Biaya')->getStyle("AI1")->applyFromArray($styleHeader)->getFont()->setSize(14)->setBold(true);
        $sheet->mergeCells("AI" . ($detail_table_header_row) . ":AJ" . ($detail_table_header_row));
        $sheet->setCellValue("AI" . ($detail_table_header_row + 1), 'Uang Jalan')->getStyle("AI2")->applyFromArray($styleHeader)->getFont()->setSize(14)->setBold(true);
        $sheet->mergeCells("AI" . ($detail_table_header_row + 1) . ":AI" . ($detail_table_header_row + 2));
        $sheet->setCellValue("AJ" . ($detail_table_header_row + 1), 'BBM')->getStyle("AJ2")->applyFromArray($styleHeader)->getFont()->setSize(14)->setBold(true);
        $sheet->mergeCells("AJ" . ($detail_table_header_row + 1) . ":AJ" . ($detail_table_header_row + 2));
        $sheet->setCellValue("AK" . ($detail_table_header_row + 1), 'Uang Makan')->getStyle("AK2")->applyFromArray($styleHeader)->getFont()->setSize(14)->setBold(true);
        $sheet->mergeCells("AK" . ($detail_table_header_row + 1) . ":AK" . ($detail_table_header_row + 2));
        $sheet->setCellValue("AL$detail_table_header_row", 'Total Biaya')->getStyle("AL1")->applyFromArray($styleHeader)->getFont()->setSize(14)->setBold(true);
        $sheet->mergeCells("AL$detail_table_header_row:AL" . ($detail_table_header_row + 2));
        $sheet->setCellValue("AM$detail_table_header_row", 'Sisa')->getStyle("AM1")->applyFromArray($styleHeader)->getFont()->setSize(14)->setBold(true);
        $sheet->mergeCells("AM$detail_table_header_row:AM" . ($detail_table_header_row + 2));
        $sheet->setCellValue("AN$detail_table_header_row", 'No Trip')->getStyle("AN1")->applyFromArray($styleHeader)->getFont()->setSize(14)->setBold(true);
        $sheet->mergeCells("AN$detail_table_header_row:AN" . ($detail_table_header_row + 2));
        $sheet->setCellValue("AO$detail_table_header_row", 'Bongkar/Muat')->getStyle("AO1")->applyFromArray($styleHeader)->getFont()->setSize(14)->setBold(true);
        $sheet->mergeCells("AO$detail_table_header_row:AO" . ($detail_table_header_row + 2));
        $sheet->setCellValue("AP$detail_table_header_row", 'Panjar')->getStyle("AP1")->applyFromArray($styleHeader)->getFont()->setSize(14)->setBold(true);
        $sheet->mergeCells("AP$detail_table_header_row:AP" . ($detail_table_header_row + 2));
        $sheet->setCellValue("AQ$detail_table_header_row", 'Mandor')->getStyle("AQ1")->applyFromArray($styleHeader)->getFont()->setSize(14)->setBold(true);
        $sheet->mergeCells("AQ$detail_table_header_row:AQ" . ($detail_table_header_row + 2));
        $sheet->setCellValue("AR$detail_table_header_row", 'Supir Ex')->getStyle("AR1")->applyFromArray($styleHeader)->getFont()->setSize(14)->setBold(true);
        $sheet->mergeCells("AR$detail_table_header_row:AR" . ($detail_table_header_row + 2));
        $sheet->setCellValue("AS$detail_table_header_row", 'Liter')->getStyle("AS1")->applyFromArray($styleHeader)->getFont()->setSize(14)->setBold(true);
        $sheet->mergeCells("AS$detail_table_header_row:AS" . ($detail_table_header_row + 2));


        $rowIndex = 4;
        $previous_nopol = null;
        // $group = [];
        $groupRowCount = 0;
        $sheet->setCellValue("A4", "periode : " . $dari . " s/d " . $sampai);
        foreach ($data as $response_index => $response_detail) {
            $nopol = $response_detail['nopol'];

            if ($nopol != $previous_nopol) {
                if ($previous_nopol !== null) {
                    // $rowIndex++; // Move to the next row
                    // $sheet->setCellValue("A$rowIndex", 'Total')->getStyle("A$rowIndex")->applyFromArray($styleHeader)->getFont()->setBold(true);

                    // Calculate the total for the previous group and set it in the next column
                    $startTotalIndex = $rowIndex - $groupRowCount;
                    $endTotalIndex = $rowIndex - 1;

                    $sheet->setCellValue("M$rowIndex", "=SUM(M$startTotalIndex:M$endTotalIndex)")->getStyle("M$rowIndex")->applyFromArray($styleArray2)->getNumberFormat()->setFormatCode("#,##0.00");
                    $sheet->setCellValue("N$rowIndex", "=SUM(M$startTotalIndex:N$endTotalIndex)")->getStyle("N$rowIndex")->applyFromArray($styleArray2)->getNumberFormat()->setFormatCode("#,##0.00");
                    $sheet->setCellValue("Q$rowIndex", "=SUM(Q$startTotalIndex:Q$endTotalIndex)")->getStyle("Q$rowIndex")->applyFromArray($styleArray2)->getNumberFormat()->setFormatCode("#,##0.00");
                    $sheet->setCellValue("T$rowIndex", "=SUM(T$startTotalIndex:T$endTotalIndex)")->getStyle("T$rowIndex")->applyFromArray($styleArray2)->getNumberFormat()->setFormatCode("#,##0.00");
                    $sheet->setCellValue("V$rowIndex", "=SUM(V$startTotalIndex:V$endTotalIndex)")->getStyle("V$rowIndex")->applyFromArray($styleArray2)->getNumberFormat()->setFormatCode("#,##0.00");
                    $sheet->setCellValue("W$rowIndex", "=SUM(W$startTotalIndex:W$endTotalIndex)")->getStyle("W$rowIndex")->applyFromArray($styleArray2)->getNumberFormat()->setFormatCode("#,##0.00");
                    $sheet->setCellValue("X$rowIndex", "=SUM(X$startTotalIndex:X$endTotalIndex)")->getStyle("X$rowIndex")->applyFromArray($styleArray2)->getNumberFormat()->setFormatCode("#,##0.00");
                    $sheet->setCellValue("Y$rowIndex", "=SUM(Y$startTotalIndex:Y$endTotalIndex)")->getStyle("Y$rowIndex")->applyFromArray($styleArray2)->getNumberFormat()->setFormatCode("#,##0.00");
                    $sheet->setCellValue("Z$rowIndex", "=SUM(Z$startTotalIndex:Z$endTotalIndex)")->getStyle("Z$rowIndex")->applyFromArray($styleArray2)->getNumberFormat()->setFormatCode("#,##0.00");
                    $sheet->setCellValue("AC$rowIndex", "=SUM(AC$startTotalIndex:AC$endTotalIndex)")->getStyle("AC$rowIndex")->applyFromArray($styleArray2)->getNumberFormat()->setFormatCode("#,##0.00");
                    $sheet->setCellValue("AD$rowIndex", "=SUM(AD$startTotalIndex:AD$endTotalIndex)")->getStyle("AD$rowIndex")->applyFromArray($styleArray2)->getNumberFormat()->setFormatCode("#,##0.00");
                    $sheet->setCellValue("AF$rowIndex", "=SUM(AF$startTotalIndex:AF$endTotalIndex)")->getStyle("AF$rowIndex")->applyFromArray($styleArray2)->getNumberFormat()->setFormatCode("#,##0.00");
                    $sheet->setCellValue("AG$rowIndex", "=SUM(AG$startTotalIndex:AG$endTotalIndex)")->getStyle("AG$rowIndex")->applyFromArray($styleArray2)->getNumberFormat()->setFormatCode("#,##0.00");
                    $sheet->setCellValue("AI$rowIndex", "=SUM(AI$startTotalIndex:AI$endTotalIndex)")->getStyle("AI$rowIndex")->applyFromArray($styleArray2)->getNumberFormat()->setFormatCode("#,##0.00");
                    $sheet->setCellValue("AJ$rowIndex", "=SUM(AJ$startTotalIndex:AJ$endTotalIndex)")->getStyle("AJ$rowIndex")->applyFromArray($styleArray2)->getNumberFormat()->setFormatCode("#,##0.00");
                    $sheet->setCellValue("AK$rowIndex", "=SUM(AK$startTotalIndex:AK$endTotalIndex)")->getStyle("AK$rowIndex")->applyFromArray($styleArray2)->getNumberFormat()->setFormatCode("#,##0.00");
                    $sheet->setCellValue("AL$rowIndex", "=SUM(AL$startTotalIndex:AL$endTotalIndex)")->getStyle("AL$rowIndex")->applyFromArray($styleArray2)->getNumberFormat()->setFormatCode("#,##0.00");
                    $sheet->setCellValue("AM$rowIndex", "=SUM(AM$startTotalIndex:AM$endTotalIndex)")->getStyle("AM$rowIndex")->applyFromArray($styleArray2)->getNumberFormat()->setFormatCode("#,##0.00");
                    $groupRowCount = 0;
                    $rowIndex++;
                    $rowIndex++; // Move to the next row
                }
                $sheet->setCellValue("C$rowIndex", $nopol);
                $rowIndex++;

                // Store the starting row index of the current group
                $groupStartIndex = $rowIndex;
            }

            $sheet->setCellValue("A$rowIndex", $response_detail['tglbukti']);
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
            $sheet->setCellValue("M$rowIndex", $response_detail['omset'])->getStyle("M$rowIndex")->applyFromArray($style_number)->getNumberFormat()->setFormatCode("#,##0.00");
            $sheet->setCellValue("N$rowIndex", $response_detail['omsettambahan'])->getStyle("N$rowIndex")->applyFromArray($style_number)->getNumberFormat()->setFormatCode("#,##0.00");
            $sheet->setCellValue("O$rowIndex", $response_detail['omsetextrabbm'])->getStyle("O$rowIndex")->applyFromArray($style_number)->getNumberFormat()->setFormatCode("#,##0.00");
            $sheet->setCellValue("P$rowIndex", $response_detail['invoice']);
            $sheet->setCellValue("Q$rowIndex", $response_detail['borongan'])->getStyle("Q$rowIndex")->applyFromArray($style_number)->getNumberFormat()->setFormatCode("#,##0.00");
            $sheet->setCellValue("R$rowIndex", $response_detail['nobuktiebs']);
            $sheet->setCellValue("S$rowIndex", $response_detail['pengeluarannobuktiebs']);
            $sheet->setCellValue("T$rowIndex", $response_detail['voucher'])->getStyle("T$rowIndex")->applyFromArray($style_number)->getNumberFormat()->setFormatCode("#,##0.00");
            $sheet->setCellValue("U$rowIndex", $response_detail['novoucher']);
            $sheet->setCellValue("V$rowIndex", $response_detail['gajisupir'])->getStyle("V$rowIndex")->applyFromArray($style_number)->getNumberFormat()->setFormatCode("#,##0.00");
            $sheet->setCellValue("W$rowIndex", $response_detail['komisi'])->getStyle("W$rowIndex")->applyFromArray($style_number)->getNumberFormat()->setFormatCode("#,##0.00");
            $sheet->setCellValue("X$rowIndex", $response_detail['gajikenek'])->getStyle("X$rowIndex")->applyFromArray($style_number)->getNumberFormat()->setFormatCode("#,##0.00");
            $sheet->setCellValue("Y$rowIndex", $response_detail['gajimingguan'])->getStyle("Y$rowIndex")->applyFromArray($style_number)->getNumberFormat()->setFormatCode("#,##0.00");
            $sheet->setCellValue("Z$rowIndex", $response_detail['gajilain'])->getStyle("Z$rowIndex")->applyFromArray($style_number)->getNumberFormat()->setFormatCode("#,##0.00");
            $sheet->setCellValue("AA$rowIndex", $response_detail['ket']);
            $sheet->setCellValue("AB$rowIndex", $response_detail['nobuktikbtkomisi']);
            $sheet->setCellValue("AC$rowIndex", $response_detail['uanglain'])->getStyle("AC$rowIndex")->applyFromArray($style_number)->getNumberFormat()->setFormatCode("#,##0.00");
            $sheet->setCellValue("AD$rowIndex", $response_detail['uangbon'])->getStyle("AD$rowIndex")->applyFromArray($style_number)->getNumberFormat()->setFormatCode("#,##0.00");
            $sheet->setCellValue("AE$rowIndex", $response_detail['nobuktikbtebs2']);
            $sheet->setCellValue("AF$rowIndex", $response_detail['ritasi'])->getStyle("AF$rowIndex")->applyFromArray($style_number)->getNumberFormat()->setFormatCode("#,##0.00");
            $sheet->setCellValue("AG$rowIndex", $response_detail['extrabbm'])->getStyle("AG$rowIndex")->applyFromArray($style_number)->getNumberFormat()->setFormatCode("#,##0.00");
            $sheet->setCellValue("AH$rowIndex", $response_detail['ketritasi']);
            $sheet->setCellValue("AI$rowIndex", $response_detail['uangjalan'])->getStyle("AI$rowIndex")->applyFromArray($style_number)->getNumberFormat()->setFormatCode("#,##0.00");
            $sheet->setCellValue("AJ$rowIndex", $response_detail['uangbbm'])->getStyle("AJ$rowIndex")->applyFromArray($style_number)->getNumberFormat()->setFormatCode("#,##0.00");
            $sheet->setCellValue("AK$rowIndex", $response_detail['uangmakan'])->getStyle("AK$rowIndex")->applyFromArray($style_number)->getNumberFormat()->setFormatCode("#,##0.00");
            $sheet->setCellValue("AL$rowIndex", $response_detail['totalbiaya'])->getStyle("AL$rowIndex")->applyFromArray($style_number)->getNumberFormat()->setFormatCode("#,##0.00");
            $sheet->setCellValue("AM$rowIndex", $response_detail['sisa'])->getStyle("AM$rowIndex")->applyFromArray($style_number)->getNumberFormat()->setFormatCode("#,##0.00");
            $sheet->setCellValue("AN$rowIndex", $response_detail['nobukti']);
            $sheet->setCellValue("AO$rowIndex", $response_detail['bongkarmuat'])->getStyle("AO$rowIndex")->applyFromArray($style_number)->getNumberFormat()->setFormatCode("#,##0.00");
            $sheet->setCellValue("AP$rowIndex", $response_detail['panjar']);
            $sheet->setCellValue("AQ$rowIndex", $response_detail['mandor']);
            $sheet->setCellValue("AR$rowIndex", $response_detail['supirex']);
            $sheet->setCellValue("AS$rowIndex", $response_detail['liter'])->getStyle("AS$rowIndex")->applyFromArray($style_number)->getNumberFormat()->setFormatCode("#,##0.00");
            $rowIndex++;

            // Store the current group details in an array
            $group[] = $response_detail;
            $sheet->getColumnDimension('A')->setWidth(10);
            $previous_nopol = $nopol;
            $groupRowCount++;
        }

        // Add total and calculate the total for the last group
        if ($previous_nopol !== null) {
            // $rowIndex++;
            // $sheet->setCellValue("A$rowIndex", 'Total')->getStyle("A$rowIndex")->applyFromArray($styleHeader)->getFont()->setBold(true);

            $startTotalIndex = $groupStartIndex;
            $endTotalIndex = $rowIndex - 1;

            $sheet->setCellValue("M$rowIndex", "=SUM(M$startTotalIndex:M$endTotalIndex)")->getStyle("M$rowIndex")->applyFromArray($styleArray2)->getNumberFormat()->setFormatCode("#,##0.00");
            $sheet->setCellValue("N$rowIndex", "=SUM(N$startTotalIndex:N$endTotalIndex)")->getStyle("N$rowIndex")->applyFromArray($styleArray2)->getNumberFormat()->setFormatCode("#,##0.00");
            $sheet->setCellValue("Q$rowIndex", "=SUM(Q$startTotalIndex:Q$endTotalIndex)")->getStyle("Q$rowIndex")->applyFromArray($styleArray2)->getNumberFormat()->setFormatCode("#,##0.00");
            $sheet->setCellValue("T$rowIndex", "=SUM(T$startTotalIndex:T$endTotalIndex)")->getStyle("T$rowIndex")->applyFromArray($styleArray2)->getNumberFormat()->setFormatCode("#,##0.00");
            $sheet->setCellValue("V$rowIndex", "=SUM(V$startTotalIndex:V$endTotalIndex)")->getStyle("V$rowIndex")->applyFromArray($styleArray2)->getNumberFormat()->setFormatCode("#,##0.00");
            $sheet->setCellValue("W$rowIndex", "=SUM(W$startTotalIndex:W$endTotalIndex)")->getStyle("W$rowIndex")->applyFromArray($styleArray2)->getNumberFormat()->setFormatCode("#,##0.00");
            $sheet->setCellValue("X$rowIndex", "=SUM(X$startTotalIndex:X$endTotalIndex)")->getStyle("X$rowIndex")->applyFromArray($styleArray2)->getNumberFormat()->setFormatCode("#,##0.00");
            $sheet->setCellValue("Y$rowIndex", "=SUM(Y$startTotalIndex:Y$endTotalIndex)")->getStyle("Y$rowIndex")->applyFromArray($styleArray2)->getNumberFormat()->setFormatCode("#,##0.00");
            $sheet->setCellValue("Z$rowIndex", "=SUM(Z$startTotalIndex:Z$endTotalIndex)")->getStyle("Z$rowIndex")->applyFromArray($styleArray2)->getNumberFormat()->setFormatCode("#,##0.00");
            $sheet->setCellValue("AC$rowIndex", "=SUM(AC$startTotalIndex:AC$endTotalIndex)")->getStyle("AC$rowIndex")->applyFromArray($styleArray2)->getNumberFormat()->setFormatCode("#,##0.00");
            $sheet->setCellValue("AD$rowIndex", "=SUM(AD$startTotalIndex:AD$endTotalIndex)")->getStyle("AD$rowIndex")->applyFromArray($styleArray2)->getNumberFormat()->setFormatCode("#,##0.00");
            $sheet->setCellValue("AF$rowIndex", "=SUM(AF$startTotalIndex:AF$endTotalIndex)")->getStyle("AF$rowIndex")->applyFromArray($styleArray2)->getNumberFormat()->setFormatCode("#,##0.00");
            $sheet->setCellValue("AG$rowIndex", "=SUM(AG$startTotalIndex:AG$endTotalIndex)")->getStyle("AG$rowIndex")->applyFromArray($styleArray2)->getNumberFormat()->setFormatCode("#,##0.00");
            $sheet->setCellValue("AI$rowIndex", "=SUM(AI$startTotalIndex:AI$endTotalIndex)")->getStyle("AI$rowIndex")->applyFromArray($styleArray2)->getNumberFormat()->setFormatCode("#,##0.00");
            $sheet->setCellValue("AJ$rowIndex", "=SUM(AJ$startTotalIndex:AJ$endTotalIndex)")->getStyle("AJ$rowIndex")->applyFromArray($styleArray2)->getNumberFormat()->setFormatCode("#,##0.00");
            $sheet->setCellValue("AK$rowIndex", "=SUM(AK$startTotalIndex:AK$endTotalIndex)")->getStyle("AK$rowIndex")->applyFromArray($styleArray2)->getNumberFormat()->setFormatCode("#,##0.00");
            $sheet->setCellValue("AL$rowIndex", "=SUM(AL$startTotalIndex:AL$endTotalIndex)")->getStyle("AL$rowIndex")->applyFromArray($styleArray2)->getNumberFormat()->setFormatCode("#,##0.00");
            $sheet->setCellValue("AM$rowIndex", "=SUM(AM$startTotalIndex:AM$endTotalIndex)")->getStyle("AM$rowIndex")->applyFromArray($styleArray2)->getNumberFormat()->setFormatCode("#,##0.00");
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
        $sheet->getColumnDimension('AS')->setAutoSize(true);



        $writer = new Xlsx($spreadsheet);
        $filename = 'LAPORAN MINGGUAN SUPIR' . date('dmYHis');
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
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
            ->get(config('app.api_url') . 'exportlaporanmingguansupir/export', $detailParams);

            // dd(config('app.api_url') . 'exportlaporanmingguansupir/export', $detailParams);

        $data = $header['data'];

        if ($data[0]['formatric'] == '1') {
            $this->export1($data, $request->dari,$request->sampai,$request->tradodari_id,$request->tradosampai_id,$request->tradodari,$request->tradosampai);
        } else {
            $this->export2($data, $request->dari,$request->sampai,$request->tradodari_id,$request->tradosampai_id,$request->tradodari,$request->tradosampai);
        }
    }

    public function export2($data, $dari,$sampai,$tradodari_id,$tradosampai_id,$tradodari,$tradosampai)
    {
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
        $sheet->setCellValue("O$detail_table_header_row", 'Omset Extra BBM')->getStyle("O1")->applyFromArray($styleHeader)->getFont()->setSize(14)->setBold(true);
        $sheet->mergeCells("O$detail_table_header_row:O" . ($detail_table_header_row + 2));
        $sheet->setCellValue("P$detail_table_header_row", 'Inv')->getStyle("O1")->applyFromArray($styleHeader)->getFont()->setSize(14)->setBold(true);
        $sheet->mergeCells("P$detail_table_header_row:P" . ($detail_table_header_row + 2));
        $sheet->setCellValue("Q$detail_table_header_row", 'Biaya Operasional')->getStyle("Q1")->applyFromArray($styleHeader)->getFont()->setSize(14)->setBold(true);
        $sheet->mergeCells("Q$detail_table_header_row:AF$detail_table_header_row");
        $sheet->setCellValue("Q" . ($detail_table_header_row + 1), 'Uang Jalan')->getStyle("Q2")->applyFromArray($styleHeader)->getFont()->setSize(14)->setBold(true);
        $sheet->mergeCells("Q" . ($detail_table_header_row + 1) . ":Q" . ($detail_table_header_row + 2));
        $sheet->setCellValue("R" . ($detail_table_header_row + 1), 'EBS')->getStyle("R2")->applyFromArray($styleHeader)->getFont()->setSize(14)->setBold(true);
        $sheet->mergeCells("R" . ($detail_table_header_row + 1) . ":R" . ($detail_table_header_row + 2));
        $sheet->setCellValue("S" . ($detail_table_header_row + 1), 'No Pengeluaran EBS')->getStyle("S2")->applyFromArray($styleHeader)->getFont()->setSize(14)->setBold(true);
        $sheet->mergeCells("S" . ($detail_table_header_row + 1) . ":S" . ($detail_table_header_row + 2));
        $sheet->setCellValue("T" . ($detail_table_header_row + 1), 'Voucher')->getStyle("T2")->applyFromArray($styleHeader)->getFont()->setSize(14)->setBold(true);
        $sheet->mergeCells("T" . ($detail_table_header_row + 1) . ":T" . ($detail_table_header_row + 2));
        $sheet->setCellValue("U" . ($detail_table_header_row + 1), 'No Voucher')->getStyle("U2")->applyFromArray($styleHeader)->getFont()->setSize(14)->setBold(true);
        $sheet->mergeCells("U" . ($detail_table_header_row + 1) . ":U" . ($detail_table_header_row + 2));
        $sheet->setCellValue("V" . ($detail_table_header_row + 1), 'Komisi Supir')->getStyle("V2")->applyFromArray($styleHeader)->getFont()->setSize(14)->setBold(true);
        $sheet->mergeCells("V" . ($detail_table_header_row + 1) . ":V" . ($detail_table_header_row + 2));
        $sheet->setCellValue("W" . ($detail_table_header_row + 1), 'Kenek ')->getStyle("W2")->applyFromArray($styleHeader)->getFont()->setSize(14)->setBold(true);
        $sheet->mergeCells("W" . ($detail_table_header_row + 1) . ":W" . ($detail_table_header_row + 2));
        $sheet->setCellValue("X" . ($detail_table_header_row + 1), '')->getStyle("X2")->applyFromArray($styleHeader)->getFont()->setSize(14)->setBold(true);
        $sheet->mergeCells("X" . ($detail_table_header_row + 1) . ":X" . ($detail_table_header_row + 2));
        $sheet->setCellValue("Y" . ($detail_table_header_row + 1), 'G. Lain')->getStyle("Y")->applyFromArray($styleHeader)->getFont()->setSize(14)->setBold(true);
        $sheet->mergeCells("Y" . ($detail_table_header_row + 1) . ":Y" . ($detail_table_header_row + 2));
        $sheet->setCellValue("Z" . ($detail_table_header_row + 1), 'G. LAIN')->getStyle("Z2")->applyFromArray($styleHeader)->getFont()->setSize(14)->setBold(true);
        $sheet->mergeCells("Z" . ($detail_table_header_row + 1) . ":Z" . ($detail_table_header_row + 2));
        $sheet->setCellValue("AA" . ($detail_table_header_row + 1), 'Ket')->getStyle("AA2")->applyFromArray($styleHeader)->getFont()->setSize(14)->setBold(true);
        $sheet->mergeCells("AA" . ($detail_table_header_row + 1) . ":AA" . ($detail_table_header_row + 2));
        $sheet->setCellValue("AB" . ($detail_table_header_row + 1), 'No Bukti Komisi')->getStyle("AB2")->applyFromArray($styleHeader)->getFont()->setSize(14)->setBold(true);
        $sheet->mergeCells("AB" . ($detail_table_header_row + 1) . ":AB" . ($detail_table_header_row + 2));
        $sheet->setCellValue("AC" . ($detail_table_header_row + 1), 'Rp')->getStyle("AC2")->applyFromArray($styleHeader)->getFont()->setSize(14)->setBold(true);
        $sheet->mergeCells("AC" . ($detail_table_header_row + 1) . ":AH" . ($detail_table_header_row + 1));
        $sheet->setCellValue("AC" . ($detail_table_header_row + 2), 'Tol')->getStyle("AC3")->applyFromArray($styleHeader)->getFont()->setSize(14)->setBold(true);
        $sheet->mergeCells("AC" . ($detail_table_header_row + 2) . ":AC" . ($detail_table_header_row + 2));
        $sheet->setCellValue("AE" . ($detail_table_header_row + 2), '')->getStyle("AE3")->applyFromArray($styleHeader)->getFont()->setSize(14)->setBold(true);
        $sheet->mergeCells("AE" . ($detail_table_header_row + 2) . ":AE" . ($detail_table_header_row + 2));
        $sheet->setCellValue("AF" . ($detail_table_header_row + 2), 'Ritasi')->getStyle("AF3")->applyFromArray($styleHeader)->getFont()->setSize(14)->setBold(true);
        $sheet->mergeCells("AF" . ($detail_table_header_row + 2) . ":AF" . ($detail_table_header_row + 2));
        $sheet->setCellValue("AG" . ($detail_table_header_row + 2), 'Extra Bbm')->getStyle("AG3")->applyFromArray($styleHeader)->getFont()->setSize(14)->setBold(true);
        $sheet->mergeCells("AG" . ($detail_table_header_row + 2) . ":AG" . ($detail_table_header_row + 2));
        $sheet->setCellValue("AH" . ($detail_table_header_row + 2), 'Ket')->getStyle("AH3")->applyFromArray($styleHeader)->getFont()->setSize(14)->setBold(true);
        $sheet->mergeCells("AH" . ($detail_table_header_row + 2) . ":AH" . ($detail_table_header_row + 2));
        $sheet->setCellValue("AI$detail_table_header_row", 'Biaya')->getStyle("AI1")->applyFromArray($styleHeader)->getFont()->setSize(14)->setBold(true);
        $sheet->mergeCells("AI" . ($detail_table_header_row) . ":AJ" . ($detail_table_header_row));
        $sheet->setCellValue("AI" . ($detail_table_header_row + 1), 'Kas Gantung Supir')->getStyle("AI2")->applyFromArray($styleHeader)->getFont()->setSize(14)->setBold(true);
        $sheet->mergeCells("AI" . ($detail_table_header_row + 1) . ":AI" . ($detail_table_header_row + 2));
        $sheet->setCellValue("AJ" . ($detail_table_header_row + 1), '')->getStyle("AJ2")->applyFromArray($styleHeader)->getFont()->setSize(14)->setBold(true);
        $sheet->mergeCells("AJ" . ($detail_table_header_row + 1) . ":AJ" . ($detail_table_header_row + 2));
        $sheet->setCellValue("AK" . ($detail_table_header_row + 1), '')->getStyle("AK2")->applyFromArray($styleHeader)->getFont()->setSize(14)->setBold(true);
        $sheet->mergeCells("AK" . ($detail_table_header_row + 1) . ":AK" . ($detail_table_header_row + 2));
        $sheet->setCellValue("AL$detail_table_header_row", 'Total Biaya')->getStyle("AL1")->applyFromArray($styleHeader)->getFont()->setSize(14)->setBold(true);
        $sheet->mergeCells("AL$detail_table_header_row:AL" . ($detail_table_header_row + 2));
        $sheet->setCellValue("AM$detail_table_header_row", 'Laba')->getStyle("AM1")->applyFromArray($styleHeader)->getFont()->setSize(14)->setBold(true);
        $sheet->mergeCells("AM$detail_table_header_row:AM" . ($detail_table_header_row + 2));
        $sheet->setCellValue("AN$detail_table_header_row", 'No Trip')->getStyle("AN1")->applyFromArray($styleHeader)->getFont()->setSize(14)->setBold(true);
        $sheet->mergeCells("AN$detail_table_header_row:AN" . ($detail_table_header_row + 2));
        $sheet->setCellValue("AO$detail_table_header_row", 'Bongkar/Muat')->getStyle("AO1")->applyFromArray($styleHeader)->getFont()->setSize(14)->setBold(true);
        $sheet->mergeCells("AO$detail_table_header_row:AO" . ($detail_table_header_row + 2));
        $sheet->setCellValue("AP$detail_table_header_row", 'Panjar')->getStyle("AP1")->applyFromArray($styleHeader)->getFont()->setSize(14)->setBold(true);
        $sheet->mergeCells("AP$detail_table_header_row:AP" . ($detail_table_header_row + 2));
        $sheet->setCellValue("AQ$detail_table_header_row", 'Liter')->getStyle("AS1")->applyFromArray($styleHeader)->getFont()->setSize(14)->setBold(true);
        $sheet->mergeCells("AQ$detail_table_header_row:AQ" . ($detail_table_header_row + 2));


        $rowIndex = 4;
        $previous_nopol = null;
        // $group = [];
        $groupRowCount = 0;
        $sheet->setCellValue("A4", "periode : " . $dari . " s/d " . $sampai);
        foreach ($data as $response_index => $response_detail) {
            $nopol = $response_detail['nopol'];

            if ($nopol != $previous_nopol) {
                if ($previous_nopol !== null) {
                    // $rowIndex++; // Move to the next row
                    // $sheet->setCellValue("A$rowIndex", 'Total')->getStyle("A$rowIndex")->applyFromArray($styleHeader)->getFont()->setBold(true);

                    // Calculate the total for the previous group and set it in the next column
                    $startTotalIndex = $rowIndex - $groupRowCount;
                    $endTotalIndex = $rowIndex - 1;

                    $sheet->setCellValue("M$rowIndex", "=SUM(M$startTotalIndex:M$endTotalIndex)")->getStyle("M$rowIndex")->applyFromArray($styleArray2)->getNumberFormat()->setFormatCode("#,##0.00");
                    $sheet->setCellValue("N$rowIndex", "=SUM(M$startTotalIndex:N$endTotalIndex)")->getStyle("N$rowIndex")->applyFromArray($styleArray2)->getNumberFormat()->setFormatCode("#,##0.00");
                    $sheet->setCellValue("Q$rowIndex", "=SUM(P$startTotalIndex:Q$endTotalIndex)")->getStyle("QP$rowIndex")->applyFromArray($styleArray2)->getNumberFormat()->setFormatCode("#,##0.00");
                    $sheet->setCellValue("T$rowIndex", "=SUM(S$startTotalIndex:T$endTotalIndex)")->getStyle("T$rowIndex")->applyFromArray($styleArray2)->getNumberFormat()->setFormatCode("#,##0.00");
                    $sheet->setCellValue("V$rowIndex", "=SUM(U$startTotalIndex:V$endTotalIndex)")->getStyle("V$rowIndex")->applyFromArray($styleArray2)->getNumberFormat()->setFormatCode("#,##0.00");
                    $sheet->setCellValue("W$rowIndex", "=SUM(V$startTotalIndex:W$endTotalIndex)")->getStyle("W$rowIndex")->applyFromArray($styleArray2)->getNumberFormat()->setFormatCode("#,##0.00");
                    $sheet->setCellValue("X$rowIndex", "=SUM(W$startTotalIndex:X$endTotalIndex)")->getStyle("X$rowIndex")->applyFromArray($styleArray2)->getNumberFormat()->setFormatCode("#,##0.00");
                    $sheet->setCellValue("Y$rowIndex", "=SUM(X$startTotalIndex:Y$endTotalIndex)")->getStyle("Y$rowIndex")->applyFromArray($styleArray2)->getNumberFormat()->setFormatCode("#,##0.00");
                    $sheet->setCellValue("Z$rowIndex", "=SUM(Y$startTotalIndex:Z$endTotalIndex)")->getStyle("Z$rowIndex")->applyFromArray($styleArray2)->getNumberFormat()->setFormatCode("#,##0.00");
                    $sheet->setCellValue("AC$rowIndex", "=SUM(AB$startTotalIndex:AC$endTotalIndex)")->getStyle("AC$rowIndex")->applyFromArray($styleArray2)->getNumberFormat()->setFormatCode("#,##0.00");
                    $sheet->setCellValue("AD$rowIndex", "=SUM(AC$startTotalIndex:AD$endTotalIndex)")->getStyle("AD$rowIndex")->applyFromArray($styleArray2)->getNumberFormat()->setFormatCode("#,##0.00");
                    $sheet->setCellValue("AF$rowIndex", "=SUM(AE$startTotalIndex:AF$endTotalIndex)")->getStyle("AF$rowIndex")->applyFromArray($styleArray2)->getNumberFormat()->setFormatCode("#,##0.00");
                    $sheet->setCellValue("AG$rowIndex", "=SUM(AF$startTotalIndex:AG$endTotalIndex)")->getStyle("AG$rowIndex")->applyFromArray($styleArray2)->getNumberFormat()->setFormatCode("#,##0.00");
                    $sheet->setCellValue("AI$rowIndex", "=SUM(AH$startTotalIndex:AI$endTotalIndex)")->getStyle("AI$rowIndex")->applyFromArray($styleArray2)->getNumberFormat()->setFormatCode("#,##0.00");
                    $sheet->setCellValue("AJ$rowIndex", "=SUM(AI$startTotalIndex:AJ$endTotalIndex)")->getStyle("AJ$rowIndex")->applyFromArray($styleArray2)->getNumberFormat()->setFormatCode("#,##0.00");
                    $sheet->setCellValue("AK$rowIndex", "=SUM(AJ$startTotalIndex:AK$endTotalIndex)")->getStyle("AK$rowIndex")->applyFromArray($styleArray2)->getNumberFormat()->setFormatCode("#,##0.00");
                    $sheet->setCellValue("AL$rowIndex", "=SUM(AK$startTotalIndex:AL$endTotalIndex)")->getStyle("AL$rowIndex")->applyFromArray($styleArray2)->getNumberFormat()->setFormatCode("#,##0.00");
                    $sheet->setCellValue("AM$rowIndex", "=SUM(AL$startTotalIndex:AM$endTotalIndex)")->getStyle("AM$rowIndex")->applyFromArray($styleArray2)->getNumberFormat()->setFormatCode("#,##0.00");
                    $groupRowCount = 0;
                    $rowIndex++;
                    $rowIndex++; // Move to the next row
                }
                $sheet->setCellValue("C$rowIndex", $nopol);
                $rowIndex++;

                // Store the starting row index of the current group
                $groupStartIndex = $rowIndex;
            }

            $sheet->setCellValue("A$rowIndex", $response_detail['tglbukti']);
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
            $sheet->setCellValue("M$rowIndex", $response_detail['omset'])->getStyle("M$rowIndex")->applyFromArray($style_number)->getNumberFormat()->setFormatCode("#,##0.00");
            $sheet->setCellValue("N$rowIndex", $response_detail['omsettambahan'])->getStyle("N$rowIndex")->applyFromArray($style_number)->getNumberFormat()->setFormatCode("#,##0.00");
            $sheet->setCellValue("O$rowIndex", $response_detail['omsetextrabbm'])->getStyle("O$rowIndex")->applyFromArray($style_number)->getNumberFormat()->setFormatCode("#,##0.00");
            $sheet->setCellValue("P$rowIndex", $response_detail['invoice']);
            $sheet->setCellValue("Q$rowIndex", $response_detail['borongan'])->getStyle("Q$rowIndex")->applyFromArray($style_number)->getNumberFormat()->setFormatCode("#,##0.00");
            $sheet->setCellValue("R$rowIndex", $response_detail['nobuktiebs']);
            $sheet->setCellValue("S$rowIndex", $response_detail['pengeluarannobuktiebs']);
            $sheet->setCellValue("T$rowIndex", $response_detail['voucher'])->getStyle("T$rowIndex")->applyFromArray($style_number)->getNumberFormat()->setFormatCode("#,##0.00");
            $sheet->setCellValue("U$rowIndex", $response_detail['novoucher']);
            $sheet->setCellValue("V$rowIndex", $response_detail['komisi'])->getStyle("V$rowIndex")->applyFromArray($style_number)->getNumberFormat()->setFormatCode("#,##0.00");
            $sheet->setCellValue("W$rowIndex", $response_detail['gajikenek'])->getStyle("W$rowIndex")->applyFromArray($style_number)->getNumberFormat()->setFormatCode("#,##0.00");
            $sheet->setCellValue("X$rowIndex", $response_detail['gajimingguan'])->getStyle("X$rowIndex")->applyFromArray($style_number)->getNumberFormat()->setFormatCode("#,##0.00");
            $sheet->setCellValue("Y$rowIndex", $response_detail['gajilain'])->getStyle("Y$rowIndex")->applyFromArray($style_number)->getNumberFormat()->setFormatCode("#,##0.00");
            $sheet->setCellValue("Z$rowIndex", $response_detail['ket']);
            $sheet->setCellValue("AA$rowIndex", $response_detail['nobuktikbtkomisi']);
            $sheet->setCellValue("AB$rowIndex", $response_detail['uanglain'])->getStyle("AB$rowIndex")->applyFromArray($style_number)->getNumberFormat()->setFormatCode("#,##0.00");
            $sheet->setCellValue("AC$rowIndex", $response_detail['tolsupir'])->getStyle("AC$rowIndex")->applyFromArray($style_number)->getNumberFormat()->setFormatCode("#,##0.00");
            $sheet->setCellValue("AD$rowIndex", $response_detail['uangbon'])->getStyle("AD$rowIndex")->applyFromArray($style_number)->getNumberFormat()->setFormatCode("#,##0.00");
            $sheet->setCellValue("AE$rowIndex", $response_detail['nobuktikbtebs2']);
            $sheet->setCellValue("AF$rowIndex", $response_detail['ritasi'])->getStyle("AF$rowIndex")->applyFromArray($style_number)->getNumberFormat()->setFormatCode("#,##0.00");
            $sheet->setCellValue("AG$rowIndex", $response_detail['extrabbm'])->getStyle("AG$rowIndex")->applyFromArray($style_number)->getNumberFormat()->setFormatCode("#,##0.00");
            $sheet->setCellValue("AH$rowIndex", $response_detail['ketuanglain']);
            $sheet->setCellValue("AI$rowIndex", $response_detail['uangjalan'])->getStyle("AI$rowIndex")->applyFromArray($style_number)->getNumberFormat()->setFormatCode("#,##0.00");
            $sheet->setCellValue("AJ$rowIndex", $response_detail['uangbbm'])->getStyle("AJ$rowIndex")->applyFromArray($style_number)->getNumberFormat()->setFormatCode("#,##0.00");
            $sheet->setCellValue("AK$rowIndex", $response_detail['uangmakan'])->getStyle("AK$rowIndex")->applyFromArray($style_number)->getNumberFormat()->setFormatCode("#,##0.00");
            $sheet->setCellValue("AL$rowIndex", $response_detail['totalbiaya'])->getStyle("AL$rowIndex")->applyFromArray($style_number)->getNumberFormat()->setFormatCode("#,##0.00");
            $sheet->setCellValue("AM$rowIndex", $response_detail['sisa'])->getStyle("AM$rowIndex")->applyFromArray($style_number)->getNumberFormat()->setFormatCode("#,##0.00");
            $sheet->setCellValue("AN$rowIndex", $response_detail['nobukti']);
            $sheet->setCellValue("AO$rowIndex", $response_detail['bongkarmuat'])->getStyle("AO$rowIndex")->applyFromArray($style_number)->getNumberFormat()->setFormatCode("#,##0.00");
            $sheet->setCellValue("AP$rowIndex", $response_detail['panjar']);
            $sheet->setCellValue("AQ$rowIndex", $response_detail['liter'])->getStyle("AQ$rowIndex")->applyFromArray($style_number)->getNumberFormat()->setFormatCode("#,##0.00");
            $rowIndex++;

            // Store the current group details in an array
            $group[] = $response_detail;
            $sheet->getColumnDimension('A')->setWidth(10);
            $previous_nopol = $nopol;
            $groupRowCount++;
        }

        // Add total and calculate the total for the last group
        if ($previous_nopol !== null) {
            // $rowIndex++;
            // $sheet->setCellValue("A$rowIndex", 'Total')->getStyle("A$rowIndex")->applyFromArray($styleHeader)->getFont()->setBold(true);

            $startTotalIndex = $groupStartIndex;
            $endTotalIndex = $rowIndex - 1;

            $sheet->setCellValue("M$rowIndex", "=SUM(M$startTotalIndex:M$endTotalIndex)")->getStyle("M$rowIndex")->applyFromArray($styleArray2)->getNumberFormat()->setFormatCode("#,##0.00");
            $sheet->setCellValue("N$rowIndex", "=SUM(N$startTotalIndex:N$endTotalIndex)")->getStyle("N$rowIndex")->applyFromArray($styleArray2)->getNumberFormat()->setFormatCode("#,##0.00");
            $sheet->setCellValue("S$rowIndex", "=SUM(S$startTotalIndex:S$endTotalIndex)")->getStyle("S$rowIndex")->applyFromArray($styleArray2)->getNumberFormat()->setFormatCode("#,##0.00");
            $sheet->setCellValue("T$rowIndex", "=SUM(T$startTotalIndex:T$endTotalIndex)")->getStyle("T$rowIndex")->applyFromArray($styleArray2)->getNumberFormat()->setFormatCode("#,##0.00");
            $sheet->setCellValue("V$rowIndex", "=SUM(V$startTotalIndex:V$endTotalIndex)")->getStyle("V$rowIndex")->applyFromArray($styleArray2)->getNumberFormat()->setFormatCode("#,##0.00");
            $sheet->setCellValue("W$rowIndex", "=SUM(W$startTotalIndex:W$endTotalIndex)")->getStyle("W$rowIndex")->applyFromArray($styleArray2)->getNumberFormat()->setFormatCode("#,##0.00");
            $sheet->setCellValue("X$rowIndex", "=SUM(X$startTotalIndex:X$endTotalIndex)")->getStyle("X$rowIndex")->applyFromArray($styleArray2)->getNumberFormat()->setFormatCode("#,##0.00");
            $sheet->setCellValue("Y$rowIndex", "=SUM(Y$startTotalIndex:Y$endTotalIndex)")->getStyle("Y$rowIndex")->applyFromArray($styleArray2)->getNumberFormat()->setFormatCode("#,##0.00");
            $sheet->setCellValue("Z$rowIndex", "=SUM(Z$startTotalIndex:Z$endTotalIndex)")->getStyle("Z$rowIndex")->applyFromArray($styleArray2)->getNumberFormat()->setFormatCode("#,##0.00");
            $sheet->setCellValue("AC$rowIndex", "=SUM(AC$startTotalIndex:AC$endTotalIndex)")->getStyle("AC$rowIndex")->applyFromArray($styleArray2)->getNumberFormat()->setFormatCode("#,##0.00");
            $sheet->setCellValue("AD$rowIndex", "=SUM(AD$startTotalIndex:AD$endTotalIndex)")->getStyle("AD$rowIndex")->applyFromArray($styleArray2)->getNumberFormat()->setFormatCode("#,##0.00");
            $sheet->setCellValue("AF$rowIndex", "=SUM(AF$startTotalIndex:AF$endTotalIndex)")->getStyle("AF$rowIndex")->applyFromArray($styleArray2)->getNumberFormat()->setFormatCode("#,##0.00");
            $sheet->setCellValue("AG$rowIndex", "=SUM(AG$startTotalIndex:AG$endTotalIndex)")->getStyle("AG$rowIndex")->applyFromArray($styleArray2)->getNumberFormat()->setFormatCode("#,##0.00");
            $sheet->setCellValue("AI$rowIndex", "=SUM(AI$startTotalIndex:AI$endTotalIndex)")->getStyle("AI$rowIndex")->applyFromArray($styleArray2)->getNumberFormat()->setFormatCode("#,##0.00");
            $sheet->setCellValue("AJ$rowIndex", "=SUM(AJ$startTotalIndex:AJ$endTotalIndex)")->getStyle("AJ$rowIndex")->applyFromArray($styleArray2)->getNumberFormat()->setFormatCode("#,##0.00");
            $sheet->setCellValue("AK$rowIndex", "=SUM(AK$startTotalIndex:AK$endTotalIndex)")->getStyle("AK$rowIndex")->applyFromArray($styleArray2)->getNumberFormat()->setFormatCode("#,##0.00");
            $sheet->setCellValue("AL$rowIndex", "=SUM(AL$startTotalIndex:AL$endTotalIndex)")->getStyle("AL$rowIndex")->applyFromArray($styleArray2)->getNumberFormat()->setFormatCode("#,##0.00");
            $sheet->setCellValue("AM$rowIndex", "=SUM(AM$startTotalIndex:AM$endTotalIndex)")->getStyle("AM$rowIndex")->applyFromArray($styleArray2)->getNumberFormat()->setFormatCode("#,##0.00");
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



        $writer = new Xlsx($spreadsheet);
        $filename = 'LAPORAN MINGGUAN SUPIR' . date('dmYHis');
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }
}

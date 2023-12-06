<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\RedirectResponse;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class LaporanKartuPiutangPerAgenController extends MyController
{
    public $title = 'Laporan Kartu Piutang Per Customer';

    public function index(Request $request)
    {
        $title = $this->title;
        $data = [
            'pagename' => 'Menu Utama Laporan Kartu Piutang Per Customer',
        ];

        return view('laporankartupiutangperagen.index', compact('title'));
    }

    public function report(Request $request)
    {
        $detailParams = [
            'dari' => $request->dari,
            'sampai' => $request->sampai,
            'agendari' => $request->agendari,
            'agensampai' => $request->agensampai,
            'agendari_id' => $request->agendari_id,
            'agensampai_id' => $request->agensampai_id,

        ];
        // dd($detailParams);
        $header = Http::withHeaders(request()->header())
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'laporankartupiutangperagen/report', $detailParams);

        $data = $header['data'];
        $user = Auth::user();

        return view('reports.laporankartupiutangperagen', compact('data', 'user', 'detailParams'));
    }

    public function export(Request $request): void
    {
        $detailParams = [
            'dari' => $request->dari,
            'sampai' => $request->sampai,
            'agendari' => $request->agendari,
            'agensampai' => $request->agensampai,
            'agendari_id' => $request->agendari_id,
            'agensampai_id' => $request->agensampai_id,

        ];

        $responses = Http::withHeaders($request->header())
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'laporankartupiutangperagen/export', $detailParams);

        $pengeluaran = $responses['data'];

        if(count($pengeluaran) == 0){
            throw new \Exception('TIDAK ADA DATA');
        }
        
        $disetujui = $pengeluaran[0]['disetujui'] ?? '';
        $diperiksa = $pengeluaran[0]['diperiksa'] ?? '';
        $user = Auth::user();
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', $pengeluaran[0]['judul']);
        $sheet->getStyle("A1")->getFont()->setSize(16)->setBold(true);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal('center');
        $sheet->mergeCells('A1:J1');

        $englishMonths = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
        $indonesianMonths = ['JANUARI', 'FEBRUARI', 'MARET', 'APRIL', 'MEI', 'JUNI', 'JULI', 'AGUSTUS', 'SEPTEMBER', 'OKTOBER', 'NOVEMBER', 'DESEMBER'];
        $tanggal = str_replace($englishMonths, $indonesianMonths, date('d - M - Y', strtotime($request->dari)));

        $sheet->setCellValue('A2', strtoupper($pengeluaran[0]['judulLaporan']));
        $sheet->getStyle("A2")->getFont()->setBold(true);
        $sheet->mergeCells('A2:J2');

        $sheet->setCellValue('A3', strtoupper('Periode : ' . $tanggal));
        $sheet->getStyle("A3")->getFont()->setBold(true);
        $sheet->mergeCells('A3:J3');

        $agendari=$request->agendari ?? '';
        $agensampai=$request->agensampai ?? '';
        if ($agendari=='' || $agensampai=='') {
            $sheet->setCellValue('A4', strtoupper('Customer : SEMUA'));
        } else {
            $sheet->setCellValue('A4', strtoupper('Customer : ' . $request->agendari . ' S/D ' . $request->agensampai));
        }

        $sheet->getStyle("A4")->getFont()->setBold(true);
        $sheet->mergeCells('A4:J4');

        $header_start_row = 6;
        $detail_start_row = 7;

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

        ];

        $borderHorizontal = [
            'borders' => [
                'top' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
            ],
        ];

        $alphabets = range('A', 'Z');



        $header_columns = [
            [
                'label' => 'No',
            ],
            [
                'label' => 'No Bukti',
                'index' => 'nobukti',
            ],
            [
                'label' => 'Tgl Inv',
                'index' => 'tglbukti',
            ],
            [
                'label' => 'Nominal',
                'index' => 'nominal',
            ],
            [
                'label' => 'Tgl Bayar',
                'index' => 'tgllunas',
            ],
            [
                'label' => 'Bayar',
                'index' => 'bayar',
            ],
            [
                'label' => 'Saldo',
                'index' => 'Saldo',
            ],

        ];


        $totalDebet = 0;
        $totalKredit = 0;
        $totalSaldo = 0;
        $no = 1;
        $agen = '';
        $groupedData = [];
        if (is_array($pengeluaran)) {

            foreach ($pengeluaran as $row) {
                $jenispiutang = $row['jenispiutang'];
                $agen_id = $row['agen_id'];
                $groupedData[$jenispiutang][$agen_id][] = $row;
            }
        }

        $sumBayar = [];
        $sumNominal = [];
        if (is_array($pengeluaran) || is_iterable($pengeluaran)) {
            foreach ($groupedData as $jenispiutang => $group) {
                $startcell = $detail_start_row;


                foreach ($group as $customer => $row) {
                    $startcellcustomer = $detail_start_row + 2;
                    $sheet->setCellValue("A$detail_start_row", 'Customer : ' . $customer)->getStyle("A$detail_start_row")->getFont()->setBold(true);
                    $detail_start_row++;
                    foreach ($header_columns as $data_columns_index => $data_column) {

                        $sheet->setCellValue($alphabets[$data_columns_index] . $detail_start_row, $data_column['label'] ?? $data_columns_index + 1);
                        $lastColumn = $alphabets[$data_columns_index];
                        $sheet->getStyle("A$detail_start_row:$lastColumn$detail_start_row")->applyFromArray($styleArray)->getFont()->setBold(true);
                    }
                    $detail_start_row++;
                    $bayarCell = 'F' . ($detail_start_row + count($row));
                    $nominalCell = 'D' . ($detail_start_row + count($row));
                    // // DATA
                    $prevNobukti = '';
                    foreach ($row as $response_detail) {
                        $nobukti = $response_detail['nobuktipiutang'];

                        $tglbukti = ($response_detail['tglbukti'] != null) ? Date::PHPToExcel(date('Y-m-d', strtotime($response_detail['tglbukti']))) : '';
                        $tgllunas = ($response_detail['tgllunas'] != null) ? Date::PHPToExcel(date('Y-m-d', strtotime($response_detail['tgllunas']))) : '';

                        $sheet->setCellValue("B$detail_start_row", $response_detail['nobukti']);
                        $sheet->setCellValue("C$detail_start_row", $tglbukti);
                        $sheet->setCellValue("D$detail_start_row", $response_detail['nominalpiutang']);
                        $sheet->setCellValue("E$detail_start_row", $tgllunas);
                        $sheet->setCellValue("F$detail_start_row", $response_detail['nominallunas']);
                        if ($prevNobukti == '') {
                            $sheet->setCellValue("G$detail_start_row", "=D$detail_start_row-F$detail_start_row");
                        }
                        if ($nobukti != $prevNobukti) {
                            $sheet->setCellValue("G$detail_start_row", "=D$detail_start_row-F$detail_start_row");
                        } else {
                            $sheet->setCellValue("G$detail_start_row", "=(G" . ($detail_start_row - 1) . "+D$detail_start_row)-F$detail_start_row");
                        }

                        if ($nobukti != $prevNobukti) {
                            $sheet->setCellValue("A$detail_start_row", $no++);
                            if ($prevNobukti != '') {

                                $sheet->getStyle("A" . ($detail_start_row) . ":G" . ($detail_start_row))->applyFromArray($borderHorizontal);
                            }
                        }

                        $sheet->getStyle("A" . ($detail_start_row))->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                        $sheet->getStyle("G" . ($detail_start_row))->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

                        $sheet->getStyle("C$detail_start_row")->getNumberFormat()->setFormatCode('dd-mm-yyyy');
                        $sheet->getStyle("D$detail_start_row")->getNumberFormat()->setFormatCode("#,##0.00_);(#,##0.00)");
                        $sheet->getStyle("E$detail_start_row")->getNumberFormat()->setFormatCode('dd-mm-yyyy');
                        $sheet->getStyle("F$detail_start_row")->getNumberFormat()->setFormatCode("#,##0.00_);(#,##0.00)");
                        $sheet->getStyle("G$detail_start_row")->getNumberFormat()->setFormatCode("#,##0.00_);(#,##0.00)");
                        $detail_start_row++;
                        $prevNobukti = $nobukti;
                    }
                    
                    $sheet->getStyle("F$detail_start_row")->getNumberFormat()->setFormatCode("#,##0.00_);(#,##0.00)");
                    $sheet->getStyle("G$detail_start_row")->getNumberFormat()->setFormatCode("#,##0.00_);(#,##0.00)");
                    $sheet->getStyle("D$detail_start_row")->getNumberFormat()->setFormatCode("#,##0.00_);(#,##0.00)");
                $sheet->setCellValue('A' . $detail_start_row, 'TOTAL ' )->getStyle("A$detail_start_row")->getFont()->setBold(true);
                $sheet->setCellValue('F' . $detail_start_row, "=SUM(F$startcellcustomer:$bayarCell)")->getStyle("F$detail_start_row")->applyFromArray($style_number)->getFont()->setBold(true);
                $sheet->setCellValue('D' . $detail_start_row, "=SUM(D$startcellcustomer:$nominalCell)")->getStyle("D$detail_start_row")->applyFromArray($style_number)->getFont()->setBold(true);
                $sheet->setCellValue('G' . $detail_start_row, "=D$detail_start_row-F$detail_start_row")->getStyle("G$detail_start_row")->applyFromArray($style_number)->getFont()->setBold(true);
                array_push($sumBayar, 'F' . $detail_start_row);
                array_push($sumNominal, 'D' . $detail_start_row);
                $sheet->getStyle("A" . ($detail_start_row) . ":G" . ($detail_start_row))->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                $sheet->getStyle("A" . ($detail_start_row) . ":G" . ($detail_start_row))->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                $sheet->getStyle("A" . ($detail_start_row))->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                $sheet->getStyle("G" . ($detail_start_row))->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                $detail_start_row++;

                    if ($prevNobukti != '') {
                        $sheet->getStyle("A" . ($detail_start_row) . ":G" . ($detail_start_row))->applyFromArray($borderHorizontal);
                    }
                    $no = 1;
                    $detail_start_row++;
                }
                // $detail_start_row--;
                // $sheet->getStyle("F$detail_start_row")->getNumberFormat()->setFormatCode("#,##0.00_);(#,##0.00)");
                // $sheet->getStyle("G$detail_start_row")->getNumberFormat()->setFormatCode("#,##0.00_);(#,##0.00)");
                // $sheet->getStyle("D$detail_start_row")->getNumberFormat()->setFormatCode("#,##0.00_);(#,##0.00)");
                // $sheet->setCellValue('A' . $detail_start_row, 'TOTAL ' . $jenispiutang)->getStyle("A$detail_start_row")->getFont()->setBold(true);
                // $sheet->setCellValue('F' . $detail_start_row, "=SUM(F$startcell:$bayarCell)")->getStyle("F$detail_start_row")->applyFromArray($style_number)->getFont()->setBold(true);
                // $sheet->setCellValue('D' . $detail_start_row, "=SUM(D$startcell:$nominalCell)")->getStyle("D$detail_start_row")->applyFromArray($style_number)->getFont()->setBold(true);
                // $sheet->setCellValue('G' . $detail_start_row, "=D$detail_start_row-F$detail_start_row")->getStyle("G$detail_start_row")->applyFromArray($style_number)->getFont()->setBold(true);
                // array_push($sumBayar, 'F' . $detail_start_row);
                // array_push($sumNominal, 'D' . $detail_start_row);

                // $sheet->getStyle("A" . ($detail_start_row) . ":G" . ($detail_start_row))->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                // $sheet->getStyle("A" . ($detail_start_row) . ":G" . ($detail_start_row))->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                // $sheet->getStyle("A" . ($detail_start_row))->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                // $sheet->getStyle("G" . ($detail_start_row))->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);


                $detail_start_row += 3;
            }

            $total_start_row = $detail_start_row - 3;

            $sheet->setCellValue('A' . $total_start_row, 'TOTAL KARTU PIUTANG')->getStyle("A$total_start_row")->getFont()->setBold(true);
            $totalBayar = "=" . implode('+', $sumBayar);
            $totalNominal = "=" . implode('+', $sumNominal);
            $sheet->setCellValue("D$total_start_row", $totalNominal)->getStyle("D$total_start_row")->applyFromArray($style_number)->getFont()->setBold(true);
            $sheet->getStyle("D$total_start_row")->getNumberFormat()->setFormatCode("#,##0.00_);(#,##0.00)");
            $sheet->setCellValue("F$total_start_row", $totalBayar)->getStyle("F$total_start_row")->applyFromArray($style_number)->getFont()->setBold(true);
            $sheet->getStyle("F$total_start_row")->getNumberFormat()->setFormatCode("#,##0.00_);(#,##0.00)");
            $sheet->setCellValue("G$total_start_row", "=D$total_start_row-F$total_start_row")->getStyle("G$total_start_row")->applyFromArray($style_number)->getFont()->setBold(true);
            $sheet->getStyle("G$total_start_row")->getNumberFormat()->setFormatCode("#,##0.00_);(#,##0.00)");

            $sheet->getStyle("A" . ($total_start_row) . ":G" . ($total_start_row))->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
            $sheet->getStyle("A" . ($total_start_row) . ":G" . ($total_start_row))->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
            $sheet->getStyle("A" . ($total_start_row))->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
            $sheet->getStyle("G" . ($total_start_row))->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

        }

        $ttd_start_row = $detail_start_row + 2;
        $sheet->setCellValue("B$ttd_start_row", 'Disetujui Oleh,');
        $sheet->setCellValue("D$ttd_start_row", 'Diperiksa Oleh,');
        $sheet->setCellValue("F$ttd_start_row", 'Disusun Oleh,');

        $sheet->setCellValue("B" . ($ttd_start_row + 3), '( ' . $disetujui . ' )');
        $sheet->setCellValue("D" . ($ttd_start_row + 3), '( ' . $diperiksa . ' )');
        $sheet->setCellValue("F" . ($ttd_start_row + 3), '(                )');

        //ukuran kolom
        $sheet->getColumnDimension('A')->setWidth(4);
        $sheet->getColumnDimension('B')->setAutoSize(true);
        $sheet->getColumnDimension('C')->setAutoSize(true);
        $sheet->getColumnDimension('D')->setAutoSize(true);
        $sheet->getColumnDimension('E')->setAutoSize(true);
        $sheet->getColumnDimension('F')->setAutoSize(true);
        $sheet->getColumnDimension('G')->setAutoSize(true);


        $writer = new Xlsx($spreadsheet);
        $filename = 'LAPORAN KARTU PIUTANG PER CUSTOMER' . date('dmYHis');
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }
}

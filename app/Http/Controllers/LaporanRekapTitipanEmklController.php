<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Menu;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class LaporanRekapTitipanEmklController extends MyController
{
    public $title = 'Laporan Rekap Titipan EMKL';

    public function index(Request $request)
    {
        $title = $this->title;

        $data = [
            'pagename' => 'Menu Utama Laporan Rekap Titipan EMKL',
        ];

        return view('laporanrekaptitipanemkl.index', compact('title'));
    }



    public function report(Request $request)
    {
        $detailParams = [
            'periode' => $request->periode,
        ];

        $header = Http::withHeaders(request()->header())
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'laporanrekaptitipanemkl/report', $detailParams);

        $data = $header['data'];
        $dataCabang['namacabang'] = $header['namacabang'];
        $user = Auth::user();
        return view('reports.laporanrekaptitipanemkl', compact('data','dataCabang', 'user', 'detailParams'));
    }

    public function export(Request $request): void
    {
        $detailParams = [
            'periode' => $request->periode,
        ];

        $responses = Http::withHeaders($request->header())
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'laporanrekaptitipanemkl/export', $detailParams);

        $pengeluaran = $responses['data'];

        if(count($pengeluaran) == 0){
            throw new \Exception('TIDAK ADA DATA');
        }

        // dd($pengeluaran);
        $namacabang = $responses['namacabang'];
        $user = Auth::user();
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', $pengeluaran[0]['judul']);
        $sheet->setCellValue('A2', $namacabang);
        $sheet->setCellValue('A3', $pengeluaran[0]['judullaporan']);
        $sheet->setCellValue('A4', 'Periode : ' . date('d-M-Y', strtotime($request->periode)));

        $sheet->getStyle("A1")->getFont()->setSize(16)->setBold(true);
        $sheet->getStyle("A2")->getFont()->setSize(16)->setBold(true);

        $sheet->getStyle('A1')->getAlignment()->setHorizontal('center');
        $sheet->getStyle('A2')->getAlignment()->setHorizontal('center');
        $sheet->getStyle("A3")->getFont()->setBold(true);
        $sheet->getStyle("A4")->getFont()->setBold(true);
        $sheet->mergeCells('A1:E1');
        $sheet->mergeCells('A2:E2');

        $header_start_row = 5;
        $detail_start_row = 6;

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

            'borders' => array(
                'allBorders' => array(
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ),
            ),
        ];

        $alphabets = range('A', 'Z');



        $header_columns = [
            [
                "index" => "no",
                "label" => "No"
            ],
            [
                "index" => "nobukti",
                "label" => "No Bukti"
            ],
            [
                "index" => "tglbukti",
                "label" => "Tanggal"
            ],
            [
                "index" => "keterangan",
                "label" => "Keterangan"
            ],
            [
                "index" => "nominal",
                "label" => "Nominal"
            ],
            [
                "index" => "jenisorder",
                "label" => "Jenis Order"
            ],

        ];

        $tradoPrev = null;


        // Group data by jenislaporan
        $groupedData = [];
        if (is_array($pengeluaran)) {

            foreach ($pengeluaran as $row) {
                $jenislaporan = $row['jenislaporan'];
                $groupedData[$jenislaporan][] = $row;
            }
        }
        $prevJenis = '';
        $sumTotal = [];
        $no = 1;
        if (is_array($pengeluaran) || is_iterable($pengeluaran)) {
            foreach ($groupedData as $jenislaporan => $group) {
                // HEADER

                foreach ($header_columns as $data_columns_index => $data_column) {
                    if ($jenislaporan == 'PIUTANG LAIN') {
                        if ($data_column['index'] != 'jenisorder') {
                            $sheet->setCellValue($alphabets[$data_columns_index] . $detail_start_row, $data_column['label'] ?? $data_columns_index + 1);
                            $lastColumn = $alphabets[$data_columns_index];
                            $sheet->getStyle("A$detail_start_row:$lastColumn$detail_start_row")->applyFromArray($styleArray)->getFont()->setBold(true);
                        }
                    } else {
                        $sheet->setCellValue($alphabets[$data_columns_index] . $detail_start_row, $data_column['label'] ?? $data_columns_index + 1);
                        $lastColumn = $alphabets[$data_columns_index];
                        $sheet->getStyle("A$detail_start_row:$lastColumn$detail_start_row")->applyFromArray($styleArray)->getFont()->setBold(true);
                    }
                }


                $detail_start_row++;
                $totalCell = 'E' . ($detail_start_row + count($group));

                // DATA
                foreach ($group as $response_detail) {
                    $dateValue = ($response_detail['tglbukti'] != null) ? Date::PHPToExcel(date('Y-m-d', strtotime($response_detail['tglbukti']))) : '';

                    $sheet->setCellValue("A$detail_start_row", $no++);
                    $sheet->setCellValue("B$detail_start_row", $response_detail['nobukti']);
                    $sheet->setCellValue("C$detail_start_row", $dateValue);
                    $sheet->setCellValue("D$detail_start_row", $response_detail['keterangan']);
                    $sheet->setCellValue("E$detail_start_row", $response_detail['nominal']);
                    $sheet->setCellValue("F$detail_start_row", $response_detail['jenisorder']);

                    if ($jenislaporan == 'PIUTANG LAIN') {
                        $sheet->getStyle("A$detail_start_row:E$detail_start_row")->applyFromArray($styleArray);
                    } else {
                        $sheet->getStyle("A$detail_start_row:F$detail_start_row")->applyFromArray($styleArray);
                    }
                    $sheet->getStyle("C$detail_start_row")->getNumberFormat()->setFormatCode('dd-mm-yyyy');
                    $sheet->getStyle("E$detail_start_row")->getNumberFormat()->setFormatCode("#,##0.00");
                    $detail_start_row++;
                }
                // $sheet->setCellValue("E$detail_start_row", $response_detail['saldo']);
                $sheet->mergeCells("A$detail_start_row:D$detail_start_row");
                if ($jenislaporan == 'PIUTANG LAIN') {
                    $sheet->getStyle("A$detail_start_row:E$detail_start_row")->applyFromArray($styleArray);
                } else {
                    $sheet->getStyle("A$detail_start_row:F$detail_start_row")->applyFromArray($styleArray);
                }
                $sheet->getStyle("E$detail_start_row")->getNumberFormat()->setFormatCode("#,##0.00");
                $sheet->setCellValue('A' . $detail_start_row, 'TOTAL ' . $jenislaporan)->getStyle("A$detail_start_row")->getFont()->setBold(true);
                $sheet->getStyle("A$detail_start_row")->getAlignment()->setHorizontal('center');
                $sheet->setCellValue('E' . $detail_start_row, "=SUM(E" . ($detail_start_row - count($group)) . ":$totalCell)")->getStyle("E$detail_start_row")->applyFromArray($style_number)->getFont()->setBold(true);
                array_push($sumTotal, 'E' . $detail_start_row);
                $detail_start_row += 3;

                $no = 1;
            }
        }

        //total
        $total_start_row = $detail_start_row - 2;

        $sheet->mergeCells("A$total_start_row:D$total_start_row");
        $sheet->setCellValue("A$total_start_row", 'TOTAL')->getStyle('A' . $total_start_row . ':E' . $total_start_row)->applyFromArray($styleArray)->getFont()->setBold(true);

        $sheet->getStyle("A$total_start_row")->getAlignment()->setHorizontal('center');

        // $totalDebet = "=SUM(E6:E" . ($detail_start_row - 1) . ")";
        // $sheet->setCellValue("E$total_start_row", $totalDebet)->getStyle("E$total_start_row")->applyFromArray($style_number);
        // $sheet->setCellValue("E$total_start_row", $totalDebet)->getStyle("E$total_start_row")->getNumberFormat()->setFormatCode("#,##0.00");
        $totalDebet = "=" . implode('+', $sumTotal);
        $sheet->setCellValue("E$total_start_row", $totalDebet)->getStyle("E$total_start_row")->applyFromArray($style_number)->getFont()->setBold(true);
        $sheet->setCellValue("E$total_start_row", $totalDebet)->getStyle("E$total_start_row")->getNumberFormat()->setFormatCode("#,##0.00");

        $ttd_start_row = $total_start_row + 2;
        // $sheet->setCellValue("A$ttd_start_row", 'Disetujui Oleh,');
        // $sheet->setCellValue("C$ttd_start_row", 'Diperiksa Oleh,');
        // $sheet->setCellValue("E$ttd_start_row", 'Disusun Oleh,');

        // $sheet->setCellValue("A" . ($ttd_start_row + 3), '(                )');
        // $sheet->setCellValue("C" . ($ttd_start_row + 3), '(                )');
        // $sheet->setCellValue("E" . ($ttd_start_row + 3), '(                )');

        //ukuran kolom
        $sheet->getColumnDimension('A')->setWidth(4);
        $sheet->getColumnDimension('B')->setWidth(20);
        $sheet->getColumnDimension('C')->setWidth(11);
        $sheet->getColumnDimension('D')->setWidth(74);
        $sheet->getColumnDimension('E')->setAutoSize(true);
        $sheet->getColumnDimension('F')->setAutoSize(true);




        $writer = new Xlsx($spreadsheet);
        $filename = 'Laporan Rekap Titipan EMKL' . date('dmYHis');
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }
}

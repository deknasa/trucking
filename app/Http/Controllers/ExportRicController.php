<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;


class ExportRicController extends MyController
{
    public $title = 'Export RIC';

    public function index(Request $request)
    {
        $title = $this->title;
        $data = [
            'pagename' => 'Menu Utama Export RIC',
        ];

        return view('exportric.index', compact('title'));
    }

    public function export(Request $request): void
    {
        $detailParams = [
            'periode' => $request->periode,
            'statusric' => $request->statusric,
            'dari' => $request->dari,
            'sampai' => $request->sampai,
            'kelompok_id' => $request->kelompok_id,
            'trado_id' => $request->trado_id,
        ];

        $responses = Http::withHeaders(request()->header())
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'exportric/export', $detailParams);
        $data = $responses['data'];
        $spreadsheet = new Spreadsheet();
        if (count($data) > 0) {
            $sheet = $spreadsheet->getActiveSheet();
            $sheet->setCellValue('A1', $data[0]['judul']);
            $sheet->getStyle("A1")->getFont()->setSize(16);
            $sheet->getStyle('A1')->getAlignment()->setHorizontal('center');
            $sheet->mergeCells('A1:K1');

            $sheet->setCellValue('A2', $data[0]['judulLaporan']);
            $sheet->mergeCells('A2:K2');

            $header_start_row = 4;
            $detail_start_row = 5;

            $styleArray = array(
                'borders' => array(
                    'allBorders' => array(
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    ),
                ),
            );
            $header_columns = [
                [
                    'label' => 'No Bukti',
                    'index' => 'nobukti',
                ],
                [
                    'label' => 'Tanggal',
                    'index' => 'tglbukti',
                ],
                [
                    'label' => 'Nama Barang',
                    'index' => 'namabarang',
                ],
                [
                    'label' => 'QTY',
                    'index' => 'qty',
                ],
                [
                    'label' => 'Satuan',
                    'index' => 'satuan',
                ],
                [
                    'label' => 'Status Kendaraan',
                    'index' => 'statuskendaraan',
                ],
                [
                    'label' => 'Pergantian Ke',
                    'index' => 'pergantianke',
                ],
                [
                    'label' => 'KM Ke',
                    'index' => 'kmke',
                ],
                [
                    'label' => 'Selisih KM',
                    'index' => 'selisihkm',
                ],
                [
                    'label' => 'Keterangan',
                    'index' => 'keterangan',
                ],
                [
                    'label' => 'Keterangan Tambahan',
                ],
            ];

            $alphabets = range('A', 'Z');

            foreach ($header_columns as $data_columns_index => $data_column) {
                $sheet->setCellValue($alphabets[$data_columns_index] . $header_start_row, $data_column['label'] ?? $data_columns_index + 1);
            }

            $lastColumn = $alphabets[$data_columns_index];
            $sheet->getStyle("A$header_start_row:$lastColumn$header_start_row")->applyFromArray($styleArray)->getFont()->setBold(true);

            foreach ($data as $response_index => $response_detail) {
                foreach ($header_columns as $detail_columns_index => $detail_column) {
                    $sheet->setCellValue($alphabets[$detail_columns_index] . $detail_start_row, isset($detail_column['index']) ? $response_detail[$detail_column['index']] : $response_index + 1);
                }
                $sheet->setCellValue("A$detail_start_row", $response_detail['nobukti']);
                $sheet->setCellValue("B$detail_start_row", date('d-m-Y', strtotime($response_detail['tglbukti'])));
                $sheet->setCellValue("C$detail_start_row", $response_detail['namabarang']);
                $sheet->setCellValue("D$detail_start_row", $response_detail['qty']);
                $sheet->setCellValue("E$detail_start_row", $response_detail['satuan']);
                $sheet->setCellValue("F$detail_start_row", $response_detail['statuskendaraan']);
                $sheet->setCellValue("G$detail_start_row", $response_detail['pergantianke']);
                $sheet->setCellValue("H$detail_start_row", $response_detail['kmke']);
                $sheet->setCellValue("I$detail_start_row", $response_detail['selisihkm']);
                $sheet->setCellValue("J$detail_start_row", $response_detail['keterangan']);
                $sheet->setCellValue("K$detail_start_row", '=A'.$detail_start_row.' & " " & B'.$detail_start_row.' & " Penambahan Oli Ke-" & G'.$detail_start_row.'& ",(Selisih KM : " & I'.$detail_start_row.' & "), KM Ke-" & H'.$detail_start_row.' & " (" & ABS(D'.$detail_start_row.') & " Liter )" & " Keterangan : " & J'.$detail_start_row);

                // =A4 & " " & TEXT(B4,"dd/mmm/yyyy") & " Penambahan Oli Ke-" & G4 & ",(Selisih KM : " & I4 & "), KM Ke-" & H4 & " (" & ABS(D4) & " Liter )" & " Keterangan : " & J4
                $sheet->getStyle("A$detail_start_row:K$detail_start_row")->applyFromArray($styleArray);
                $sheet->getStyle("J$detail_start_row:K$detail_start_row")->getAlignment()->setWrapText(true);
                $sheet->getColumnDimension('J')->setWidth(50);
                $sheet->getColumnDimension('K')->setWidth(100);
                $detail_start_row++;
            }

            $sheet->getColumnDimension('A')->setAutoSize(true);
            $sheet->getColumnDimension('B')->setAutoSize(true);
            $sheet->getColumnDimension('C')->setAutoSize(true);
            $sheet->getColumnDimension('D')->setAutoSize(true);
            $sheet->getColumnDimension('E')->setAutoSize(true);
            $sheet->getColumnDimension('F')->setAutoSize(true);
            $sheet->getColumnDimension('G')->setAutoSize(true);
            $sheet->getColumnDimension('H')->setAutoSize(true);
            $sheet->getColumnDimension('I')->setAutoSize(true);
        }

        $writer = new Xlsx($spreadsheet);
        $filename = 'ExportRIC' . date('dmYHis');
        header('Content-Type: application/vnd.ms-excel');
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

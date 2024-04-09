<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class LaporanHistoryTradoMilikMandorController extends MyController
{
    public $title = 'Laporan History Trado Milik Mandor';

    public function index(Request $request)
    {
        $title = $this->title;
        return view('laporanhistorytradomilikmandor.index', compact('title'));
    }

    public function report(Request $request)
    {
        $detailParams = [
            'trado_id' => $request->trado_id,
        ];

        $header = Http::withHeaders(request()->header())
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'laporanhistorytradomilikmandor/report', $detailParams);

        $data = $header['data'];
        $dataCabang['namacabang'] = $header['namacabang'];

        $user = Auth::user();
        return view('reports.laporanhistorytradomilikmandor', compact('data','dataCabang'));
    }

    public function export(Request $request): void
    {
        $detailParams = [
            'trado_id' => $request->trado_id,
        ];

        $header = Http::withHeaders(request()->header())
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'laporanhistorytradomilikmandor/export', $detailParams);

        $data = $header['data'];

        if (count($data) == 0) {
            throw new \Exception('TIDAK ADA DATA');
        }
        $namacabang = $header['namacabang'];

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', $data[0]['judul']);
        $sheet->getStyle("A1")->getFont()->setSize(16)->setBold(true);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal('center');
        $sheet->mergeCells('A1:E1');
        $sheet->setCellValue('A2', $namacabang);
        $sheet->getStyle("A2")->getFont()->setSize(16)->setBold(true);
        $sheet->getStyle('A2')->getAlignment()->setHorizontal('center');
        $sheet->mergeCells('A2:E2');


        $sheet->setCellValue('A3', $data[0]['judulLaporan']);

        $sheet->getStyle("A3")->getFont()->setBold(true);

        $detail_start_row = 5;

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

            'borders' => [
                'top' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
                'right' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
                'bottom' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
                'left' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN]
            ]
        ];

        $alphabets = range('A', 'Z');

        $detail_columns = [
            [
                'label' => 'No'
            ],
            [
                'label' => 'Trado',
                'index' => 'kodetrado',
            ],
            [
                'label' => 'Mandor Baru',
                'index' => 'mandorbaru',
            ],
            [
                'label' => 'Mandor Lama',
                'index' => 'mandorlama',
            ],
            [
                'label' => 'Tgl Berlaku',
                'index' => 'tglberlaku',
            ],
        ];


        // foreach ($detail_columns as $detail_columns_index => $detail_column) {
        //     $sheet->setCellValue($alphabets[$detail_columns_index] . $detail_table_header_row, $detail_column['label'] ?? $detail_columns_index + 1);
        // }
        // $sheet->getStyle("A$detail_table_header_row:G$detail_table_header_row")->applyFromArray($styleArray)->getFont()->setBold(true);

        // LOOPING DETAIL
        $groupedData = [];
        if (is_array($data)) {

            foreach ($data as $row) {
                $trado_id = $row['trado_id'];
                $groupedData[$trado_id][] = $row;
            }
        }
        foreach ($groupedData as $supir => $row) {
            $sheet->setCellValue("A$detail_start_row", 'Trado : ' . $row[0]['kodetrado'])->getStyle("A$detail_start_row")->getFont()->setBold(true);
            $detail_start_row++;
            foreach ($detail_columns as $data_columns_index => $data_column) {

                $sheet->setCellValue($alphabets[$data_columns_index] . $detail_start_row, $data_column['label'] ?? $data_columns_index + 1);
                $lastColumn = $alphabets[$data_columns_index];
                $sheet->getStyle("A$detail_start_row:$lastColumn$detail_start_row")->applyFromArray($styleArray)->getFont()->setBold(true);
            }
            $detail_start_row++;
            // // DATA
            $no = 1;
            foreach ($row as $response_detail) {
                $tglberlaku = ($response_detail['tglberlaku'] != null) ? Date::PHPToExcel(date('Y-m-d', strtotime($response_detail['tglberlaku']))) : '';

                $sheet->setCellValue("A$detail_start_row", $no++);
                $sheet->setCellValue("B$detail_start_row", $response_detail['kodetrado']);
                $sheet->setCellValue("C$detail_start_row", $response_detail['mandorbaru']);
                $sheet->setCellValue("D$detail_start_row", $response_detail['mandorlama']);
                $sheet->setCellValue("E$detail_start_row", $tglberlaku);


                $sheet->getStyle("E$detail_start_row")->getNumberFormat()->setFormatCode('dd-mm-yyyy');
                $sheet->getStyle("A$detail_start_row:E$detail_start_row")->applyFromArray($styleArray);
                $detail_start_row++;

            }
            $detail_start_row++;

        }


        $sheet->getColumnDimension('A')->setWidth(4);
        $sheet->getColumnDimension('B')->setAutoSize(true);
        $sheet->getColumnDimension('C')->setAutoSize(true);
        $sheet->getColumnDimension('D')->setAutoSize(true);
        $sheet->getColumnDimension('E')->setAutoSize(true);

        $writer = new Xlsx($spreadsheet);
        $filename = 'LAPORAN HISTORY TRADO MILIK MANDOR' . date('dmYHis');
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }
}

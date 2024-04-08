<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class StokPersediaanController extends MyController
{
    public $title = 'Stok Persediaan';
    
    public function index(Request $request)
    {
        $title = $this->title;
        return view('stokpersediaan.index', compact('title'));
    }

    public function report(Request $request)
    {
        $detailParams = [
            'filter' => $request->filter,
            'datafilter' => $request->datafilter,
        ];

        $header = Http::withHeaders(request()->header())
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'stokpersediaan/report', $detailParams);

        $data = $header['data'];
        $dataHeader = $header['dataheader'];

        return view('reports.stokpersediaan', compact('data','dataHeader'));
    }

    public function export(Request $request): void
    {
        $detailParams = [
            'filter' => $request->filter,
            'datafilter' => $request->datafilter,
            'forReport' => true,
        ];

        $header = Http::withHeaders(request()->header())
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'stokpersediaan/export', $detailParams);

        $data = $header['data'];
        $dataHeader = $header['dataheader'];
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', $dataHeader['judul']);
        $sheet->getStyle("A1")->getFont()->setSize(16);
        $sheet->getStyle("A1")->getFont()->setBold(true);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal('center');
        $sheet->mergeCells('A1:B1');
        $sheet->setCellValue('A2', $dataHeader['namacabang']);
        $sheet->getStyle("A2")->getFont()->setSize(16);
        $sheet->getStyle("A2")->getFont()->setBold(true);
        $sheet->getStyle('A2')->getAlignment()->setHorizontal('center');
        $sheet->mergeCells('A2:B2');


        $sheet->setCellValue('A3', $dataHeader['judulLaporan']);
        $sheet->getStyle("A3")->getFont()->setBold(true);
        $sheet->mergeCells('A3:B3');
        
        $sheet->setCellValue('A4', $dataHeader['filter']);
        $sheet->getStyle("A4")->getFont()->setBold(true);
        $sheet->setCellValue('B4', ': '.$dataHeader['datafilter']);
        $sheet->getStyle('B4')->getAlignment()->setHorizontal('left');
        $sheet->getStyle("B4")->getFont()->setBold(true);

        $header_start_row = 2;
        $header_right_start_row = 2;
        $detail_table_header_row = 6;
        $detail_start_row = $detail_table_header_row + 1;

        $alphabets = range('A', 'Z');
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

        $header_columns = [
            [
                'label' => 'Stok',
                'index' => 'stok_id',
            ],
            [
                'label' => 'QTY',
                'index' => 'qty',
            ],
            

        ];
        //         "filter" => "GUDANG"
        //   "datafilter" => "GUDANG KANTOR"
        foreach ($header_columns as $detail_columns_index => $detail_column) {
            $sheet->setCellValue($alphabets[$detail_columns_index] . $detail_table_header_row, $detail_column['label'] ?? $detail_columns_index + 1);
            $sheet->getStyle($alphabets[$detail_columns_index] . $detail_table_header_row)->getFont()->setBold(true);
        }

        foreach ($data as $response_index => $response_detail) {
            // dd($response_detail);
            foreach ($header_columns as $detail_columns_index => $detail_column) {
                $sheet->setCellValue($alphabets[$detail_columns_index] . $detail_start_row,$response_detail[$detail_column['index']] );
            }
            // $sheet->setCellValue($alphabets[0] . $detail_table_header_row, $response_detail['index'] ?? $detail_columns_index + 1);



            $detail_start_row++;
        }
        $endRow = $detail_start_row-1;
        $sheet->getStyle("A$detail_table_header_row:B$endRow")->applyFromArray($styleArray);
        $sheet->getColumnDimension('A')->setAutoSize(true);
                $sheet->getColumnDimension('B')->setAutoSize(true);
        $writer = new Xlsx($spreadsheet);
        $filename = $dataHeader['judulLaporan'] . date('dmYHis');
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
        header('Cache-Control: max-age=0');
        $writer->save('php://output');
    }
}
?>
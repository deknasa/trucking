<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class ProsesGajiSupirHeaderController extends MyController
{
    public $title = 'Proses Gaji Supir';

    public function index(Request $request)
    {
        $title = $this->title;
        $data = [
            'comboapproval' => $this->comboList('list', 'STATUS APPROVAL', 'STATUS APPROVAL'),
            'combocetak' => $this->comboList('list', 'STATUSCETAK', 'STATUSCETAK')
        ];
        return view('prosesgajisupirheader.index', compact('title', 'data'));
    }


    public function get($params = [])
    {
        $params = [
            'offset' => $params['offset'] ?? request()->offset ?? ((request()->page - 1) * request()->rows),
            'limit' => $params['rows'] ?? request()->rows ?? 0,
            'sortIndex' => $params['sidx'] ?? request()->sidx,
            'sortOrder' => $params['sord'] ?? request()->sord,
            'search' => json_decode($params['filters'] ?? request()->filters, 1) ?? [],
            'withRelations' => $params['withRelations'] ?? request()->withRelations ?? false,
        ];

        $response = Http::withHeaders(request()->header())
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'prosesgajisupirheader', $params);

        $data = [
            'total' => $response['attributes']['totalPages'] ?? [],
            'records' => $response['attributes']['totalRows'] ?? [],
            'rows' => $response['data'] ?? [],
            'params' => $response['params'] ?? [],
        ];

        return $data;
    }
    public function getNoBukti($group, $subgroup, $table)
    {
        $params = [
            'group' => $group,
            'subgroup' => $subgroup,
            'table' => $table
        ];

        $response = Http::withHeaders($this->httpHeaders)
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . "running_number", $params);

        $noBukti = $response['data'] ?? 'No bukti tidak ditemukan';

        return $noBukti;
    }

    public function comboList($aksi, $grp, $subgrp)
    {

        $status = [
            'status' => $aksi,
            'grp' => $grp,
            'subgrp' => $subgrp,
        ];

        $response = Http::withHeaders($this->httpHeaders)
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'parameter/combolist', $status);

        return $response['data'];
    }

    public function report(Request $request)
    {

        $header = Http::withHeaders(request()->header())
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'prosesgajisupirheader/' . $request->id);

        $detailParams = [
            'forReport' => true,
            'prosesgajisupir_id' => $request->id
        ];

        $prosesgajisupir_detail = Http::withHeaders(request()->header())
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'prosesgajisupirdetail', $detailParams);

        $data = $header['data'];
        $prosesgajisupir_details = $prosesgajisupir_detail['data'];
        $user = Auth::user();
        return view('reports.prosesgajisupir', compact('data', 'prosesgajisupir_details', 'user'));
    }

    public function export(Request $request): void
    {

        //FETCH HEADER
        $prosesgajisupirs = Http::withHeaders($request->header())
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'prosesgajisupirheader/' . $request->id)['data'];

        //FETCH DETAIL
        $detailParams = [
            'forReport' => true,
            'prosesgajisupir_id' => $request->id
        ];

        $responses = Http::withHeaders($request->header())
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'prosesgajisupirdetail', $detailParams);

        $prosesgajisupir_details = $responses['data'];
        $user = Auth::user();
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'TAS ');
        $sheet->getStyle("A1")->getFont()->setSize(20);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal('center');
        $sheet->mergeCells('A1:E1');
        $tgldari = date('d-m-Y', strtotime($prosesgajisupirs['tgldari']));
        $tglsampai = date('d-m-Y', strtotime($prosesgajisupirs['tglsampai']));
        $prosesgajisupirs['keterangan'] = "GAJI SUPIR PERIODE $tgldari S/D $tglsampai";

        $header_start_row = 2;
        $detail_table_header_row = 6;
        $detail_start_row = $detail_table_header_row + 1;

        $alphabets = range('A', 'Z');

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
                'label' => 'Keterangan',
                'index' => 'keterangan',
            ],
        ];

        $detail_columns = [
            [
                'label' => 'No',
            ],
            [
                'label' => 'No RIC',
                'index' => 'gajisupir_nobukti',
            ],
            [
                'label' => 'Supir',
                'index' => 'supir_id',
            ],
            [
                'label' => 'Trado',
                'index' => 'trado_id',
            ],
            [
                'label' => 'Nominal',
                'index' => 'nominal',
                'format' => 'currency'
            ]
        ];

        //LOOPING HEADER        
        foreach ($header_columns as $header_column) {
            $sheet->setCellValue('B' . $header_start_row, $header_column['label']);
            $sheet->setCellValue('C' . $header_start_row++, ': ' . $prosesgajisupirs[$header_column['index']]);
        }

        foreach ($detail_columns as $detail_columns_index => $detail_column) {
            $sheet->setCellValue($alphabets[$detail_columns_index] . $detail_table_header_row, $detail_column['label'] ?? $detail_columns_index + 1);
        }
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
                'allBorders' => array(
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ),
            ]
        ];

        // $sheet->getStyle("A$detail_table_header_row:G$detail_table_header_row")->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('FF1F456E');
        $sheet->getStyle("A$detail_table_header_row:E$detail_table_header_row")->applyFromArray($styleArray);

        // LOOPING DETAIL
        $total = 0;
        foreach ($prosesgajisupir_details as $response_index => $response_detail) {

            foreach ($detail_columns as $detail_columns_index => $detail_column) {
                $sheet->setCellValue($alphabets[$detail_columns_index] . $detail_start_row, isset($detail_column['index']) ? $response_detail[$detail_column['index']] : $response_index + 1);
            }
            $response_detail['nominals'] = number_format((float) $response_detail['nominal'], '2', ',', '.');

            $sheet->setCellValue("A$detail_start_row", $response_index + 1);
            $sheet->setCellValue("B$detail_start_row", $response_detail['gajisupir_nobukti']);
            $sheet->setCellValue("C$detail_start_row", $response_detail['supir_id']);
            $sheet->setCellValue("D$detail_start_row", $response_detail['trado_id']);
            $sheet->setCellValue("E$detail_start_row", $response_detail['nominals']);

            $sheet->getStyle("A$detail_start_row:D$detail_start_row")->applyFromArray($styleArray);
            $sheet->getStyle("E$detail_start_row")->applyFromArray($style_number);
            $total += $response_detail['nominal'];
            $detail_start_row++;
        }

        $total_start_row = $detail_start_row;
        $sheet->mergeCells('A' . $total_start_row . ':D' . $total_start_row);
        $sheet->setCellValue("A$total_start_row", 'Total :')->getStyle('A' . $total_start_row . ':D' . $total_start_row)->applyFromArray($style_number)->getFont()->setBold(true);
        $sheet->setCellValue("E$total_start_row", number_format((float) $total, '2', ',', '.'))->getStyle("E$detail_start_row")->applyFromArray($style_number)->getFont()->setBold(true);

        //set diketahui dibuat
        $ttd_start_row = $total_start_row + 2;
        $sheet->setCellValue("B$ttd_start_row", 'Disetujui');
        $sheet->setCellValue("C$ttd_start_row", 'Diketahui');
        $sheet->setCellValue("D$ttd_start_row", 'Dibuat');
        $sheet->getStyle("B$ttd_start_row:D$ttd_start_row")->applyFromArray($styleArray);
        // $sheet->mergeCells("A$ttd_end_row:C$ttd_end_row");
        $sheet->mergeCells("B" . ($ttd_start_row + 1) . ":B" . ($ttd_start_row + 3));
        $sheet->mergeCells("C" . ($ttd_start_row + 1) . ":C" . ($ttd_start_row + 3));
        $sheet->mergeCells("D" . ($ttd_start_row + 1) . ":D" . ($ttd_start_row + 3));
        $sheet->getStyle("B" . ($ttd_start_row + 1) . ":B" . ($ttd_start_row + 3))->applyFromArray($styleArray);
        $sheet->getStyle("C" . ($ttd_start_row + 1) . ":C" . ($ttd_start_row + 3))->applyFromArray($styleArray);
        $sheet->getStyle("D" . ($ttd_start_row + 1) . ":D" . ($ttd_start_row + 3))->applyFromArray($styleArray);

        //set tglcetak
        date_default_timezone_set('Asia/Jakarta');

        $sheet->setCellValue("B" . ($ttd_start_row + 5), 'Dicetak Pada :');
        $sheet->getStyle("B" . ($ttd_start_row + 5))->getFont()->setItalic(true);
        $sheet->setCellValue("C" . ($ttd_start_row + 5), date('d/m/Y H:i:s'));
        $sheet->getStyle("C" . ($ttd_start_row + 5))->getFont()->setItalic(true);
        $sheet->setCellValue("D" . ($ttd_start_row + 5), $user['name']);
        $sheet->getStyle("D" . ($ttd_start_row + 5))->getFont()->setItalic(true);

        $sheet->getColumnDimension('A')->setAutoSize(true);
        $sheet->getColumnDimension('B')->setAutoSize(true);
        $sheet->getColumnDimension('C')->setAutoSize(true);
        $sheet->getColumnDimension('D')->setAutoSize(true);
        $sheet->getColumnDimension('E')->setAutoSize(true);
        $sheet->getColumnDimension('F')->setAutoSize(true);
        $sheet->getColumnDimension('G')->setAutoSize(true);


        $writer = new Xlsx($spreadsheet);
        $filename = 'Laporan Proses Gaji Supir  ' . date('dmYHis');
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }
}

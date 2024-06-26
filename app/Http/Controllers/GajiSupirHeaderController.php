<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class GajiSupirHeaderController extends MyController
{
    public $title = 'Rincian Gaji Supir';

    public function index(Request $request)
    {
        $title = $this->title;
        $data = [
            'combocetak' => $this->comboList('list', 'STATUSCETAK', 'STATUSCETAK'),
            'listbtn' => $this->getListBtn()
        ];
        $data = array_merge(
            compact('title', 'data'),
            ["request" => $request->all()]
        );
        return view('gajisupirheader.index', $data);
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
            ->get(config('app.api_url') . 'gajisupirheader', $params);

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

    public function combo($aksi)
    {
        $status = [
            'status' => $aksi,
            'grp' => 'STATUSCETAK',
            'subgrp' => 'STATUSCETAK',
        ];
        $response = Http::withHeaders($this->httpHeaders)->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'user/combostatus', $status);
        return $response['data'];
    }

    public function report(Request $request)
    {
        //FETCH HEADER
        $id = $request->id;
        $gajisupir = Http::withHeaders($request->header())
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'gajisupirheader/' . $id . '/export')['data'];

        //FETCH DETAIL
        $detailParams = [
            'forReport' => true,
            'gajisupir_id' => $request->id,
            'sortIndex' => 'suratpengantar_nobukti'
        ];

        $gajisupir_details = Http::withHeaders(request()->header())
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'gajisupirdetail', $detailParams)['data'];

        $combo = $this->combo('list');
        $key = array_search('CETAK', array_column($combo, 'parameter'));
        $gajisupir["combo"] =  $combo[$key];

        return view('reports.gajisupir', compact('gajisupir', 'gajisupir_details'));
    }

    public function export(Request $request): void
    {
        //FETCH HEADER
        $id = $request->id;
        $data = Http::withHeaders($request->header())
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'gajisupirheader/' . $id . '/export');

        //FETCH DETAIL
        $detailParams = [
            'forReport' => true,
            'gajisupir_id' => $request->id,
            'sortIndex' => 'suratpengantar_nobukti'
        ];
        $data_details = Http::withHeaders($request->header())
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'gajisupirdetail', $detailParams);

        $gajisupirs = $data['data'];
        $gajisupir_details = $data_details['data'];

        $tglBukti = $gajisupirs["tglbukti"];
        $timeStamp = strtotime($tglBukti);
        $dateTglBukti = date('d-m-Y', $timeStamp);
        $gajisupirs['tglbukti'] = $dateTglBukti;

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', $gajisupirs['judul']);
        $sheet->setCellValue('A2', $gajisupirs['judulLaporan']);
        $sheet->getStyle("A1")->getFont()->setSize(12);
        $sheet->getStyle("A2")->getFont()->setSize(12);
        $sheet->getStyle("A1")->getFont()->setBold(true);
        $sheet->getStyle("A2")->getFont()->setBold(true);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal('center');
        $sheet->getStyle('A2')->getAlignment()->setHorizontal('center');
        $sheet->mergeCells('A1:N1');
        $sheet->mergeCells('A2:N2');

        $header_start_row = 4;
        $detail_table_header_row = 8;
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
                'label' => 'Supir',
                'index' => 'supir_id',
            ]
        ];

        $header_down_columns = [
            [
                'label' => 'TOTAL UANG BORONGAN',
                'index' => 'total',
            ],
            [
                'label' => 'UANG MAKAN',
                'index' => 'uangmakanharian',
            ],
            [
                'label' => 'UANG MAKAN BERJENJANG',
                'index' => 'uangmakanberjenjang',
            ],
            [
                'label' => 'TOTAL POTONGAN UANG JALAN',
                'index' => 'uangjalan',
            ],
            [
                'label' => 'TOTAL POTONGAN PINJAMAN',
                'index' => 'potonganpinjaman',
            ],
            [
                'label' => 'TOTAL POTONGAN PINJAMAN SEMUA',
                'index' => 'potonganpinjamansemua',
            ],
            [
                'label' => 'TOTAL DEPOSITO',
                'index' => 'deposito',
            ],
            [
                'label' => 'TOTAL POTONGAN BBM',
                'index' => 'bbm',
            ],
            [
                'label' => 'SISA YANG DITERIMA SUPIR',
                'index' => 'sisa',
            ]
        ];

        $detail_columns = [
            [
                'label' => 'NO',
            ],
            [
                'label' => 'TANGGAL',
                'index' => 'tglsp',
            ],
            [
                'label' => 'NO SP',
                'index' => 'nosp',
            ],
            [
                'label' => 'STATUS',
                'index' => 'kodestatuscontainer',
            ],
            [
                'label' => 'DARI',
                'index' => 'dari',
            ],
            [
                'label' => 'SAMPAI',
                'index' => 'sampai',
            ],
            [
                'label' => 'RITASI',
                'index' => 'statusritasi',
            ],
            [
                'label' => 'UK. CONT',
                'index' => 'kodecontainer',
            ],
            [
                'label' => 'LITER',
                'index' => 'liter',
            ],
            [
                'label' => 'NO CONT',
                'index' => 'nocont',
            ],
            [
                'label' => 'CUSTOMER',
                'index' => 'agen',
            ],
            [
                'label' => 'BORONGAN',
                'index' => 'borongan',
                'format' => 'currency'
            ],
            [
                'label' => 'EXTRA',
                'index' => 'biayaextra',
                'format' => 'currency'
            ],
            [
                'label' => 'RITASI',
                'index' => 'upahritasi',
                'format' => 'currency'
            ]
        ];

        //LOOPING HEADER   
        foreach ($header_columns as $header_column) {
            $sheet->setCellValue('B' . $header_start_row, $header_column['label']);
            $sheet->setCellValue('C' . $header_start_row++, ': ' . $gajisupirs[$header_column['index']]);
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

        $style_number_2 = [
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT,
            ]
        ];

        // $sheet->getStyle("A$detail_table_header_row:G$detail_table_header_row")->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('FF1F456E');
        $sheet->getStyle("A$detail_table_header_row:N$detail_table_header_row")->applyFromArray($styleArray);

        // LOOPING DETAIL
        $liter = 0;
        $borongan = 0;
        $biayaextra = 0;
        $upahritasi = 0;
        foreach ($gajisupir_details as $response_index => $response_detail) {

            foreach ($detail_columns as $detail_columns_index => $detail_column) {
                $sheet->setCellValue($alphabets[$detail_columns_index] . $detail_start_row, isset($detail_column['index']) ? $response_detail[$detail_column['index']] : $response_index + 1);
                $sheet->getStyle("A$detail_table_header_row:N$detail_table_header_row")->getFont()->setBold(true);
                $sheet->getStyle("A$detail_table_header_row:N$detail_table_header_row")->getAlignment()->setHorizontal('center');
            }

            $dateValue = ($response_detail['tglsp'] != null) ? Date::PHPToExcel(date('Y-m-d', strtotime($response_detail['tglsp']))) : '';

            $sheet->setCellValue("A$detail_start_row", $response_index + 1);
            $sheet->setCellValue("B$detail_start_row", $dateValue);
            $sheet->setCellValue("C$detail_start_row", $response_detail['nosp']);
            $sheet->setCellValue("D$detail_start_row", $response_detail['kodestatuscontainer']);
            $sheet->setCellValue("E$detail_start_row", $response_detail['dari']);
            $sheet->setCellValue("F$detail_start_row", $response_detail['sampai']);
            $sheet->setCellValue("G$detail_start_row", $response_detail['statusritasi']);
            $sheet->setCellValue("H$detail_start_row", $response_detail['kodecontainer']);
            $sheet->setCellValue("I$detail_start_row", $response_detail['liter']);
            $sheet->setCellValue("J$detail_start_row", $response_detail['nocont']);
            $sheet->setCellValue("K$detail_start_row", $response_detail['agen']);
            $sheet->setCellValue("L$detail_start_row", $response_detail['borongan']);
            $sheet->setCellValue("M$detail_start_row", $response_detail['biayaextra']);
            $sheet->setCellValue("N$detail_start_row", $response_detail['upahritasi']);

            $sheet->getStyle("A$detail_start_row:N$detail_start_row")->applyFromArray($styleArray);
            $sheet->getStyle("L$detail_start_row:N$detail_start_row")->applyFromArray($style_number)->getNumberFormat()->setFormatCode("#,##0.00_);(#,##0.00)");

            $sheet->getStyle("B$detail_start_row")->getNumberFormat()->setFormatCode('dd-mm-yyyy');
            $detail_start_row++;
        }

        $total_start_row = $detail_start_row;
        $sheet->setCellValue("G$total_start_row", 'Tot Liter')->getStyle('G' . $total_start_row)->applyFromArray($styleArray)->getFont()->setBold(true);
        $liter = "=SUM(I".($detail_table_header_row + 1).":I" . ($detail_start_row - 1) . ")";
        $sheet->setCellValue("I$total_start_row", $liter)->getStyle("I$detail_start_row")->applyFromArray($style_number)->getFont()->setBold(true);
        $borongan = "=SUM(L".($detail_table_header_row + 1).":L" . ($detail_start_row - 1) . ")";
        $sheet->setCellValue("L$total_start_row", $borongan)->getStyle("L$detail_start_row")->applyFromArray($style_number)->getFont()->setBold(true);
        $biayaextra = "=SUM(M".($detail_table_header_row + 1).":M" . ($detail_start_row - 1) . ")";
        $sheet->setCellValue("M$total_start_row", $biayaextra)->getStyle("M$detail_start_row")->applyFromArray($style_number)->getFont()->setBold(true);
        $upahritasi = "=SUM(N".($detail_table_header_row + 1).":N" . ($detail_start_row - 1) . ")";
        $sheet->setCellValue("N$total_start_row", $upahritasi)->getStyle("N$detail_start_row")->applyFromArray($style_number)->getFont()->setBold(true);
        $sheet->getStyle("L$total_start_row:N$total_start_row")->applyFromArray($style_number)->getNumberFormat()->setFormatCode("#,##0.00_);(#,##0.00)");

        $sheet->getColumnDimension('A')->setAutoSize(true);
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

        $header_down_row = $total_start_row + 2;
        $header_down_value_row = $total_start_row + 2;

        foreach ($header_down_columns as $header_down_column) {
            $sheet->setCellValue('L' . $header_down_row, $header_down_column['label']);
            $sheet->setCellValue('M' . $header_down_row++, ':');

            $cellCoordinate = 'N' . $header_down_value_row++;
            $sheet->setCellValue($cellCoordinate, $gajisupirs[$header_down_column['index']]);
            $sheet->getStyle($cellCoordinate)->applyFromArray($style_number_2)->getNumberFormat()->setFormatCode("#,##0.00_);(#,##0.00)");
        }

        $writer = new Xlsx($spreadsheet);
        $filename = 'Laporan Rincian Gaji Supir' . date('dmYHis');
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }
}

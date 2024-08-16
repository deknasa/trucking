<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class PenerimaanTruckingHeaderController extends MyController
{
    public $title = 'Penerimaan Trucking';

    public function index(Request $request)
    {
        $title = $this->title;
        $data = [
            'combocetak' => $this->comboList('list', 'STATUSCETAK', 'STATUSCETAK'),
            'listbtn' => $this->getListBtn()
        ];
        $combo = $this->comboKodepenerimaan();
        $comboKodepenerimaan = $combo['data'];
        $acosPenerimaan = $combo['acos'];
        $data = array_merge(
            compact('title', 'data', 'comboKodepenerimaan', 'acosPenerimaan'),
            ["request" => $request->all()]
        );
        return view('penerimaantruckingheader.index', $data);
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
            ->get(config('app.api_url') . 'penerimaantruckingheader', $params);

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
    public function comboKodepenerimaan()
    {
        $params = [
            'limit' => 0,
            'roleinput' => 'role',
            'sortIndex' => 'keterangan'
        ];

        $response = Http::withHeaders($this->httpHeaders)
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'penerimaantrucking', $params);

        return $response;
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
        $penerimaantrucking = Http::withHeaders($request->header())
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'penerimaantruckingheader/' . $id . '/export')['data'];

        //FETCH DETAIL
        $detailParams = [
            'forReport' => true,
            'penerimaantruckingheader_id' => $request->id,
        ];
        $penerimaantrucking_details = Http::withHeaders($request->header())
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'penerimaantruckingdetail', $detailParams)['data'];

        $combo = $this->combo('list');
        $key = array_search('CETAK', array_column($combo, 'parameter'));
        $penerimaantrucking["combo"] =  $combo[$key];
        $printer['tipe'] = $request->printer;
        return view('reports.penerimaantruckingheader', compact('penerimaantrucking', 'penerimaantrucking_details', 'printer'));
    }

    public function export(Request $request): void
    {
        //FETCH HEADER
        $id = $request->id;
        $penerimaantrucking = Http::withHeaders($request->header())
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'penerimaantruckingheader/' . $id . '/export')['data'];

        //FETCH DETAIL
        $detailParams = [
            'forReport' => true,
            'penerimaantruckingheader_id' => $request->id,
        ];

        $penerimaantrucking_details = Http::withHeaders($request->header())
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'penerimaantruckingdetail', $detailParams)['data'];

        $tglBukti = $penerimaantrucking["tglbukti"];
        $timeStamp = strtotime($tglBukti);
        $dateTglBukti = date('d-m-Y', $timeStamp);
        $penerimaantrucking['tglbukti'] = $dateTglBukti;

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', $penerimaantrucking['judul']);
        $sheet->setCellValue('A2', $penerimaantrucking['judulLaporan']);
        $sheet->getStyle("A1")->getFont()->setSize(12);
        $sheet->getStyle("A2")->getFont()->setSize(12);
        $sheet->getStyle("A1")->getFont()->setBold(true);
        $sheet->getStyle("A2")->getFont()->setBold(true);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal('center');
        $sheet->getStyle('A2')->getAlignment()->setHorizontal('center');
        $sheet->mergeCells('A1:E1');
        $sheet->mergeCells('A2:E2');

        $header_start_row = 4;
        $header_right_start_row = 4;
        $detail_table_header_row = 8;
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

        switch ($penerimaantrucking['statusformat']) {
            case '125':
                // DPO

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
                        'label' => 'No Bukti Penerimaan',
                        'index' => 'penerimaan_nobukti',
                    ],

                ];
                $header_right_columns = [
                    [
                        'label' => 'Penerimaan Trucking',
                        'index' => 'penerimaantrucking_id',
                    ],
                    [
                        'label' => 'Bank',
                        'index' => 'bank_id',
                    ],
                    [
                        'label' => 'Nama Perkiraan',
                        'index' => 'coa',
                    ],
                ];


                //LOOPING HEADER        
                foreach ($header_columns as $header_column) {
                    $sheet->setCellValue('B' . $header_start_row, $header_column['label']);
                    $sheet->setCellValue('C' . $header_start_row++, ': ' . $penerimaantrucking[$header_column['index']]);
                }
                foreach ($header_right_columns as $header_right_column) {
                    $sheet->setCellValue('D' . $header_right_start_row++, $header_right_column['label'] . ': ' . $penerimaantrucking[$header_right_column['index']]);
                    // $sheet->setCellValue('E' . $header_right_start_row++, ': ' . $penerimaantrucking[$header_right_column['index']]);
                }
                $detail_columns = [
                    [
                        'label' => 'NO',
                    ],
                    [
                        'label' => 'SUPIR',
                        'index' => 'supir_id',
                    ],
                    [
                        'label' => 'KETERANGAN',
                        'index' => 'keterangan'
                    ],
                    [
                        'label' => 'NOMINAL',
                        'index' => 'nominal',
                        'format' => 'currency'
                    ]
                ];

                foreach ($detail_columns as $detail_columns_index => $detail_column) {
                    $sheet->setCellValue($alphabets[$detail_columns_index] . $detail_table_header_row, $detail_column['label'] ?? $detail_columns_index + 1);
                }
                $sheet->getStyle("A$detail_table_header_row:D$detail_table_header_row")->applyFromArray($styleArray);

                // LOOPING DETAIL
                $nominal = 0;
                foreach ($penerimaantrucking_details as $response_index => $response_detail) {

                    foreach ($detail_columns as $detail_columns_index => $detail_column) {
                        $sheet->setCellValue($alphabets[$detail_columns_index] . $detail_start_row, isset($detail_column['index']) ? $response_detail[$detail_column['index']] : $response_index + 1);
                        $sheet->getStyle("A$detail_table_header_row:D$detail_table_header_row")->getFont()->setBold(true);
                        $sheet->getStyle("A$detail_table_header_row:D$detail_table_header_row")->getAlignment()->setHorizontal('center');
                    }

                    $sheet->setCellValue("A$detail_start_row", $response_index + 1);
                    $sheet->setCellValue("B$detail_start_row", $response_detail['supir_id']);
                    $sheet->setCellValue("C$detail_start_row", $response_detail['keterangan']);
                    $sheet->setCellValue("D$detail_start_row", $response_detail['nominal']);

                    // $sheet->getStyle("C$detail_start_row")->getAlignment()->setWrapText(true);
                    $sheet->getColumnDimension('C')->setWidth(60);

                    $sheet->getStyle("A$detail_start_row:D$detail_start_row")->applyFromArray($styleArray);
                    $sheet->getStyle("D$detail_start_row")->applyFromArray($style_number)->getNumberFormat()->setFormatCode("#,##0.00_);(#,##0.00)");

                    $detail_start_row++;
                }

                $total_start_row = $detail_start_row;
                $sheet->mergeCells('A' . $total_start_row . ':C' . $total_start_row);
                $sheet->setCellValue("A$total_start_row", 'Total')->getStyle('A' . $total_start_row . ':C' . $total_start_row)->applyFromArray($styleArray)->getFont()->setBold(true);
                $totalNominal = "=SUM(D" . ($detail_table_header_row + 1) . ":D" . ($detail_start_row - 1) . ")";
                $sheet->setCellValue("D$total_start_row", $totalNominal)->getStyle("D$total_start_row")->applyFromArray($style_number)->getNumberFormat()->setFormatCode("#,##0.00_);(#,##0.00)");
                $sheet->getStyle("D$total_start_row")->getFont()->setBold(true);

                $sheet->getColumnDimension('A')->setAutoSize(true);
                $sheet->getColumnDimension('B')->setAutoSize(true);
                $sheet->getColumnDimension('D')->setAutoSize(true);

                $writer = new Xlsx($spreadsheet);
                $filename = 'Laporan Penerimaan Trucking (DPO)' . date('dmYHis');
                header('Content-Type: application/vnd.ms-excel');
                header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
                header('Cache-Control: max-age=0');
                $writer->save('php://output');
                break;

            case '265':
                // BBM

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
                        'label' => 'No Bukti Penerimaan',
                        'index' => 'penerimaan_nobukti',
                    ],

                ];
                $header_right_columns = [
                    [
                        'label' => 'Penerimaan Trucking',
                        'index' => 'penerimaantrucking_id',
                    ],
                    [
                        'label' => 'Bank',
                        'index' => 'bank_id',
                    ],
                    [
                        'label' => 'Nama Perkiraan',
                        'index' => 'coa',
                    ],
                ];


                //LOOPING HEADER        
                foreach ($header_columns as $header_column) {
                    $sheet->setCellValue('B' . $header_start_row++, $header_column['label'] . ': ' . $penerimaantrucking[$header_column['index']]);
                }
                foreach ($header_right_columns as $header_right_column) {
                    $sheet->setCellValue('C' . $header_right_start_row++, $header_right_column['label'] . ': ' . $penerimaantrucking[$header_right_column['index']]);
                }
                $detail_columns = [
                    [
                        'label' => 'NO',
                    ],
                    [
                        'label' => 'KETERANGAN',
                        'index' => 'keterangan'
                    ],
                    [
                        'label' => 'NOMINAL',
                        'index' => 'nominal',
                        'format' => 'currency'
                    ]
                ];

                foreach ($detail_columns as $detail_columns_index => $detail_column) {
                    $sheet->setCellValue($alphabets[$detail_columns_index] . $detail_table_header_row, $detail_column['label'] ?? $detail_columns_index + 1);
                }
                $sheet->getStyle("A$detail_table_header_row:C$detail_table_header_row")->applyFromArray($styleArray);

                // LOOPING DETAIL
                $nominal = 0;
                foreach ($penerimaantrucking_details as $response_index => $response_detail) {

                    foreach ($detail_columns as $detail_columns_index => $detail_column) {
                        $sheet->setCellValue($alphabets[$detail_columns_index] . $detail_start_row, isset($detail_column['index']) ? $response_detail[$detail_column['index']] : $response_index + 1);
                        $sheet->getStyle("A$detail_table_header_row:C$detail_table_header_row")->getFont()->setBold(true);
                        $sheet->getStyle("A$detail_table_header_row:C$detail_table_header_row")->getAlignment()->setHorizontal('center');
                    }

                    $sheet->setCellValue("A$detail_start_row", $response_index + 1);
                    $sheet->setCellValue("B$detail_start_row", $response_detail['keterangan']);
                    $sheet->setCellValue("C$detail_start_row", $response_detail['nominal']);

                    // $sheet->getStyle("B$detail_start_row")->getAlignment()->setWrapText(true);
                    $sheet->getColumnDimension('B')->setWidth(60);

                    $sheet->getStyle("A$detail_start_row:C$detail_start_row")->applyFromArray($styleArray);
                    $sheet->getStyle("C$detail_start_row")->applyFromArray($style_number)->getNumberFormat()->setFormatCode("#,##0.00_);(#,##0.00)");

                    $detail_start_row++;
                }

                $total_start_row = $detail_start_row;
                $sheet->mergeCells('A' . $total_start_row . ':B' . $total_start_row);
                $sheet->setCellValue("A$total_start_row", 'Total')->getStyle('A' . $total_start_row . ':B' . $total_start_row)->applyFromArray($styleArray)->getFont()->setBold(true);
                $totalNominal = "=SUM(C" . ($detail_table_header_row + 1) . ":C" . ($detail_start_row - 1) . ")";
                $sheet->setCellValue("C$total_start_row", $totalNominal)->getStyle("C$total_start_row")->applyFromArray($style_number)->getNumberFormat()->setFormatCode("#,##0.00_);(#,##0.00)");
                $sheet->getStyle("C$total_start_row")->getFont()->setBold(true);

                $sheet->getColumnDimension('A')->setAutoSize(true);
                $sheet->getColumnDimension('C')->setAutoSize(true);

                $writer = new Xlsx($spreadsheet);
                $filename = 'Laporan Penerimaan Trucking (BBM)' . date('dmYHis');
                header('Content-Type: application/vnd.ms-excel');
                header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
                header('Cache-Control: max-age=0');
                $writer->save('php://output');
                break;

            case '410':
                // PBT

                $penerimaantrucking['periodedari'] = date('d-m-Y', strtotime($penerimaantrucking["periodedari"]));
                $penerimaantrucking['periodesampai'] = date('d-m-Y', strtotime($penerimaantrucking["periodesampai"]));
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
                        'label' => 'No Bukti Penerimaan',
                        'index' => 'penerimaan_nobukti',
                    ],
                    [
                        'label' => 'Tanggal Dari',
                        'index' => 'periodedari',
                    ],
                    [
                        'label' => 'Keterangan',
                        'index' => 'keteranganheader',
                    ],

                ];
                $header_right_columns = [
                    [
                        'label' => 'Penerimaan Trucking',
                        'index' => 'penerimaantrucking_id',
                    ],
                    [
                        'label' => 'Bank',
                        'index' => 'bank_id',
                    ],
                    [
                        'label' => 'Nama Perkiraan',
                        'index' => 'coa',
                    ],
                    [
                        'label' => 'Tanggal Sampai',
                        'index' => 'periodesampai',
                    ],
                ];


                //LOOPING HEADER        
                foreach ($header_columns as $header_column) {
                    $sheet->setCellValue('B' . $header_start_row, $header_column['label']);
                    $sheet->setCellValue('C' . $header_start_row++, ': ' . $penerimaantrucking[$header_column['index']]);
                }
                foreach ($header_right_columns as $header_right_column) {
                    $sheet->setCellValue('D' . $header_right_start_row++, $header_right_column['label'] . ': ' . $penerimaantrucking[$header_right_column['index']]);
                    // $sheet->setCellValue('E' . $header_right_start_row++, ': ' . $penerimaantrucking[$header_right_column['index']]);
                }

                $detail_table_header_row = 10;
                $detail_start_row = $detail_table_header_row + 1;
                $detail_columns = [
                    [
                        'label' => 'NO',
                    ],
                    [
                        'label' => 'NO BUKTI PENGELUARAN TRUCKING',
                        'index' => 'pengeluarantruckingheader_nobukti',
                    ],
                    [
                        'label' => 'JENIS ORDER',
                    ],
                    [
                        'label' => 'KETERANGAN',
                        'index' => 'keterangan'
                    ],
                    [
                        'label' => 'NOMINAL',
                        'index' => 'nominal',
                        'format' => 'currency'
                    ]
                ];

                foreach ($detail_columns as $detail_columns_index => $detail_column) {
                    $sheet->setCellValue($alphabets[$detail_columns_index] . $detail_table_header_row, $detail_column['label'] ?? $detail_columns_index + 1);
                }
                $sheet->getStyle("A$detail_table_header_row:E$detail_table_header_row")->applyFromArray($styleArray);

                // LOOPING DETAIL
                $nominal = 0;
                foreach ($penerimaantrucking_details as $response_index => $response_detail) {

                    foreach ($detail_columns as $detail_columns_index => $detail_column) {
                        $sheet->setCellValue($alphabets[$detail_columns_index] . $detail_start_row, isset($detail_column['index']) ? $response_detail[$detail_column['index']] : $response_index + 1);
                        $sheet->getStyle("A$detail_table_header_row:E$detail_table_header_row")->getFont()->setBold(true);
                        $sheet->getStyle("A$detail_table_header_row:E$detail_table_header_row")->getAlignment()->setHorizontal('center');
                    }

                    $sheet->setCellValue("A$detail_start_row", $response_index + 1);
                    $sheet->setCellValue("B$detail_start_row", $response_detail['pengeluarantruckingheader_nobukti']);
                    $sheet->setCellValue("C$detail_start_row", $penerimaantrucking['jenisorder_id']);
                    $sheet->setCellValue("D$detail_start_row", $response_detail['keterangan']);
                    $sheet->setCellValue("E$detail_start_row", $response_detail['nominal']);

                    // $sheet->getStyle("D$detail_start_row")->getAlignment()->setWrapText(true);
                    $sheet->getColumnDimension('D')->setWidth(60);

                    $sheet->getStyle("A$detail_start_row:E$detail_start_row")->applyFromArray($styleArray);
                    $sheet->getStyle("E$detail_start_row")->applyFromArray($style_number)->getNumberFormat()->setFormatCode("#,##0.00_);(#,##0.00)");

                    $detail_start_row++;
                }

                $total_start_row = $detail_start_row;
                $sheet->mergeCells('A' . $total_start_row . ':D' . $total_start_row);
                $sheet->setCellValue("A$total_start_row", 'Total')->getStyle('A' . $total_start_row . ':D' . $total_start_row)->applyFromArray($styleArray)->getFont()->setBold(true);
                $totalNominal = "=SUM(E" . ($detail_table_header_row + 1) . ":E" . ($detail_start_row - 1) . ")";
                $sheet->setCellValue("E$total_start_row", $totalNominal)->getStyle("E$total_start_row")->applyFromArray($style_number)->getNumberFormat()->setFormatCode("#,##0.00_);(#,##0.00)");
                $sheet->getStyle("E$total_start_row")->getFont()->setBold(true);

                $sheet->getColumnDimension('A')->setAutoSize(true);
                $sheet->getColumnDimension('B')->setAutoSize(true);
                $sheet->getColumnDimension('C')->setWidth(17);
                $sheet->getColumnDimension('E')->setAutoSize(true);

                $writer = new Xlsx($spreadsheet);
                $filename = 'Laporan Penerimaan Trucking (TTE) ' . date('dmYHis');
                header('Content-Type: application/vnd.ms-excel');
                header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
                header('Cache-Control: max-age=0');
                $writer->save('php://output');
                break;
            case '544':
                // DPOK

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
                        'label' => 'No Bukti Penerimaan',
                        'index' => 'penerimaan_nobukti',
                    ],

                ];
                $header_right_columns = [
                    [
                        'label' => 'Penerimaan Trucking',
                        'index' => 'penerimaantrucking_id',
                    ],
                    [
                        'label' => 'Bank',
                        'index' => 'bank_id',
                    ],
                    [
                        'label' => 'Nama Perkiraan',
                        'index' => 'coa',
                    ],
                ];


                //LOOPING HEADER        
                foreach ($header_columns as $header_column) {
                    $sheet->setCellValue('B' . $header_start_row, $header_column['label']);
                    $sheet->setCellValue('C' . $header_start_row++, ': ' . $penerimaantrucking[$header_column['index']]);
                }
                foreach ($header_right_columns as $header_right_column) {
                    $sheet->setCellValue('D' . $header_right_start_row++, $header_right_column['label'] . ': ' . $penerimaantrucking[$header_right_column['index']]);
                    // $sheet->setCellValue('E' . $header_right_start_row++, ': ' . $penerimaantrucking[$header_right_column['index']]);
                }
                $detail_columns = [
                    [
                        'label' => 'NO',
                    ],
                    [
                        'label' => 'KARYAWAN',
                        'index' => 'karyawan_id',
                    ],
                    [
                        'label' => 'KETERANGAN',
                        'index' => 'keterangan'
                    ],
                    [
                        'label' => 'NOMINAL',
                        'index' => 'nominal',
                        'format' => 'currency'
                    ]
                ];

                foreach ($detail_columns as $detail_columns_index => $detail_column) {
                    $sheet->setCellValue($alphabets[$detail_columns_index] . $detail_table_header_row, $detail_column['label'] ?? $detail_columns_index + 1);
                }
                $sheet->getStyle("A$detail_table_header_row:D$detail_table_header_row")->applyFromArray($styleArray);

                // LOOPING DETAIL
                $nominal = 0;
                foreach ($penerimaantrucking_details as $response_index => $response_detail) {

                    foreach ($detail_columns as $detail_columns_index => $detail_column) {
                        $sheet->setCellValue($alphabets[$detail_columns_index] . $detail_start_row, isset($detail_column['index']) ? $response_detail[$detail_column['index']] : $response_index + 1);
                        $sheet->getStyle("A$detail_table_header_row:D$detail_table_header_row")->getFont()->setBold(true);
                        $sheet->getStyle("A$detail_table_header_row:D$detail_table_header_row")->getAlignment()->setHorizontal('center');
                    }

                    $sheet->setCellValue("A$detail_start_row", $response_index + 1);
                    $sheet->setCellValue("B$detail_start_row", $response_detail['karyawan_id']);
                    $sheet->setCellValue("C$detail_start_row", $response_detail['keterangan']);
                    $sheet->setCellValue("D$detail_start_row", $response_detail['nominal']);

                    // $sheet->getStyle("C$detail_start_row")->getAlignment()->setWrapText(true);
                    $sheet->getColumnDimension('C')->setWidth(60);

                    $sheet->getStyle("A$detail_start_row:D$detail_start_row")->applyFromArray($styleArray);
                    $sheet->getStyle("D$detail_start_row")->applyFromArray($style_number)->getNumberFormat()->setFormatCode("#,##0.00_);(#,##0.00)");

                    $detail_start_row++;
                }

                $total_start_row = $detail_start_row;
                $sheet->mergeCells('A' . $total_start_row . ':C' . $total_start_row);
                $sheet->setCellValue("A$total_start_row", 'Total')->getStyle('A' . $total_start_row . ':C' . $total_start_row)->applyFromArray($styleArray)->getFont()->setBold(true);
                $totalNominal = "=SUM(D" . ($detail_table_header_row + 1) . ":D" . ($detail_start_row - 1) . ")";
                $sheet->setCellValue("D$total_start_row", $totalNominal)->getStyle("D$total_start_row")->applyFromArray($style_number)->getNumberFormat()->setFormatCode("#,##0.00_);(#,##0.00)");
                $sheet->getStyle("D$total_start_row")->getFont()->setBold(true);

                $sheet->getColumnDimension('A')->setAutoSize(true);
                $sheet->getColumnDimension('B')->setAutoSize(true);
                $sheet->getColumnDimension('D')->setAutoSize(true);

                $writer = new Xlsx($spreadsheet);
                $filename = 'Laporan Penerimaan Trucking (DPOK)' . date('dmYHis');
                header('Content-Type: application/vnd.ms-excel');
                header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
                header('Cache-Control: max-age=0');
                $writer->save('php://output');
                break;

            default:
                //PJP & PJPK

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
                        'label' => 'No Bukti Penerimaan',
                        'index' => 'penerimaan_nobukti',
                    ],

                ];
                $header_right_columns = [
                    [
                        'label' => 'Penerimaan Trucking',
                        'index' => 'penerimaantrucking_id',
                    ],
                    [
                        'label' => 'Bank',
                        'index' => 'bank_id',
                    ],
                    [
                        'label' => 'Nama Perkiraan',
                        'index' => 'coa',
                    ],
                ];


                //LOOPING HEADER        
                foreach ($header_columns as $header_column) {
                    $sheet->setCellValue('B' . $header_start_row, $header_column['label']);
                    $sheet->setCellValue('C' . $header_start_row++, ': ' . $penerimaantrucking[$header_column['index']]);
                }
                foreach ($header_right_columns as $header_right_column) {
                    $sheet->setCellValue('D' . $header_right_start_row++, $header_right_column['label'] . ': ' . $penerimaantrucking[$header_right_column['index']]);
                    // $sheet->setCellValue('E' . $header_right_start_row++, ': ' . $penerimaantrucking[$header_right_column['index']]);
                }
                if ($penerimaantrucking['statusformat'] == 126) {

                    $detail_columns = [
                        [
                            'label' => 'NO',
                        ],
                        [
                            'label' => 'NO BUKTI PENGELUARAN TRUCKING',
                            'index' => 'pengeluarantruckingheader_nobukti',
                        ],
                        [
                            'label' => 'SUPIR',
                            'index' => 'supir_id',
                        ],
                        [
                            'label' => 'KETERANGAN',
                            'index' => 'keterangan'
                        ],
                        [
                            'label' => 'NOMINAL',
                            'index' => 'nominal',
                            'format' => 'currency'
                        ]
                    ];
                } else if ($penerimaantrucking['statusformat'] == 370) {

                    $detail_columns = [
                        [
                            'label' => 'NO',
                        ],
                        [
                            'label' => 'NO BUKTI PENGELUARAN TRUCKING',
                            'index' => 'pengeluarantruckingheader_nobukti',
                        ],
                        [
                            'label' => 'KARYAWAN',
                            'index' => 'karyawan_id',
                        ],
                        [
                            'label' => 'KETERANGAN',
                            'index' => 'keterangan'
                        ],
                        [
                            'label' => 'NOMINAL',
                            'index' => 'nominal',
                            'format' => 'currency'
                        ]
                    ];
                }

                foreach ($detail_columns as $detail_columns_index => $detail_column) {
                    $sheet->setCellValue($alphabets[$detail_columns_index] . $detail_table_header_row, $detail_column['label'] ?? $detail_columns_index + 1);
                }
                $sheet->getStyle("A$detail_table_header_row:E$detail_table_header_row")->applyFromArray($styleArray);

                // LOOPING DETAIL
                $nominal = 0;
                foreach ($penerimaantrucking_details as $response_index => $response_detail) {

                    foreach ($detail_columns as $detail_columns_index => $detail_column) {
                        $sheet->setCellValue($alphabets[$detail_columns_index] . $detail_start_row, isset($detail_column['index']) ? $response_detail[$detail_column['index']] : $response_index + 1);
                        $sheet->getStyle("A$detail_table_header_row:E$detail_table_header_row")->getFont()->setBold(true);
                        $sheet->getStyle("A$detail_table_header_row:E$detail_table_header_row")->getAlignment()->setHorizontal('center');
                    }

                    $sheet->setCellValue("A$detail_start_row", $response_index + 1);
                    $sheet->setCellValue("B$detail_start_row", $response_detail['pengeluarantruckingheader_nobukti']);
                    if ($penerimaantrucking['statusformat'] == 126) {
                        $sheet->setCellValue("C$detail_start_row", $response_detail['supir_id']);
                    } else if ($penerimaantrucking['statusformat'] == 370) {
                        $sheet->setCellValue("C$detail_start_row", $response_detail['karyawan_id']);
                    }
                    $sheet->setCellValue("D$detail_start_row", $response_detail['keterangan']);
                    $sheet->setCellValue("E$detail_start_row", $response_detail['nominal']);

                    // $sheet->getStyle("D$detail_start_row")->getAlignment()->setWrapText(true);
                    $sheet->getColumnDimension('D')->setWidth(60);

                    $sheet->getStyle("A$detail_start_row:D$detail_start_row")->applyFromArray($styleArray);
                    $sheet->getStyle("E$detail_start_row")->applyFromArray($style_number)->getNumberFormat()->setFormatCode("#,##0.00_);(#,##0.00)");

                    $detail_start_row++;
                }

                $total_start_row = $detail_start_row;
                $sheet->mergeCells('A' . $total_start_row . ':D' . $total_start_row);
                $sheet->setCellValue("A$total_start_row", 'Total')->getStyle('A' . $total_start_row . ':D' . $total_start_row)->applyFromArray($styleArray)->getFont()->setBold(true);
                $totalNominal = "=SUM(E" . ($detail_table_header_row + 1) . ":E" . ($detail_start_row - 1) . ")";
                $sheet->setCellValue("E$total_start_row", $totalNominal)->getStyle("E$total_start_row")->applyFromArray($style_number)->getNumberFormat()->setFormatCode("#,##0.00_);(#,##0.00)");
                $sheet->getStyle("E$total_start_row")->getFont()->setBold(true);

                $sheet->getColumnDimension('A')->setAutoSize(true);
                $sheet->getColumnDimension('B')->setAutoSize(true);
                $sheet->getColumnDimension('C')->setAutoSize(true);
                $sheet->getColumnDimension('E')->setAutoSize(true);

                $writer = new Xlsx($spreadsheet);

                if ($penerimaantrucking['statusformat'] == 126) {
                    $filename = 'Laporan Penerimaan Trucking (PJP)' . date('dmYHis');
                } else if ($penerimaantrucking['statusformat'] == 370) {
                    $filename = 'Laporan Penerimaan Trucking (PJPK)' . date('dmYHis');
                }
                header('Content-Type: application/vnd.ms-excel');
                header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
                header('Cache-Control: max-age=0');
                $writer->save('php://output');
                break;
        }
    }
}

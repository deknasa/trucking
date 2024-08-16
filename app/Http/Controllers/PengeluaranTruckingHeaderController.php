<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class PengeluaranTruckingHeaderController extends MyController
{
    public $title = 'Pengeluaran Trucking';

    public function index(Request $request)
    {
        $title = $this->title;
        $data = [
            'combostatusposting' => $this->comboList('list', 'STATUS POSTING', 'STATUS POSTING'),
            'combocetak' => $this->comboList('list', 'STATUSCETAK', 'STATUSCETAK'),
            'combokirimberkas' => $this->comboList('list','STATUSKIRIMBERKAS','STATUSKIRIMBERKAS'),
            'listbtn' => $this->getListBtn()
        ];
        $combo  = $this->comboKodepengeluaran();
        $comboKodepengeluaran = $combo['data'];
        $acosPengeluaran = $combo['acos'];
        $data = array_merge(
            compact('title', 'data', 'comboKodepengeluaran', 'acosPengeluaran'),
            ["request" => $request->all()]
        );
        return view('pengeluarantruckingheader.index', $data);
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
            ->get(config('app.api_url') . 'pengeluarantruckingheader', $params);

        $data = [
            'total' => $response['attributes']['totalPages'] ?? [],
            'records' => $response['attributes']['totalRows'] ?? [],
            'rows' => $response['data'] ?? [],
            'params' => $response['params'] ?? [],
        ];

        return $data;
    }

    public function edit($id)
    {
        $title = $this->title;

        $response = Http::withHeaders($this->httpHeaders)
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . "pengeluarantruckingheader/$id");
        // dd($response->getBody()->getContents());

        $pengeluarantruckingheader = $response['data'];


        $combo = $this->combo();

        return view('pengeluarantruckingheader.edit', compact('title', 'pengeluarantruckingheader', 'combo'));
    }
    public function comboKodepengeluaran()
    {
        $params = [
            'limit' => 0,
            'roleinput' => 'role',
            'sortIndex' => 'keterangan'
        ];
        $response = Http::withHeaders($this->httpHeaders)
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'pengeluarantrucking', $params);

        return $response;
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
        $pengeluarantrucking = Http::withHeaders($request->header())
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'pengeluarantruckingheader/' . $id . '/export')['data'];

        //FETCH DETAIL
        $detailParams = [
            'forReport' => true,
            'pengeluarantruckingheader_id' => $request->id,
        ];
        $pengeluarantrucking_details = Http::withHeaders($request->header())
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'pengeluarantruckingdetail', $detailParams)['data'];

        $combo = $this->combo('list');
        $key = array_search('CETAK', array_column($combo, 'parameter'));
        $pengeluarantrucking["combo"] =  $combo[$key];
        $printer['tipe'] = $request->printer;
        return view('reports.pengeluarantruckingheader', compact('pengeluarantrucking_details', 'pengeluarantrucking', 'printer'));
    }

    public function export(Request $request): void
    {

        //FETCH HEADER
        $id = $request->id;
        $pengeluarantrucking = Http::withHeaders($request->header())
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'pengeluarantruckingheader/' . $id . '/export')['data'];

        //FETCH DETAIL
        $detailParams = [
            'forReport' => true,
            'pengeluarantruckingheader_id' => $request->id,
        ];

        $pengeluarantrucking_details = Http::withHeaders($request->header())
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'pengeluarantruckingdetail', $detailParams)['data'];
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

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', $pengeluarantrucking['judul']);
        $sheet->setCellValue('A2', $pengeluarantrucking['judulLaporan']);
        $sheet->getStyle("A1")->getFont()->setSize(12);
        $sheet->getStyle("A2")->getFont()->setSize(12);
        $sheet->getStyle("A1")->getFont()->setBold(true);
        $sheet->getStyle("A2")->getFont()->setBold(true);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal('center');
        $sheet->getStyle('A2')->getAlignment()->setHorizontal('center');
        $sheet->mergeCells('A1:G1');
        $sheet->mergeCells('A2:G2');

        $alphabets = range('A', 'Z');


        switch ($pengeluarantrucking['statusformat']) {
            case '122':
                //PJT
                $header_start_row = 4;
                $header_right_start_row = 4;
                $detail_table_header_row = 8;
                $detail_start_row = $detail_table_header_row + 1;


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
                        'label' => 'No Bukti Pengeluaran',
                        'index' => 'pengeluaran_nobukti',
                    ],
                ];

                $header_right_columns = [
                    [
                        'label' => 'Pengeluaran Trucking',
                        'index' => 'pengeluarantrucking_id',
                    ],
                    [
                        'label' => 'Nama Perkiraan',
                        'index' => 'coa',
                    ],
                    [
                        'label' => 'Bank',
                        'index' => 'bank_id',
                    ],

                ];

                //LOOPING HEADER        
                foreach ($header_columns as $header_column) {
                    $sheet->setCellValue('B' . $header_start_row, $header_column['label']);
                    if ($header_column['index'] == 'tglbukti') {
                        $pengeluarantrucking[$header_column['index']] = date('d-m-Y', strtotime($pengeluarantrucking[$header_column['index']]));
                    }
                    $sheet->setCellValue('C' . $header_start_row++, ': ' . $pengeluarantrucking[$header_column['index']]);
                }
                foreach ($header_right_columns as $header_right_column) {
                    $sheet->setCellValue('D' . $header_right_start_row, $header_right_column['label']);
                    $sheet->setCellValue('E' . $header_right_start_row++, ': ' . $pengeluarantrucking[$header_right_column['index']]);
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
                        'index' => 'keterangan',
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
                // $sheet->getStyle("A$detail_table_header_row:G$detail_table_header_row")->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('FF1F456E');
                $sheet->getStyle("A$detail_table_header_row:D$detail_table_header_row")->applyFromArray($styleArray);

                // LOOPING DETAIL
                $nominal = 0;
                foreach ($pengeluarantrucking_details as $response_index => $response_detail) {

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
                    $sheet->getColumnDimension('C')->setWidth(50);

                    $sheet->getStyle("A$detail_start_row:C$detail_start_row")->applyFromArray($styleArray);
                    $sheet->getStyle("D$detail_start_row")->applyFromArray($style_number)->getNumberFormat()->setFormatCode("#,##0.00_);(#,##0.00)");
                    $detail_start_row++;
                }

                $total_start_row = $detail_start_row;
                $sheet->mergeCells('A' . $total_start_row . ':C' . $total_start_row);
                $sheet->setCellValue("A$total_start_row", 'Total')->getStyle('A' . $total_start_row . ':C' . $total_start_row)->applyFromArray($styleArray)->getFont()->setBold(true);
                $totalKredit = "=SUM(D" . ($detail_table_header_row + 1) . ":D" . ($detail_start_row - 1) . ")";
                $sheet->setCellValue("D$total_start_row", $totalKredit)->getStyle("D$total_start_row")->applyFromArray($style_number)->getNumberFormat()->setFormatCode("#,##0.00_);(#,##0.00)");
                $sheet->getStyle("D$total_start_row")->getFont()->setBold(true);

                $sheet->getColumnDimension('A')->setAutoSize(true);
                $sheet->getColumnDimension('B')->setAutoSize(true);
                $sheet->getColumnDimension('D')->setAutoSize(true);
                $writer = new Xlsx($spreadsheet);
                $filename = 'Laporan Pengeluaran Trucking (PJT)' . date('dmYHis');
                header('Content-Type: application/vnd.ms-excel');
                header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
                header('Cache-Control: max-age=0');
                $writer->save('php://output');
                break;
            case '251':
                //TDE
                $header_start_row = 4;
                $header_right_start_row = 4;
                $detail_table_header_row = 9;
                $detail_start_row = $detail_table_header_row + 1;


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
                        'label' => 'No Bukti Pengeluaran',
                        'index' => 'pengeluaran_nobukti',
                    ],

                    [
                        'label' => 'Bank',
                        'index' => 'bank_id',
                    ]
                ];

                $header_right_columns = [
                    [
                        'label' => 'Pengeluaran Trucking',
                        'index' => 'pengeluarantrucking_id',
                    ],
                    [
                        'label' => 'Supir',
                        'index' => 'supir',
                    ],
                    [
                        'label' => 'Trado',
                        'index' => 'trado',
                    ],
                    [
                        'label' => 'Nama Perkiraan',
                        'index' => 'coa',
                    ],

                ];

                //LOOPING HEADER        
                foreach ($header_columns as $header_column) {
                    $sheet->setCellValue('B' . $header_start_row, $header_column['label']);
                    if ($header_column['index'] == 'tglbukti') {
                        $pengeluarantrucking[$header_column['index']] = date('d-m-Y', strtotime($pengeluarantrucking[$header_column['index']]));
                    }
                    $sheet->setCellValue('C' . $header_start_row++, ': ' . $pengeluarantrucking[$header_column['index']]);
                }
                foreach ($header_right_columns as $header_right_column) {
                    $sheet->setCellValue('D' . $header_right_start_row, $header_right_column['label']);
                    $sheet->setCellValue('E' . $header_right_start_row++, ': ' . $pengeluarantrucking[$header_right_column['index']]);
                }

                $detail_columns = [
                    [
                        'label' => 'NO',
                    ],
                    [
                        'label' => 'NO BUKTI PENERIMAAN TRUCKING',
                        'index' => 'penerimaantruckingheader_nobukti',
                    ],
                    [
                        'label' => 'SUPIR',
                        'index' => 'supir_id',
                    ],
                    [
                        'label' => 'KETERANGAN',
                        'index' => 'keterangan',
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
                // $sheet->getStyle("A$detail_table_header_row:G$detail_table_header_row")->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('FF1F456E');
                $sheet->getStyle("A$detail_table_header_row:E$detail_table_header_row")->applyFromArray($styleArray);

                // LOOPING DETAIL
                $nominal = 0;
                foreach ($pengeluarantrucking_details as $response_index => $response_detail) {

                    foreach ($detail_columns as $detail_columns_index => $detail_column) {
                        $sheet->setCellValue($alphabets[$detail_columns_index] . $detail_start_row, isset($detail_column['index']) ? $response_detail[$detail_column['index']] : $response_index + 1);
                        $sheet->getStyle("A$detail_table_header_row:E$detail_table_header_row")->getFont()->setBold(true);
                        $sheet->getStyle("A$detail_table_header_row:E$detail_table_header_row")->getAlignment()->setHorizontal('center');
                    }

                    $sheet->setCellValue("A$detail_start_row", $response_index + 1);
                    $sheet->setCellValue("B$detail_start_row", $response_detail['penerimaantruckingheader_nobukti']);
                    $sheet->setCellValue("C$detail_start_row", $response_detail['supir_id']);
                    $sheet->setCellValue("D$detail_start_row", $response_detail['keterangan']);
                    $sheet->setCellValue("E$detail_start_row", $response_detail['nominal']);

                    // $sheet->getStyle("D$detail_start_row")->getAlignment()->setWrapText(true);
                    $sheet->getColumnDimension('D')->setWidth(50);

                    $sheet->getStyle("A$detail_start_row:D$detail_start_row")->applyFromArray($styleArray);
                    $sheet->getStyle("E$detail_start_row")->applyFromArray($style_number)->getNumberFormat()->setFormatCode("#,##0.00_);(#,##0.00)");
                    $detail_start_row++;
                }

                $total_start_row = $detail_start_row;
                $sheet->mergeCells('A' . $total_start_row . ':D' . $total_start_row);
                $sheet->setCellValue("A$total_start_row", 'Total')->getStyle('A' . $total_start_row . ':D' . $total_start_row)->applyFromArray($styleArray)->getFont()->setBold(true);
                $totalKredit = "=SUM(E" . ($detail_table_header_row + 1) . ":E" . ($detail_start_row - 1) . ")";
                $sheet->setCellValue("E$total_start_row", $totalKredit)->getStyle("E$total_start_row")->applyFromArray($style_number)->getNumberFormat()->setFormatCode("#,##0.00_);(#,##0.00)");
                $sheet->getStyle("E$total_start_row")->getFont()->setBold(true);

                $sheet->getColumnDimension('A')->setAutoSize(true);
                $sheet->getColumnDimension('B')->setAutoSize(true);
                $sheet->getColumnDimension('C')->setAutoSize(true);
                $sheet->getColumnDimension('E')->setAutoSize(true);
                $writer = new Xlsx($spreadsheet);
                $filename = 'Laporan Pengeluaran Trucking (TDE)' . date('dmYHis');
                header('Content-Type: application/vnd.ms-excel');
                header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
                header('Cache-Control: max-age=0');
                $writer->save('php://output');
                break;
            case '289':
                //BST
                $header_start_row = 4;
                $header_right_start_row = 4;
                $detail_table_header_row = 9;
                $detail_start_row = $detail_table_header_row + 1;


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
                        'label' => 'No Bukti Pengeluaran',
                        'index' => 'pengeluaran_nobukti',
                    ],

                    [
                        'label' => 'Bank',
                        'index' => 'bank_id',
                    ]
                ];

                $header_right_columns = [
                    [
                        'label' => 'Pengeluaran Trucking',
                        'index' => 'pengeluarantrucking_id',
                    ],
                    [
                        'label' => 'Periode Dari',
                        'index' => 'periodedari',
                    ],
                    [
                        'label' => 'Periode Sampai',
                        'index' => 'periodesampai',
                    ],
                    [
                        'label' => 'Nama Perkiraan',
                        'index' => 'coa',
                    ],

                ];
                // dd($pengeluarantrucking);
                //LOOPING HEADER        
                foreach ($header_columns as $header_column) {
                    $sheet->setCellValue('B' . $header_start_row, $header_column['label']);
                    if ($header_column['index'] == 'tglbukti') {
                        $pengeluarantrucking[$header_column['index']] = date('d-m-Y', strtotime($pengeluarantrucking[$header_column['index']]));
                    }
                    $sheet->setCellValue('C' . $header_start_row++, ': ' . $pengeluarantrucking[$header_column['index']]);
                }
                foreach ($header_right_columns as $header_right_column) {
                    $sheet->setCellValue('D' . $header_right_start_row, $header_right_column['label']);
                    if ($header_right_column['index'] == 'periodedari' || $header_right_column['index'] == 'periodesampai') {
                        $pengeluarantrucking[$header_right_column['index']] = date('d-m-Y', strtotime($pengeluarantrucking[$header_right_column['index']]));
                    }
                    $sheet->setCellValue('E' . $header_right_start_row++, ': ' . $pengeluarantrucking[$header_right_column['index']]);
                }

                $detail_columns = [
                    [
                        'label' => 'NO',
                    ],
                    [
                        'label' => 'NO BUKTI INVOICE',
                        'index' => 'invoice_nobukti',
                    ],
                    [
                        'label' => 'NO ORDERAN TRUCKING',
                        'index' => 'orderantrucking_nobukti',
                    ],
                    [
                        'label' => 'KETERANGAN',
                        'index' => 'keterangan',
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
                // $sheet->getStyle("A$detail_table_header_row:G$detail_table_header_row")->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('FF1F456E');
                $sheet->getStyle("A$detail_table_header_row:E$detail_table_header_row")->applyFromArray($styleArray);

                // LOOPING DETAIL
                $nominal = 0;
                foreach ($pengeluarantrucking_details as $response_index => $response_detail) {

                    foreach ($detail_columns as $detail_columns_index => $detail_column) {
                        $sheet->setCellValue($alphabets[$detail_columns_index] . $detail_start_row, isset($detail_column['index']) ? $response_detail[$detail_column['index']] : $response_index + 1);
                        $sheet->getStyle("A$detail_table_header_row:E$detail_table_header_row")->getFont()->setBold(true);
                        $sheet->getStyle("A$detail_table_header_row:E$detail_table_header_row")->getAlignment()->setHorizontal('center');
                    }

                    $sheet->setCellValue("A$detail_start_row", $response_index + 1);
                    $sheet->setCellValue("B$detail_start_row", $response_detail['invoice_nobukti']);
                    $sheet->setCellValue("C$detail_start_row", $response_detail['orderantrucking_nobukti']);
                    $sheet->setCellValue("D$detail_start_row", $response_detail['keterangan']);
                    $sheet->setCellValue("E$detail_start_row", $response_detail['nominal']);

                    // $sheet->getStyle("D$detail_start_row")->getAlignment()->setWrapText(true);
                    $sheet->getColumnDimension('D')->setWidth(50);

                    $sheet->getStyle("A$detail_start_row:D$detail_start_row")->applyFromArray($styleArray);
                    $sheet->getStyle("E$detail_start_row")->applyFromArray($style_number)->getNumberFormat()->setFormatCode("#,##0.00_);(#,##0.00)");
                    $detail_start_row++;
                }

                $total_start_row = $detail_start_row;
                $sheet->mergeCells('A' . $total_start_row . ':D' . $total_start_row);
                $sheet->setCellValue("A$total_start_row", 'Total')->getStyle('A' . $total_start_row . ':D' . $total_start_row)->applyFromArray($styleArray)->getFont()->setBold(true);
                $totalKredit = "=SUM(E" . ($detail_table_header_row + 1) . ":E" . ($detail_start_row - 1) . ")";
                $sheet->setCellValue("E$total_start_row", $totalKredit)->getStyle("E$total_start_row")->applyFromArray($style_number)->getNumberFormat()->setFormatCode("#,##0.00_);(#,##0.00)");
                $sheet->getStyle("E$total_start_row")->getFont()->setBold(true);

                $sheet->getColumnDimension('A')->setAutoSize(true);
                $sheet->getColumnDimension('B')->setAutoSize(true);
                $sheet->getColumnDimension('C')->setAutoSize(true);
                $sheet->getColumnDimension('E')->setAutoSize(true);
                $writer = new Xlsx($spreadsheet);
                $filename = 'Laporan Pengeluaran Trucking (BST)' . date('dmYHis');
                header('Content-Type: application/vnd.ms-excel');
                header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
                header('Cache-Control: max-age=0');
                $writer->save('php://output');
                break;

            case '297':
                //BSB
                $header_start_row = 4;
                $header_right_start_row = 4;
                $detail_table_header_row = 8;
                $detail_start_row = $detail_table_header_row + 1;


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
                        'label' => 'No Bukti Pengeluaran',
                        'index' => 'pengeluaran_nobukti',
                    ],
                ];

                $header_right_columns = [
                    [
                        'label' => 'Pengeluaran Trucking',
                        'index' => 'pengeluarantrucking_id',
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
                    if ($header_column['index'] == 'tglbukti') {
                        $pengeluarantrucking[$header_column['index']] = date('d-m-Y', strtotime($pengeluarantrucking[$header_column['index']]));
                    }
                    $sheet->setCellValue('C' . $header_start_row++, ': ' . $pengeluarantrucking[$header_column['index']]);
                }
                foreach ($header_right_columns as $header_right_column) {
                    $sheet->setCellValue('D' . $header_right_start_row, $header_right_column['label']);
                    $sheet->setCellValue('E' . $header_right_start_row++, ': ' . $pengeluarantrucking[$header_right_column['index']]);
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
                        'index' => 'keterangan',
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
                // $sheet->getStyle("A$detail_table_header_row:G$detail_table_header_row")->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('FF1F456E');
                $sheet->getStyle("A$detail_table_header_row:D$detail_table_header_row")->applyFromArray($styleArray);

                // LOOPING DETAIL
                $nominal = 0;
                foreach ($pengeluarantrucking_details as $response_index => $response_detail) {

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
                    $sheet->getColumnDimension('C')->setWidth(50);

                    $sheet->getStyle("A$detail_start_row:C$detail_start_row")->applyFromArray($styleArray);
                    $sheet->getStyle("D$detail_start_row")->applyFromArray($style_number)->getNumberFormat()->setFormatCode("#,##0.00_);(#,##0.00)");
                    $detail_start_row++;
                }

                $total_start_row = $detail_start_row;
                $sheet->mergeCells('A' . $total_start_row . ':C' . $total_start_row);
                $sheet->setCellValue("A$total_start_row", 'Total')->getStyle('A' . $total_start_row . ':C' . $total_start_row)->applyFromArray($styleArray)->getFont()->setBold(true);
                $totalKredit = "=SUM(D" . ($detail_table_header_row + 1) . ":D" . ($detail_start_row - 1) . ")";
                $sheet->setCellValue("D$total_start_row", $totalKredit)->getStyle("D$total_start_row")->applyFromArray($style_number)->getNumberFormat()->setFormatCode("#,##0.00_);(#,##0.00)");
                $sheet->getStyle("D$total_start_row")->getFont()->setBold(true);

                $sheet->getColumnDimension('A')->setAutoSize(true);
                $sheet->getColumnDimension('B')->setAutoSize(true);
                $sheet->getColumnDimension('D')->setAutoSize(true);
                $writer = new Xlsx($spreadsheet);
                $filename = 'Laporan Pengeluaran Trucking (BSB)' . date('dmYHis');
                header('Content-Type: application/vnd.ms-excel');
                header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
                header('Cache-Control: max-age=0');
                $writer->save('php://output');
                break;
            case '298':
                //KBBM
                $header_start_row = 4;
                $header_right_start_row = 4;
                $detail_table_header_row = 9;
                $detail_start_row = $detail_table_header_row + 1;


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
                        'label' => 'No Bukti Pengeluaran',
                        'index' => 'pengeluaran_nobukti',
                    ],

                    [
                        'label' => 'Bank',
                        'index' => 'bank_id',
                    ]
                ];

                $header_right_columns = [
                    [
                        'label' => 'Pengeluaran Trucking',
                        'index' => 'pengeluarantrucking_id',
                    ],
                    [
                        'label' => 'Periode Dari',
                        'index' => 'periodedari',
                    ],
                    [
                        'label' => 'Periode Sampai',
                        'index' => 'periodesampai',
                    ],
                    [
                        'label' => 'Nama Perkiraan',
                        'index' => 'coa',
                    ],

                ];
                // dd($pengeluarantrucking);
                //LOOPING HEADER        
                foreach ($header_columns as $header_column) {
                    $sheet->setCellValue('B' . $header_start_row, $header_column['label']);
                    if ($header_column['index'] == 'tglbukti') {
                        $pengeluarantrucking[$header_column['index']] = date('d-m-Y', strtotime($pengeluarantrucking[$header_column['index']]));
                    }
                    $sheet->setCellValue('C' . $header_start_row++, ': ' . $pengeluarantrucking[$header_column['index']]);
                }
                foreach ($header_right_columns as $header_right_column) {
                    $sheet->setCellValue('D' . $header_right_start_row, $header_right_column['label']);
                    if ($header_right_column['index'] == 'periodedari' || $header_right_column['index'] == 'periodesampai') {
                        $pengeluarantrucking[$header_right_column['index']] = date('d-m-Y', strtotime($pengeluarantrucking[$header_right_column['index']]));
                    }
                    $sheet->setCellValue('E' . $header_right_start_row++, ': ' . $pengeluarantrucking[$header_right_column['index']]);
                }

                $detail_columns = [
                    [
                        'label' => 'NO',
                    ],
                    [
                        'label' => 'NO BUKTI PENERIMAAN TRUCKING',
                        'index' => 'penerimaantruckingheader_nobukti',
                    ],
                    [
                        'label' => 'KETERANGAN',
                        'index' => 'keterangan',
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
                // $sheet->getStyle("A$detail_table_header_row:G$detail_table_header_row")->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('FF1F456E');
                $sheet->getStyle("A$detail_table_header_row:D$detail_table_header_row")->applyFromArray($styleArray);

                // LOOPING DETAIL
                $nominal = 0;
                foreach ($pengeluarantrucking_details as $response_index => $response_detail) {

                    foreach ($detail_columns as $detail_columns_index => $detail_column) {
                        $sheet->setCellValue($alphabets[$detail_columns_index] . $detail_start_row, isset($detail_column['index']) ? $response_detail[$detail_column['index']] : $response_index + 1);
                        $sheet->getStyle("A$detail_table_header_row:D$detail_table_header_row")->getFont()->setBold(true);
                        $sheet->getStyle("A$detail_table_header_row:D$detail_table_header_row")->getAlignment()->setHorizontal('center');
                    }

                    $sheet->setCellValue("A$detail_start_row", $response_index + 1);
                    $sheet->setCellValue("B$detail_start_row", $response_detail['penerimaantruckingheader_nobukti']);
                    $sheet->setCellValue("C$detail_start_row", $response_detail['keterangan']);
                    $sheet->setCellValue("D$detail_start_row", $response_detail['nominal']);

                    // $sheet->getStyle("C$detail_start_row")->getAlignment()->setWrapText(true);
                    $sheet->getColumnDimension('C')->setWidth(50);

                    $sheet->getStyle("A$detail_start_row:C$detail_start_row")->applyFromArray($styleArray);
                    $sheet->getStyle("D$detail_start_row")->applyFromArray($style_number)->getNumberFormat()->setFormatCode("#,##0.00_);(#,##0.00)");
                    $detail_start_row++;
                }

                $total_start_row = $detail_start_row;
                $sheet->mergeCells('A' . $total_start_row . ':C' . $total_start_row);
                $sheet->setCellValue("A$total_start_row", 'Total')->getStyle('A' . $total_start_row . ':C' . $total_start_row)->applyFromArray($styleArray)->getFont()->setBold(true);
                $totalKredit = "=SUM(D" . ($detail_table_header_row + 1) . ":D" . ($detail_start_row - 1) . ")";
                $sheet->setCellValue("D$total_start_row", $totalKredit)->getStyle("D$total_start_row")->applyFromArray($style_number)->getNumberFormat()->setFormatCode("#,##0.00_);(#,##0.00)");
                $sheet->getStyle("D$total_start_row")->getFont()->setBold(true);

                $sheet->getColumnDimension('A')->setAutoSize(true);
                $sheet->getColumnDimension('B')->setAutoSize(true);
                $sheet->getColumnDimension('D')->setAutoSize(true);
                $writer = new Xlsx($spreadsheet);
                $filename = 'Laporan Pengeluaran Trucking (KBBM)' . date('dmYHis');
                header('Content-Type: application/vnd.ms-excel');
                header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
                header('Cache-Control: max-age=0');
                $writer->save('php://output');
                break;
            case '279':
                //BLS
                $header_start_row = 4;
                $header_right_start_row = 4;
                $detail_table_header_row = 8;
                $detail_start_row = $detail_table_header_row + 1;


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
                        'label' => 'No Bukti Pengeluaran',
                        'index' => 'pengeluaran_nobukti',
                    ],
                ];

                $header_right_columns = [
                    [
                        'label' => 'Pengeluaran Trucking',
                        'index' => 'pengeluarantrucking_id',
                    ],
                    [
                        'label' => 'Nama Perkiraan',
                        'index' => 'coa',
                    ],
                    [
                        'label' => 'Bank',
                        'index' => 'bank_id',
                    ],

                ];

                //LOOPING HEADER        
                foreach ($header_columns as $header_column) {
                    $sheet->setCellValue('B' . $header_start_row, $header_column['label']);
                    if ($header_column['index'] == 'tglbukti') {
                        $pengeluarantrucking[$header_column['index']] = date('d-m-Y', strtotime($pengeluarantrucking[$header_column['index']]));
                    }
                    $sheet->setCellValue('C' . $header_start_row++, ': ' . $pengeluarantrucking[$header_column['index']]);
                }
                foreach ($header_right_columns as $header_right_column) {
                    $sheet->setCellValue('D' . $header_right_start_row, $header_right_column['label']);
                    $sheet->setCellValue('E' . $header_right_start_row++, ': ' . $pengeluarantrucking[$header_right_column['index']]);
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
                        'index' => 'keterangan',
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
                // $sheet->getStyle("A$detail_table_header_row:G$detail_table_header_row")->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('FF1F456E');
                $sheet->getStyle("A$detail_table_header_row:D$detail_table_header_row")->applyFromArray($styleArray);

                // LOOPING DETAIL
                $nominal = 0;
                foreach ($pengeluarantrucking_details as $response_index => $response_detail) {

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
                    $sheet->getColumnDimension('C')->setWidth(50);

                    $sheet->getStyle("A$detail_start_row:C$detail_start_row")->applyFromArray($styleArray);
                    $sheet->getStyle("D$detail_start_row")->applyFromArray($style_number)->getNumberFormat()->setFormatCode("#,##0.00_);(#,##0.00)");
                    $detail_start_row++;
                }

                $total_start_row = $detail_start_row;
                $sheet->mergeCells('A' . $total_start_row . ':C' . $total_start_row);
                $sheet->setCellValue("A$total_start_row", 'Total')->getStyle('A' . $total_start_row . ':C' . $total_start_row)->applyFromArray($styleArray)->getFont()->setBold(true);
                $totalKredit = "=SUM(D" . ($detail_table_header_row + 1) . ":D" . ($detail_start_row - 1) . ")";
                $sheet->setCellValue("D$total_start_row", $totalKredit)->getStyle("D$total_start_row")->applyFromArray($style_number)->getNumberFormat()->setFormatCode("#,##0.00_);(#,##0.00)");
                $sheet->getStyle("D$total_start_row")->getFont()->setBold(true);

                $sheet->getColumnDimension('A')->setAutoSize(true);
                $sheet->getColumnDimension('B')->setAutoSize(true);
                $sheet->getColumnDimension('D')->setAutoSize(true);
                $writer = new Xlsx($spreadsheet);
                $filename = 'Laporan Pengeluaran Trucking (BLS)' . date('dmYHis');
                header('Content-Type: application/vnd.ms-excel');
                header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
                header('Cache-Control: max-age=0');
                $writer->save('php://output');
                break;
            case '318':
                //KLAIM
                $header_start_row = 4;
                $header_right_start_row = 4;
                $detail_table_header_row = 8;
                $detail_start_row = $detail_table_header_row + 1;


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
                        'label' => 'No Bukti Pengeluaran',
                        'index' => 'pengeluarantrucking_nobukti',
                    ],
                ];

                $header_right_columns = [
                    [
                        'label' => 'Pengeluaran Trucking',
                        'index' => 'pengeluarantrucking_id',
                    ],
                    [
                        'label' => 'Supir',
                        'index' => 'supir',
                    ],
                    [
                        'label' => 'Trado',
                        'index' => 'trado',
                    ],

                ];
                //LOOPING HEADER        
                foreach ($header_columns as $header_column) {
                    $sheet->setCellValue('B' . $header_start_row, $header_column['label']);
                    if ($header_column['index'] == 'tglbukti') {
                        $pengeluarantrucking[$header_column['index']] = date('d-m-Y', strtotime($pengeluarantrucking[$header_column['index']]));
                    }
                    $sheet->setCellValue('C' . $header_start_row++, ': ' . $pengeluarantrucking[$header_column['index']]);
                }
                foreach ($header_right_columns as $header_right_column) {
                    $sheet->setCellValue('D' . $header_right_start_row, $header_right_column['label']);
                    $sheet->setCellValue('E' . $header_right_start_row++, ': ' . $pengeluarantrucking[$header_right_column['index']]);
                }

                $detail_columns = [
                    [
                        'label' => 'NO',
                    ],
                    [
                        'label' => 'NO BUKTI PENGELUARAN STOK',
                        'index' => 'pengeluaranstok_nobukti',
                    ],
                    [
                        'label' => 'STOK',
                        'index' => 'stok_id',
                    ],
                    [
                        'label' => 'KETERANGAN',
                        'index' => 'keterangan',
                    ],
                    [
                        'label' => 'HARGA',
                        'index' => 'harga',
                        'format' => 'currency'
                    ],
                    [
                        'label' => 'QTY',
                        'index' => 'qty',
                        'format' => 'currency'
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
                // $sheet->getStyle("A$detail_table_header_row:G$detail_table_header_row")->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('FF1F456E');
                $sheet->getStyle("A$detail_table_header_row:G$detail_table_header_row")->applyFromArray($styleArray);

                // LOOPING DETAIL
                $nominal = 0;
                foreach ($pengeluarantrucking_details as $response_index => $response_detail) {

                    foreach ($detail_columns as $detail_columns_index => $detail_column) {
                        $sheet->setCellValue($alphabets[$detail_columns_index] . $detail_start_row, isset($detail_column['index']) ? $response_detail[$detail_column['index']] : $response_index + 1);
                        $sheet->getStyle("A$detail_table_header_row:G$detail_table_header_row")->getFont()->setBold(true);
                        $sheet->getStyle("A$detail_table_header_row:G$detail_table_header_row")->getAlignment()->setHorizontal('center');
                    }

                    $sheet->setCellValue("A$detail_start_row", $response_index + 1);
                    $sheet->setCellValue("B$detail_start_row", $response_detail['pengeluaranstok_nobukti']);
                    $sheet->setCellValue("C$detail_start_row", $response_detail['stok_id']);
                    $sheet->setCellValue("D$detail_start_row", $response_detail['keterangan']);
                    $sheet->setCellValue("E$detail_start_row", $response_detail['harga']);
                    $sheet->setCellValue("F$detail_start_row", $response_detail['qty']);
                    $sheet->setCellValue("G$detail_start_row", $response_detail['nominal']);

                    // $sheet->getStyle("D$detail_start_row")->getAlignment()->setWrapText(true);
                    $sheet->getColumnDimension('D')->setWidth(50);

                    $sheet->getStyle("A$detail_start_row:D$detail_start_row")->applyFromArray($styleArray);
                    $sheet->getStyle("E$detail_start_row:G$detail_start_row")->applyFromArray($style_number)->getNumberFormat()->setFormatCode("#,##0.00_);(#,##0.00)");
                    $detail_start_row++;
                }

                $total_start_row = $detail_start_row;
                $sheet->mergeCells('A' . $total_start_row . ':F' . $total_start_row);
                $sheet->setCellValue("A$total_start_row", 'Total')->getStyle('A' . $total_start_row . ':F' . $total_start_row)->applyFromArray($styleArray)->getFont()->setBold(true);
                $totalKredit = "=SUM(G" . ($detail_table_header_row + 1) . ":G" . ($detail_start_row - 1) . ")";
                $sheet->setCellValue("G$total_start_row", $totalKredit)->getStyle("G$total_start_row")->applyFromArray($style_number)->getNumberFormat()->setFormatCode("#,##0.00_);(#,##0.00)");
                $sheet->getStyle("G$total_start_row")->getFont()->setBold(true);

                $sheet->getColumnDimension('A')->setAutoSize(true);
                $sheet->getColumnDimension('B')->setAutoSize(true);
                $sheet->getColumnDimension('C')->setAutoSize(true);
                $sheet->getColumnDimension('E')->setAutoSize(true);
                $sheet->getColumnDimension('F')->setAutoSize(true);
                $sheet->getColumnDimension('G')->setAutoSize(true);
                $writer = new Xlsx($spreadsheet);
                $filename = 'Laporan Pengeluaran Trucking (KLAIM)' . date('dmYHis');
                header('Content-Type: application/vnd.ms-excel');
                header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
                header('Cache-Control: max-age=0');
                $writer->save('php://output');
                break;
            case '369':
                //PJK
                $header_start_row = 4;
                $header_right_start_row = 4;
                $detail_table_header_row = 8;
                $detail_start_row = $detail_table_header_row + 1;


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
                        'label' => 'No Bukti Pengeluaran',
                        'index' => 'pengeluaran_nobukti',
                    ],
                ];

                $header_right_columns = [
                    [
                        'label' => 'Pengeluaran Trucking',
                        'index' => 'pengeluarantrucking_id',
                    ],
                    [
                        'label' => 'Nama Perkiraan',
                        'index' => 'coa',
                    ],
                    [
                        'label' => 'Bank',
                        'index' => 'bank_id',
                    ]

                ];

                //LOOPING HEADER        
                foreach ($header_columns as $header_column) {
                    $sheet->setCellValue('B' . $header_start_row, $header_column['label']);
                    if ($header_column['index'] == 'tglbukti') {
                        $pengeluarantrucking[$header_column['index']] = date('d-m-Y', strtotime($pengeluarantrucking[$header_column['index']]));
                    }
                    $sheet->setCellValue('C' . $header_start_row++, ': ' . $pengeluarantrucking[$header_column['index']]);
                }
                foreach ($header_right_columns as $header_right_column) {
                    $sheet->setCellValue('D' . $header_right_start_row, $header_right_column['label']);
                    $sheet->setCellValue('E' . $header_right_start_row++, ': ' . $pengeluarantrucking[$header_right_column['index']]);
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
                        'index' => 'keterangan',
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
                // $sheet->getStyle("A$detail_table_header_row:G$detail_table_header_row")->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('FF1F456E');
                $sheet->getStyle("A$detail_table_header_row:D$detail_table_header_row")->applyFromArray($styleArray);

                // LOOPING DETAIL
                $nominal = 0;
                foreach ($pengeluarantrucking_details as $response_index => $response_detail) {

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
                    $sheet->getColumnDimension('C')->setWidth(50);

                    $sheet->getStyle("A$detail_start_row:C$detail_start_row")->applyFromArray($styleArray);
                    $sheet->getStyle("D$detail_start_row")->applyFromArray($style_number)->getNumberFormat()->setFormatCode("#,##0.00_);(#,##0.00)");
                    $detail_start_row++;
                }

                $total_start_row = $detail_start_row;
                $sheet->mergeCells('A' . $total_start_row . ':C' . $total_start_row);
                $sheet->setCellValue("A$total_start_row", 'Total')->getStyle('A' . $total_start_row . ':C' . $total_start_row)->applyFromArray($styleArray)->getFont()->setBold(true);
                $totalKredit = "=SUM(D" . ($detail_table_header_row + 1) . ":D" . ($detail_start_row - 1) . ")";
                $sheet->setCellValue("D$total_start_row", $totalKredit)->getStyle("D$total_start_row")->applyFromArray($style_number)->getNumberFormat()->setFormatCode("#,##0.00_);(#,##0.00)");
                $sheet->getStyle("D$total_start_row")->getFont()->setBold(true);

                $sheet->getColumnDimension('A')->setAutoSize(true);
                $sheet->getColumnDimension('B')->setAutoSize(true);
                $sheet->getColumnDimension('D')->setAutoSize(true);
                $writer = new Xlsx($spreadsheet);
                $filename = 'Laporan Pengeluaran Trucking (PJK)' . date('dmYHis');
                header('Content-Type: application/vnd.ms-excel');
                header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
                header('Cache-Control: max-age=0');
                $writer->save('php://output');
                break;
            case '411':
                //BBT
                $header_start_row = 4;
                $header_right_start_row = 4;
                $detail_table_header_row = 8;
                $detail_start_row = $detail_table_header_row + 1;


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
                        'label' => 'No Bukti Pengeluaran',
                        'index' => 'pengeluaran_nobukti',
                    ],
                ];

                $header_right_columns = [
                    [
                        'label' => 'Pengeluaran Trucking',
                        'index' => 'pengeluarantrucking_id',
                    ],
                    [
                        'label' => 'Nama Perkiraan',
                        'index' => 'coa',
                    ],
                    [
                        'label' => 'Bank',
                        'index' => 'bank_id',
                    ]

                ];

                //LOOPING HEADER        
                foreach ($header_columns as $header_column) {
                    $sheet->setCellValue('B' . $header_start_row, $header_column['label']);
                    if ($header_column['index'] == 'tglbukti') {
                        $pengeluarantrucking[$header_column['index']] = date('d-m-Y', strtotime($pengeluarantrucking[$header_column['index']]));
                    }
                    $sheet->setCellValue('C' . $header_start_row++, ': ' . $pengeluarantrucking[$header_column['index']]);
                }
                foreach ($header_right_columns as $header_right_column) {
                    $sheet->setCellValue('D' . $header_right_start_row, $header_right_column['label']);
                    $sheet->setCellValue('E' . $header_right_start_row++, ': ' . $pengeluarantrucking[$header_right_column['index']]);
                }

                $detail_columns = [
                    [
                        'label' => 'NO',
                    ],
                    [
                        'label' => 'STATUS TITIPAN EMKL',
                        'index' => 'statustitipanemkl',
                    ],
                    [
                        'label' => 'NO BUKTI SURAT PENGANTAR',
                        'index' => 'suratpengantar_nobukti',
                    ],
                    [
                        'label' => 'KETERANGAN',
                        'index' => 'keterangan',
                    ],
                    [
                        'label' => 'JENIS ORDER',
                        'index' => 'jenisorderan',
                    ],
                    [
                        'label' => 'TRADO',
                        'index' => 'trado_id',
                    ],
                    [
                        'label' => 'NOMINAL TAGIH',
                        'index' => 'nominaltagih',
                        'format' => 'currency'
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
                // $sheet->getStyle("A$detail_table_header_row:G$detail_table_header_row")->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('FF1F456E');
                $sheet->getStyle("A$detail_table_header_row:H$detail_table_header_row")->applyFromArray($styleArray);

                // LOOPING DETAIL
                $nominal = 0;
                foreach ($pengeluarantrucking_details as $response_index => $response_detail) {

                    foreach ($detail_columns as $detail_columns_index => $detail_column) {
                        $sheet->setCellValue($alphabets[$detail_columns_index] . $detail_start_row, isset($detail_column['index']) ? $response_detail[$detail_column['index']] : $response_index + 1);
                        $sheet->getStyle("A$detail_table_header_row:H$detail_table_header_row")->getFont()->setBold(true);
                        $sheet->getStyle("A$detail_table_header_row:H$detail_table_header_row")->getAlignment()->setHorizontal('center');
                    }

                    $sheet->setCellValue("A$detail_start_row", $response_index + 1);
                    $sheet->setCellValue("B$detail_start_row", $response_detail['statustitipanemkl']);
                    $sheet->setCellValue("C$detail_start_row", $response_detail['suratpengantar_nobukti']);
                    $sheet->setCellValue("D$detail_start_row", $response_detail['keterangan']);
                    $sheet->setCellValue("E$detail_start_row", $response_detail['jenisorderan']);
                    $sheet->setCellValue("F$detail_start_row", $response_detail['trado_id']);
                    $sheet->setCellValue("G$detail_start_row", $response_detail['nominaltagih']);
                    $sheet->setCellValue("H$detail_start_row", $response_detail['nominal']);

                    // $sheet->getStyle("D$detail_start_row")->getAlignment()->setWrapText(true);

                    $sheet->getStyle("A$detail_start_row:F$detail_start_row")->applyFromArray($styleArray);
                    $sheet->getStyle("G$detail_start_row:H$detail_start_row")->applyFromArray($style_number)->getNumberFormat()->setFormatCode("#,##0.00_);(#,##0.00)");
                    $detail_start_row++;
                }

                $total_start_row = $detail_start_row;
                $sheet->mergeCells('A' . $total_start_row . ':G' . $total_start_row);
                $sheet->setCellValue("A$total_start_row", 'Total')->getStyle('A' . $total_start_row . ':G' . $total_start_row)->applyFromArray($styleArray)->getFont()->setBold(true);
                $totalKredit = "=SUM(H" . ($detail_table_header_row + 1) . ":H" . ($detail_start_row - 1) . ")";
                $sheet->setCellValue("H$total_start_row", $totalKredit)->getStyle("H$total_start_row")->applyFromArray($style_number)->getNumberFormat()->setFormatCode("#,##0.00_);(#,##0.00)");
                $sheet->getStyle("H$total_start_row")->getFont()->setBold(true);

                $sheet->getColumnDimension('A')->setAutoSize(true);
                $sheet->getColumnDimension('B')->setAutoSize(true);
                $sheet->getColumnDimension('C')->setAutoSize(true);
                $sheet->getColumnDimension('D')->setWidth(50);
                $sheet->getColumnDimension('E')->setAutoSize(true);
                $sheet->getColumnDimension('F')->setAutoSize(true);
                $sheet->getColumnDimension('G')->setAutoSize(true);
                $sheet->getColumnDimension('H')->setAutoSize(true);
                $writer = new Xlsx($spreadsheet);
                $filename = 'Laporan Pengeluaran Trucking (BBT)' . date('dmYHis');
                header('Content-Type: application/vnd.ms-excel');
                header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
                header('Cache-Control: max-age=0');
                $writer->save('php://output');
                break;
            case '545':
                //TDEK
                $header_start_row = 4;
                $header_right_start_row = 4;
                $detail_table_header_row = 9;
                $detail_start_row = $detail_table_header_row + 1;


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
                        'label' => 'No Bukti Pengeluaran',
                        'index' => 'pengeluaran_nobukti',
                    ],
                ];

                $header_right_columns = [
                    [
                        'label' => 'Pengeluaran Trucking',
                        'index' => 'pengeluarantrucking_id',
                    ],
                    [
                        'label' => 'Nama Perkiraan',
                        'index' => 'coa',
                    ],
                    [
                        'label' => 'Bank',
                        'index' => 'bank_id',
                    ]

                ];

                //LOOPING HEADER        
                foreach ($header_columns as $header_column) {
                    $sheet->setCellValue('B' . $header_start_row, $header_column['label']);
                    if ($header_column['index'] == 'tglbukti') {
                        $pengeluarantrucking[$header_column['index']] = date('d-m-Y', strtotime($pengeluarantrucking[$header_column['index']]));
                    }
                    $sheet->setCellValue('C' . $header_start_row++, ': ' . $pengeluarantrucking[$header_column['index']]);
                }
                foreach ($header_right_columns as $header_right_column) {
                    $sheet->setCellValue('D' . $header_right_start_row, $header_right_column['label']);
                    $sheet->setCellValue('E' . $header_right_start_row++, ': ' . $pengeluarantrucking[$header_right_column['index']]);
                }

                $detail_columns = [
                    [
                        'label' => 'NO',
                    ],
                    [
                        'label' => 'NO BUKTI PENERIMAAN TRUCKING',
                        'index' => 'penerimaantruckingheader_nobukti',
                    ],
                    [
                        'label' => 'KARYAWAN',
                        'index' => 'karyawan_id',
                    ],
                    [
                        'label' => 'KETERANGAN',
                        'index' => 'keterangan',
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
                // $sheet->getStyle("A$detail_table_header_row:G$detail_table_header_row")->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('FF1F456E');
                $sheet->getStyle("A$detail_table_header_row:E$detail_table_header_row")->applyFromArray($styleArray);

                // LOOPING DETAIL
                $nominal = 0;
                foreach ($pengeluarantrucking_details as $response_index => $response_detail) {

                    foreach ($detail_columns as $detail_columns_index => $detail_column) {
                        $sheet->setCellValue($alphabets[$detail_columns_index] . $detail_start_row, isset($detail_column['index']) ? $response_detail[$detail_column['index']] : $response_index + 1);
                        $sheet->getStyle("A$detail_table_header_row:E$detail_table_header_row")->getFont()->setBold(true);
                        $sheet->getStyle("A$detail_table_header_row:E$detail_table_header_row")->getAlignment()->setHorizontal('center');
                    }

                    $sheet->setCellValue("A$detail_start_row", $response_index + 1);
                    $sheet->setCellValue("B$detail_start_row", $response_detail['penerimaantruckingheader_nobukti']);
                    $sheet->setCellValue("C$detail_start_row", $response_detail['karyawan_id']);
                    $sheet->setCellValue("D$detail_start_row", $response_detail['keterangan']);
                    $sheet->setCellValue("E$detail_start_row", $response_detail['nominal']);

                    // $sheet->getStyle("D$detail_start_row")->getAlignment()->setWrapText(true);
                    $sheet->getColumnDimension('D')->setWidth(50);

                    $sheet->getStyle("A$detail_start_row:D$detail_start_row")->applyFromArray($styleArray);
                    $sheet->getStyle("E$detail_start_row")->applyFromArray($style_number)->getNumberFormat()->setFormatCode("#,##0.00_);(#,##0.00)");
                    $detail_start_row++;
                }

                $total_start_row = $detail_start_row;
                $sheet->mergeCells('A' . $total_start_row . ':D' . $total_start_row);
                $sheet->setCellValue("A$total_start_row", 'Total')->getStyle('A' . $total_start_row . ':D' . $total_start_row)->applyFromArray($styleArray)->getFont()->setBold(true);
                $totalKredit = "=SUM(E" . ($detail_table_header_row + 1) . ":E" . ($detail_start_row - 1) . ")";
                $sheet->setCellValue("E$total_start_row", $totalKredit)->getStyle("E$total_start_row")->applyFromArray($style_number)->getNumberFormat()->setFormatCode("#,##0.00_);(#,##0.00)");
                $sheet->getStyle("E$total_start_row")->getFont()->setBold(true);

                $sheet->getColumnDimension('A')->setAutoSize(true);
                $sheet->getColumnDimension('B')->setAutoSize(true);
                $sheet->getColumnDimension('C')->setAutoSize(true);
                $sheet->getColumnDimension('E')->setAutoSize(true);
                $writer = new Xlsx($spreadsheet);
                $filename = 'Laporan Pengeluaran Trucking (TDEK)' . date('dmYHis');
                header('Content-Type: application/vnd.ms-excel');
                header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
                header('Cache-Control: max-age=0');
                $writer->save('php://output');
                break;
            case '556':
            case '557':
                //OTOK&OTOL
                $header_start_row = 4;
                $header_right_start_row = 4;
                $detail_table_header_row = 10;
                $detail_start_row = $detail_table_header_row + 1;


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
                        'label' => 'No Bukti Pengeluaran',
                        'index' => 'pengeluaran_nobukti',
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

                $header_right_columns = [
                    [
                        'label' => 'Pengeluaran Trucking',
                        'index' => 'pengeluarantrucking_id',
                    ],
                    [
                        'label' => 'Periode Dari',
                        'index' => 'periodedari',
                    ],
                    [
                        'label' => 'Periode Sampai',
                        'index' => 'periodesampai',
                    ],
                    [
                        'label' => 'Customer',
                        'index' => 'agen_id',
                    ],
                    [
                        'label' => 'Container',
                        'index' => 'containerheader_id',
                    ],

                ];
                // dd($pengeluarantrucking);
                //LOOPING HEADER        
                foreach ($header_columns as $header_column) {
                    $sheet->setCellValue('B' . $header_start_row, $header_column['label']);
                    if ($header_column['index'] == 'tglbukti') {
                        $pengeluarantrucking[$header_column['index']] = date('d-m-Y', strtotime($pengeluarantrucking[$header_column['index']]));
                    }
                    $sheet->setCellValue('C' . $header_start_row++, ': ' . $pengeluarantrucking[$header_column['index']]);
                }
                foreach ($header_right_columns as $header_right_column) {
                    $sheet->setCellValue('D' . $header_right_start_row, $header_right_column['label']);
                    if ($header_right_column['index'] == 'periodedari' || $header_right_column['index'] == 'periodesampai') {
                        $pengeluarantrucking[$header_right_column['index']] = date('d-m-Y', strtotime($pengeluarantrucking[$header_right_column['index']]));
                    }
                    $sheet->setCellValue('E' . $header_right_start_row++, ': ' . $pengeluarantrucking[$header_right_column['index']]);
                }

                $detail_columns = [
                    [
                        'label' => 'NO',
                    ],
                    [
                        'label' => 'NO BUKTI INVOICE',
                        'index' => 'invoice_nobukti',
                    ],
                    [
                        'label' => 'NO ORDERAN TRUCKING',
                        'index' => 'orderantrucking_nobukti',
                    ],
                    [
                        'label' => 'KETERANGAN',
                        'index' => 'keterangan',
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
                // $sheet->getStyle("A$detail_table_header_row:G$detail_table_header_row")->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('FF1F456E');
                $sheet->getStyle("A$detail_table_header_row:E$detail_table_header_row")->applyFromArray($styleArray);

                // LOOPING DETAIL
                $nominal = 0;
                foreach ($pengeluarantrucking_details as $response_index => $response_detail) {

                    foreach ($detail_columns as $detail_columns_index => $detail_column) {
                        $sheet->setCellValue($alphabets[$detail_columns_index] . $detail_start_row, isset($detail_column['index']) ? $response_detail[$detail_column['index']] : $response_index + 1);
                        $sheet->getStyle("A$detail_table_header_row:E$detail_table_header_row")->getFont()->setBold(true);
                        $sheet->getStyle("A$detail_table_header_row:E$detail_table_header_row")->getAlignment()->setHorizontal('center');
                    }

                    $sheet->setCellValue("A$detail_start_row", $response_index + 1);
                    $sheet->setCellValue("B$detail_start_row", $response_detail['invoice_nobukti']);
                    $sheet->setCellValue("C$detail_start_row", $response_detail['orderantrucking_nobukti']);
                    $sheet->setCellValue("D$detail_start_row", $response_detail['keterangan']);
                    $sheet->setCellValue("E$detail_start_row", $response_detail['nominal']);

                    // $sheet->getStyle("D$detail_start_row")->getAlignment()->setWrapText(true);
                    $sheet->getColumnDimension('D')->setWidth(50);

                    $sheet->getStyle("A$detail_start_row:D$detail_start_row")->applyFromArray($styleArray);
                    $sheet->getStyle("E$detail_start_row")->applyFromArray($style_number)->getNumberFormat()->setFormatCode("#,##0.00_);(#,##0.00)");
                    $detail_start_row++;
                }

                $total_start_row = $detail_start_row;
                $sheet->mergeCells('A' . $total_start_row . ':D' . $total_start_row);
                $sheet->setCellValue("A$total_start_row", 'Total')->getStyle('A' . $total_start_row . ':D' . $total_start_row)->applyFromArray($styleArray)->getFont()->setBold(true);
                $totalKredit = "=SUM(E" . ($detail_table_header_row + 1) . ":E" . ($detail_start_row - 1) . ")";
                $sheet->setCellValue("E$total_start_row", $totalKredit)->getStyle("E$total_start_row")->applyFromArray($style_number)->getNumberFormat()->setFormatCode("#,##0.00_);(#,##0.00)");
                $sheet->getStyle("E$total_start_row")->getFont()->setBold(true);

                $sheet->getColumnDimension('A')->setAutoSize(true);
                $sheet->getColumnDimension('B')->setAutoSize(true);
                $sheet->getColumnDimension('C')->setAutoSize(true);
                $sheet->getColumnDimension('E')->setAutoSize(true);
                $writer = new Xlsx($spreadsheet);
                $filename = 'Laporan Pengeluaran Trucking ('.$pengeluarantrucking['kodepengeluaran'].')' . date('dmYHis');
                header('Content-Type: application/vnd.ms-excel');
                header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
                header('Cache-Control: max-age=0');
                $writer->save('php://output');
                break;
            default:

                $spreadsheet = new Spreadsheet();
                $sheet = $spreadsheet->getActiveSheet();
                $sheet->setCellValue('A1', $pengeluarantrucking['judul']);
                $sheet->setCellValue('A2', $pengeluarantrucking['judulLaporan']);
                $sheet->getStyle("A1")->getFont()->setSize(12);
                $sheet->getStyle("A2")->getFont()->setSize(12);
                $sheet->getStyle("A1")->getFont()->setBold(true);
                $sheet->getStyle("A2")->getFont()->setBold(true);
                $sheet->getStyle('A1')->getAlignment()->setHorizontal('center');
                $sheet->getStyle('A2')->getAlignment()->setHorizontal('center');
                $sheet->mergeCells('A1:G1');
                $sheet->mergeCells('A2:G2');

                $header_start_row = 4;
                $header_right_start_row = 4;
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
                        'label' => 'No Bukti Pengeluaran',
                        'index' => 'pengeluaran_nobukti',
                    ],
                ];

                $header_right_columns = [
                    [
                        'label' => 'Pengeluaran Trucking',
                        'index' => 'pengeluarantrucking_id',
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

                $detail_columns = [
                    [
                        'label' => 'NO',
                    ],
                    [
                        'label' => 'SUPIR',
                        'index' => 'supir_id',
                    ],
                    [
                        'label' => 'NOMINAL',
                        'index' => 'nominal',
                        'format' => 'currency'
                    ],
                    [
                        'label' => 'TANDA TANGAN',
                    ],
                ];

                //LOOPING HEADER        
                foreach ($header_columns as $header_column) {
                    $sheet->setCellValue('B' . $header_start_row, $header_column['label']);
                    if ($header_column['index'] == 'tglbukti') {
                        $pengeluarantrucking[$header_column['index']] = date('d-m-Y', strtotime($pengeluarantrucking[$header_column['index']]));
                    }
                    $sheet->setCellValue('C' . $header_start_row++, ': ' . $pengeluarantrucking[$header_column['index']]);
                }
                foreach ($header_right_columns as $header_right_column) {
                    $sheet->setCellValue('D' . $header_right_start_row, $header_right_column['label']);
                    $sheet->setCellValue('E' . $header_right_start_row++, ': ' . $pengeluarantrucking[$header_right_column['index']]);
                }
                foreach ($detail_columns as $detail_columns_index => $detail_column) {
                    $sheet->setCellValue($alphabets[$detail_columns_index] . $detail_table_header_row, $detail_column['label'] ?? $detail_columns_index + 1);
                }


                // $sheet->getStyle("A$detail_table_header_row:G$detail_table_header_row")->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('FF1F456E');
                $sheet->getStyle("A$detail_table_header_row:D$detail_table_header_row")->applyFromArray($styleArray);

                // LOOPING DETAIL
                $nominal = 0;
                foreach ($pengeluarantrucking_details as $response_index => $response_detail) {

                    foreach ($detail_columns as $detail_columns_index => $detail_column) {
                        $sheet->setCellValue($alphabets[$detail_columns_index] . $detail_start_row, isset($detail_column['index']) ? $response_detail[$detail_column['index']] : $response_index + 1);
                        $sheet->getStyle("A$detail_table_header_row:D$detail_table_header_row")->getFont()->setBold(true);
                        $sheet->getStyle("A$detail_table_header_row:D$detail_table_header_row")->getAlignment()->setHorizontal('center');
                    }

                    $sheet->setCellValue("A$detail_start_row", $response_index + 1);
                    $sheet->setCellValue("B$detail_start_row", $response_detail['supir_id']);
                    $sheet->setCellValue("C$detail_start_row", $response_detail['nominal']);
                    $sheet->setCellValue("D$detail_start_row", $response_index + 1);

                    if (($response_index + 1) % 2 == 0) {
                        $sheet->getStyle("D$detail_start_row")->getAlignment()->setHorizontal('center');
                    } else {
                        $sheet->getStyle("D$detail_start_row")->getAlignment()->setHorizontal('left');
                    }
                    // $sheet->getStyle("F$detail_start_row")->getAlignment()->setWrapText(true);
                    // $sheet->getColumnDimension('F')->setWidth(50);

                    $sheet->getStyle("A$detail_start_row:D$detail_start_row")->applyFromArray($styleArray);
                    $sheet->getStyle("C$detail_start_row")->applyFromArray($style_number)->getNumberFormat()->setFormatCode("#,##0.00_);(#,##0.00)");
                    $detail_start_row++;
                }

                $total_start_row = $detail_start_row;
                $sheet->mergeCells('A' . $total_start_row . ':B' . $total_start_row);
                $totalKredit = "=SUM(C" . ($detail_table_header_row + 1) . ":C" . ($detail_start_row - 1) . ")";
                $sheet->setCellValue("A$total_start_row", 'Total')->getStyle('A' . $total_start_row . ':D' . $total_start_row)->applyFromArray($styleArray)->getFont()->setBold(true);
                $sheet->setCellValue("C$total_start_row", $totalKredit)->getStyle("C$detail_start_row")->getNumberFormat()->setFormatCode("#,##0.00_);(#,##0.00)");
                $sheet->getStyle("C$total_start_row")->applyFromArray($style_number)->getFont()->setBold(true);

                $sheet->getColumnDimension('A')->setAutoSize(true);
                $sheet->getColumnDimension('B')->setAutoSize(true);
                $sheet->getColumnDimension('C')->setAutoSize(true);
                $sheet->getColumnDimension('D')->setAutoSize(true);
                $writer = new Xlsx($spreadsheet);
                $filename = 'Laporan Pengeluaran Trucking (' . $pengeluarantrucking['kodepengeluaran'] . ')' . date('dmYHis');
                header('Content-Type: application/vnd.ms-excel');
                header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
                header('Cache-Control: max-age=0');
                $writer->save('php://output');
                break;
        }
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\View\View;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;


class PenerimaanHeaderController extends MyController
{
    public $title = 'Penerimaan Kas/Bank';

    /**
     * @ClassName
     */
    public function index(Request $request)
    {
        $title = $this->title;

        $data = [
            'comboapproval' => $this->comboList('list', 'STATUS APPROVAL', 'STATUS APPROVAL'),
            'combokas' => $this->comboList('list', 'STATUS KAS', 'STATUS KAS'),
            'combocetak' => $this->comboList('list', 'STATUSCETAK', 'STATUSCETAK'),
            'combokirimberkas' => $this->comboList('list', 'STATUSKIRIMBERKAS', 'STATUSKIRIMBERKAS'),
            'combobank' => $this->comboBank(),
            'listbtn' => $this->getListBtn()
        ];

        $data = array_merge(
            compact('title', 'data'),
            ["request" => $request->all()]
        );
        return view('penerimaan.index', $data);
    }

    // /**
    //  * Fungsi get
    //  * @ClassName get
    //  */
    public function get($params = [])
    {
        $params = [
            'offset' => $params['offset'] ?? request()->offset ?? ((request()->page - 1) * request()->rows),
            'limit' => $params['rows'] ?? request()->rows ?? 0,
            'sortIndex' => $params['sidx'] ?? request()->sidx,
            'sortOrder' => $params['sord'] ?? request()->sord,
            'search' => json_decode($params['filters'] ?? request()->filters, 1) ?? [],
        ];

        $response = Http::withHeaders(request()->header())
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'penerimaanheader', $params);

        $data = [
            'total' => $response['attributes']['totalPages'] ?? [],
            'records' => $response['attributes']['totalRows'] ?? [],
            'rows' => $response['data'] ?? [],
            'params' => $params ?? [],
            'message' => $response['message'] ?? ''
        ];

        if (request()->ajax()) {
            return response($data, $response->status());
        }

        return $data;
    }


    public function fieldLength(): Response
    {
        $response = Http::withHeaders($this->httpHeaders)
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'penerimaanheader/field_length');

        return response($response['data']);
    }

    // /**
    //  * Fungsi getNoBukti
    //  * @ClassName getNoBukti
    //  */
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

    public function comboBank()
    {
        $detailParams = [
            'aktif' => 'AKTIF',
            'format' => 'penerimaan',
            'limit' => 0
        ];
        $response = Http::withHeaders($this->httpHeaders)
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'bank', $detailParams);

        return $response['data'];
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
        $penerimaan = Http::withHeaders($request->header())
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'penerimaanheader/' . $id . '/export')['data'];

        //FETCH DETAIL
        $detailParams = [
            'forReport' => true,
            'penerimaan_id' => $request->id
        ];
        $penerimaan_details = Http::withHeaders($request->header())
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'penerimaandetail', $detailParams)['data'];

        $combo = $this->combo('list');
        $key = array_search('CETAK', array_column($combo, 'parameter'));
        $penerimaan["combo"] =  $combo[$key];
        $printer['tipe'] = $request->printer;
        $cabang['cabang'] = session('cabang');
        if ($penerimaan['tipe_bank'] === 'KAS') {
            return view('reports.penerimaankas', compact('penerimaan', 'penerimaan_details', 'printer', 'cabang'));
        } else {
            return view('reports.penerimaanbank', compact('penerimaan', 'penerimaan_details', 'printer', 'cabang'));
        }
    }

    public function export(Request $request): void
    {
        //FETCH HEADER
        $id = $request->id;
        $penerimaan = Http::withHeaders($request->header())
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'penerimaanheader/' . $id . '/export')['data'];

        //FETCH DETAIL
        $detailParams = [
            'forReport' => true,
            'penerimaan_id' => $request->id,
        ];
        $penerimaan_details = Http::withHeaders($request->header())
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'penerimaandetail', $detailParams)['data'];

        $tglBukti = $penerimaan["tglbukti"];
        $timeStamp = strtotime($tglBukti);
        $dateTglBukti = date('d-m-Y', $timeStamp);
        $penerimaan['tglbukti'] = $dateTglBukti;

        $tglLunas = $penerimaan["tgllunas"];
        $timeStamp = strtotime($tglLunas);
        $datetglLunas = date('d-m-Y', $timeStamp);
        $penerimaan['tgllunas'] = $datetglLunas;

        if ($penerimaan['tipe_bank'] === 'KAS') {
            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();
            $sheet->setCellValue('A1', $penerimaan['judul']);
            $sheet->setCellValue('A2', 'Laporan Penerimaan ' . $penerimaan['bank_id']);
            $sheet->getStyle("A1")->getFont()->setSize(12);
            $sheet->getStyle("A2")->getFont()->setSize(12);
            $sheet->getStyle("A1")->getFont()->setBold(true);
            $sheet->getStyle("A2")->getFont()->setBold(true);
            $sheet->getStyle('A1')->getAlignment()->setHorizontal('center');
            $sheet->getStyle('A2')->getAlignment()->setHorizontal('center');
            $sheet->mergeCells('A1:D1');
            $sheet->mergeCells('A2:D2');

            $header_start_row = 4;
            $header_start_row_right = 4;
            $detail_table_header_row = 9;
            $detail_start_row = $detail_table_header_row + 1;

            $alphabets = range('A', 'Z');

            $header_columns = [
                [
                    'label' => 'No Bukti',
                    'index' => 'nobukti',
                ],
                [
                    'label' => 'Kas',
                    'index' => 'bank_id',
                ]
            ];
            $header_right_columns = [
                [
                    'label' => 'Diterima Dari',
                    'index' => 'diterimadari',
                ],
                [
                    'label' => 'Tanggal',
                    'index' => 'tglbukti',
                ],
            ];

            $detail_columns = [
                [
                    'label' => 'NO',
                ],
                [
                    'label' => 'NAMA PERKIRAAN',
                    'index' => 'coadebet'
                ],
                [
                    'label' => 'KETERANGAN',
                    'index' => 'keterangan_detail'
                ],
                [
                    'label' => 'NOMINAL',
                    'index' => 'nominal',
                    'format' => 'currency'
                ]
            ];

            //LOOPING HEADER        
            foreach ($header_columns as $header_column) {
                $sheet->setCellValue('B' . $header_start_row, $header_column['label']);
                $sheet->setCellValue('C' . $header_start_row++, ': ' . $penerimaan[$header_column['index']]);
            }
            foreach ($header_right_columns as $header_right_column) {
                $sheet->setCellValue('D' . $header_start_row_right, $header_right_column['label']);
                $sheet->setCellValue('E' . $header_start_row_right++, ': ' . $penerimaan[$header_right_column['index']]);
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
                    'top' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
                    'right' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
                    'bottom' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
                    'left' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN]
                ]
            ];

            // $sheet->getStyle("A$detail_table_header_row:G$detail_table_header_row")->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('FF1F456E');
            $sheet->getStyle("A$detail_table_header_row:D$detail_table_header_row")->applyFromArray($styleArray);

            // LOOPING DETAIL
            $nominal = 0;
            foreach ($penerimaan_details as $response_index => $response_detail) {

                foreach ($detail_columns as $detail_columns_index => $detail_column) {
                    $sheet->setCellValue($alphabets[$detail_columns_index] . $detail_start_row, isset($detail_column['index']) ? $response_detail[$detail_column['index']] : 0);
                    $sheet->getStyle("A$detail_table_header_row:D$detail_table_header_row")->getFont()->setBold(true);
                    $sheet->getStyle("A$detail_table_header_row:D$detail_table_header_row")->getAlignment()->setHorizontal('center');
                }

                $sheet->setCellValue("A$detail_start_row", $response_index + 1);
                $sheet->setCellValue("B$detail_start_row", $response_detail['coadebet']);
                $sheet->setCellValue("C$detail_start_row", $response_detail['keterangan_detail']);
                $sheet->setCellValue("D$detail_start_row", $response_detail['nominal']);

                // $sheet->getStyle("C$detail_start_row")->getAlignment()->setWrapText(true);
                $sheet->getColumnDimension('C')->setWidth(50);

                $sheet->getStyle("A$detail_start_row:D$detail_start_row")->applyFromArray($styleArray);
                $sheet->getStyle("D$detail_start_row")->applyFromArray($style_number)->getNumberFormat()->setFormatCode("#,##0.00_);(#,##0.00)");

                $detail_start_row++;
            }

            $total_start_row = $detail_start_row;
            $sheet->mergeCells('A' . $total_start_row . ':C' . $total_start_row);
            $sheet->setCellValue("A$total_start_row", 'Total')->getStyle('A' . $total_start_row . ':C' . $total_start_row)->applyFromArray($styleArray)->getFont()->setBold(true);
            $sheet->setCellValue("D$total_start_row", "=SUM(D10:D" . ($detail_start_row - 1) . ")")->getStyle("D$detail_start_row")->applyFromArray($style_number)->getFont()->setBold(true);

            $sheet->getStyle("D$detail_start_row")->getNumberFormat()->setFormatCode("#,##0.00_);(#,##0.00)");
            $sheet->getColumnDimension('A')->setAutoSize(true);
            $sheet->getColumnDimension('B')->setAutoSize(true);
            $sheet->getColumnDimension('D')->setAutoSize(true);
            $sheet->getColumnDimension('E')->setAutoSize(true);

            $writer = new Xlsx($spreadsheet);
            $filename = 'Laporan Penerimaan ' . $penerimaan['bank_id'] . date('dmYHis');
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
            header('Cache-Control: max-age=0');

            $writer->save('php://output');
        } else {
            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();
            $sheet->setCellValue('A1', $penerimaan['judul']);
            $sheet->setCellValue('A2', 'Laporan Penerimaan ' . $penerimaan['bank_id']);
            $sheet->getStyle("A1")->getFont()->setSize(12);
            $sheet->getStyle("A2")->getFont()->setSize(12);
            $sheet->getStyle("A1")->getFont()->setBold(true);
            $sheet->getStyle("A2")->getFont()->setBold(true);
            $sheet->getStyle('A1')->getAlignment()->setHorizontal('center');
            $sheet->getStyle('A2')->getAlignment()->setHorizontal('center');
            $sheet->mergeCells('A1:F1');
            $sheet->mergeCells('A2:F2');

            $header_start_row = 4;
            $header_start_row_right = 4;
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
                    'label' => 'Bank',
                    'index' => 'bank_id',
                ]
            ];
            $header_columns_right = [
                [
                    'label' => 'Diterima Dari',
                    'index' => 'diterimadari',
                ],
            ];

            $detail_columns = [
                [
                    'label' => 'NO',
                ],
                [
                    'label' => 'NAMA PERKIRAAN',
                    'index' => 'coadebet'
                ],
                [
                    'label' => 'BANK',
                    'index' => 'bank_detail'
                ],
                [
                    'label' => 'INVOICE',
                    'index' => 'invoice_nobukti'
                ],
                [
                    'label' => 'KETERANGAN',
                    'index' => 'keterangan_detail'
                ],
                [
                    'label' => 'NOMINAL',
                    'index' => 'nominal',
                    'format' => 'currency'
                ]
            ];

            //LOOPING HEADER        
            foreach ($header_columns as $header_column) {
                $sheet->setCellValue('B' . $header_start_row, $header_column['label']);
                $sheet->setCellValue('C' . $header_start_row++, ': ' . $penerimaan[$header_column['index']]);
            }
            foreach ($header_columns_right as $header_column_right) {
                $sheet->setCellValue('D' . $header_start_row_right, $header_column_right['label']);
                $sheet->setCellValue('E' . $header_start_row_right++, ': ' . $penerimaan[$header_column_right['index']]);
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
                    'top' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
                    'right' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
                    'bottom' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
                    'left' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN]
                ]
            ];

            // $sheet->getStyle("A$detail_table_header_row:G$detail_table_header_row")->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('FF1F456E');
            $sheet->getStyle("A$detail_table_header_row:F$detail_table_header_row")->applyFromArray($styleArray);

            // LOOPING DETAIL
            $nominal = 0;
            foreach ($penerimaan_details as $response_index => $response_detail) {

                foreach ($detail_columns as $detail_columns_index => $detail_column) {
                    $sheet->setCellValue($alphabets[$detail_columns_index] . $detail_start_row, isset($detail_column['index']) ? $response_detail[$detail_column['index']] : 0);
                    $sheet->getStyle("A$detail_table_header_row:G$detail_table_header_row")->getFont()->setBold(true);
                    $sheet->getStyle("A$detail_table_header_row:G$detail_table_header_row")->getAlignment()->setHorizontal('center');
                }

                $sheet->setCellValue("A$detail_start_row", $response_index + 1);
                $sheet->setCellValue("B$detail_start_row", $response_detail['coadebet']);
                $sheet->setCellValue("C$detail_start_row", $response_detail['bank_detail']);
                $sheet->setCellValue("D$detail_start_row", $response_detail['invoice_nobukti']);
                $sheet->setCellValue("E$detail_start_row", $response_detail['keterangan_detail']);
                $sheet->setCellValue("F$detail_start_row", $response_detail['nominal']);

                // $sheet->getStyle("E$detail_start_row")->getAlignment()->setWrapText(true);
                $sheet->getColumnDimension('E')->setWidth(50);

                $sheet->getStyle("A$detail_start_row:F$detail_start_row")->applyFromArray($styleArray);
                $sheet->getStyle("F$detail_start_row")->applyFromArray($style_number)->getNumberFormat()->setFormatCode("#,##0.00_);(#,##0.00)");
                $detail_start_row++;
            }
            $total_start_row = $detail_start_row;
            $sheet->mergeCells('A' . $total_start_row . ':E' . $total_start_row);
            $sheet->setCellValue("A$total_start_row", 'Total')->getStyle('A' . $total_start_row . ':E' . $total_start_row)->applyFromArray($styleArray)->getFont()->setBold(true);
            $sheet->setCellValue("F$total_start_row", "=SUM(F9:F" . ($detail_start_row - 1) . ")")->getStyle("F$detail_start_row")->applyFromArray($style_number)->getFont()->setBold(true);
            $sheet->getStyle("F$total_start_row")->applyFromArray($style_number)->getNumberFormat()->setFormatCode("#,##0.00_);(#,##0.00)");
            $sheet->getColumnDimension('A')->setAutoSize(true);
            $sheet->getColumnDimension('B')->setAutoSize(true);
            $sheet->getColumnDimension('C')->setAutoSize(true);
            $sheet->getColumnDimension('D')->setAutoSize(true);
            $sheet->getColumnDimension('F')->setAutoSize(true);

            $writer = new Xlsx($spreadsheet);
            $filename = 'Laporan Penerimaan Bank ' . $penerimaan['bank_id'] . date('dmYHis');
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
            header('Cache-Control: max-age=0');

            $writer->save('php://output');
        }
    }
}

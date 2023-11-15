<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\View\View;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;


class ProsesUangJalanSupirHeaderController extends MyController
{
    public $title = 'Proses Uang Jalan Supir';

    /**
     * @ClassName
     */
    public function index(Request $request)
    {
        $title = $this->title;
        $data = [
            'combocetak' => $this->comboCetak('list', 'STATUSCETAK', 'STATUSCETAK'),
            'comboapproval' => $this->comboList('list', 'STATUS APPROVAL', 'STATUS APPROVAL'),
        ];
        return view('prosesuangjalansupir.index', compact('title', 'data'));
    }

    public function comboCetak($aksi, $grp, $subgrp)
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
            ->get(config('app.api_url') . 'prosesuangjalansupirheader', $params);

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
        $uangjalansupir = Http::withHeaders($request->header())
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'prosesuangjalansupirheader/' . $id . '/export')['data'];

        //FETCH DETAIL
        $detailParams = [
            'forReport' => true,
            'prosesuangjalansupir_id' => $request->id
        ];
        $uangjalansupir_detail = Http::withHeaders(request()->header())
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'prosesuangjalansupirdetail', $detailParams)['data'];

        $combo = $this->combo('list');
        $key = array_search('CETAK', array_column($combo, 'parameter'));
        $uangjalansupir["combo"] =  $combo[$key];
        return view('reports.prosesuangjalansupir', compact('uangjalansupir', 'uangjalansupir_detail'));
    }

    public function export(Request $request): void
    {
        //FETCH HEADER
        $id = $request->id;
        $uangjalansupir = Http::withHeaders($request->header())
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'prosesuangjalansupirheader/' . $id . '/export')['data'];

        //FETCH DETAIL
        $detailParams = [
            'forExport' => true,
            'prosesuangjalansupir_id' => $request->id
        ];
        $uangjalansupir_detail = Http::withHeaders(request()->header())
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'prosesuangjalansupirdetail', $detailParams)['data'];

        $tglBukti = $uangjalansupir["tglbukti"];
        $timeStamp = strtotime($tglBukti);
        $dateTglBukti = date('d-m-Y', $timeStamp);
        $uangjalansupir['tglbukti'] = $dateTglBukti;

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', $uangjalansupir['judul']);
        $sheet->setCellValue('A2', $uangjalansupir['judulLaporan']);
        $sheet->getStyle("A1")->getFont()->setSize(12);
        $sheet->getStyle("A2")->getFont()->setSize(12);
        $sheet->getStyle("A1")->getFont()->setBold(true);
        $sheet->getStyle("A2")->getFont()->setBold(true);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal('center');
        $sheet->getStyle('A2')->getAlignment()->setHorizontal('center');
        $sheet->mergeCells('A1:N1');
        $sheet->mergeCells('A2:N2');

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
                'label' => 'Tanggal Bukti',
                'index' => 'tglbukti',
            ],
            [
                'label' => 'No Bukti Absensi Supir',
                'index' => 'absensisupir_nobukti',
            ],
        ];
        $header_right_columns = [
            [
                'label' => 'Trado',
                'index' => 'trado_id',
            ],
            [
                'label' => 'Supir',
                'index' => 'supir_id',
            ]
        ];

        $detail_columns = [
            [
                'label' => 'NO',
            ],
            [
                'label' => 'NO BUKTI',
                'index' => 'nobukti',
            ],
            [
                'label' => 'NO BUKTI PENERIMAAN',
                'index' => 'penerimaantrucking_nobukti',
            ],
            [
                'label' => 'TANGGAL PENERIMAAN',
                'index' => 'penerimaantrucking_tglbukti',
            ],
            [
                'label' => 'BANK PENERIMAAN',
                'index' => 'penerimaantrucking_bank_id',
            ],
            [
                'label' => 'STATUS PROSES UANG JALAN',
                'index' => 'statusprosesuangjalan',
            ],
            [
                'label' => 'NO BUKTI PENGELUARAN',
                'index' => 'pengeluarantrucking_nobukti',
            ],
            [
                'label' => 'TANGGAL PENGELUARAN',
                'index' => 'pengeluarantrucking_tglbukti',
            ],
            [
                'label' => 'BANK PENGELUARAN',
                'index' => 'pengeluarantrucking_bank_id',
            ],
            [
                'label' => 'KETERANGAN',
                'index' => 'keterangan',
            ],
            [
                'label' => 'NO BUKTI PENGEMBALIAN KAS GANTUNG',
                'index' => 'pengembaliankasgantung_nobukti',

            ],
            [
                'label' => 'TANGGAL PENGEMBALIAN KAS GANTUNG',
                'index' => 'pengembaliankasgantung_tglbukti',

            ],
            [
                'label' => 'BANK PENGEMBALIAN KAS GANTUNG',
                'index' => 'pengembaliankasgantung_bank_id',
            ],
            [
                'label' => 'NOMINAL',
                'index' => 'nominal',

            ]
        ];

        //LOOPING HEADER
        foreach ($header_columns as $header_column) {
            $sheet->setCellValue('B' . $header_start_row, $header_column['label']);
            $sheet->setCellValue('C' . $header_start_row++, ': ' . $uangjalansupir[$header_column['index']]);
        }
        foreach ($header_right_columns as $header_right_column) {
            $sheet->setCellValue('D' . $header_right_start_row, $header_right_column['label']);
            $sheet->setCellValue('E' . $header_right_start_row++, ': ' . $uangjalansupir[$header_right_column['index']]);
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

        $sheet->getStyle("A$detail_table_header_row:N$detail_table_header_row")->applyFromArray($styleArray);

        // LOOPING DETAIL
        $nominal = 0;
        foreach ($uangjalansupir_detail as $response_index => $response_detail) {

            foreach ($detail_columns as $detail_columns_index => $detail_column) {
                $sheet->setCellValue($alphabets[$detail_columns_index] . $detail_start_row, isset($detail_column['index']) ? $response_detail[$detail_column['index']] : $response_index + 1);
                $sheet->getStyle("A$detail_table_header_row:N$detail_table_header_row")->getFont()->setBold(true);
                $sheet->getStyle("A$detail_table_header_row:N$detail_table_header_row")->getAlignment()->setHorizontal('center');
            }

            $penerimaantrucking_tglbukti = ($response_detail['penerimaantrucking_tglbukti'] != null) ? Date::PHPToExcel(date('Y-m-d', strtotime($response_detail['penerimaantrucking_tglbukti']))) : '';
            $pengeluarantrucking_tglbukti = ($response_detail['pengeluarantrucking_tglbukti'] != null) ? Date::PHPToExcel(date('Y-m-d', strtotime($response_detail['pengeluarantrucking_tglbukti']))) : '';
            $pengembaliankasgantung_tglbukti = ($response_detail['pengembaliankasgantung_tglbukti'] != null) ? Date::PHPToExcel(date('Y-m-d', strtotime($response_detail['pengembaliankasgantung_tglbukti']))) : '';

            $sheet->setCellValue("A$detail_start_row", $response_index + 1);
            $sheet->setCellValue("B$detail_start_row", $response_detail['nobukti']);
            $sheet->setCellValue("C$detail_start_row", $response_detail['penerimaantrucking_nobukti']);
            $sheet->setCellValue("D$detail_start_row", $penerimaantrucking_tglbukti);
            $sheet->setCellValue("E$detail_start_row", $response_detail['penerimaantrucking_bank_id']);
            $sheet->setCellValue("F$detail_start_row", $response_detail['statusprosesuangjalan']);
            $sheet->setCellValue("G$detail_start_row", $response_detail['pengeluarantrucking_nobukti']);
            $sheet->setCellValue("H$detail_start_row", $pengeluarantrucking_tglbukti);
            $sheet->setCellValue("I$detail_start_row", $response_detail['pengeluarantrucking_bank_id']);
            $sheet->setCellValue("J$detail_start_row", $response_detail['keterangan']);
            $sheet->setCellValue("K$detail_start_row", $response_detail['pengembaliankasgantung_nobukti']);
            $sheet->setCellValue("L$detail_start_row", $pengembaliankasgantung_tglbukti);
            $sheet->setCellValue("M$detail_start_row", $response_detail['pengembaliankasgantung_bank_id']);
            $sheet->setCellValue("N$detail_start_row", $response_detail['nominal']);

            $sheet->getStyle("J$detail_start_row")->getAlignment()->setWrapText(true);
            $sheet->getColumnDimension('J')->setWidth(50);

            $sheet->getStyle("A$detail_start_row:M$detail_start_row")->applyFromArray($styleArray);
            $sheet->getStyle("N$detail_start_row")->applyFromArray($style_number);
            $sheet->getStyle("N$detail_start_row")->getNumberFormat()->setFormatCode("#,##0.00_);(#,##0.00)");

            $sheet->getStyle("D$detail_start_row")->getNumberFormat()->setFormatCode('dd-mm-yyyy');
            $sheet->getStyle("H$detail_start_row")->getNumberFormat()->setFormatCode('dd-mm-yyyy');
            $sheet->getStyle("L$detail_start_row")->getNumberFormat()->setFormatCode('dd-mm-yyyy');
            $detail_start_row++;
        }

        $total_start_row = $detail_start_row;
        $sheet->mergeCells('A' . $total_start_row . ':M' . $total_start_row);
        $sheet->setCellValue("A$total_start_row", 'Total')->getStyle('A' . $total_start_row . ':M' . $total_start_row)->applyFromArray($style_number)->getFont()->setBold(true);
        $total = "=SUM(N".($detail_table_header_row + 1).":N" . ($detail_start_row - 1) . ")";
        $sheet->setCellValue("N$total_start_row", $total)->getStyle("N$detail_start_row")->applyFromArray($style_number)->getFont()->setBold(true);
        $sheet->getStyle("N$detail_start_row")->getNumberFormat()->setFormatCode("#,##0.00_);(#,##0.00)");

        $sheet->getColumnDimension('A')->setAutoSize(true);
        $sheet->getColumnDimension('B')->setAutoSize(true);
        $sheet->getColumnDimension('C')->setAutoSize(true);
        $sheet->getColumnDimension('D')->setAutoSize(true);
        $sheet->getColumnDimension('E')->setAutoSize(true);
        $sheet->getColumnDimension('F')->setAutoSize(true);
        $sheet->getColumnDimension('G')->setAutoSize(true);
        $sheet->getColumnDimension('H')->setAutoSize(true);
        $sheet->getColumnDimension('I')->setAutoSize(true);
        $sheet->getColumnDimension('K')->setAutoSize(true);
        $sheet->getColumnDimension('L')->setAutoSize(true);
        $sheet->getColumnDimension('M')->setAutoSize(true);
        $sheet->getColumnDimension('N')->setAutoSize(true);

        $writer = new Xlsx($spreadsheet);
        $filename = 'Laporan Proses Uang Jalan Supir' . date('dmYHis');
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }
}

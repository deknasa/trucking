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
            'listbtn' => $this->getListBtn()
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
        $printer['tipe'] = $request->printer;
        return view('reports.prosesuangjalansupir', compact('uangjalansupir', 'uangjalansupir_detail', 'printer'));
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
            'forReport' => true,
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
        $sheet->mergeCells('A1:F1');
        $sheet->mergeCells('A2:F2');

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
                'label' => 'Supir',
                'index' => 'supir_id',
            ],
            [
                'label' => 'Trado',
                'index' => 'trado_id',
            ],
            [
                'label' => 'Uang Jalan',
                'index' => 'nominaluangjalan',
            ]
        ];

        $detail_columns = [
            [
                'label' => 'NO',
            ],
            [
                'label' => 'NO BUKTI PENERIMAAN/PENGELUARAN KAS/BANK',
                'index' => 'nobukti',
            ],
            [
                'label' => 'BANK',
                'index' => 'bank',
            ],
            [
                'label' => 'STATUS PROSES',
                'index' => 'statusproses',
            ],
            [
                'label' => 'KETERANGAN',
                'index' => 'keterangan',
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
            if ($header_right_column['index'] == 'nominaluangjalan') {
                $sheet->setCellValue('E' . $header_right_start_row++, ': ' . number_format($uangjalansupir[$header_right_column['index']], 2, ".", ","));
            } else {
                $sheet->setCellValue('E' . $header_right_start_row++, ': ' . $uangjalansupir[$header_right_column['index']]);
            }
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

        $sheet->getStyle("A$detail_table_header_row:F$detail_table_header_row")->applyFromArray($styleArray);

        // LOOPING DETAIL
        $nominal = 0;
        foreach ($uangjalansupir_detail as $response_index => $response_detail) {


            $sheet->setCellValue("A$detail_start_row", $response_index + 1);
            $sheet->setCellValue("B$detail_start_row", $response_detail['nobukti_proses']);
            $sheet->setCellValue("C$detail_start_row", $response_detail['bank']);
            $sheet->setCellValue("D$detail_start_row", $response_detail['statusproses']);
            $sheet->setCellValue("E$detail_start_row", $response_detail['keterangan']);
            $sheet->setCellValue("F$detail_start_row", $response_detail['nominal']);
            $sheet->getColumnDimension('E')->setWidth(30);

            $sheet->getStyle("A$detail_start_row:E$detail_start_row")->applyFromArray($styleArray);
            $sheet->getStyle("F$detail_start_row")->applyFromArray($style_number);
            $sheet->getStyle("F$detail_start_row")->getNumberFormat()->setFormatCode("#,##0.00_);(#,##0.00)");
            $detail_start_row++;
        }


        $sheet->getColumnDimension('A')->setAutoSize(true);
        $sheet->getColumnDimension('B')->setAutoSize(true);
        $sheet->getColumnDimension('C')->setAutoSize(true);
        $sheet->getColumnDimension('D')->setAutoSize(true);
        $sheet->getColumnDimension('F')->setAutoSize(true);

        $writer = new Xlsx($spreadsheet);
        $filename = 'Laporan Proses Uang Jalan Supir' . date('dmYHis');
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }
}

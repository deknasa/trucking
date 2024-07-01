<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use stdClass;

class OrderanTruckingController extends MyController
{
    public $title = 'Orderan Trucking';

    /**
     * @ClassName
     */
    public function index(Request $request)
    {
        $title = $this->title;

        $data = [
            'combolangsir' => $this->combo('list', 'STATUS LANGSIR', 'STATUS LANGSIR'),
            'comboperalihan' => $this->combo('list', 'STATUS PERALIHAN', 'STATUS PERALIHAN'),
            'comboapproval' => $this->comboApproval('list', 'STATUS APPROVAL', 'STATUS APPROVAL'),
            'comboapprovaledit' => $this->comboApproval('list', 'STATUS APPROVAL', 'STATUS APPROVAL'),
            'comboapprovaltanpajob' => $this->comboApproval('list', 'STATUS APPROVAL', 'STATUS APPROVAL'),
            'listbtn' => $this->getListBtn()
        ];

        $data = array_merge(
            compact('title', 'data'),
            ["request" => $request->all()]
        );
        return view('orderantrucking.index', $data);
    }

    /**
     * @ClassName
     */
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
            ->get(config('app.api_url') . 'orderantrucking', $params);

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

    /**
     * @ClassName
     */
    public function create(): View
    {
        $title = $this->title;
        $combo = $this->combo();

        return view('orderantrucking.add', compact('title', 'combo'));
    }


    public function fieldLength(): Response
    {
        $response = Http::withHeaders($this->httpHeaders)
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'orderantrucking/field_length');

        return response($response['data']);
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
    public function comboApproval($aksi, $grp, $subgrp)
    {

        $status = [
            'status' => $aksi,
            'grp' => $grp,
            'subgrp' => $subgrp,
        ];

        $response = Http::withHeaders($this->httpHeaders)
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'hutangbayarheader/comboapproval', $status);

        return $response['data'];
    }


    public function report(Request $request)
    {
        //FETCH HEADER
        $data = Http::withHeaders($request->header())
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'orderantrucking/export?dari=' . $request->dari . '&sampai=' . $request->sampai)['data'];
        $orderantrucking = $data['data'];
        $params = $data['parameter'];

        return view('reports.orderantrucking', compact('orderantrucking', 'params'));
    }

    public function export(Request $request): void
    {
        //FETCH HEADER
        $orderanTrucking = Http::withHeaders($request->header())
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'orderantrucking/export?dari=' . $request->dari . '&sampai=' . $request->sampai)['data'];
        $orderanTruck = $orderanTrucking['data'];

        // $tglDari = $orderanTruck[0]['tgldari'];
        $timeStamp = strtotime($request->dari);
        $datetglDari = date('d-m-Y', $timeStamp);
        $periodeDari = $datetglDari;

        // $tglSampai = $orderanTruck[0]['tglsampai'];
        $timeStamp = strtotime($request->sampai);
        $datetglSampai = date('d-m-Y', $timeStamp);
        $periodeSampai = $datetglSampai;

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', $orderanTrucking['parameter']['judul']);
        $sheet->setCellValue('A2', $orderanTrucking['parameter']['judulLaporan']);
        $sheet->getStyle("A1")->getFont()->setSize(12);
        $sheet->getStyle("A2")->getFont()->setSize(12);
        $sheet->getStyle("A1")->getFont()->setBold(true);
        $sheet->getStyle("A2")->getFont()->setBold(true);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal('center');
        $sheet->getStyle('A2')->getAlignment()->setHorizontal('center');
        $sheet->mergeCells('A1:O1');
        $sheet->mergeCells('A2:O2');

        $header_start_row = 4;
        $detail_table_header_row = 7;
        $detail_start_row = $detail_table_header_row + 1;

        $alphabets = range('A', 'Z');

        $header_columns = [
            [
                'label' => 'Periode Dari',
                'index' => $periodeDari
            ],
            [
                'label' => 'Periode Sampai',
                'index' => $periodeSampai
            ]
        ];
        $columns = [
            [
                'label' => 'NO',
            ],
            [
                'label' => 'NO BUKTI',
                'index' => 'nobukti',
            ],
            [
                'label' => 'TANGGAL',
                'index' => 'tglbukti',
            ],
            [
                'label' => 'CONTAINER',
                'index' => 'container_id',
            ],
            [
                'label' => 'CUSTOMER',
                'index' => 'agen_id',
            ],
            [
                'label' => 'JENIS ORDER',
                'index' => 'jenisorder_id',
            ],
            [
                'label' => 'SHIPPER',
                'index' => 'pelanggan_id',
            ],
            [
                'label' => 'NO JOB EMKL(1)',
                'index' => 'nojobemkl',
            ],
            [
                'label' => 'NO CONT(1)',
                'index' => 'nocont',
            ],
            [
                'label' => 'NO SEAL(1)',
                'index' => 'noseal',
            ],
            [
                'label' => 'NO JOB EMKL(2)',
                'index' => 'nojobemkl2',
            ],
            [
                'label' => 'NO CONT(2)',
                'index' => 'nocont2',
            ],
            [
                'label' => 'NO SEAL(2)',
                'index' => 'noseal2',
            ],
        ];

        //LOOPING HEADER        
        foreach ($header_columns as $header_column) {
            $sheet->setCellValue('B' . $header_start_row, $header_column['label']);
            $sheet->setCellValue('C' . $header_start_row++, ': ' . $header_column['index']);
        }
        foreach ($columns as $detail_columns_index => $detail_column) {
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
        $sheet->getStyle("A$detail_table_header_row:M$detail_table_header_row")->applyFromArray($styleArray);

        $nominal = 0;
        if (is_iterable($orderanTruck)) {

            foreach ($orderanTruck as $response_index => $response_detail) {
                foreach ($columns as $detail_columns_index => $detail_column) {
                    $sheet->setCellValue($alphabets[$detail_columns_index] . $detail_start_row, isset($detail_column['index']) ? $response_detail[$detail_column['index']] : $response_index + 1);
                    $sheet->getStyle("A$detail_table_header_row:M$detail_table_header_row")->getFont()->setBold(true);
                    $sheet->getStyle("A$detail_table_header_row:M$detail_table_header_row")->getAlignment()->setHorizontal('center');
                }
                $response_detail['nominals'] = number_format((float) $response_detail['nominal'], '2', '.', ',');

                $tglbukti = $response_detail["tglbukti"];
                $timeStamp = strtotime($tglbukti);
                $datetglbukti = date('d-m-Y', $timeStamp);
                $response_detail['tglbukti'] = $datetglbukti;

                $sheet->setCellValue("A$detail_start_row", $response_index + 1);
                $sheet->setCellValue("B$detail_start_row", $response_detail['nobukti']);
                $sheet->setCellValue("C$detail_start_row", $response_detail['tglbukti']);
                $sheet->setCellValue("D$detail_start_row", $response_detail['container_id']);
                $sheet->setCellValue("E$detail_start_row", $response_detail['agen_id']);
                $sheet->setCellValue("F$detail_start_row", $response_detail['jenisorder_id']);
                $sheet->setCellValue("G$detail_start_row", $response_detail['pelanggan_id']);
                $sheet->setCellValue("H$detail_start_row", $response_detail['nojobemkl']);
                $sheet->setCellValue("I$detail_start_row", $response_detail['nocont']);
                $sheet->setCellValue("J$detail_start_row", $response_detail['noseal']);
                $sheet->setCellValue("K$detail_start_row", $response_detail['nojobemkl2']);
                $sheet->setCellValue("L$detail_start_row", $response_detail['nocont2']);
                $sheet->setCellValue("M$detail_start_row", $response_detail['noseal2']);

                $sheet->getStyle("A$detail_start_row:M$detail_start_row")->applyFromArray($styleArray);

                $detail_start_row++;
            }
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
        $sheet->getColumnDimension('J')->setAutoSize(true);
        $sheet->getColumnDimension('K')->setAutoSize(true);
        $sheet->getColumnDimension('L')->setAutoSize(true);
        $sheet->getColumnDimension('M')->setAutoSize(true);
        $sheet->getColumnDimension('N')->setAutoSize(true);
        $sheet->getColumnDimension('O')->setAutoSize(true);

        $writer = new Xlsx($spreadsheet);
        $filename = 'Laporan Orderan Trucking' . date('dmYHis');
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }
}

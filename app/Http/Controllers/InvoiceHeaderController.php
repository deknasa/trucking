<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class InvoiceHeaderController extends MyController
{
    public $title = 'Invoice';

    public function index(Request $request)
    {
        $title = $this->title;
        $data = [
            'pagename' => 'Menu Utama Invoice',
            'comboapproval' => $this->comboList('list','STATUS APPROVAL','STATUS APPROVAL'),
            'combocetak' => $this->comboList('list','STATUSCETAK','STATUSCETAK'),
        ];

        return view('invoiceheader.index', compact('title', 'data'));
    }

    public function store(Request $request)
    {
        try {
            $request['modifiedby'] = Auth::user()->name;

            $response = Http::withHeaders($this->httpHeaders)
                ->withOptions(['verify' => false])
                ->withToken(session('access_token'))
                ->post(config('app.api_url') . 'invoiceheader', $request->all());


            return response($response, $response->status());
        } catch (\Throwable $th) {
            throw $th->getMessage();
        }
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
            ->get(config('app.api_url') . 'invoiceheader', $params);

        $data = [
            'total' => $response['attributes']['totalPages'] ?? [],
            'records' => $response['attributes']['totalRows'] ?? [],
            'rows' => $response['data'] ?? [],
            'params' => $response['params'] ?? [],
        ];

        return $data;
    }

    public function update(Request $request, $id)
    {


        $request['modifiedby'] = Auth::user()->name;

        $response = Http::withHeaders($this->httpHeaders)
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->patch(config('app.api_url') . "invoiceheader/$id", $request->all());

        return response($response);
    }



    public function destroy($id)
    {
        $request['modifiedby'] = Auth::user()->name;
        $response = Http::withHeaders($this->httpHeaders)
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->delete(config('app.api_url') . "invoiceheader/$id");


        return response($response);
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
         //FETCH HEADER
         $id = $request->id;
         $invoices = Http::withHeaders($request->header())
             ->withOptions(['verify' => false])
             ->withToken(session('access_token'))
             ->get(config('app.api_url') . 'invoiceheader/'.$id.'/export')['data'];

        $detailParams = [
            'forReport' => true,
            'invoice_id' => $request->id
        ];
        $invoice_detail = Http::withHeaders(request()->header())
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'invoicedetail', $detailParams)['data'];

        return view('reports.invoice', compact('invoice_detail', 'invoices'));
    }

    public function export(Request $request): void
    {
        //FETCH HEADER
        $id = $request->id;
        $invoices = Http::withHeaders($request->header())
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'invoiceheader/'.$id.'/export')['data'];

        //FETCH DETAIL
        $detailParams = [
            'forExport' => true,
            'invoice_id' => $request->id
        ];
        $responses = Http::withHeaders($request->header())
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'invoicedetail', $detailParams);

        $invoice_details = $responses['data'];
        
        $tglBukti = $invoices["tglbukti"];
        $timeStamp = strtotime($tglBukti);
        $dateTglBukti = date('d-m-Y', $timeStamp); 
        $invoices['tglbukti'] = $dateTglBukti;

        $tglterima = $invoices["tglterima"];
        $timeStamp = strtotime($tglterima);
        $datetglterima = date('d-m-Y', $timeStamp); 
        $invoices['tglterima'] = $datetglterima;

        $tgljatuhtempo = $invoices["tgljatuhtempo"];
        $timeStamp = strtotime($tgljatuhtempo);
        $datetgljatuhtempo = date('d-m-Y', $timeStamp); 
        $invoices['tgljatuhtempo'] = $datetgljatuhtempo;

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', $invoices['judul']);
        $sheet->setCellValue('A2', $invoices['judulLaporan']);
        $sheet->getStyle("A1")->getFont()->setSize(12);
        $sheet->getStyle("A2")->getFont()->setSize(12);
        $sheet->getStyle("A1")->getFont()->setBold(true);
        $sheet->getStyle("A2")->getFont()->setBold(true);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal('center');
        $sheet->getStyle('A2')->getAlignment()->setHorizontal('center');
        $sheet->mergeCells('A1:I1');
        $sheet->mergeCells('A2:I2');

        $header_start_row = 4;
        $header_right_start_row = 4;
        $detail_table_header_row = 9;
        $detail_start_row = $detail_table_header_row + 1;

        $alphabets = range('A', 'Z');

        $header_columns = [
            [
                'label' => 'No Invoice',
                'index' => 'nobukti',
            ],
            [
                'label' => 'Tanggal',
                'index' => 'tglbukti',
            ],
            [
                'label' => 'Tanggal Terima',
                'index' => 'tglterima',
            ],
            [
                'label' => 'Tanggal Jatuh Tempo',
                'index' => 'tgljatuhtempo',
            ]
        ];
        $header_right_columns = [
            [
                'label' => 'EMKL',
                'index' => 'agen',
            ],
            [
                'label' => 'Jenis Order',
                'index' => 'jenisorder_id',
            ], 
            [
                'label' => 'No Bukti Piutang',
                'index' => 'piutang_nobukti',
            ]
        ];

        $detail_columns = [
            [
                'label' => 'NO',
            ],
            [
                'label' => 'NO BUKTI ORDERAN',
                'index' => 'orderantrucking_nobukti',
            ],
            [
                'label' => 'NO BUKTI SURAT PENGANTAR',
                'index' => 'suratpengantar_nobukti',
            ],
            [
                'label' => 'KETERANGAN',
                'index' => 'keterangan_detail',
            ],
            [
                'label' => 'NOMINAL RETRIBUSI',
                'index' => 'nominalretribusi',
                'format' => 'currency'
            ],
            [
                'label' => 'NOMINAL EXTRA',
                'index' => 'extra',
                'format' => 'currency'
            ],
            [
                'label' => 'TOTAL',
                'index' => 'total_detail',
                'format' => 'currency'
            ],
            [
                'label' => 'NOMINAL',
                'index' => 'omset',
                'format' => 'currency'
            ]
        ];

        //LOOPING HEADER       
        foreach ($header_columns as $header_column) {
            $sheet->setCellValue('B' . $header_start_row, $header_column['label']);
            $sheet->setCellValue('C' . $header_start_row++, ': '.$invoices[$header_column['index']]);
        }
        foreach ($header_right_columns as $header_right_column) {
            $sheet->setCellValue('D' . $header_right_start_row, $header_right_column['label']);
            $sheet->setCellValue('E' . $header_right_start_row++, ': '.$invoices[$header_right_column['index']]);
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
        $sheet->getStyle("A$detail_table_header_row:I$detail_table_header_row")->applyFromArray($styleArray);

        // LOOPING DETAIL
        $nominal = 0;
        foreach ($invoice_details as $response_index => $response_detail) {

            foreach ($detail_columns as $detail_columns_index => $detail_column) {
                $sheet->setCellValue($alphabets[$detail_columns_index] . $detail_start_row, isset($detail_column['index']) ? $response_detail[$detail_column['index']] : $response_index + 1);
            }
            $response_detail['omsets'] = number_format((float) $response_detail['omset'], '2', '.', ',');
            $response_detail['extras'] = number_format((float) $response_detail['extra'], '2', '.', ',');
            $response_detail['total_details'] = number_format((float) $response_detail['total_detail'], '2', '.', ',');
            $response_detail['nominalretribusis'] = number_format((float) $response_detail['nominalretribusi'], '2', '.', ',');

            $sheet->setCellValue("A$detail_start_row", $response_index + 1);
            $sheet->setCellValue("B$detail_start_row", $response_detail['orderantrucking_nobukti']);
            $sheet->setCellValue("C$detail_start_row", $response_detail['suratpengantar_nobukti']);
            $sheet->setCellValue("D$detail_start_row", $response_detail['keterangan_detail']);
            $sheet->setCellValue("E$detail_start_row", $response_detail['nominalretribusis']);
            $sheet->setCellValue("F$detail_start_row", $response_detail['extras']);
            $sheet->setCellValue("G$detail_start_row", $response_detail['total_details']);
            $sheet->setCellValue("H$detail_start_row", $response_detail['omsets']);

            $sheet->getStyle("C$detail_start_row:D$detail_start_row")->getAlignment()->setWrapText(true);
            $sheet->getColumnDimension('C')->setWidth(50);
            $sheet->getColumnDimension('D')->setWidth(50);

            $sheet->getStyle("A$detail_start_row:D$detail_start_row")->applyFromArray($styleArray);
            $sheet->getStyle("E$detail_start_row:H$detail_start_row")->applyFromArray($style_number);
            $nominal += $response_detail['omset'];
            $detail_start_row++;
        }

        $total_start_row = $detail_start_row;
        $sheet->mergeCells('A' . $total_start_row . ':G' . $total_start_row);
        $sheet->setCellValue("A$total_start_row", 'Total :')->getStyle('A' . $total_start_row . ':G' . $total_start_row)->applyFromArray($styleArray)->getFont()->setBold(true);
        $sheet->setCellValue("H$total_start_row", number_format((float) $nominal, '2', '.', ','))->getStyle("H$detail_start_row")->applyFromArray($style_number)->getFont()->setBold(true);

        $sheet->getColumnDimension('A')->setAutoSize(true);
        $sheet->getColumnDimension('B')->setAutoSize(true);
        $sheet->getColumnDimension('E')->setAutoSize(true);
        $sheet->getColumnDimension('F')->setAutoSize(true);
        $sheet->getColumnDimension('G')->setAutoSize(true);
        $sheet->getColumnDimension('H')->setAutoSize(true);
        $sheet->getColumnDimension('I')->setAutoSize(true);

        $writer = new Xlsx($spreadsheet);
        $filename = 'Laporan Invoice' . date('dmYHis');
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }
}

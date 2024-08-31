<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use PhpOffice\PhpSpreadsheet\Shared\Date;
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
            'listbtn' => $this->getListBtn()
        ];
        $data = array_merge(compact('title', 'data'),
            ["request"=>$request->all()]
        );
        return view('invoiceheader.index', $data);
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

    public function combo($aksi)
    {
        $status = [
            'status' => $aksi,
            'grp' => 'STATUSCETAK',
            'subgrp' => 'STATUSCETAK',
        ]; 
        $response = Http::withHeaders($this->httpHeaders)->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'user/combostatus',$status);
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
            
        $paramCetak = [
            'grp' => 'STATUS CETAKAN',
            'subgrp' => 'INVOICE'
        ];
        $statusCetakan = Http::withHeaders(request()->header())
        ->withOptions(['verify' => false])
        ->withToken(session('access_token'))
        ->get(config('app.api_url') . 'parameter/getparamfirst', $paramCetak);
            
        $combo = $this->combo('list');
        $key = array_search('CETAK', array_column( $combo, 'parameter')); 
        $invoices["combo"] =  $combo[$key];
        $printer['tipe'] = $request->printer;
        $format['cetak'] = $statusCetakan['text'];
        return view('reports.invoice', compact('invoice_detail', 'invoices','printer','format'));
    }

    // public function export(Request $request): void
    // {
    //     //FETCH HEADER
    //     $id = $request->id;
    //     $invoices = Http::withHeaders($request->header())
    //         ->withOptions(['verify' => false])
    //         ->withToken(session('access_token'))
    //         ->get(config('app.api_url') . 'invoiceheader/'.$id.'/export')['data'];

    //     //FETCH DETAIL
    //     $detailParams = [
    //         'forReport' => true,
    //         'invoice_id' => $request->id
    //     ];
    //     $responses = Http::withHeaders($request->header())
    //         ->withOptions(['verify' => false])
    //         ->withToken(session('access_token'))
    //         ->get(config('app.api_url') . 'invoicedetail', $detailParams);

    //     $invoice_details = $responses['data'];
        
    //     $tglBukti = $invoices["tglbukti"];
    //     $timeStamp = strtotime($tglBukti);
    //     $dateTglBukti = date('d-m-Y', $timeStamp); 
    //     $invoices['tglbukti'] = $dateTglBukti;

    //     $tglterima = $invoices["tglterima"];
    //     $timeStamp = strtotime($tglterima);
    //     $datetglterima = date('d-m-Y', $timeStamp); 
    //     $invoices['tglterima'] = $datetglterima;

    //     $tgljatuhtempo = $invoices["tgljatuhtempo"];
    //     $timeStamp = strtotime($tgljatuhtempo);
    //     $datetgljatuhtempo = date('d-m-Y', $timeStamp); 
    //     $invoices['tgljatuhtempo'] = $datetgljatuhtempo;

    //     $spreadsheet = new Spreadsheet();
    //     $sheet = $spreadsheet->getActiveSheet();
    //     $sheet->setCellValue('A1', $invoices['judul']);
    //     $sheet->setCellValue('A2', $invoices['judulLaporan']);
    //     $sheet->getStyle("A1")->getFont()->setSize(12);
    //     $sheet->getStyle("A2")->getFont()->setSize(12);
    //     $sheet->getStyle("A1")->getFont()->setBold(true);
    //     $sheet->getStyle("A2")->getFont()->setBold(true);
    //     $sheet->getStyle('A1')->getAlignment()->setHorizontal('center');
    //     $sheet->getStyle('A2')->getAlignment()->setHorizontal('center');
    //     $sheet->mergeCells('A1:M1');
    //     $sheet->mergeCells('A2:M2');

    //     $header_start_row = 4;
    //     $header_right_start_row = 4;
    //     $detail_table_header_row = 8;
    //     $detail_start_row = $detail_table_header_row + 1;

    //     $alphabets = range('A', 'Z');

    //     $header_columns = [
    //         [
    //             'label' => 'No Invoice',
    //             'index' => 'nobukti',
    //         ],
    //         [
    //             'label' => 'Tanggal',
    //             'index' => 'tglbukti',
    //         ],
    //         [
    //             'label' => 'Tanggal Jatuh Tempo',
    //             'index' => 'tgljatuhtempo',
    //         ]
    //     ];

    //     $header_right_columns = [
    //         [
    //             'label' => 'Customer',
    //             'index' => 'agen',
    //         ],
    //         [
    //             'label' => 'Jenis Order',
    //             'index' => 'jenisorder_id',
    //         ],
    //         [
    //             'label' => 'No Bukti Piutang',
    //             'index' => 'piutang_nobukti',
    //         ]
    //     ];

    //     $detail_columns = [
    //         [
    //             'label' => 'NO',
    //         ],
    //         [
    //             'label' => 'TANGGAL SP',
    //             'index' => 'tglsp',
    //         ],
    //         [
    //             'label' => 'SHIPPER',
    //             'index' => 'shipper',
    //         ],
    //         [
    //             'label' => 'TUJUAN',
    //             'index' => 'tujuan',
    //         ],
    //         [
    //             'label' => 'NO CONT',
    //             'index' => 'nocont',
    //         ],
    //         [
    //             'label' => 'UK. CONT',
    //             'index' => 'ukcont',
    //         ],
    //         [
    //             'label' => 'FULL',
    //             'index' => 'full'
    //         ],
    //         [
    //             'label' => 'EMPTY',
    //             'index' => 'empty'
    //         ],
    //         [
    //             'label' => 'FULL / EMPTY',
    //             'index' => 'fullEmpty'
    //         ],
    //         [
    //             'label' => 'OMSET',
    //             'index' => 'omset',
    //             'format' => 'currency'
    //         ],
    //         [
    //             'label' => 'EXTRA',
    //             'index' => 'extra',
    //             'format' => 'currency'
    //         ],
    //         [
    //             'label' => 'JUMLAH',
    //             'index' => 'jumlah',
    //             'format' => 'currency'
    //         ],
    //         [
    //             'label' => 'KETERANGAN',
    //             'index' => 'keterangan'
    //         ]
    //     ];

    //     //LOOPING HEADER       
    //     foreach ($header_columns as $header_column) {
    //         $sheet->setCellValue('B' . $header_start_row, $header_column['label']);
    //         $sheet->setCellValue('C' . $header_start_row++, ': '.$invoices[$header_column['index']]);
    //     }
    //     foreach ($header_right_columns as $header_right_column) {
    //         $sheet->setCellValue('D' . $header_right_start_row, $header_right_column['label']);
    //         $sheet->setCellValue('E' . $header_right_start_row++, ': '.$invoices[$header_right_column['index']]);
    //     }
    //     foreach ($detail_columns as $detail_columns_index => $detail_column) {
    //         $sheet->setCellValue($alphabets[$detail_columns_index] . $detail_table_header_row, $detail_column['label'] ?? $detail_columns_index + 1);
    //     }
    //     $styleArray = array(
    //         'borders' => array(
    //             'allBorders' => array(
    //                 'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
    //             ),
    //         ),
    //     );

    //     $style_number = [
	// 		'alignment' => [
	// 			'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT, 
	// 		],
            
	// 		'borders' => [
	// 			'allBorders' => array(
    //                 'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
    //             ),
	// 		]
    //     ];

    //     // $sheet->getStyle("A$detail_table_header_row:G$detail_table_header_row")->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('FF1F456E');
    //     $sheet->getStyle("A$detail_table_header_row:M$detail_table_header_row")->applyFromArray($styleArray);

    //     // LOOPING DETAIL
    //     $jumlah = 0;
    //     foreach ($invoice_details as $response_index => $response_detail) {

    //         foreach ($detail_columns as $detail_columns_index => $detail_column) {
    //             $sheet->setCellValue($alphabets[$detail_columns_index] . $detail_start_row, isset($detail_column['index']) ? $response_detail[$detail_column['index']] : $response_index + 1);
    //             $sheet->getStyle("A$detail_table_header_row:M$detail_table_header_row")->getFont()->setBold(true);
    //             $sheet->getStyle("A$detail_table_header_row:M$detail_table_header_row")->getAlignment()->setHorizontal('center');
    //         }
        
    //         $tglSp = ($response_detail['tglsp'] != null) ? Date::PHPToExcel(date('Y-m-d',strtotime($response_detail['tglsp']))) : ''; 

    //         $sheet->setCellValue("A$detail_start_row", $response_index + 1);
    //         $sheet->setCellValue("B$detail_start_row", $tglSp);
    //         $sheet->setCellValue("C$detail_start_row", $response_detail['shipper']);
    //         $sheet->setCellValue("D$detail_start_row", $response_detail['tujuan']);
    //         $sheet->setCellValue("E$detail_start_row", $response_detail['nocont']);
    //         $sheet->setCellValue("F$detail_start_row", $response_detail['ukcont']);
    //         $sheet->setCellValueExplicit("G$detail_start_row",$response_detail['full'], DataType::TYPE_STRING);
    //         $sheet->setCellValueExplicit("H$detail_start_row",$response_detail['empty'], DataType::TYPE_STRING);
    //         $sheet->setCellValueExplicit("I$detail_start_row",$response_detail['fullEmpty'], DataType::TYPE_STRING);
    //         $sheet->setCellValue("J$detail_start_row", $response_detail['omset']);
    //         $sheet->setCellValue("K$detail_start_row", $response_detail['extra']);
    //         $sheet->setCellValue("L$detail_start_row", $response_detail['jumlah']);
    //         $sheet->setCellValue("M$detail_start_row", $response_detail['keterangan']);
            
    //         $sheet->getColumnDimension('M')->setWidth(30);

    //         $sheet->getStyle("A$detail_start_row:M$detail_start_row")->applyFromArray($styleArray);
    //         $sheet->getStyle("B$detail_start_row")->getNumberFormat()->setFormatCode('dd-mm-yyyy');
    //         $sheet->getStyle("J$detail_start_row:L$detail_start_row")->applyFromArray($style_number)->getNumberFormat()->setFormatCode("#,##0.00_);(#,##0.00)");
    //         $detail_start_row++;
    //     }

    //     $total_start_row = $detail_start_row;
    //     $sheet->mergeCells('A' . $total_start_row . ':K' . $total_start_row);
    //     $sheet->setCellValue("A$total_start_row", 'Total')->getStyle('A' . $total_start_row . ':M' . $total_start_row)->applyFromArray($styleArray)->getFont()->setBold(true);
    //     $sheet->setCellValue("L$detail_start_row", "=SUM(L9:L" . ($detail_start_row - 1) . ")")->getStyle("L$detail_start_row")->applyFromArray($style_number)->getFont()->setBold(true);

    //     $sheet->getStyle("L$detail_start_row")->getNumberFormat()->setFormatCode("#,##0.00_);(#,##0.00)");

    //     $sheet->getColumnDimension('A')->setAutoSize(true);
    //     $sheet->getColumnDimension('B')->setAutoSize(true);
    //     $sheet->getColumnDimension('C')->setAutoSize(true);
    //     $sheet->getColumnDimension('D')->setAutoSize(true);
    //     $sheet->getColumnDimension('E')->setAutoSize(true);
    //     $sheet->getColumnDimension('F')->setAutoSize(true);
    //     $sheet->getColumnDimension('G')->setAutoSize(true);
    //     $sheet->getColumnDimension('H')->setAutoSize(true);
    //     $sheet->getColumnDimension('I')->setAutoSize(true);
    //     $sheet->getColumnDimension('J')->setAutoSize(true);
    //     $sheet->getColumnDimension('K')->setAutoSize(true);
    //     $sheet->getColumnDimension('L')->setAutoSize(true);

    //     $writer = new Xlsx($spreadsheet);
    //     $filename = 'Laporan Invoice ' . date('dmYHis');
    //     header('Content-Type: application/vnd.ms-excel');
    //     header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
    //     header('Cache-Control: max-age=0');

    //     $writer->save('php://output');
    // }
}

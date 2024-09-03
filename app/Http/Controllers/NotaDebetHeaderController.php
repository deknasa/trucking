<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class NotaDebetHeaderController extends MyController
{
    public $title = 'Nota Debet';
    public function index(Request $request)
    {

        $title = $this->title; 
        $data = [
            'comboapproval' => $this->comboList('list', 'STATUS APPROVAL', 'STATUS APPROVAL'),
            'combocetak' => $this->comboList('list', 'STATUSCETAK', 'STATUSCETAK'),
            'combokirimberkas' => $this->comboList('list','STATUSKIRIMBERKAS','STATUSKIRIMBERKAS'),
            'listbtn' => $this->getListBtn()
        ];
        $data = array_merge(compact('title', 'data'),
            ["request"=>$request->all()]
        );
        return view('notadebetheader.index', $data);
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
            ->get(config('app.api_url') . 'notadebetheader', $params);

        $data = [
            'total' => $response['attributes']['totalPages'] ?? [],
            'records' => $response['attributes']['totalRows'] ?? [],
            'rows' => $response['data'] ?? [],
            'params' => $response['params'] ?? [],
        ];

        return $data;
    }

    public function find($params,$id)
    {
        $params = [
            'offset' => $params['offset'] ?? request()->offset ?? ((request()->page - 1) * request()->rows),
            'limit' => $params['rows'] ?? request()->rows ?? 0,
            'sortIndex' => $params['sidx'] ?? request()->sidx,
            'sortOrder' => $params['sord'] ?? request()->sord,
            'search' => json_decode($params['filters'] ?? request()->filters, 1) ?? [],
            'withRelations' => $params['withRelations'] ?? request()->withRelations ?? false,
        ];

        return $response = Http::withHeaders(request()->header())
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'notadebetheader/'.$id);
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

    /**
     * @ClassName
     */
    public function report(Request $request,$id)
    {
        //FETCH HEADER
        $id = $request->id;
        $notadebet = Http::withHeaders($request->header())
           ->withOptions(['verify' => false])
           ->withToken(session('access_token'))
           ->get(config('app.api_url') .'notadebetheader/'.$id.'/export')['data'];

       //FETCH DETAIL
       $detailParams = [
        'forReport' => true,
        'notadebet_id' => $request->id
       ];
       $notadebet_detail = Http::withHeaders(request()->header())
           ->withOptions(['verify' => false])
           ->withToken(session('access_token'))
           ->get(config('app.api_url') .'notadebetdetail', $detailParams)['data'];

        $combo = $this->combo('list');
        $key = array_search('CETAK', array_column( $combo, 'parameter')); 
        $notadebet["combo"] =  $combo[$key];
        $printer['tipe'] = $request->printer;
        return view('reports.notadebetheader', compact('notadebet', 'notadebet_detail','printer'));
    }

    /**
     * @ClassName
     */
    // public function export(Request $request)
    // {
    //      //FETCH HEADER
    //      $id = $request->id;
    //      $notadebet = Http::withHeaders($request->header())
    //         ->withOptions(['verify' => false])
    //         ->withToken(session('access_token'))
    //         ->get(config('app.api_url') .'notadebetheader/'.$id.'/export')['data'];

    //     //FETCH DETAIL
    //     $detailParams = [
    //         'notadebet_id' => $request->id
    //     ];
    //     $notadebet_detail = Http::withHeaders(request()->header())
    //         ->withOptions(['verify' => false])
    //         ->withToken(session('access_token'))
    //         ->get(config('app.api_url') .'notadebetdetail', $detailParams)['data'];

    //     $tglBukti = $notadebet["tglbukti"];
    //     $timeStamp = strtotime($tglBukti);
    //     $dateTglBukti = date('d-m-Y', $timeStamp); 
    //     $notadebet['tglbukti'] = $dateTglBukti;

    //     $tgllunas = $notadebet["tgllunas"];
    //     $timeStamp = strtotime($tgllunas);
    //     $datetgllunas = date('d-m-Y', $timeStamp); 
    //     $notadebet['tgllunas'] = $datetgllunas;

    //     $spreadsheet = new Spreadsheet();
    //     $sheet = $spreadsheet->getActiveSheet();
    //     $sheet->setCellValue('A1', $notadebet['judul']);
    //     $sheet->setCellValue('A2', $notadebet['judulLaporan']);
    //     $sheet->getStyle("A1")->getFont()->setSize(12);
    //     $sheet->getStyle("A2")->getFont()->setSize(12);
    //     $sheet->getStyle("A1")->getFont()->setBold(true);
    //     $sheet->getStyle("A2")->getFont()->setBold(true);
    //     $sheet->getStyle('A1')->getAlignment()->setHorizontal('center');
    //     $sheet->getStyle('A2')->getAlignment()->setHorizontal('center');
    //     $sheet->mergeCells('A1:E1');
    //     $sheet->mergeCells('A2:E2');

    //     $header_start_row = 4;
    //     $detail_table_header_row = 9;
    //     $detail_start_row = $detail_table_header_row + 1;

    //     $alphabets = range('A', 'Z');
    //     $header_columns = [
    //         [
    //             'label'=>'No Bukti',
    //             'index'=>'nobukti'
    //         ],
    //         [
    //             'label'=>'Tanggal',
    //             'index'=>'tglbukti'
    //         ],
    //         [
    //             'label'=>'No Bukti Pelunasan Piutang',
    //             'index'=>'pelunasanpiutang_nobukti'
    //         ],
    //         [
    //             'label'=>'Tanggal lunas',
    //             'index'=>'tgllunas'
    //         ],
            
    //     ];
    //     $detail_columns = [
    //         [
    //             'label'=>'NO',
    //         ],
    //         [
    //             'label'=>'NO BUKTI INVOICE',
    //             'index'=>'invoice_nobukti'
    //         ],
    //         [
    //             'label'=>'NAMA PERKIRAAN LEBIH BAYAR',
    //             'index'=>'coalebihbayar'
    //         ],
    //         [
    //             'label'=>'KETERANGAN',
    //             'index'=>'keterangan'
    //         ],
    //         [
    //             'label'=>'NOMINAL LEBIH BAYAR',
    //             'index'=>'lebihbayar',
    //             'format'=>'currency',
    //         ],
    //     ];

    //     //LOOPING HEADER        
    //     foreach ($header_columns as $header_column) {
    //         $sheet->setCellValue('B' . $header_start_row, $header_column['label']);
    //         $sheet->setCellValue('C' . $header_start_row++, ': '.$notadebet[$header_column['index']]);
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
	// 			'top' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
	// 			'right' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], 
	// 			'bottom' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
	// 			'left' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN] 
	// 		]
    //     ];

    //     $sheet ->getStyle("A$detail_table_header_row:E$detail_table_header_row")->applyFromArray($styleArray);

    //     // LOOPING DETAIL
    //     $lebihbayar = 0;
    //     foreach ($notadebet_detail as $response_index => $response_detail) {
            
    //         foreach ($detail_columns as $detail_columns_index => $detail_column) {
    //             $sheet->setCellValue($alphabets[$detail_columns_index] . $detail_start_row, isset($detail_column['index']) ? $response_detail[$detail_column['index']] : $response_index + 1);
    //             $sheet->getStyle("A$detail_table_header_row:E$detail_table_header_row")->getFont()->setBold(true);
    //             $sheet->getStyle("A$detail_table_header_row:E$detail_table_header_row")->getAlignment()->setHorizontal('center');
    //         }
    //         $sheet->setCellValue("A$detail_start_row", $response_index + 1);
    //         $sheet->setCellValue("B$detail_start_row", $response_detail['invoice_nobukti']);
    //         $sheet->setCellValue("C$detail_start_row", $response_detail['coalebihbayar']);
    //         $sheet->setCellValue("D$detail_start_row", $response_detail['keterangan']);
    //         $sheet->setCellValue("E$detail_start_row", $response_detail['lebihbayar']);

    //         $sheet->getStyle("D$detail_start_row")->getAlignment()->setWrapText(true);
    //         $sheet->getColumnDimension('D')->setWidth(40);

    //         $sheet ->getStyle("A$detail_start_row:E$detail_start_row")->applyFromArray($styleArray);
    //         $sheet ->getStyle("E$detail_start_row")->applyFromArray($style_number)->getNumberFormat()->setFormatCode("#,##0.00_);(#,##0.00)");

    //         $detail_start_row++;
    //     }

    //     $total_start_row = $detail_start_row;
    //     $sheet->mergeCells('A'.$total_start_row.':D'.$total_start_row);
    //     $sheet->setCellValue("A$total_start_row", 'Total')->getStyle('A'.$total_start_row.':D'.$total_start_row)->applyFromArray($styleArray)->getFont()->setBold(true);

    //     $sheet->setCellValue("E$detail_start_row", "=SUM(E10:E" . ($detail_start_row - 1) . ")")->getStyle("E$detail_start_row")->applyFromArray($style_number)->getFont()->setBold(true);
       
    //     $sheet->getStyle("E$detail_start_row")->getNumberFormat()->setFormatCode("#,##0.00_);(#,##0.00)");

    //     $sheet->getColumnDimension('A')->setAutoSize(true);
    //     $sheet->getColumnDimension('B')->setAutoSize(true);
    //     $sheet->getColumnDimension('C')->setAutoSize(true);
    //     $sheet->getColumnDimension('E')->setAutoSize(true);

    //     $writer = new Xlsx($spreadsheet);
    //     $filename = 'Laporan Nota Debet' . date('dmYHis');
    //     header('Content-Type: application/vnd.ms-excel');
    //     header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
    //     header('Cache-Control: max-age=0');

    //     $writer->save('php://output');
    // }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class RekapPengeluaranHeaderController extends MyController
{
    public $title = 'Rekap Pengeluaran';
    
    public function index(Request $request)
    {
        $title = $this->title;
        $data = [
            'comboapproval' => $this->comboList('list','STATUS APPROVAL','STATUS APPROVAL'),
            'combocetak' => $this->comboList('list','STATUSCETAK','STATUSCETAK'),
            'listbtn' => $this->getListBtn()
        ];
        return view('rekappengeluaranheader.index', compact('title','data'));
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
            ->get(config('app.api_url') . 'rekappengeluaranheader', $params);

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
            ->get(config('app.api_url') . 'rekappengeluaranheader/'.$id);
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

    public function comboEntry($aksi,$grp,$subgrp)
    {
        $status = [
            'status' => $aksi,
            'grp' => $grp,
            'subgrp' => $subgrp,
        ]; 
        $response = Http::withHeaders($this->httpHeaders)->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'user/combostatus',$status);
        return $response['data'];
    }

    /**
     * @ClassName
     */
    public function report(Request $request)
    {
        //FETCH HEADER
        $id = $request->id;
        $rekappengeluaran = Http::withHeaders($request->header())
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') .'rekappengeluaranheader/'.$id.'/export')['data'];

        //FETCH DETAIL
        $detailParams = [
            'forReport' => true,
            'rekappengeluaran_id' => $request->id,
            'formatcetakan' => $rekappengeluaran['formatcetakan'],
        ];
        $rekappengeluaran_details = Http::withHeaders($request->header())
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') .'rekappengeluarandetail', $detailParams)['data'];
        $combo = $this->combo('list');
        $key = array_search('CETAK', array_column( $combo, 'parameter')); 
        $formatcetakan = $this->comboEntry('entry','FORMAT CETAKAN BANK','FORMAT CETAKAN BANK 1')[0];
        $rekappengeluaran["combo"] =  $combo[$key];
        $printer['tipe'] = $request->printer;
        return view('reports.rekappengeluaranheader', compact('rekappengeluaran','rekappengeluaran_details','printer','formatcetakan'));
    }

    // public function export(Request $request)
    // {
    //     //FETCH HEADER
    //     $id = $request->id;
    //     $rekappengeluaran = Http::withHeaders($request->header())
    //     ->withOptions(['verify' => false])
    //     ->withToken(session('access_token'))
    //     ->get(config('app.api_url') .'rekappengeluaranheader/'.$id.'/export')['data'];
        
    //     //FETCH DETAIL
    //     $detailParams = [
    //         'forReport' => true,
    //         'rekappengeluaran_id' => $request->id,
    //     ];
    //     $rekappengeluaran_details = Http::withHeaders($request->header())
    //     ->withOptions(['verify' => false])
    //     ->withToken(session('access_token'))
    //     ->get(config('app.api_url') .'rekappengeluarandetail', $detailParams)['data'];

    //     $tglBukti = $rekappengeluaran["tglbukti"];
    //     $timeStamp = strtotime($tglBukti);
    //     $dateTglBukti = date('d-m-Y', $timeStamp); 
    //     $rekappengeluaran['tglbukti'] = $dateTglBukti;

    //     $tgltransaksi = $rekappengeluaran["tgltransaksi"];
    //     $timeStamp = strtotime($tgltransaksi);
    //     $datetgltransaksi = date('d-m-Y', $timeStamp); 
    //     $rekappengeluaran['tgltransaksi'] = $datetgltransaksi;
        
    //     $spreadsheet = new Spreadsheet();
    //     $sheet = $spreadsheet->getActiveSheet();
    //     $sheet->setCellValue('A1', $rekappengeluaran['judul']);
    //     $sheet->setCellValue('A2', $rekappengeluaran['judulLaporan'] . $rekappengeluaran['bank']);
    //     $sheet->getStyle("A1")->getFont()->setSize(12);
    //     $sheet->getStyle("A2")->getFont()->setSize(12);
    //     $sheet->getStyle("A1")->getFont()->setBold(true);
    //     $sheet->getStyle("A2")->getFont()->setBold(true);
    //     $sheet->getStyle('A1')->getAlignment()->setHorizontal('center');
    //     $sheet->getStyle('A2')->getAlignment()->setHorizontal('center');
    //     $sheet->mergeCells('A1:D1');
    //     $sheet->mergeCells('A2:D2');

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
    //             'label'=>'Bank/Kas',
    //             'index'=>'bank'
    //         ],
    //         [
    //             'label'=>'Tanggal Transaksi',
    //             'index'=>'tgltransaksi'
    //         ]
    //     ];
    //     $detail_columns = [
    //         [
    //             'label'=>'NO',
    //         ],
    //         [
    //             'label'=>'NAMA PERKIRAAN',
    //             'index'=>'keterangancoa'
    //         ],
    //         [
    //             'label'=>'KETERANGAN',
    //             'index'=>'keterangan'
    //         ],
    //         [
    //             'label'=>'NOMINAL',
    //             'index'=>'nominal',
    //             'format'=>'currency'
    //         ], 
            
    //     ];

    //     //LOOPING HEADER        
    //     foreach ($header_columns as $header_column) {
    //         $sheet->setCellValue('B' . $header_start_row, $header_column['label']);
    //         $sheet->setCellValue('C' . $header_start_row++, ': '.$rekappengeluaran[$header_column['index']]);
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

    //     // $sheet->getStyle("A$detail_table_header_row:G$detail_table_header_row")->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('FF1F456E');
    //     $sheet ->getStyle("A$detail_table_header_row:D$detail_table_header_row")->applyFromArray($styleArray);
    
    //     // LOOPING DETAIL
    //     $nominal = 0;
    //     foreach ($rekappengeluaran_details as $response_index => $response_detail) {
            
    //         foreach ($detail_columns as $detail_columns_index => $detail_column) {
    //             $sheet->setCellValue($alphabets[$detail_columns_index] . $detail_start_row, isset($detail_column['index']) ? $response_detail[$detail_column['index']] : $response_index + 1);
    //             $sheet->getStyle("A$detail_table_header_row:E$detail_table_header_row")->getFont()->setBold(true);
    //             $sheet->getStyle("A$detail_table_header_row:E$detail_table_header_row")->getAlignment()->setHorizontal('center');
    //         }
        
    //         $sheet->setCellValue("A$detail_start_row", $response_index + 1);
    //         $sheet->setCellValue("B$detail_start_row", $response_detail['keterangancoa']);
    //         $sheet->setCellValue("C$detail_start_row", $response_detail['keterangan']);
    //         $sheet->setCellValue("D$detail_start_row", $response_detail['nominal']);

    //         $sheet->getStyle("C$detail_start_row")->getAlignment()->setWrapText(true);
    //         $sheet->getColumnDimension('C')->setWidth(50);

    //         $sheet ->getStyle("A$detail_start_row:C$detail_start_row")->applyFromArray($styleArray);
    //         $sheet ->getStyle("D$detail_start_row")->applyFromArray($style_number)->getNumberFormat()->setFormatCode("#,##0.00_);(#,##0.00)");
    //         $detail_start_row++;
    //     }
 
    //     $total_start_row = $detail_start_row;
    //     $sheet->mergeCells('A'.$total_start_row.':C'.$total_start_row);
    //     $sheet->setCellValue("A$total_start_row", 'Total')->getStyle('A'.$total_start_row.':C'.$total_start_row)->applyFromArray($styleArray)->getFont()->setBold(true);
    //     $sheet->setCellValue("D$total_start_row", "=SUM(D10:D" . ($detail_start_row - 1) . ")")->getStyle("D$detail_start_row")->applyFromArray($style_number)->getFont()->setBold(true);
    //     $sheet->getStyle("D$total_start_row")->applyFromArray($style_number)->getNumberFormat()->setFormatCode("#,##0.00_);(#,##0.00)");
    //     //set autosize
    //     $sheet->getColumnDimension('A')->setAutoSize(true);
    //     $sheet->getColumnDimension('B')->setAutoSize(true);
    //     $sheet->getColumnDimension('D')->setAutoSize(true);

    //     $writer = new Xlsx($spreadsheet);
    //     $filename = 'Laporan Rekap Pengeluaran ' . $rekappengeluaran['bank'] . date('dmYHis');
    //     header('Content-Type: application/vnd.ms-excel');
    //     header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
    //     header('Cache-Control: max-age=0');

    //     $writer->save('php://output');
    // }
}

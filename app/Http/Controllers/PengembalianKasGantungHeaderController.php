<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use stdClass;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Client\ConnectionException;

class PengembalianKasGantungHeaderController extends MyController
{
    public $title = 'Pengembalian Kas Gantung';

    public function index(Request $request)
    {
        $title = $this->title;
        
        $data = [
            'combocetak' => $this->comboCetak('list', 'STATUSCETAK', 'STATUSCETAK'),
            'listbtn' => $this->getListBtn()
        ];

        return view('pengembaliankasgantung.index', compact('title', 'data'));
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
            ->get(config('app.api_url') . 'pengembaliankasgantung', $params);

        $data = [
            'total' => $response['attributes']['totalPages'] ?? [],
            'records' => $response['attributes']['totalRows'] ?? [],
            'rows' => $response['data'] ?? [],
            'params' => $response['params'] ?? [],
        ];

        return $data;
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
        $data = Http::withHeaders($request->header())
        ->withOptions(['verify' => false])
        ->withToken(session('access_token'))
        ->get(config('app.api_url') .'pengembaliankasgantungheader/'.$id.'/export');

        //FETCH DETAIL
        $detailParams = [
            'pengembaliankasgantung_id' => $request->id
        ];
        $responses = Http::withHeaders(request()->header())
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') .'pengembaliankasgantungdetail', $detailParams);

        $pengembaliankasgantung = $data['data'];
        $pengembaliankasgantung_details = $responses['data'];

        $combo = $this->combo('list');
        $key = array_search('CETAK', array_column( $combo, 'parameter')); 
        $pengembaliankasgantung["combo"] =  $combo[$key];
        $printer['tipe'] = $request->printer;
        return view('reports.pengembaliankasgantungheader', compact('pengembaliankasgantung','pengembaliankasgantung_details','printer'));
    }

    // public function export(Request $request): void
    // {
    //     //FETCH HEADER
    //     $id = $request->id;
    //     $data = Http::withHeaders($request->header())
    //     ->withOptions(['verify' => false])
    //     ->withToken(session('access_token'))
    //     ->get(config('app.api_url') .'pengembaliankasgantungheader/'.$id.'/export');

    //     // dd($data['data']);

    //      //FETCH DETAIL
    //      $detailParams = [
    //         'pengembaliankasgantung_id' => $request->id
    //     ];
    //     $responses = Http::withHeaders(request()->header())
    //         ->withOptions(['verify' => false])
    //         ->withToken(session('access_token'))
    //         ->get(config('app.api_url') .'pengembaliankasgantungdetail', $detailParams);

    //     $pengembaliankasgantung = $data['data'];
    //     $pengembaliankasgantung_details = $responses['data'];

    //     dd($pengembaliankasgantung_details);

    //     $tglBukti = $pengembaliankasgantung["tglbukti"];
    //     $timeStamp = strtotime($tglBukti);
    //     $dateTglBukti = date('d-m-Y', $timeStamp); 

    //     $tglDari = $pengembaliankasgantung["tgldari"];
    //     $timeStampDari = strtotime($tglDari);
    //     $dateTglDari = date('d-m-Y', $timeStampDari); 

    //     $tglSampai = $pengembaliankasgantung["tglsampai"];
    //     $timeStampSampai = strtotime($tglSampai);
    //     $dateTglSampai = date('d-m-Y', $timeStampSampai); 

    //     $tglKasMasuk = $pengembaliankasgantung["tglkasmasuk"];
    //     $timeStampKasMasuk = strtotime($tglKasMasuk);
    //     $dateTglKasMasuk = date('d-m-Y', $timeStampKasMasuk); 

    //     $pengembaliankasgantung['tglbukti'] = $dateTglBukti;
    //     $pengembaliankasgantung['tgldari'] = $dateTglDari;
    //     $pengembaliankasgantung['tglsampai'] = $dateTglSampai;
    //     $pengembaliankasgantung['tglkasmasuk'] = $dateTglKasMasuk;

    //     $spreadsheet = new Spreadsheet();
    //     $sheet = $spreadsheet->getActiveSheet();
    //     $sheet->setCellValue('A1', $pengembaliankasgantung['judul']);
    //     $sheet->setCellValue('A2', $pengembaliankasgantung['judulLaporan']);
    //     $sheet->getStyle("A1")->getFont()->setSize(12);
    //     $sheet->getStyle("A2")->getFont()->setSize(12);
    //     $sheet->getStyle("A1")->getFont()->setBold(true);
    //     $sheet->getStyle("A2")->getFont()->setBold(true);
    //     $sheet->getStyle('A1')->getAlignment()->setHorizontal('center');
    //     $sheet->getStyle('A2')->getAlignment()->setHorizontal('center');
    //     $sheet->mergeCells('A1:E1');
    //     $sheet->mergeCells('A2:E2');

    //     $header_start_row = 4;
    //     $header_right_start_row = 4;
    //     $detail_table_header_row = 10;
    //     $detail_start_row = $detail_table_header_row + 1;

    //     $alphabets = range('A', 'Z');

    //     $header_columns = [
    //         [
    //             'label' => 'No Bukti',
    //             'index' => 'nobukti',
    //         ],
    //         [
    //             'label' => 'Tanggal',
    //             'index' => 'tglbukti',
    //         ],
    //         [
    //             'label' => 'Tanggal Dari',
    //             'index' => 'tgldari',
    //         ],
    //         [
    //             'label' => 'Tanggal Sampai',
    //             'index' => 'tglsampai',
    //         ],
            
    //         [
    //             'label' => 'Tanggal Kas Masuk',
    //             'index' => 'tglkasmasuk',
    //         ],
    //     ];
    //     $header_right_columns = [
    //         [
    //             'label' => 'Posting Dari',
    //             'index' => 'postingdari',
    //         ],
    //         [
    //             'label' => 'Bank',
    //             'index' => 'bank',
    //         ],
    //         [
    //             'label' => 'No Bukti Penerimaan',
    //             'index' => 'penerimaan_nobukti',
    //         ],
    //         [
    //             'label' => 'Kode Perkiraan',
    //             'index' => 'coakasmasuk',
    //         ],
    //     ];

    //     $detail_columns = [
    //         [
    //             'label' => 'NO',
    //         ],
    //         [
    //             'label' => 'NO BUKTI KAS GANTUNG',
    //             'index' => 'kasgantung_nobukti',
    //         ],
    //         [
    //             'label' => 'KETERANGAN',
    //             'index' => 'keterangan',
    //         ],
    //         [
    //             'label' => 'KODE PERKIRAAN',
    //             'index' => 'coa',
    //         ],
    //         [
    //             'label' => 'NOMINAL',
    //             'index' => 'nominal',
    //             'format' => 'currency'
    //         ],
    //     ];

    //     //LOOPING HEADER        
    //     foreach ($header_columns as $header_column) {
    //         $sheet->setCellValue('B' . $header_start_row, $header_column['label']);
    //         $sheet->setCellValue('C' . $header_start_row++, ': '.$pengembaliankasgantung[$header_column['index']]);
    //     }
    //     foreach ($header_right_columns as $header_right_column) {
    //         $sheet->setCellValue('D' . $header_right_start_row, $header_right_column['label']);
    //         $sheet->setCellValue('E' . $header_right_start_row++, ': '.$pengembaliankasgantung[$header_right_column['index']]);
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
    //     $nominal = 0;
    //     foreach ($pengembaliankasgantung_details as $response_index => $response_detail) {
            
    //         foreach ($detail_columns as $detail_columns_index => $detail_column) {
    //             $sheet->setCellValue($alphabets[$detail_columns_index] . $detail_start_row, isset($detail_column['index']) ? $response_detail[$detail_column['index']] : $response_index + 1);
    //             $sheet->getStyle("A$detail_table_header_row:E$detail_table_header_row")->getFont()->setBold(true);
    //             $sheet->getStyle("A$detail_table_header_row:E$detail_table_header_row")->getAlignment()->setHorizontal('center');
    //         }
        
    //         $sheet->setCellValue("A$detail_start_row", $response_index + 1);    
    //         $sheet->setCellValue("B$detail_start_row", $response_detail['kasgantung_nobukti']);
    //         $sheet->setCellValue("C$detail_start_row", $response_detail['keterangan']);
    //         $sheet->setCellValue("D$detail_start_row", $response_detail['coa']);
    //         $sheet->setCellValue("E$detail_start_row", $response_detail['nominal']);

    //         // $sheet->getStyle("C$detail_start_row")->getAlignment()->setWrapText(true);
    //         $sheet->getColumnDimension('C')->setWidth(50);

    //         $sheet ->getStyle("A$detail_start_row:E$detail_start_row")->applyFromArray($styleArray);
    //         $sheet ->getStyle("E$detail_start_row")->applyFromArray($style_number)->getNumberFormat()->setFormatCode("#,##0.00_);(#,##0.00)");
    //         $detail_start_row++;
    //     }

    //     $total_start_row = $detail_start_row;
    //     $sheet->mergeCells('A'.$total_start_row.':D'.$total_start_row);
    //     $sheet->setCellValue("A$total_start_row", 'Total')->getStyle('A'.$total_start_row.':D'.$total_start_row)->applyFromArray($style_number)->getFont()->setBold(true);
    //     $sheet->setCellValue("E$total_start_row", "=SUM(E11:E" . ($detail_start_row - 1) . ")")->getStyle("E$detail_start_row")->applyFromArray($style_number)->getFont()->setBold(true);

    //     $sheet->getStyle("E$detail_start_row")->getNumberFormat()->setFormatCode("#,##0.00_);(#,##0.00)");
    //     $sheet->getColumnDimension('A')->setAutoSize(true);
    //     $sheet->getColumnDimension('B')->setAutoSize(true);
    //     $sheet->getColumnDimension('C')->setAutoSize(true);
    //     $sheet->getColumnDimension('D')->setAutoSize(true);
    //     $sheet->getColumnDimension('E')->setAutoSize(true);

    //     $writer = new Xlsx($spreadsheet);
    //     $filename = 'Laporan Pengembalian Kas Gantung' . date('dmYHis');
    //     header('Content-Type: application/vnd.ms-excel');
    //     header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
    //     header('Cache-Control: max-age=0');

    //     $writer->save('php://output');
    // }
}

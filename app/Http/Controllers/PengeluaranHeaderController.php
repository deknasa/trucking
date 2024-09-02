<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\View\View;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class PengeluaranHeaderController extends MyController
{
    public $title = 'Pengeluaran Kas/Bank';

    /**
     * @ClassName
     */
    public function index(Request $request)
    {
        $title = $this->title;
        
        $data = [            
            'comboapproval' => $this->comboApproval('list','STATUS APPROVAL','STATUS APPROVAL'),
            'combocetak' => $this->comboCetak('list','STATUSCETAK','STATUSCETAK'),
            'combokirimberkas' => $this->comboCetak('list','STATUSKIRIMBERKAS','STATUSKIRIMBERKAS'),
            'combobank' => $this->comboBank(),
            'listbtn' => $this->getListBtn()
        ];
        
        $data = array_merge(compact('title', 'data'),
            ["request"=>$request->all()]
        );
        return view('pengeluaran.index', $data);
    }

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
            ->get(config('app.api_url') . 'pengeluaranheader', $params);

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


    // /**
    //  * Fungsi delete
    //  * @ClassName delete
    //  */




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

    public function comboBank()
    {
        $detailParams = [
            'aktif' => 'AKTIF',
            'from' => 'pengeluaran',
            'limit' => 0
        ];
        $response = Http::withHeaders($this->httpHeaders)
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'bank', $detailParams);

        return $response['data'];
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
    //  * Fungsi combo
    //  * @ClassName combo
    //  */
    private function combo()
    {
        $response = Http::withHeaders($this->httpHeaders)
            ->withToken(session('access_token'))
            ->withOptions(['verify' => false])
            ->get(config('app.api_url') . 'pengeluaranheader/combo');
        return $response['data'];
    }

    public function comboreport($aksi)
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
        $pengeluaran = Http::withHeaders($request->header())
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'pengeluaranheader/'.$id.'/export')['data'];

        //FETCH DETAIL
        $detailParams = [
            'forReport' => true,
            'pengeluaran_id' => $request->id,
        ];
        $pengeluaran_details = Http::withHeaders($request->header())
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'pengeluarandetail', $detailParams)['data'];

        $combo = $this->comboreport('list');
        $key = array_search('CETAK', array_column( $combo, 'parameter')); 
        $pengeluaran["combo"] =  $combo[$key];
        $printer['tipe'] = $request->printer;
        $cabang['cabang'] = session('cabang');
        // dd($cabang['cabang']);
        if($pengeluaran['tipe_bank'] === 'KAS')
        { return view('reports.pengeluarankas', compact('pengeluaran', 'pengeluaran_details','printer', 'cabang',));
        } else {
            return view('reports.pengeluaranbank', compact('pengeluaran', 'pengeluaran_details','printer', 'cabang',));
        }
    }

    // public function export(Request $request): void
    // {
    //     //FETCH HEADER
    //     $id = $request->id;
    //     $pengeluaran = Http::withHeaders($request->header())
    //         ->withOptions(['verify' => false])
    //         ->withToken(session('access_token'))
    //         ->get(config('app.api_url') . 'pengeluaranheader/'.$id.'/export')['data'];

    //     //FETCH DETAIL
    //     $detailParams = [
    //         'forReport' => true,
    //         'pengeluaran_id' => $request->id,
    //     ];
    //     $pengeluaran_details = Http::withHeaders($request->header())
    //         ->withOptions(['verify' => false])
    //         ->withToken(session('access_token'))
    //         ->get(config('app.api_url') . 'pengeluarandetail', $detailParams)['data'];
        
    //     $tglBukti = $pengeluaran["tglbukti"];
    //     $timeStamp = strtotime($tglBukti);
    //     $dateTglBukti = date('d-m-Y', $timeStamp); 
    //     $pengeluaran['tglbukti'] = $dateTglBukti;
    
    //     if($pengeluaran['tipe_bank'] === 'KAS')
    //     { 
    //         $spreadsheet = new Spreadsheet();
    //         $sheet = $spreadsheet->getActiveSheet();
    //         $sheet->setCellValue('A1', $pengeluaran['judul']);
    //         $sheet->setCellValue('A2', 'Laporan Pengeluaran '. $pengeluaran['bank_id'] );
    //         $sheet->getStyle("A1")->getFont()->setSize(12);
    //         $sheet->getStyle("A2")->getFont()->setSize(12);
    //         $sheet->getStyle("A1")->getFont()->setBold(true);
    //         $sheet->getStyle("A2")->getFont()->setBold(true);
    //         $sheet->getStyle('A1')->getAlignment()->setHorizontal('center');
    //         $sheet->getStyle('A2')->getAlignment()->setHorizontal('center');
    //         $sheet->mergeCells('A1:D1');
    //         $sheet->mergeCells('A2:D2');
            
    //         $header_start_row = 4;
    //         $detail_table_header_row = 8;
    //         $detail_start_row = $detail_table_header_row + 1;

    //         $alphabets = range('A', 'Z');

    //         $header_columns = [
    //             [
    //                 'label' => 'No Bukti',
    //                 'index' => 'nobukti',
    //             ],
    //             [
    //                 'label' => 'Tanggal',
    //                 'index' => 'tglbukti',
    //             ],
    //             [
    //                 'label' => 'Kas',
    //                 'index' => 'bank_id',
    //             ],
    //         ];

    //         $detail_columns = [
    //             [
    //                 'label' => 'NO',
    //             ],
    //             [
    //                 'label' => 'NAMA PERKIRAAN',
    //                 'index' => 'coadebet'
    //             ],
    //             [
    //                 'label' => 'KETERANGAN',
    //                 'index' => 'keterangan'
    //             ],
    //             [
    //                 'label' => 'NOMINAL',
    //                 'index' => 'nominal',
    //                 'format' => 'currency'
    //             ]
    //         ];

    //         //LOOPING HEADER        
    //         foreach ($header_columns as $header_column) {
    //             $sheet->setCellValue('B' . $header_start_row, $header_column['label']);
    //             $sheet->setCellValue('C' . $header_start_row++, ': ' . $pengeluaran[$header_column['index']]);
    //         }
    //         foreach ($detail_columns as $detail_columns_index => $detail_column) {
    //             $sheet->setCellValue($alphabets[$detail_columns_index] . $detail_table_header_row, $detail_column['label'] ?? $detail_columns_index + 1);
    //         }
    //         $styleArray = array(
    //             'borders' => array(
    //                 'allBorders' => array(
    //                     'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
    //                 ),
    //             ),
    //         );

    //         $style_number = [
    //             'alignment' => [
    //                 'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT,
    //             ],

    //             'borders' => [
    //                 'top' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
    //                 'right' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
    //                 'bottom' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
    //                 'left' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN]
    //             ]
    //         ];

    //         // $sheet->getStyle("A$detail_table_header_row:G$detail_table_header_row")->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('FF1F456E');
    //         $sheet->getStyle("A$detail_table_header_row:D$detail_table_header_row")->applyFromArray($styleArray);

    //         // LOOPING DETAIL
    //         $nominal = 0;
    //         foreach ($pengeluaran_details as $response_index => $response_detail) {

    //             foreach ($detail_columns as $detail_columns_index => $detail_column) {
    //                 $sheet->setCellValue($alphabets[$detail_columns_index] . $detail_start_row, isset($detail_column['index']) ? $response_detail[$detail_column['index']] : 0);
    //                 $sheet->getStyle("A$detail_table_header_row:D$detail_table_header_row")->getFont()->setBold(true);
    //                 $sheet->getStyle("A$detail_table_header_row:D$detail_table_header_row")->getAlignment()->setHorizontal('center');
    //             }

    //             $sheet->setCellValue("A$detail_start_row", $response_index + 1);
    //             $sheet->setCellValue("B$detail_start_row", $response_detail['coadebet']);
    //             $sheet->setCellValue("C$detail_start_row", $response_detail['keterangan']);
    //             $sheet->setCellValue("D$detail_start_row", $response_detail['nominal']);

    //             $sheet->getStyle("C$detail_start_row")->getAlignment()->setWrapText(true);
    //             $sheet->getColumnDimension('C')->setWidth(50);

    //             $sheet->getStyle("A$detail_start_row:C$detail_start_row")->applyFromArray($styleArray);
    //             $sheet->getStyle("D$detail_start_row")->applyFromArray($style_number)->getNumberFormat()->setFormatCode("#,##0.00_);(#,##0.00)");

    //             $detail_start_row++;
    //         }

    //         $total_start_row = $detail_start_row;
    //         $sheet->mergeCells('A' . $total_start_row . ':C' . $total_start_row);
    //         $sheet->setCellValue("A$total_start_row", 'Total')->getStyle('A' . $total_start_row . ':C' . $total_start_row)->applyFromArray($styleArray)->getFont()->setBold(true);
    //         $sheet->setCellValue("D$total_start_row", "=SUM(D9:D" . ($detail_start_row - 1) . ")")->getStyle("D$detail_start_row")->applyFromArray($style_number)->getFont()->setBold(true);

    //         $sheet->getStyle("D$detail_start_row")->getNumberFormat()->setFormatCode("#,##0.00_);(#,##0.00)");
    //         $sheet->getColumnDimension('A')->setAutoSize(true);
    //         $sheet->getColumnDimension('B')->setAutoSize(true);
    //         $sheet->getColumnDimension('D')->setAutoSize(true);

    //         $writer = new Xlsx($spreadsheet);
    //         $filename = 'Laporan Pengeluaran ' .$pengeluaran['bank_id'] . date('dmYHis');
    //         header('Content-Type: application/vnd.ms-excel');
    //         header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
    //         header('Cache-Control: max-age=0');

    //         $writer->save('php://output');
    //     } else {
    //         $spreadsheet = new Spreadsheet();
    //         $sheet = $spreadsheet->getActiveSheet();
    //         $sheet->setCellValue('A1', $pengeluaran['judul']);
    //         $sheet->setCellValue('A2', 'Laporan pengeluaran '. $pengeluaran['bank_id']);
    //         $sheet->getStyle("A1")->getFont()->setSize(12);
    //         $sheet->getStyle("A2")->getFont()->setSize(12);
    //         $sheet->getStyle("A1")->getFont()->setBold(true);
    //         $sheet->getStyle("A2")->getFont()->setBold(true);
    //         $sheet->getStyle('A1')->getAlignment()->setHorizontal('center');
    //         $sheet->getStyle('A2')->getAlignment()->setHorizontal('center');
    //         $sheet->mergeCells('A1:G1');
    //         $sheet->mergeCells('A2:G2');

    //         $header_start_row = 4;
    //         $header_start_row_right = 4;
    //         $detail_table_header_row = 8;
    //         $detail_start_row = $detail_table_header_row + 1;

    //         $alphabets = range('A', 'Z');

    //         $header_columns = [
    //             [
    //                 'label' => 'No Bukti',
    //                 'index' => 'nobukti',
    //             ],
    //             [
    //                 'label' => 'Tanggal',
    //                 'index' => 'tglbukti',
    //             ],
    //             [
    //                 'label' => 'Bank',
    //                 'index' => 'bank_id',
    //             ],
    //         ];

    //         $detail_columns = [
    //             [
    //                 'label' => 'NO',
    //             ],
    //             [
    //                 'label' => 'NAMA PERKIRAAN',
    //                 'index' => 'coadebet'
    //             ],
    //             [
    //                 'label' => 'BANK',
    //                 'index' => 'bank'
    //             ],
    //             [
    //                 'label' => 'JATUH TEMPO',
    //                 'index' => 'tgljatuhtempo'
    //             ],
    //             [
    //                 'label' => 'NO INVOICE',
    //                 'index' => 'invoice_nobukti'
    //             ],
    //             [
    //                 'label' => 'KETERANGAN',
    //                 'index' => 'keterangan'
    //             ],
    //             [
    //                 'label' => 'NOMINAL',
    //                 'index' => 'nominal',
    //                 'format' => 'currency'
    //             ]
    //         ];

    //         //LOOPING HEADER        
    //         foreach ($header_columns as $header_column) {
    //             $sheet->setCellValue('B' . $header_start_row, $header_column['label']);
    //             $sheet->setCellValue('C' . $header_start_row++, ': ' . $pengeluaran[$header_column['index']]);
    //         }
    //         foreach ($detail_columns as $detail_columns_index => $detail_column) {
    //             $sheet->setCellValue($alphabets[$detail_columns_index] . $detail_table_header_row, $detail_column['label'] ?? $detail_columns_index + 1);
    //         }
    //         $styleArray = array(
    //             'borders' => array(
    //                 'allBorders' => array(
    //                     'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
    //                 ),
    //             ),
    //         );

    //         $style_number = [
    //             'alignment' => [
    //                 'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT,
    //             ],

    //             'borders' => [
    //                 'top' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
    //                 'right' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
    //                 'bottom' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
    //                 'left' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN]
    //             ]
    //         ];

    //         // $sheet->getStyle("A$detail_table_header_row:G$detail_table_header_row")->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('FF1F456E');
    //         $sheet->getStyle("A$detail_table_header_row:G$detail_table_header_row")->applyFromArray($styleArray);

    //         // LOOPING DETAIL
    //         $nominal = 0;
    //         foreach ($pengeluaran_details as $response_index => $response_detail) {

    //             foreach ($detail_columns as $detail_columns_index => $detail_column) {
    //                 $sheet->setCellValue($alphabets[$detail_columns_index] . $detail_start_row, isset($detail_column['index']) ? $response_detail[$detail_column['index']] : 0);
    //                 $sheet->getStyle("A$detail_table_header_row:G$detail_table_header_row")->getFont()->setBold(true);
    //                 $sheet->getStyle("A$detail_table_header_row:G$detail_table_header_row")->getAlignment()->setHorizontal('center');
    //             }

    //             $tgljatuhtempo = $response_detail["tgljatuhtempo"];
    //             $timeStamp = strtotime($tgljatuhtempo);
    //             $datetgljatuhtempo = date('d-m-Y', $timeStamp); 
    //             $response_detail['tgljatuhtempo'] = $datetgljatuhtempo;

    //             $sheet->setCellValue("A$detail_start_row", $response_index + 1);
    //             $sheet->setCellValue("B$detail_start_row", $response_detail['coadebet']);
    //             $sheet->setCellValue("C$detail_start_row", $response_detail['bank']);
    //             $sheet->setCellValue("D$detail_start_row", $response_detail['tgljatuhtempo']);
    //             $sheet->setCellValue("E$detail_start_row", $response_detail['invoice_nobukti']);
    //             $sheet->setCellValue("F$detail_start_row", $response_detail['keterangan']);
    //             $sheet->setCellValue("G$detail_start_row", $response_detail['nominal']);

    //             $sheet->getStyle("F$detail_start_row")->getAlignment()->setWrapText(true);
    //             $sheet->getColumnDimension('F')->setWidth(50);

    //             $sheet->getStyle("A$detail_start_row:G$detail_start_row")->applyFromArray($styleArray);
    //             $sheet->getStyle("G$detail_start_row")->applyFromArray($style_number)->getNumberFormat()->setFormatCode("#,##0.00_);(#,##0.00)");

    //             $detail_start_row++;
    //         }
    //         $total_start_row = $detail_start_row;
    //         $sheet->mergeCells('A' . $total_start_row . ':F' . $total_start_row);
    //         $sheet->setCellValue("A$total_start_row", 'Total')->getStyle('A' . $total_start_row . ':F' . $total_start_row)->applyFromArray($styleArray)->getFont()->setBold(true);
    //         $sheet->setCellValue("G$total_start_row", "=SUM(G9:G" . ($detail_start_row - 1) . ")")->getStyle("G$detail_start_row")->applyFromArray($style_number)->getFont()->setBold(true);
    //         $sheet->getStyle("G$total_start_row")->applyFromArray($style_number)->getNumberFormat()->setFormatCode("#,##0.00_);(#,##0.00)");

    //         $sheet->getColumnDimension('A')->setAutoSize(true);
    //         $sheet->getColumnDimension('B')->setAutoSize(true);
    //         $sheet->getColumnDimension('C')->setAutoSize(true);
    //         $sheet->getColumnDimension('D')->setAutoSize(true);
    //         $sheet->getColumnDimension('E')->setAutoSize(true);
    //         $sheet->getColumnDimension('G')->setAutoSize(true);

    //         $writer = new Xlsx($spreadsheet);
    //         $filename = 'Laporan Pengeluaran ' .$pengeluaran['bank_id'] . date('dmYHis');
    //         header('Content-Type: application/vnd.ms-excel');
    //         header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
    //         header('Cache-Control: max-age=0');

    //         $writer->save('php://output');
    //     }

        
    // }
}

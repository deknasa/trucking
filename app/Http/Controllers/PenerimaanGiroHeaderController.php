<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;


class PenerimaanGiroHeaderController extends MyController
{
    public $title = 'Penerimaan Giro';

    /**
     * @ClassName
     */
    public function index(Request $request)
    {
        $title = $this->title;
        
        $data = [
            'comboapproval' => $this->comboApproval('list', 'STATUS APPROVAL', 'STATUS APPROVAL'),
            'combocetak' => $this->comboApproval('list', 'STATUSCETAK', 'STATUSCETAK'),
            'combokirimberkas' => $this->comboApproval('list','STATUSKIRIMBERKAS','STATUSKIRIMBERKAS'),
            'listbtn' => $this->getListBtn()
        ];
        $data = array_merge(compact('title', 'data'),
            ["request"=>$request->all()]
        );

        return view('penerimaangiroheader.index', $data);
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
            ->get(config('app.api_url') . 'penerimaangiroheader', $params);

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

    // /**
    //  * Fungsi combo
    //  * @ClassName combo
    //  */
    private function combo()
    {
        $response = Http::withHeaders($this->httpHeaders)
            ->withToken(session('access_token'))
            ->withOptions(['verify' => false])
            ->get(config('app.api_url') . 'penerimaanheader/combo');
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
        $penerimaangiro = Http::withHeaders($request->header())
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'penerimaangiroheader/'.$id.'/export')['data'];

        //FETCH DETAIL
        $detailParams = [
            'forReport' => true,
            'penerimaangiro_id' => $request->id,
        ];

        $penerimaangiro_details = Http::withHeaders($request->header())
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'penerimaangirodetail', $detailParams)['data'];

        $combo = $this->comboreport('list');
        $key = array_search('CETAK', array_column( $combo, 'parameter')); 
        $penerimaangiro["combo"] =  $combo[$key];
        $printer['tipe'] = $request->printer;
        return view('reports.penerimaangiroheader', compact('penerimaangiro','penerimaangiro_details','printer'));
    }

    // public function export(Request $request): void
    // {
    //     //FETCH HEADER
    //     $id = $request->id;
    //     $penerimaangiro = Http::withHeaders($request->header())
    //         ->withOptions(['verify' => false])
    //         ->withToken(session('access_token'))
    //         ->get(config('app.api_url') . 'penerimaangiroheader/'.$id.'/export')['data'];

    //     //FETCH DETAIL
    //     $detailParams = [
    //         'forReport' => true,
    //         'penerimaangiro_id' => $request->id,
    //     ];

    //     $responses = Http::withHeaders($request->header())
    //         ->withOptions(['verify' => false])
    //         ->withToken(session('access_token'))
    //         ->get(config('app.api_url') . 'penerimaangirodetail', $detailParams);
    //     $penerimaangiro_details = $responses['data'];

    //     $tglBukti = $penerimaangiro["tglbukti"];
    //     $timeStamp = strtotime($tglBukti);
    //     $dateTglBukti = date('d-m-Y', $timeStamp); 
    //     $penerimaangiro['tglbukti'] = $dateTglBukti;

    //     $spreadsheet = new Spreadsheet();
    //     $sheet = $spreadsheet->getActiveSheet();
    //     $sheet->setCellValue('A1', $penerimaangiro['judul']);
    //     $sheet->setCellValue('A2', 'Bukti Penerimaan Giro ' . $penerimaangiro['bank']);
    //     $sheet->getStyle("A1")->getFont()->setSize(12);
    //     $sheet->getStyle("A2")->getFont()->setSize(12);
    //     $sheet->getStyle("A1")->getFont()->setBold(true);
    //     $sheet->getStyle("A2")->getFont()->setBold(true);
    //     $sheet->getStyle('A1')->getAlignment()->setHorizontal('center');
    //     $sheet->getStyle('A2')->getAlignment()->setHorizontal('center');
    //     $sheet->mergeCells('A1:G1');
    //     $sheet->mergeCells('A2:G2');

    //     $header_start_row = 4;
    //     $header_right_start_row = 4;
    //     $detail_table_header_row = 8;
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
    //     ];
    //     $header_right_columns = [
    //         [
    //             'label' => 'No Warkat',
    //             'index' => 'nowarkat',
    //         ],
    //         [
    //             'label' => 'Diterima Dari',
    //             'index' => 'diterimadari',
    //         ]
    //     ];

    //     $detail_columns = [
    //         [
    //             'label' => 'NO',
    //         ],
    //         [
    //             'label' => 'NAMA PERKIRAAN',
    //             'index' => 'namacoakredit',
    //         ],
    //         [
    //             'label' => 'BANK',
    //             'index' => 'bank_id'
    //         ],
    //         [
    //             'label' => 'TANGGAL JATUH TEMPO',
    //             'index' => 'tgljatuhtempo',
    //         ],
    //         [
    //             'label' => 'NO INVOICE',
    //             'index' => 'invoice_nobukti',
    //         ],
    //         [
    //             'label' => 'KETERANGAN',
    //             'index' => 'keterangan'
    //         ],
    //         [
    //             'label' => 'NOMINAL',
    //             'index' => 'nominal',
    //             'format' => 'currency'
    //         ]
    //     ];

    //     //LOOPING HEADER        
    //     foreach ($header_columns as $header_column) {
    //         $sheet->setCellValue('B' . $header_start_row, $header_column['label']);
    //         $sheet->setCellValue('C' . $header_start_row++, ': ' . $penerimaangiro[$header_column['index']]);
    //     }
    //     foreach ($header_right_columns as $header_right_column) {
    //         $sheet->setCellValue('D' . $header_right_start_row, $header_right_column['label']);
    //         $sheet->setCellValue('E' . $header_right_start_row++, ': '.$penerimaangiro[$header_right_column['index']]);
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
    //         'alignment' => [
    //             'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT,
    //         ],

    //         'borders' => [
    //             'top' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
    //             'right' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
    //             'bottom' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
    //             'left' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN]
    //         ]
    //     ];

    //     // $sheet->getStyle("A$detail_table_header_row:G$detail_table_header_row")->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('FF1F456E');
    //     $sheet->getStyle("A$detail_table_header_row:G$detail_table_header_row")->applyFromArray($styleArray);

    //     // LOOPING DETAIL
       
    //     foreach ($penerimaangiro_details as $response_index => $response_detail) {

    //         foreach ($detail_columns as $detail_columns_index => $detail_column) {
    //             $sheet->setCellValue($alphabets[$detail_columns_index] . $detail_start_row, isset($detail_column['index']) ? $response_detail[$detail_column['index']] : $response_index + 1);
    //             $sheet->getStyle("A$detail_table_header_row:G$detail_table_header_row")->getFont()->setBold(true);
    //             $sheet->getStyle("A$detail_table_header_row:G$detail_table_header_row")->getAlignment()->setHorizontal('center');
    //         }
          
    //         $tgljatuhtempo = $response_detail["tgljatuhtempo"];
    //         $timeStamp = strtotime($tgljatuhtempo);
    //         $datetgljatuhtempo = date('d-m-Y', $timeStamp); 
    //         $response_detail['tgljatuhtempo'] = $datetgljatuhtempo;

    //         $sheet->setCellValue("A$detail_start_row", $response_index + 1);
    //         $sheet->setCellValue("B$detail_start_row", $response_detail['namacoakredit']);
    //         $sheet->setCellValue("C$detail_start_row", $response_detail['bank_id']);
    //         $sheet->setCellValue("D$detail_start_row", $response_detail['tgljatuhtempo']);
    //         $dateValue = ($response_detail['tgljatuhtempo'] != null) ? Date::PHPToExcel(date('Y-m-d',strtotime($response_detail['tgljatuhtempo']))) : ''; 
    //             $sheet->setCellValue("D$detail_start_row", $dateValue);
    //             $sheet->getStyle("D$detail_start_row") 
    //             ->getNumberFormat() 
    //             ->setFormatCode('dd-mm-yyyy');
    //         $sheet->setCellValue("E$detail_start_row", $response_detail['invoice_nobukti']);
    //         $sheet->setCellValue("F$detail_start_row", $response_detail['keterangan']);
    //         $sheet->setCellValue("G$detail_start_row", $response_detail['nominal']);

    //         $sheet->getStyle("F$detail_start_row")->getAlignment()->setWrapText(true);
    //         $sheet->getColumnDimension('F')->setWidth(50);

    //         $sheet->getStyle("A$detail_start_row:G$detail_start_row")->applyFromArray($styleArray);
    //         $sheet->getStyle("G$detail_start_row")->applyFromArray($style_number)->getNumberFormat()->setFormatCode("#,##0.00_);(#,##0.00)");

    //         $detail_start_row++;
    //     }

    //     $total_start_row = $detail_start_row;
    //     $sheet->mergeCells('A' . $total_start_row . ':F' . $total_start_row);
    //     $sheet->setCellValue("A$total_start_row", 'Total')->getStyle('A' . $total_start_row . ':F' . $total_start_row)->applyFromArray($styleArray)->getFont()->setBold(true);
    //     $sheet->setCellValue("G$detail_start_row", "=SUM(G9:G" . ($detail_start_row - 1) . ")")->getStyle("G$detail_start_row")->applyFromArray($style_number)->getFont()->setBold(true);

    //     $sheet->getStyle("G$detail_start_row")->getNumberFormat()->setFormatCode("#,##0.00_);(#,##0.00)");
    //     $sheet->getColumnDimension('A')->setAutoSize(true);
    //     $sheet->getColumnDimension('B')->setAutoSize(true);
    //     $sheet->getColumnDimension('C')->setAutoSize(true);
    //     $sheet->getColumnDimension('D')->setAutoSize(true);
    //     $sheet->getColumnDimension('E')->setAutoSize(true);
    //     $sheet->getColumnDimension('G')->setAutoSize(true);

    //     $writer = new Xlsx($spreadsheet);
    //     $filename = 'Laporan Penerimaan Giro ' .$penerimaangiro['bank'] . date('dmYHis');
    //     header('Content-Type: application/vnd.ms-excel');
    //     header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
    //     header('Cache-Control: max-age=0');

    //     $writer->save('php://output');
    // }
}

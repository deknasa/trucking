<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class OpnameHeaderController extends MyController
{
    public $title = 'Opname';

    public function index(Request $request)
    {
        $title = $this->title;
        $data = [
            'combocetak' => $this->comboapproval('list', 'STATUS CETAK', 'STATUS CETAK'),
        ];

        return view('opname.index', compact('title', 'data'));
    }

    public function comboapproval($aksi, $grp, $subgrp)
    {
        $status = [
            'status' => $aksi,
            'grp' => $grp,
            'subgrp' => $subgrp,
        ];

        $response = Http::withHeaders($this->httpHeaders)
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'invoiceheader/comboapproval', $status);

        return $response['data'];
    }
    
    public function report(Request $request)
    {
        //FETCH HEADER
        $id = $request->id;
        $opname = Http::withHeaders($request->header())
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'opnameheader/'.$id.'/export')['data'];

        //FETCH DETAIL
        $detailParams = [
            'opname_id' => $request->id,
        ];
        $opname_details = Http::withHeaders($request->header())
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
        ->get(config('app.api_url') . 'opnameheader/'.$id.'/getEdit')['data'];

        $combo = $this->combo('list');
        $key = array_search('CETAK', array_column( $combo, 'parameter')); 
        $opname["combo"] =  $combo[$key];
        $report = $request->report;
        return view('reports.opname', compact('opname','opname_details','report'));
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

    public function export(Request $request): void
    {
        $jenis = 'bukti';
        if ($request->export =="stokBanding") {
            $jenis = 'banding';
        }
        if ($request->export == "stokOpname") {
            $jenis = 'opname';
        }
        //FETCH HEADER
        $id = $request->id;
        $opname = Http::withHeaders($request->header())
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'opnameheader/'.$id.'/export')['data'];

        //FETCH DETAIL
        $opname_details = Http::withHeaders($request->header())
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'opnameheader/'.$id.'/getEdit')['data'];

        // dd($opname_details);
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', $opname['judul']);
        $sheet->setCellValue('A2', $opname['judulLaporan']);
        $sheet->getStyle("A1")->getFont()->setSize(12);
        $sheet->getStyle("A2")->getFont()->setSize(12);
        $sheet->getStyle("A1")->getFont()->setBold(true);
        $sheet->getStyle("A2")->getFont()->setBold(true);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal('center');
        $sheet->getStyle('A2')->getAlignment()->setHorizontal('center');
       
        if ($jenis =="banding") {
            $sheet->mergeCells('A1:E1');
            $sheet->mergeCells('A2:E2');
        }else {
            $sheet->mergeCells('A1:D1');
            $sheet->mergeCells('A2:D2');
        }

        $header_start_row = 4;
        $header_right_start_row = 4;
        $detail_table_header_row = 10;
        $detail_start_row = $detail_table_header_row + 1;

        $alphabets = range('A', 'Z');

        $header_columns = [
            [
                'label' => 'No Bukti',
                'index' => 'nobukti',
            ],
            [
                'label' => 'Tanggal',
                'index' => 'tglbukti',
            ],
            [
                'label' => 'Gudang',
                'index' => 'gudang',
            ],
            [
                'label' => 'Kelompok',
                'index' => 'kelompok',
            ],
            [
                'label' => 'Keterangan',
                'index' => 'keterangan',
            ],
        ];

        if ($jenis == "banding") {
            $detail_columns = [
                [
                    'label' => 'No',
                ],
                [
                    'label' => 'Nama Stok',
                    'index' => 'namabarang',
                ],
                [
                    'label' => 'Tanggal Bukti Masuk',
                    'index' => 'tanggal',
                ],
                [
                    'label' => 'Qty',
                    'index' => 'qty',
                    'format' => 'currency'
                ],
                [
                    'label' => 'Qty Fisik',
                    'index' => 'qtyfisik',
                    'format' => 'currency'
                ],
                [
                    'label' => 'Selisih',
                    'index' => 'selisih',
                    'format' => 'currency'
                ]
            ];
        }else{
            $detail_columns = [
                [
                    'label' => 'No',
                ],
                [
                    'label' => 'Nama Stok',
                    'index' => 'namabarang',
                ],
                [
                    'label' => 'Tanggal Bukti Masuk',
                    'index' => 'tanggal',
                ],
                [
                    'label' => 'Qty Fisik',
                    'index' => 'qtyfisik',
                    'format' => 'currency'
                ]
            ];
        }

        //LOOPING HEADER        
        foreach ($header_columns as $header_column) {
            $sheet->setCellValue('B' . $header_start_row, $header_column['label']);
            $sheet->setCellValue('C' . $header_start_row++, ': ' . $opname[$header_column['index']]);
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

        if ($jenis =="banding") {
            $sheet->getStyle("A$detail_table_header_row:F$detail_table_header_row")->applyFromArray($styleArray);
        }else {
            $sheet->getStyle("A$detail_table_header_row:D$detail_table_header_row")->applyFromArray($styleArray);
        }

        // LOOPING DETAIL
        $total = 0;
        foreach ($opname_details as $response_index => $response_detail) {

            foreach ($detail_columns as $detail_columns_index => $detail_column) {
                $sheet->setCellValue($alphabets[$detail_columns_index] . $detail_start_row, isset($detail_column['index']) ? $response_detail[$detail_column['index']] : $response_index + 1);
                if ($jenis == "banding") {
                    $sheet->getStyle("A$detail_table_header_row:F$detail_table_header_row")->getFont()->setBold(true);
                    $sheet->getStyle("A$detail_table_header_row:F$detail_table_header_row")->getAlignment()->setHorizontal('center');
                }else{
                    $sheet->getStyle("A$detail_table_header_row:D$detail_table_header_row")->getFont()->setBold(true);
                    $sheet->getStyle("A$detail_table_header_row:D$detail_table_header_row")->getAlignment()->setHorizontal('center');
                }
            }

            $sheet->setCellValue("A$detail_start_row", $response_index + 1);
            $sheet->setCellValue("B$detail_start_row", $response_detail['namabarang']);
            
            $dateValue = ($response_detail['tanggal'] != null) ? Date::PHPToExcel(date('Y-m-d',strtotime($response_detail['tanggal']))) : ''; 
            $sheet->setCellValue("C$detail_start_row", $dateValue);
            $sheet->getStyle("C$detail_start_row") 
            ->getNumberFormat() 
            ->setFormatCode('dd-mm-yyyy');

            // $sheet->setCellValue("C$detail_start_row", $response_detail['tanggal']);
            if ($jenis =="banding") {
                $sheet->setCellValue("D$detail_start_row", $response_detail['qty']);
                $sheet->setCellValue("E$detail_start_row", $response_detail['qtyfisik']);
                $sheet->setCellValue("F$detail_start_row", "=D$detail_start_row - E$detail_start_row");
            }else if($jenis == 'opname'){
                $sheet->setCellValue("D$detail_start_row", null);
            }else{
                $sheet->setCellValue("D$detail_start_row", $response_detail['qtyfisik']);
            }
            $sheet->getStyle("B$detail_start_row")->getAlignment()->setWrapText(true);
            $sheet->getColumnDimension('B')->setWidth(60);

            $sheet->getStyle("A$detail_start_row:C$detail_start_row")->applyFromArray($styleArray);
            $sheet->getStyle("D$detail_start_row")->applyFromArray($style_number)->getNumberFormat()->setFormatCode("#,##0.00_);(#,##0.00)");
            if ($jenis =="banding") {
                $sheet->getStyle("E$detail_start_row")->applyFromArray($style_number)->getNumberFormat()->setFormatCode("#,##0.00_);(#,##0.00)");
                $sheet->getStyle("F$detail_start_row")->applyFromArray($style_number)->getNumberFormat()->setFormatCode("#,##0.00_);(#,##0.00)");
            }
            $detail_start_row++;
        }

        $sheet->getColumnDimension('A')->setAutoSize(true);
        $sheet->getColumnDimension('C')->setAutoSize(true);
        $sheet->getColumnDimension('D')->setAutoSize(true);
        if ($jenis =="banding") {
            $sheet->getColumnDimension('E')->setAutoSize(true);
            $sheet->getColumnDimension('F')->setAutoSize(true);
        }

        $writer = new Xlsx($spreadsheet);
        $filename = 'Laporan Opname' . date('dmYHis');
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }
}

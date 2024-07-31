<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class PelunasanHutangHeaderController extends MyController
{
    public $title = 'Pelunasan Hutang';

    public function index(Request $request)
    {
        $title = $this->title;
        $data = [
            'comboapproval' => $this->comboList('list','STATUS APPROVAL','STATUS APPROVAL'),
            'combocetak' => $this->comboList('list','STATUSCETAK','STATUSCETAK'),
            'listbtn' => $this->getListBtn()
        ];
        $data = array_merge(compact('title','data'),
            ["request"=>$request->all()]
        );
        return view('pelunasanhutangheader.index',$data  );
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
        $pelunasanhutang = Http::withHeaders($request->header())
        ->withOptions(['verify' => false])
        ->withToken(session('access_token'))
        ->get(config('app.api_url') .'pelunasanhutangheader/'.$id.'/export')['data'];

        //FETCH DETAIL
        $detailParams = [
            'forReport' => true,
            'PelunasanHutang_id' => $id,
        ];
        $pelunasanhutang_details = Http::withHeaders($request->header())
        ->withOptions(['verify' => false])
        ->withToken(session('access_token'))
        ->get(config('app.api_url') .'pelunasanhutangdetail', $detailParams)['data'];

        $combo = $this->combo('list');
        $key = array_search('CETAK', array_column( $combo, 'parameter')); 
        $pelunasanhutang["combo"] =  $combo[$key];
        $printer['tipe'] = $request->printer;
        return view('reports.pelunasanhutang', compact('pelunasanhutang','pelunasanhutang_details','printer'));
    }

    public function export(Request $request): void
    {
        //FETCH HEADER
        $id = $request->id;
        $pelunasanhutang = Http::withHeaders($request->header())
        ->withOptions(['verify' => false])
        ->withToken(session('access_token'))
        ->get(config('app.api_url') .'pelunasanhutangheader/'.$id.'/export')['data'];

        //FETCH DETAIL
        $detailParams = [
            'forReport' => true,
            'PelunasanHutang_id' => $id,
        ];
        $pelunasanhutang_details = Http::withHeaders($request->header())
        ->withOptions(['verify' => false])
        ->withToken(session('access_token'))
        ->get(config('app.api_url') .'pelunasanhutangdetail', $detailParams)['data'];

        $tglBukti = $pelunasanhutang["tglbukti"];
        $timeStamp = strtotime($tglBukti);
        $dateTglBukti = date('d-m-Y', $timeStamp); 
        $pelunasanhutang['tglbukti'] = $dateTglBukti;

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', $pelunasanhutang['judul']);
        $sheet->setCellValue('A2', $pelunasanhutang['judulLaporan']);
        $sheet->getStyle("A1")->getFont()->setSize(12);
        $sheet->getStyle("A2")->getFont()->setSize(12);
        $sheet->getStyle("A1")->getFont()->setBold(true);
        $sheet->getStyle("A2")->getFont()->setBold(true);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal('center');
        $sheet->getStyle('A2')->getAlignment()->setHorizontal('center');
        $sheet->mergeCells('A1:H1');
        $sheet->mergeCells('A2:H2');

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
                'label' => 'Tanggal',
                'index' => 'tglbukti',
            ],
            [
                'label' => 'Supplier', 
                'index' => 'supplier_id',
            ]
        ];

        $detail_columns = [
            [
                'label' => 'NO',
            ],
            [
                'label' => 'NO BUKTI HUTANG',
                'index' => 'hutang_nobukti',
            ],
            [
                'label' => 'NO SPB / HUTANG EXTRA',
                'index' => 'spb_nobukti',
            ],
            [
                'label' => 'NOMINAL HUTANG',
                'index' => 'nominalhutang',
                'format' => 'currency'
            ],
            [
                'label' => 'NOMINALBAYAR',
                'index' => 'nominaLbayar',
                'format' => 'currency'
            ],
            [
                'label' => 'DISKON',
                'index' => 'diskon',
                'format' => 'currency'
            ],
            [
                'label' => 'KETERANGAN DISKON',
                'index' => 'keterangandiskon',
            ],
            [
                'label' => 'SISA PIUTANG',
                'index' => 'sisahutang',
                'format' => 'currency'
            ],
            
        ];

       //LOOPING HEADER        
       foreach ($header_columns as $header_column) {
        $sheet->setCellValue('B' . $header_start_row, $header_column['label']);
        $sheet->setCellValue('C' . $header_start_row++, ': '.$pelunasanhutang[$header_column['index']]);
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

        // // $sheet->getStyle("A$detail_table_header_row:G$detail_table_header_row")->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('FF1F456E');
        $sheet ->getStyle("A$detail_table_header_row:H$detail_table_header_row")->applyFromArray($styleArray);

       // LOOPING DETAIL
       $nominalbayar = 0;
       foreach ($pelunasanhutang_details as $response_index => $response_detail) {
           
           foreach ($detail_columns as $detail_columns_index => $detail_column) {
               $sheet->setCellValue($alphabets[$detail_columns_index] . $detail_start_row, isset($detail_column['index']) ? $response_detail[$detail_column['index']] : $response_index + 1);
               $sheet->getStyle("A$detail_table_header_row:H$detail_table_header_row")->getFont()->setBold(true);
               $sheet->getStyle("A$detail_table_header_row:H$detail_table_header_row")->getAlignment()->setHorizontal('center');
            }
          
           $sheet->setCellValue("A$detail_start_row", $response_index + 1);
           $sheet->setCellValue("B$detail_start_row", $response_detail['hutang_nobukti']);
           $sheet->setCellValue("C$detail_start_row", $response_detail['spb_nobukti']);
           $sheet->setCellValue("D$detail_start_row", $response_detail['nominalhutang']);
           $sheet->setCellValue("E$detail_start_row", $response_detail['nominaLbayar']);
           $sheet->setCellValue("F$detail_start_row", $response_detail['diskon']);
           $sheet->setCellValue("G$detail_start_row", $response_detail['keterangandiskon']);
           $sheet->setCellValue("H$detail_start_row", $response_detail['sisahutang']);

           $sheet->getStyle("G$detail_start_row")->getAlignment()->setWrapText(true);
           $sheet->getColumnDimension('G')->setWidth(50);
           $sheet->getStyle("D$detail_start_row:F$detail_start_row")->applyFromArray($style_number)->getNumberFormat()->setFormatCode("#,##0.00_);(#,##0.00)");
           $sheet->getStyle("H$detail_start_row")->applyFromArray($style_number)->getNumberFormat()->setFormatCode("#,##0.00_);(#,##0.00)");

           $sheet ->getStyle("A$detail_start_row:H$detail_start_row")->applyFromArray($styleArray);
           $sheet ->getStyle("D$detail_start_row:F$detail_start_row")->applyFromArray($style_number);
           $sheet ->getStyle("H$detail_start_row")->applyFromArray($style_number);

           $nominalbayar += $response_detail['nominaLbayar'];
           $detail_start_row++;
       }

       $total_start_row = $detail_start_row;
       $sheet->mergeCells('A'.$total_start_row.':D'.$total_start_row);
       $sheet->setCellValue("A$total_start_row", 'Total')->getStyle('A'.$total_start_row.':D'.$total_start_row)->applyFromArray($styleArray)->getFont()->setBold(true);
       $sheet->setCellValue("E$total_start_row", "=SUM(E9:E" . ($detail_start_row-1) . ")")->getStyle("E$total_start_row")->applyFromArray($style_number)->getFont()->setBold(true);
       $sheet->getStyle("E$total_start_row")->getNumberFormat()->setFormatCode("#,##0.00_);(#,##0.00)");
       
       $sheet ->getStyle("F$detail_start_row:H$detail_start_row")->applyFromArray($styleArray);        

       $sheet->getColumnDimension('A')->setAutoSize(true);
       $sheet->getColumnDimension('B')->setAutoSize(true);
       $sheet->getColumnDimension('C')->setAutoSize(true);
       $sheet->getColumnDimension('D')->setAutoSize(true);
       $sheet->getColumnDimension('E')->setAutoSize(true);
       $sheet->getColumnDimension('F')->setAutoSize(true);
       $sheet->getColumnDimension('H')->setAutoSize(true);

       $writer = new Xlsx($spreadsheet);
       $filename = 'Laporan Pelunasan Hutang' . date('dmYHis');
       header('Content-Type: application/vnd.ms-excel');
       header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
       header('Cache-Control: max-age=0');

       $writer->save('php://output');
   }
}

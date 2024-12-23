<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class HutangBayarHeaderController extends MyController
{
    public $title = 'Pembayaran Hutang';

    public function index(Request $request)
    {
        $title = $this->title;
        $data = [
            'comboapproval' => $this->comboList('list','STATUS APPROVAL','STATUS APPROVAL'),
            'combocetak' => $this->comboList('list','STATUSCETAK','STATUSCETAK'),
        ];
        $data = array_merge(compact('title','data'),
            ["request"=>$request->all()]
        );
        return view('hutangbayarheader.index',$data  );
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
            ->get(config('app.api_url') . 'hutangbayarheader', $params);

        $data = [
            'total' => $response['attributes']['totalPages'] ?? [],
            'records' => $response['attributes']['totalRows'] ?? [],
            'rows' => $response['data'] ?? [],
            'params' => $response['params'] ?? [],
        ];

        return $data;
    }

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
        $hutangbayar = Http::withHeaders($request->header())
        ->withOptions(['verify' => false])
        ->withToken(session('access_token'))
        ->get(config('app.api_url') .'hutangbayarheader/'.$id.'/export')['data'];

        //FETCH DETAIL
        $detailParams = [
            'forReport' => true,
            'hutangbayar_id' => $id,
        ];
        $hutangbayar_details = Http::withHeaders($request->header())
        ->withOptions(['verify' => false])
        ->withToken(session('access_token'))
        ->get(config('app.api_url') .'hutangbayardetail', $detailParams)['data'];

        $combo = $this->combo('list');
        $key = array_search('CETAK', array_column( $combo, 'parameter')); 
        $hutangbayar["combo"] =  $combo[$key];
        return view('reports.hutangbayar', compact('hutangbayar','hutangbayar_details'));
    }

    public function export(Request $request): void
    {
        //FETCH HEADER
        $id = $request->id;
        $hutangbayar = Http::withHeaders($request->header())
        ->withOptions(['verify' => false])
        ->withToken(session('access_token'))
        ->get(config('app.api_url') .'hutangbayarheader/'.$id.'/export')['data'];

        //FETCH DETAIL
        $detailParams = [
            'forReport' => true,
            'hutangbayar_id' => $id,
        ];
        $hutangbayar_details = Http::withHeaders($request->header())
        ->withOptions(['verify' => false])
        ->withToken(session('access_token'))
        ->get(config('app.api_url') .'hutangbayardetail', $detailParams)['data'];

        $tglBukti = $hutangbayar["tglbukti"];
        $timeStamp = strtotime($tglBukti);
        $dateTglBukti = date('d-m-Y', $timeStamp); 
        $hutangbayar['tglbukti'] = $dateTglBukti;

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', $hutangbayar['judul']);
        $sheet->setCellValue('A2', $hutangbayar['judulLaporan']);
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
        $sheet->setCellValue('C' . $header_start_row++, ': '.$hutangbayar[$header_column['index']]);
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
       foreach ($hutangbayar_details as $response_index => $response_detail) {
           
           foreach ($detail_columns as $detail_columns_index => $detail_column) {
               $sheet->setCellValue($alphabets[$detail_columns_index] . $detail_start_row, isset($detail_column['index']) ? $response_detail[$detail_column['index']] : $response_index + 1);
               $sheet->getStyle("A$detail_table_header_row:H$detail_table_header_row")->getFont()->setBold(true);
               $sheet->getStyle("A$detail_table_header_row:H$detail_table_header_row")->getAlignment()->setHorizontal('center');
            }
           $response_detail['nominalhutangs'] = number_format((float) $response_detail['nominalhutang'], '2', '.', ',');
           $response_detail['nominaLbayars'] = number_format((float) $response_detail['nominaLbayar'], '2', '.', ',');
           $response_detail['diskons'] = number_format((float) $response_detail['diskon'], '2', '.', ',');
           $response_detail['sisahutangs'] = number_format((float) $response_detail['sisahutang'], '2', '.', ',');
           
           $sheet->setCellValue("A$detail_start_row", $response_index + 1);
           $sheet->setCellValue("B$detail_start_row", $response_detail['hutang_nobukti']);
           $sheet->setCellValue("C$detail_start_row", $response_detail['spb_nobukti']);
           $sheet->setCellValue("D$detail_start_row", $response_detail['nominalhutangs']);
           $sheet->setCellValue("E$detail_start_row", $response_detail['nominaLbayars']);
           $sheet->setCellValue("F$detail_start_row", $response_detail['diskons']);
           $sheet->setCellValue("G$detail_start_row", $response_detail['keterangandiskon']);
           $sheet->setCellValue("H$detail_start_row", $response_detail['sisahutangs']);

           $sheet->getStyle("G$detail_start_row")->getAlignment()->setWrapText(true);
           $sheet->getColumnDimension('G')->setWidth(50);

           $sheet ->getStyle("A$detail_start_row:H$detail_start_row")->applyFromArray($styleArray);
           $sheet ->getStyle("D$detail_start_row:F$detail_start_row")->applyFromArray($style_number);
           $sheet ->getStyle("H$detail_start_row")->applyFromArray($style_number);

           $nominalbayar += $response_detail['nominaLbayar'];
           $detail_start_row++;
       }

       $total_start_row = $detail_start_row;
       $sheet->mergeCells('A'.$total_start_row.':D'.$total_start_row);
       $sheet->setCellValue("A$total_start_row", 'Total')->getStyle('A'.$total_start_row.':D'.$total_start_row)->applyFromArray($styleArray)->getFont()->setBold(true);
       $sheet->setCellValue("E$total_start_row", number_format((float) $nominalbayar, '2', '.', ','))->getStyle("E$detail_start_row")->applyFromArray($style_number)->getFont()->setBold(true);

       $sheet->getColumnDimension('A')->setAutoSize(true);
       $sheet->getColumnDimension('B')->setAutoSize(true);
       $sheet->getColumnDimension('C')->setAutoSize(true);
       $sheet->getColumnDimension('D')->setAutoSize(true);
       $sheet->getColumnDimension('E')->setAutoSize(true);
       $sheet->getColumnDimension('F')->setAutoSize(true);
       $sheet->getColumnDimension('H')->setAutoSize(true);

       $writer = new Xlsx($spreadsheet);
       $filename = 'Laporan Pembayaran Hutang' . date('dmYHis');
       header('Content-Type: application/vnd.ms-excel');
       header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
       header('Cache-Control: max-age=0');

       $writer->save('php://output');
   }
    
}

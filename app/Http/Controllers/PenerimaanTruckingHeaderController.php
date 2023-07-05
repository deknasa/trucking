<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class PenerimaanTruckingHeaderController extends MyController
{
    public $title = 'Penerimaan Trucking';
    
    public function index(Request $request)
    {
        $title = $this->title;
        $data = [
            'combocetak' => $this->comboList('list','STATUSCETAK','STATUSCETAK')
        ];
        $comboKodepenerimaan = $this->comboKodepenerimaan();

        return view('penerimaantruckingheader.index', compact('title','data','comboKodepenerimaan'));
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
            ->get(config('app.api_url') . 'penerimaantruckingheader', $params);

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
    public function comboKodepenerimaan()
    {
        $response = Http::withHeaders($this->httpHeaders)
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'penerimaantrucking');

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
        $penerimaantrucking = Http::withHeaders($request->header())
        ->withOptions(['verify' => false])
        ->withToken(session('access_token'))
        ->get(config('app.api_url') .'penerimaantruckingheader/'.$id.'/export')['data'];

        //FETCH DETAIL
        $detailParams = [
            'forReport' => true,
            'penerimaantruckingheader_id' => $request->id,
        ];
        $penerimaantrucking_details = Http::withHeaders($request->header())
        ->withOptions(['verify' => false])
        ->withToken(session('access_token'))
        ->get(config('app.api_url') .'penerimaantruckingdetail', $detailParams)['data'];

        $combo = $this->combo('list');
        $key = array_search('CETAK', array_column( $combo, 'parameter')); 
        $penerimaantrucking["combo"] =  $combo[$key];
        return view('reports.penerimaantruckingheader', compact('penerimaantrucking','penerimaantrucking_details'));
    }

    public function export(Request $request): void
    {
        //FETCH HEADER
        $id = $request->id;
        $penerimaantrucking = Http::withHeaders($request->header())
        ->withOptions(['verify' => false])
        ->withToken(session('access_token'))
        ->get(config('app.api_url') .'penerimaantruckingheader/'.$id.'/export')['data'];

        //FETCH DETAIL
        $detailParams = [
            'penerimaantruckingheader_id' => $request->id,
        ];

        $penerimaantrucking_details = Http::withHeaders($request->header())
        ->withOptions(['verify' => false])
        ->withToken(session('access_token'))
        ->get(config('app.api_url') .'penerimaantruckingdetail', $detailParams)['data'];

        $tglBukti = $penerimaantrucking["tglbukti"];
        $timeStamp = strtotime($tglBukti);
        $dateTglBukti = date('d-m-Y', $timeStamp); 
        $penerimaantrucking['tglbukti'] = $dateTglBukti;

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', $penerimaantrucking['judul']);
        $sheet->setCellValue('A2', $penerimaantrucking['judulLaporan']);
        $sheet->getStyle("A1")->getFont()->setSize(12);
        $sheet->getStyle("A2")->getFont()->setSize(12);
        $sheet->getStyle("A1")->getFont()->setBold(true);
        $sheet->getStyle("A2")->getFont()->setBold(true);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal('center');
        $sheet->getStyle('A2')->getAlignment()->setHorizontal('center');
        $sheet->mergeCells('A1:E1');
        $sheet->mergeCells('A2:E2');

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
                'label' => 'No Bukti Penerimaan',
                'index' => 'penerimaan_nobukti',
            ],
            
        ];
        $header_right_columns = [
            [
                'label' => 'Penerimaan Trucking',
                'index' => 'penerimaantrucking_id',
            ],
            [
                'label' => 'Bank',
                'index' => 'bank_id',
            ],
            [
                'label' => 'Nama Perkiraan',
                'index' => 'coa',
            ],
        ];

        $detail_columns = [
            [
                'label' => 'NO',
            ],
            [
                'label' => 'NO BUKTI PENGELUARAN TRUCKING',
                'index' => 'pengeluarantruckingheader_nobukti',
            ],
            [
                'label' => 'SUPIR',
                'index' => 'supir_id',
            ],
            [
                'label' => 'KETERANGAN',
                'index' => 'keterangan'
            ],
            [
                'label' => 'NOMINAL',
                'index' => 'nominal',
                'format' => 'currency'
            ]
        ];

        //LOOPING HEADER        
        foreach ($header_columns as $header_column) {
            $sheet->setCellValue('B' . $header_start_row, $header_column['label']);
            $sheet->setCellValue('C' . $header_start_row++, ': '.$penerimaantrucking[$header_column['index']]);
        }
        foreach ($header_right_columns as $header_right_column) {
            $sheet->setCellValue('D' . $header_right_start_row, $header_right_column['label']);
            $sheet->setCellValue('E' . $header_right_start_row++, ': '.$penerimaantrucking[$header_right_column['index']]);
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
        $sheet ->getStyle("A$detail_table_header_row:E$detail_table_header_row")->applyFromArray($styleArray);

       // LOOPING DETAIL
       $nominal = 0;
       foreach ($penerimaantrucking_details as $response_index => $response_detail) {
           
           foreach ($detail_columns as $detail_columns_index => $detail_column) {
               $sheet->setCellValue($alphabets[$detail_columns_index] . $detail_start_row, isset($detail_column['index']) ? $response_detail[$detail_column['index']] : $response_index + 1);
               $sheet->getStyle("A$detail_table_header_row:E$detail_table_header_row")->getFont()->setBold(true);
               $sheet->getStyle("A$detail_table_header_row:E$detail_table_header_row")->getAlignment()->setHorizontal('center');
           }
           $response_detail['nominals'] = number_format((float) $response_detail['nominal'], '2', '.', ',');
       
           $sheet->setCellValue("A$detail_start_row", $response_index + 1);    
           $sheet->setCellValue("B$detail_start_row", $response_detail['pengeluarantruckingheader_nobukti']);
           $sheet->setCellValue("C$detail_start_row", $response_detail['supir_id']);
           $sheet->setCellValue("D$detail_start_row", $response_detail['keterangan']);
           $sheet->setCellValue("E$detail_start_row", $response_detail['nominals']);

           $sheet->getStyle("D$detail_start_row")->getAlignment()->setWrapText(true);
            $sheet->getColumnDimension('D')->setWidth(50);

           $sheet ->getStyle("A$detail_start_row:D$detail_start_row")->applyFromArray($styleArray);
           $sheet ->getStyle("E$detail_start_row")->applyFromArray($style_number);

           $nominal += $response_detail['nominal'];
           $detail_start_row++;
       }

        $total_start_row = $detail_start_row;
        $sheet->mergeCells('A'.$total_start_row.':D'.$total_start_row);
        $sheet->setCellValue("A$total_start_row", 'Total')->getStyle('A'.$total_start_row.':D'.$total_start_row)->applyFromArray($styleArray)->getFont()->setBold(true);
        $sheet->setCellValue("E$total_start_row", number_format((float) $nominal, '2', '.', ','))->getStyle("E$detail_start_row")->applyFromArray($style_number)->getFont()->setBold(true);

        $sheet->getColumnDimension('A')->setAutoSize(true);
        $sheet->getColumnDimension('B')->setAutoSize(true);
        $sheet->getColumnDimension('C')->setAutoSize(true);
        $sheet->getColumnDimension('E')->setAutoSize(true);

        $writer = new Xlsx($spreadsheet);
        $filename = 'Laporan Penerimaan Trucking ' . date('dmYHis');
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
        header('Cache-Control: max-age=0');
        $writer->save('php://output');
    }

}
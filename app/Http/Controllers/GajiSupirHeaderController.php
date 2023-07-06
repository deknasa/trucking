<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class GajiSupirHeaderController extends MyController
{
    public $title = 'Rincian Gaji Supir';
    
    public function index(Request $request)
    {
        $title = $this->title;
        $data = [
            'combocetak' => $this->comboList('list','STATUSCETAK','STATUSCETAK')
        ];
        return view('gajisupirheader.index', compact('title','data'));
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
            ->get(config('app.api_url') . 'gajisupirheader', $params);

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
        $gajisupir = Http::withHeaders($request->header())
        ->withOptions(['verify' => false])
        ->withToken(session('access_token'))
        ->get(config('app.api_url') .'gajisupirheader/'.$id.'/export')['data'];

        //FETCH DETAIL
        $detailParams = [
            'forReport' => true,
            'gajisupir_id' => $request->id,
            'sortIndex' => 'suratpengantar_nobukti'
        ];

        $gajisupir_details = Http::withHeaders(request()->header())
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'gajisupirdetail', $detailParams)['data'];
        
        $combo = $this->combo('list');
        $key = array_search('CETAK', array_column( $combo, 'parameter')); 
        $gajisupir["combo"] =  $combo[$key];

        return view('reports.gajisupir', compact('gajisupir','gajisupir_details'));
    }

    public function export(Request $request): void
    {
        //FETCH HEADER
        $id = $request->id;
        $data = Http::withHeaders($request->header())
        ->withOptions(['verify' => false])
        ->withToken(session('access_token'))
        ->get(config('app.api_url') .'gajisupirheader/'.$id.'/export');

        //FETCH DETAIL
        $detailParams = [
            'gajisupir_id' => $request->id,
            'sortIndex' => 'suratpengantar_nobukti'
        ];
        $data_details = Http::withHeaders($request->header())
        ->withOptions(['verify' => false])
        ->withToken(session('access_token'))
        ->get(config('app.api_url') .'gajisupirdetail', $detailParams);

        $gajisupirs = $data['data'];
        $gajisupir_details = $data_details['data'];
        //$user = Auth::user();
        // dd($gajisupirs);

        $tglBukti = $gajisupirs["tglbukti"];
        $timeStamp = strtotime($tglBukti);
        $dateTglBukti = date('d-m-Y', $timeStamp); 
        $gajisupirs['tglbukti'] = $dateTglBukti;

        $tglDari = $gajisupirs["tgldari"];
        $timeStamp = strtotime($tglDari);
        $dateTglDari = date('d-m-Y', $timeStamp); 
        $gajisupirs['tgldari'] = $dateTglDari;

        $tglSampai = $gajisupirs["tglsampai"];
        $timeStamp = strtotime($tglSampai);
        $dateTglSampai = date('d-m-Y', $timeStamp); 
        $gajisupirs['tglsampai'] = $dateTglSampai;

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', $gajisupirs['judul']);
        $sheet->setCellValue('A2', $gajisupirs['judulLaporan']);
        $sheet->getStyle("A1")->getFont()->setSize(12);
        $sheet->getStyle("A2")->getFont()->setSize(12);
        $sheet->getStyle("A1")->getFont()->setBold(true);
        $sheet->getStyle("A2")->getFont()->setBold(true);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal('center');
        $sheet->getStyle('A2')->getAlignment()->setHorizontal('center');
        $sheet->mergeCells('A1:P1');
        $sheet->mergeCells('A2:P2');

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
                'label' => 'Supir',
                'index' => 'supir_id',
            ]
        ];
        $header_right_columns = [
            [
                'label' => 'Tanggal Dari',
                'index' => 'tgldari',
            ],
            [
                'label' => 'Tanggal Sampai',
                'index' => 'tglsampai',
            ]
        ];

        $detail_columns = [
            [
                'label' => 'NO',
            ],
            [
                'label' => 'NO TRIP',
                'index' => 'nobukti',
            ],
            [
                'label' => 'TANGGAL BON',
                'index' => 'tglsp',
            ],
            [
                'label' => 'DARI',
                'index' => 'dari',
            ],
            [
                'label' => 'SAMPAI',
                'index' => 'sampai',
            ],
            [
                'label' => 'NO CONT',
                'index' => 'nocont',
            ],
            [
                'label' => 'NO SP',
                'index' => 'nosp',
            ],
            [
                'label' => 'STATUS RITASI',
                'index' => 'statusritasi',
            ],
            [
                'label' => 'NO BUKTI RITASI',
                'index' => 'ritasi_nobukti',
            ],
            [
                'label' => 'KET. BIAYA EXTRA',
                'index' => 'keteranganbiayatambahan',
            ],
            [
                'label' => 'BIAYA EXTRA',
                'index' => 'biayaextra',
                'format' => 'currency'
            ],
            [
                'label' => 'GAJI KENEK',
                'index' => 'gajikenek',
                'format' => 'currency'
            ],
            [
                'label' => 'KOMISI SUPIR',
                'index' => 'komisisupir',
                'format' => 'currency'
            ],
            [
                'label' => 'UPAH RITASI',
                'index' => 'upahritasi',
                'format' => 'currency'
            ],
            [
                'label' => 'TOL SUPIR',
                'index' => 'tolsupir',
                'format' => 'currency'
            ],
            [
                'label' => 'GAJI SUPIR',
                'index' => 'gajisupir',
                'format' => 'currency'
            ]
        ];

        //LOOPING HEADER   
        foreach ($header_columns as $header_column) {
            $sheet->setCellValue('B' . $header_start_row, $header_column['label']);
            $sheet->setCellValue('C' . $header_start_row++, ': '.$gajisupirs[$header_column['index']]);
        }
        foreach ($header_right_columns as $header_right_column) {
            $sheet->setCellValue('D' . $header_right_start_row, $header_right_column['label']);
            $sheet->setCellValue('E' . $header_right_start_row++, ': '.$gajisupirs[$header_right_column['index']]);
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
				'allBorders' => array(
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ),
			]
        ];

        // $sheet->getStyle("A$detail_table_header_row:G$detail_table_header_row")->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('FF1F456E');
        $sheet ->getStyle("A$detail_table_header_row:P$detail_table_header_row")->applyFromArray($styleArray);

        // LOOPING DETAIL
        $gajisupir = 0;
        foreach ($gajisupir_details as $response_index => $response_detail) {
            
            foreach ($detail_columns as $detail_columns_index => $detail_column) {
                $sheet->setCellValue($alphabets[$detail_columns_index] . $detail_start_row, isset($detail_column['index']) ? $response_detail[$detail_column['index']] : $response_index + 1);
                $sheet->getStyle("A$detail_table_header_row:P$detail_table_header_row")->getFont()->setBold(true);
                $sheet->getStyle("A$detail_table_header_row:P$detail_table_header_row")->getAlignment()->setHorizontal('center');
            }
            $response_detail['gajisupirs'] = number_format((float) $response_detail['gajisupir'], '2', '.', ',');
            $response_detail['gajikeneks'] = number_format((float) $response_detail['gajikenek'], '2', '.', ',');
            $response_detail['komisisupirs'] = number_format((float) $response_detail['komisisupir'], '2', '.', ',');
            $response_detail['tolsupirs'] = number_format((float) $response_detail['tolsupir'], '2', '.', ',');
            $response_detail['upahritasis'] = number_format((float) $response_detail['upahritasi'], '2', '.', ',');
            $response_detail['biayaextras'] = number_format((float) $response_detail['biayaextra'], '2', '.', ',');

            $tglBon = $response_detail["tglsp"];
            $timeStamp = strtotime($tglBon);
            $datetglBon = date('d-m-Y', $timeStamp); 
            $response_detail['tglsp'] = $datetglBon;
        
            $sheet->setCellValue("A$detail_start_row", $response_index + 1);
            $sheet->setCellValue("B$detail_start_row", $response_detail['nobukti']);
            $sheet->setCellValue("C$detail_start_row", $response_detail['tglsp']);
            $sheet->setCellValue("D$detail_start_row", $response_detail['dari']);
            $sheet->setCellValue("E$detail_start_row", $response_detail['sampai']);
            $sheet->setCellValue("F$detail_start_row", $response_detail['nocont']);
            $sheet->setCellValue("G$detail_start_row", $response_detail['nosp']);
            $sheet->setCellValue("H$detail_start_row", $response_detail['statusritasi']);
            $sheet->setCellValue("I$detail_start_row", $response_detail['ritasi_nobukti']);
            $sheet->setCellValue("J$detail_start_row", $response_detail['keteranganbiayatambahan']);
            $sheet->setCellValue("K$detail_start_row", $response_detail['biayaextras']);
            $sheet->setCellValue("L$detail_start_row", $response_detail['gajikeneks']);
            $sheet->setCellValue("M$detail_start_row", $response_detail['komisisupirs']);
            $sheet->setCellValue("N$detail_start_row", $response_detail['upahritasis']);
            $sheet->setCellValue("O$detail_start_row", $response_detail['tolsupirs']);
            $sheet->setCellValue("P$detail_start_row", $response_detail['gajisupirs']);
            
            $sheet ->getStyle("A$detail_start_row:J$detail_start_row")->applyFromArray($styleArray);
            $sheet ->getStyle("K$detail_start_row:P$detail_start_row")->applyFromArray($style_number);
            
            $gajisupir += $response_detail['gajisupir'];
            $detail_start_row++;
        }

        $total_start_row = $detail_start_row;
        $sheet->mergeCells('A'.$total_start_row.':O'.$total_start_row);
        $sheet->setCellValue("A$total_start_row", 'Total :')->getStyle('A'.$total_start_row.':O'.$total_start_row)->applyFromArray($styleArray)->getFont()->setBold(true);
        $sheet->setCellValue("P$total_start_row", number_format((float) $gajisupir, '2', '.', ','))->getStyle("P$detail_start_row")->applyFromArray($style_number)->getFont()->setBold(true);

        $sheet->getColumnDimension('A')->setAutoSize(true);
        $sheet->getColumnDimension('B')->setAutoSize(true);
        $sheet->getColumnDimension('C')->setAutoSize(true);
        $sheet->getColumnDimension('D')->setAutoSize(true);
        $sheet->getColumnDimension('E')->setAutoSize(true);
        $sheet->getColumnDimension('F')->setAutoSize(true);
        $sheet->getColumnDimension('G')->setAutoSize(true);
        $sheet->getColumnDimension('H')->setAutoSize(true);
        $sheet->getColumnDimension('I')->setAutoSize(true);
        $sheet->getColumnDimension('J')->setAutoSize(true);
        $sheet->getColumnDimension('K')->setAutoSize(true);
        $sheet->getColumnDimension('L')->setAutoSize(true);
        $sheet->getColumnDimension('M')->setAutoSize(true);
        $sheet->getColumnDimension('N')->setAutoSize(true);
        $sheet->getColumnDimension('O')->setAutoSize(true);
        $sheet->getColumnDimension('P')->setAutoSize(true);

        $writer = new Xlsx($spreadsheet);
        $filename = 'Laporan Gaji Supir' . date('dmYHis');
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }

}
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class PengeluaranTruckingHeaderController extends MyController
{
    public $title = 'Pengeluaran Trucking';
    
    public function index(Request $request)
    {
        $title = $this->title;
        $data = [            
            'combostatusposting' => $this->comboList('list','STATUS POSTING','STATUS POSTING'),
            'combocetak' => $this->comboList('list','STATUSCETAK','STATUSCETAK'),
        ];
        $comboKodepengeluaran  = $this->comboKodepengeluaran();
        return view('pengeluarantruckingheader.index', compact('title','data','comboKodepengeluaran'));
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
            ->get(config('app.api_url') . 'pengeluarantruckingheader', $params);

        $data = [
            'total' => $response['attributes']['totalPages'] ?? [],
            'records' => $response['attributes']['totalRows'] ?? [],
            'rows' => $response['data'] ?? [],
            'params' => $response['params'] ?? [],
        ];

        return $data;
    }

    public function edit($id)
    {
        $title = $this->title;

        $response = Http::withHeaders($this->httpHeaders)
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . "pengeluarantruckingheader/$id");
            // dd($response->getBody()->getContents());

        $pengeluarantruckingheader = $response['data'];
        

        $combo = $this->combo();

        return view('pengeluarantruckingheader.edit', compact('title', 'pengeluarantruckingheader','combo'));
    }
    public function comboKodepengeluaran()
    {
        $response = Http::withHeaders($this->httpHeaders)
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'pengeluarantrucking');

        return $response['data'];
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

    public function report(Request $request)
    {
        //FETCH HEADER
        $id = $request->id;
        $pengeluarantrucking = Http::withHeaders($request->header())
        ->withOptions(['verify' => false])
        ->withToken(session('access_token'))
        ->get(config('app.api_url') .'pengeluarantruckingheader/'.$id.'/export')['data'];

        //FETCH DETAIL
        $detailParams = [
            'forReport' => true,
            'pengeluarantruckingheader_id' => $request->id,
        ];
        $pengeluarantrucking_details = Http::withHeaders($request->header())
        ->withOptions(['verify' => false])
        ->withToken(session('access_token'))
        ->get(config('app.api_url') .'pengeluarantruckingdetail', $detailParams)['data'];

        return view('reports.pengeluarantruckingheader', compact('pengeluarantrucking_details','pengeluarantrucking'));
    }

    public function export(Request $request): void
    {
        
        //FETCH HEADER
        $id = $request->id;
        $pengeluarantrucking = Http::withHeaders($request->header())
        ->withOptions(['verify' => false])
        ->withToken(session('access_token'))
        ->get(config('app.api_url') .'pengeluarantruckingheader/'.$id.'/export')['data'];

        //FETCH DETAIL
        $detailParams = [
            'pengeluarantruckingheader_id' => $request->id,
        ];

        $pengeluarantrucking_details = Http::withHeaders($request->header())
        ->withOptions(['verify' => false])
        ->withToken(session('access_token'))
        ->get(config('app.api_url') .'pengeluarantruckingdetail', $detailParams)['data'];

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', $pengeluarantrucking['judul']);
        $sheet->setCellValue('A2', $pengeluarantrucking['judulLaporan']);
        $sheet->getStyle("A1")->getFont()->setSize(12);
        $sheet->getStyle("A2")->getFont()->setSize(12);
        $sheet->getStyle("A1")->getFont()->setBold(true);
        $sheet->getStyle("A2")->getFont()->setBold(true);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal('center');
        $sheet->getStyle('A2')->getAlignment()->setHorizontal('center');
        $sheet->mergeCells('A1:G1');
        $sheet->mergeCells('A2:G2');

        $header_start_row = 4;
        $header_right_start_row = 4;
        $detail_table_header_row = 9;
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
                'label' => 'No Bukti Pengeluaran', 
                'index' => 'pengeluaran_nobukti',
            ],
            
            [
                'label' => 'Bank',
                'index' => 'bank_id',
            ]
        ];

        $header_right_columns = [
            [
                'label' => 'Pengeluaran Trucking',
                'index' => 'pengeluarantrucking_id',
            ],
            [
                'label' => 'Supir', 
                'index' => 'supir',
            ],
            [
                'label' => 'Trado', 
                'index' => 'trado',
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
                'label' => 'NO BUKTI PENERIMAAN TRUCKING',
                'index' => 'penerimaantruckingheader_nobukti',
            ],
            [
                'label' => 'NO BUKTI ORDERAN TRUCKING',
                'index' => 'orderantrucking_nobukti',
            ],
            [
                'label' => 'SUPIR',
                'index' => 'supir_id',
            ],
            [
                'label' => 'NO INVOCE',
                'index' => 'invoice_nobukti',
            ],
            [
                'label' => 'KETERANGAN',
                'index' => 'keterangan',
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
            $sheet->setCellValue('C' . $header_start_row++, ': '.$pengeluarantrucking[$header_column['index']]); 
        }
        foreach ($header_right_columns as $header_right_column) {
            $sheet->setCellValue('D' . $header_right_start_row, $header_right_column['label']);
            $sheet->setCellValue('E' . $header_right_start_row++, ': '.$pengeluarantrucking[$header_right_column['index']]); 
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

        // $sheet->getStyle("A$detail_table_header_row:G$detail_table_header_row")->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('FF1F456E');
        $sheet ->getStyle("A$detail_table_header_row:G$detail_table_header_row")->applyFromArray($styleArray);

        // LOOPING DETAIL
        $nominal = 0;
        foreach ($pengeluarantrucking_details as $response_index => $response_detail) {
            
            foreach ($detail_columns as $detail_columns_index => $detail_column) {
                $sheet->setCellValue($alphabets[$detail_columns_index] . $detail_start_row, isset($detail_column['index']) ? $response_detail[$detail_column['index']] : $response_index + 1);
                $sheet->getStyle("A$detail_table_header_row:G$detail_table_header_row")->getFont()->setBold(true);
                $sheet->getStyle("A$detail_table_header_row:G$detail_table_header_row")->getAlignment()->setHorizontal('center');
            }
            $response_detail['nominals'] = number_format((float) $response_detail['nominal'], '2', '.', ',');
        
            $sheet->setCellValue("A$detail_start_row", $response_index + 1);
            $sheet->setCellValue("B$detail_start_row", $response_detail['penerimaantruckingheader_nobukti']);
            $sheet->setCellValue("C$detail_start_row", $response_detail['orderantrucking_nobukti']);
            $sheet->setCellValue("D$detail_start_row", $response_detail['supir_id']);
            $sheet->setCellValue("E$detail_start_row", $response_detail['invoice_nobukti']);
            $sheet->setCellValue("F$detail_start_row", $response_detail['keterangan']);
            $sheet->setCellValue("G$detail_start_row", $response_detail['nominals']);

            $sheet->getStyle("F$detail_start_row")->getAlignment()->setWrapText(true);
            $sheet->getColumnDimension('F')->setWidth(50);

            $sheet ->getStyle("A$detail_start_row:F$detail_start_row")->applyFromArray($styleArray);
            $sheet ->getStyle("G$detail_start_row")->applyFromArray($style_number);
            $nominal += $response_detail['nominal'];
            $detail_start_row++;
        }

        $total_start_row = $detail_start_row;
        $sheet->mergeCells('A'.$total_start_row.':F'.$total_start_row);
        $sheet->setCellValue("A$total_start_row", 'Total :')->getStyle('A'.$total_start_row.':F'.$total_start_row)->applyFromArray($styleArray)->getFont()->setBold(true);
        $sheet->setCellValue("G$total_start_row", number_format((float) $nominal, '2', '.', ','))->getStyle("G$detail_start_row")->applyFromArray($style_number)->getFont()->setBold(true);

        $sheet->getColumnDimension('A')->setAutoSize(true);
        $sheet->getColumnDimension('B')->setAutoSize(true);
        $sheet->getColumnDimension('C')->setAutoSize(true);
        $sheet->getColumnDimension('D')->setAutoSize(true);
        $sheet->getColumnDimension('E')->setAutoSize(true);
        $sheet->getColumnDimension('G')->setAutoSize(true);

        $writer = new Xlsx($spreadsheet);
        $filename = 'Laporan Pengeluaran Trucking' . date('dmYHis');
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }
}
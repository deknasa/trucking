<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class JurnalUmumHeaderController extends MyController
{
    public $title = 'Jurnal Umum';
    
    public function index(Request $request)
    {
        $title = $this->title;
        $data = [            
            'comboapproval' => $this->comboApproval('list'),
            'combocetak' => $this->comboCetak('list', 'STATUSCETAK', 'STATUSCETAK'),
            'listbtn' => $this->getListBtn()
        ];
        return view('jurnalumum.index', compact('title','data'));
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

    
    public function store(Request $request)
    {
        try {
             /* Unformat nominal */
            $request->nominal_detail = array_map(function ($nominal) {
                $nominal = str_replace('.', '', $nominal);
                $nominal = str_replace(',', '', $nominal);

                return $nominal;
            }, $request->nominal_detail);

            $request->merge([
                'nominal' => $request->nominal_detail
            ]);

            $request['modifiedby'] = Auth::user()->name;

            $response = Http::withHeaders($this->httpHeaders)
                ->withOptions(['verify' => false])
                ->withToken(session('access_token'))
                ->post(config('app.api_url') . 'jurnalumumheader', $request->all());


            return response($response, $response->status());
        } catch (\Throwable $th) {
            throw $th->getMessage();
        }
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
            ->get(config('app.api_url') . 'jurnalumumheader', $params);

        $data = [
            'total' => $response['attributes']['totalPages'] ?? [],
            'records' => $response['attributes']['totalRows'] ?? [],
            'rows' => $response['data'] ?? [],
            'params' => $response['params'] ?? [],
        ];

        return $data;
    }
    
    
    public function create()
    {
        $title = $this->title;

        $combo = $this->combo();

        return view('jurnalumum.add', compact('title','combo'));
    }

    
    public function edit($id)
    {
        $title = $this->title;

        $response = Http::withHeaders($this->httpHeaders)
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . "jurnalumumheader/$id");
            // dd($response->getBody()->getContents());

        $jurnalumum = $response['data'];
        $detail = $response['detail'];
        $jurnalNoBukti = $this->getNoBukti('JURNAL UMUM', 'JURNAL UMUM', 'jurnalumumheader');

        $combo = $this->combo();

        return view('jurnalumum.edit', compact('title', 'jurnalumum','combo','detail', 'jurnalNoBukti'));
    }

    
    public function update(Request $request, $id)
    {
        /* Unformat nominal */
        $request->nominal_detail = array_map(function ($nominal) {
            $nominal = str_replace('.', '', $nominal);
            $nominal = str_replace(',', '', $nominal);

            return $nominal;
        }, $request->nominal_detail);

        $request->merge([
            'nominal' => $request->nominal_detail
        ]);

        $request['modifiedby'] = Auth::user()->name;

        $response = Http::withHeaders($this->httpHeaders)
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->patch(config('app.api_url') . "jurnalumumheader/$id", $request->all());

        return response($response);
    }

    
    
    public function delete($id)
    {
        try {
            $title = $this->title;

            $response = Http::withHeaders($this->httpHeaders)
                ->withOptions(['verify' => false])
                ->withToken(session('access_token'))
                ->get(config('app.api_url') . "jurnalumumheader/$id");

            $jurnalumum = $response['data'];
            $detail = $response['detail'];
            
            $combo = $this->combo();

            return view('jurnalumum.delete', compact('title','combo', 'jurnalumum', 'detail'));
        } catch (\Throwable $th) {
            return redirect()->route('jurnalumum.index');
        }
    }

    
    
    public function destroy($id)
    {
        $request['modifiedby'] = Auth::user()->name;
        $response = Http::withHeaders($this->httpHeaders)
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->delete(config('app.api_url') . "jurnalumumheader/$id");

            
        return response($response);
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

    private function combo()
    {
        $response = Http::withHeaders($this->httpHeaders)
        ->withToken(session('access_token'))
        ->withOptions(['verify' => false])
            ->get(config('app.api_url') . 'jurnalumumheader/combo');

        return $response['data'];
    }

    public function comboApproval($aksi)
    {

        $status = [
            'status' => $aksi,
            'grp' => 'STATUS APPROVAL',
            'subgrp' => 'STATUS APPROVAL',
        ];

        $response = Http::withHeaders($this->httpHeaders)
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'parameter/comboapproval', $status);

        return $response['data'];
    }
    
    public function comboReport($aksi)
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
        $jurnal = Http::withHeaders($request->header())
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') .'jurnalumumheader/'.$id.'/export')['data'];

        //FETCH DETAIL
        $detailParams = [
            'forReport' => true,
            'jurnalumum_id' => $request->id
        ];

        $jurnal_details = Http::withHeaders($request->header())
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') .'jurnalumumdetail', $detailParams)['data'];

        $combo = $this->comboReport('list');
        $key = array_search('CETAK', array_column( $combo, 'parameter')); 
        $jurnal["combo"] =  $combo[$key];
        $printer['tipe'] = $request->printer;
        return view('reports.jurnalumum', compact('jurnal', 'jurnal_details', 'printer'));
    }

    // public function export(Request $request): void
    // {
    //     //FETCH HEADER
    //     $id = $request->id;
    //     $jurnal = Http::withHeaders($request->header())
    //         ->withOptions(['verify' => false])
    //         ->withToken(session('access_token'))
    //         ->get(config('app.api_url') .'jurnalumumheader/'.$id.'/export')['data'];

    //     //FETCH DETAIL
    //     $detailParams = [
    //         'forExport' => true,
    //         'jurnalumum_id' => $request->id
    //     ];

    //     $responses = Http::withHeaders($request->header())
    //         ->withOptions(['verify' => false])
    //         ->withToken(session('access_token'))
    //         ->get(config('app.api_url') .'jurnalumumdetail', $detailParams);
    //     $jurnal_details = $responses['data'];
    
    //     $tglBukti = $jurnal["tglbukti"];
    //     $timeStamp = strtotime($tglBukti);
    //     $dateTglBukti = date('d-m-Y', $timeStamp); 
    //     $jurnal['tglbukti'] = $dateTglBukti;

    //     $spreadsheet = new Spreadsheet();
    //     $sheet = $spreadsheet->getActiveSheet();
    //     $sheet->setCellValue('A1', $jurnal['judul']);
    //     $sheet->setCellValue('A2', $jurnal['judulLaporan']);
    //     $sheet->getStyle("A1")->getFont()->setSize(12);
    //     $sheet->getStyle("A2")->getFont()->setSize(12);
    //     $sheet->getStyle("A1")->getFont()->setBold(true);
    //     $sheet->getStyle("A2")->getFont()->setBold(true);
    //     $sheet->getStyle('A1')->getAlignment()->setHorizontal('center');
    //     $sheet->getStyle('A2')->getAlignment()->setHorizontal('center');
    //     $sheet->mergeCells('A1:F1');
    //     $sheet->mergeCells('A2:F2');

    //     $header_start_row = 4;
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
    //         [
    //             'label' => 'Posting Dari',
    //             'index' => 'postingdari',
    //         ],
    //     ];

    //     $detail_columns = [
    //         [
    //             'label' => 'NO',
    //         ],
    //         [
    //             'label' => 'KODE PERKIRAAN',
    //             'index' => 'coa',
    //         ],
    //         [
    //             'label' => 'NAMA PERKIRAAN',
    //             'index' => 'keterangancoa',
    //         ],
    //         [
    //             'label' => 'KETERANGAN',
    //             'index' => 'keterangan',
    //         ],
    //         [
    //             'label' => 'DEBET',
    //             'index' => 'nominaldebet',
    //         ],
    //         [
    //             'label' => 'KREDIT',
    //             'index' => 'nominalkredit',
    //         ]
    //     ];

    //     //LOOPING HEADER
    //     foreach ($header_columns as $header_column) {
    //         $sheet->setCellValue('B' . $header_start_row, $header_column['label']);
    //         $sheet->setCellValue('C' . $header_start_row++, ': '.$jurnal[$header_column['index']]);
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
    //     $sheet ->getStyle("A$detail_table_header_row:F$detail_table_header_row")->applyFromArray($styleArray);

    //     //LOOPING DETAIL
    //     $totaldebet = 0;
    //     $totalkredit = 0;
    //     foreach ($jurnal_details as $response_index => $response_detail) {
            
    //         foreach ($detail_columns as $detail_columns_index => $detail_column) {
    //             $sheet->setCellValue($alphabets[$detail_columns_index] . $detail_start_row, isset($detail_column['index']) ? $response_detail[$detail_column['index']] : $response_index + 1);
    //             $sheet->getStyle("A$detail_table_header_row:F$detail_table_header_row")->getFont()->setBold(true);
    //             $sheet->getStyle("A$detail_table_header_row:F$detail_table_header_row")->getAlignment()->setHorizontal('center');
    //         }

    //         $tglBukti = $response_detail["tglbukti"];
    //         $timeStamp = strtotime($tglBukti);
    //         $dateTglBukti = date('d-m-Y', $timeStamp); 
    //         $response_detail['tglbukti'] = $dateTglBukti;
        
    //         $sheet->setCellValue("A$detail_start_row", $response_index + 1);
    //         $sheet->setCellValue("B$detail_start_row", $response_detail['coa']);
    //         $sheet->setCellValue("C$detail_start_row", $response_detail['keterangancoa']);
    //         $sheet->setCellValue("D$detail_start_row", $response_detail['keterangan']);
    //         $sheet->setCellValue("E$detail_start_row", $response_detail['nominaldebet']);
    //         $sheet->setCellValue("F$detail_start_row", $response_detail['nominalkredit']);

    //         $sheet->getStyle("D$detail_start_row")->getAlignment()->setWrapText(true);
    //         $sheet->getColumnDimension('D')->setWidth(50);

    //         $sheet ->getStyle("A$detail_start_row:D$detail_start_row")->applyFromArray($styleArray);
    //         $sheet ->getStyle("E$detail_start_row:F$detail_start_row")->applyFromArray($style_number)->getNumberFormat()->setFormatCode("#,##0.00_);(#,##0.00)");
    //         $detail_start_row++;
    //     }

    //     $total_start_row = $detail_start_row;
        
    //     $sheet->mergeCells('A'.$total_start_row.':D'.$total_start_row);
    //     $sheet->setCellValue("A$total_start_row", 'Total')->getStyle('A'.$total_start_row.':D'.$total_start_row)->applyFromArray($styleArray)->getFont()->setBold(true);
    //     $sheet->setCellValue("E$total_start_row", "=SUM(E9:E" . ($detail_start_row - 1) . ")")->getStyle("E$detail_start_row")->applyFromArray($style_number)->getFont()->setBold(true);
    //     $sheet->setCellValue("F$total_start_row", "=SUM(F9:F" . ($detail_start_row - 1) . ")")->getStyle("F$detail_start_row")->applyFromArray($style_number)->getFont()->setBold(true);

    //     $sheet->getStyle("E$total_start_row:F$total_start_row")->getNumberFormat()->setFormatCode("#,##0.00_);(#,##0.00)");
    //     $sheet->getColumnDimension('A')->setAutoSize(true);
    //     $sheet->getColumnDimension('B')->setAutoSize(true);
    //     $sheet->getColumnDimension('C')->setAutoSize(true);
    //     $sheet->getColumnDimension('E')->setAutoSize(true);
    //     $sheet->getColumnDimension('F')->setAutoSize(true);

    //     $writer = new Xlsx($spreadsheet);
    //     $filename = 'Jurnal Umum' . date('dmYHis');
    //     header('Content-Type: application/vnd.ms-excel');
    //     header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
    //     header('Cache-Control: max-age=0');

    //     $writer->save('php://output');
    // }
}
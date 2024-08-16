<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use stdClass;

class AbsensiSupirHeaderController extends MyController
{
    public $title = 'Absensi Supir (Admin)';
    
    public function index(Request $request)
    {
        $title = $this->title;

        $data = [
            'combocetak' => $this->comboCetak('list', 'STATUSCETAK', 'STATUSCETAK'),
            'comboedit' => $this->comboCetak('list', 'STATUS EDIT ABSENSI', 'STATUS EDIT ABSENSI'),
            'combofinalabsensi' => $this->comboCetak('list', 'STATUS APPROVAL', 'STATUS APPROVAL'),
            'listbtn' => $this->getListBtn()
        ];
        $data = array_merge(compact('title', 'data'),
            ["request"=>$request->all()]
        );
        return view('absensisupir.index', $data);        

    }

    public function create()
    {
        $title = $this->title;

        $combo = [
            'trado' => $this->getTrado(),
            'supir' => $this->getSupir(),
            'status' => $this->getStatus(),
        ];

        return view('absensisupir.add', compact('title', 'combo'));
    }

    public function edit($id)
    {
        $title = $this->title;

        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Content-Type' => 'application/json'
        ])
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . "absensi/$id");

        $absensisupir = $response['data'];
        $combo = [
            'trado' => $this->getTrado(),
            'supir' => $this->getSupir(),
            'status' => $this->getStatus(),
        ];

        return view('absensisupir.edit', compact('title', 'absensisupir', 'combo'));
    }
    
    public function delete($id)
    {
        try {
            $title = $this->title;

            $response = Http::withHeaders([
                'Accept' => 'application/json',
                'Content-Type' => 'application/json'
            ])
                ->withOptions(['verify' => false])
                ->withToken(session('access_token'))
                ->get(config('app.api_url') . "absensi/$id");

            $absensisupir = $response['data'];
            $combo = [
                'trado' => $this->getTrado(),
                'supir' => $this->getSupir(),
                'status' => $this->getStatus(),
            ];

            return view('absensisupir.delete', compact('title', 'combo', 'absensisupir'));
        } catch (\Throwable $th) {
            return redirect()->route('absensi.index');
        }
    }

    public function getTrado()
    {
        $response = Http::withToken(session('access_token'))
            ->withOptions(['verify' => false])
            ->get(config('app.api_url') . 'trado');

        return $response['data'];
    }

    public function getSupir()
    {
        $response = Http::withToken(session('access_token'))
            ->withOptions(['verify' => false])
            ->get(config('app.api_url') . 'supir');

        return $response['data'];
    }

    public function getStatus()
    {
        $response = Http::withToken(session('access_token'))
            ->withOptions(['verify' => false])
            ->get(config('app.api_url') . 'absen_trado');

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
        $invoices = Http::withHeaders($request->header())
        ->withOptions(['verify' => false])
        ->withToken(session('access_token'))
        ->get(config('app.api_url') .'absensisupirheader/'.$id.'/export');

        //FETCH DETAIL
        $detailParams = [
            'forReport' => true,
            'absensi_id' => $request->id
        ];
        $responses = Http::withHeaders($request->header())
        ->withOptions(['verify' => false])
        ->withToken(session('access_token'))
        ->get(config('app.api_url') .'absensisupirdetail', $detailParams);

        $absensi = $invoices['data'];
        $absensi_details = $responses['data'];
        $combo = $this->combo('list');
        $key = array_search('CETAK', array_column( $combo, 'parameter')); 
        $absensi["combo"] =  $combo[$key];
        $printer['tipe'] = $request->printer;
        return view('reports.absensi', compact('absensi', 'absensi_details','printer'));
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
            ->get(config('app.api_url') . 'absensisupirheader', $params);

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
        
    public function export(Request $request): void
    {
        //FETCH HEADER
        $id = $request->id;
        $invoices = Http::withHeaders($request->header())
        ->withOptions(['verify' => false])
        ->withToken(session('access_token'))
        ->get(config('app.api_url') .'absensisupirheader/'.$id.'/export');

        //FETCH DETAIL
        $detailParams = [
            'forReport' => true,
            'absensi_id' => $request->id,
        ];
        $responses = Http::withHeaders($request->header())
        ->withOptions(['verify' => false])
        ->withToken(session('access_token'))
        ->get(config('app.api_url') .'absensisupirdetail', $detailParams);

        $invoice = $invoices['data'];
        $invoice_details = $responses['data'];

        $tglBukti = $invoice["tglbukti"];
        $timeStamp = strtotime($tglBukti);
        $dateTglBukti = date('d-m-Y', $timeStamp); 
        $invoice['tglbukti'] = $dateTglBukti;

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', $invoice['judul']);
        $sheet->setCellValue('A2', $invoice['judulLaporan']);
        $sheet->getStyle("A1")->getFont()->setSize(12);
        $sheet->getStyle("A2")->getFont()->setSize(11);
        $sheet->getStyle("A1")->getFont()->setBold(true);
        $sheet->getStyle("A2")->getFont()->setBold(true);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal('center');
        $sheet->getStyle('A2')->getAlignment()->setHorizontal('center');
        $sheet->mergeCells('A1:F1');
        $sheet->mergeCells('A2:F2');

        $header_start_row = 4;
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
                'label' => 'No Bukti Kas Gantung',
                'index' => 'kasgantung_nobukti',
            ],
        ];

        $detail_columns = [
            [
                'label' => 'NO',
            ],
            [
                'label' => 'TRADO',
                'index' => 'trado',
            ],
            [
                'label' => 'SUPIR',
                'index' => 'supir',
            ],
            [
                'label' => 'STATUS',
                'index' => 'status',
            ],
            [
                'label' => 'KETERANGAN',
                'index' => 'keterangan_detail',
            ],
            [
                'label' => 'UANG JALAN',
                'index' => 'uangjalan',
                'format' => 'currency'
            ]
        ];
        
        //LOOPING HEADER        
        foreach ($header_columns as $header_column) {
            $sheet->setCellValue('B' . $header_start_row, $header_column['label']);
            $sheet->setCellValue('C' . $header_start_row++, ': '.$invoice[$header_column['index']]);
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
        $sheet ->getStyle("A$detail_table_header_row:F$detail_table_header_row")->applyFromArray($styleArray);
        
        // LOOPING DETAIL
        $totaluangjalan = 0;
        foreach ($invoice_details as $response_index => $response_detail) {
            
            foreach ($detail_columns as $detail_columns_index => $detail_column) {
                $sheet->setCellValue($alphabets[$detail_columns_index] . $detail_start_row, isset($detail_column['index']) ? $response_detail[$detail_column['index']] : $response_index + 1);
                $sheet->getStyle("A$detail_table_header_row:F$detail_table_header_row")->getFont()->setBold(true);
                $sheet->getStyle("A$detail_table_header_row:F$detail_table_header_row")->getAlignment()->setHorizontal('center');
            }
            $response_detail['jumlahtrips'] = number_format((float) $response_detail['jumlahtrip'], '2', '.', ',');
            
        
            $sheet->setCellValue("A$detail_start_row", $response_index + 1);
            $sheet->setCellValue("B$detail_start_row", $response_detail['trado']);
            $sheet->setCellValue("C$detail_start_row", $response_detail['supir']);
            $sheet->setCellValue("D$detail_start_row", $response_detail['status']);
            $sheet->setCellValue("E$detail_start_row", $response_detail['keterangan_detail']);
            $sheet->setCellValue("F$detail_start_row", $response_detail['uangjalan']);

            $sheet->getColumnDimension('E')->setWidth(50);
            
            $sheet ->getStyle("A$detail_start_row:F$detail_start_row")->applyFromArray($styleArray);
            $sheet ->getStyle("F$detail_start_row")->applyFromArray($style_number)->getNumberFormat()->setFormatCode("#,##0.00_);(#,##0.00)");
            $detail_start_row++;
        }

        $total_start_row = $detail_start_row;
        $sheet->mergeCells('A'.$total_start_row.':E'.$total_start_row);
        $sheet->setCellValue("A$total_start_row", 'Total')->getStyle('A'.$total_start_row.':E'.$total_start_row)->applyFromArray($styleArray)->getFont()->setBold(true);
        $sheet->setCellValue("F$total_start_row", "=SUM(F8:F" . ($detail_start_row - 1) . ")")->getStyle("F$detail_start_row")->applyFromArray($style_number)->getFont()->setBold(true);
        $sheet->getStyle("F$total_start_row")->getNumberFormat()->setFormatCode("#,##0.00_);(#,##0.00)");

        //set autosize
        $sheet->getColumnDimension('A')->setAutoSize(true);
        $sheet->getColumnDimension('B')->setAutoSize(true);
        $sheet->getColumnDimension('C')->setAutoSize(true);
        $sheet->getColumnDimension('D')->setAutoSize(true);
        $sheet->getColumnDimension('F')->setAutoSize(true);

        $writer = new Xlsx($spreadsheet);
        $filename = 'Laporan Absensi ' . date('dmYHis');
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class PendapatanSupirHeaderController extends MyController
{
    public $title = 'Pendapatan Supir';

    public function index(Request $request){
        $title = $this->title;
        $data = [            
            'comboapproval' => $this->comboList('list','STATUS APPROVAL','STATUS APPROVAL'),
            'combocetak' => $this->comboList('list','STATUSCETAK','STATUSCETAK')
        ];
        return view('pendapatansupirheader.index', compact('title','data'));
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
    
    public function report(Request $request)
    {
        $header = Http::withHeaders(request()->header())
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'pendapatansupirheader/' . $request->id);

        $detailParams = [
            'forReport' => true,
            'pendapatansupir_id' => $request->id
        ];
  
        $pendapatan_detail = Http::withHeaders(request()->header())
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'pendapatansupirdetail', $detailParams);
        
        $data = $header['data'];
        $pendapatan_details = $pendapatan_detail['data'];
        $user = Auth::user();
        return view('reports.pendapatansupir', compact('data','pendapatan_details','user'));
    }

    public function export(Request $request): void
    {
        //FETCH HEADER
        $id = $request->id;
        $pendapatans = Http::withHeaders($request->header())
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') .'pendapatansupirheader/'.$id.'/export')['data'];
      
        //FETCH DETAIL
        $detailParams = [
            'forExport' => true,
            'pendapatansupir_id' => $request->id
        ];

        $responses = Http::withHeaders($request->header())
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') .'pendapatansupirdetail', $detailParams);
        $pendapatan_details = $responses['data'];

        $tglBukti = $pendapatans["tglbukti"];
        $timeStamp = strtotime($tglBukti);
        $dateTglBukti = date('d-m-Y', $timeStamp); 
        $pendapatans['tglbukti'] = $dateTglBukti;

        $tglDari = $pendapatans["tgldari"];
        $timeStampDari = strtotime($tglDari);
        $datetglDari = date('d-m-Y', $timeStampDari); 
        $pendapatans['tgldari'] = $datetglDari;

        $tglSampai = $pendapatans["tglsampai"];
        $timeStampSampai = strtotime($tglSampai);
        $datetglSampai = date('d-m-Y', $timeStampSampai); 
        $pendapatans['tglsampai'] = $datetglSampai;

        $periode = $pendapatans["periode"];
        $timeStampPeriode = strtotime($periode);
        $dateperiode = date('d-m-Y', $timeStampPeriode); 
        $pendapatans['periode'] = $dateperiode;

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', $pendapatans['judul']);
        $sheet->setCellValue('A2', $pendapatans['judulLaporan']);
        $sheet->getStyle("A1")->getFont()->setSize(14);
        $sheet->getStyle("A2")->getFont()->setSize(12);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal('center');
        $sheet->getStyle('A2')->getAlignment()->setHorizontal('center');
        $sheet->mergeCells('A1:D1');
        $sheet->mergeCells('A2:D2');

        $header_start_row = 4;
        $detail_table_header_row = 11;
        $detail_start_row = $detail_table_header_row + 1;
       
        $alphabets = range('A', 'Z');

        $header_columns = [
            [
                'label' => 'No Bukti',
                'index' => 'nobukti',
            ],
            [
                'label' => 'Tanggal Bukti',
                'index' => 'tglbukti',
            ],
            [
                'label' => 'Bank',
                'index' => 'bank_id',
            ],
            [
                'label' => 'Tanggal Dari',
                'index' => 'tgldari',
            ],
            [
                'label' => 'Tanggal Sampai',
                'index' => 'tglsampai',
            ],
            [
                'label' => 'Periode',
                'index' => 'periode',
            ],
        ];

        $detail_columns = [
            [
                'label' => 'No',
            ],
            [
                'label' => 'Supir',
                'index' => 'supir_id',
            ],
            [
                'label' => 'Keterangan',
                'index' => 'keterangan',
            ],
            [
                'label' => 'Nominal',
                'index' => 'nominal',
                'format' => 'currency'
            ]
        ];

        foreach ($header_columns as $header_column) {
            $sheet->setCellValue('B' . $header_start_row, $header_column['label']);
            $sheet->setCellValue('C' . $header_start_row++, ': '.$pendapatans[$header_column['index']]);
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
        $sheet ->getStyle("A$detail_table_header_row:D$detail_table_header_row")->applyFromArray($styleArray);

        $total = 0;
        foreach ($pendapatan_details as $response_index => $response_detail) {
            
            foreach ($detail_columns as $detail_columns_index => $detail_column) {
                $sheet->setCellValue($alphabets[$detail_columns_index] . $detail_start_row, isset($detail_column['index']) ? $response_detail[$detail_column['index']] : $response_index + 1);
            }
            $response_detail['nominals'] = number_format((float) $response_detail['nominal'], '2', '.', ',');
        
            $sheet->setCellValue("A$detail_start_row", $response_index + 1);
            $sheet->setCellValue("B$detail_start_row", $response_detail['supir_id']);
            $sheet->setCellValue("C$detail_start_row", $response_detail['keterangan']);
            $sheet->setCellValue("D$detail_start_row", $response_detail['nominals']);

            $sheet ->getStyle("A$detail_start_row:D$detail_start_row")->applyFromArray($styleArray);
            $sheet ->getStyle("D$detail_start_row")->applyFromArray($style_number);
            $total += $response_detail['nominal'];
            $detail_start_row++;
        }

        $total_start_row = $detail_start_row;
        
        $sheet->mergeCells('A'.$total_start_row.':C'.$total_start_row);
        $sheet->setCellValue("A$total_start_row", 'Total :')->getStyle('A'.$total_start_row.':C'.$total_start_row)->applyFromArray($style_number)->getFont()->setBold(true);
        $sheet->setCellValue("D$total_start_row", number_format((float) $total, '2', '.', ','))->getStyle("D$detail_start_row")->applyFromArray($style_number)->getFont()->setBold(true);
       
        //set diketahui dibuat
        $ttd_start_row = $total_start_row+2;
        $sheet->setCellValue("B$ttd_start_row", 'Disetujui');
        $sheet->setCellValue("C$ttd_start_row", 'Diketahui');
        $sheet->setCellValue("D$ttd_start_row", 'Dibuat');
        $sheet ->getStyle("B$ttd_start_row:D$ttd_start_row")->applyFromArray($styleArray);
        // $sheet->mergeCells("A$ttd_end_row:C$ttd_end_row");
        $sheet->mergeCells("B".($ttd_start_row+1).":B".($ttd_start_row+3));      
        $sheet->mergeCells("C".($ttd_start_row+1).":C".($ttd_start_row+3));      
        $sheet->mergeCells("D".($ttd_start_row+1).":D".($ttd_start_row+3));      
        $sheet ->getStyle("B".($ttd_start_row+1).":B".($ttd_start_row+3))->applyFromArray($styleArray);
        $sheet ->getStyle("C".($ttd_start_row+1).":C".($ttd_start_row+3))->applyFromArray($styleArray);
        $sheet ->getStyle("D".($ttd_start_row+1).":D".($ttd_start_row+3))->applyFromArray($styleArray);

        $sheet->getColumnDimension('A')->setAutoSize(true);
        $sheet->getColumnDimension('B')->setAutoSize(true);
        $sheet->getColumnDimension('C')->setAutoSize(true);
        $sheet->getColumnDimension('D')->setAutoSize(true);
        $sheet->getColumnDimension('E')->setAutoSize(true);
        $sheet->getColumnDimension('F')->setAutoSize(true);
        $sheet->getColumnDimension('G')->setAutoSize(true);

        

        $writer = new Xlsx($spreadsheet);
        $filename = 'Laporan Pendapatan Supir' . date('dmYHis');
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }

}
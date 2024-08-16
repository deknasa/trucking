<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class InvoiceChargeGandenganHeaderController extends MyController
{
    public $title = 'Invoice Charge Gandengan Extra';
    
    public function index()
    {

        $title = $this->title;
        $data = [
            'pagename' => 'Menu Utama Invoice Charge Gandengan Extra',
            'comboapproval' => $this->comboList('list','STATUS APPROVAL','STATUS APPROVAL'),
            'combocetak' => $this->comboList('list','STATUSCETAK','STATUSCETAK'),
            'listbtn' => $this->getListBtn()
        ];
        return view('invoicechargegandenganheader.index', compact('title', 'data'));
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
        $chargegandengan = Http::withHeaders($request->header())
        ->withOptions(['verify' => false])
        ->withToken(session('access_token'))
        ->get(config('app.api_url') .'invoicechargegandenganheader/'.$id.'/export')['data'];

        //FETCH DETAIL
        $detailParams = [
            'forReport' => true,
            'invoicechargegandengan_id' => $request->id
        ];
        $chargegandengan_details = Http::withHeaders(request()->header())
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') .'invoicechargegandengandetail', $detailParams)['data'];

        $combo = $this->combo('list');
        $key = array_search('CETAK', array_column( $combo, 'parameter')); 
        $chargegandengan["combo"] =  $combo[$key];
        $printer['tipe'] = $request->printer;
        return view('reports.invoicechargegandengan', compact('chargegandengan', 'chargegandengan_details','printer'));
    }

    public function export(Request $request)
    {
        //FETCH HEADER
        $id = $request->id;
        $invchargegandengan = Http::withHeaders($request->header())
        ->withOptions(['verify' => false])
        ->withToken(session('access_token'))
        ->get(config('app.api_url') .'invoicechargegandenganheader/'.$id.'/export')['data'];

        //FETCH DETAIL
        $detailParams = [
            'forExport' => true,
            'invoicechargegandengan_id' => $request->id
        ];
        $invchargegandengan_details = Http::withHeaders(request()->header())
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') .'invoicechargegandengandetail', $detailParams)['data'];

        $tglBukti = $invchargegandengan["tglbukti"];
        $timeStamp = strtotime($tglBukti);
        $dateTglBukti = date('d-m-Y', $timeStamp); 
        $invchargegandengan['tglbukti'] = $dateTglBukti;

        $tglProses = $invchargegandengan["tglproses"];
        $timeStampProses = strtotime($tglProses);
        $dateTglProses = date('d-m-Y', $timeStampProses);
        $invchargegandengan['tglproses'] = $dateTglProses;

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', $invchargegandengan['judul']);
        $sheet->setCellValue('A2', $invchargegandengan['judulLaporan']);
        $sheet->getStyle("A1")->getFont()->setSize(12);
        $sheet->getStyle("A2")->getFont()->setSize(12);
        $sheet->getStyle("A1")->getFont()->setBold(true);
        $sheet->getStyle("A2")->getFont()->setBold(true);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal('center');
        $sheet->getStyle('A2')->getAlignment()->setHorizontal('center');
        $sheet->mergeCells('A1:G1');
        $sheet->mergeCells('A2:G2');

        $header_start_row = 4;
        $detail_table_header_row = 9;
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
                'label' => 'Tanggal Proses',
                'index' => 'tglproses',
            ],
            [
                'label' => 'Customer',
                'index' => 'agen',
            ]
        ];

        $detail_columns = [
            [
                'label' => 'NO',
            ],
            [
                'label' => 'GANDENGAN',
                'index' => 'gandengan',
            ],
            [
                'label' => 'JOB TRUCKING',
                'index' => 'jobtrucking',
            ],
            [
                'label' => 'DARI',
                'index' => 'tgltrip',
            ],
            [
                'label' => 'SAMPAI',
                'index' => 'tglakhir',
            ],
            [
                'label' => 'ORDERAN',
                'index' => 'orderan',
            ],
            [
                'label' => 'JUMLAH HARI',
                'index' => 'jumlahhari',
            ],
            [
                'label' => 'NAMA GUDANG',
                'index' => 'namagudang',
            ],
            [
                'label' => 'NOMINAL',
                'index' => 'nominal',
            ],
        ];

        //LOOPING HEADER       
        foreach ($header_columns as $header_column) {
            $sheet->setCellValue('B' . $header_start_row, $header_column['label']);
            $sheet->setCellValue('C' . $header_start_row++, ': '.$invchargegandengan[$header_column['index']]);
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
        $sheet ->getStyle("A$detail_table_header_row:I$detail_table_header_row")->applyFromArray($styleArray);

        // LOOPING DETAIL
        $nominal = 0;
        foreach ($invchargegandengan_details as $response_index => $response_detail) {
            
            foreach ($detail_columns as $detail_columns_index => $detail_column) {
                $sheet->setCellValue($alphabets[$detail_columns_index] . $detail_start_row, isset($detail_column['index']) ? $response_detail[$detail_column['index']] : $response_index + 1);
                $sheet->getStyle("A$detail_table_header_row:I$detail_table_header_row")->getFont()->setBold(true);
                $sheet->getStyle("A$detail_table_header_row:I$detail_table_header_row")->getAlignment()->setHorizontal('center');            
            }
        
            // dd('here');
            $tglTrip = ($response_detail['tgltrip'] != null) ? Date::PHPToExcel(date('Y-m-d',strtotime($response_detail['tgltrip']))) : ''; 
            $tglAkhir = ($response_detail['tglakhir'] != null) ? Date::PHPToExcel(date('Y-m-d',strtotime($response_detail['tglakhir']))) : ''; 

            $sheet->setCellValue("A$detail_start_row", $response_index + 1);    
            $sheet->setCellValue("B$detail_start_row", $response_detail['gandengan']);
            $sheet->setCellValue("C$detail_start_row", $response_detail['jobtrucking']);
            $sheet->setCellValue("D$detail_start_row", $tglTrip);
            $sheet->setCellValue("E$detail_start_row", $tglAkhir);
            $sheet->setCellValue("F$detail_start_row", $response_detail['orderan']);
            $sheet->setCellValue("G$detail_start_row", $response_detail['jumlahhari']);
            $sheet->setCellValue("H$detail_start_row", $response_detail['namagudang']);
            $sheet->setCellValue("I$detail_start_row", $response_detail['nominal']);

            $sheet ->getStyle("A$detail_start_row:I$detail_start_row")->applyFromArray($styleArray);
            $sheet->getStyle("D$detail_start_row:E$detail_start_row")->getNumberFormat()->setFormatCode('dd-mm-yyyy');
            $sheet->getStyle("I$detail_start_row")->getNumberFormat()->setFormatCode("#,##0.00_);(#,##0.00)");
            
            $sheet ->getStyle("I$detail_start_row")->applyFromArray($style_number);
            $nominal += $response_detail['nominal'];
            $detail_start_row++;
        }

        $total_start_row = $detail_start_row;
        $sheet->mergeCells('A'.$total_start_row.':H'.$total_start_row);
        $sheet->setCellValue("A$total_start_row", 'Total')->getStyle('A'.$total_start_row.':H'.$total_start_row)->applyFromArray($styleArray)->getFont()->setBold(true);

        $sheet->setCellValue("I$detail_start_row", "=SUM(I10:I" . ($detail_start_row - 1) . ")")->getStyle("I$detail_start_row")->applyFromArray($style_number)->getFont()->setBold(true);

        $sheet->getStyle("I$detail_start_row")->getNumberFormat()->setFormatCode("#,##0.00_);(#,##0.00)");

        $sheet->getColumnDimension('A')->setAutoSize(true);
        $sheet->getColumnDimension('B')->setAutoSize(true);
        $sheet->getColumnDimension('C')->setAutoSize(true);
        $sheet->getColumnDimension('D')->setAutoSize(true);
        $sheet->getColumnDimension('E')->setAutoSize(true);
        $sheet->getColumnDimension('F')->setAutoSize(true);
        $sheet->getColumnDimension('G')->setAutoSize(true);
        $sheet->getColumnDimension('H')->setAutoSize(true);
        $sheet->getColumnDimension('I')->setAutoSize(true);

        $writer = new Xlsx($spreadsheet);
        $filename = 'LAPORAN INVOICE CHARGE GANDENGAN ' . date('dmYHis');
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }

}

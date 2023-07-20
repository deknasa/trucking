<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
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
        return view('reports.invoicechargegandengan', compact('chargegandengan', 'chargegandengan_details'));
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
                'label' => 'Agen',
                'index' => 'agen',
            ]
        ];

        $detail_columns = [
            [
                'label' => 'NO',
            ],
            [
                'label' => 'TANGGAL',
                'index' => 'tglbukti',
            ],
            [
                'label' => 'JUMLAH HARI',
                'index' => 'jumlahhari',
            ],
            [
                'label' => 'NO POLISI',
                'index' => 'nopolisi',
            ],
            [
                'label' => 'KETERANGAN',
                'index' => 'keterangan',
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
        $sheet ->getStyle("A$detail_table_header_row:F$detail_table_header_row")->applyFromArray($styleArray);

        // LOOPING DETAIL
        $nominal = 0;
        foreach ($invchargegandengan_details as $response_index => $response_detail) {
            
            foreach ($detail_columns as $detail_columns_index => $detail_column) {
                $sheet->setCellValue($alphabets[$detail_columns_index] . $detail_start_row, isset($detail_column['index']) ? $response_detail[$detail_column['index']] : $response_index + 1);
                $sheet->getStyle("A$detail_table_header_row:F$detail_table_header_row")->getFont()->setBold(true);
                $sheet->getStyle("A$detail_table_header_row:F$detail_table_header_row")->getAlignment()->setHorizontal('center');            
            }
            $response_detail['nominals'] = number_format((float) $response_detail['nominal'], '2', '.', ',');
        
            $tglbukti = $response_detail["tglbukti"];
            $timeStampProses = strtotime($tglbukti);
            $datetglbukti = date('d-m-Y', $timeStampProses);
            $response_detail['tglbukti'] = $datetglbukti;

            $sheet->setCellValue("A$detail_start_row", $response_index + 1);    
            $sheet->setCellValue("B$detail_start_row", $response_detail['tglbukti']);
            $sheet->setCellValue("C$detail_start_row", $response_detail['jumlahhari']);
            $sheet->setCellValue("D$detail_start_row", $response_detail['nopolisi']);
            $sheet->setCellValue("E$detail_start_row", $response_detail['keterangan']);
            $sheet->setCellValue("F$detail_start_row", $response_detail['nominals']);

            $sheet->getStyle("E$detail_start_row")->getAlignment()->setWrapText(true);
            $sheet->getColumnDimension('E')->setWidth(50);

            $sheet ->getStyle("A$detail_start_row:E$detail_start_row")->applyFromArray($styleArray);
            $sheet ->getStyle("F$detail_start_row")->applyFromArray($style_number);
            $nominal += $response_detail['nominal'];
            $detail_start_row++;
        }

        $total_start_row = $detail_start_row;
        $sheet->mergeCells('A'.$total_start_row.':E'.$total_start_row);
        $sheet->setCellValue("A$total_start_row", 'Total')->getStyle('A'.$total_start_row.':E'.$total_start_row)->applyFromArray($styleArray)->getFont()->setBold(true);
        $sheet->setCellValue("F$total_start_row", number_format((float) $nominal, '2', '.', ','))->getStyle("F$detail_start_row")->applyFromArray($style_number)->getFont()->setBold(true);

        $sheet->getColumnDimension('A')->setAutoSize(true);
        $sheet->getColumnDimension('B')->setAutoSize(true);
        $sheet->getColumnDimension('C')->setAutoSize(true);
        $sheet->getColumnDimension('D')->setAutoSize(true);
        $sheet->getColumnDimension('F')->setAutoSize(true);

        $writer = new Xlsx($spreadsheet);
        $filename = 'Laporan Invoice Extra Gandengan' . date('dmYHis');
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }

}

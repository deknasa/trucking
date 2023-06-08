<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use stdClass;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Client\ConnectionException;

class PengembalianKasGantungHeaderController extends MyController
{
    public $title = 'Pengembalian Kas Gantung';

    public function index(Request $request)
    {
        $title = $this->title;
        
        $data = [
            'combocetak' => $this->comboCetak('list', 'STATUSCETAK', 'STATUSCETAK'),
        ];

        return view('pengembaliankasgantung.index', compact('title', 'data'));
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
            ->get(config('app.api_url') . 'pengembaliankasgantung', $params);

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

    public function report(Request $request)
    {
        //FETCH HEADER
        $pengembaliankasgantung = Http::withHeaders($request->header())
        ->withOptions(['verify' => false])
        ->withToken(session('access_token'))
        ->get(config('app.api_url') .'pengembaliankasgantungheader/'.$request->id);
        
        //FETCH DETAIL
        $detailParams = [
            'forReport' => true,
            'pengembaliankasgantung_id' => $request->id
        ];

        $responses = Http::withHeaders(request()->header())
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') .'pengembaliankasgantung_detail', $detailParams);

        $data = $pengembaliankasgantung['data'];
        $pengembaliankasgantung_details = $responses['data'];
        $user = $responses['user'];

        return view('reports.pengembaliankasgantungheader', compact('data','pengembaliankasgantung_details','user'));
    }

    public function export(Request $request): void
    {
        //FETCH HEADER
        $id = $request->id;
        $data = Http::withHeaders($request->header())
        ->withOptions(['verify' => false])
        ->withToken(session('access_token'))
        ->get(config('app.api_url') .'pengembaliankasgantungheader/'.$id.'/export');

         //FETCH DETAIL
         $detailParams = [
            'pengembaliankasgantung_id' => $request->id
        ];
        $responses = Http::withHeaders(request()->header())
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') .'pengembaliankasgantung_detail', $detailParams);

        $pengembaliankasgantung = $data['data'];
        $pengembaliankasgantung_details = $responses['data'];
        $user = $responses['user'];

        $tglBukti = $pengembaliankasgantung["tglbukti"];
        $timeStamp = strtotime($tglBukti);
        $dateTglBukti = date('d-m-Y', $timeStamp); 

        $tglDari = $pengembaliankasgantung["tgldari"];
        $timeStampDari = strtotime($tglDari);
        $dateTglDari = date('d-m-Y', $timeStampDari); 

        $tglSampai = $pengembaliankasgantung["tglsampai"];
        $timeStampSampai = strtotime($tglSampai);
        $dateTglSampai = date('d-m-Y', $timeStampSampai); 

        $tglKasMasuk = $pengembaliankasgantung["tglkasmasuk"];
        $timeStampKasMasuk = strtotime($tglKasMasuk);
        $dateTglKasMasuk = date('d-m-Y', $timeStampKasMasuk); 

        $pengembaliankasgantung['tglbukti'] = $dateTglBukti;
        $pengembaliankasgantung['tgldari'] = $dateTglDari;
        $pengembaliankasgantung['tglsampai'] = $dateTglSampai;
        $pengembaliankasgantung['tglkasmasuk'] = $dateTglKasMasuk;

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'TAS '.$user['nama_cabang']);
        $sheet->setCellValue('A2', 'Pengembalian Kas Gantung');
        $sheet->getStyle("A1")->getFont()->setSize(20);
        $sheet->getStyle("A2")->getFont()->setSize(16);
        $sheet->getStyle("A1")->getFont()->setBold(true);
        $sheet->getStyle("A2")->getFont()->setBold(true);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal('center');
        $sheet->getStyle('A2')->getAlignment()->setHorizontal('center');
        $sheet->mergeCells('A1:E1');
        $sheet->mergeCells('A2:E2');

        $header_start_row = 4;
        $detail_table_header_row = 15;
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
                'label' => 'No Bukti Penerimaan',
                'index' => 'penerimaan_nobukti',
            ],
            [
                'label' => 'Bank',
                'index' => 'bank',
            ],
            [
                'label' => 'COA Kas Masuk',
                'index' => 'coakasmasuk',
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
                'label' => 'Tanggal Kas Masuk',
                'index' => 'tglkasmasuk',
            ],
            [
                'label' => 'Posting Dari',
                'index' => 'postingdari',
            ],
        ];

        $detail_columns = [
            [
                'label' => 'No',
            ],
            [
                'label' => 'No Bukti Kas Gantung',
                'index' => 'kasgantung_nobukti',
            ],
            [
                'label' => 'Keterangan',
                'index' => 'keterangan',
            ],
            [
                'label' => 'COA',
                'index' => 'coa',
            ],
            [
                'label' => 'Nominal',
                'index' => 'nominal',
                'format' => 'currency'
            ],
        ];

        //LOOPING HEADER        
        foreach ($header_columns as $header_column) {
            $sheet->setCellValue('B' . $header_start_row, $header_column['label']);
              
                $sheet->setCellValue('C' . $header_start_row++, ': '.$pengembaliankasgantung[$header_column['index']]);
           
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
        foreach ($pengembaliankasgantung_details as $response_index => $response_detail) {
            
            foreach ($detail_columns as $detail_columns_index => $detail_column) {
                $sheet->setCellValue($alphabets[$detail_columns_index] . $detail_start_row, isset($detail_column['index']) ? $response_detail[$detail_column['index']] : $response_index + 1);
            }
            $response_detail['nominals'] = number_format((float) $response_detail['nominal'], '2', ',', '.');
        
            $sheet->setCellValue("A$detail_start_row", $response_index + 1);    
            $sheet->setCellValue("B$detail_start_row", $response_detail['kasgantung_nobukti']);
            $sheet->setCellValue("C$detail_start_row", $response_detail['keterangan']);
            $sheet->setCellValue("D$detail_start_row", $response_detail['coa']);
            $sheet->setCellValue("E$detail_start_row", $response_detail['nominals']);

            $sheet ->getStyle("A$detail_start_row:E$detail_start_row")->applyFromArray($styleArray);
            $sheet ->getStyle("E$detail_start_row")->applyFromArray($style_number);
            $nominal += $response_detail['nominal'];
            $detail_start_row++;
        }

        $total_start_row = $detail_start_row;
        $sheet->mergeCells('A'.$total_start_row.':D'.$total_start_row);
        $sheet->setCellValue("A$total_start_row", 'Total :')->getStyle('A'.$total_start_row.':E'.$total_start_row)->applyFromArray($style_number)->getFont()->setBold(true);
        $sheet->setCellValue("E$total_start_row", number_format((float) $nominal, '2', ',', '.'))->getStyle("E$detail_start_row")->applyFromArray($style_number)->getFont()->setBold(true);

        // set diketahui dibuat
        $ttd_start_row = $total_start_row+2;
        $sheet->setCellValue("B$ttd_start_row", 'Disetujui');
        $sheet->setCellValue("C$ttd_start_row", 'Diketahui');
        $sheet->setCellValue("D$ttd_start_row", 'Dibuat');
        $sheet ->getStyle("B$ttd_start_row:D$ttd_start_row")->applyFromArray($styleArray);
        
        $sheet->mergeCells("B".($ttd_start_row+1).":B".($ttd_start_row+3));      
        $sheet->mergeCells("C".($ttd_start_row+1).":C".($ttd_start_row+3));      
        $sheet->mergeCells("D".($ttd_start_row+1).":D".($ttd_start_row+3));      
        $sheet ->getStyle("B".($ttd_start_row+1).":B".($ttd_start_row+3))->applyFromArray($styleArray);
        $sheet ->getStyle("C".($ttd_start_row+1).":C".($ttd_start_row+3))->applyFromArray($styleArray);
        $sheet ->getStyle("D".($ttd_start_row+1).":D".($ttd_start_row+3))->applyFromArray($styleArray);

        //set tglcetak
        date_default_timezone_set('Asia/Jakarta');
        
        $sheet->setCellValue("B".($ttd_start_row+5), 'Dicetak Pada :');
        $sheet->getStyle("B".($ttd_start_row+5))->getFont()->setItalic(true);
        $sheet->setCellValue("C".($ttd_start_row+5), date('d-m-Y H:i:s'));
        $sheet->getStyle("C".($ttd_start_row+5))->getFont()->setItalic(true);
        $sheet->setCellValue("D".($ttd_start_row+5), $user['name']);
        $sheet->getStyle("D".($ttd_start_row+5))->getFont()->setItalic(true);

        $sheet->getColumnDimension('A')->setAutoSize(true);
        $sheet->getColumnDimension('B')->setAutoSize(true);
        $sheet->getColumnDimension('C')->setAutoSize(true);
        $sheet->getColumnDimension('D')->setAutoSize(true);
        $sheet->getColumnDimension('E')->setAutoSize(true);

        $writer = new Xlsx($spreadsheet);
        $filename = 'Laporan Pengembalian Kas Gantung' . date('dmYHis');
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }
}

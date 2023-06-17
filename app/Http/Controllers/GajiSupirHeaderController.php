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

    public function report(Request $request)
    {
        
        $header = Http::withHeaders(request()->header())
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'gajisupirheader/' . $request->id);

        $detailParams = [
            'forReport' => true,
            'gajisupir_id' => $request->id
        ];
  
        $gajisupir_detail = Http::withHeaders(request()->header())
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'gajisupirdetail', $detailParams);
        
        $data = $header['data'];
        $gajisupir_details = $gajisupir_detail['data'];
        $user = Auth::user();
        return view('reports.gajisupir', compact('data','gajisupir_details','user'));
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
        $sheet->getStyle("A1")->getFont()->setSize(14);
        $sheet->getStyle("A2")->getFont()->setSize(12);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal('center');
        $sheet->getStyle('A2')->getAlignment()->setHorizontal('center');
        $sheet->mergeCells('A1:P1');
        $sheet->mergeCells('A2:P2');

        $header_start_row = 4;
        $detail_table_header_row = 18;
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
            ],
            [
                'label' => 'Total',
                'index' => 'total',
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
                'label' => 'Uang Jalan',
                'index' => 'uangjalan',
                'format' => 'currency'
            ],
            [
                'label' => 'Uang BBM',
                'index' => 'bbm',
                'format' => 'currency'
            ],
            [
                'label' => 'Deposito',
                'index' => 'deposito',
                'format' => 'currency'
            ],
            [
                'label' => 'Potongan Pinjaman',
                'index' => 'potonganpinjaman',
                'format' => 'currency'
            ],
            [
                'label' => 'Potongan Pinjaman Semua',
                'index' => 'potonganpinjamansemua',
                'format' => 'currency'
            ],
            [
                'label' => 'Uang Makan Harian',
                'index' => 'uangmakanharian',
                'format' => 'currency'
            ],
            [
                'label' => 'Nominal',
                'index' => 'nominal',
                'format' => 'currency'
            ],
        ];

        $detail_columns = [
            [
                'label' => 'No',
            ],
            [
                'label' => 'No Trip',
                'index' => 'nobukti',
            ],
            [
                'label' => 'No SP',
                'index' => 'nosp',
            ],
            [
                'label' => 'Tanggal SP',
                'index' => 'tglsp',
            ],
            [
                'label' => 'No Cont',
                'index' => 'nocont',
            ],
            [
                'label' => 'Tanggal Dari',
                'index' => 'dari',
            ],
            [
                'label' => 'Tanggal Sampai',
                'index' => 'sampai',
            ],
            [
                'label' => 'Gaji Supir',
                'index' => 'gajisupir',
                'format' => 'currency'
            ],
            [
                'label' => 'Gaji Kenek',
                'index' => 'gajikenek',
                'format' => 'currency'
            ],
            [
                'label' => 'Komisi Supir',
                'index' => 'komisisupir',
                'format' => 'currency'
            ],
            [
                'label' => 'Tol Supir',
                'index' => 'tolsupir',
                'format' => 'currency'
            ],
            [
                'label' => 'No Bukti Ritasi',
                'index' => 'ritasi_nobukti',
            ],
            [
                'label' => 'Upah Ritasi',
                'index' => 'upahritasi',
                'format' => 'currency'
            ],
            [
                'label' => 'Status Ritasi',
                'index' => 'statusritasi',
            ],
            [
                'label' => 'Keterangan Biaya Tambahan',
                'index' => 'keteranganbiayatambahan',
            ],
            [
                'label' => 'Biaya Extra',
                'index' => 'biayaextra',
                'format' => 'currency'
            ],
        ];

        //LOOPING HEADER    

        $gajisupirs['nominal'] = number_format((float) $gajisupirs['nominal'], '2', '.', ','); 
        $gajisupirs['uangjalan'] = number_format((float) $gajisupirs['uangjalan'], '2', '.', ',');  
        $gajisupirs['bbm'] = number_format((float) $gajisupirs['bbm'], '2', '.', ',');
        $gajisupirs['deposito'] = number_format((float) $gajisupirs['deposito'], '2', '.', ',');
        $gajisupirs['potonganpinjaman'] = number_format((float) $gajisupirs['potonganpinjaman'], '2', '.', ',');
        $gajisupirs['potonganpinjamansemua'] = number_format((float) $gajisupirs['potonganpinjamansemua'], '2', '.', ',');
        $gajisupirs['uangmakanharian'] = number_format((float) $gajisupirs['uangmakanharian'], '2', '.', ',');
        $gajisupirs['total'] = number_format((float) $gajisupirs['total'], '2', '.', ',');
        foreach ($header_columns as $header_column) {
            $sheet->setCellValue('B' . $header_start_row, $header_column['label']);
            $sheet->setCellValue('C' . $header_start_row++, ': '.$gajisupirs[$header_column['index']]);
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
        $gajikenek = 0;
        $komisisupir = 0;
        $tolsupir = 0;
        $upahritasi = 0; 
        $biayaextra = 0; 
        foreach ($gajisupir_details as $response_index => $response_detail) {
            
            foreach ($detail_columns as $detail_columns_index => $detail_column) {
                $sheet->setCellValue($alphabets[$detail_columns_index] . $detail_start_row, isset($detail_column['index']) ? $response_detail[$detail_column['index']] : $response_index + 1);
            }
            $response_detail['gajisupirs'] = number_format((float) $response_detail['gajisupir'], '2', '.', ',');
            $response_detail['gajikeneks'] = number_format((float) $response_detail['gajikenek'], '2', '.', ',');
            $response_detail['komisisupirs'] = number_format((float) $response_detail['komisisupir'], '2', '.', ',');
            $response_detail['tolsupirs'] = number_format((float) $response_detail['tolsupir'], '2', '.', ',');
            $response_detail['upahritasis'] = number_format((float) $response_detail['upahritasi'], '2', '.', ',');
            $response_detail['biayaextras'] = number_format((float) $response_detail['biayaextra'], '2', '.', ',');
        
            $sheet->setCellValue("A$detail_start_row", $response_index + 1);
            $sheet->setCellValue("B$detail_start_row", $response_detail['nobukti']);
            $sheet->setCellValue("C$detail_start_row", $response_detail['nosp']);
            $sheet->setCellValue("D$detail_start_row", $response_detail['tglsp']);
            $sheet->setCellValue("E$detail_start_row", $response_detail['nocont']);
            $sheet->setCellValue("F$detail_start_row", $response_detail['dari']);
            $sheet->setCellValue("G$detail_start_row", $response_detail['sampai']);
            $sheet->setCellValue("H$detail_start_row", $response_detail['gajisupirs']);
            $sheet->setCellValue("I$detail_start_row", $response_detail['gajikeneks']);
            $sheet->setCellValue("J$detail_start_row", $response_detail['komisisupirs']);
            $sheet->setCellValue("K$detail_start_row", $response_detail['tolsupirs']);
            $sheet->setCellValue("L$detail_start_row", $response_detail['ritasi_nobukti']);
            $sheet->setCellValue("M$detail_start_row", $response_detail['upahritasis']);
            $sheet->setCellValue("N$detail_start_row", $response_detail['statusritasi']);
            $sheet->setCellValue("O$detail_start_row", $response_detail['keteranganbiayatambahan']);
            $sheet->setCellValue("P$detail_start_row", $response_detail['biayaextras']);

            $sheet ->getStyle("A$detail_start_row:G$detail_start_row")->applyFromArray($styleArray);
            $sheet ->getStyle("H$detail_start_row:K$detail_start_row")->applyFromArray($style_number);
            $sheet ->getStyle("L$detail_start_row")->applyFromArray($styleArray);
            $sheet->getStyle("L" . ($detail_start_row + 1))->applyFromArray($styleArray);
            $sheet ->getStyle("N$detail_start_row:O$detail_start_row")->applyFromArray($styleArray);
            $sheet->getStyle("N" . ($detail_start_row + 1) . ":O" . ($detail_start_row + 1))->applyFromArray($styleArray);
            $sheet ->getStyle("M$detail_start_row")->applyFromArray($style_number);
            $sheet ->getStyle("N$detail_start_row")->applyFromArray($styleArray);
            $sheet ->getStyle("P$detail_start_row")->applyFromArray($style_number);

            $gajisupir += $response_detail['gajisupir'];
            $gajikenek += $response_detail['gajikenek'];
            $komisisupir += $response_detail['komisisupir'];
            $tolsupir += $response_detail['tolsupir'];
            $upahritasi += $response_detail['upahritasi'];
            $biayaextra += $response_detail['biayaextra'];
            $detail_start_row++;
        }

        $total_start_row = $detail_start_row;
        $sheet->mergeCells('A'.$total_start_row.':G'.$total_start_row);
        $sheet->setCellValue("A$total_start_row", 'Total :')->getStyle('A'.$total_start_row.':G'.$total_start_row)->applyFromArray($style_number)->getFont()->setBold(true);
        $sheet->setCellValue("H$total_start_row", number_format((float) $gajisupir, '2', '.', ','))->getStyle("H$detail_start_row")->applyFromArray($style_number)->getFont()->setBold(true);
        $sheet->setCellValue("I$total_start_row", number_format((float) $gajikenek, '2', '.', ','))->getStyle("I$detail_start_row")->applyFromArray($style_number)->getFont()->setBold(true);
        $sheet->setCellValue("J$total_start_row", number_format((float) $komisisupir, '2', '.', ','))->getStyle("J$detail_start_row")->applyFromArray($style_number)->getFont()->setBold(true);
        $sheet->setCellValue("K$total_start_row", number_format((float) $tolsupir, '2', '.', ','))->getStyle("K$detail_start_row")->applyFromArray($style_number)->getFont()->setBold(true);
        $sheet->setCellValue("M$total_start_row", number_format((float) $upahritasi, '2', '.', ','))->getStyle("M$detail_start_row")->applyFromArray($style_number)->getFont()->setBold(true);
        $sheet->setCellValue("P$total_start_row", number_format((float) $biayaextra, '2', '.', ','))->getStyle("P$detail_start_row")->applyFromArray($style_number)->getFont()->setBold(true);

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
        $filename = 'Laporan Gaji Supir  ' . date('dmYHis');
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }

}
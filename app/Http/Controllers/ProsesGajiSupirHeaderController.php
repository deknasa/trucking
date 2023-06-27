<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class ProsesGajiSupirHeaderController extends MyController
{
    public $title = 'Proses Gaji Supir';

    public function index(Request $request)
    {
        $title = $this->title;
        $data = [
            'comboapproval' => $this->comboList('list', 'STATUS APPROVAL', 'STATUS APPROVAL'),
            'combocetak' => $this->comboList('list', 'STATUSCETAK', 'STATUSCETAK')
        ];
        return view('prosesgajisupirheader.index', compact('title', 'data'));
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
            ->get(config('app.api_url') . 'prosesgajisupirheader', $params);

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
        $prosesgajisupir = Http::withHeaders($request->header())
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'prosesgajisupirheader/'.$id.'/export')['data'];

        $detailParams = [
            'forReport' => true,
            'prosesgajisupir_id' => $request->id
        ];

        $prosesgajisupir_detail = Http::withHeaders(request()->header())
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'prosesgajisupirdetail', $detailParams)['data'];

        $combo = $this->combo('list');
        $key = array_search('CETAK', array_column( $combo, 'parameter')); 
        $prosesgajisupir["combo"] =  $combo[$key];
        return view('reports.prosesgajisupir', compact('prosesgajisupir', 'prosesgajisupir_detail'));
    }

    public function export(Request $request): void
    {
        //FETCH HEADER
        $id = $request->id;
        $prosesgajisupirs = Http::withHeaders($request->header())
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'prosesgajisupirheader/'.$id.'/export')['data'];
            
        //FETCH DETAIL
        $detailParams = [
            'prosesgajisupir_id' => $request->id
        ];

        $responses = Http::withHeaders($request->header())
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'prosesgajisupirdetail', $detailParams);

        $prosesgajisupir_details = $responses['data'];
        //$user = Auth::user();

        $tglBukti = $prosesgajisupirs["tglbukti"];
        $timeStamp = strtotime($tglBukti);
        $dateTglBukti = date('d-m-Y', $timeStamp); 
        $prosesgajisupirs['tglbukti'] = $dateTglBukti;

        $tglPeriode = $prosesgajisupirs["periode"];
        $timeStamp = strtotime($tglPeriode);
        $dateTglPeriode = date('d-m-Y', $timeStamp); 
        $prosesgajisupirs['periode'] = $dateTglPeriode;

        $tgldari = $prosesgajisupirs["tgldari"];
        $timeStamp = strtotime($tgldari);
        $datetgldari = date('d-m-Y', $timeStamp); 
        $prosesgajisupirs['tgldari'] = $datetgldari;

        $tglsampai = $prosesgajisupirs["tglsampai"];
        $timeStamp = strtotime($tglsampai);
        $datetglsampai = date('d-m-Y', $timeStamp); 
        $prosesgajisupirs['tglsampai'] = $datetglsampai;

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', $prosesgajisupirs['judul']);
        $sheet->setCellValue('A2', $prosesgajisupirs['judulLaporan']);
        $sheet->getStyle("A1")->getFont()->setSize(12);
        $sheet->getStyle("A2")->getFont()->setSize(12);
        $sheet->getStyle("A1")->getFont()->setBold(true);
        $sheet->getStyle("A2")->getFont()->setBold(true);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal('center');
        $sheet->getStyle('A2')->getAlignment()->setHorizontal('center');
        $sheet->mergeCells('A1:M1');
        $sheet->mergeCells('A2:M2');
        
        $tgldari = date('d-m-Y', strtotime($prosesgajisupirs['tgldari']));
        $tglsampai = date('d-m-Y', strtotime($prosesgajisupirs['tglsampai']));
        $prosesgajisupirs['keterangan'] = "GAJI SUPIR PERIODE $tgldari S/D $tglsampai";

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
                'label' => 'Tanggal Bukti',
                'index' => 'tglbukti',
            ],
            [
                'label' => 'Periode',
                'index' => 'periode',
            ],
        ];

        $header_right_columns = [
            [
                'label' => 'Tanggal Dari',
                'index' => 'tgldari',
            ],
            [
                'label' => 'Tanggal Sampai',
                'index' => 'tglsampai',
            ],
        ];

        $detail_columns = [
            [
                'label' => 'NO',
            ],
            [
                'label' => 'NO RINCIAN',
                'index' => 'gajisupir_nobukti',
            ],
            [
                'label' => 'SUPIR',
                'index' => 'supir_id',
            ],
            [
                'label' => 'TRADO',
                'index' => 'trado_id',
            ],
            [
                'label' => 'UANG JALAN',
                'index' => 'uangjalan',
                'format' => 'currency'
            ],
            [
                'label' => 'HUTANG BBM',
                'index' => 'bbm',
                'format' => 'currency'
            ],
            [
                'label' => 'UANG MAKAN',
                'index' => 'uangmakanharian',
                'format' => 'currency'
            ],
            [
                'label' => 'POT. PINJAMAN',
                'index' => 'potonganpinjaman',
                'format' => 'currency'
            ],
            [
                'label' => 'POT. PINJAMAN SEMUA',
                'index' => 'potonganpinjamansemua',
                'format' => 'currency'
            ],
            
            [
                'label' => 'DEPOSITO',
                'index' => 'deposito',
                'format' => 'currency'
            ],
            [
                'label' => 'KOMISI SUPIR',
                'index' => 'komisisupir',
                'format' => 'currency'
            ],
            [
                'label' => 'TOL SUPIR',
                'index' => 'tolsupir',
                'format' => 'currency'
            ],
            [
                'label' => 'BORONGAN',
                'index' => 'total',
                'format' => 'currency'
            ]
        ];

        //LOOPING HEADER      
        foreach ($header_columns as $header_column) {
            $sheet->setCellValue('B' . $header_start_row, $header_column['label']);
            $sheet->setCellValue('C' . $header_start_row++, ': ' . $prosesgajisupirs[$header_column['index']]);
        }
        foreach ($header_right_columns as $header_right_column) {
            $sheet->setCellValue('D' . $header_right_start_row, $header_right_column['label']);
            $sheet->setCellValue('E' . $header_right_start_row++, ': '.$prosesgajisupirs[$header_right_column['index']]);
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
        $sheet->getStyle("A$detail_table_header_row:M$detail_table_header_row")->applyFromArray($styleArray);

        // LOOPING DETAIL
        $borongan = 0;
        foreach ($prosesgajisupir_details as $response_index => $response_detail) {

            foreach ($detail_columns as $detail_columns_index => $detail_column) {
                $sheet->setCellValue($alphabets[$detail_columns_index] . $detail_start_row, isset($detail_column['index']) ? $response_detail[$detail_column['index']] : $response_index + 1);
            }
            $response_detail['totals'] = number_format((float) $response_detail['total'], '2', '.', ',');
            $response_detail['uangjalans'] = number_format((float) $response_detail['uangjalan'], '2', '.', ',');
            $response_detail['bbms'] = number_format((float) $response_detail['bbm'], '2', '.', ',');
            $response_detail['uangmakanharians'] = number_format((float) $response_detail['uangmakanharian'], '2', '.', ',');
            $response_detail['potonganpinjamans'] = number_format((float) $response_detail['potonganpinjaman'], '2', '.', ',');
            $response_detail['potonganpinjamansemuas'] = number_format((float) $response_detail['potonganpinjamansemua'], '2', '.', ',');
            $response_detail['depositos'] = number_format((float) $response_detail['deposito'], '2', '.', ',');
            $response_detail['komisisupirs'] = number_format((float) $response_detail['komisisupir'], '2', '.', ',');
            $response_detail['tolsupirs'] = number_format((float) $response_detail['tolsupir'], '2', '.', ',');

            $sheet->setCellValue("A$detail_start_row", $response_index + 1);
            $sheet->setCellValue("B$detail_start_row", $response_detail['gajisupir_nobukti']);
            $sheet->setCellValue("C$detail_start_row", $response_detail['supir_id']);
            $sheet->setCellValue("D$detail_start_row", $response_detail['trado_id']);
            $sheet->setCellValue("E$detail_start_row", $response_detail['uangjalans']);
            $sheet->setCellValue("F$detail_start_row", $response_detail['bbms']);
            $sheet->setCellValue("G$detail_start_row", $response_detail['uangmakanharians']);
            $sheet->setCellValue("H$detail_start_row", $response_detail['potonganpinjamans']);
            $sheet->setCellValue("I$detail_start_row", $response_detail['potonganpinjamansemuas']);
            $sheet->setCellValue("J$detail_start_row", $response_detail['depositos']); 
            $sheet->setCellValue("K$detail_start_row", $response_detail['komisisupirs']);
            $sheet->setCellValue("L$detail_start_row", $response_detail['tolsupirs']);
            $sheet->setCellValue("M$detail_start_row", $response_detail['totals']);
            
            $sheet->getStyle("A$detail_start_row:D$detail_start_row")->applyFromArray($styleArray);
            $sheet->getStyle("E$detail_start_row:M$detail_start_row")->applyFromArray($style_number);
            $borongan += $response_detail['total'];
            $detail_start_row++;
        }

        $total_start_row = $detail_start_row;
        $sheet->mergeCells('A' . $total_start_row . ':L' . $total_start_row);
        $sheet->setCellValue("A$total_start_row", 'Total :')->getStyle('A' . $total_start_row . ':L' . $total_start_row)->applyFromArray($styleArray)->getFont()->setBold(true);
        $sheet->setCellValue("M$total_start_row", number_format((float) $borongan, '2', '.', ','))->getStyle("M$detail_start_row")->applyFromArray($style_number)->getFont()->setBold(true);
        
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

        $writer = new Xlsx($spreadsheet);
        $filename = 'Laporan Proses Gaji Supir ' . date('dmYHis');
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }
}

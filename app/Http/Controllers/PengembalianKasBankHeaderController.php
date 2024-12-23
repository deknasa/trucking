<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\View\View;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class PengembalianKasBankHeaderController extends MyController
{
    public $title = 'Pengembalian Kas Bank';

    public function index(Request $request)
    {
        $title = $this->title;
        $data = [
            'comboapproval' => $this->comboList('list','STATUS APPROVAL','STATUS APPROVAL'),
            'combocetak' => $this->comboList('list','STATUSCETAK','STATUSCETAK'), 
            'combojenistransaksi' => $this->comboList('list','JENIS TRANSAKSI','JENIS TRANSAKSI'),
            'combobank' => $this->comboBank(),
        ];
        return view('pengembaliankasbank.index', compact('title','data'));

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
    
    public function comboBank()
    {
        $data = [
            'tipe' => 'BANK'
        ];
        $response = Http::withHeaders($this->httpHeaders)
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'bank', $data);

        return $response['data'];
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
            ->get(config('app.api_url') . 'pengembaliankasbank', $params);

        $data = [
            'total' => $response['attributes']['totalPages'] ?? [],
            'records' => $response['attributes']['totalRows'] ?? [],
            'rows' => $response['data'] ?? [],
            'params' => $response['params'] ?? [],
        ];

        return $data;
    }
    public function comboApproval($aksi, $grp, $subgrp)
    {

        $status = [
            'status' => $aksi,
            'grp' => $grp,
            'subgrp' => $subgrp,
        ];

        $response = Http::withHeaders($this->httpHeaders)
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'hutangbayarheader/comboapproval', $status);

        return $response['data'];
    }


    public function report(Request $request)
    {
        
        //FETCH HEADER
        $pengembaliankasbankheader = Http::withHeaders($request->header())
        ->withOptions(['verify' => false])
        ->withToken(session('access_token'))
        ->get(config('app.api_url') .'pengembaliankasbankheader/'.$request->id)['data'];
        $data = $pengembaliankasbankheader;
        //FETCH DETAIL 
        $response = Http::withHeaders($this->httpHeaders)
        ->withOptions(['verify' => false])
        ->withToken(session('access_token'))
        ->get(config('app.api_url') . 'pengembaliankasbankdetail', ['pengembaliankasbank_id' => $pengembaliankasbankheader['id']]);
        $data["details"] =$response['data'];
        $data["user"] = Auth::user();
        $pengembaliankasbankheader = $data;
        
        return view('reports.pengembaliankasbank', compact('pengembaliankasbankheader'));
    }

    public function export(Request $request): void
    {
        
        //FETCH HEADER
        $pengeluarans = Http::withHeaders($request->header())
        ->withOptions(['verify' => false])
        ->withToken(session('access_token'))
        ->get(config('app.api_url') .'pengembaliankasbankheader/'.$request->id)['data'];

        //FETCH DETAIL
        $detailParams = [
            'pengembaliankasbank_id' => $request->id,
        ];

        $responses = Http::withHeaders($request->header())
        ->withOptions(['verify' => false])
        ->withToken(session('access_token'))
        ->get(config('app.api_url') .'pengembaliankasbankdetail', $detailParams);

        $pengeluaran_details = $responses['data'];
        $user =   Auth::user();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'PENGEMBALIAN KASBANK HEADER');
        $sheet->getStyle("A1")->getFont()->setSize(20);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal('center');
        $sheet->mergeCells('A1:G1');

        $header_start_row = 2;
        $header_right_start_row = 2;
        $detail_table_header_row = 12;
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
                'label' => 'No Bukti Pengeluaran ',
                'index' => 'pengeluaran_nobukti',
            ],
            [
                'label' => 'Dibayarkan ke',
                'index' => 'dibayarke',
            ],
            [
                'label' => 'Keterangan',
                'index' => 'keterangan',
            ],
            [
                'label' => 'Bank',
                'index' => 'bank',
            ],
            [
                'label' => 'Transfer ke Acc.',
                'index' => 'transferkeac',
            ],
            [
                'label' => 'Transfer ke An.',
                'index' => 'transferkean',
            ],
            [
                'label' => 'Transfer ke Bank',
                'index' => 'transferkebank',
            ],
        ];

        $detail_columns = [
            [
                'label' => 'No',
            ],
            [
                'label' => 'Alat Bayar',
                'index' => 'alatbayar_id',
            ],
            [
                'label' => 'No Warkat',
                'index' => 'nowarkat',
            ],
            [
                'label' => 'Tgl Jatuh Tempo',
                'index' => 'tgljatuhtempo',
            ],
            [
                'label' => 'COA Debet',
                'index' => 'coadebet',
            ],
            [
                'label' => 'COA Kredit',
                'index' => 'coakredit'
            ],
            [
                'label' => 'Bulan Beban',
                'index' => 'bulanbeban'
            ],
            [
                'label' => 'Keterangan',
                'index' => 'keterangan'
            ],
            [
                'label' => 'Nominal',
                'index' => 'nominal',
                'format' => 'currency'
            ]
        ];

        //LOOPING HEADER        
        foreach ($header_columns as $header_column) {
            $sheet->setCellValue('B' . $header_start_row, $header_column['label']);
            
                $sheet->setCellValue('C' . $header_start_row++, ': '.$pengeluarans[$header_column['index']]);
           
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
        $sheet ->getStyle("A$detail_table_header_row:I$detail_table_header_row")->applyFromArray($styleArray);

        // LOOPING DETAIL
        $nominal = 0;
        foreach ($pengeluaran_details as $response_index => $response_detail) {
            
            foreach ($detail_columns as $detail_columns_index => $detail_column) {
                $sheet->setCellValue($alphabets[$detail_columns_index] . $detail_start_row, isset($detail_column['index']) ? $response_detail[$detail_column['index']] : $response_index + 1);
            }
            $response_detail['nominals'] = number_format((float) $response_detail['nominal'], '2', ',', '.');
        
            $sheet->setCellValue("A$detail_start_row", $response_index + 1);
            $sheet->setCellValue("B$detail_start_row", $response_detail['alatbayar_id']);
            $sheet->setCellValue("C$detail_start_row", $response_detail['nowarkat']);
            $sheet->setCellValue("D$detail_start_row", $response_detail['tgljatuhtempo']);
            $sheet->setCellValue("E$detail_start_row", $response_detail['coadebet']);
            $sheet->setCellValue("F$detail_start_row", $response_detail['coakredit']);
            $sheet->setCellValue("G$detail_start_row", $response_detail['bulanbeban']);
            $sheet->setCellValue("H$detail_start_row", $response_detail['keterangan']);
            $sheet->setCellValue("I$detail_start_row", $response_detail['nominals']);

            $sheet ->getStyle("A$detail_start_row:I$detail_start_row")->applyFromArray($styleArray);
            $sheet ->getStyle("I$detail_start_row")->applyFromArray($style_number);
            $nominal += $response_detail['nominal'];
            $detail_start_row++;
        }

        $total_start_row = $detail_start_row;
        $sheet->mergeCells('A'.$total_start_row.':H'.$total_start_row);
        $sheet->setCellValue("A$total_start_row", 'Total')->getStyle('A'.$total_start_row.':H'.$total_start_row)->applyFromArray($style_number)->getFont()->setBold(true);
        $sheet->setCellValue("I$total_start_row", number_format((float) $nominal, '2', ',', '.'))->getStyle("I$detail_start_row")->applyFromArray($style_number)->getFont()->setBold(true);

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
        $sheet->setCellValue("C".($ttd_start_row+5), date('d/m/Y H:i:s'));
        $sheet->getStyle("C".($ttd_start_row+5))->getFont()->setItalic(true);
        $sheet->setCellValue("D".($ttd_start_row+5), $user['name']);
        $sheet->getStyle("D".($ttd_start_row+5))->getFont()->setItalic(true);

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
        $filename = 'Laporan Pengembalian Kas Bank  ' . date('dmYHis');
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }

}

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

class KasGantungHeaderController extends MyController
{
    public $title = 'Kas Gantung';

    /**
     * Fungsi index
     * @ClassName index
     */
    public function index(Request $request)
    {
        $title = $this->title;
        $data = [
            'combocetak' => $this->comboList('list','STATUSCETAK','STATUSCETAK'),
        ];
        return view('kasgantung.index', compact('title','data'));
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
            ->get(config('app.api_url') .'kasgantung', $params);

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
            ->get(config('app.api_url') . 'kasgantungheader/' . $request->id);

        $detailParams = [
            'forReport' => true,
            'kasgantung_id' => $request->id
        ];

        $kasgantung_detail = Http::withHeaders(request()->header())
            ->withToken(session('access_token'))
            ->get('http://localhost/trucking-laravel/public/api/kasgantungdetail', $detailParams);
       
        $data = $header['data'];
        $kasgantung_details = $kasgantung_detail['data'];
        $user = Auth::user();
        return view('reports.kasgantung', compact('data','kasgantung_details','user'));
    }

    public function export(Request $request): void
    {
        
        //FETCH HEADER
        $kasgantungs = Http::withHeaders($request->header())
        ->withOptions(['verify' => false])
        ->withToken(session('access_token'))
        ->get(config('app.api_url') .'kasgantungheader/'.$request->id)['data'];
        
        //FETCH DETAIL
        $detailParams = [
            'forExport' => true,
            'kasgantung_id' => $request->id
        ];

        $responses = Http::withHeaders($request->header())
        ->withOptions(['verify' => false])
        ->withToken(session('access_token'))
        ->get(config('app.api_url') .'kasgantungdetail', $detailParams);

        $kasgantung_details = $responses['data'];
        $user = $responses['user'];

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'TAS '.$user['cabang_id']);
        $sheet->getStyle("A1")->getFont()->setSize(20);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal('center');
        $sheet->mergeCells('A1:G1');

        $header_start_row = 2;
        $header_right_start_row = 2;
        $detail_table_header_row = 8;
        $detail_start_row = $detail_table_header_row + 1;
       
        $alphabets = range('A', 'Z');

        $header_columns = [
            [
                'label' => 'No Kas Gantung :',
                'index' => 'nobukti',
            ],
            [
                'label' => 'Tanggal :',
                'index' => 'tglbukti',
            ],
            [
                'label' => 'Bank :',
                'index' => 'bank',
            ],
            [
                'label' => 'Penerima :',
                'index' => 'penerima',
            ],
            [
                'label' => 'Keterangan :',
                'index' => 'keterangan',
            ],
        ];
        $header_right_columns = [
            [
                'label' => 'No Bukti Pengeluaran :',
                'index' => 'pengeluaran_nobukti',
            ],
            [
                'label' => 'COA Kas Keluar :',
                'index' => 'coakaskeluar',
            ],
            [
                'label' => 'Tanggal Kas Keluar :',
                'index' => 'tglkaskeluar',
            ],
        ];

        $detail_columns = [
            [
                'label' => 'No',
            ],
            [
                'label' => 'COA',
                'index' => 'coa',
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

        //LOOPING HEADER        
        foreach ($header_columns as $header_column) {
            $sheet->setCellValue('B' . $header_start_row, $header_column['label']);
            $sheet->setCellValue('C' . $header_start_row++, $kasgantungs[$header_column['index']]);
        }
        foreach ($header_right_columns as $header_right_column) {
            $sheet->setCellValue('E' . $header_right_start_row, $header_right_column['label']);
            $sheet->setCellValue('F' . $header_right_start_row++, $kasgantungs[$header_right_column['index']]);
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

        // LOOPING DETAIL
        $total = 0;
        foreach ($kasgantung_details as $response_index => $response_detail) {
            
            foreach ($detail_columns as $detail_columns_index => $detail_column) {
                $sheet->setCellValue($alphabets[$detail_columns_index] . $detail_start_row, isset($detail_column['index']) ? $response_detail[$detail_column['index']] : $response_index + 1);
            }
            $response_detail['nominals'] = number_format((float) $response_detail['nominal'], '2', ',', '.');
        
            $sheet->setCellValue("A$detail_start_row", $response_index + 1);
            $sheet->setCellValue("B$detail_start_row", $response_detail['coa']);
            $sheet->setCellValue("C$detail_start_row", $response_detail['keterangan']);
            $sheet->setCellValue("D$detail_start_row", $response_detail['nominals']);

            $sheet->getStyle("A$detail_start_row:C$detail_start_row")->applyFromArray($styleArray);
            $sheet->getStyle("D$detail_start_row")->applyFromArray($style_number);
            $total += $response_detail['nominal'];
            $detail_start_row++;
        }

        $total_start_row = $detail_start_row;
        $sheet->mergeCells('A'.$total_start_row.':C'.$total_start_row);
        $sheet->setCellValue("A$total_start_row", 'Total :')->getStyle('A'.$total_start_row.':C'.$total_start_row)->applyFromArray($style_number)->getFont()->setBold(true);
        $sheet->setCellValue("D$total_start_row", number_format((float) $total, '2', ',', '.'))->getStyle("D$detail_start_row")->applyFromArray($style_number)->getFont()->setBold(true);

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

        

        $writer = new Xlsx($spreadsheet);
        $filename = 'Kas Gantung ' . date('dmYHis');
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }
    private function combo()
    {
        $response = Http::withHeaders($this->httpHeaders)
        ->withOptions(['verify' => false])
            ->get(config('app.api_url') . 'kasgantung/combo');
        
        return $response['data'];
    }
}

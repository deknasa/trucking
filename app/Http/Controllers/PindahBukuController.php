<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\RedirectResponse;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class PindahBukuController extends MyController
{
    public $title = 'Pindah Buku';

    public function index(Request $request)
    {
        $title = $this->title;
        $data = [            
            'combocetak' => $this->comboCetak('list','STATUSCETAK','STATUSCETAK'),
            'comboapproval' => $this->comboCetak('list','STATUS APPROVAL','STATUS APPROVAL'),
            'listbtn' => $this->getListBtn()
        ];
        return view('pindahbuku.index', compact('title', 'data'));
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

    public function get($params = [])
    {
        $params = [
            'offset' => $params['offset'] ?? request()->offset ?? ((request()->page - 1) * request()->rows),
            'limit' => $params['rows'] ?? request()->rows ?? 0,
            'sortIndex' => $params['sidx'] ?? request()->sidx,
            'sortOrder' => $params['sord'] ?? request()->sord,
            'search' => json_decode($params['filters'] ?? request()->filters, 1) ?? [],
        ];

        $response = Http::withHeaders(request()->header())
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'pindahbuku', $params);

        $data = [
            'total' => $response['attributes']['totalPages'] ?? [],
            'records' => $response['attributes']['totalRows'] ?? [],
            'rows' => $response['data'] ?? [],
            'params' => $params ?? [],
            'message' => $response['message'] ?? ''
        ];

        if (request()->ajax()) {
            return response($data, $response->status());
        }

        return $data;
    }


    public function comboreport($aksi)
    {
        $status = [
            'status' => $aksi,
            'grp' => 'STATUSCETAK',
            'subgrp' => 'STATUSCETAK',
        ];
        $response = Http::withHeaders($this->httpHeaders)->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'user/combostatus', $status);
        return $response['data'];
    }


    public function report(Request $request)
    {
        //FETCH HEADER
        $id = $request->id;
        $pindahbuku = Http::withHeaders($request->header())
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'pindahbuku/' . $id . '/export')['data'];

        $combo = $this->comboreport('list');
        $key = array_search('CETAK', array_column($combo, 'parameter'));
        $pindahbuku["combo"] =  $combo[$key];
        $printer['tipe'] = $request->printer;
        $cabang['cabang'] = session('cabang');
        return view('reports.pindahbuku', compact('pindahbuku','printer','cabang'));
    }

    public function export(Request $request): void
    {
        //FETCH HEADER
        $id = $request->id;
        $pindahBuku = Http::withHeaders($request->header())
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'pindahbuku/' . $id . '/export')['data'];

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', $pindahBuku['judul']);
        $sheet->setCellValue('A2', 'Laporan Pindah Buku ');
        $sheet->getStyle("A1")->getFont()->setSize(12);
        $sheet->getStyle("A2")->getFont()->setSize(12);
        $sheet->getStyle("A1")->getFont()->setBold(true);
        $sheet->getStyle("A2")->getFont()->setBold(true);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal('center');
        $sheet->getStyle('A2')->getAlignment()->setHorizontal('center');
        $sheet->mergeCells('A1:E1');
        $sheet->mergeCells('A2:E2');

        $header_start_row = 4;
        $header_start_row_right = 4;
        $detail_table_header_row = 10;
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
                'label' => 'Mutasi Dari',
                'index' => 'bankdari',
            ],
            [
                'label' => 'Mutasi Ke',
                'index' => 'bankke',
            ],
            [
                'label' => 'Keterangan',
                'index' => 'keterangan',
            ],
        ];

        $detail_columns = [
            [
                'label' => 'ALAT BAYAR',
                'index' => 'kodealatbayar'
            ],
            [
                'label' => 'TGL JATUH TEMPO',
                'index' => 'tgljatuhtempo'
            ],
            [
                'label' => 'NO WARKAT',
                'index' => 'nowarkat'
            ],
            [
                'label' => 'KETERANGAN',
                'index' => 'keterangan'
            ],
            [
                'label' => 'NOMINAL',
                'index' => 'nominal',
                'format' => 'currency'
            ]
        ];

        //LOOPING HEADER        
        foreach ($header_columns as $header_column) {
            $sheet->setCellValue('A' . $header_start_row, $header_column['label']);
            if($header_column['index'] == 'tglbukti'){
                $sheet->setCellValue('B' . $header_start_row++, ': ' . date('d-m-Y', strtotime($pindahBuku[$header_column['index']])));
            }else{
                $sheet->setCellValue('B' . $header_start_row++, ': ' . $pindahBuku[$header_column['index']]);
            }
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

        $sheet->getStyle("A$detail_table_header_row:E$detail_table_header_row")->getFont()->setBold(true);
        $sheet->getStyle("A$detail_table_header_row:E$detail_table_header_row")->applyFromArray($styleArray);
        $sheet->setCellValue("A$detail_start_row", $pindahBuku['kodealatbayar']);
        $sheet->setCellValue("B$detail_start_row", date('d-m-Y', strtotime($pindahBuku['tgljatuhtempo'])));
        $dateValue = ($pindahBuku['tgljatuhtempo'] != null) ? Date::PHPToExcel(date('Y-m-d',strtotime($pindahBuku['tgljatuhtempo']))) : ''; 
        $sheet->setCellValue("D$detail_start_row", $dateValue);
        $sheet->getStyle("D$detail_start_row") 
        ->getNumberFormat() 
        ->setFormatCode('dd-mm-yyyy');
        $sheet->setCellValue("C$detail_start_row", $pindahBuku['nowarkat']);
        $sheet->setCellValue("D$detail_start_row", $pindahBuku['keterangan']);
        $sheet->setCellValue("E$detail_start_row", $pindahBuku['nominal']);
        $sheet->getStyle('A' . $detail_start_row . ':D' . $detail_start_row)->applyFromArray($styleArray);
        $sheet->getStyle("E$detail_start_row")->applyFromArray($style_number)->getNumberFormat()->setFormatCode("#,##0.00_);(#,##0.00)");
        
        $total_start_row = $detail_start_row+1;
        $sheet->mergeCells('A' . $total_start_row . ':D' . $total_start_row);
        $sheet->setCellValue("A$total_start_row", 'Total')->getStyle('A' . $total_start_row . ':D' . $total_start_row)->applyFromArray($styleArray)->getFont()->setBold(true);
        $sheet->setCellValue("E$total_start_row", "=SUM(E11:E" . ($detail_start_row) . ")")->getStyle("E$detail_start_row")->applyFromArray($style_number)->getFont()->setBold(true);
        $sheet->getStyle("E$total_start_row")->applyFromArray($style_number)->getNumberFormat()->setFormatCode("#,##0.00_);(#,##0.00)");

        $sheet->getColumnDimension('A')->setAutoSize(true);
        $sheet->getColumnDimension('B')->setAutoSize(true);
        $sheet->getColumnDimension('C')->setAutoSize(true);
        $sheet->getColumnDimension('D')->setWidth(50);
        $sheet->getColumnDimension('E')->setAutoSize(true);

        $writer = new Xlsx($spreadsheet);
        $filename = 'Laporan Pindah Buku ' . date('dmYHis');
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }
}

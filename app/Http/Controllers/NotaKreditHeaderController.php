<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class NotaKreditHeaderController extends MyController
{
    public $title = 'Nota Kredit';

    public function index(Request $request){
        $title = $this->title;$data = [
            'comboapproval' => $this->comboList('list', 'STATUS APPROVAL', 'STATUS APPROVAL'),
            'combocetak' => $this->comboList('list', 'STATUSCETAK', 'STATUSCETAK'),
        ];
        return view('notakreditheader.index', compact('title','data'));
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
            ->get(config('app.api_url') . 'notakreditheader', $params);

        $data = [
            'total' => $response['attributes']['totalPages'] ?? [],
            'records' => $response['attributes']['totalRows'] ?? [],
            'rows' => $response['data'] ?? [],
            'params' => $response['params'] ?? [],
        ];

        return $data;
    }

    public function find($params,$id)
    {
        $params = [
            'offset' => $params['offset'] ?? request()->offset ?? ((request()->page - 1) * request()->rows),
            'limit' => $params['rows'] ?? request()->rows ?? 0,
            'sortIndex' => $params['sidx'] ?? request()->sidx,
            'sortOrder' => $params['sord'] ?? request()->sord,
            'search' => json_decode($params['filters'] ?? request()->filters, 1) ?? [],
            'withRelations' => $params['withRelations'] ?? request()->withRelations ?? false,
        ];

        return $response = Http::withHeaders(request()->header())
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'notakreditheader/'.$id);
    }

    // OLD REPORT
    // public function report(Request $request,$id)
    // {
    //     $params = [
    //         'offset' => $request->dari - 1,
    //         'rows' => $request->sampai - $request->dari + 1,
    //         'withRelations' => true,

    //     ];

    //     $notakredit = $this->find($params,$id)['data'];
    //     $data = $notakredit;
    //     $i =0;
        
    //         $response = Http::withHeaders($this->httpHeaders)
    //         ->withOptions(['verify' => false])
    //         ->withToken(session('access_token'))
    //         ->get(config('app.api_url') . 'notakredit_detail', ['notakredit_id' => $notakredit['id']]);


    //         $data["details"] =$response['data'];
    //         $data["user"] = Auth::user();
    //     $notakreditheaders = $data;
    //     return view('reports.notakreditheader', compact('notakreditheaders'));
    // }

    public function report(Request $request)
    {

        $header = Http::withHeaders(request()->header())
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'notakreditheader/' . $request->id);

        $detailParams = [
            'forReport' => true,
            'notakredit_id' => $request->id
        ];

        $nota_kredit = Http::withHeaders(request()->header())
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get('http://localhost/trucking-laravel/public/api/notakredit_detail', $detailParams);

        $data = $header['data'];
        $nota_kredits = $nota_kredit['data'];
        $user = Auth::user();
        return view('reports.notakreditheader', compact('data','nota_kredits', 'user'));
    }
    /**
     * @ClassName
     */
    public function export(Request $request)
    {
        $params = [
            'offset' => $request->dari - 1,
            'rows' => $request->sampai - $request->dari + 1,
            'withRelations' => true,

        ];

        $notakredits = $this->get($params)['rows'];
        $data = [];
        $i =0;
        foreach ($notakredits as $notakredit) {
            $data[$i] =$notakredit;
            $response = Http::withHeaders($this->httpHeaders)
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'notakredit_detail', [$request->all()]);


            $data[$i]["details"] =$response['data'];
            $i++;
        }
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'Laporan Nota Kredit Header');
        $sheet->getStyle("A1")->getFont()->setSize(20);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal('center');
        $sheet->mergeCells('A1:K1');

        $header_start_row = 2;
        $detail_table_header_row = 12;
        $detail_start_row = $detail_table_header_row + 1;

        $alphabets = range('A', 'Z');
        $header_columns = [
            [
                'label'=>'No Bukti',
                'index'=>'nobukti'
            ],
            [
                'label'=>'No Bukti Pelunasan Piutang',
                'index'=>'pelunasanpiutang_nobukti'
            ],
            [
                'label'=>'Tgl Bukti',
                'index'=>'tglbukti'
            ],
            [
                'label'=>'Approval Status ',
                'index'=>'statusapproval_memo'
            ],
            [
                'label'=>'tgl lunas',
                'index'=>'tgllunas'
            ],
            [
                'label'=>'Approval User',
                'index'=>'userapproval'
            ],
            [
                'label'=>'Tgl Approval',
                'index'=>'tglapproval'
            ],
            [
                'label'=>'Status Format',
                'index'=>'statusformat'
            ],
            [
                'label'=>'modifiedby',
                'index'=>'modifiedby'
            ],
            
        ];
        $detail_columns = [
            [
                'label'=>'NO',
            ],
            [
                'label'=>'No Bukti',
                'index'=>'nobukti'
            ],
            [
                'label'=>'Invoice No Bukti',
                'index'=>'invoice_nobukti'
            ],
            [
                'label'=>'Tgl Terima',
                'index'=>'tglterima'
            ],
            [
                'label'=>'Keterangan',
                'index'=>'keterangan'
            ],
            [
                'label'=>'Nominal',
                'index'=>'nominal'
            ],
            [
                'label'=>'Nominal Bayar',
                'index'=>'nominalbayar'
            ],
            [
                'label'=>'Penyesuaian',
                'index'=>'penyesuaian'
            ],
            [
                'label'=>'COA Penyesuaian',
                'index'=>'coaadjust'
            ],
            [
                'label'=>'modifiedby',
                'index'=>'modifiedby'
            ],
            
        ];

        for ($i = 0; $i < count($data); $i++) {
            foreach ($header_columns as $header_column) {
                $sheet->setCellValue('A' . $header_start_row, $header_column['label']);
                $sheet->setCellValue('B' . $header_start_row, ':');
                $sheet->setCellValue('C' . $header_start_row++, $data[$i][$header_column['index']]);
            }

            $header_start_row += count($data[$i]['details']) + 2;

            foreach ($detail_columns as $detail_columns_index => $detail_column) {
                $sheet->setCellValue($alphabets[$detail_columns_index] . $detail_table_header_row, $detail_column['label'] ?? $detail_columns_index + 1);
            }

            $sheet->getStyle("A$detail_table_header_row:J$detail_table_header_row")->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('FF02c4f5');

            foreach ($data[$i]['details'] as $detail_index => $detail_data) {
                foreach ($detail_columns as $detail_columns_index => $detail_column) {
                    $sheet->setCellValue($alphabets[$detail_columns_index] . $detail_start_row, isset($detail_column['index']) ? $detail_data[$detail_column['index']] : $detail_index + 1);
                }
                $sheet->setCellValue("A$detail_start_row", $detail_index + 1);
                $sheet->setCellValue("B$detail_start_row", $detail_data['nobukti']);
                $sheet->setCellValue("C$detail_start_row", $detail_data['invoice_nobukti']);
                $sheet->setCellValue("D$detail_start_row", $detail_data['tglterima']);
                $sheet->setCellValue("E$detail_start_row", $detail_data['keterangan']);
                $sheet->setCellValue("F$detail_start_row", $detail_data['nominal']);
                $sheet->setCellValue("G$detail_start_row", $detail_data['nominalbayar']);
                $sheet->setCellValue("H$detail_start_row", $detail_data['penyesuaian']);
                $sheet->setCellValue("I$detail_start_row", $detail_data['coaadjust']);
                $sheet->setCellValue("J$detail_start_row", $detail_data['modifiedby']);

                $detail_start_row++;
            }

            $detail_table_header_row += (10 + count($data[$i]['details']) + 2);
            $detail_start_row = $detail_table_header_row + 1;
        }

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

        $styleArray = array(
            'borders' => array(
                'allBorders' => array(
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ),
            ),
        );

        $writer = new Xlsx($spreadsheet);
        $filename = 'laporanNotaKreditHeader' . date('dmYHis');

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }
}

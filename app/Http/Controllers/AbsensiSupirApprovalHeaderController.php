<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class AbsensiSupirApprovalHeaderController extends MyController
{

    public $title = 'Absesi Supir Aproval';

    public function index(Request $request)
    {
        $title = $this->title;
        $breadcrumb = $this->breadcrumb;
        $data = [
            'combocetak' => $this->comboCetak('list', 'STATUSCETAK', 'STATUSCETAK'),
            'comboapproval' => $this->comboApproval('list')

        ];

        
        return view('absensisupirapprovalheader.index', compact('title', 'breadcrumb', 'data'));              
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
            ->get(config('app.api_url') . 'absensisupirapprovalheader', $params);

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
            ->get(config('app.api_url') . 'absensisupirapprovalheader/'.$id);
    }

     /**
     * @ClassName
     */
    public function report(Request $request,$id)
    {
        $params = [
            'offset' => $request->dari - 1,
            'rows' => $request->sampai - $request->dari + 1,
            'withRelations' => true,

        ];
        $absensisupirapproval = $this->find($params,$id)['data'];
        // return $absensisupirapprovals['id'];
        $data = $absensisupirapproval;
        $i =0;
        
            $response = Http::withHeaders($this->httpHeaders)
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'absensisupirapprovaldetail', ['absensisupirapproval_id' => $absensisupirapproval['id']]);

            $data["details"] =$response['data'];
            $data["user"] = Auth::user();
            

        $absensisupirapprovalheaders = $data;
        return view('reports.absensisupirapprovalheader', compact('absensisupirapprovalheaders'));
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

        $notadebets = $this->get($params)['rows'];
        $data = [];
        $i =0;
        foreach ($notadebets as $notadebet) {
            $data[$i] =$notadebet;
            $response = Http::withHeaders($this->httpHeaders)
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'absensisupirapprovaldetail', [$request->all()]);


            $data[$i]["details"] =$response['data'];
            $i++;
        }
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'Laporan Absensi Supir Approval');
        $sheet->getStyle("A1")->getFont()->setSize(20);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal('center');
        $sheet->mergeCells('A1:E1');

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
                'label'=>'No Bukti absensi supir',
                'index'=>'absensisupir_nobukti'
            ],
            [
                'label'=>'Tgl Bukti',
                'index'=>'tglbukti'
            ],
            [
                'label'=>'Keterangan',
                'index'=>'keterangan'
            ],
            [
                'label'=>'Approval Status ',
                'index'=>'statusapproval_memo'
            ],
            [
                'label'=>'pengeluaran nobukti',
                'index'=>'pengeluaran_nobukti'
            ],
            [
                'label'=>'coa kas keluar',
                'index'=>'coakaskeluar'
            ],
            [
                'label'=>'tgl kas keluar',
                'index'=>'tglkaskeluar'
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
                'index'=>'statusformat_memo'
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
                'label'=>'trado',
                'index'=>'trado'
            ],
            [
                'label'=>'supir',
                'index'=>'supir'
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

            $sheet->getStyle("A$detail_table_header_row:E$detail_table_header_row")->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('FF02c4f5');

            foreach ($data[$i]['details'] as $detail_index => $detail_data) {
                foreach ($detail_columns as $detail_columns_index => $detail_column) {
                    $sheet->setCellValue($alphabets[$detail_columns_index] . $detail_start_row, isset($detail_column['index']) ? $detail_data[$detail_column['index']] : $detail_index + 1);
                }
                $sheet->setCellValue("A$detail_start_row", $detail_index + 1);
                $sheet->setCellValue("B$detail_start_row", $detail_data['nobukti']);
                $sheet->setCellValue("C$detail_start_row", $detail_data['trado']);
                $sheet->setCellValue("D$detail_start_row", $detail_data['supir']);
                $sheet->setCellValue("E$detail_start_row", $detail_data['modifiedby']);

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
        // $sheet->getColumnDimension('F')->setAutoSize(true);
        // $sheet->getColumnDimension('G')->setAutoSize(true);
        // $sheet->getColumnDimension('H')->setAutoSize(true);
        // $sheet->getColumnDimension('I')->setAutoSize(true);
        // $sheet->getColumnDimension('J')->setAutoSize(true);
        // $sheet->getColumnDimension('K')->setAutoSize(true);

        $styleArray = array(
            'borders' => array(
                'allBorders' => array(
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ),
            ),
        );

        $writer = new Xlsx($spreadsheet);
        $filename = 'LaporanAbsensiSupirApproval' . date('dmYHis');

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
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
        // dd($response )    ;
        return $response['data'];

    }

    
    public function comboApproval($aksi)
    {

        $status = [
            'status' => $aksi,
            'grp' => 'STATUS APPROVAL',
            'subgrp' => 'STATUS APPROVAL',
        ];

        $response = Http::withHeaders($this->httpHeaders)
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'parameter/comboapproval', $status);

        return $response['data'];
    }
    
}

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
        
        $data = [
            'combocetak' => $this->comboCetak('list', 'STATUSCETAK', 'STATUSCETAK'),
            'comboapproval' => $this->comboApproval('list')

        ];

        
        return view('absensisupirapprovalheader.index', compact('title', 'data'));              
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
        //FETCH HEADER
        $id = $request->id;
        $data = Http::withHeaders($request->header())
        ->withOptions(['verify' => false])
        ->withToken(session('access_token'))
        ->get(config('app.api_url') .'absensisupirapprovalheader/'.$id.'/export');

        //FETCH DETAIL
        $detailParams = [
            'absensisupirapproval_id' => $request->id
        ];
        $responses = Http::withHeaders(request()->header())
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') .'absensisupirapprovaldetail', $detailParams);

        $absensiappheader = $data['data'];
        $absensiappheader_details = $responses['data'];

        $data = $absensiappheader['statusapproval'];
        $result = json_decode($data, true);
        $parameters = $result['MEMO'];     
        $absensiappheader['statusapproval'] =  $parameters;

        $tglBukti = $absensiappheader["tglbukti"];
        $timeStamp = strtotime($tglBukti);
        $dateTglBukti = date('d-m-Y', $timeStamp); 
        $absensiappheader['tglbukti'] = $dateTglBukti;

        $tglKasKeluar = $absensiappheader["tglkaskeluar"];
        $timeStamp = strtotime($tglKasKeluar);
        $dateKasKeluar = date('d-m-Y', $timeStamp); 
        $absensiappheader['tglkaskeluar'] = $dateKasKeluar;

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', $absensiappheader['judul']);
        $sheet->setCellValue('A2', $absensiappheader['judulLaporan']);
        $sheet->getStyle("A1")->getFont()->setSize(14);
        $sheet->getStyle("A2")->getFont()->setSize(12);
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
                'label'=>'No Bukti',
                'index'=>'nobukti'
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
                'label'=>'No Bukti Absensi Supir ',
                'index'=>'absensisupir_nobukti'
            ],
            [
                'label'=>'Status Approval',
                'index'=>'statusapproval'
            ],
            [
                'label'=>'User Approval',
                'index'=>'userapproval'
            ],
            [
                'label'=>'No Bukti Pengeluaran',
                'index'=>'pengeluaran_nobukti'
            ],
            [
                'label'=>'Coa Kas Keluar',
                'index'=>'coakaskeluar'
            ],
            [
                'label'=>'Tanggal Kas Keluar',
                'index'=>'tglkaskeluar'
            ],
            [
                'label'=>'Posting Dari',
                'index'=>'postingdari'
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
                'label'=>'Trado',
                'index'=>'trado'
            ],
            [
                'label'=>'Supir',
                'index'=>'supir'
            ],
            [
                'label'=>'Supir Serap',
                'index'=>'supirserap'
            ],
            
        ];

         //LOOPING HEADER        
         foreach ($header_columns as $header_column) {
             $sheet->setCellValue('B' . $header_start_row, $header_column['label']);
             $sheet->setCellValue('C' . $header_start_row++, ': '.$absensiappheader[$header_column['index']]);
             
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
        $sheet ->getStyle("A$detail_table_header_row:E$detail_table_header_row")->applyFromArray($styleArray);
        

        // LOOPING DETAIL

        foreach ($absensiappheader_details as $response_index => $response_detail) {
            
            foreach ($detail_columns as $detail_columns_index => $detail_column) {
                $sheet->setCellValue($alphabets[$detail_columns_index] . $detail_start_row, isset($detail_column['index']) ? $response_detail[$detail_column['index']] : $response_index + 1);
            }
        
            $sheet->setCellValue("A$detail_start_row", $response_index + 1);
            $sheet->setCellValue("B$detail_start_row", $response_detail['nobukti']);
            $sheet->setCellValue("C$detail_start_row", $response_detail['trado']);
            $sheet->setCellValue("D$detail_start_row", $response_detail['supir']);
            $sheet->setCellValue("E$detail_start_row", $response_detail['supirserap']);

            $sheet ->getStyle("A$detail_start_row:E$detail_start_row")->applyFromArray($styleArray);
            $detail_start_row++;
        }

        $total_start_row = $detail_start_row;

        //set diketahui dibuat
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

        //set autosize
        $sheet->getColumnDimension('A')->setAutoSize(true);
        $sheet->getColumnDimension('B')->setAutoSize(true);
        $sheet->getColumnDimension('C')->setAutoSize(true);
        //$sheet->getColumnDimension('D')->setAutoSize(true);
        $sheet->getColumnDimension('E')->setAutoSize(true);


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

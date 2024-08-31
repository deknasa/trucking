<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class ServiceInHeaderController extends MyController
{
    public $title = 'Service in';
   
    public function index(Request $request)
    {
        $title = $this->title;
        
        $data = [
            'combocetak' => $this->comboCetak('list', 'STATUSCETAK', 'STATUSCETAK'),
            'comboserviceout' => $this->comboCetak('list', 'STATUS SERVICE OUT', 'STATUS SERVICE OUT'),
            'listbtn' => $this->getListBtn()
        ];
        $data = array_merge(compact('title', 'data'),
            ["request"=>$request->all()]
        );
        return view('serviceinheader.index', $data);
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

    public function store(Request $request)
    {
        try {
            $request['modifiedby'] = Auth::user()->name;

            $response = Http::withHeaders($this->httpHeaders)
                ->withOptions(['verify' => false])
                ->withToken(session('access_token'))
                ->post(config('app.api_url') . 'serviceinheader', $request->all());


            return response($response, $response->status());
        } catch (\Throwable $th) {
            throw $th->getMessage();
        }
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
            ->get(config('app.api_url') . 'serviceinheader', $params);

            $data = [
                'total' => $response['attributes']['totalPages'] ?? [],
                'records' => $response['attributes']['totalRows'] ?? [],
                'rows' => $response['data'] ?? [],
                'params' => $response['params'] ?? [],
            ];

        return $data;
    }

  

    public function update(Request $request, $id)
    {
        // /* Unformat nominal */
        // $request->nominal = array_map(function ($nominal) {
        //     $nominal = str_replace('.', '', $nominal);
        //     $nominal = str_replace(',', '', $nominal);

        //     return $nominal;
        // }, $request->nominal);

        // $request->merge([
        //     'nominal' => $request->nominal
        // ]);

        $request['modifiedby'] = Auth::user()->name;

        $response = Http::withHeaders($this->httpHeaders)
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->patch(config('app.api_url') . "serviceinheader/$id", $request->all());

        return response($response);
    }

   

    public function destroy($id)
    {
        $request['modifiedby'] = Auth::user()->name;
        $response = Http::withHeaders($this->httpHeaders)
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->delete(config('app.api_url') . "serviceinheader/$id");

        return response($response);
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

    private function combo()
    {
        $response = Http::withHeaders($this->httpHeaders)
            ->withToken(session('access_token'))
            ->withOptions(['verify' => false])
            ->get(config('app.api_url') . 'serviceinheader/combo');

        return $response['data'];
    }

    public function comboReport($aksi)
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
        $serviceIn = Http::withHeaders($request->header())
        ->withOptions(['verify' => false])
        ->withToken(session('access_token'))
        ->get(config('app.api_url') .'serviceinheader/'.$id.'/export')['data'];

        //FETCH DETAIL
        $detailParams = [
            'forReport' => true,
            'servicein_id' => $request->id,
        ];
        $responses = Http::withHeaders($request->header())
        ->withOptions(['verify' => false])
        ->withToken(session('access_token'))
        ->get(config('app.api_url') .'serviceindetail', $detailParams);
        $serviceIn_details = $responses['data'];

        $combo = $this->comboReport('list');
        $key = array_search('CETAK', array_column( $combo, 'parameter')); 
        $serviceIn["combo"] =  $combo[$key];
        $printer['tipe'] = $request->printer;
        return view('reports.servicein', compact('serviceIn','serviceIn_details', 'printer'));
    }

    // public function export(Request $request): void
    // {
        
    //     //FETCH HEADER
    //     $id = $request->id;
    //     $serviceIn = Http::withHeaders($request->header())
    //     ->withOptions(['verify' => false])
    //     ->withToken(session('access_token'))
    //     ->get(config('app.api_url') .'serviceinheader/'.$id.'/export')['data'];

    //     //FETCH DETAIL
    //     $detailParams = [
    //         'servicein_id' => $request->id,
    //     ];
    //     $responses = Http::withHeaders($request->header())
    //     ->withOptions(['verify' => false])
    //     ->withToken(session('access_token'))
    //     ->get(config('app.api_url') .'serviceindetail', $detailParams);
    //     $serviceIn_details = $responses['data'];

    //     $tglBukti = $serviceIn["tglbukti"];
    //     $timeStamp = strtotime($tglBukti);
    //     $dateTglBukti = date('d-m-Y', $timeStamp); 
    //     $serviceIn['tglbukti'] = $dateTglBukti;

    //     $tglMasuk = $serviceIn["tglmasuk"];
    //     $timeStamp = strtotime($tglMasuk);
    //     $datetglMasuk = date('d-m-Y', $timeStamp); 
    //     $serviceIn['tglmasuk'] = $datetglMasuk;

    //     $spreadsheet = new Spreadsheet();
    //     $sheet = $spreadsheet->getActiveSheet();
    //     $sheet->setCellValue('A1', $serviceIn['judul']);
    //     $sheet->setCellValue('A2', $serviceIn['judulLaporan']);
    //     $sheet->getStyle("A1")->getFont()->setSize(12);
    //     $sheet->getStyle("A2")->getFont()->setSize(12);
    //     $sheet->getStyle("A1")->getFont()->setBold(true);
    //     $sheet->getStyle("A2")->getFont()->setBold(true);
    //     $sheet->getStyle('A1')->getAlignment()->setHorizontal('center');
    //     $sheet->getStyle('A2')->getAlignment()->setHorizontal('center');
    //     $sheet->mergeCells('A1:D1');
    //     $sheet->mergeCells('A2:D2');

    //     $header_start_row = 4;
    //     $detail_table_header_row = 9;
    //     $detail_start_row = $detail_table_header_row + 1;
       
    //     $alphabets = range('A', 'Z');

    //     $header_columns = [
    //         [
    //             'label' => 'No Bukti',
    //             'index' => 'nobukti',
    //         ],
    //         [
    //             'label' => 'Tanggal',
    //             'index' => 'tglbukti',
    //         ],
    //         [
    //             'label' => 'Trado',
    //             'index' => 'trado_id',
    //         ],
    //         [
    //             'label' => 'Tanggal Masuk',
    //             'index' => 'tglmasuk',
    //         ],
    //     ];

    //     $detail_columns = [
    //         [
    //             'label' => 'No',
    //         ],
    //         [
    //             'label' => 'MEKANIK',
    //             'index' => 'karyawan_id',
    //         ],
    //         [
    //             'label' => 'KETERANGAN',
    //             'index' => 'keterangan',
    //         ]
    //     ];

    //     //LOOPING HEADER        
    //     foreach ($header_columns as $header_column) {
    //         $sheet->setCellValue('B' . $header_start_row, $header_column['label']);
    //         $sheet->setCellValue('C' . $header_start_row++, ': '.$serviceIn[$header_column['index']]);
           
    //     }
    //     foreach ($detail_columns as $detail_columns_index => $detail_column) {
    //         $sheet->setCellValue($alphabets[$detail_columns_index] . $detail_table_header_row, $detail_column['label'] ?? $detail_columns_index + 1);
    //     }
    //     $styleArray = array(
    //         'borders' => array(
    //             'allBorders' => array(
    //                 'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
    //             ),
    //         ),
    //     );

    //     // $sheet->getStyle("A$detail_table_header_row:G$detail_table_header_row")->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('FF1F456E');
    //     $sheet ->getStyle("A$detail_table_header_row:C$detail_table_header_row")->applyFromArray($styleArray);

    //     // LOOPING DETAIL
    //     foreach ($serviceIn_details as $response_index => $response_detail) {
            
    //         foreach ($detail_columns as $detail_columns_index => $detail_column) {
    //             $sheet->setCellValue($alphabets[$detail_columns_index] . $detail_start_row, isset($detail_column['index']) ? $response_detail[$detail_column['index']] : $response_index + 1);
    //             $sheet->getStyle("A$detail_table_header_row:C$detail_table_header_row")->getFont()->setBold(true);
    //             $sheet->getStyle("A$detail_table_header_row:C$detail_table_header_row")->getAlignment()->setHorizontal('center');
    //         }
    //         $sheet->setCellValue("A$detail_start_row", $response_index + 1);
    //         $sheet->setCellValue("B$detail_start_row", $response_detail['karyawan_id']);
    //         $sheet->setCellValue("C$detail_start_row", $response_detail['keterangan']);

    //         $sheet->getColumnDimension('C')->setWidth(50);

    //         $sheet ->getStyle("A$detail_start_row:C$detail_start_row")->applyFromArray($styleArray);
    //         $detail_start_row++;
    //     }

    //     $sheet->getColumnDimension('A')->setAutoSize(true);
    //     $sheet->getColumnDimension('B')->setAutoSize(true);

    //     $writer = new Xlsx($spreadsheet);
    //     $filename = 'Laporan ServiceIn  ' . date('dmYHis');
    //     header('Content-Type: application/vnd.ms-excel');
    //     header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
    //     header('Cache-Control: max-age=0');

    //     $writer->save('php://output');
    // }
}

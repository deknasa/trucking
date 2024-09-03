<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class ServiceOutHeaderController extends MyController
{

     /**
     * @ClassName
     */
    public $title = 'Service out';

    public function index(Request $request)
    {
        $title = $this->title;

        $data = [
            'combocetak' => $this->comboCetak('list', 'STATUSCETAK', 'STATUSCETAK'),
            'listbtn' => $this->getListBtn()
        ];
        $data = array_merge(compact('title', 'data'),
            ["request"=>$request->all()]
        );
        return view('serviceoutheader.index', $data);
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

     /**
     * @ClassName
     */
    public function store(Request $request)
    {
        try {
            $request['modifiedby'] = Auth::user()->name;

            $response = Http::withHeaders($this->httpHeaders)
                ->withOptions(['verify' => false])
                ->withToken(session('access_token'))
                ->post(config('app.api_url') . 'serviceoutheader', $request->all());


            return response($response, $response->status());
        } catch (\Throwable $th) {
            throw $th->getMessage();
        }
        
    }
   
      // /**
    //  * Fungsi get
    //  * @ClassName get
    //  */
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
            ->get(config('app.api_url') . 'serviceoutheader', $params);

            $data = [
                'total' => $response['attributes']['totalPages'] ?? [],
                'records' => $response['attributes']['totalRows'] ?? [],
                'rows' => $response['data'] ?? [],
                'params' => $response['params'] ?? [],
            ];
    

        return $data;
    }

     /**
     * @ClassName
     */
    public function create()
    {
        $title = $this->title;

        $combo = $this->combo();

        return view('serviceoutheader.add', compact('title' , 'combo'));
    }

     /**
     * @ClassName
     */
    public function edit($id)
    {
        $title = $this->title;

        $response = Http::withHeaders($this->httpHeaders)
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . "serviceoutheader/$id");

        $serviceout = $response['data'];
        $kode = $response['kode'];
        $serviceNoBukti = $this->getNoBukti('SERVICEOUT', 'SERVICEOUT', 'serviceoutheader');

        $combo = $this->combo();

        return view('serviceoutheader.edit', compact('title', 'serviceoutheader', 'combo', 'serviceNoBukti'));
    }

     /**
     * @ClassName
     */
    public function update(Request $request, $id)
    {
        $request['modifiedby'] = Auth::user()->name;

        $response = Http::withHeaders($this->httpHeaders)
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->patch(config('app.api_url') . "serviceoutheader/$id", $request->all());

        return response($response);
    }

     /**
     * @ClassName
     */
    public function delete($id)
    {
        try {
            $title = $this->title;

            $response = Http::withHeaders($this->httpHeaders)
                ->withOptions(['verify' => false])
                ->withToken(session('access_token'))
                ->get(config('app.api_url') . "serviceoutheader/$id");

            $serviceout = $response['data'];
            $combo = $this->combo();

            return view('serviceoutheader.delete', compact('title', 'combo', 'serviceoutheader'));
        } catch (\Throwable $th) {
            return redirect()->route('serviceoutheader.index');
        }
    }

     /**
     * @ClassName
     */
    public function destroy($id)
    {
        $request['modifiedby'] = Auth::user()->name;
        $response = Http::withHeaders($this->httpHeaders)
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->delete(config('app.api_url') . "serviceoutheader/$id");

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


    // private function combo()
    // {
    //     $response = Http::withHeaders($this->httpHeaders)
    //     ->withToken(session('access_token'))
    //     ->withOptions(['verify' => false])
    //         ->get(config('app.api_url') . 'serviceoutheader/combo');

    //     return $response['data'];
    // }

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
        $serviceOut = Http::withHeaders($request->header())
        ->withOptions(['verify' => false])
        ->withToken(session('access_token'))
        ->get(config('app.api_url') .'serviceoutheader/'.$id.'/export')['data'];;

        //FETCH DETAIL
        $detailParams = [
            'serviceout_id' => $request->id,
        ];

        $responses = Http::withHeaders($request->header())
        ->withOptions(['verify' => false])
        ->withToken(session('access_token'))
        ->get(config('app.api_url') .'serviceoutdetail', $detailParams);
        $serviceOut_details = $responses['data'];

        $combo = $this->combo('list');
        $key = array_search('CETAK', array_column( $combo, 'parameter')); 
        $serviceOut["combo"] =  $combo[$key];
        $printer['tipe'] = $request->printer;
        return view('reports.serviceout', compact('serviceOut_details','serviceOut','printer'));
    }

    // public function export(Request $request): void
    // {
    //     //FETCH HEADER
    //     $id = $request->id;
    //     $serviceOut = Http::withHeaders($request->header())
    //     ->withOptions(['verify' => false])
    //     ->withToken(session('access_token'))
    //     ->get(config('app.api_url') .'serviceoutheader/'.$id.'/export')['data'];;

    //     //FETCH DETAIL
    //     $detailParams = [
    //         'serviceout_id' => $request->id,
    //     ];

    //     $responses = Http::withHeaders($request->header())
    //     ->withOptions(['verify' => false])
    //     ->withToken(session('access_token'))
    //     ->get(config('app.api_url') .'serviceoutdetail', $detailParams);
    //     $serviceout_details = $responses['data'];

    //     $tglBukti = $serviceOut["tglbukti"];
    //     $timeStamp = strtotime($tglBukti);
    //     $dateTglBukti = date('d-m-Y', $timeStamp); 
    //     $serviceOut['tglbukti'] = $dateTglBukti;

    //     $tglKeluar = $serviceOut["tglkeluar"];
    //     $timeStamp = strtotime($tglKeluar);
    //     $datetglKeluar = date('d-m-Y', $timeStamp); 
    //     $serviceOut['tglkeluar'] = $datetglKeluar;

    //     $spreadsheet = new Spreadsheet();
    //     $sheet = $spreadsheet->getActiveSheet();
    //     $sheet->setCellValue('A1', $serviceOut['judul']);
    //     $sheet->setCellValue('A2', $serviceOut['judulLaporan']);
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
    //             'label' => 'Tanggal Keluar',
    //             'index' => 'tglkeluar',
    //         ],
    //     ];

    //     $detail_columns = [
    //         [
    //             'label' => 'No',
    //         ],
    //         [
    //             'label' => 'NO BUKTI SERVICE IN',
    //             'index' => 'servicein_nobukti',
    //         ],
    //         [
    //             'label' => 'KETERANGAN',
    //             'index' => 'keterangan',
    //         ]
    //     ];

    //     //LOOPING HEADER        
    //     foreach ($header_columns as $header_column) {
    //         $sheet->setCellValue('B' . $header_start_row, $header_column['label']);
    //         $sheet->setCellValue('C' . $header_start_row++, ': '.$serviceOut[$header_column['index']]);
           
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
    //     $sheet ->getStyle("A$detail_table_header_row:C$detail_table_header_row")->applyFromArray($styleArray);

    //     // LOOPING DETAIL
    //     foreach ($serviceout_details as $response_index => $response_detail) {
            
    //         foreach ($detail_columns as $detail_columns_index => $detail_column) {
    //             $sheet->setCellValue($alphabets[$detail_columns_index] . $detail_start_row, isset($detail_column['index']) ? $response_detail[$detail_column['index']] : $response_index + 1);
    //             $sheet->getStyle("A$detail_table_header_row:C$detail_table_header_row")->getFont()->setBold(true);
    //             $sheet->getStyle("A$detail_table_header_row:C$detail_table_header_row")->getAlignment()->setHorizontal('center');
    //         }
    //         $sheet->setCellValue("A$detail_start_row", $response_index + 1);
    //         $sheet->setCellValue("B$detail_start_row", $response_detail['servicein_nobukti']);
    //         $sheet->setCellValue("C$detail_start_row", $response_detail['keterangan']);

    //         // $sheet->getStyle("C$detail_start_row")->getAlignment()->setWrapText(true);
    //         $sheet->getColumnDimension('C')->setWidth(50);

    //         $sheet ->getStyle("A$detail_start_row:C$detail_start_row")->applyFromArray($styleArray);
    //         $detail_start_row++;
    //     }

    //     $sheet->getColumnDimension('A')->setAutoSize(true);
    //     $sheet->getColumnDimension('B')->setAutoSize(true);

    //     $writer = new Xlsx($spreadsheet);
    //     $filename = 'Laporan ServiceOut  ' . date('dmYHis');
    //     header('Content-Type: application/vnd.ms-excel');
    //     header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
    //     header('Cache-Control: max-age=0');

    //     $writer->save('php://output');
    // }

}

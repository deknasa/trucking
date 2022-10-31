<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class PiutangHeaderController extends MyController
{
    public $title = 'Piutang';

    public function index(Request $request){
        $title = $this->title;
        return view('piutang.index', compact('title'));
    }

    public function create(){
        $title = $this->title;

        return view('piutang.add', compact('title'));
    }

    public function store(Request $request)
    {
        try {
           

            $request->nominal_detail = array_map(function ($nominal_detail) {
                $nominal_detail = str_replace('.', '', $nominal_detail);
                $nominal_detail = str_replace(',', '', $nominal_detail);

                return $nominal_detail;
            }, $request->nominal_detail);

            $request->merge([
                'nominal' => $request->nominal,
                'nominal_detail' => $request->nominal_detail,
            ]);

            $request['modifiedby'] = Auth::user()->name;

            $response = Http::withHeaders($this->httpHeaders)
                ->withOptions(['verify' => false])
                ->withToken(session('access_token'))
                ->post(config('app.api_url') . 'piutangheader', $request->all());


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
            ->get(config('app.api_url') . 'piutangheader', $params);

        $data = [
            'total' => $response['attributes']['totalPages'] ?? [],
            'records' => $response['attributes']['totalRows'] ?? [],
            'rows' => $response['data'] ?? [],
            'params' => $response['params'] ?? [],
        ];

        return $data;
    }

    public function edit($id)
    {
        $title = $this->title;

        $response = Http::withHeaders($this->httpHeaders)
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . "piutangheader/$id");
            // dd($response->getBody()->getContents());

        $piutang = $response['data'];
        $piutangNoBukti = $this->getNoBukti('PIUTANG', 'PIUTANG', 'piutangheader');


        return view('piutang.edit', compact('title', 'piutang', 'piutangNoBukti'));
    }

    public function update(Request $request, $id)
    {
       

        /* Unformat nominal detail*/
        $request->nominal_detail = array_map(function ($nominal_detail) {
            $nominal_detail = str_replace('.', '', $nominal_detail);
            $nominal_detail = str_replace(',', '', $nominal_detail);

            return $nominal_detail;
        }, $request->nominal_detail);

        $request->merge([
            'nominal' => $request->nominal,
            'nominal_detail' => $request->nominal_detail
        ]);

        $request['modifiedby'] = Auth::user()->name;

        $response = Http::withHeaders($this->httpHeaders)
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->patch(config('app.api_url') . "piutangheader/$id", $request->all());

        return response($response);
    }

    public function delete($id)
    {
        try {
            $title = $this->title;

            $response = Http::withHeaders($this->httpHeaders)
                ->withOptions(['verify' => false])
                ->withToken(session('access_token'))
                ->get(config('app.api_url') . "piutangheader/$id");

            $piutang = $response['data'];
            

            return view('piutang.delete', compact('title', 'piutang'));
        } catch (\Throwable $th) {
            return redirect()->route('piutang.index');
        }
    }

    public function destroy($id)
    {
        $request['modifiedby'] = Auth::user()->name;
        $response = Http::withHeaders($this->httpHeaders)
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->delete(config('app.api_url') . "piutangheader/$id");

            
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

    public function export(Request $request): void
    {
        

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'TAS');
        $sheet->getStyle("A1")->getFont()->setSize(20);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal('center');
        $sheet->mergeCells('A1:G1');

        $header_start_row = 2;
        $detail_table_header_row = 5;
        $detail_start_row = $detail_table_header_row + 1;
       
        $alphabets = range('A', 'Z');

        $header_columns = [
            [
                'label' => 'No Piutang',
                'index' => 'nobukti',
            ],
            [
                'label' => 'Tanggal',
                'index' => 'tglbukti',
            ],
            [
                'label' => 'Agen',
                'index' => 'agen',
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

        $detail_columns = [
            [
                'label' => 'No',
            ],
            [
                'label' => 'No Invoice',
                'index' => 'invoice_nobukti',
            ],
            [
                'label' => 'Keterangan',
                'index' => 'keterangan_detail',
            ],
            [
                'label' => 'Nominal',
                'index' => 'nominal',
                'format' => 'currency'
            ]
        ];

        

        $piutangs = Http::withHeaders($request->header())
                    ->withOptions(['verify' => false])
                    ->withToken(session('access_token'))
                    ->get(config('app.api_url') .'piutangheader/'.$request->id)['data'];

            
        foreach ($header_columns as $header_column) {
            $sheet->setCellValue('A' . $header_start_row, $header_column['label']);
            $sheet->setCellValue('B' . $header_start_row, ':');
            $sheet->setCellValue('C' . $header_start_row++, $piutangs[$header_column['index']]);
        }

        // $detailParams = [
        //     'forExport' => true,
        //     'invoice_id' => $request->id
        // ];

        // $responses = Http::withHeaders($request->header())
        //     ->withOptions(['verify' => false])
        //     ->withToken(session('access_token'))
        //     ->get(config('app.api_url') .'invoicedetail', $detailParams)['data'];

        // foreach ($detail_columns as $detail_columns_index => $detail_column) {
        //     $sheet->setCellValue($alphabets[$detail_columns_index] . $detail_table_header_row, $detail_column['label'] ?? $detail_columns_index + 1);
        // }
        // $styleArray = array(
        //     'borders' => array(
        //         'allBorders' => array(
        //             'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
        //         ),
        //     ),
        // );

        // $style_number = [
		// 	'alignment' => [
		// 		'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT, 
		// 	],
            
		// 	'borders' => [
		// 		'top' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
		// 		'right' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], 
		// 		'bottom' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
		// 		'left' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN] 
		// 	]
        // ];

        // // $sheet->getStyle("A$detail_table_header_row:G$detail_table_header_row")->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('FF1F456E');
        // $sheet ->getStyle("A$detail_table_header_row:G$detail_table_header_row")->applyFromArray($styleArray);

        // $total = 0;
        // foreach ($responses as $response_index => $response_detail) {
            
        //     foreach ($detail_columns as $detail_columns_index => $detail_column) {
        //         $sheet->setCellValue($alphabets[$detail_columns_index] . $detail_start_row, isset($detail_column['index']) ? $response_detail[$detail_column['index']] : $response_index + 1);
        //     }
        //     $response_detail['omsets'] = number_format((float) $response_detail['omset'], '2', ',', '.');
        
        //     $sheet->setCellValue("A$detail_start_row", $response_index + 1);
        //     $sheet->setCellValue("B$detail_start_row", $response_detail['tglsp']);
        //     $sheet->setCellValue("C$detail_start_row", $response_detail['agen_id']);
        //     $sheet->setCellValue("D$detail_start_row", $response_detail['tujuan']);
        //     $sheet->setCellValue("E$detail_start_row", $response_detail['nocont']);
        //     $sheet->setCellValue("F$detail_start_row", $response_detail['keterangan_detail']);
        //     $sheet->setCellValue("G$detail_start_row", $response_detail['omsets']);

        //     $sheet ->getStyle("A$detail_start_row:F$detail_start_row")->applyFromArray($styleArray);
        //     $sheet ->getStyle("G$detail_start_row")->applyFromArray($style_number);
        //     $total += $response_detail['omset'];
        //     $detail_start_row++;
        // }

        // $total_start_row = $detail_start_row;
        // $sheet->mergeCells('A'.$total_start_row.':F'.$total_start_row);
        // $sheet->setCellValue("A$total_start_row", 'Total :')->getStyle('A'.$total_start_row.':F'.$total_start_row)->applyFromArray($style_number)->getFont()->setBold(true);
        // $sheet->setCellValue("G$total_start_row", number_format((float) $total, '2', ',', '.'))->getStyle("G$detail_start_row")->applyFromArray($style_number)->getFont()->setBold(true);

        // $ttd_start_row = $total_start_row+2;
        // $sheet->setCellValue("A$ttd_start_row", 'Disetujui');
        // $sheet->setCellValue("B$ttd_start_row", 'Diketahui');
        // $sheet->setCellValue("C$ttd_start_row", 'Dibuat');
        // $ttd_end_row = $ttd_start_row+3;
        // $sheet ->getStyle("A$ttd_start_row:C$ttd_start_row")->applyFromArray($styleArray);
        // // $sheet->mergeCells("A$ttd_end_row:C$ttd_end_row");
        // $sheet->mergeCells("A".($ttd_start_row+1).":A".($ttd_start_row+3));      
        // $sheet->mergeCells("B".($ttd_start_row+1).":B".($ttd_start_row+3));      
        // $sheet->mergeCells("C".($ttd_start_row+1).":C".($ttd_start_row+3));      
        // $sheet ->getStyle("A".($ttd_start_row+1).":A".($ttd_start_row+3))->applyFromArray($styleArray);
        // $sheet ->getStyle("B".($ttd_start_row+1).":B".($ttd_start_row+3))->applyFromArray($styleArray);
        // $sheet ->getStyle("C".($ttd_start_row+1).":C".($ttd_start_row+3))->applyFromArray($styleArray);

        $sheet->getColumnDimension('A')->setAutoSize(true);
        $sheet->getColumnDimension('B')->setAutoSize(true);
        $sheet->getColumnDimension('C')->setAutoSize(true);
        $sheet->getColumnDimension('D')->setAutoSize(true);
        $sheet->getColumnDimension('E')->setAutoSize(true);
        $sheet->getColumnDimension('F')->setAutoSize(true);
        $sheet->getColumnDimension('G')->setAutoSize(true);
        $sheet->getColumnDimension('H')->setAutoSize(true);

        

        $writer = new Xlsx($spreadsheet);
        $filename = 'Piutang ' . date('dmYHis');
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }


}
   
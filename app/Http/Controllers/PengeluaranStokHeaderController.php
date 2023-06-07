<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class PengeluaranStokHeaderController extends MyController
{
    public $title = 'Pengeluaran Stok Header';

    public function index(Request $request)
    {
        $title = $this->title;
        $comboKodepengeluaran = $this->comboKodepengeluaran();

        return view('pengeluaranstokheader.index', compact('title','comboKodepengeluaran'));
    }

    public function create()
    {
        $title = $this->title;

        $combo = $this->combo();

        return view('pengeluaranstokheader.add', compact('title','combo'));
    }
    
    public function comboKodepengeluaran()
    {
        $response = Http::withHeaders($this->httpHeaders)
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'pengeluaranstok');

        return $response['data'];
    }

    public function store(Request $request)
    {
        try {
            $request['modifiedby'] = Auth::user()->name;

            $response = Http::withHeaders($this->httpHeaders)
                ->withOptions(['verify' => false])
                ->withToken(session('access_token'))
                ->post(config('app.api_url') . 'pengeluaranstokheader', $request->all());


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
            ->get(config('app.api_url') . 'pengeluaranstokheader', $params);

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
            ->get(config('app.api_url') . "pengeluaranstokheader/$id");
            // dd($response->getBody()->getContents());

        $pengeluaranstokheader = $response['data'];
        $kode = $response['kode'];

        if($kode == 'PJT'){
            $pengeluaranstokheaderNoBukti = $this->getNoBukti('PINJAMAN SUPIR', 'PINJAMAN SUPIR', 'pengeluaranstokheader');
        }else{
            $pengeluaranstokheaderNoBukti = $this->getNoBukti('BIAYA LAIN SUPIR', 'BIAYA LAIN SUPIR', 'pengeluaranstokheader');
        }


        $combo = $this->combo();

        return view('pengeluaranstokheader.edit', compact('title', 'pengeluaranstokheader','combo', 'pengeluaranstokheaderNoBukti'));
    }

    public function update(Request $request, $id)
    {
        /* Unformat nominal */
        $request->nominal = array_map(function ($nominal) {
            $nominal = str_replace('.', '', $nominal);
            $nominal = str_replace(',', '', $nominal);

            return $nominal;
        }, $request->nominal);

        $request->merge([
            'nominal' => $request->nominal
        ]);

        $request['modifiedby'] = Auth::user()->name;

        $response = Http::withHeaders($this->httpHeaders)
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->patch(config('app.api_url') . "pengeluaranstokheader/$id", $request->all());

        return response($response);
    }

    public function delete($id)
    {
        try {
            $title = $this->title;

            $response = Http::withHeaders($this->httpHeaders)
                ->withOptions(['verify' => false])
                ->withToken(session('access_token'))
                ->get(config('app.api_url') . "pengeluaranstokheader/$id");

            $pengeluaranstokheader = $response['data'];
            
            $combo = $this->combo();

            return view('pengeluaranstokheader.delete', compact('title','combo', 'pengeluaranstokheader'));
        } catch (\Throwable $th) {
            return redirect()->route('pengeluaranstokheader.index');
        }
    }

    public function destroy($id)
    {
        $request['modifiedby'] = Auth::user()->name;
        $response = Http::withHeaders($this->httpHeaders)
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->delete(config('app.api_url') . "pengeluaranstokheader/$id");

            
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
            ->get(config('app.api_url') . 'pengeluaranstokheader/'.$id);
    }
    public function statusFormat()
    {
        $paramsFormat = [
            "groupOp"=> "AND",
            "rules"=> [
                [
                "field"=> "grp",
                "op"=> "cn",
                "data"=> "PENGELUARAN STOK"
              ],
              [
                "field"=> "subgrp",
                "op"=> "cn",
                "data"=> "SPK STOK BUKTI"
              ]
            ]
        ];

        return $parameterStatusFormat = Http::withHeaders($this->httpHeaders)
        ->withOptions(['verify' => false])
        ->withToken(session('access_token'))
        ->get(config('app.api_url') . 'parameter', ['filters' =>json_encode($paramsFormat)])['data'][0];
        
    }

    public function report(Request $request)
    {
        $params = [
            'offset' => $request->dari - 1,
            'rows' => $request->sampai - $request->dari + 1,
            'withRelations' => true,

        ];
        $id = $request->id;
        $pengeluaranstok = $this->find($params,$id)['data'];
        

        $data = $pengeluaranstok;
        $i =0;
        
        $response = Http::withHeaders($this->httpHeaders)
        ->withOptions(['verify' => false])
        ->withToken(session('access_token'))
        ->get(config('app.api_url') . 'pengeluaranstokdetail', ['pengeluaranstok_id' => $pengeluaranstok['id']]);

        $data["details"] =$response['data'];
        $data["user"] = Auth::user();
        $combo = $this->combo('list');
        
        $key = array_search('CETAK', array_column( $combo, 'parameter')); 
        $data["combo"] =  $combo[$key];
        $pengeluaranstokheaders = $data;
        $parameterStatusFormat = $this->statusFormat();

        return view('reports.pengeluaranstokheader', compact('pengeluaranstokheaders','parameterStatusFormat'));
    }

    public function export(Request $request)
    {
        $params = [
            'offset' => $request->dari - 1,
            'rows' => $request->sampai - $request->dari + 1,
            'withRelations' => true,

        ];
        
        $id = $request->id;
        $pengeluaranstok = $this->find($params,$id)['data'];
        

        $data = $pengeluaranstok;
        $i =0;
        
        $response = Http::withHeaders($this->httpHeaders)
        ->withOptions(['verify' => false])
        ->withToken(session('access_token'))
        ->get(config('app.api_url') . 'pengeluaranstokdetail', ['pengeluaranstokheader_id' => $pengeluaranstok['id']]);
       
        

        $pengeluaranstok_details = $response['data'];
        $user =  Auth::user();
        dd($user);
        $combo = $this->combo('list');
        $parameterStatusFormat = $this->statusFormat();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'TAS '.$user['cabang_id']);
        $sheet->getStyle("A1")->getFont()->setSize(20);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal('center');

        $header_start_row = 2;
        $detail_table_header_row = 5;
        $detail_start_row = $detail_table_header_row + 1;
       
        $alphabets = range('A', 'Z');
        if ($parameterStatusFormat['id'] == $pengeluaranstok['statusformat']) {
            $sheet->mergeCells('A1:E1');
            $detail_columns = [
                [
                    'label' => 'No',
                ],
                [
                    'label' => 'No Bukti',
                    'index' => 'nobukti',
                ],
                [
                    'label' => 'Stok',
                    'index' => 'stok',
                ],
                [
                    'label' => 'Keterangan',
                    'index' => 'keterangan',
                ],
                [
                    'label' => 'QTY',
                    'index' => 'qty',
                ]
            ];
        } else{
            $sheet->mergeCells('A1:H1');
            $detail_columns = [
                [
                    'label' => 'No',
                ],
                [
                    'label' => 'No Bukti',
                    'index' => 'nobukti',
                ],
                [
                    'label' => 'Vulkanisir ke',
                    'index' => 'vulkanisirke',
                ],
                [
                    'label' => 'Stok',
                    'index' => 'stok',
                ],
                [
                    'label' => 'Keterangan',
                    'index' => 'keterangan',
                ],
                [
                    'label' => 'QTY',
                    'index' => 'qty',
                ],
                [
                    'label' => 'Harga',
                    'index' => 'harga',
                    'format' => 'currency'
                ],
                [
                    'label' => 'Total',
                    'index' => 'total',
                    'format' => 'currency'
                ]
            ];
        }
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
                'label' => 'Keterangan',
                'index' => 'keterangan',
            ],
        ];

        

        foreach ($header_columns as $header_column) {
            $sheet->setCellValue('A' . $header_start_row, $header_column['label']);
            $sheet->setCellValue('B' . $header_start_row, ':');
            $sheet->setCellValue('C' . $header_start_row++, $pengeluaranstok[$header_column['index']]);
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
        
        $total = 0;
        if ($parameterStatusFormat['id'] == $pengeluaranstok['statusformat']) {
            $sheet ->getStyle("A$detail_table_header_row:E$detail_table_header_row")->applyFromArray($styleArray);
            //jika spk
            foreach ($pengeluaranstok_details as $response_index => $response_detail) {
                
                foreach ($detail_columns as $detail_columns_index => $detail_column) {
                    $sheet->setCellValue($alphabets[$detail_columns_index] . $detail_start_row, isset($detail_column['index']) ? $response_detail[$detail_column['index']] : $response_index + 1);
                }
                $response_detail['totals'] = number_format((float) $response_detail['total'], '2', ',', '.');
            
                $sheet->setCellValue("A$detail_start_row", $response_index + 1);
                $sheet->setCellValue("B$detail_start_row", $response_detail['nobukti']);
                $sheet->setCellValue("C$detail_start_row", $response_detail['stok']);
                $sheet->setCellValue("D$detail_start_row", $response_detail['keterangan']);
                $sheet->setCellValue("E$detail_start_row", $response_detail['qty'], number_format((float) $response_detail['total'], '2', ',', '.'));
    
                $sheet ->getStyle("A$detail_start_row:D$detail_start_row")->applyFromArray($styleArray);
                $sheet ->getStyle("E$detail_start_row")->applyFromArray($style_number);
                $total += $response_detail['total'];
                $detail_start_row++;
            }
    
            $total_start_row = $detail_start_row;
            
            
        }else{
            //jika rbt
            $sheet ->getStyle("A$detail_table_header_row:h$detail_table_header_row")->applyFromArray($styleArray);

            foreach ($pengeluaranstok_details as $response_index => $response_detail) {
                
                foreach ($detail_columns as $detail_columns_index => $detail_column) {
                    $sheet->setCellValue($alphabets[$detail_columns_index] . $detail_start_row, isset($detail_column['index']) ? $response_detail[$detail_column['index']] : $response_index + 1);
                }
                $response_detail['totals'] = number_format((float) $response_detail['total'], '2', ',', '.');
            
                $sheet->setCellValue("A$detail_start_row", $response_index + 1);
                $sheet->setCellValue("B$detail_start_row", $response_detail['nobukti']);
                $sheet->setCellValue("C$detail_start_row", $response_detail['vulkanisirke']);
                $sheet->setCellValue("D$detail_start_row", $response_detail['stok']);
                $sheet->setCellValue("E$detail_start_row", $response_detail['keterangan']);
                $sheet->setCellValue("F$detail_start_row", number_format((float) $response_detail['qty'], '2', ',', '.'))->getStyle("F$detail_start_row")->applyFromArray($style_number);
                $sheet->setCellValue("G$detail_start_row", number_format((float) $response_detail['harga'], '2', ',', '.'))->getStyle("G$detail_start_row")->applyFromArray($style_number);
                $sheet->setCellValue("H$detail_start_row", number_format((float) $response_detail['total'], '2', ',', '.'))->getStyle("H$detail_start_row")->applyFromArray($style_number);
    
    
                $sheet ->getStyle("A$detail_start_row:G$detail_start_row")->applyFromArray($styleArray);
                $sheet ->getStyle("H$detail_start_row")->applyFromArray($style_number);
                $total += $response_detail['total'];
                $detail_start_row++;
            }
    
            $total_start_row = $detail_start_row;
            
            $sheet->mergeCells('A'.$total_start_row.':G'.$total_start_row);
            $sheet->setCellValue("A$total_start_row", 'Total :')->getStyle('A'.$total_start_row.':G'.$total_start_row)->applyFromArray($style_number)->getFont()->setBold(true);
            $sheet->setCellValue("H$total_start_row", number_format((float) $total, '2', ',', '.'))->getStyle("H$detail_start_row")->applyFromArray($style_number)->getFont()->setBold(true);

        }


        //set diketahui dibuat
        $ttd_start_row = $total_start_row+2;
        $sheet->setCellValue("A$ttd_start_row", 'Disetujui');
        $sheet->setCellValue("B$ttd_start_row", 'Diketahui');
        $sheet->setCellValue("C$ttd_start_row", 'Dibuat');
        $sheet ->getStyle("A$ttd_start_row:C$ttd_start_row")->applyFromArray($styleArray);
        // $sheet->mergeCells("A$ttd_end_row:C$ttd_end_row");
        $sheet->mergeCells("A".($ttd_start_row+1).":A".($ttd_start_row+3));      
        $sheet->mergeCells("B".($ttd_start_row+1).":B".($ttd_start_row+3));      
        $sheet->mergeCells("C".($ttd_start_row+1).":C".($ttd_start_row+3));      
        $sheet ->getStyle("A".($ttd_start_row+1).":A".($ttd_start_row+3))->applyFromArray($styleArray);
        $sheet ->getStyle("B".($ttd_start_row+1).":B".($ttd_start_row+3))->applyFromArray($styleArray);
        $sheet ->getStyle("C".($ttd_start_row+1).":C".($ttd_start_row+3))->applyFromArray($styleArray);

        
        //set tglcetak
        date_default_timezone_set('Asia/Jakarta');
        
        $sheet->setCellValue("A".($ttd_start_row+5), 'Dicetak Pada :');
        $sheet->getStyle("A".($ttd_start_row+5))->getFont()->setItalic(true);
        $sheet->setCellValue("B".($ttd_start_row+5), date('d/m/Y H:i:s'));
        $sheet->getStyle("B".($ttd_start_row+5))->getFont()->setItalic(true);
        $sheet->setCellValue("C".($ttd_start_row+5), $user['name']);
        $sheet->getStyle("C".($ttd_start_row+5))->getFont()->setItalic(true);

        $sheet->getColumnDimension('A')->setAutoSize(true);
        $sheet->getColumnDimension('B')->setAutoSize(true);
        $sheet->getColumnDimension('C')->setAutoSize(true);
        $sheet->getColumnDimension('D')->setAutoSize(true);
        $sheet->getColumnDimension('E')->setAutoSize(true);
        $sheet->getColumnDimension('F')->setAutoSize(true);
        $sheet->getColumnDimension('G')->setAutoSize(true);
        $sheet->getColumnDimension('H')->setAutoSize(true);
        $sheet->getColumnDimension('A')->setAutoSize(true);
        $sheet->getColumnDimension('B')->setAutoSize(true);
        $sheet->getColumnDimension('C')->setAutoSize(true);
        $sheet->getColumnDimension('D')->setAutoSize(true);
        $sheet->getColumnDimension('E')->setAutoSize(true);
        $sheet->getColumnDimension('F')->setAutoSize(true);
        $sheet->getColumnDimension('G')->setAutoSize(true);
        $sheet->getColumnDimension('H')->setAutoSize(true);

        

        $writer = new Xlsx($spreadsheet);
        $filename = 'Pengeluaran Stok ' . date('dmYHis');
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }

}

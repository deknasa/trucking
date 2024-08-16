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
        $data = [
            'combocetak' => $this->comboList('list', 'STATUSCETAK', 'STATUSCETAK'),
            'combokirimberkas' => $this->comboList('list','STATUSKIRIMBERKAS','STATUSKIRIMBERKAS'),
            'listbtn' => $this->getListBtn()

        ];
        $combo = $this->comboKodepengeluaran();
        $comboKodepengeluaran = $combo['data'];
        $acosPengeluaran = $combo['acos'];
        $data = array_merge(compact('title','comboKodepengeluaran', 'acosPengeluaran','data'),
            ["request"=>$request->all()]
        );
        return view('pengeluaranstokheader.index', $data);
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

    public function create()
    {
        $title = $this->title;

        $combo = $this->combo();

        return view('pengeluaranstokheader.add', compact('title','combo'));
    }
    
    public function comboKodepengeluaran()
    {
        $params = [
            'limit' => 0,
            'roleinput' => 'role',
            'sortIndex' => 'keterangan'
        ];

        $response = Http::withHeaders($this->httpHeaders)
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'pengeluaranstok', $params);

        return $response;
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

    public function persediaan($gudang,$trado,$gandengan)
    {
        $kolom = null;
        $value = 0;
        if(!empty($gudang)) {
            $kolom = "Gudang";
            $value = $gudang;
        } elseif(!empty($trado)) {
            $kolom = "Trado";
            $value = $trado;
          } elseif(!empty($gandengan)) {
            $kolom = "Gandengan";
            $value = $gandengan;
          }
          return [
            "column"=>$kolom,
            "value"=>$value
        ];
    }

    public function report(Request $request)
    {
        $params = [
            'offset' => $request->dari - 1,
            'rows' => $request->sampai - $request->dari + 1,
            'withRelations' => true,
            'limit'=> 0
        ];
        $id = $request->id;
        $pengeluaranstok = $this->find($params,$id)['data'];
        $data = $pengeluaranstok;
        $i =0;
        
        $response = Http::withHeaders($this->httpHeaders)
        ->withOptions(['verify' => false])
        ->withToken(session('access_token'))
        ->get(config('app.api_url') . 'pengeluaranstokdetail', ['pengeluaranstokheader_id' => $pengeluaranstok['id'], 'limit' => 0]);
        $data["details"] =$response['data'];
        $data["user"] = Auth::user();
        $combo = $this->combo('list');
        $key = array_search('CETAK', array_column( $combo, 'parameter')); 
        $data["combo"] =  $combo[$key];
        $printer['tipe'] = $request->printer;

        $pengeluaranstokheaders = $data;
        $parameterStatusFormat = $this->statusFormat();

        $trado = $pengeluaranstokheaders['trado'];
        $gandengan = $pengeluaranstokheaders['gandengan'];
        $gudang = $pengeluaranstokheaders['gudang'];
        $persediaan = $this->persediaan($gudang,$trado,$gandengan);
        $data['column'] = $persediaan['column'];
        $data['value'] = $persediaan['value'];

        $pengeluaranstokheaders = $data;
        return view('reports.pengeluaranstokheader', compact('pengeluaranstokheaders','printer'));
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
        ->get(config('app.api_url') . 'pengeluaranstokdetail', ['pengeluaranstokheader_id' => $pengeluaranstok['id'], 'limit' => 0]);
        $pengeluaranstok_details = $response['data'];

        $pengeluaranstokheaders = $data;
        $trado = $pengeluaranstokheaders['trado'];
        $gandengan = $pengeluaranstokheaders['gandengan'];
        $gudang = $pengeluaranstokheaders['gudang'];
        $persediaan = $this->persediaan($gudang,$trado,$gandengan);
        $data['column'] = $persediaan['column'];
        $data['value'] = $persediaan['value'];
        $pengeluaranstokheaders = $data;
        $tglbukti = $pengeluaranstokheaders["tglbukti"];
        $timeStamp = strtotime($tglbukti);
        $datetglbukti = date('d-m-Y', $timeStamp); 
        $pengeluaranstokheaders['tglbukti'] = $datetglbukti;

        $tglkasmasuk = $pengeluaranstokheaders["tglkasmasuk"];
        $timeStampDari = strtotime($tglkasmasuk);
        $datetglkasmasuk = date('d-m-Y', $timeStampDari); 
        $pengeluaranstokheaders['tglkasmasuk'] = $datetglkasmasuk;

        switch ($pengeluaranstok['statusformat']) {
            case '135':
                //SPK
                $spreadsheet = new Spreadsheet();
                $sheet = $spreadsheet->getActiveSheet();
                $sheet->setCellValue('A1', $pengeluaranstokheaders['judul']);
                $sheet->setCellValue('A2', 'Laporan Pengeluaran Stok (SPK)');
                $sheet->getStyle("A1")->getFont()->setSize(12);
                $sheet->getStyle("A2")->getFont()->setSize(12);
                $sheet->getStyle("A1")->getFont()->setBold(true);
                $sheet->getStyle("A2")->getFont()->setBold(true);
                $sheet->getStyle('A1')->getAlignment()->setHorizontal('center');
                $sheet->getStyle('A2')->getAlignment()->setHorizontal('center');
                $sheet->mergeCells('A1:F1');
                $sheet->mergeCells('A2:F2');
                $header_start_row = 4;
                $detail_table_header_row = 9;
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
                        'label' => 'No Polisi',
                        'index' => 'trado',
                    ],
                    [
                        'label' => 'No PG',
                        'index' => 'penerimaanstok_nobukti',
                    ],
                ];
                $detail_columns = [
                    [
                        'label' => 'NO',
                    ],
                    [
                        'label' => 'NAMA BARANG',
                        'index' => 'stok'
                    ],
                    [
                        'label' => 'JUMLAH',
                        'index' => 'qty'
                    ],
                    [
                        'label' => '@',
                        'index' => 'harga',
                        'format' => 'currency'
                    ],
                    [
                        'label' => 'TOTAL',
                        'index' => 'total',
                        'format' => 'currency'
                    ],
                    [
                        'label' => 'KETERANGAN',
                        'index' => 'keterangan',
                    ]
                ];
                //LOOPING HEADER        
                foreach ($header_columns as $header_column) {
                    $sheet->setCellValue('B' . $header_start_row, $header_column['label']);
                    $sheet->setCellValue('C' . $header_start_row++, ': ' . $pengeluaranstokheaders[$header_column['index']]);
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
                $sheet->getStyle("A$detail_table_header_row:F$detail_table_header_row")->applyFromArray($styleArray);
                // LOOPING DETAIL
                $nominal = 0;
                foreach ($pengeluaranstok_details as $response_index => $response_detail) {

                    foreach ($detail_columns as $detail_columns_index => $detail_column) {
                        $sheet->setCellValue($alphabets[$detail_columns_index] . $detail_start_row, isset($detail_column['index']) ? $response_detail[$detail_column['index']] : 0);
                        $sheet->getStyle("A$detail_table_header_row:F$detail_table_header_row")->getFont()->setBold(true);
                        $sheet->getStyle("A$detail_table_header_row:F$detail_table_header_row")->getAlignment()->setHorizontal('center');
                    }
                    $sheet->setCellValue("A$detail_start_row", $response_index + 1);
                    $sheet->setCellValue("B$detail_start_row", $response_detail['stok']);
                    $sheet->setCellValue("C$detail_start_row", $response_detail['qty']);
                    $sheet->setCellValue("D$detail_start_row", $response_detail['harga']);
                    $sheet->setCellValue("E$detail_start_row", $response_detail['total']);
                    $sheet->setCellValue("F$detail_start_row", $response_detail['keterangan']);
                    $sheet->getStyle("F$detail_start_row")->getAlignment()->setWrapText(true);
                    $sheet->getColumnDimension('F')->setWidth(70);
                    $sheet->getStyle("A$detail_start_row:F$detail_start_row")->applyFromArray($styleArray);
                    $sheet->getStyle("D$detail_start_row:E$detail_start_row")->applyFromArray($style_number)->getNumberFormat()->setFormatCode("#,##0.00_);(#,##0.00)");
                    $nominal += $response_detail['total'];
                    $detail_start_row++;
                }

                $total_start_row = $detail_start_row;
                $sheet->mergeCells('A' . $total_start_row . ':D' . $total_start_row);
                $sheet->setCellValue("A$total_start_row", 'Total')->getStyle('A' . $total_start_row . ':D' . $total_start_row)->applyFromArray($styleArray)->getFont()->setBold(true);
                $sheet->setCellValue("E$total_start_row", $nominal)->getStyle("E$detail_start_row")->applyFromArray($style_number)->getFont()->setBold(true);
                $sheet->getStyle("E$detail_start_row")->getNumberFormat()->setFormatCode("#,##0.00_);(#,##0.00)");
                $sheet->getColumnDimension('A')->setAutoSize(true);
                $sheet->getColumnDimension('B')->setAutoSize(true);
                $sheet->getColumnDimension('C')->setAutoSize(true);
                $sheet->getColumnDimension('D')->setAutoSize(true);
                $sheet->getColumnDimension('E')->setAutoSize(true);
                $writer = new Xlsx($spreadsheet);
                $filename = 'Laporan Pengeluaran Stok (SPK)' . date('dmYHis');
                header('Content-Type: application/vnd.ms-excel');
                header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
                header('Cache-Control: max-age=0');
                $writer->save('php://output');
            break;
            case '139':
                //RTR
                $spreadsheet = new Spreadsheet();
                $sheet = $spreadsheet->getActiveSheet();
                $sheet->setCellValue('A1', $pengeluaranstokheaders['judul']);
                $sheet->setCellValue('A2', 'Laporan Purchase Return (RTR)');
                $sheet->getStyle("A1")->getFont()->setSize(12);
                $sheet->getStyle("A2")->getFont()->setSize(12);
                $sheet->getStyle("A1")->getFont()->setBold(true);
                $sheet->getStyle("A2")->getFont()->setBold(true);
                $sheet->getStyle('A1')->getAlignment()->setHorizontal('center');
                $sheet->getStyle('A2')->getAlignment()->setHorizontal('center');
                $sheet->mergeCells('A1:F1');
                $sheet->mergeCells('A2:F2');
                $header_start_row = 4;
                $detail_table_header_row = 9;
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
                        'label' => 'Supplier',
                        'index' => 'supplier',
                    ],
                    [
                        'label' => 'No SPB',
                        'index' => 'penerimaanstok_nobukti',
                    ]
                ];
                $detail_columns = [
                    [
                        'label' => 'NO',
                    ],
                    [
                        'label' => 'NAMA BARANG',
                        'index' => 'stok'
                    ],
                    [
                        'label' => 'JUMLAH',
                        'index' => 'qty'
                    ],
                    [
                        'label' => '@',
                        'index' => 'harga',
                        'format' => 'currency'
                    ],
                    [
                        'label' => 'TOTAL',
                        'index' => 'total',
                        'format' => 'currency'
                    ],
                    [
                        'label' => 'KETERANGAN',
                        'index' => 'keterangan',
                    ]
                ];
                //LOOPING HEADER        
                foreach ($header_columns as $header_column) {
                    $sheet->setCellValue('B' . $header_start_row, $header_column['label']);
                    $sheet->setCellValue('C' . $header_start_row++, ': ' . $pengeluaranstokheaders[$header_column['index']]);
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
                $sheet->getStyle("A$detail_table_header_row:F$detail_table_header_row")->applyFromArray($styleArray);
                // LOOPING DETAIL
                $nominal = 0;
                foreach ($pengeluaranstok_details as $response_index => $response_detail) {

                    foreach ($detail_columns as $detail_columns_index => $detail_column) {
                        $sheet->setCellValue($alphabets[$detail_columns_index] . $detail_start_row, isset($detail_column['index']) ? $response_detail[$detail_column['index']] : 0);
                        $sheet->getStyle("A$detail_table_header_row:F$detail_table_header_row")->getFont()->setBold(true);
                        $sheet->getStyle("A$detail_table_header_row:F$detail_table_header_row")->getAlignment()->setHorizontal('center');
                    }
                    
                    $sheet->setCellValue("A$detail_start_row", $response_index + 1);
                    $sheet->setCellValue("B$detail_start_row", $response_detail['stok']);
                    $sheet->setCellValue("C$detail_start_row", $response_detail['qty']);
                    $sheet->setCellValue("D$detail_start_row", $response_detail['harga']);
                    $sheet->setCellValue("E$detail_start_row", $response_detail['total']);
                    $sheet->setCellValue("F$detail_start_row", $response_detail['keterangan']);
                    $sheet->getStyle("F$detail_start_row")->getAlignment()->setWrapText(true);
                    $sheet->getColumnDimension('F')->setWidth(70);
                    $sheet->getStyle("A$detail_start_row:F$detail_start_row")->applyFromArray($styleArray);
                    $sheet->getStyle("D$detail_start_row:E$detail_start_row")->applyFromArray($style_number)->getNumberFormat()->setFormatCode("#,##0.00_);(#,##0.00)");
                    $nominal += $response_detail['total'];
                    $detail_start_row++;
                }

                $total_start_row = $detail_start_row;
                $sheet->mergeCells('A' . $total_start_row . ':D' . $total_start_row);
                $sheet->setCellValue("A$total_start_row", 'Total')->getStyle('A' . $total_start_row . ':D' . $total_start_row)->applyFromArray($styleArray)->getFont()->setBold(true);
                $sheet->setCellValue("E$total_start_row", $nominal)->getStyle("E$detail_start_row")->applyFromArray($style_number)->getFont()->setBold(true);
                $sheet->getStyle("E$detail_start_row")->getNumberFormat()->setFormatCode("#,##0.00_);(#,##0.00)");
                $sheet->getColumnDimension('A')->setAutoSize(true);
                $sheet->getColumnDimension('B')->setAutoSize(true);
                $sheet->getColumnDimension('C')->setAutoSize(true);
                $sheet->getColumnDimension('D')->setAutoSize(true);
                $sheet->getColumnDimension('E')->setAutoSize(true);
                $writer = new Xlsx($spreadsheet);
                $filename = 'Laporan Purchase Return (RTR)' . date('dmYHis');
                header('Content-Type: application/vnd.ms-excel');
                header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
                header('Cache-Control: max-age=0');
                $writer->save('php://output');
            break;
            case '221':
                //KOR
                $spreadsheet = new Spreadsheet();
                $sheet = $spreadsheet->getActiveSheet();
                $sheet->setCellValue('A1', $pengeluaranstokheaders['judul']);
                $sheet->setCellValue('A2', 'Laporan Koreksi Stok (KOR)');
                $sheet->getStyle("A1")->getFont()->setSize(12);
                $sheet->getStyle("A2")->getFont()->setSize(12);
                $sheet->getStyle("A1")->getFont()->setBold(true);
                $sheet->getStyle("A2")->getFont()->setBold(true);
                $sheet->getStyle('A1')->getAlignment()->setHorizontal('center');
                $sheet->getStyle('A2')->getAlignment()->setHorizontal('center');
                $sheet->mergeCells('A1:F1');
                $sheet->mergeCells('A2:F2');
                $header_start_row = 4;
                $detail_table_header_row = 8;
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
                        'label' => $data['column'],
                        'index' => 'value',
                    ]
                ];
                $detail_columns = [
                    [
                        'label' => 'NO',
                    ],
                    [
                        'label' => 'NAMA BARANG',
                        'index' => 'stok'
                    ],
                    [
                        'label' => 'JUMLAH',
                        'index' => 'qty'
                    ],
                    [
                        'label' => '@',
                        'index' => 'harga',
                        'format' => 'currency'
                    ],
                    [
                        'label' => 'TOTAL',
                        'index' => 'total',
                        'format' => 'currency'
                    ],
                    [
                        'label' => 'KETERANGAN',
                        'index' => 'keterangan',
                    ]
                ];
                //LOOPING HEADER        
                foreach ($header_columns as $header_column) {
                    $sheet->setCellValue('B' . $header_start_row, $header_column['label']);
                    $sheet->setCellValue('C' . $header_start_row++, ': ' . $pengeluaranstokheaders[$header_column['index']]);
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
                $sheet->getStyle("A$detail_table_header_row:F$detail_table_header_row")->applyFromArray($styleArray);
                // LOOPING DETAIL
                $nominal = 0;
                foreach ($pengeluaranstok_details as $response_index => $response_detail) {

                    foreach ($detail_columns as $detail_columns_index => $detail_column) {
                        $sheet->setCellValue($alphabets[$detail_columns_index] . $detail_start_row, isset($detail_column['index']) ? $response_detail[$detail_column['index']] : 0);
                        $sheet->getStyle("A$detail_table_header_row:F$detail_table_header_row")->getFont()->setBold(true);
                        $sheet->getStyle("A$detail_table_header_row:F$detail_table_header_row")->getAlignment()->setHorizontal('center');
                    }
                    $sheet->setCellValue("A$detail_start_row", $response_index + 1);
                    $sheet->setCellValue("B$detail_start_row", $response_detail['stok']);
                    $sheet->setCellValue("C$detail_start_row", $response_detail['qty']);
                    $sheet->setCellValue("D$detail_start_row", $response_detail['harga']);
                    $sheet->setCellValue("E$detail_start_row", $response_detail['total']);
                    $sheet->setCellValue("F$detail_start_row", $response_detail['keterangan']);
                    $sheet->getStyle("F$detail_start_row")->getAlignment()->setWrapText(true);
                    $sheet->getColumnDimension('F')->setWidth(70);
                    $sheet->getStyle("A$detail_start_row:F$detail_start_row")->applyFromArray($styleArray);
                    $sheet->getStyle("D$detail_start_row:E$detail_start_row")->applyFromArray($style_number)->getNumberFormat()->setFormatCode("#,##0.00_);(#,##0.00)");

                    $nominal += $response_detail['total'];
                    $detail_start_row++;
                }

                $total_start_row = $detail_start_row;
                $sheet->mergeCells('A' . $total_start_row . ':D' . $total_start_row);
                $sheet->setCellValue("A$total_start_row", 'Total')->getStyle('A' . $total_start_row . ':D' . $total_start_row)->applyFromArray($styleArray)->getFont()->setBold(true);
                $sheet->setCellValue("E$total_start_row", $nominal)->getStyle("E$detail_start_row")->applyFromArray($style_number)->getFont()->setBold(true);
                $sheet->getStyle("E$detail_start_row")->getNumberFormat()->setFormatCode("#,##0.00_);(#,##0.00)");
                $sheet->getColumnDimension('A')->setAutoSize(true);
                $sheet->getColumnDimension('B')->setAutoSize(true);
                $sheet->getColumnDimension('C')->setAutoSize(true);
                $sheet->getColumnDimension('D')->setAutoSize(true);
                $sheet->getColumnDimension('E')->setAutoSize(true);
                $writer = new Xlsx($spreadsheet);
                $filename = 'Laporan Koreksi Stok (KOR)' . date('dmYHis');
                header('Content-Type: application/vnd.ms-excel');
                header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
                header('Cache-Control: max-age=0');
                $writer->save('php://output');
            break;
            case '340':
                //PJA
                $spreadsheet = new Spreadsheet();
                $sheet = $spreadsheet->getActiveSheet();
                $sheet->setCellValue('A1', $pengeluaranstokheaders['judul']);
                $sheet->setCellValue('A2', 'Laporan Penjualan Stok Afkir(PJA)');
                $sheet->getStyle("A1")->getFont()->setSize(12);
                $sheet->getStyle("A2")->getFont()->setSize(12);
                $sheet->getStyle("A1")->getFont()->setBold(true);
                $sheet->getStyle("A2")->getFont()->setBold(true);
                $sheet->getStyle('A1')->getAlignment()->setHorizontal('center');
                $sheet->getStyle('A2')->getAlignment()->setHorizontal('center');
                $sheet->mergeCells('A1:F1');
                $sheet->mergeCells('A2:F2');
                $header_start_row = 4;
                $header_right_start_row = 4;
                $detail_table_header_row = 8;
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
                        'label' => 'Supplier',
                        'index' => 'supplier',
                    ]
                ];
                $header_right_columns = [
                    [
                        'label' => 'Kas/Bank',
                        'index' => 'bank',
                    ],
                    [
                        'label' => 'Tanggal Post',
                        'index' => 'tglkasmasuk',
                    ]
                ];
                $detail_columns = [
                    [
                        'label' => 'NO',
                    ],
                    [
                        'label' => 'NAMA BARANG',
                        'index' => 'stok'
                    ],
                    [
                        'label' => 'JUMLAH',
                        'index' => 'qty'
                    ],
                    [
                        'label' => '@',
                        'index' => 'harga',
                        'format' => 'currency'
                    ],
                    [
                        'label' => 'TOTAL',
                        'index' => 'total',
                        'format' => 'currency'
                    ],
                    [
                        'label' => 'KETERANGAN',
                        'index' => 'keterangan',
                    ]
                ];
                //LOOPING HEADER        
                foreach ($header_columns as $header_column) {
                    $sheet->setCellValue('B' . $header_start_row, $header_column['label']);
                    $sheet->setCellValue('C' . $header_start_row++, ': ' . $pengeluaranstokheaders[$header_column['index']]);
                }
                foreach ($header_right_columns as $header_right_column) {
                    $sheet->setCellValue('D' . $header_right_start_row, $header_right_column['label']);
                    $sheet->setCellValue('E' . $header_right_start_row++, ': '.$pengeluaranstokheaders[$header_right_column['index']]);
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
                $sheet->getStyle("A$detail_table_header_row:F$detail_table_header_row")->applyFromArray($styleArray);
                // LOOPING DETAIL
                $nominal = 0;
                foreach ($pengeluaranstok_details as $response_index => $response_detail) {

                    foreach ($detail_columns as $detail_columns_index => $detail_column) {
                        $sheet->setCellValue($alphabets[$detail_columns_index] . $detail_start_row, isset($detail_column['index']) ? $response_detail[$detail_column['index']] : 0);
                        $sheet->getStyle("A$detail_table_header_row:F$detail_table_header_row")->getFont()->setBold(true);
                        $sheet->getStyle("A$detail_table_header_row:F$detail_table_header_row")->getAlignment()->setHorizontal('center');
                    }
                    $sheet->setCellValue("A$detail_start_row", $response_index + 1);
                    $sheet->setCellValue("B$detail_start_row", $response_detail['stok']);
                    $sheet->setCellValue("C$detail_start_row", $response_detail['qty']);
                    $sheet->setCellValue("D$detail_start_row", $response_detail['harga']);
                    $sheet->setCellValue("E$detail_start_row", $response_detail['total']);
                    $sheet->setCellValue("F$detail_start_row", $response_detail['keterangan']);
                    $sheet->getStyle("F$detail_start_row")->getAlignment()->setWrapText(true);
                    $sheet->getColumnDimension('F')->setWidth(50);
                    $sheet->getStyle("A$detail_start_row:F$detail_start_row")->applyFromArray($styleArray);
                    $sheet->getStyle("D$detail_start_row:E$detail_start_row")->applyFromArray($style_number)->getNumberFormat()->setFormatCode("#,##0.00_);(#,##0.00)");

                    $nominal += $response_detail['total'];
                    $detail_start_row++;
                }

                $total_start_row = $detail_start_row;
                $sheet->mergeCells('A' . $total_start_row . ':D' . $total_start_row);
                $sheet->setCellValue("A$total_start_row", 'Total')->getStyle('A' . $total_start_row . ':D' . $total_start_row)->applyFromArray($styleArray)->getFont()->setBold(true);
                $sheet->setCellValue("E$total_start_row", $nominal)->getStyle("E$detail_start_row")->applyFromArray($style_number)->getFont()->setBold(true);
                $sheet->getStyle("E$detail_start_row")->getNumberFormat()->setFormatCode("#,##0.00_);(#,##0.00)");
                $sheet->getColumnDimension('A')->setAutoSize(true);
                $sheet->getColumnDimension('B')->setAutoSize(true);
                $sheet->getColumnDimension('C')->setAutoSize(true);
                $sheet->getColumnDimension('D')->setAutoSize(true);
                $sheet->getColumnDimension('E')->setAutoSize(true);
                $writer = new Xlsx($spreadsheet);
                $filename = 'Laporan Penjualan Stok Afkir(PJA)' . date('dmYHis');
                header('Content-Type: application/vnd.ms-excel');
                header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
                header('Cache-Control: max-age=0');
                $writer->save('php://output');
            break;
            case '353':
                //GST
                $spreadsheet = new Spreadsheet();
                $sheet = $spreadsheet->getActiveSheet();
                $sheet->setCellValue('A1', $pengeluaranstokheaders['judul']);
                $sheet->setCellValue('A2', 'Laporan Sparepart Gantung Trucking(GST)');
                $sheet->getStyle("A1")->getFont()->setSize(12);
                $sheet->getStyle("A2")->getFont()->setSize(12);
                $sheet->getStyle("A1")->getFont()->setBold(true);
                $sheet->getStyle("A2")->getFont()->setBold(true);
                $sheet->getStyle('A1')->getAlignment()->setHorizontal('center');
                $sheet->getStyle('A2')->getAlignment()->setHorizontal('center');
                $sheet->mergeCells('A1:F1');
                $sheet->mergeCells('A2:F2');
                $header_start_row = 4;
                $detail_table_header_row = 8;
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
                        'label' => $data['column'],
                        'index' => 'value',
                    ]
                ];
                $detail_columns = [
                    [
                        'label' => 'NO',
                    ],
                    [
                        'label' => 'NAMA BARANG',
                        'index' => 'stok'
                    ],
                    [
                        'label' => 'JUMLAH',
                        'index' => 'qty'
                    ],
                    [
                        'label' => '@',
                        'index' => 'harga',
                        'format' => 'currency'
                    ],
                    [
                        'label' => 'TOTAL',
                        'index' => 'total',
                        'format' => 'currency'
                    ],
                    [
                        'label' => 'KETERANGAN',
                        'index' => 'keterangan',
                    ]
                ];
                //LOOPING HEADER        
                foreach ($header_columns as $header_column) {
                    $sheet->setCellValue('B' . $header_start_row, $header_column['label']);
                    $sheet->setCellValue('C' . $header_start_row++, ': ' . $pengeluaranstokheaders[$header_column['index']]);
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
                $sheet->getStyle("A$detail_table_header_row:F$detail_table_header_row")->applyFromArray($styleArray);
                // LOOPING DETAIL
                $nominal = 0;
                foreach ($pengeluaranstok_details as $response_index => $response_detail) {

                    foreach ($detail_columns as $detail_columns_index => $detail_column) {
                        $sheet->setCellValue($alphabets[$detail_columns_index] . $detail_start_row, isset($detail_column['index']) ? $response_detail[$detail_column['index']] : 0);
                        $sheet->getStyle("A$detail_table_header_row:F$detail_table_header_row")->getFont()->setBold(true);
                        $sheet->getStyle("A$detail_table_header_row:F$detail_table_header_row")->getAlignment()->setHorizontal('center');
                    }
                    $sheet->setCellValue("A$detail_start_row", $response_index + 1);
                    $sheet->setCellValue("B$detail_start_row", $response_detail['stok']);
                    $sheet->setCellValue("C$detail_start_row", $response_detail['qty']);
                    $sheet->setCellValue("D$detail_start_row", $response_detail['harga']);
                    $sheet->setCellValue("E$detail_start_row", $response_detail['total']);
                    $sheet->setCellValue("F$detail_start_row", $response_detail['keterangan']);
                    $sheet->getStyle("F$detail_start_row")->getAlignment()->setWrapText(true);
                    $sheet->getColumnDimension('F')->setWidth(70);
                    $sheet->getStyle("A$detail_start_row:F$detail_start_row")->applyFromArray($styleArray);
                    $sheet->getStyle("D$detail_start_row:E$detail_start_row")->applyFromArray($style_number)->getNumberFormat()->setFormatCode("#,##0.00_);(#,##0.00)");

                    $nominal += $response_detail['total'];
                    $detail_start_row++;
                }

                $total_start_row = $detail_start_row;
                $sheet->mergeCells('A' . $total_start_row . ':D' . $total_start_row);
                $sheet->setCellValue("A$total_start_row", 'Total')->getStyle('A' . $total_start_row . ':D' . $total_start_row)->applyFromArray($styleArray)->getFont()->setBold(true);
                $sheet->setCellValue("E$total_start_row", number_format((float) $nominal, '2', '.', ','))->getStyle("E$detail_start_row")->applyFromArray($style_number)->getFont()->setBold(true);
                $sheet->getStyle("E$detail_start_row")->getNumberFormat()->setFormatCode("#,##0.00_);(#,##0.00)");

                $sheet->getColumnDimension('A')->setAutoSize(true);
                $sheet->getColumnDimension('B')->setAutoSize(true);
                $sheet->getColumnDimension('C')->setAutoSize(true);
                $sheet->getColumnDimension('D')->setAutoSize(true);
                $sheet->getColumnDimension('E')->setAutoSize(true);
                $writer = new Xlsx($spreadsheet);
                $filename = 'Laporan Sparepart Gantung Trucking (GST)' . date('dmYHis');
                header('Content-Type: application/vnd.ms-excel');
                header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
                header('Cache-Control: max-age=0');
                $writer->save('php://output');
            break;
            default:
            break;
        }
    }

}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;


class PenerimaanStokHeaderController extends MyController
{
    public $title = 'Penerimaan Stok Header';

    public function index(Request $request)
    {
        $title = $this->title;
        $data = [
            'combocetak' => $this->comboList('list', 'STATUSCETAK', 'STATUSCETAK'),
            'combokirimberkas' => $this->comboList('list','STATUSKIRIMBERKAS','STATUSKIRIMBERKAS'),
            'listbtn' => $this->getListBtn()
        ];
        $combo = $this->comboKodepenerimaan();
        $comboKodepenerimaan = $combo['data'];
        $acosPenerimaan = $combo['acos'];
        $data = array_merge(
            compact('title', 'comboKodepenerimaan', 'acosPenerimaan', 'data'),
            ["request" => $request->all()]
        );

        return view('penerimaanstokheader.index', $data);
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

        return view('penerimaanstokheader.add', compact('title', 'combo'));
    }

    public function store(Request $request)
    {
        try {
            $request['modifiedby'] = Auth::user()->name;

            $response = Http::withHeaders($this->httpHeaders)
                ->withOptions(['verify' => false])
                ->withToken(session('access_token'))
                ->post(config('app.api_url') . 'penerimaanstokheader', $request->all());


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
            ->get(config('app.api_url') . 'penerimaanstokheader', $params);

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
            ->get(config('app.api_url') . "penerimaanstokheader/$id");
        // dd($response->getBody()->getContents());

        $penerimaanstokheader = $response['data'];
        $kode = $response['kode'];

        if ($kode == 'PJT') {
            $penerimaanstokheaderNoBukti = $this->getNoBukti('PINJAMAN SUPIR', 'PINJAMAN SUPIR', 'penerimaanstokheader');
        } else {
            $penerimaanstokheaderNoBukti = $this->getNoBukti('BIAYA LAIN SUPIR', 'BIAYA LAIN SUPIR', 'penerimaanstokheader');
        }


        $combo = $this->combo();

        return view('penerimaanstokheader.edit', compact('title', 'penerimaanstokheader', 'combo', 'penerimaanstokheaderNoBukti'));
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
            ->patch(config('app.api_url') . "penerimaanstokheader/$id", $request->all());

        return response($response);
    }

    public function delete($id)
    {
        try {
            $title = $this->title;

            $response = Http::withHeaders($this->httpHeaders)
                ->withOptions(['verify' => false])
                ->withToken(session('access_token'))
                ->get(config('app.api_url') . "penerimaanstokheader/$id");

            $penerimaanstokheader = $response['data'];

            $combo = $this->combo();

            return view('penerimaanstokheader.delete', compact('title', 'combo', 'penerimaanstokheader'));
        } catch (\Throwable $th) {
            return redirect()->route('penerimaanstokheader.index');
        }
    }

    public function destroy($id)
    {
        $request['modifiedby'] = Auth::user()->name;
        $response = Http::withHeaders($this->httpHeaders)
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->delete(config('app.api_url') . "penerimaanstokheader/$id");


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
            ->get(config('app.api_url') . 'user/combostatus', $status);

        return $response['data'];
    }
    public function comboKodepenerimaan()
    {

        $params = [
            'limit' => 0,
            'roleinput' => 'role',
            'sortIndex' => 'keterangan'
        ];

        $response = Http::withHeaders($this->httpHeaders)
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'penerimaanstok', $params);
        // dd($response['acos']);
        return $response;
    }
    public function find($params, $id)
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
            ->get(config('app.api_url') . 'penerimaanstokheader/' . $id);
    }

    public function persediaan($gudang, $trado, $gandengan)
    {
        $kolom = null;
        $value = 0;
        if (!empty($gudang)) {
            $kolom = "Gudang";
            $value = $gudang;
        } elseif (!empty($trado)) {
            $kolom = "Trado";
            $value = $trado;
        } elseif (!empty($gandengan)) {
            $kolom = "Gandengan";
            $value = $gandengan;
        }
        return [
            "column" => $kolom,
            "value" => $value
        ];
    }

    public function persediaanDari($gudangDari, $tradoDari, $gandenganDari)
    {
        $kolom = null;
        $value = 0;
        if (!empty($gudangDari)) {
            $kolom = "Dari Gudang";
            $value = $gudangDari;
        } elseif (!empty($tradoDari)) {
            $kolom = "Dari Trado";
            $value = $tradoDari;
        } elseif (!empty($gandenganDari)) {
            $kolom = "Dari Gandengan";
            $value = $gandenganDari;
        }
        return [
            "columnDari" => $kolom,
            "valueDari" => $value
        ];
    }

    public function persediaanKe($gudangKe, $tradoKe, $gandenganKe)
    {
        $kolom = null;
        $value = 0;
        if (!empty($gudangKe)) {
            $kolom = "Ke Gudang";
            $value = $gudangKe;
        } elseif (!empty($tradoKe)) {
            $kolom = "Ke Trado";
            $value = $tradoKe;
        } elseif (!empty($gandenganKe)) {
            $kolom = "Ke Gandengan";
            $value = $gandenganKe;
        }
        return [
            "columnKe" => $kolom,
            "valueKe" => $value
        ];
    }

    public function report(Request $request)
    {
        $params = [
            'offset' => $request->dari - 1,
            'rows' => $request->sampai - $request->dari + 1,
            'withRelations' => true,

        ];
        // dd($request->all());
        $id = $request->id ?? 0;
        $penerimaanstok = $this->find($params, $id)['data'];
        $data = $penerimaanstok;
        $i = 0;

        $response = Http::withHeaders($this->httpHeaders)
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'penerimaanstokdetail', ['forReport' => true,'nobukti'=>$request->nobukti ,'penerimaanstokheader_id' => $penerimaanstok['id']]);
        $data["details"] = $response['data'];
        $data["user"] = Auth::user();
        $combo = $this->combo('list');

        $key = array_search('CETAK', array_column($combo, 'parameter'));
        $data["combo"] =  $combo[$key];
        $penerimaanstokheaders = $data;

        $trado = $penerimaanstokheaders['trado'];
        $gandengan = $penerimaanstokheaders['gandengan'];
        $gudang = $penerimaanstokheaders['gudang'];
        $persediaan = $this->persediaan($gudang, $trado, $gandengan);
        $data['column'] = $persediaan['column'];
        $data['value'] = $persediaan['value'];

        $tradoDari = $penerimaanstokheaders['tradodari'];
        $gandenganDari = $penerimaanstokheaders['gandengandari'];
        $gudangDari = $penerimaanstokheaders['gudangdari'];
        $persediaanDari = $this->persediaanDari($gudangDari, $tradoDari, $gandenganDari);
        $data['columnDari'] = $persediaanDari['columnDari'];
        $data['valueDari'] = $persediaanDari['valueDari'];

        $tradoKe = $penerimaanstokheaders['tradoke'];
        $gandenganKe = $penerimaanstokheaders['gandenganke'];
        $gudangKe = $penerimaanstokheaders['gudangke'];
        $persediaanKe = $this->persediaanKe($gudangKe, $tradoKe, $gandenganKe);
        $data['columnKe'] = $persediaanKe['columnKe'];
        $data['valueKe'] = $persediaanKe['valueKe'];

        $penerimaanstokheaders = $data;
        $printer['tipe'] = $request->printer;
        return view('reports.penerimaanstokheader', compact('penerimaanstokheaders', 'printer'));
    }

    public function export(Request $request)
    {
        $params = [
            'offset' => $request->dari - 1,
            'rows' => $request->sampai - $request->dari + 1,
            'withRelations' => true,

        ];
        $id = $request->id;
        $penerimaanstok = $this->find($params, $id)['data'];
        $data = $penerimaanstok;
        $i = 0;
        $response = Http::withHeaders($this->httpHeaders)
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'penerimaanstokdetail', ['penerimaanstokheader_id' => $penerimaanstok['id']]);
        $penerimaanstok_details = $response['data'];
        $penerimaanstokheaders = $data;

        $tglBukti = $penerimaanstokheaders["tglbukti"];
        $timeStamp = strtotime($tglBukti);
        $dateTglBukti = date('d-m-Y', $timeStamp);
        $penerimaanstokheaders['tglbukti'] = $dateTglBukti;

        $parenttglbukti = $penerimaanstokheaders["parrenttglbukti"];
        $timeStamp = strtotime($parenttglbukti);
        $dateparenttglbukti = date('d-m-Y', $timeStamp);
        $penerimaanstokheaders['parrenttglbukti'] = $dateparenttglbukti;

        // dd($penerimaanstokheaders['statusformat']);
        switch ($penerimaanstokheaders['statusformat']) {
            case '132':
                //PGDO
                $spreadsheet = new Spreadsheet();
                $sheet = $spreadsheet->getActiveSheet();
                $sheet->setCellValue('A1', $penerimaanstokheaders['judul']);
                $sheet->setCellValue('A2', 'Laporan Pindah Gudang DO');
                $sheet->getStyle("A1")->getFont()->setSize(12);
                $sheet->getStyle("A2")->getFont()->setSize(12);
                $sheet->getStyle("A1")->getFont()->setBold(true);
                $sheet->getStyle("A2")->getFont()->setBold(true);
                $sheet->getStyle('A1')->getAlignment()->setHorizontal('center');
                $sheet->getStyle('A2')->getAlignment()->setHorizontal('center');
                $sheet->mergeCells('A1:D1');
                $sheet->mergeCells('A2:D2');
                $header_start_row = 4;
                $header_start_row_right = 4;
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
                        'label' => 'Dari Gudang',
                        'index' => 'gudangdari',
                    ],
                    [
                        'label' => 'Ke Gudang',
                        'index' => 'gudangke',
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
                        'label' => 'KETERANGAN',
                        'index' => 'keterangan',
                    ]
                ];
                //LOOPING HEADER        
                foreach ($header_columns as $header_column) {
                    $sheet->setCellValue('B' . $header_start_row, $header_column['label']);
                    $sheet->setCellValue('C' . $header_start_row++, ': ' . $penerimaanstokheaders[$header_column['index']]);
                }
                foreach ($header_right_columns as $header_column_right) {
                    $sheet->setCellValue('D' . $header_start_row_right, $header_column_right['label']);
                    $sheet->setCellValue('E' . $header_start_row_right++, ': ' . $penerimaanstokheaders[$header_column_right['index']]);
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
                $sheet->getStyle("A$detail_table_header_row:D$detail_table_header_row")->applyFromArray($styleArray);
                // LOOPING DETAIL
                foreach ($penerimaanstok_details as $response_index => $response_detail) {

                    foreach ($detail_columns as $detail_columns_index => $detail_column) {
                        $sheet->setCellValue($alphabets[$detail_columns_index] . $detail_start_row, isset($detail_column['index']) ? $response_detail[$detail_column['index']] : 0);
                        $sheet->getStyle("A$detail_table_header_row:F$detail_table_header_row")->getFont()->setBold(true);
                        $sheet->getStyle("A$detail_table_header_row:F$detail_table_header_row")->getAlignment()->setHorizontal('center');
                    }
                    $sheet->setCellValue("A$detail_start_row", $response_index + 1);
                    $sheet->setCellValue("B$detail_start_row", $response_detail['stok']);
                    $sheet->setCellValue("C$detail_start_row", $response_detail['qty']);
                    $sheet->setCellValue("D$detail_start_row", $response_detail['keterangan']);
                    $sheet->getStyle("D$detail_start_row")->getAlignment()->setWrapText(true);
                    $sheet->getColumnDimension('D')->setWidth(50);
                    $sheet->getStyle("A$detail_start_row:D$detail_start_row")->applyFromArray($styleArray);
                    $sheet->getStyle("C$detail_start_row")->getNumberFormat()->setFormatCode("#,##0.00_);(#,##0.00)");
                }
                $sheet->getColumnDimension('A')->setAutoSize(true);
                $sheet->getColumnDimension('B')->setAutoSize(true);
                $sheet->getColumnDimension('C')->setAutoSize(true);
                $writer = new Xlsx($spreadsheet);
                $filename = 'Laporan Pindah Gudang DO' . date('dmYHis');
                header('Content-Type: application/vnd.ms-excel');
                header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
                header('Cache-Control: max-age=0');
                $writer->save('php://output');
                break;
            case '133':
                //POT
                $spreadsheet = new Spreadsheet();
                $sheet = $spreadsheet->getActiveSheet();
                $sheet->setCellValue('A1', $penerimaanstokheaders['judul']);
                $sheet->setCellValue('A2', 'Laporan Purchase Order (PO)');
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
                        'label' => 'Supplier',
                        'index' => 'supplier',
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
                        'label' => 'NOMINAL',
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
                    $sheet->setCellValue('C' . $header_start_row++, ': ' . $penerimaanstokheaders[$header_column['index']]);
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
                foreach ($penerimaanstok_details as $response_index => $response_detail) {

                    foreach ($detail_columns as $detail_columns_index => $detail_column) {
                        $sheet->setCellValue($alphabets[$detail_columns_index] . $detail_start_row, isset($detail_column['index']) ? $response_detail[$detail_column['index']] : 0);
                        $sheet->getStyle("A$detail_table_header_row:F$detail_table_header_row")->getFont()->setBold(true);
                        $sheet->getStyle("A$detail_table_header_row:F$detail_table_header_row")->getAlignment()->setHorizontal('center');
                    }
                    // $response_detail['hargas'] = number_format((float) $response_detail['harga'], '2', '.', ',');
                    // $response_detail['totals'] = number_format((float) $response_detail['total'], '2', '.', ',');
                    $sheet->setCellValue("A$detail_start_row", $response_index + 1);
                    $sheet->setCellValue("B$detail_start_row", $response_detail['stok']);
                    $sheet->setCellValue("C$detail_start_row", $response_detail['qty']);
                    $sheet->setCellValue("D$detail_start_row", $response_detail['harga']);
                    $sheet->setCellValue("E$detail_start_row", $response_detail['total']);
                    $sheet->setCellValue("F$detail_start_row", $response_detail['keterangan']);
                    $sheet->getStyle("F$detail_start_row")->getAlignment()->setWrapText(true);
                    $sheet->getColumnDimension('F')->setWidth(70);
                    $sheet->getStyle("A$detail_start_row:F$detail_start_row")->applyFromArray($styleArray);
                    $sheet->getStyle("D$detail_start_row:F$detail_start_row")->applyFromArray($style_number)->getNumberFormat()->setFormatCode("#,##0.00_);(#,##0.00)");
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
                $filename = 'Laporan Purchase Order (PO)' . date('dmYHis');
                header('Content-Type: application/vnd.ms-excel');
                header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
                header('Cache-Control: max-age=0');
                $writer->save('php://output');
                break;
            case '134':
                //SPB
                $spreadsheet = new Spreadsheet();
                $sheet = $spreadsheet->getActiveSheet();
                $sheet->setCellValue('A1', $penerimaanstokheaders['judul']);
                $sheet->setCellValue('A2', 'Laporan Pembelian Stok (SPB)');
                $sheet->getStyle("A1")->getFont()->setSize(12);
                $sheet->getStyle("A2")->getFont()->setSize(12);
                $sheet->getStyle("A1")->getFont()->setBold(true);
                $sheet->getStyle("A2")->getFont()->setBold(true);
                $sheet->getStyle('A1')->getAlignment()->setHorizontal('center');
                $sheet->getStyle('A2')->getAlignment()->setHorizontal('center');
                $sheet->mergeCells('A1:G1');
                $sheet->mergeCells('A2:G2');
                $header_start_row = 4;
                $header_start_row_right = 4;
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
                        'label' => 'No PO',
                        'index' => 'penerimaanstok_nobukti',
                    ],
                    [
                        'label' => 'Tanggal PO',
                        'index' => 'parrenttglbukti',
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
                        'label' => 'DISKON',
                        'index' => 'nominaldiscount',
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
                    $sheet->setCellValue('C' . $header_start_row++, ': ' . $penerimaanstokheaders[$header_column['index']]);
                }
                foreach ($header_right_columns as $header_column_right) {
                    $sheet->setCellValue('D' . $header_start_row_right, $header_column_right['label']);
                    $sheet->setCellValue('E' . $header_start_row_right++, ': ' . $penerimaanstokheaders[$header_column_right['index']]);
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
                $sheet->getStyle("A$detail_table_header_row:G$detail_table_header_row")->applyFromArray($styleArray);
                // LOOPING DETAIL
                $nominal = 0;
                foreach ($penerimaanstok_details as $response_index => $response_detail) {

                    foreach ($detail_columns as $detail_columns_index => $detail_column) {
                        $sheet->setCellValue($alphabets[$detail_columns_index] . $detail_start_row, isset($detail_column['index']) ? $response_detail[$detail_column['index']] : 0);
                        $sheet->getStyle("A$detail_table_header_row:F$detail_table_header_row")->getFont()->setBold(true);
                        $sheet->getStyle("A$detail_table_header_row:F$detail_table_header_row")->getAlignment()->setHorizontal('center');
                    }
                    $sheet->setCellValue("B$detail_start_row", $response_detail['stok']);
                    $sheet->setCellValue("C$detail_start_row", $response_detail['qty']);
                    $sheet->setCellValue("D$detail_start_row", $response_detail['harga']);
                    $sheet->setCellValue("E$detail_start_row", $response_detail['nominaldiscount']);
                    $sheet->setCellValue("F$detail_start_row", $response_detail['total']);
                    $sheet->setCellValue("G$detail_start_row", $response_detail['keterangan']);
                    $sheet->getStyle("G$detail_start_row")->getAlignment()->setWrapText(true);
                    $sheet->getColumnDimension('G')->setWidth(70);
                    
                    $sheet->getStyle("A$detail_start_row:G$detail_start_row")->applyFromArray($styleArray);
                    $sheet->getStyle("D$detail_start_row:F$detail_start_row")->applyFromArray($style_number)->getNumberFormat()->setFormatCode("#,##0.00_);(#,##0.00)");
                    
                    $nominal += $response_detail['total'];
                    $detail_start_row++;
                }

                $total_start_row = $detail_start_row;
                $sheet->mergeCells('A' . $total_start_row . ':E' . $total_start_row);
                $sheet->setCellValue("A$total_start_row", 'Total')->getStyle('A' . $total_start_row . ':E' . $total_start_row)->applyFromArray($styleArray)->getFont()->setBold(true);
                $sheet->setCellValue("F$total_start_row", $nominal)->getStyle("F$detail_start_row")->applyFromArray($style_number)->getFont()->setBold(true);
                $sheet->getStyle("F$detail_start_row")->getNumberFormat()->setFormatCode("#,##0.00_);(#,##0.00)");
                $sheet->getColumnDimension('A')->setAutoSize(true);
                $sheet->getColumnDimension('B')->setAutoSize(true);
                $sheet->getColumnDimension('C')->setAutoSize(true);
                $sheet->getColumnDimension('D')->setAutoSize(true);
                $sheet->getColumnDimension('E')->setAutoSize(true);
                $sheet->getColumnDimension('F')->setAutoSize(true);
                $writer = new Xlsx($spreadsheet);
                $filename = 'Laporan Pembelian Stok (SPB)' . date('dmYHis');
                header('Content-Type: application/vnd.ms-excel');
                header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
                header('Cache-Control: max-age=0');
                $writer->save('php://output');
                break;
            case '136':
                //KOR
                $trado = $penerimaanstokheaders['trado'];
                $gandengan = $penerimaanstokheaders['gandengan'];
                $gudang = $penerimaanstokheaders['gudang'];
                $persediaan = $this->persediaan($gudang, $trado, $gandengan);
                $data['column'] = $persediaan['column'];
                $data['value'] = $persediaan['value'];

                $penerimaanstokheaders = $data;
                $tglBukti = $penerimaanstokheaders["tglbukti"];
                $timeStamp = strtotime($tglBukti);
                $dateTglBukti = date('d-m-Y', $timeStamp);
                $penerimaanstokheaders['tglbukti'] = $dateTglBukti;

                $spreadsheet = new Spreadsheet();
                $sheet = $spreadsheet->getActiveSheet();
                $sheet->setCellValue('A1', $penerimaanstokheaders['judul']);
                $sheet->setCellValue('A2', 'Laporan Cetak Koreksi Stok (KOR)');
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
                        'index' => $data['value'],
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
                    $sheet->setCellValue('C' . $header_start_row++, ': ' . $penerimaanstokheaders[$header_column['index']]);
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
                foreach ($penerimaanstok_details as $response_index => $response_detail) {

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
                    $sheet->getStyle("D$detail_start_row:E$detail_start_row")->applyFromArray($style_number);
                    
                    $sheet->getStyle("D$detail_start_row:E$detail_start_row")->getNumberFormat()->setFormatCode("#,##0.00_);(#,##0.00)");

                    $nominal += $response_detail['total'];
                    $detail_start_row++;
                }
                $total_start_row = $detail_start_row;
                $sheet->mergeCells('A' . $total_start_row . ':D' . $total_start_row);
                $sheet->setCellValue("A$total_start_row", 'Total')->getStyle('A' . $total_start_row . ':D' . $total_start_row)->applyFromArray($styleArray)->getFont()->setBold(true);
                $sheet->setCellValue("E$total_start_row", $nominal)->getStyle("E$detail_start_row")->applyFromArray($style_number)->getFont()->setBold(true);
                $sheet->getStyle("E$total_start_row")->getNumberFormat()->setFormatCode("#,##0.00_);(#,##0.00)");

                $sheet->getColumnDimension('A')->setAutoSize(true);
                $sheet->getColumnDimension('B')->setAutoSize(true);
                $sheet->getColumnDimension('C')->setAutoSize(true);
                $sheet->getColumnDimension('D')->setAutoSize(true);
                $sheet->getColumnDimension('E')->setAutoSize(true);
                $writer = new Xlsx($spreadsheet);
                $filename = 'Laporan Cetak Koreksi Stok (KOR)' . date('dmYHis');
                header('Content-Type: application/vnd.ms-excel');
                header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
                header('Cache-Control: max-age=0');
                $writer->save('php://output');
                break;
            case '137':
                //PG
                $tradoDari = $penerimaanstokheaders['tradodari'];
                $gandenganDari = $penerimaanstokheaders['gandengandari'];
                $gudangDari = $penerimaanstokheaders['gudangdari'];
                $persediaanDari = $this->persediaanDari($gudangDari, $tradoDari, $gandenganDari);
                $data['columnDari'] = $persediaanDari['columnDari'];
                $data['valueDari'] = $persediaanDari['valueDari'];

                $tradoKe = $penerimaanstokheaders['tradoke'];
                $gandenganKe = $penerimaanstokheaders['gandenganke'];
                $gudangKe = $penerimaanstokheaders['gudangke'];
                $persediaanKe = $this->persediaanKe($gudangKe, $tradoKe, $gandenganKe);
                $data['columnKe'] = $persediaanKe['columnKe'];
                $data['valueKe'] = $persediaanKe['valueKe'];

                $penerimaanstokheaders = $data;

                $spreadsheet = new Spreadsheet();
                $sheet = $spreadsheet->getActiveSheet();
                $sheet->setCellValue('A1', $penerimaanstokheaders['judul']);
                $sheet->setCellValue('A2', 'Laporan Cetak Pindah Gudang(PG)');
                $sheet->getStyle("A1")->getFont()->setSize(12);
                $sheet->getStyle("A2")->getFont()->setSize(12);
                $sheet->getStyle("A1")->getFont()->setBold(true);
                $sheet->getStyle("A2")->getFont()->setBold(true);
                $sheet->getStyle('A1')->getAlignment()->setHorizontal('center');
                $sheet->getStyle('A2')->getAlignment()->setHorizontal('center');
                $sheet->mergeCells('A1:D1');
                $sheet->mergeCells('A2:D2');
                $header_start_row = 4;
                $header_start_row_right = 4;
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
                        'label' => 'No Bon',
                        'index' => 'nobon',
                    ]
                ];
                $header_right_columns = [
                    [
                        'label' => $data['columnDari'],
                        'index' => 'valueDari',
                    ],
                    [
                        'label' => $data['columnKe'],
                        'index' => 'valueKe',
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
                        'label' => 'KETERANGAN',
                        'index' => 'keterangan',
                    ]
                ];
                //LOOPING HEADER        
                foreach ($header_columns as $header_column) {
                    $sheet->setCellValue('B' . $header_start_row, $header_column['label']);
                    $sheet->setCellValue('C' . $header_start_row++, ': ' . $penerimaanstokheaders[$header_column['index']]);
                }
                foreach ($header_right_columns as $header_column_right) {
                    $sheet->setCellValue('D' . $header_start_row_right, $header_column_right['label']);
                    $sheet->setCellValue('E' . $header_start_row_right++, ': ' . $penerimaanstokheaders[$header_column_right['index']]);
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
                $sheet->getStyle("A$detail_table_header_row:D$detail_table_header_row")->applyFromArray($styleArray);
                // LOOPING DETAIL
                foreach ($penerimaanstok_details as $response_index => $response_detail) {

                    foreach ($detail_columns as $detail_columns_index => $detail_column) {
                        $sheet->setCellValue($alphabets[$detail_columns_index] . $detail_start_row, isset($detail_column['index']) ? $response_detail[$detail_column['index']] : 0);
                        $sheet->getStyle("A$detail_table_header_row:F$detail_table_header_row")->getFont()->setBold(true);
                        $sheet->getStyle("A$detail_table_header_row:F$detail_table_header_row")->getAlignment()->setHorizontal('center');
                    }
                    $sheet->setCellValue("A$detail_start_row", $response_index + 1);
                    $sheet->setCellValue("B$detail_start_row", $response_detail['stok']);
                    $sheet->setCellValue("C$detail_start_row", $response_detail['qty']);
                    $sheet->setCellValue("D$detail_start_row", $response_detail['keterangan']);
                    $sheet->getStyle("D$detail_start_row")->getAlignment()->setWrapText(true);
                    $sheet->getColumnDimension('D')->setWidth(50);
                    $sheet->getStyle("A$detail_start_row:D$detail_start_row")->applyFromArray($styleArray);
                    $sheet->getStyle("D$detail_start_row")->applyFromArray($style_number)->getNumberFormat()->setFormatCode("#,##0.00_);(#,##0.00)");

                }
                $sheet->getColumnDimension('A')->setAutoSize(true);
                $sheet->getColumnDimension('B')->setAutoSize(true);
                $sheet->getColumnDimension('C')->setAutoSize(true);
                $writer = new Xlsx($spreadsheet);
                $filename = 'Laporan Cetak Pindah Gudang(PG)' . date('dmYHis');
                header('Content-Type: application/vnd.ms-excel');
                header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
                header('Cache-Control: max-age=0');
                $writer->save('php://output');
                break;
            case '138':
                //SPBS
                $spreadsheet = new Spreadsheet();
                $sheet = $spreadsheet->getActiveSheet();
                $sheet->setCellValue('A1', $penerimaanstok['judul']);
                $sheet->setCellValue('A2', 'Laporan SPB Servis (SPBS)');
                $sheet->getStyle("A1")->getFont()->setSize(12);
                $sheet->getStyle("A2")->getFont()->setSize(12);
                $sheet->getStyle("A1")->getFont()->setBold(true);
                $sheet->getStyle("A2")->getFont()->setBold(true);
                $sheet->getStyle('A1')->getAlignment()->setHorizontal('center');
                $sheet->getStyle('A2')->getAlignment()->setHorizontal('center');
                $sheet->mergeCells('A1:G1');
                $sheet->mergeCells('A2:G2');
                $header_start_row = 4;
                $header_start_row_right = 4;
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
                        'index' => 'nobon',
                    ]
                ];
                $header_right_columns = [
                    [
                        'label' => 'No PO',
                        'index' => 'penerimaanstok_nobukti',
                    ],
                    [
                        'label' => 'Tanggal PO',
                        'index' => 'parrenttglbukti',
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
                        'label' => 'DISKON',
                        'index' => 'nominaldiscount',
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
                    $sheet->setCellValue('C' . $header_start_row++, ': ' . $penerimaanstok[$header_column['index']]);
                }
                foreach ($header_right_columns as $header_column_right) {
                    $sheet->setCellValue('D' . $header_start_row_right, $header_column_right['label']);
                    $sheet->setCellValue('E' . $header_start_row_right++, ': ' . $penerimaanstok[$header_column_right['index']]);
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
                $sheet->getStyle("A$detail_table_header_row:G$detail_table_header_row")->applyFromArray($styleArray);
                // LOOPING DETAIL
                $nominal = 0;
                foreach ($penerimaanstok_details as $response_index => $response_detail) {

                    foreach ($detail_columns as $detail_columns_index => $detail_column) {
                        $sheet->setCellValue($alphabets[$detail_columns_index] . $detail_start_row, isset($detail_column['index']) ? $response_detail[$detail_column['index']] : 0);
                        $sheet->getStyle("A$detail_table_header_row:G$detail_table_header_row")->getFont()->setBold(true);
                        $sheet->getStyle("A$detail_table_header_row:G$detail_table_header_row")->getAlignment()->setHorizontal('center');
                    }
                    $sheet->setCellValue("A$detail_start_row", $response_index + 1);
                    $sheet->setCellValue("B$detail_start_row", $response_detail['stok']);
                    $sheet->setCellValue("C$detail_start_row", $response_detail['qty']);
                    $sheet->setCellValue("D$detail_start_row", $response_detail['harga']);
                    $sheet->setCellValue("E$detail_start_row", $response_detail['nominaldiscount']);
                    $sheet->setCellValue("F$detail_start_row", $response_detail['total']);
                    $sheet->setCellValue("G$detail_start_row", $response_detail['keterangan']);
                    $sheet->getStyle("G$detail_start_row")->getAlignment()->setWrapText(true);
                    $sheet->getColumnDimension('G')->setWidth(70);
                    $sheet->getStyle("A$detail_start_row:G$detail_start_row")->applyFromArray($styleArray);
                    $sheet->getStyle("D$detail_start_row:F$detail_start_row")->applyFromArray($style_number);
                    $sheet->getStyle("D$detail_start_row:F$detail_start_row")->applyFromArray($style_number)->getNumberFormat()->setFormatCode("#,##0.00_);(#,##0.00)");

                    $nominal += $response_detail['total'];
                    $detail_start_row++;
                }

                $total_start_row = $detail_start_row;
                $sheet->mergeCells('A' . $total_start_row . ':E' . $total_start_row);
                $sheet->setCellValue("A$total_start_row", 'Total')->getStyle('A' . $total_start_row . ':E' . $total_start_row)->applyFromArray($styleArray)->getFont()->setBold(true);
                $sheet->setCellValue("F$total_start_row", $nominal)->getStyle("F$detail_start_row")->applyFromArray($style_number)->getFont()->setBold(true);
                $sheet->getStyle("F$detail_start_row")->getNumberFormat()->setFormatCode("#,##0.00_);(#,##0.00)");
                
                $sheet->getColumnDimension('A')->setAutoSize(true);
                $sheet->getColumnDimension('B')->setAutoSize(true);
                $sheet->getColumnDimension('C')->setAutoSize(true);
                $sheet->getColumnDimension('D')->setAutoSize(true);
                $sheet->getColumnDimension('E')->setAutoSize(true);
                $sheet->getColumnDimension('F')->setAutoSize(true);
                $writer = new Xlsx($spreadsheet);
                $filename = 'Laporan SPB Servis (SPBS)' . date('dmYHis');
                header('Content-Type: application/vnd.ms-excel');
                header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
                header('Cache-Control: max-age=0');
                $writer->save('php://output');
                break;
            case '352':
                //PST
                $spreadsheet = new Spreadsheet();
                $sheet = $spreadsheet->getActiveSheet();
                $sheet->setCellValue('A1', $penerimaanstok['judul']);
                $sheet->setCellValue('A2', 'Laporan Pengembalian Sparepart Gantung(PST)');
                $sheet->getStyle("A1")->getFont()->setSize(12);
                $sheet->getStyle("A2")->getFont()->setSize(12);
                $sheet->getStyle("A1")->getFont()->setBold(true);
                $sheet->getStyle("A2")->getFont()->setBold(true);
                $sheet->getStyle('A1')->getAlignment()->setHorizontal('center');
                $sheet->getStyle('A2')->getAlignment()->setHorizontal('center');
                $sheet->mergeCells('A1:F1');
                $sheet->mergeCells('A2:F2');
                $header_start_row = 4;
                $header_start_row_right = 4;
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
                        'label' => 'No GST',
                        'index' => 'pengeluaranstok_nobukti',
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
                    $sheet->setCellValue('C' . $header_start_row++, ': ' . $penerimaanstok[$header_column['index']]);
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
                foreach ($penerimaanstok_details as $response_index => $response_detail) {

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
                $filename = 'Laporan Pengembalian Sparepart Gantung (PST)' . date('dmYHis');
                header('Content-Type: application/vnd.ms-excel');
                header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
                header('Cache-Control: max-age=0');
                $writer->save('php://output');
                break;
            case '361':
                //PSPK
                $spreadsheet = new Spreadsheet();
                $sheet = $spreadsheet->getActiveSheet();
                $sheet->setCellValue('A1', $penerimaanstok['judul']);
                $sheet->setCellValue('A2', 'Laporan Pengembalian SPK');
                $sheet->getStyle("A1")->getFont()->setSize(12);
                $sheet->getStyle("A2")->getFont()->setSize(12);
                $sheet->getStyle("A1")->getFont()->setBold(true);
                $sheet->getStyle("A2")->getFont()->setBold(true);
                $sheet->getStyle('A1')->getAlignment()->setHorizontal('center');
                $sheet->getStyle('A2')->getAlignment()->setHorizontal('center');
                $sheet->mergeCells('A1:F1');
                $sheet->mergeCells('A2:F2');
                $header_start_row = 4;
                $header_start_row_right = 4;
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
                        'label' => 'No SPK',
                        'index' => 'pengeluaranstok_nobukti',
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
                    $sheet->setCellValue('C' . $header_start_row++, ': ' . $penerimaanstok[$header_column['index']]);
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
                foreach ($penerimaanstok_details as $response_index => $response_detail) {

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
                $sheet->getStyle("E$total_start_row")->getNumberFormat()->setFormatCode("#,##0.00_);(#,##0.00)");
                $sheet->getColumnDimension('A')->setAutoSize(true);
                $sheet->getColumnDimension('B')->setAutoSize(true);
                $sheet->getColumnDimension('C')->setAutoSize(true);
                $sheet->getColumnDimension('D')->setAutoSize(true);
                $sheet->getColumnDimension('E')->setAutoSize(true);
                $writer = new Xlsx($spreadsheet);
                $filename = 'Laporan Pengembalian SPK' . date('dmYHis');
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

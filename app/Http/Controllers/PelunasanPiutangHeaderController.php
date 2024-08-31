<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class PelunasanPiutangHeaderController extends MyController
{
    public $title = 'Pelunasan Piutang';

    public function index(Request $request)
    {
        $title = $this->title;
        $data = [
            'combocetak' => $this->comboCetak('list', 'STATUSCETAK', 'STATUSCETAK'),
            'listbtn' => $this->getListBtn()
        ];
        $data = array_merge(
            compact('title', 'data'),
            ["request" => $request->all()]
        );
        return view('pelunasanpiutangheader.index', $data);
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

    public function create()
    {
        $title = $this->title;

        $combo = $this->combo();

        return view('pelunasanpiutangheader.add', compact('title', 'combo'));
    }

    public function store(Request $request)
    {
        try {
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
                ->post(config('app.api_url') . 'pelunasanpiutangheader', $request->all());


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
            ->get(config('app.api_url') . 'pelunasanpiutangheader', $params);

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
            ->get(config('app.api_url') . "pelunasanpiutangheader/$id");
        // dd($response->getBody()->getContents());

        $pelunasanpiutangheader = $response['data'];


        $combo = $this->combo();

        return view('pelunasanpiutangheader.edit', compact('title', 'pelunasanpiutangheader', 'combo'));
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
            ->patch(config('app.api_url') . "pelunasanpiutangheader/$id", $request->all());

        return response($response);
    }

    public function delete($id)
    {
        try {
            $title = $this->title;

            $response = Http::withHeaders($this->httpHeaders)
                ->withOptions(['verify' => false])
                ->withToken(session('access_token'))
                ->get(config('app.api_url') . "pelunasanpiutangheader/$id");

            $pelunasanpiutangheader = $response['data'];

            $combo = $this->combo();

            return view('pelunasanpiutangheader.delete', compact('title', 'combo', 'pelunasanpiutangheader'));
        } catch (\Throwable $th) {
            return redirect()->route('pelunasanpiutangheader.index');
        }
    }

    public function destroy($id)
    {
        $request['modifiedby'] = Auth::user()->name;
        $response = Http::withHeaders($this->httpHeaders)
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->delete(config('app.api_url') . "pelunasanpiutangheader/$id");


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
            ->get(config('app.api_url') . 'pelunasanpiutangheader/combo');

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
            ->get(config('app.api_url') . 'user/combostatus', $status);
        return $response['data'];
    }

    public function report(Request $request)
    {
        //FETCH HEADER
        $id = $request->id;
        $pelunasanPiutangs = Http::withHeaders($request->header())
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'pelunasanpiutangheader/' . $id . '/export')['data'];

        //FETCH DETAIL
        $detailParams = [
            'forReport' => true,
            'pelunasanpiutang_id' => $id,
        ];
        $pelunasanPiutang_details = Http::withHeaders($request->header())
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'pelunasanpiutangdetail', $detailParams)['data'];

        $combo = $this->comboReport('list');
        $key = array_search('CETAK', array_column($combo, 'parameter'));
        $pelunasanPiutangs["combo"] =  $combo[$key];
        $printer['tipe'] = $request->printer;
        return view('reports.pelunasanpiutang', compact('pelunasanPiutang_details', 'pelunasanPiutangs', 'printer'));
    }

    // public function export(Request $request): void
    // {
    //     //FETCH HEADER
    //     $id = $request->id;
    //     $pelunasanPiutangs = Http::withHeaders($request->header())
    //         ->withOptions(['verify' => false])
    //         ->withToken(session('access_token'))
    //         ->get(config('app.api_url') . 'pelunasanpiutangheader/' . $id . '/export')['data'];

    //     //FETCH DETAIL
    //     $detailParams = [
    //         'forReport' => true,
    //         'pelunasanpiutang_id' => $request->id,
    //     ];
    //     $pelunasanPiutang_details = Http::withHeaders($request->header())
    //         ->withOptions(['verify' => false])
    //         ->withToken(session('access_token'))
    //         ->get(config('app.api_url') . 'pelunasanpiutangdetail', $detailParams)['data'];

    //     $spreadsheet = new Spreadsheet();
    //     $sheet = $spreadsheet->getActiveSheet();
    //     $sheet->setCellValue('A1', $pelunasanPiutangs['judul']);
    //     $sheet->setCellValue('A2', $pelunasanPiutangs['judulLaporan']);
    //     $sheet->getStyle("A1")->getFont()->setSize(12);
    //     $sheet->getStyle("A2")->getFont()->setSize(12);
    //     $sheet->getStyle("A1")->getFont()->setBold(true);
    //     $sheet->getStyle("A2")->getFont()->setBold(true);
    //     $sheet->getStyle('A1')->getAlignment()->setHorizontal('center');
    //     $sheet->getStyle('A2')->getAlignment()->setHorizontal('center');
    //     $sheet->mergeCells('A1:J1');
    //     $sheet->mergeCells('A2:J2');

    //     $header_start_row = 4;
    //     $header_right_start_row = 4;
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
    //             'label' => 'Bank/Kas',
    //             'index' => 'bank_id',
    //         ],
    //         [
    //             'label' => 'Customer',
    //             'index' => 'agen_id',
    //         ],
    //     ];
    //     $header_right_columns = [
    //         [
    //             'label' => 'No Bukti Penerimaan',
    //             'index' => 'penerimaan_nobukti',
    //         ],
    //         [
    //             'label' => 'No Bukt Giro',
    //             'index' => 'penerimaangiro_nobukti',
    //         ],
    //         [
    //             'label' => 'Nota Debet',
    //             'index' => 'notadebet_nobukti',
    //         ],
    //         [
    //             'label' => 'Nota Kredit / B. PPH',
    //             'index' => 'notakredit_nobukti',
    //         ]
    //     ];
    //     $detail_columns = [
    //         [
    //             'label' => 'NO',
    //         ],
    //         [
    //             'label' => 'NO BUKTI PIUTANG',
    //             'index' => 'piutang_nobukti',
    //         ],
    //         [
    //             'label' => 'NO BUKTI INVOICE',
    //             'index' => 'invoice_nobukti',
    //         ],
    //         [
    //             'label' => 'NOMINAL PIUTANG',
    //             'index' => 'nominalpiutang',
    //             'format' => 'currency'
    //         ],
    //         [
    //             'label' => 'NOMINAL BAYAR',
    //             'index' => 'nominal',
    //             'format' => 'currency'
    //         ],
    //         [
    //             'label' => 'POTONGAN',
    //             'index' => 'potongan',
    //             'format' => 'currency'
    //         ],
    //         [
    //             'label' => 'LEBIH BAYAR',
    //             'index' => 'nominallebihbayar',
    //             'format' => 'currency'
    //         ],
    //         [
    //             'label' => 'KETERANGAN POTONGAN',
    //             'index' => 'keteranganpotongan',
    //         ],
    //         [
    //             'label' => 'KETERANGAN',
    //             'index' => 'keterangan',
    //         ],
    //         [
    //             'label' => 'POTONGAN PPH',
    //             'index' => 'potonganpph',
    //             'format' => 'currency'
    //         ],
    //         [
    //             'label' => 'KET. POT. PPH',
    //             'index' => 'keteranganpotonganpph',
    //         ],
    //     ];

    //     //LOOPING HEADER        
    //     foreach ($header_columns as $header_column) {
    //         $sheet->setCellValue('B' . $header_start_row, $header_column['label']);
    //         $sheet->setCellValue('C' . $header_start_row++, ': ' . $pelunasanPiutangs[$header_column['index']]);
    //     }

    //     foreach ($header_right_columns as $header_right_column) {
    //         if ($header_right_column['index'] == 'notakredit_nobukti') {

    //             $sheet->setCellValue('D' . $header_right_start_row, $header_right_column['label']);
    //             $sheet->setCellValue('E' . $header_right_start_row++, ': ' . $pelunasanPiutangs['notakredit_nobukti'] . ' / ' . $pelunasanPiutangs['notakreditpph_nobukti']);
    //         } else {
    //             $sheet->setCellValue('D' . $header_right_start_row, $header_right_column['label']);
    //             $sheet->setCellValue('E' . $header_right_start_row++, ': ' . $pelunasanPiutangs[$header_right_column['index']]);
    //         }
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

    //     $style_number = [
    //         'alignment' => [
    //             'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT,
    //         ],

    //         'borders' => [
    //             'top' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
    //             'right' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
    //             'bottom' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
    //             'left' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN]
    //         ]
    //     ];

    //     // $sheet->getStyle("A$detail_table_header_row:G$detail_table_header_row")->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('FF1F456E');
    //     $sheet->getStyle("A$detail_table_header_row:K$detail_table_header_row")->applyFromArray($styleArray);

    //     // LOOPING DETAIL
    //     $nominal = 0;
    //     foreach ($pelunasanPiutang_details as $response_index => $response_detail) {

    //         // foreach ($detail_columns as $detail_columns_index => $detail_column) {
    //         //     $sheet->setCellValue($alphabets[$detail_columns_index] . $detail_start_row, isset($detail_column['index']) ? $response_detail[$detail_column['index']] : $response_index + 1);
    //         //     $sheet->getStyle("A$detail_table_header_row:J$detail_table_header_row")->getFont()->setBold(true);
    //         //     $sheet->getStyle("A$detail_table_header_row:J$detail_table_header_row")->getAlignment()->setHorizontal('center');
    //         // }
    //         $sheet->setCellValue("A$detail_start_row", $response_index + 1);
    //         $sheet->setCellValue("B$detail_start_row", $response_detail['piutang_nobukti']);
    //         $sheet->setCellValue("C$detail_start_row", $response_detail['invoice_nobukti']);
    //         $sheet->setCellValue("D$detail_start_row", $response_detail['nominalpiutang']);
    //         $sheet->setCellValue("E$detail_start_row", $response_detail['nominal']);
    //         $sheet->setCellValue("F$detail_start_row", $response_detail['potongan']);
    //         $sheet->setCellValue("G$detail_start_row", $response_detail['nominallebihbayar']);
    //         $sheet->setCellValue("H$detail_start_row", $response_detail['keteranganpotongan']);
    //         $sheet->setCellValue("I$detail_start_row", $response_detail['keterangan']);
    //         $sheet->setCellValue("J$detail_start_row", $response_detail['potonganpph']);
    //         $sheet->setCellValue("K$detail_start_row", $response_detail['keteranganpotonganpph']);

    //         $sheet->getStyle("H$detail_start_row:I$detail_start_row")->getAlignment()->setWrapText(true);
    //         $sheet->getColumnDimension('H')->setWidth(30);
    //         $sheet->getColumnDimension('I')->setWidth(30);
    //         $sheet->getColumnDimension('K')->setWidth(30);

    //         $sheet->getStyle("A$detail_start_row:K$detail_start_row")->applyFromArray($styleArray);
    //         $sheet->getStyle("D$detail_start_row:G$detail_start_row")->applyFromArray($style_number)->getNumberFormat()->setFormatCode("#,##0.00_);(#,##0.00)");
    //         $sheet->getStyle("J$detail_start_row")->applyFromArray($style_number)->getNumberFormat()->setFormatCode("#,##0.00_);(#,##0.00)");

    //         $nominal += $response_detail['nominal'];
    //         $detail_start_row++;
    //     }

    //     $total_start_row = $detail_start_row;
    //     $sheet->mergeCells('A' . $total_start_row . ':D' . $total_start_row);
    //     $sheet->setCellValue("A$total_start_row", 'Total Nominal Bayar')->getStyle('A' . $total_start_row . ':K' . $total_start_row)->applyFromArray($styleArray)->getFont()->setBold(true);
    //     $sheet->setCellValue("E$detail_start_row", "=SUM(E10:E" . ($detail_start_row - 1) . ")")->getStyle("E$detail_start_row")->applyFromArray($style_number)->getFont()->setBold(true);
    //     $sheet->getStyle("E$detail_start_row")->getNumberFormat()->setFormatCode("#,##0.00_);(#,##0.00)");

    //     $sheet->getColumnDimension('A')->setAutoSize(true);
    //     $sheet->getColumnDimension('B')->setAutoSize(true);
    //     $sheet->getColumnDimension('C')->setAutoSize(true);
    //     $sheet->getColumnDimension('D')->setAutoSize(true);
    //     $sheet->getColumnDimension('E')->setAutoSize(true);
    //     $sheet->getColumnDimension('F')->setAutoSize(true);
    //     $sheet->getColumnDimension('G')->setAutoSize(true);
    //     $sheet->getColumnDimension('J')->setAutoSize(true);

    //     $writer = new Xlsx($spreadsheet);
    //     $filename = 'Laporan Penerimaan Piutang  ' . date('dmYHis');
    //     header('Content-Type: application/vnd.ms-excel');
    //     header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
    //     header('Cache-Control: max-age=0');

    //     $writer->save('php://output');
    // }
}

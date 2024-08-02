<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use stdClass;

class UpahSupirController extends MyController
{
    public $title = 'Upah Supir';

    /**
     * Fungsi index
     * @ClassName index
     */
    public function index(Request $request)
    {
        $title = $this->title;
        $data = [
            'combo' => $this->comboStatusAktif('list'),
            'comboupahzona' => $this->comboCetak('list', 'STATUS UPAH ZONA', 'STATUS UPAH ZONA'),
            'comboluarkota' => $this->comboLuarKota('list'),
            'combopostingtnl' => $this->combocetak('list', 'STATUS POSTING TNL', 'STATUS POSTING TNL'),
            'listbtn' => $this->getListBtn(),
        ];

        return view('upahsupir.index', compact('title', 'data'));
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
            ->get(config('app.api_url') . 'upahsupir', $params);

        $data = [
            'total' => $response['attributes']['totalPages'] ?? [],
            'records' => $response['attributes']['totalRows'] ?? [],
            'rows' => $response['data'] ?? [],
            'params' => $response['params'] ?? [],
        ];

        return $data;
    }

    /**
     * Fungsi create
     * @ClassName create
     */
    public function create()
    {
        $title = $this->title;

        $combo = $this->combo();

        return view('upahsupir.add', compact('title', 'combo'));
    }

    public function store(Request $request)
    {

        try {
            /* Unformat nominal */
            $request->nominalsupir = array_map(function ($nominal) {
                $nominal = str_replace('.', '', $nominal);
                $nominal = str_replace(',', '', $nominal);

                return $nominal;
            }, $request->nominalsupir);

            $request->nominalkenek = array_map(function ($nominal) {
                $nominal = str_replace('.', '', $nominal);
                $nominal = str_replace(',', '', $nominal);

                return $nominal;
            }, $request->nominalkenek);

            $request->nominalkomisi = array_map(function ($nominal) {
                $nominal = str_replace('.', '', $nominal);
                $nominal = str_replace(',', '', $nominal);

                return $nominal;
            }, $request->nominalkomisi);

            $request->nominaltol = array_map(function ($nominal) {
                $nominal = str_replace('.', '', $nominal);
                $nominal = str_replace(',', '', $nominal);

                return $nominal;
            }, $request->nominaltol);

            $request->liter = array_map(function ($nominal) {
                $nominal = str_replace('.', '', $nominal);
                $nominal = str_replace(',', '', $nominal);

                return $nominal;
            }, $request->liter);

            $request->merge([
                'nominalsupir' => $request->nominalsupir,
                'nominalkenek' => $request->nominalkenek,
                'nominalkomisi' => $request->nominalkomisi,
                'nominaltol' => $request->nominaltol,
                'liter' => $request->liter,
            ]);

            $request['modifiedby'] = Auth::user()->name;

            $response = Http::withHeaders($this->httpHeaders)
                ->withOptions(['verify' => false])
                ->withToken(session('access_token'))
                ->post(config('app.api_url') . 'upahsupir', $request->all());

            return response($response, $response->status());
        } catch (\Throwable $th) {
            throw $th->getMessage();
        }
    }

    /**
     * Fungsi edit
     * @ClassName edit
     */
    public function edit($id)
    {
        $title = $this->title;

        $response = Http::withHeaders($this->httpHeaders)
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . "upahsupir/$id");

        $upahsupir = $response['data'];

        $combo = $this->combo();

        return view('upahsupir.edit', compact('title', 'upahsupir', 'combo'));
    }

    public function update(Request $request, $id)
    {
        /* Unformat nominal */
        $request->nominalsupir = array_map(function ($nominal) {
            $nominal = str_replace('.', '', $nominal);
            $nominal = str_replace(',', '', $nominal);

            return $nominal;
        }, $request->nominalsupir);

        $request->nominalkenek = array_map(function ($nominal) {
            $nominal = str_replace('.', '', $nominal);
            $nominal = str_replace(',', '', $nominal);

            return $nominal;
        }, $request->nominalkenek);

        $request->nominalkomisi = array_map(function ($nominal) {
            $nominal = str_replace('.', '', $nominal);
            $nominal = str_replace(',', '', $nominal);

            return $nominal;
        }, $request->nominalkomisi);

        $request->nominaltol = array_map(function ($nominal) {
            $nominal = str_replace('.', '', $nominal);
            $nominal = str_replace(',', '', $nominal);

            return $nominal;
        }, $request->nominaltol);

        $request->liter = array_map(function ($nominal) {
            $nominal = str_replace('.', '', $nominal);
            $nominal = str_replace(',', '', $nominal);

            return $nominal;
        }, $request->liter);

        $request->merge([
            'nominalsupir' => $request->nominalsupir,
            'nominalkenek' => $request->nominalkenek,
            'nominalkomisi' => $request->nominalkomisi,
            'nominaltol' => $request->nominaltol,
            'liter' => $request->liter,
        ]);

        $request['modifiedby'] = Auth::user()->name;

        $response = Http::withHeaders($this->httpHeaders)
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->patch(config('app.api_url') . "upahsupir/$id", $request->all());

        return response($response);
    }

    /**
     * Fungsi delete
     * @ClassName delete
     */
    public function delete($id)
    {
        try {
            $title = $this->title;

            $response = Http::withHeaders($this->httpHeaders)
                ->withOptions(['verify' => false])
                ->withToken(session('access_token'))
                ->get(config('app.api_url') . "upahsupir/$id");

            $upahsupir = $response['data'];
            $combo = $this->combo();

            return view('upahsupir.delete', compact('title', 'combo', 'upahsupir'));
        } catch (\Throwable $th) {
            return redirect()->route('upahsupir.index');
        }
    }

    public function destroy($id)
    {
        $request['modifiedby'] = Auth::user()->name;
        $response = Http::withHeaders($this->httpHeaders)
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->delete(config('app.api_url') . "upahsupir/$id");

        return response($response);
    }
    public function report(Request $request)
    {

        $upahsupir_detail = Http::withHeaders($request->header())
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'upahsupir/export', [
                'limit' => $request->limit,
                'filters' => $request->filters
            ]);

        if ($upahsupir_detail->successful()) {
            $upahsupir_details = $upahsupir_detail['data'];
            $judul = $upahsupir_detail['judul'];

            return view('reports.upahsupir', compact('upahsupir_details', 'judul'));
        } else {
            return response()->json($upahsupir_detail->json(), $upahsupir_detail->status());
        }
    }

    public function export(Request $request): void
    {
        $get = Http::withHeaders($request->header())
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'upahsupir/export', [
                'limit' => $request->limit,
                'filters' => $request->filters
            ]);
        if ($get == null) {
            echo "<script>window.close();</script>";
        } else {
            $upahsupir = $get['data'];
            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();
            $sheet->setCellValue('A1',  $get['judul']['text']);
            $sheet->getStyle("A1")->getFont()->setSize(12);
            $sheet->getStyle("A1")->getFont()->setBold(true);
            $sheet->getStyle('A1')->getAlignment()->setHorizontal('center');
            $sheet->mergeCells('A1:I1');

            $sheet->setCellValue('A2', 'Laporan Upah Supir');
            $sheet->getStyle("A2")->getFont()->setSize(12);
            $sheet->getStyle("A2")->getFont()->setBold(true);
            $sheet->getStyle('A2')->getAlignment()->setHorizontal('center');
            $sheet->mergeCells('A2:I2');

            $header_start_row = 3;
            $detail_start_row = 4;

            $header_columns = [];
            foreach ($upahsupir[0] as $key => $value) {
                if ($key <> 'id') {
                    $header_columns[] =  [
                        'label' => $key,
                        'index' => $key
                    ];
                }
            }
            // $detail_columns = [];
            // foreach($upahritasi[0] as $key => $value)
            // {
            //     $detail_columns[] =  [
            //         'label' => $key,
            //         'index' => $key
            //     ];
            // }

            $alphabets = array();
            for ($i = 'A'; $i <= 'Z'; $i++) {
                $alphabets[] =  $i;
            }
            foreach ($header_columns as $data_columns_index => $data_column) {
                $sheet->setCellValue($alphabets[$data_columns_index] . $header_start_row, $data_column['label'] ?? $data_columns_index + 1);
            }

            $lastColumn = $alphabets[$data_columns_index];
            $styleArray = array(
                'borders' => array(
                    'allBorders' => array(
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    ),
                ),
            );
            $sheet->getStyle("A$header_start_row:$lastColumn$header_start_row")->applyFromArray($styleArray);

            $sheet->getStyle("A$detail_start_row:$lastColumn$detail_start_row")->applyFromArray($styleArray);

            // LOOPING DETAIL
            $total = 0;
            foreach ($upahsupir as $response_index => $response_detail) {

                $alphabets = range('A', 'Z');
                $sheet->getStyle("D$detail_start_row")->getNumberFormat()->setFormatCode('#,##0.00');
                $sheet->getStyle("E$detail_start_row")->getNumberFormat()->setFormatCode('dd-mm-yyyy');
                $sheet->getStyle("F$detail_start_row")->getNumberFormat()->setFormatCode('#,##0.00');
                $sheet->getStyle("G$detail_start_row")->getNumberFormat()->setFormatCode('#,##0.00');
                $sheet->getStyle("H$detail_start_row")->getNumberFormat()->setFormatCode('#,##0.00');
                $sheet->getStyle("I$detail_start_row")->getNumberFormat()->setFormatCode('#,##0.00');
                $sheet->getStyle("J$detail_start_row")->getNumberFormat()->setFormatCode('#,##0.00');
                $sheet->getStyle("K$detail_start_row")->getNumberFormat()->setFormatCode('#,##0.00');
                $sheet->getStyle("L$detail_start_row")->getNumberFormat()->setFormatCode('#,##0.00');
                $sheet->getStyle("M$detail_start_row")->getNumberFormat()->setFormatCode('#,##0.00');
                $sheet->getStyle("N$detail_start_row")->getNumberFormat()->setFormatCode('#,##0.00');
                $sheet->getStyle("O$detail_start_row")->getNumberFormat()->setFormatCode('#,##0.00');
                $sheet->getStyle("P$detail_start_row")->getNumberFormat()->setFormatCode('#,##0.00');
                $sheet->getStyle("Q$detail_start_row")->getNumberFormat()->setFormatCode('#,##0.00');
                $sheet->getStyle("R$detail_start_row")->getNumberFormat()->setFormatCode('#,##0.00');
                $sheet->getStyle("S$detail_start_row")->getNumberFormat()->setFormatCode('#,##0.00');
                $sheet->getStyle("T$detail_start_row")->getNumberFormat()->setFormatCode('#,##0.00');
                $sheet->getStyle("U$detail_start_row")->getNumberFormat()->setFormatCode('#,##0.00');
                $sheet->getStyle("V$detail_start_row")->getNumberFormat()->setFormatCode('#,##0.00');
                $sheet->getStyle("W$detail_start_row")->getNumberFormat()->setFormatCode('#,##0.00');
                foreach ($header_columns as $data_columns_index => $data_column) {
                    if ($data_columns_index == 4) {
                        $tgl = date('Y/m/d', strtotime($response_detail[$data_column['index']]));
                        $excelDateValue = \PhpOffice\PhpSpreadsheet\Shared\Date::PHPToExcel(
                            $tgl
                        );
                        $sheet->setCellValue($alphabets[$data_columns_index] . $detail_start_row, $excelDateValue);
                    } else {
                        $sheet->setCellValue($alphabets[$data_columns_index] . $detail_start_row, $response_detail[$data_column['index']]);
                    }
                    $sheet->getColumnDimension($alphabets[$data_columns_index])->setAutoSize(true);
                }
                $sheet->getStyle("A$header_start_row:$lastColumn$detail_start_row")->applyFromArray($styleArray);
                $detail_start_row++;
            }

            $writer = new Xlsx($spreadsheet);
            $filename = 'Data Upah Supir  ' . date('dmYHis');
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
            header('Cache-Control: max-age=0');

            $writer->save('php://output');
        }
    }

    public function exportOld(Request $request): void
    {

        //FETCH HEADER
        $hutangbayars = Http::withHeaders($request->header())
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'upahritasi/' . $request->id)['data'];

        //FETCH DETAIL
        $detailParams = [
            'upahritasi_id' => $request->id,
        ];

        $responses = Http::withHeaders($request->header())
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'upahritasirincian', $detailParams);

        $hutangbayar_details = $responses['data'];
        $user = $responses['user'];

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'UPAH RITASI');
        $sheet->getStyle("A1")->getFont()->setSize(20);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal('center');
        $sheet->mergeCells('A1:G1');

        $header_start_row = 2;
        $header_right_start_row = 2;
        $detail_table_header_row = 10;
        $detail_start_row = $detail_table_header_row + 1;

        $alphabets = range('A', 'Z');

        $header_columns = [
            [
                'label' => 'Dari',
                'index' => 'kotadari',
            ],
            [
                'label' => 'Tujuan',
                'index' => 'kotasampai',
            ],
            [
                'label' => 'Jarak',
                'index' => 'jarak',
            ],
            [
                'label' => 'Zona',
                'index' => 'zona',
            ],
            [
                'label' => 'Tgl Mulai Berlaku',
                'index' => 'tglmulaiberlaku',
            ],
            [
                'label' => 'Tgl Akhir Berlaku',
                'index' => 'tglakhirberlaku',
            ],
            [
                'label' => 'Status Luar Kota',
                'index' => 'statusluarkotas',
            ],
        ];

        $detail_columns = [
            [
                'label' => 'No',
            ],
            [
                'label' => 'Container',
                'index' => 'container_id',
            ],
            [
                'label' => 'Status Container',
                'index' => 'statuscontainer_id',
            ],
            [
                'label' => 'Liter',
                'index' => 'liter',
            ],
            [
                'label' => 'Nominal Supir',
                'index' => 'nominalsupir',
                'format' => 'currency'
            ],
            [
                'label' => 'Nominal Kenek',
                'index' => 'nominalkenek',
                'format' => 'currency'
            ],
            [
                'label' => 'Nominal Komisi',
                'index' => 'nominalkomisi',
                'format' => 'currency'
            ],
            [
                'label' => 'Nominal Tol',
                'index' => 'nominaltol',
                'format' => 'currency'
            ]
        ];

        //LOOPING HEADER        
        foreach ($header_columns as $header_column) {
            $sheet->setCellValue('B' . $header_start_row, $header_column['label']);

            $sheet->setCellValue('C' . $header_start_row++, ': ' . $hutangbayars[$header_column['index']]);
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
        $sheet->getStyle("A$detail_table_header_row:H$detail_table_header_row")->applyFromArray($styleArray);

        // LOOPING DETAIL
        $nominalSupir = 0;
        $nominalKenek = 0;
        $nominalTol = 0;
        $nominalKomisi = 0;
        foreach ($hutangbayar_details as $response_index => $response_detail) {

            foreach ($detail_columns as $detail_columns_index => $detail_column) {
                $sheet->setCellValue($alphabets[$detail_columns_index] . $detail_start_row, isset($detail_column['index']) ? $response_detail[$detail_column['index']] : $response_index + 1);
            }
            $response_detail['nominalsupirs'] = number_format((float) $response_detail['nominalsupir'], '2', ',', '.');
            $response_detail['nominalkeneks'] = number_format((float) $response_detail['nominalkenek'], '2', ',', '.');
            $response_detail['nominalkomisis'] = number_format((float) $response_detail['nominalkomisi'], '2', ',', '.');
            $response_detail['nominaltols'] = number_format((float) $response_detail['nominaltol'], '2', ',', '.');

            $sheet->setCellValue("A$detail_start_row", $response_index + 1);
            $sheet->setCellValue("B$detail_start_row", $response_detail['container_id']);
            $sheet->setCellValue("C$detail_start_row", $response_detail['statuscontainer_id']);
            $sheet->setCellValue("D$detail_start_row", $response_detail['liter']);
            $sheet->setCellValue("E$detail_start_row", $response_detail['nominalsupirs']);
            $sheet->setCellValue("F$detail_start_row", $response_detail['nominalkeneks']);
            $sheet->setCellValue("G$detail_start_row", $response_detail['nominalkomisis']);
            $sheet->setCellValue("H$detail_start_row", $response_detail['nominaltols']);

            $sheet->getStyle("A$detail_start_row:D$detail_start_row")->applyFromArray($styleArray);
            $sheet->getStyle("E$detail_start_row:H$detail_start_row")->applyFromArray($style_number);
            $nominalSupir += $response_detail['nominalsupir'];
            $nominalKenek += $response_detail['nominalkenek'];
            $nominalKomisi += $response_detail['nominalkomisi'];
            $nominalTol += $response_detail['nominaltol'];
            $detail_start_row++;
        }

        $total_start_row = $detail_start_row;
        $sheet->mergeCells('A' . $total_start_row . ':D' . $total_start_row);
        $sheet->setCellValue("A$total_start_row", 'Total')->getStyle('A' . $total_start_row . ':D' . $total_start_row)->applyFromArray($style_number)->getFont()->setBold(true);
        $sheet->setCellValue("E$total_start_row", number_format((float) $nominalSupir, '2', ',', '.'))->getStyle("E$detail_start_row")->applyFromArray($style_number)->getFont()->setBold(true);
        $sheet->setCellValue("F$total_start_row", number_format((float) $nominalKenek, '2', ',', '.'))->getStyle("F$detail_start_row")->applyFromArray($style_number)->getFont()->setBold(true);
        $sheet->setCellValue("G$total_start_row", number_format((float) $nominalKomisi, '2', ',', '.'))->getStyle("G$detail_start_row")->applyFromArray($style_number)->getFont()->setBold(true);
        $sheet->setCellValue("H$total_start_row", number_format((float) $nominalTol, '2', ',', '.'))->getStyle("H$detail_start_row")->applyFromArray($style_number)->getFont()->setBold(true);

        // set diketahui dibuat
        $ttd_start_row = $total_start_row + 2;
        $sheet->setCellValue("B$ttd_start_row", 'Disetujui');
        $sheet->setCellValue("C$ttd_start_row", 'Diketahui');
        $sheet->setCellValue("D$ttd_start_row", 'Dibuat');
        $sheet->getStyle("B$ttd_start_row:D$ttd_start_row")->applyFromArray($styleArray);

        $sheet->mergeCells("B" . ($ttd_start_row + 1) . ":B" . ($ttd_start_row + 3));
        $sheet->mergeCells("C" . ($ttd_start_row + 1) . ":C" . ($ttd_start_row + 3));
        $sheet->mergeCells("D" . ($ttd_start_row + 1) . ":D" . ($ttd_start_row + 3));
        $sheet->getStyle("B" . ($ttd_start_row + 1) . ":B" . ($ttd_start_row + 3))->applyFromArray($styleArray);
        $sheet->getStyle("C" . ($ttd_start_row + 1) . ":C" . ($ttd_start_row + 3))->applyFromArray($styleArray);
        $sheet->getStyle("D" . ($ttd_start_row + 1) . ":D" . ($ttd_start_row + 3))->applyFromArray($styleArray);

        //set tglcetak
        date_default_timezone_set('Asia/Jakarta');

        $sheet->setCellValue("B" . ($ttd_start_row + 5), 'Dicetak Pada :');
        $sheet->getStyle("B" . ($ttd_start_row + 5))->getFont()->setItalic(true);
        $sheet->setCellValue("C" . ($ttd_start_row + 5), date('d/m/Y H:i:s'));
        $sheet->getStyle("C" . ($ttd_start_row + 5))->getFont()->setItalic(true);
        $sheet->setCellValue("D" . ($ttd_start_row + 5), $user['name']);
        $sheet->getStyle("D" . ($ttd_start_row + 5))->getFont()->setItalic(true);

        $sheet->getColumnDimension('A')->setAutoSize(true);
        $sheet->getColumnDimension('B')->setAutoSize(true);
        $sheet->getColumnDimension('C')->setAutoSize(true);
        $sheet->getColumnDimension('D')->setAutoSize(true);
        $sheet->getColumnDimension('E')->setAutoSize(true);
        $sheet->getColumnDimension('F')->setAutoSize(true);
        $sheet->getColumnDimension('G')->setAutoSize(true);
        $sheet->getColumnDimension('H')->setAutoSize(true);



        $writer = new Xlsx($spreadsheet);
        $filename = 'Laporan Upah Ritasi  ' . date('dmYHis');
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }

    public function OLDexport(Request $request): void
    {

        //FETCH HEADER
        $hutangbayars = Http::withHeaders($request->header())
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'upahsupir/' . $request->id)['data'];

        //FETCH DETAIL
        $detailParams = [
            'upahsupir_id' => $request->id,
        ];

        $responses = Http::withHeaders($request->header())
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'upahsupirrincian', $detailParams);

        $hutangbayar_details = $responses['data'];
        $user = $responses['user'];

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'UPAH SUPIR');
        $sheet->getStyle("A1")->getFont()->setSize(20);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal('center');
        $sheet->mergeCells('A1:G1');

        $header_start_row = 2;
        $header_right_start_row = 2;
        $detail_table_header_row = 10;
        $detail_start_row = $detail_table_header_row + 1;

        $alphabets = range('A', 'Z');

        $header_columns = [
            [
                'label' => 'Dari',
                'index' => 'kotadari',
            ],
            [
                'label' => 'Tujuan',
                'index' => 'kotasampai',
            ],
            [
                'label' => 'Jarak',
                'index' => 'jarak',
            ],
            [
                'label' => 'Zona',
                'index' => 'zona',
            ],
            [
                'label' => 'Tgl Mulai Berlaku',
                'index' => 'tglmulaiberlaku',
            ],
            [
                'label' => 'Tgl Akhir Berlaku',
                'index' => 'tglakhirberlaku',
            ],
            [
                'label' => 'Status Luar Kota',
                'index' => 'statusluarkotas',
            ],
        ];

        $detail_columns = [
            [
                'label' => 'No',
            ],
            [
                'label' => 'Container',
                'index' => 'container_id',
            ],
            [
                'label' => 'Status Container',
                'index' => 'statuscontainer_id',
            ],
            [
                'label' => 'Liter',
                'index' => 'liter',
            ],
            [
                'label' => 'Nominal Supir',
                'index' => 'nominalsupir',
                'format' => 'currency'
            ],
            [
                'label' => 'Nominal Kenek',
                'index' => 'nominalkenek',
                'format' => 'currency'
            ],
            [
                'label' => 'Nominal Komisi',
                'index' => 'nominalkomisi',
                'format' => 'currency'
            ],
            [
                'label' => 'Nominal Tol',
                'index' => 'nominaltol',
                'format' => 'currency'
            ]
        ];

        //LOOPING HEADER        
        foreach ($header_columns as $header_column) {
            $sheet->setCellValue('B' . $header_start_row, $header_column['label']);

            $sheet->setCellValue('C' . $header_start_row++, ': ' . $hutangbayars[$header_column['index']]);
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
        $sheet->getStyle("A$detail_table_header_row:H$detail_table_header_row")->applyFromArray($styleArray);

        // LOOPING DETAIL
        $nominalSupir = 0;
        $nominalKenek = 0;
        $nominalTol = 0;
        $nominalKomisi = 0;
        foreach ($hutangbayar_details as $response_index => $response_detail) {

            foreach ($detail_columns as $detail_columns_index => $detail_column) {
                $sheet->setCellValue($alphabets[$detail_columns_index] . $detail_start_row, isset($detail_column['index']) ? $response_detail[$detail_column['index']] : $response_index + 1);
            }
            $response_detail['nominalsupirs'] = number_format((float) $response_detail['nominalsupir'], '2', ',', '.');
            $response_detail['nominalkeneks'] = number_format((float) $response_detail['nominalkenek'], '2', ',', '.');
            $response_detail['nominalkomisis'] = number_format((float) $response_detail['nominalkomisi'], '2', ',', '.');
            $response_detail['nominaltols'] = number_format((float) $response_detail['nominaltol'], '2', ',', '.');

            $sheet->setCellValue("A$detail_start_row", $response_index + 1);
            $sheet->setCellValue("B$detail_start_row", $response_detail['container_id']);
            $sheet->setCellValue("C$detail_start_row", $response_detail['statuscontainer_id']);
            $sheet->setCellValue("D$detail_start_row", $response_detail['liter']);
            $sheet->setCellValue("E$detail_start_row", $response_detail['nominalsupirs']);
            $sheet->setCellValue("F$detail_start_row", $response_detail['nominalkeneks']);
            $sheet->setCellValue("G$detail_start_row", $response_detail['nominalkomisis']);
            $sheet->setCellValue("H$detail_start_row", $response_detail['nominaltols']);

            $sheet->getStyle("A$detail_start_row:D$detail_start_row")->applyFromArray($styleArray);
            $sheet->getStyle("E$detail_start_row:H$detail_start_row")->applyFromArray($style_number);
            $nominalSupir += $response_detail['nominalsupir'];
            $nominalKenek += $response_detail['nominalkenek'];
            $nominalKomisi += $response_detail['nominalkomisi'];
            $nominalTol += $response_detail['nominaltol'];
            $detail_start_row++;
        }

        $total_start_row = $detail_start_row;
        $sheet->mergeCells('A' . $total_start_row . ':D' . $total_start_row);
        $sheet->setCellValue("A$total_start_row", 'Total')->getStyle('A' . $total_start_row . ':D' . $total_start_row)->applyFromArray($style_number)->getFont()->setBold(true);
        $sheet->setCellValue("E$total_start_row", number_format((float) $nominalSupir, '2', ',', '.'))->getStyle("E$detail_start_row")->applyFromArray($style_number)->getFont()->setBold(true);
        $sheet->setCellValue("F$total_start_row", number_format((float) $nominalKenek, '2', ',', '.'))->getStyle("F$detail_start_row")->applyFromArray($style_number)->getFont()->setBold(true);
        $sheet->setCellValue("G$total_start_row", number_format((float) $nominalKomisi, '2', ',', '.'))->getStyle("G$detail_start_row")->applyFromArray($style_number)->getFont()->setBold(true);
        $sheet->setCellValue("H$total_start_row", number_format((float) $nominalTol, '2', ',', '.'))->getStyle("H$detail_start_row")->applyFromArray($style_number)->getFont()->setBold(true);

        // set diketahui dibuat
        $ttd_start_row = $total_start_row + 2;
        $sheet->setCellValue("B$ttd_start_row", 'Disetujui');
        $sheet->setCellValue("C$ttd_start_row", 'Diketahui');
        $sheet->setCellValue("D$ttd_start_row", 'Dibuat');
        $sheet->getStyle("B$ttd_start_row:D$ttd_start_row")->applyFromArray($styleArray);

        $sheet->mergeCells("B" . ($ttd_start_row + 1) . ":B" . ($ttd_start_row + 3));
        $sheet->mergeCells("C" . ($ttd_start_row + 1) . ":C" . ($ttd_start_row + 3));
        $sheet->mergeCells("D" . ($ttd_start_row + 1) . ":D" . ($ttd_start_row + 3));
        $sheet->getStyle("B" . ($ttd_start_row + 1) . ":B" . ($ttd_start_row + 3))->applyFromArray($styleArray);
        $sheet->getStyle("C" . ($ttd_start_row + 1) . ":C" . ($ttd_start_row + 3))->applyFromArray($styleArray);
        $sheet->getStyle("D" . ($ttd_start_row + 1) . ":D" . ($ttd_start_row + 3))->applyFromArray($styleArray);

        //set tglcetak
        date_default_timezone_set('Asia/Jakarta');

        $sheet->setCellValue("B" . ($ttd_start_row + 5), 'Dicetak Pada :');
        $sheet->getStyle("B" . ($ttd_start_row + 5))->getFont()->setItalic(true);
        $sheet->setCellValue("C" . ($ttd_start_row + 5), date('d/m/Y H:i:s'));
        $sheet->getStyle("C" . ($ttd_start_row + 5))->getFont()->setItalic(true);
        $sheet->setCellValue("D" . ($ttd_start_row + 5), $user['name']);
        $sheet->getStyle("D" . ($ttd_start_row + 5))->getFont()->setItalic(true);

        $sheet->getColumnDimension('A')->setAutoSize(true);
        $sheet->getColumnDimension('B')->setAutoSize(true);
        $sheet->getColumnDimension('C')->setAutoSize(true);
        $sheet->getColumnDimension('D')->setAutoSize(true);
        $sheet->getColumnDimension('E')->setAutoSize(true);
        $sheet->getColumnDimension('F')->setAutoSize(true);
        $sheet->getColumnDimension('G')->setAutoSize(true);
        $sheet->getColumnDimension('H')->setAutoSize(true);



        $writer = new Xlsx($spreadsheet);
        $filename = 'Laporan Upah Supir  ' . date('dmYHis');
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }


    private function combo()
    {
        $response = Http::withHeaders($this->httpHeaders)
            ->withOptions(['verify' => false])
            ->get(config('app.api_url') . 'upahsupir/combo');

        return $response['data'];
    }

    public function comboStatusAktif($aksi)
    {

        $status = [
            'status' => $aksi,
            'grp' => 'STATUS AKTIF',
            'subgrp' => 'STATUS AKTIF',
        ];

        $response = Http::withHeaders($this->httpHeaders)->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'user/combostatus', $status);

        return $response['data'];
    }
    public function comboLuarKota($aksi)
    {

        $status = [
            'status' => $aksi,
            'grp' => 'UPAH SUPIR LUAR KOTA',
            'subgrp' => 'UPAH SUPIR LUAR KOTA',
        ];

        $response = Http::withHeaders($this->httpHeaders)
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'upahritasi/comboluarkota', $status);

        return $response['data'];
    }
}

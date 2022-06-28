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
        ];

        return view('upahsupir.index', compact('title','data'));
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
            ->get(config('app.api_url') .'upahsupir', $params);

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

        $request->merge([
            'nominalsupir' => $request->nominalsupir,
            'nominalkenek' => $request->nominalkenek,
            'nominalkomisi' => $request->nominalkomisi,
            'nominaltol' => $request->nominaltol,
        ]);

        $request['modifiedby'] = Auth::user()->name;

        $response = Http::withHeaders($this->httpHeaders)
        ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->post(config('app.api_url') . 'upahsupir', $request->all());

        return response($response, $response->status());
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

        $request->merge([
            'nominalsupir' => $request->nominalsupir,
            'nominalkenek' => $request->nominalkenek,
            'nominalkomisi' => $request->nominalkomisi,
            'nominaltol' => $request->nominaltol,
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
        $params = [
            'offset' => $request->dari - 1,
            'rows' => $request->sampai - $request->dari + 1,
            'forReport' => true,
        ];

        $upahsupir = $this->get($params)['rows'];

        $detailParams = [
            'forReport' => true
        ];

        foreach ($upahsupir as $upahsupirIndex => $item) {
            $detailParams["whereIn[$upahsupirIndex]"] = $item['id'];
        }

        $upahsupir_details = Http::withHeaders(request()->header())
            ->withToken(session('access_token'))
            ->get('http://localhost/trucking-laravel/public/api/upahsupir_detail', $detailParams)['data'];

        foreach ($upahsupir_details as $upahsupir_detailsIndex => &$upahsupir_detail) {
            $upahsupir_detail['nominal_header'] = number_format((float) $upahsupir_detail['nominal_header'], '2', ',', '.');
            $upahsupir_detail['uangjalan'] = number_format((float) $upahsupir_detail['uangjalan'], '2', ',', '.');
        }

        return view('reports.upahsupir', compact('upahsupir_details'));
    }

    public function export(Request $request): void
    {
        $params = [
            'offset' => $request->dari - 1,
            'rows' => $request->sampai - $request->dari + 1,
            'withRelations' => true,
        ];

        $upahsupir = $this->get($params)['rows'];

        foreach ($upahsupir as &$item) {
            $item['nominal '] = number_format((float) $item['nominal'], '2', ',', '.');

            foreach ($item['absensi_supir_detail'] as &$upahsupir_detail) {
                $upahsupir_detail['trado'] = $upahsupir_detail['trado']['nama'] ?? '';
                $upahsupir_detail['supir'] = $upahsupir_detail['supir']['namasupir'] ?? '';
                $upahsupir_detail['status'] = $upahsupir_detail['absen_trado']['keterangan'] ?? '';
                $upahsupir_detail['uangjalan'] = number_format((float) $upahsupir_detail['uangjalan'], '2', ',', '.');
            }
        }

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'Laporan Kas Gantung');
        $sheet->getStyle("A1")->getFont()->setSize(20);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal('center');
        $sheet->mergeCells('A1:G1');

        $header_start_row = 2;
        $detail_table_header_row = 7;
        $detail_start_row = $detail_table_header_row + 1;

        $alphabets = range('A', 'Z');

        $header_columns = [
            [
                'label' => 'No Bukti',
                'index' => 'nobukti',
            ],
            [
                'label' => 'Tanggal',
                'index' => 'tgl',
            ],
            [
                'label' => 'No Bukti KGT',
                'index' => 'upahsupir_nobukti',
            ],
            [
                'label' => 'Nominal',
                'index' => 'nominal',
            ],
            [
                'label' => 'Keterangan',
                'index' => 'keterangan',
            ]
        ];

        $detail_columns = [
            [
                'label' => 'No',
            ],
            [
                'label' => 'Trado',
                'index' => 'trado',
            ],
            [
                'label' => 'Supir',
                'index' => 'supir',
            ],
            [
                'label' => 'Status',
                'index' => 'status',
            ],
            [
                'label' => 'Keterangan',
                'index' => 'keterangan',
            ],
            [
                'label' => 'Jam',
                'index' => 'jam',
            ],
            [
                'label' => 'Uang Jalan',
                'index' => 'uangjalan',
                'format' => 'currency'
            ]
        ];

        for ($i = 0; $i < count($upahsupir); $i++) {
            foreach ($header_columns as $header_column) {
                $sheet->setCellValue('A' . $header_start_row, $header_column['label']);
                $sheet->setCellValue('B' . $header_start_row, ':');
                $sheet->setCellValue('C' . $header_start_row++, $absensis[$i][$header_column['index']]);
            }

            $header_start_row += count($upahsupir[$i]['absensi_supir_detail']) + 2;

            foreach ($detail_columns as $detail_columns_index => $detail_column) {
                $sheet->setCellValue($alphabets[$detail_columns_index] . $detail_table_header_row, $detail_column['label'] ?? $detail_columns_index + 1);
            }

            $sheet->getStyle("A$detail_table_header_row:G$detail_table_header_row")->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('FF02c4f5');

            foreach ($absensis[$i]['absensi_supir_detail'] as $absensi_supir_details_index => $absensi_supir_detail) {
                foreach ($detail_columns as $detail_columns_index => $detail_column) {
                    $sheet->setCellValue($alphabets[$detail_columns_index] . $detail_start_row, isset($detail_column['index']) ? $absensi_supir_detail[$detail_column['index']] : $absensi_supir_details_index + 1);
                }
                $sheet->setCellValue("A$detail_start_row", $absensi_supir_details_index + 1);
                $sheet->setCellValue("B$detail_start_row", $absensi_supir_detail['trado']);
                $sheet->setCellValue("C$detail_start_row", $absensi_supir_detail['supir']);
                $sheet->setCellValue("D$detail_start_row", $absensi_supir_detail['status']);
                $sheet->setCellValue("E$detail_start_row", $absensi_supir_detail['keterangan']);
                $sheet->setCellValue("F$detail_start_row", $absensi_supir_detail['jam']);
                $sheet->setCellValue("G$detail_start_row", $absensi_supir_detail['uangjalan']);

                $detail_start_row++;
            }

            $detail_table_header_row += (5 + count($absensis[$i]['absensi_supir_detail']) + 2);
            $detail_start_row = $detail_table_header_row + 1;
        }

        $sheet->getColumnDimension('A')->setAutoSize(true);
        $sheet->getColumnDimension('B')->setAutoSize(true);
        $sheet->getColumnDimension('C')->setAutoSize(true);
        $sheet->getColumnDimension('D')->setAutoSize(true);
        $sheet->getColumnDimension('E')->setAutoSize(true);
        $sheet->getColumnDimension('F')->setAutoSize(true);
        $sheet->getColumnDimension('G')->setAutoSize(true);
        $sheet->getColumnDimension('H')->setAutoSize(true);

        $styleArray = array(
            'borders' => array(
                'allBorders' => array(
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ),
            ),
        );

        $writer = new Xlsx($spreadsheet);
        $filename = 'laporanAbsensi' . date('dmYHis');

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

        $response = Http::withHeaders($this->httpHeaders)
        ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'user/combostatus', $status);

        return $response['data'];
    }
}

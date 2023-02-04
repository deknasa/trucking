<?php

namespace App\Http\Controllers;

use App\Models\Tarif;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class TarifController extends MyController
{
    public $title = 'TARIF';

    /**
     * @ClassName
     */
    public function index(Request $request)
    {
        $title = $this->title;
        
        $data = [
            'combo' => $this->comboStatusAktif('list'),
            'comboton' => $this->combocetak('list', 'SISTEM TON', 'SISTEM TON'),
            'combopenyesuaianharga' => $this->combocetak('list', 'PENYESUAIAN HARGA', 'PENYESUAIAN HARGA'),
        ];

        return view('tarif.index', compact('title', 'data'));        

    }

    /**
     * @ClassName
     */
    public function get($params = [])
    {
        $params = [
            'offset' => $params['offset'] ?? request()->offset ?? ((request()->page - 1) * request()->rows),
            'limit' => $params['rows'] ?? request()->rows ?? 0,
            'sortIndex' => $params['sidx'] ?? request()->sidx,
            'sortOrder' => $params['sord'] ?? request()->sord,
            'search' => json_decode($params['filters'] ?? request()->filters, 1) ?? [],
        ];

        $response = Http::withHeaders(request()->header())
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'tarif', $params);

        $data = [
            'total' => $response['attributes']['totalPages'] ?? [],
            'records' => $response['attributes']['totalRows'] ?? [],
            'rows' => $response['data'] ?? [],
            'params' => $params ?? [],
            'message' => $response['message'] ?? ''
        ];

        if (request()->ajax()) {
            return response($data, $response->status());
        }

        return $data;
    }

    /**
     * @ClassName
     */
    public function create(): View
    {
        $title = $this->title;
        $combo = $this->combo();

        return view('tarif.add', compact('title', 'combo'));
    }

    /**
     * @ClassName
     */
    public function store(Request $request): Response
    {
        try {
            $request['modifiedby'] = Auth::user()->name;

            $request->merge([
                'nominal' => str_replace(',', '', str_replace('.', '', $request->nominal)),
                'nominalton' => str_replace(',', '', str_replace('.', '', $request->nominalton)),
            ]);

            $response = Http::withHeaders($this->httpHeaders)
                ->withToken(session('access_token'))
                ->post(config('app.api_url') . 'tarif', $request->all());

            return response($response, $response->status());
        } catch (\Throwable $th) {
            throw $th->getMessage();
        }
    }

    /**
     * @ClassName
     */
    public function edit($id): View
    {
        $title = $this->title;
        $combo = $this->combo();

        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Content-Type' => 'application/json'
        ])->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . "tarif/$id");

        $tarif = $response['data'];

        return view('tarif.edit', compact('title', 'tarif', 'combo'));
    }

    /**
     * @ClassName
     */
    public function update(Request $request, $id): Response
    {
        $request['modifiedby'] = Auth::user()->name;

        $request->merge([
            'nominal' => str_replace(',', '', str_replace('.', '', $request->nominal)),
            'nominalton' => str_replace(',', '', str_replace('.', '', $request->nominalton)),
        ]);

        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ])
            ->withToken(session('access_token'))
            ->patch(config('app.api_url') . "tarif/$id", $request->all());

        return response($response);
    }

    /**
     * @ClassName
     */
    public function delete($id)
    {
        try {
            $title = $this->title;
            $combo = $this->combo();

            $response = Http::withHeaders([
                'Accept' => 'application/json',
                'Content-Type' => 'application/json'
            ])->withOptions(['verify' => false])
                ->withToken(session('access_token'))
                ->get(config('app.api_url') . "tarif/$id");

            $tarif = $response['data'];

            return view('tarif.delete', compact('title', 'tarif', 'combo'));
        } catch (\Throwable $th) {
            return redirect()->route('tarif.index');
        }
    }

    /**
     * @ClassName
     */
    public function destroy($id, Request $request)
    {
        $request['modifiedby'] = Auth::user()->name;

        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Content-Type' => 'application/json'
        ])
            ->withToken(session('access_token'))
            ->delete(config('app.api_url') . "tarif/$id", $request->all());

        return response($response);
    }

    public function fieldLength(): Response
    {
        $response = Http::withHeaders($this->httpHeaders)
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'tarif/field_length');

        return response($response['data']);
    }

    private function combo()
    {
        $response = Http::withHeaders($this->httpHeaders)->withOptions(['verify' => false])->withToken(session('access_token'))
            ->get(config('app.api_url') . 'tarif/combo');

        return $response['data'];
    }

    public function combocetak($aksi, $grp, $subgrp)
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

    public function export(Request $request): void
    {

        $tarif = Http::withHeaders($request->header())
        ->withOptions(['verify' => false])
        ->withToken(session('access_token'))
        ->get(config('app.api_url') . 'tarif/listpivot')['data'];
       

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        // $sheet->setCellValue('A1', 'TAS TARIF');
        // $sheet->getStyle("A1")->getFont()->setSize(20);
        // $sheet->getStyle('A1')->getAlignment()->setHorizontal('center');
        // $sheet->mergeCells('A1:G1');

        $header_start_row = 1;
        $detail_start_row = 2;

        $header_columns = [];
        foreach($tarif[0] as $key => $value)
        {
            $header_columns[] =  [
                'label' => $key,
                'index' => $key
            ];
        }
        // $detail_columns = [];
        // foreach($tarif[0] as $key => $value)
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
            $sheet->setCellValue( $alphabets[$data_columns_index]. $header_start_row, $data_column['label'] ?? $data_columns_index + 1);
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
        foreach ($tarif as $response_index => $response_detail) {
            $alphabets = range('A', 'Z');
            foreach ($header_columns as $data_columns_index => $data_column) {
                $sheet->setCellValue($alphabets[$data_columns_index].$detail_start_row, $response_detail[$data_column['index']]);
                $sheet->getColumnDimension($alphabets[$data_columns_index])->setAutoSize(true);
            }
            $sheet->getStyle("A$header_start_row:$lastColumn$detail_start_row")->applyFromArray($styleArray);
            $detail_start_row++;
        }

        $writer = new Xlsx($spreadsheet);
        $filename = 'Data Tarif  ' . date('dmYHis');
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }
}

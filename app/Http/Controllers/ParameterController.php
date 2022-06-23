<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use app\Helpers\Menu as MenuHelper;

class ParameterController extends MyController
{
    public $title = 'Parameter';

    /**
     * @ClassName
     */
    public function index(Request $request)
    {
        $title = $this->title;

        return view('parameter.index', compact('title'));
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
            ->get(config('app.api_url') . 'parameter', $params);

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
    public function create()
    {
        $title = $this->title;

        return view('parameter.add', compact('title'));
    }

    /**
     * @ClassName
     */
    public function store(Request $request)
    {
        try {
            $request['modifiedby'] = Auth::user()->name;

            $response = Http::withHeaders($this->httpHeaders)->withOptions(['verify' => false])
                ->withToken(session('access_token'))
                ->post(config('app.api_url') . 'parameter', $request->all());

            return response($response, $response->status());
        } catch (\Throwable $th) {
            throw $th->getMessage();
        }
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
            ->get(config('app.api_url') . "parameter/$id");

        $parameter = $response['data'];

        return view('parameter.edit', compact('title', 'parameter'));
    }

    /**
     * @ClassName
     */
    public function update(Request $request, $id)
    {
        $request['modifiedby'] = Auth::user()->name;

        $response = Http::withHeaders($this->httpHeaders)->withOptions(['verify' => false])
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->patch(config('app.api_url') . "parameter/$id", $request->all());

        return response($response, $response->status());
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
                ->get(config('app.api_url') . "parameter/$id");

            $parameter = $response['data'];

            return view('parameter.delete', compact('title', 'parameter'));
        } catch (\Throwable $th) {
            return redirect()->route('parameter.index');
        }
    }

    /**
     * @ClassName
     */
    public function destroy($id, Request $request)
    {
        $request['modifiedby'] = Auth::user()->name;
        $response = Http::withHeaders($this->httpHeaders)
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->delete(config('app.api_url') . "parameter/$id", $request->all());

        return response($response, $response->status());
    }

    public function fieldLength()
    {
        $response = Http::withHeaders($this->httpHeaders)
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'parameter/field_length');

        return response($response['data']);
    }

    /**
     * @ClassName
     */
    public function report(Request $request)
    {
        $response = Http::withHeaders($this->httpHeaders)
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'parameter', $request->all());

        $parameters = $response['data'];

        return view('reports.parameter', compact('parameters'));
    }

    /**
     * @ClassName
     */
    public function export(Request $request)
    {
        $params = [
            'offset' => $request->dari - 1,
            'rows' => $request->sampai - $request->dari + 1,
        ];

        $parameters = $this->get($params)['rows'];

        $columns = [
            [
                'label' => 'No',
            ],
            [
                'label' => 'ID',
                'index' => 'id',
            ],
            [
                'label' => 'Group',
                'index' => 'grp',
            ],
            [
                'label' => 'Subgroup',
                'index' => 'subgrp',
            ],
            [
                'label' => 'Text',
                'index' => 'text',
            ],
            [
                'label' => 'Memo',
                'index' => 'memo',
            ],
        ];

        $this->toExcel($this->title, $parameters, $columns);
    }

    /* The old code to export */
    // public function export(Request $request)
    // {
    //     $params = [
    //         'offset' => $request->dari - 1,
    //         'rows' => $request->sampai - $request->dari + 1,
    //     ];

    //     $parameters = $this->get($params);

    //     $spreadsheet = new Spreadsheet();
    //     $sheet = $spreadsheet->getActiveSheet();
    //     $sheet->setCellValue('A1', 'Laporan Parameter');
    //     $sheet->getStyle("A1")->getFont()->setSize(20);
    //     $sheet->getStyle('A1')->getAlignment()->setHorizontal('center');
    //     $sheet->mergeCells('A1:E1');

    //     $sheet->setCellValue('A2', 'No');
    //     $sheet->setCellValue('B2', 'ID');
    //     $sheet->setCellValue('C2', 'Group');
    //     $sheet->setCellValue('D2', 'Sub Group');
    //     $sheet->setCellValue('E2', 'Nama Parameter');
    //     $sheet->setCellValue('F2', 'Memo');
    //     $sheet->setCellValue('G2', 'ModifiedBy');
    //     $sheet->setCellValue('H2', 'ModifiedOn');

    //     $sheet->getColumnDimension('C')->setAutoSize(true);
    //     $sheet->getColumnDimension('D')->setAutoSize(true);
    //     $sheet->getColumnDimension('E')->setAutoSize(true);
    //     $sheet->getColumnDimension('F')->setAutoSize(true);
    //     $sheet->getColumnDimension('G')->setAutoSize(true);
    //     $sheet->getColumnDimension('H')->setAutoSize(true);

    //     $no = 1;
    //     $x = 3;
    //     foreach ($parameters['rows'] as $row) {
    //         $sheet->setCellValue('A' . $x, $no++);
    //         $sheet->setCellValue('B' . $x, $row['id']);
    //         $sheet->setCellValue('C' . $x, $row['grp']);
    //         $sheet->setCellValue('D' . $x, $row['subgrp']);
    //         $sheet->setCellValue('E' . $x, $row['text']);
    //         $sheet->setCellValue('F' . $x, $row['memo']);
    //         $sheet->setCellValue('G' . $x, $row['modifiedby']);
    //         $sheet->setCellValue('H' . $x,  date("d-m-Y H:i:s", strtotime($row['updated_at'])));
    //         $lastCell = 'H' . $x;
    //         $x++;
    //     }

    //     $sheet->setCellValue('E' . $x, "=ROWS(E3:" . $lastCell . ")");

    //     $styleArray = array(
    //         'borders' => array(
    //             'allBorders' => array(
    //                 'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
    //             ),
    //         ),
    //     );

    //     $sheet->getStyle('A2:H2')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('FF02c4f5');
    //     $sheet->getStyle('A2:' . $lastCell)->applyFromArray($styleArray);

    //     $writer = new Xlsx($spreadsheet);
    //     $filename = 'laporanParameter' . date('dmYHis');

    //     header('Content-Type: application/vnd.ms-excel');
    //     header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
    //     header('Cache-Control: max-age=0');

    //     $writer->save('php://output');
    // }
}

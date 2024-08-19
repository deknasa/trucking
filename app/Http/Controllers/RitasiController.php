<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use stdClass;

class RitasiController extends MyController
{
    public $title = 'RITASI';

    /**
     * @ClassName
     */
    public function index(Request $request)
    {
        $title = $this->title;
        $data = array_merge(
            compact('title'),
            ["request" => $request->all()]
        );
        return view('ritasi.index', $data);
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
            ->get(config('app.api_url') . 'ritasi', $params);

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

        return view('ritasi.add', compact('title', 'combo'));
    }

    /**
     * @ClassName
     */
    public function store(Request $request): Response
    {
        try {
            $request['modifiedby'] = Auth::user()->name;

            $response = Http::withHeaders($this->httpHeaders)
                ->withToken(session('access_token'))
                ->post(config('app.api_url') . 'ritasi', $request->all());

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
        ])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . "ritasi/$id");

        $ritasi = $response['data'];

        return view('ritasi.edit', compact('title', 'ritasi', 'combo'));
    }

    /**
     * @ClassName
     */
    public function update(Request $request, $id): Response
    {
        $request['modifiedby'] = Auth::user()->name;

        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ])
            ->withToken(session('access_token'))
            ->patch(config('app.api_url') . "ritasi/$id", $request->all());

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
            ])
                ->withToken(session('access_token'))
                ->get(config('app.api_url') . "ritasi/$id");

            $ritasi = $response['data'];

            return view('ritasi.delete', compact('title', 'ritasi', 'combo'));
        } catch (\Throwable $th) {
            return redirect()->route('ritasi.index');
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
            ->delete(config('app.api_url') . "ritasi/$id", $request->all());

        return response($response);
    }

    public function fieldLength(): Response
    {
        $response = Http::withHeaders($this->httpHeaders)
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'ritasi/field_length');

        return response($response['data']);
    }

    private function combo()
    {
        $response = Http::withHeaders($this->httpHeaders)
            ->get(config('app.api_url') . 'ritasi/combo');

        return $response['data'];
    }

    public function report(Request $request)
    {
        //FETCH HEADER
        $data = Http::withHeaders($request->header())
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'ritasi/export', [
                'limit' => $request->limit,
                'tgldari' => $request->tgldari,
                'tglsampai' => $request->tglsampai,
                'filters' => $request->filters
            ]);

        if ($data->successful()) {
            $ritasi = $data['data']['data'];
            $params = $data['data']['parameter'];

            return view('reports.ritasi', compact('ritasi', 'params'));
        } else {
            return response()->json($data->json(), $data->status());
        }
    }

    public function export(Request $request): void
    {
        //FETCH HEADER
        $data = Http::withHeaders($request->header())
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'ritasi/export', [
                'limit' => $request->limit,
                'tgldari' => $request->tgldari,
                'tglsampai' => $request->tglsampai,
                'filters' => $request->filters
            ])['data'];
        $ritasi = $data['data'];

        $tglDari = $ritasi[0]['tgldari'];
        $timeStamp = strtotime($tglDari);
        $datetglDari = date('d-m-Y', $timeStamp);
        $periodeDari = $datetglDari;

        $tglSampai = $ritasi[0]['tglsampai'];
        $timeStamp = strtotime($tglSampai);
        $datetglSampai = date('d-m-Y', $timeStamp);
        $periodeSampai = $datetglSampai;

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', $data['parameter']['judul']);
        $sheet->setCellValue('A2', $data['parameter']['judulLaporan']);
        $sheet->getStyle("A1")->getFont()->setSize(12);
        $sheet->getStyle("A2")->getFont()->setSize(12);
        $sheet->getStyle("A1")->getFont()->setBold(true);
        $sheet->getStyle("A2")->getFont()->setBold(true);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal('center');
        $sheet->getStyle('A2')->getAlignment()->setHorizontal('center');
        $sheet->mergeCells('A1:K1');
        $sheet->mergeCells('A2:K2');

        $header_start_row = 4;
        $detail_table_header_row = 7;
        $detail_start_row = $detail_table_header_row + 1;
        $alphabets = range('A', 'Z');

        $header_columns = [
            [
                'label' => 'Periode Dari',
                'index' => $periodeDari
            ],
            [
                'label' => 'Periode Sampai',
                'index' => $periodeSampai
            ]
        ];
        $columns = [
            [
                'label' => 'NO',
            ],
            [
                'label' => 'NO BUKTI',
                'index' => 'nobukti',
            ],
            [
                'label' => 'TANGGAL',
                'index' => 'tglbukti',
            ],
            [
                'label' => 'STATUS RITASI',
                'index' => 'statusritasi',
            ],
            [
                'label' => 'NO BUKTI RIC',
                'index' => 'gajisupir_nobukti',
            ],
            [
                'label' => 'NO BUKTI EBS',
                'index' => 'prosesgajisupir_nobukti',
            ],
            [
                'label' => 'NO BUKTI TRIP',
                'index' => 'suratpengantar_nobukti',
            ],
            [
                'label' => 'SUPIR',
                'index' => 'supir_id',
            ],
            [
                'label' => 'TRADO',
                'index' => 'trado_id',
            ],
            [
                'label' => 'DARI',
                'index' => 'dari_id',
            ],
            [
                'label' => 'SAMPAI',
                'index' => 'sampai_id',
            ],
            [
                'label' => 'JARAK (KM)',
                'index' => 'jarak',
            ],
            [
                'label' => 'GAJI',
                'index' => 'gaji',
            ],
        ];

        //LOOPING HEADER        
        foreach ($header_columns as $header_column) {
            $sheet->setCellValue('B' . $header_start_row, $header_column['label']);
            $sheet->setCellValue('C' . $header_start_row++, ': ' . $header_column['index']);
        }
        foreach ($columns as $detail_columns_index => $detail_column) {
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
        $sheet->getStyle("A$detail_table_header_row:M$detail_table_header_row")->applyFromArray($styleArray);

        $sheet->getStyle("A$detail_table_header_row:M$detail_table_header_row")->getFont()->setBold(true);
        $sheet->getStyle("A$detail_table_header_row:M$detail_table_header_row")->getAlignment()->setHorizontal('center');
        $nominal = 0;
        foreach ($ritasi as $response_index => $response_detail) {
            $dateValue = ($response_detail['tglbukti'] != null) ? Date::PHPToExcel(date('Y-m-d', strtotime($response_detail['tglbukti']))) : '';


            $sheet->setCellValue("A$detail_start_row", $response_index + 1);
            $sheet->setCellValue("B$detail_start_row", $response_detail['nobukti']);
            $sheet->setCellValue("C$detail_start_row", $dateValue);
            $sheet->setCellValue("D$detail_start_row", $response_detail['statusritasi']);
            $sheet->setCellValue("E$detail_start_row", $response_detail['gajisupir_nobukti']);
            $sheet->setCellValue("F$detail_start_row", $response_detail['prosesgajisupir_nobukti']);
            $sheet->setCellValue("G$detail_start_row", $response_detail['suratpengantar_nobukti']);
            $sheet->setCellValue("H$detail_start_row", $response_detail['supir_id']);
            $sheet->setCellValue("I$detail_start_row", $response_detail['trado_id']);
            $sheet->setCellValue("J$detail_start_row", $response_detail['dari_id']);
            $sheet->setCellValue("K$detail_start_row", $response_detail['sampai_id']);
            $sheet->setCellValue("L$detail_start_row", $response_detail['jarak']);
            $sheet->setCellValue("M$detail_start_row", $response_detail['gaji']);

            $sheet->getStyle("A$detail_start_row:L$detail_start_row")->applyFromArray($styleArray);
            $sheet->getStyle("L$detail_start_row:M$detail_start_row")->getNumberFormat()->setFormatCode("#,##0.00_);(#,##0.00)");
            $sheet->getStyle("M$detail_start_row")->applyFromArray($style_number);

            $sheet->getStyle("C$detail_start_row")->getNumberFormat()->setFormatCode('dd-mm-yyyy');
            $detail_start_row++;
        }
        $total_start_row = $detail_start_row;
        //Total
        $sheet->mergeCells('A' . $total_start_row . ':L' . $total_start_row);
        $sheet->setCellValue("A$total_start_row", 'Total')->getStyle('A' . $total_start_row . ':L' . $total_start_row)->applyFromArray($styleArray)->getFont()->setBold(true);

        $total = "=SUM(M" . ($detail_table_header_row + 1) . ":M" . ($detail_start_row - 1) . ")";
        $sheet->setCellValue("M$total_start_row", $total)->getStyle("M$detail_start_row")->applyFromArray($style_number)->getFont()->setBold(true);
        $sheet->getStyle("M$detail_start_row")->getNumberFormat()->setFormatCode("#,##0.00_);(#,##0.00)");

        $sheet->getColumnDimension('A')->setAutoSize(true);
        $sheet->getColumnDimension('B')->setAutoSize(true);
        $sheet->getColumnDimension('C')->setAutoSize(true);
        $sheet->getColumnDimension('D')->setAutoSize(true);
        $sheet->getColumnDimension('E')->setAutoSize(true);
        $sheet->getColumnDimension('F')->setAutoSize(true);
        $sheet->getColumnDimension('G')->setAutoSize(true);
        $sheet->getColumnDimension('H')->setWidth(27);
        $sheet->getColumnDimension('I')->setAutoSize(true);
        $sheet->getColumnDimension('J')->setAutoSize(true);
        $sheet->getColumnDimension('K')->setAutoSize(true);
        $sheet->getColumnDimension('L')->setAutoSize(true);
        $sheet->getColumnDimension('M')->setAutoSize(true);

        $writer = new Xlsx($spreadsheet);
        $filename = 'Laporan Ritasi' . date('dmYHis');
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }
}

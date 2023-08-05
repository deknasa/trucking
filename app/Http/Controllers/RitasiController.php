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

        return view('ritasi.index', compact('title'));
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

        return view('ritasi.add', compact('title','combo'));
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

        return view('ritasi.edit', compact('title', 'ritasi','combo'));
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

            return view('ritasi.delete', compact('title', 'ritasi','combo'));
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
            ->get(config('app.api_url') . 'ritasi/export?dari=' . $request->dari . '&sampai=' . $request->sampai)['data'];
        $ritasi = $data['data'];
        $params = $data['parameter'];

        return view('reports.ritasi', compact('ritasi', 'params'));
    }

    public function export(Request $request):void
    {
        //FETCH HEADER
        $data = Http::withHeaders($request->header())
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'ritasi/export?dari=' . $request->dari . '&sampai=' . $request->sampai)['data'];
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
                'label'=>'Periode Dari',
                'index'=>$periodeDari
            ],
            [
                'label'=>'Periode Sampai',
                'index'=>$periodeSampai
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
                'label' => 'NO BUKTI SURAT PENGANTAR',
                'index' => 'suratpengantar_nobukti',
            ],
            [
                'label' => 'SUPIR',
                'index' => 'supir_id',
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
            $sheet->setCellValue('C' . $header_start_row++, ': '.$header_column['index']);
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
        $sheet ->getStyle("A$detail_table_header_row:K$detail_table_header_row")->applyFromArray($styleArray);

        $nominal = 0;
        foreach ($ritasi as $response_index => $response_detail) {
            foreach ($columns as $detail_columns_index => $detail_column) {
                $sheet->setCellValue($alphabets[$detail_columns_index] . $detail_start_row, isset($detail_column['index']) ? $response_detail[$detail_column['index']] : $response_index + 1);
                $sheet->getStyle("A$detail_table_header_row:K$detail_table_header_row")->getFont()->setBold(true);
                $sheet->getStyle("A$detail_table_header_row:K$detail_table_header_row")->getAlignment()->setHorizontal('center');
            }
            $response_detail['gajis'] = number_format((float) $response_detail['gaji'], '2', '.', ',');

            $tglBukti = $response_detail["tglbukti"];
            $timeStamp = strtotime($tglBukti);
            $dateTglBukti = date('d-m-Y', $timeStamp); 
            $response_detail['tglbukti'] = $dateTglBukti;

            $sheet->setCellValue("A$detail_start_row", $response_index + 1);
            $sheet->setCellValue("B$detail_start_row", $response_detail['nobukti']);
            $sheet->setCellValue("C$detail_start_row", $response_detail['suratpengantar_nobukti']);
            $sheet->setCellValue("D$detail_start_row", $response_detail['supir_id']);
            $sheet->setCellValue("E$detail_start_row", $response_detail['tglbukti']);
            $sheet->setCellValue("F$detail_start_row", $response_detail['statusritasi']);
            $sheet->setCellValue("G$detail_start_row", $response_detail['trado_id']);
            $sheet->setCellValue("H$detail_start_row", $response_detail['dari_id']);
            $sheet->setCellValue("I$detail_start_row", $response_detail['sampai_id']);
            $sheet->setCellValue("J$detail_start_row", $response_detail['jarak']);
            $sheet->setCellValue("K$detail_start_row", $response_detail['gajis']);

            $sheet ->getStyle("A$detail_start_row:J$detail_start_row")->applyFromArray($styleArray);
            $sheet ->getStyle("K$detail_start_row")->applyFromArray($style_number);

            $nominal += $response_detail['gaji'];
            $detail_start_row++;
        }
        $total_start_row = $detail_start_row;
        //Total
        $sheet->mergeCells('A'.$total_start_row.':J'.$total_start_row);
        $sheet->setCellValue("A$total_start_row", 'Total')->getStyle('A'.$total_start_row.':J'.$total_start_row)->applyFromArray($styleArray)->getFont()->setBold(true);
        $sheet->setCellValue("K$total_start_row", number_format((float) $nominal, '2', '.', ','))->getStyle("K$detail_start_row")->applyFromArray($style_number)->getFont()->setBold(true);

        $sheet->getColumnDimension('A')->setAutoSize(true);
        $sheet->getColumnDimension('B')->setAutoSize(true);
        $sheet->getColumnDimension('C')->setAutoSize(true);
        $sheet->getColumnDimension('D')->setAutoSize(true);
        $sheet->getColumnDimension('E')->setAutoSize(true);
        $sheet->getColumnDimension('F')->setAutoSize(true);
        $sheet->getColumnDimension('G')->setAutoSize(true);
        $sheet->getColumnDimension('H')->setAutoSize(true);
        $sheet->getColumnDimension('I')->setAutoSize(true);
        $sheet->getColumnDimension('J')->setAutoSize(true);
        $sheet->getColumnDimension('K')->setAutoSize(true);

        $writer = new Xlsx($spreadsheet);
        $filename = 'Laporan Ritasi' . date('dmYHis');
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }

}

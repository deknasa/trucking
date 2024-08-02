<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class SuratPengantarController extends MyController
{
    public $title = 'Surat Pengantar';

    public $httpHeaders = [
        'Accept' => 'application/json',
        'Content-Type' => 'application/json',
    ];

    // public function __construct()
    // {
    //     $this->middleware(function ($request, $next) {
    //         parent::__construct();

    //         return $next($request);
    //     });
    // }

    public function index(Request $request)
    {
        $title = $this->title;
        $data = [
            'combolongtrip' => $this->comboList('list', 'STATUS LONGTRIP', 'STATUS LONGTRIP'),
            'comboeditsp' => $this->comboList('list', 'STATUS APPROVAL', 'STATUS APPROVAL'),
            'combotolakan' => $this->comboList('list', 'STATUS APPROVAL', 'STATUS APPROVAL'),
            'combotitipan' => $this->comboList('list', 'STATUS APPROVAL', 'STATUS APPROVAL'),
            'comboperalihan' => $this->comboList('list', 'STATUS PERALIHAN', 'STATUS PERALIHAN'),
            'comboritasiomset' => $this->comboList('list', 'STATUS RITASI OMSET', 'STATUS RITASI OMSET'),
            'combogudangsama' => $this->comboList('list', 'STATUS GUDANG SAMA', 'STATUS GUDANG SAMA'),
            'combobatalmuat' => $this->comboList('list', 'STATUS BATAL MUAT', 'STATUS BATAL MUAT'),
            'combogajisupir' => $this->comboList('list', 'STATUS SUDAH BUKA', 'STATUS SUDAH BUKA'),
            'comboinvoice' => $this->comboList('list', 'STATUS SUDAH BUKA', 'STATUS SUDAH BUKA'),
            'listbtn' => $this->getListBtn()
        ];

        $data = array_merge(
            compact('title', 'data'),
            ["request" => $request->all()]
        );
        return view('suratpengantar.index', $data);
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
            ->get(config('app.api_url') . 'suratpengantar', $params);

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

    public function create()
    {
        $title = $this->title;

        $combo = $this->combo();

        return view('suratpengantar.add', compact('title', 'combo'));
    }

    public function store(Request $request): Response
    {
        try {
            $request['modifiedby'] = Auth::user()->name;

            $request['gajisupir'] = str_replace('.', '', $request['gajisupir']);
            $request['gajisupir'] = str_replace(',', '', $request['gajisupir']);

            $request['gajikenek'] = str_replace('.', '', $request['gajikenek']);
            $request['gajikenek'] = str_replace(',', '', $request['gajikenek']);

            $request['komisisupir'] = str_replace('.', '', $request['komisisupir']);
            $request['komisisupir'] = str_replace(',', '', $request['komisisupir']);

            $response = Http::withHeaders([
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ])
                ->withToken(session('access_token'))
                ->post(config('app.api_url') . 'suratpengantar', $request->all());

            return response($response, $response->status());
        } catch (\Throwable $th) {
            dd($th->getMessage());
            throw $th->getMessage();
        }
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $title = $this->title;

        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Content-Type' => 'application/json'
        ])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . "suratpengantar/$id");

        $suratpengantar = $response['data'];
        $combo = $this->combo();

        return view('suratpengantar.edit', compact('title', 'suratpengantar', 'combo'));
    }

    public function update(Request $request, $id): Response
    {
        $request['modifiedby'] = Auth::user()->name;

        $request['gajisupir'] = str_replace('.', '', $request['gajisupir']);
        $request['gajisupir'] = str_replace(',', '', $request['gajisupir']);

        $request['gajikenek'] = str_replace('.', '', $request['gajikenek']);
        $request['gajikenek'] = str_replace(',', '', $request['gajikenek']);

        $request['komisisupir'] = str_replace('.', '', $request['komisisupir']);
        $request['komisisupir'] = str_replace(',', '', $request['komisisupir']);

        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ])
            ->withToken(session('access_token'))
            ->patch(config('app.api_url') . "suratpengantar/$id", $request->all());

        return response($response);
    }

    public function delete($id)
    {
        try {
            $title = $this->title;

            $response = Http::withHeaders($this->httpHeaders)->withOptions(['verify' => false])
                ->withToken(session('access_token'))
                ->get(config('app.api_url') . "suratpengantar/$id");

            $suratpengantar = $response['data'];

            $combo = $this->combo();

            return view('suratpengantar.delete', compact('title', 'suratpengantar', 'combo'));
        } catch (\Throwable $th) {
            return redirect()->route('suratpengantar.index');
        }
    }

    public function destroy($id, Request $request)
    {
        $response = Http::withHeaders($this->httpHeaders)->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->delete(config('app.api_url') . "suratpengantar/$id", $request->all());

        return response($response);
    }

    // public function delete($id)
    // {
    //     try {
    //         $title = $this->title;

    //         $response = Http::withHeaders([
    //             'Accept' => 'application/json',
    //             'Content-Type' => 'application/json'
    //         ])
    //             ->withToken(session('access_token'))
    //             ->get(config('app.api_url') . "suratpengantar/$id");

    //         $suratpengantar = $response['data'];
    //         $combo = $this->combo();

    //         return view('suratpengantar.delete', compact('title', 'suratpengantar','combo'));
    //     } catch (\Throwable $th) {
    //         return redirect()->route('suratpengantar.index');
    //     }
    // }

    // public function destroy($id, Request $request)
    // {
    //     $request['modifiedby'] = Auth::user()->name;

    //     $response = Http::withHeaders([
    //         'Accept' => 'application/json',
    //         'Content-Type' => 'application/json'
    //     ])
    //         ->withToken(session('access_token'))
    //         ->delete(config('app.api_url') . "suratpengantar/$id", $request->all());

    //     return response($response);
    // }

    public function fieldLength(): Response
    {
        $response = Http::withHeaders($this->httpHeaders)->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'suratpengantar/field_length');

        return response($response['data']);
    }

    public function getGaji(Request $request): Response
    {
        $response = Http::withHeaders($this->httpHeaders)->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'suratpengantar/get_gaji', $request->all());

        return response($response['data']);
    }

    private function combo()
    {
        $response = Http::withHeaders($this->httpHeaders)->withOptions(['verify' => false])
            ->get(config('app.api_url') . 'suratpengantar/combo');

        return $response['data'];
    }

    public function report(Request $request)
    {
        //FETCH HEADER
        $data = Http::withHeaders($request->header())
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'suratpengantar/export', [
                'limit' => $request->limit,
                'tgldari' => $request->tgldari,
                'tglsampai' => $request->tglsampai,
                'filters' => $request->filters
            ]);

        if ($data->successful()) {
            $suratpengantar = $data['data']['data'];
            $params = $data['data']['parameter'];
            $params['tgldari'] = $request->tgldari;
            $params['tglsampai'] = $request->tglsampai;
            return view('reports.suratpengantar', compact('suratpengantar', 'params'));
        } else {
            return response()->json($data->json(), $data->status());
        }
    }

    public function export(Request $request): void
    {
        //FETCH HEADER
        $data_header = Http::withHeaders($request->header())
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'suratpengantar/export', [
                'limit' => $request->limit,
                'tgldari' => $request->tgldari,
                'tglsampai' => $request->tglsampai,
                'filters' => $request->filters
            ])['data'];
        $suratPengantar = $data_header['data'];

        // $tglDari = $suratPengantar[0]['tgldari'];
        $timeStamp = strtotime($request->tgldari);
        $datetglDari = date('d-m-Y', $timeStamp);
        $periodeDari = $datetglDari;

        // $tglSampai = $suratPengantar[0]['tglsampai'];
        $timeStamp = strtotime($request->tglsampai);
        $datetglSampai = date('d-m-Y', $timeStamp);
        $periodeSampai = $datetglSampai;

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', $data_header['parameter']['judul']);
        $sheet->setCellValue('A2', $data_header['parameter']['judulLaporan']);
        $sheet->getStyle("A1")->getFont()->setSize(12);
        $sheet->getStyle("A2")->getFont()->setSize(11);
        $sheet->getStyle("A1")->getFont()->setBold(true);
        $sheet->getStyle("A2")->getFont()->setBold(true);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal('center');
        $sheet->getStyle('A2')->getAlignment()->setHorizontal('center');
        $sheet->mergeCells('A1:Z1');
        $sheet->mergeCells('A2:Z2');

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
                'label' => 'JOB TRUCKING',
                'index' => 'jobtrucking',
            ],
            [
                'label' => 'NO TRIP',
                'index' => 'nobukti',
            ],
            [
                'label' => 'TANGGAL TRIP',
                'index' => 'tglbukti',
            ],
            [
                'label' => 'NO SP',
                'index' => 'nosp',
            ],
            [
                'label' => 'TANGGAL SP',
                'index' => 'tglsp',
            ],
            [
                'label' => 'SHIPPER',
                'index' => 'pelanggan_id',
            ],
            [
                'label' => 'KETERANGAN',
                'index' => 'keterangan',
            ],
            [
                'label' => 'NO JOB',
                'index' => 'nojob',
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
                'label' => 'CUSTOMER',
                'index' => 'agen_id',
            ],
            [
                'label' => 'JENIS ORDER',
                'index' => 'jenisorder_id',
            ],
            [
                'label' => 'JARAK (KM)',
                'index' => 'jarak',
            ],
            [
                'label' => 'NO CONTAINER',
                'index' => 'nocont',
            ],
            [
                'label' => 'CONTAINER',
                'index' => 'container_id',
            ],
            [
                'label' => 'STATUS CONTAINER',
                'index' => 'statuscontainer_id',
            ],
            [
                'label' => 'GUDANG',
                'index' => 'gudang',
            ],
            [
                'label' => 'NO POLISI',
                'index' => 'trado_id',
            ],
            [
                'label' => 'SUPIR',
                'index' => 'supir_id',
            ],
            [
                'label' => 'CHASIS',
                'index' => 'gandengan_id',
            ],
            [
                'label' => 'LOKASI BONGKAR MUAT',
                'index' => 'tarif_id',
            ],
            [
                'label' => 'MANDOR TRADO',
                'index' => 'mandortrado_id',
            ],
            [
                'label' => 'MANDOR SUPIR',
                'index' => 'mandorsupir_id',
            ],
            [
                'label' => 'NO SEAL',
                'index' => 'noseal',
            ],
            [
                'label' => 'GAJI SUPIR',
                'index' => 'gajisupir',
                'format' => 'currency'
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
        $sheet->getStyle("A$detail_table_header_row:Z$detail_table_header_row")->applyFromArray($styleArray);

        if (is_iterable($suratPengantar)) {
            $gajisupir = 0;
            foreach ($suratPengantar as $response_index => $response_detail) {
                foreach ($columns as $detail_columns_index => $detail_column) {
                    $sheet->setCellValue($alphabets[$detail_columns_index] . $detail_start_row, isset($detail_column['index']) ? $response_detail[$detail_column['index']] : $response_index + 1);
                    $sheet->getStyle("A$detail_table_header_row:Z$detail_table_header_row")->getFont()->setBold(true);
                    $sheet->getStyle("A$detail_table_header_row:Z$detail_table_header_row")->getAlignment()->setHorizontal('center');
                }
                $response_detail['gajisupirs'] = number_format((float) $response_detail['gajisupir'], '2', '.', ',');

                $tglTrip = $response_detail["tglbukti"];
                $timeStamp = strtotime($tglTrip);
                $datetglTrip = date('d-m-Y', $timeStamp);
                $response_detail['tglbukti'] = $datetglTrip;

                $tglSp = $response_detail["tglsp"];
                $timeStamp = strtotime($tglSp);
                $datetglSp = date('d-m-Y', $timeStamp);
                $response_detail['tglsp'] = $datetglSp;

                $sheet->setCellValue("A$detail_start_row", $response_index + 1);
                $sheet->setCellValue("B$detail_start_row", $response_detail['jobtrucking']);
                $sheet->setCellValue("C$detail_start_row", $response_detail['nobukti']);
                $sheet->setCellValue("D$detail_start_row", $response_detail['tglbukti']);
                $sheet->setCellValue("E$detail_start_row", $response_detail['nosp']);
                $sheet->setCellValue("F$detail_start_row", $response_detail['tglsp']);
                $sheet->setCellValue("G$detail_start_row", $response_detail['pelanggan_id']);
                $sheet->setCellValue("H$detail_start_row", $response_detail['keterangan']);
                $sheet->setCellValue("I$detail_start_row", $response_detail['nojob']);
                $sheet->setCellValue("J$detail_start_row", $response_detail['dari_id']);
                $sheet->setCellValue("K$detail_start_row", $response_detail['sampai_id']);
                $sheet->setCellValue("L$detail_start_row", $response_detail['agen_id']);
                $sheet->setCellValue("M$detail_start_row", $response_detail['jenisorder_id']);
                $sheet->setCellValue("N$detail_start_row", $response_detail['jarak']);
                $sheet->setCellValue("O$detail_start_row", $response_detail['nocont']);
                $sheet->setCellValue("P$detail_start_row", $response_detail['container_id']);
                $sheet->setCellValue("Q$detail_start_row", $response_detail['statuscontainer_id']);
                $sheet->setCellValue("R$detail_start_row", $response_detail['gudang']);
                $sheet->setCellValue("S$detail_start_row", $response_detail['trado_id']);
                $sheet->setCellValue("T$detail_start_row", $response_detail['supir_id']);
                $sheet->setCellValue("U$detail_start_row", $response_detail['gandengan_id']);
                $sheet->setCellValue("V$detail_start_row", $response_detail['tarif_id']);
                $sheet->setCellValue("W$detail_start_row", $response_detail['mandortrado_id']);
                $sheet->setCellValue("X$detail_start_row", $response_detail['mandorsupir_id']);
                $sheet->setCellValue("Y$detail_start_row", $response_detail['noseal']);
                $sheet->setCellValue("Z$detail_start_row", $response_detail['gajisupirs']);

                $sheet->getStyle("H$detail_start_row")->getAlignment()->setWrapText(true);
                $sheet->getColumnDimension('H')->setWidth(50);

                $sheet->getStyle("A$detail_start_row:Y$detail_start_row")->applyFromArray($styleArray);
                $sheet->getStyle("Z$detail_start_row")->applyFromArray($style_number);

                $gajisupir += $response_detail['gajisupir'];
                $detail_start_row++;
            }
            $total_start_row = $detail_start_row;
            $sheet->mergeCells('A' . $total_start_row . ':Y' . $total_start_row);
            $sheet->setCellValue("A$total_start_row", 'Total')->getStyle('A' . $total_start_row . ':Y' . $total_start_row)->applyFromArray($styleArray)->getFont()->setBold(true);
            $sheet->setCellValue("Z$total_start_row", number_format((float) $gajisupir, '2', '.', ','))->getStyle("Z$detail_start_row")->applyFromArray($style_number)->getFont()->setBold(true);
        }

        $sheet->getColumnDimension('A')->setAutoSize(true);
        $sheet->getColumnDimension('B')->setAutoSize(true);
        $sheet->getColumnDimension('C')->setAutoSize(true);
        $sheet->getColumnDimension('D')->setAutoSize(true);
        $sheet->getColumnDimension('E')->setAutoSize(true);
        $sheet->getColumnDimension('F')->setAutoSize(true);
        $sheet->getColumnDimension('G')->setAutoSize(true);
        $sheet->getColumnDimension('I')->setAutoSize(true);
        $sheet->getColumnDimension('J')->setAutoSize(true);
        $sheet->getColumnDimension('K')->setAutoSize(true);
        $sheet->getColumnDimension('L')->setAutoSize(true);
        $sheet->getColumnDimension('M')->setAutoSize(true);
        $sheet->getColumnDimension('N')->setAutoSize(true);
        $sheet->getColumnDimension('O')->setAutoSize(true);
        $sheet->getColumnDimension('P')->setAutoSize(true);
        $sheet->getColumnDimension('Q')->setAutoSize(true);
        $sheet->getColumnDimension('R')->setAutoSize(true);
        $sheet->getColumnDimension('S')->setAutoSize(true);
        $sheet->getColumnDimension('T')->setAutoSize(true);
        $sheet->getColumnDimension('U')->setAutoSize(true);
        $sheet->getColumnDimension('V')->setAutoSize(true);
        $sheet->getColumnDimension('W')->setAutoSize(true);
        $sheet->getColumnDimension('X')->setAutoSize(true);
        $sheet->getColumnDimension('Y')->setAutoSize(true);
        $sheet->getColumnDimension('Z')->setAutoSize(true);

        $writer = new Xlsx($spreadsheet);
        $filename = 'Laporan Surat Pengantar' . date('dmYHis');
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }
}

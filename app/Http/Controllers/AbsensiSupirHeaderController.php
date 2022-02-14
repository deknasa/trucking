<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use stdClass;

class AbsensiSupirHeaderController extends Controller
{
    public $title = 'Absensi';

    public $httpHeaders = [
        'Accept' => 'application/json',
        'Content-Type' => 'application/json'
    ];

    /**
     * Fungsi index
     * @ClassName index
     */
    public function index(Request $request)
    {
        $title = $this->title;

        return view('absensi.index', compact('title'));
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
            ->get('http://localhost/trucking-laravel/public/api/absensi', $params);

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

        $noBukti = $this->getNoBukti('ABSENSI', 'ABSENSI', 'absensisupirheader');
        $kasGantungNoBukti = $this->getNoBukti('ABSENSI', 'ABSENSI', 'absensisupirheader');

        $combo = [
            'trado' => $this->getTrado(),
            'supir' => $this->getSupir(),
            'status' => $this->getStatus(),
        ];

        return view('absensi.add', compact('title', 'noBukti', 'combo', 'kasGantungNoBukti'));
    }

    public function store(Request $request)
    {
        /* Unformat uangjalan */
        $request->uangjalan = array_map(function ($uangjalan) {
            $uangjalan = str_replace('.', '', $uangjalan);
            $uangjalan = str_replace(',', '.', $uangjalan);

            return $uangjalan;
        }, $request->uangjalan);

        $request->merge([
            'uangjalan' => $request->uangjalan
        ]);
        
        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ])->post(config('app.api_url') . 'absensi', $request->all());

        return response($response);
    }

    /**
     * Fungsi edit
     * @ClassName edit
     */
    public function edit($id)
    {
        $title = $this->title;

        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Content-Type' => 'application/json'
        ])->get(config('app.api_url') . "absensi/$id");

        $absensi = $response['data'];
        $combo = [
            'trado' => $this->getTrado(),
            'supir' => $this->getSupir(),
            'status' => $this->getStatus(),
        ];

        return view('absensi.edit', compact('title', 'absensi', 'combo'));
    }

    public function update(Request $request, $id)
    {
        /* Unformat uangjalan */
        $request->uangjalan = array_map(function ($uangjalan) {
            $uangjalan = str_replace('.', '', $uangjalan);
            $uangjalan = str_replace(',', '.', $uangjalan);

            return $uangjalan;
        }, $request->uangjalan);

        $request->merge([
            'uangjalan' => $request->uangjalan
        ]);

        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ])->patch(config('app.api_url') . "absensi/$id", $request->all());

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

            $response = Http::withHeaders([
                'Accept' => 'application/json',
                'Content-Type' => 'application/json'
            ])->get(config('app.api_url') . "absensi/$id");

            $absensi = $response['data'];
            $combo = [
                'trado' => $this->getTrado(),
                'supir' => $this->getSupir(),
                'status' => $this->getStatus(),
            ];

            return view('absensi.delete', compact('title', 'combo', 'absensi'));
        } catch (\Throwable $th) {
            return redirect()->route('absensi.index');
        }
    }

    public function destroy($id)
    {
        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Content-Type' => 'application/json'
        ])->delete(config('app.api_url') . "absensi/$id");

        return response($response);
    }

    public function getTrado()
    {
        $response = Http::get(config('app.api_url') . 'trado');

        return $response['data'];
    }

    public function getSupir()
    {
        $response = Http::get(config('app.api_url') . 'supir');

        return $response['data'];
    }

    public function getStatus()
    {
        $response = Http::get(config('app.api_url') . 'absentrado');

        return $response['data'];
    }

    public function getNoBukti($group, $subgroup, $table)
    {
        $params = [
            'group' => $group,
            'subgroup' => $subgroup,
            'table' => $table
        ];

        $response = Http::withHeaders($this->httpHeaders)
            ->get(config('app.api_url') . "absensi/running_number", $params);

        $noBukti = $response['data'] ?? 'No bukti tidak ditemukan';

        return $noBukti;
    }

    public function report(Request $request)
    {
        $params = [
            'offset' => $request->dari - 1,
            'rows' => $request->sampai - $request->dari + 1,
            'forReport' => true,
        ];

        $absensis = $this->get($params)['rows'];

        $detailParams = [
            'forReport' => true
        ];

        foreach($absensis as $absensisIndex => $absensi) {
            $detailParams["whereIn[$absensisIndex]"] = $absensi['id'];
        }

        $absensi_details = Http::withHeaders(request()->header())
            ->get('http://localhost/trucking-laravel/public/api/absensi_detail', $detailParams)['data'];

        foreach ($absensi_details as $absensi_detailsIndex => &$absensi_detail) {
            $absensi_detail['nominal_header'] = number_format((float) $absensi_detail['nominal_header'], '2', ',', '.');
            $absensi_detail['uangjalan'] = number_format((float) $absensi_detail['uangjalan'], '2', ',', '.');
        }

        return view('reports.absensi', compact('absensi_details'));
    }

    public function export(Request $request): void
    {
        $params = [
            'offset' => $request->dari - 1,
            'rows' => $request->sampai - $request->dari + 1,
            'withRelations' => true,
        ];

        $absensis = $this->get($params)['rows'];

        foreach ($absensis as &$absensi) {
            $absensi['nominal '] = number_format((float) $absensi['nominal'], '2', ',', '.');
            
            foreach ($absensi['absensi_supir_detail'] as &$absensi_supir_detail) {
                $absensi_supir_detail['trado'] = $absensi_supir_detail['trado']['nama'] ?? '';
                $absensi_supir_detail['supir'] = $absensi_supir_detail['supir']['namasupir'] ?? '';
                $absensi_supir_detail['status'] = $absensi_supir_detail['absen_trado']['keterangan'] ?? '';
                $absensi_supir_detail['uangjalan'] = number_format((float) $absensi_supir_detail['uangjalan'], '2', ',', '.');
            }
        }

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'Laporan Absensi');
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
                'index' => 'kasgantung_nobukti',
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

        for ($i = 0; $i < count($absensis); $i++) {
            foreach ($header_columns as $header_column) {
                $sheet->setCellValue('A' . $header_start_row, $header_column['label']);
                $sheet->setCellValue('B' . $header_start_row, ':');
                $sheet->setCellValue('C' . $header_start_row++, $absensis[$i][$header_column['index']]);
            }

            $header_start_row += count($absensis[$i]['absensi_supir_detail']) + 2;

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
}

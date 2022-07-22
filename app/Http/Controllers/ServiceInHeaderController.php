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

class ServiceInHeaderController extends MyController
{
    public $title = 'Service in';

    public function index(Request $request)
    {
        $title = $this->title;
        
        return view('servicein.index', compact('title'));
    }

    public function store(Request $request)
    {
        try {
            $request['modifiedby'] = Auth::user()->name;

            $response = Http::withHeaders($this->httpHeaders)
                ->withOptions(['verify' => false])
                ->withToken(session('access_token'))
                ->post(config('app.api_url') . 'serviceinheader', $request->all());


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
            ->get(config('app.api_url') . 'servicein', $params);

        $data = [
            'total' => $response['attributes']['totalPages'] ?? [],
            'records' => $response['attributes']['totalRows'] ?? [],
            'rows' => $response['data'] ?? [],
            'params' => $response['params'] ?? [],
        ];

        return $data;
    }

    // /**
    //  * Fungsi create
    //  * @ClassName create
    //  */
    public function create()
    {
        $title = $this->title;

        $combo = $this->combo();

        return view('servicein.add', compact('title' , 'combo'));
    }

    // /**
    //  * Fungsi edit
    //  * @ClassName edit
    //  */
    public function edit($id)
    {
        $title = $this->title;

        $response = Http::withHeaders($this->httpHeaders)
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . "servicein/$id");

        $servicein = $response['data'];
        $serviceNoBukti = $this->getNoBukti('SERVICEIN', 'SERVICEIN', 'serviceheader');

        $combo = $this->combo();

        return view('servicein.edit', compact('title', 'servicein', 'combo', 'serviceNoBukti'));
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
            ->patch(config('app.api_url') . "servicein/$id", $request->all());

        return response($response);
    }

    // /**
    //  * Fungsi delete
    //  * @ClassName delete
    //  */
    public function delete($id)
    {
        try {
            $title = $this->title;

            $response = Http::withHeaders($this->httpHeaders)
                ->withOptions(['verify' => false])
                ->withToken(session('access_token'))
                ->get(config('app.api_url') . "servicein/$id");

            $servicein = $response['data'];
            $combo = $this->combo();

            return view('servicein.delete', compact('title', 'combo', 'servicein'));
        } catch (\Throwable $th) {
            return redirect()->route('servicein.index');
        }
    }

    public function destroy($id)
    {
        $request['modifiedby'] = Auth::user()->name;
        $response = Http::withHeaders($this->httpHeaders)
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->delete(config('app.api_url') . "servicein/$id");

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

    // public function report(Request $request)
    // {
    //     $params = [
    //         'offset' => $request->dari - 1,
    //         'rows' => $request->sampai - $request->dari + 1,
    //         'forReport' => true,
    //     ];

    //     $service = $this->get($params)['rows'];

    //     $detailParams = [
    //         'forReport' => true
    //     ];

    //     foreach ($service as $serviceIndex => $item) {
    //         $detailParams["whereIn[$serviceIndex]"] = $item['id'];
    //     }

    //     $service_details = Http::withHeaders(request()->header())
    //         ->withToken(session('access_token'))
    //         ->get('http://localhost/trucking-laravel/public/api/service_detail', $detailParams)['data'];

    //     foreach ($service_details as $service_detailsIndex => &$service_detail) {
    //         $service_detail['nominal_header'] = number_format((float) $service_detail['nominal_header'], '2', ',', '.');
    //         $service_detail['uangjalan'] = number_format((float) $service_detail['uangjalan'], '2', ',', '.');
    //     }

    //     return view('reports.service', compact('service_details'));
    // }

    // public function export(Request $request): void
    // {
    //     $params = [
    //         'offset' => $request->dari - 1,
    //         'rows' => $request->sampai - $request->dari + 1,
    //         'withRelations' => true,
    //     ];

    //     $service = $this->get($params)['rows'];

    //     foreach ($service as &$item) {
    //         $item['nominal '] = number_format((float) $item['nominal'], '2', ',', '.');

    //         foreach ($item['absensi_supir_detail'] as &$service_detail) {
    //             $service_detail['trado'] = $service_detail['trado']['nama'] ?? '';
    //             $service_detail['supir'] = $service_detail['supir']['namasupir'] ?? '';
    //             $service_detail['status'] = $service_detail['absen_trado']['keterangan'] ?? '';
    //             $service_detail['uangjalan'] = number_format((float) $service_detail['uangjalan'], '2', ',', '.');
    //         }
    //     }

    //     $spreadsheet = new Spreadsheet();
    //     $sheet = $spreadsheet->getActiveSheet();
    //     $sheet->setCellValue('A1', 'Laporan Service');
    //     $sheet->getStyle("A1")->getFont()->setSize(20);
    //     $sheet->getStyle('A1')->getAlignment()->setHorizontal('center');
    //     $sheet->mergeCells('A1:G1');

    //     $header_start_row = 2;
    //     $detail_table_header_row = 7;
    //     $detail_start_row = $detail_table_header_row + 1;

    //     $alphabets = range('A', 'Z');

    //     $header_columns = [
    //         [
    //             'label' => 'No Bukti',
    //             'index' => 'nobukti',
    //         ],
    //         [
    //             'label' => 'Tanggal',
    //             'index' => 'tgl',
    //         ],
    //         [
    //             'label' => 'No Bukti KGT',
    //             'index' => 'service_nobukti',
    //         ],
    //         [
    //             'label' => 'Nominal',
    //             'index' => 'nominal',
    //         ],
    //         [
    //             'label' => 'Keterangan',
    //             'index' => 'keterangan',
    //         ]
    //     ];

    //     $detail_columns = [
    //         [
    //             'label' => 'No',
    //         ],
    //         [
    //             'label' => 'Trado',
    //             'index' => 'trado',
    //         ],
    //         [
    //             'label' => 'Supir',
    //             'index' => 'supir',
    //         ],
    //         [
    //             'label' => 'Status',
    //             'index' => 'status',
    //         ],
    //         [
    //             'label' => 'Keterangan',
    //             'index' => 'keterangan',
    //         ],
    //         [
    //             'label' => 'Jam',
    //             'index' => 'jam',
    //         ],
    //         [
    //             'label' => 'Uang Jalan',
    //             'index' => 'uangjalan',
    //             'format' => 'currency'
    //         ]
    //     ];

    //     for ($i = 0; $i < count($service); $i++) {
    //         foreach ($header_columns as $header_column) {
    //             $sheet->setCellValue('A' . $header_start_row, $header_column['label']);
    //             $sheet->setCellValue('B' . $header_start_row, ':');
    //             $sheet->setCellValue('C' . $header_start_row++, $absensis[$i][$header_column['index']]);
    //         }

    //         $header_start_row += count($service[$i]['absensi_supir_detail']) + 2;

    //         foreach ($detail_columns as $detail_columns_index => $detail_column) {
    //             $sheet->setCellValue($alphabets[$detail_columns_index] . $detail_table_header_row, $detail_column['label'] ?? $detail_columns_index + 1);
    //         }

    //         $sheet->getStyle("A$detail_table_header_row:G$detail_table_header_row")->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('FF02c4f5');

    //         foreach ($absensis[$i]['absensi_supir_detail'] as $absensi_supir_details_index => $absensi_supir_detail) {
    //             foreach ($detail_columns as $detail_columns_index => $detail_column) {
    //                 $sheet->setCellValue($alphabets[$detail_columns_index] . $detail_start_row, isset($detail_column['index']) ? $absensi_supir_detail[$detail_column['index']] : $absensi_supir_details_index + 1);
    //             }
    //             $sheet->setCellValue("A$detail_start_row", $absensi_supir_details_index + 1);
    //             $sheet->setCellValue("B$detail_start_row", $absensi_supir_detail['trado']);
    //             $sheet->setCellValue("C$detail_start_row", $absensi_supir_detail['supir']);
    //             $sheet->setCellValue("D$detail_start_row", $absensi_supir_detail['status']);
    //             $sheet->setCellValue("E$detail_start_row", $absensi_supir_detail['keterangan']);
    //             $sheet->setCellValue("F$detail_start_row", $absensi_supir_detail['jam']);
    //             $sheet->setCellValue("G$detail_start_row", $absensi_supir_detail['uangjalan']);

    //             $detail_start_row++;
    //         }

    //         $detail_table_header_row += (5 + count($absensis[$i]['absensi_supir_detail']) + 2);
    //         $detail_start_row = $detail_table_header_row + 1;
    //     }

    //     $sheet->getColumnDimension('A')->setAutoSize(true);
    //     $sheet->getColumnDimension('B')->setAutoSize(true);
    //     $sheet->getColumnDimension('C')->setAutoSize(true);
    //     $sheet->getColumnDimension('D')->setAutoSize(true);
    //     $sheet->getColumnDimension('E')->setAutoSize(true);
    //     $sheet->getColumnDimension('F')->setAutoSize(true);
    //     $sheet->getColumnDimension('G')->setAutoSize(true);
    //     $sheet->getColumnDimension('H')->setAutoSize(true);

    //     $styleArray = array(
    //         'borders' => array(
    //             'allBorders' => array(
    //                 'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
    //             ),
    //         ),
    //     );

    //     $writer = new Xlsx($spreadsheet);
    //     $filename = 'laporanAbsensi' . date('dmYHis');

    //     header('Content-Type: application/vnd.ms-excel');
    //     header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
    //     header('Cache-Control: max-age=0');

    //     $writer->save('php://output');
    // }

    private function combo()
    {
        $response = Http::withHeaders($this->httpHeaders)
        ->withToken(session('access_token'))
        ->withOptions(['verify' => false])
            ->get(config('app.api_url') . 'servicein/combo');

        return $response['data'];
    }
}

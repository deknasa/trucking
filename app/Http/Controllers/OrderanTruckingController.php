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

class OrderanTruckingController extends MyController
{
    public $title = 'Orderan Trucking';

    /**
     * @ClassName
     */
    public function index(Request $request)
    {
        $title = $this->title;
        
        $data = [
            'combolangsir' => $this->combo('list','STATUS LANGSIR','STATUS LANGSIR'),
            'comboperalihan' => $this->combo('list','STATUS PERALIHAN','STATUS PERALIHAN'),

        ];

        
        return view('orderantrucking.index', compact('title', 'data'));   
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
            ->get(config('app.api_url') . 'orderantrucking', $params);

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

        return view('orderantrucking.add', compact('title','combo'));
    }


    public function fieldLength(): Response
    {
        $response = Http::withHeaders($this->httpHeaders)
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'orderantrucking/field_length');

        return response($response['data']);
    }


    public function combo($aksi, $grp, $subgrp)
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

    public function export(Request $request):void
    {
        //FETCH HEADER
        $orderanTrucking = Http::withHeaders($request->header())
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'orderantrucking/export?dari=' . $request->dari . '&sampai=' . $request->sampai)['data'];
        $orderanTruck = $orderanTrucking['data'];

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', $orderanTrucking['parameter']['judul']);
        $sheet->setCellValue('A2', $orderanTrucking['parameter']['judulLaporan']);
        $sheet->getStyle("A1")->getFont()->setSize(14);
        $sheet->getStyle("A2")->getFont()->setSize(12);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal('center');
        $sheet->getStyle('A2')->getAlignment()->setHorizontal('center');
        $sheet->mergeCells('A1:O1');
        $sheet->mergeCells('A2:O2');

        $detail_table_header_row = 4;
        $detail_start_row = $detail_table_header_row + 1;

        $alphabets = range('A', 'Z');

        $columns = [
            [
                'label' => 'No',
            ],
            [
                'label' => 'No Bukti',
                'index' => 'nobukti',
            ],
            [
                'label' => 'Tanggal Bukti',
                'index' => 'tglbukti',
            ],
            [
                'label' => 'Container',
                'index' => 'container_id',
            ],
            [
                'label' => 'Agen',
                'index' => 'agen_id',
            ],
            [
                'label' => 'Jenis Order',
                'index' => 'jenisorder_id',
            ],
            [
                'label' => 'Pelanggan',
                'index' => 'pelanggan_id',
            ],
            [
                'label' => 'Tujuan',
                'index' => 'tarif_id',
            ],
            [
                'label' => 'No Job EMKL (1)',
                'index' => 'nojobemkl',
            ],
            [
                'label' => 'No Cont (1)',
                'index' => 'nocont',
            ],
            [
                'label' => 'No Seal (1)',
                'index' => 'noseal',
            ],
            [
                'label' => 'No Job EMKL (2)',
                'index' => 'nojobemkl2',
            ],
            [
                'label' => 'No Cont (2)',
                'index' => 'nocont2',
            ],
            [
                'label' => 'No Seal (2)',
                'index' => 'noseal2',
            ],
            [
                'label' => 'Nominal',
                'index' => 'nominal',
            ],
        ];

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
        $sheet ->getStyle("A$detail_table_header_row:O$detail_table_header_row")->applyFromArray($styleArray);

        $nominal = 0;
        foreach ($orderanTruck as $response_index => $response_detail) {
            foreach ($columns as $detail_columns_index => $detail_column) {
                $sheet->setCellValue($alphabets[$detail_columns_index] . $detail_start_row, isset($detail_column['index']) ? $response_detail[$detail_column['index']] : $response_index + 1);
            }
            $response_detail['nominals'] = number_format((float) $response_detail['nominal'], '2', '.', ',');
        
            $sheet->setCellValue("A$detail_start_row", $response_index + 1);
            $sheet->setCellValue("B$detail_start_row", $response_detail['nobukti']);
            $sheet->setCellValue("C$detail_start_row", $response_detail['tglbukti']);
            $sheet->setCellValue("D$detail_start_row", $response_detail['container_id']);
            $sheet->setCellValue("E$detail_start_row", $response_detail['agen_id']);
            $sheet->setCellValue("F$detail_start_row", $response_detail['jenisorder_id']);
            $sheet->setCellValue("G$detail_start_row", $response_detail['pelanggan_id']);
            $sheet->setCellValue("H$detail_start_row", $response_detail['tarif_id']);
            $sheet->setCellValue("I$detail_start_row", $response_detail['nojobemkl']);
            $sheet->setCellValue("J$detail_start_row", $response_detail['nocont']);
            $sheet->setCellValue("K$detail_start_row", $response_detail['noseal']);
            $sheet->setCellValue("L$detail_start_row", $response_detail['nojobemkl2']);
            $sheet->setCellValue("M$detail_start_row", $response_detail['nocont2']);
            $sheet->setCellValue("N$detail_start_row", $response_detail['noseal2']);
            $sheet->setCellValue("O$detail_start_row", $response_detail['nominals']);

            $sheet ->getStyle("A$detail_start_row:O$detail_start_row")->applyFromArray($styleArray);
            $sheet ->getStyle("O$detail_start_row")->applyFromArray($style_number);

            $nominal += $response_detail['nominal'];
            $detail_start_row++;
        }
        $total_start_row = $detail_start_row;
        //Total
        $sheet->mergeCells('A'.$total_start_row.':N'.$total_start_row);
        $sheet->setCellValue("A$total_start_row", 'Total :')->getStyle('A'.$total_start_row.':N'.$total_start_row)->applyFromArray($style_number)->getFont()->setBold(true);
        $sheet->setCellValue("O$total_start_row", number_format((float) $nominal, '2', '.', ','))->getStyle("O$detail_start_row")->applyFromArray($style_number)->getFont()->setBold(true);

        //set diketahui dibuat
        
        $ttd_start_row = $total_start_row+2;
        $sheet->setCellValue("B$ttd_start_row", 'Disetujui');
        $sheet->setCellValue("C$ttd_start_row", 'Diketahui');
        $sheet->setCellValue("D$ttd_start_row", 'Dibuat');
        $sheet ->getStyle("B$ttd_start_row:D$ttd_start_row")->applyFromArray($styleArray);
        // $sheet->mergeCells("A$ttd_end_row:C$ttd_end_row");
        $sheet->mergeCells("B".($ttd_start_row+1).":B".($ttd_start_row+3));      
        $sheet->mergeCells("C".($ttd_start_row+1).":C".($ttd_start_row+3));      
        $sheet->mergeCells("D".($ttd_start_row+1).":D".($ttd_start_row+3));      
        $sheet ->getStyle("B".($ttd_start_row+1).":B".($ttd_start_row+3))->applyFromArray($styleArray);
        $sheet ->getStyle("C".($ttd_start_row+1).":C".($ttd_start_row+3))->applyFromArray($styleArray);
        $sheet ->getStyle("D".($ttd_start_row+1).":D".($ttd_start_row+3))->applyFromArray($styleArray);

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
        $sheet->getColumnDimension('L')->setAutoSize(true);
        $sheet->getColumnDimension('M')->setAutoSize(true);
        $sheet->getColumnDimension('N')->setAutoSize(true);
        $sheet->getColumnDimension('O')->setAutoSize(true);

        $writer = new Xlsx($spreadsheet);
        $filename = 'Laporan Orderan Trucking' . date('dmYHis');
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }

}

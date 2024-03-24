<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class PencairanGiroPengeluaranHeaderController extends MyController
{
    public $title = 'Pencairan Giro Pengeluaran';

    public function index(Request $request)
    {
        $title = $this->title;
        $data = [
            'comboapproval' => $this->comboApproval('list'),
            'combostatus' => $this->comboList('list', 'STATUS PENCAIRAN GIRO', 'STATUS PENCAIRAN GIRO')
        ];
        array_shift($data['combostatus']);
        
        return view('pencairangiropengeluaran.index', compact('title', 'data'));
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
            'withRelations' => $params['withRelations'] ?? request()->withRelations ?? false,
        ];

        $response = Http::withHeaders(request()->header())
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'jurnalumumheader', $params);

        $data = [
            'total' => $response['attributes']['totalPages'] ?? [],
            'records' => $response['attributes']['totalRows'] ?? [],
            'rows' => $response['data'] ?? [],
            'params' => $response['params'] ?? [],
        ];

        return $data;
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

    private function combo()
    {
        $response = Http::withHeaders($this->httpHeaders)
            ->withToken(session('access_token'))
            ->withOptions(['verify' => false])
            ->get(config('app.api_url') . 'jurnalumumheader/combo');

        return $response['data'];
    }

    public function comboApproval($aksi)
    {

        $status = [
            'status' => $aksi,
            'grp' => 'STATUS APPROVAL',
            'subgrp' => 'STATUS APPROVAL',
        ];

        $response = Http::withHeaders($this->httpHeaders)
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'hutangbayarheader/comboapproval', $status);

        return $response['data'];
    }


    public function report(Request $request)
    {

        $detailParams = [
            'forReport' => true,
            'jurnalumum_id' => $request->id
        ];

        $jurnal_detail = Http::withHeaders(request()->header())
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'jurnalumumdetail', $detailParams);

        $jurnal_details = $jurnal_detail['data'];
        $user = $jurnal_detail['user'];
        return view('reports.jurnalumum', compact('jurnal_details', 'user'));
    }

    public function export(Request $request): void
    {
        //FETCH HEADER
        $jurnals = Http::withHeaders($request->header())
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'jurnalumumheader/' . $request->id)['data'];

        //FETCH DETAIL

        $detailParams = [
            'forExport' => true,
            'jurnalumum_id' => $request->id
        ];

        $responses = Http::withHeaders($request->header())
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'jurnalumumdetail', $detailParams);

        $jurnal_details = $responses['data'];
        $user = $responses['user'];

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'TAS ' . $user['cabang_id']);
        $sheet->getStyle("A1")->getFont()->setSize(20);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal('center');
        $sheet->mergeCells('A1:E1');

        $header_start_row = 2;
        $detail_table_header_row = 5;
        $detail_start_row = $detail_table_header_row + 1;

        $alphabets = range('A', 'Z');

        $header_columns = [
            [
                'label' => 'No Jurnal',
                'index' => 'nobukti',
            ],
            [
                'label' => 'Tanggal',
                'index' => 'tglbukti',
            ],
            [
                'label' => 'Keterangan',
                'index' => 'keterangan',
            ],
        ];

        $detail_columns = [
            [
                'label' => 'No',
            ],
            [
                'label' => 'Coa Debet',
                'index' => 'coadebet',
            ],
            [
                'label' => 'Coa Kredit',
                'index' => 'coakredit',
            ],
            [
                'label' => 'Keterangan',
                'index' => 'keterangan',
            ],
            [
                'label' => 'Nominal',
                'index' => 'nominal',
                'format' => 'currency'
            ]
        ];

        foreach ($header_columns as $header_column) {
            $sheet->setCellValue('A' . $header_start_row, $header_column['label']);
            $sheet->setCellValue('B' . $header_start_row, ':');
            $sheet->setCellValue('C' . $header_start_row++, $jurnals[$header_column['index']]);
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
        $sheet->getStyle("A$detail_table_header_row:E$detail_table_header_row")->applyFromArray($styleArray);

        $total = 0;
        foreach ($jurnal_details as $response_index => $response_detail) {

            foreach ($detail_columns as $detail_columns_index => $detail_column) {
                $sheet->setCellValue($alphabets[$detail_columns_index] . $detail_start_row, isset($detail_column['index']) ? $response_detail[$detail_column['index']] : $response_index + 1);
            }
            $response_detail['nominals'] = number_format((float) $response_detail['nominal'], '2', ',', '.');

            $sheet->setCellValue("A$detail_start_row", $response_index + 1);
            $sheet->setCellValue("B$detail_start_row", $response_detail['coadebet']);
            $sheet->setCellValue("C$detail_start_row", $response_detail['coakredit']);
            $sheet->setCellValue("D$detail_start_row", $response_detail['keterangan']);
            $sheet->setCellValue("E$detail_start_row", $response_detail['nominals']);

            $sheet->getStyle("A$detail_start_row:D$detail_start_row")->applyFromArray($styleArray);
            $sheet->getStyle("E$detail_start_row")->applyFromArray($style_number);
            $total += $response_detail['nominal'];
            $detail_start_row++;
        }

        $total_start_row = $detail_start_row;

        $sheet->mergeCells('A' . $total_start_row . ':D' . $total_start_row);
        $sheet->setCellValue("A$total_start_row", 'Total')->getStyle('A' . $total_start_row . ':D' . $total_start_row)->applyFromArray($style_number)->getFont()->setBold(true);
        $sheet->setCellValue("E$total_start_row", number_format((float) $total, '2', ',', '.'))->getStyle("E$detail_start_row")->applyFromArray($style_number)->getFont()->setBold(true);

        //set diketahui dibuat
        $ttd_start_row = $total_start_row + 2;
        $sheet->setCellValue("A$ttd_start_row", 'Disetujui');
        $sheet->setCellValue("B$ttd_start_row", 'Diketahui');
        $sheet->setCellValue("C$ttd_start_row", 'Dibuat');
        $sheet->getStyle("A$ttd_start_row:C$ttd_start_row")->applyFromArray($styleArray);
        // $sheet->mergeCells("A$ttd_end_row:C$ttd_end_row");
        $sheet->mergeCells("A" . ($ttd_start_row + 1) . ":A" . ($ttd_start_row + 3));
        $sheet->mergeCells("B" . ($ttd_start_row + 1) . ":B" . ($ttd_start_row + 3));
        $sheet->mergeCells("C" . ($ttd_start_row + 1) . ":C" . ($ttd_start_row + 3));
        $sheet->getStyle("A" . ($ttd_start_row + 1) . ":A" . ($ttd_start_row + 3))->applyFromArray($styleArray);
        $sheet->getStyle("B" . ($ttd_start_row + 1) . ":B" . ($ttd_start_row + 3))->applyFromArray($styleArray);
        $sheet->getStyle("C" . ($ttd_start_row + 1) . ":C" . ($ttd_start_row + 3))->applyFromArray($styleArray);


        //set tglcetak
        date_default_timezone_set('Asia/Jakarta');

        $sheet->setCellValue("A" . ($ttd_start_row + 5), 'Dicetak Pada :');
        $sheet->getStyle("A" . ($ttd_start_row + 5))->getFont()->setItalic(true);
        $sheet->setCellValue("B" . ($ttd_start_row + 5), date('d/m/Y H:i:s'));
        $sheet->getStyle("B" . ($ttd_start_row + 5))->getFont()->setItalic(true);
        $sheet->setCellValue("C" . ($ttd_start_row + 5), $user['name']);
        $sheet->getStyle("C" . ($ttd_start_row + 5))->getFont()->setItalic(true);

        $sheet->getColumnDimension('A')->setAutoSize(true);
        $sheet->getColumnDimension('B')->setAutoSize(true);
        $sheet->getColumnDimension('C')->setAutoSize(true);
        $sheet->getColumnDimension('D')->setAutoSize(true);
        $sheet->getColumnDimension('E')->setAutoSize(true);
        $sheet->getColumnDimension('F')->setAutoSize(true);
        $sheet->getColumnDimension('G')->setAutoSize(true);
        $sheet->getColumnDimension('H')->setAutoSize(true);
        $sheet->getColumnDimension('A')->setAutoSize(true);
        $sheet->getColumnDimension('B')->setAutoSize(true);
        $sheet->getColumnDimension('C')->setAutoSize(true);
        $sheet->getColumnDimension('D')->setAutoSize(true);
        $sheet->getColumnDimension('E')->setAutoSize(true);
        $sheet->getColumnDimension('F')->setAutoSize(true);
        $sheet->getColumnDimension('G')->setAutoSize(true);
        $sheet->getColumnDimension('H')->setAutoSize(true);



        $writer = new Xlsx($spreadsheet);
        $filename = 'Jurnal Umum ' . date('dmYHis');
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }
}

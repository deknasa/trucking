<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\View\View;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;


class PenerimaanHeaderController extends MyController
{
    public $title = 'Penerimaan Kas/Bank';

    /**
     * @ClassName
     */
    public function index(Request $request)
    {
        $title = $this->title;
        
        $data = [
            'comboapproval' => $this->comboList('list', 'STATUS APPROVAL', 'STATUS APPROVAL'),
            'combokas' => $this->comboList('list', 'STATUS KAS', 'STATUS KAS'),
            'combocetak' => $this->comboList('list', 'STATUSCETAK', 'STATUSCETAK'),
            'combobank' => $this->comboBank(),
        ];

        return view('penerimaan.index', compact('title', 'data'));
    }

    // /**
    //  * Fungsi get
    //  * @ClassName get
    //  */
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
            ->get(config('app.api_url') . 'penerimaanheader', $params);

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


    public function fieldLength(): Response
    {
        $response = Http::withHeaders($this->httpHeaders)
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'penerimaanheader/field_length');

        return response($response['data']);
    }

    // /**
    //  * Fungsi getNoBukti
    //  * @ClassName getNoBukti
    //  */
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

    public function comboBank()
    {
        $response = Http::withHeaders($this->httpHeaders)
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'bank');

        return $response['data'];
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
    public function report(Request $request)
    {

        $header = Http::withHeaders(request()->header())
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'penerimaanheader/' . $request->id);

        $detailParams = [
            'forReport' => true,
            'penerimaan_id' => $request->id
        ];

        $penerimaan_detail = Http::withHeaders(request()->header())
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get('http://localhost/trucking-laravel/public/api/penerimaandetail', $detailParams);

        $data = $header['data'];
        $penerimaan_details = $penerimaan_detail['data'];
        $user = Auth::user();
        return view('reports.penerimaan', compact('data','penerimaan_details', 'user'));
    }

    public function export(Request $request): void
    {

        //FETCH HEADER
        $penerimaans = Http::withHeaders($request->header())
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'penerimaanheader/' . $request->id)['data'];

        //FETCH DETAIL
        $detailParams = [
            'penerimaan_id' => $request->id,
        ];

        $responses = Http::withHeaders($request->header())
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'penerimaandetail', $detailParams);

        $penerimaan_details = $responses['data'];
        $user = Auth::user();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'PENERIMAAN');
        $sheet->getStyle("A1")->getFont()->setSize(20);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal('center');
        $sheet->mergeCells('A1:G1');

        $header_start_row = 2;
        $detail_table_header_row = 10;
        $detail_start_row = $detail_table_header_row + 1;

        $alphabets = range('A', 'Z');

        $header_columns = [
            [
                'label' => 'No Bukti',
                'index' => 'nobukti',
            ],
            [
                'label' => 'Tanggal',
                'index' => 'tglbukti',
            ],
            [
                'label' => 'Pelanggan',
                'index' => 'pelanggan',
            ],
            [
                'label' => 'Bank',
                'index' => 'bank',
            ],
            [
                'label' => 'Diterima Dari',
                'index' => 'diterimadari',
            ],
            [
                'label' => 'Tgl Lunas',
                'index' => 'tgllunas',
            ],
        ];

        $detail_columns = [
            [
                'label' => 'No',
            ],
            [
                'label' => 'No Warkat',
                'index' => 'nowarkat',
            ],
            [
                'label' => 'Tgl Jatuh Tempo',
                'index' => 'tgljatuhtempo',
            ],
            [
                'label' => 'COA Debet',
                'index' => 'coadebet',
            ],
            [
                'label' => 'COA Kredit',
                'index' => 'coakredit'
            ],
            [
                'label' => 'Bank',
                'index' => 'bank_id'
            ],
            [
                'label' => 'Pelanggan',
                'index' => 'pelanggan_id'
            ],
            [
                'label' => 'Bank Pelanggan',
                'index' => 'bankpelanggan_id'
            ],
            [
                'label' => 'No Bukti Invoice',
                'index' => 'invoice_nobukti'
            ],
            [
                'label' => 'Jenis Biaya',
                'index' => 'jenisbiaya'
            ],
            [
                'label' => 'Keterangan',
                'index' => 'keterangan'
            ],
            [
                'label' => 'Nominal',
                'index' => 'nominal',
                'format' => 'currency'
            ]
        ];

        //LOOPING HEADER        
        foreach ($header_columns as $header_column) {
            $sheet->setCellValue('B' . $header_start_row, $header_column['label']);

            $sheet->setCellValue('C' . $header_start_row++, ': ' . $penerimaans[$header_column['index']]);
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
        $sheet->getStyle("A$detail_table_header_row:L$detail_table_header_row")->applyFromArray($styleArray);

        // LOOPING DETAIL
        $nominal = 0;
        foreach ($penerimaan_details as $response_index => $response_detail) {

            foreach ($detail_columns as $detail_columns_index => $detail_column) {
                $sheet->setCellValue($alphabets[$detail_columns_index] . $detail_start_row, isset($detail_column['index']) ? $response_detail[$detail_column['index']] : $response_index + 1);
            }
            $response_detail['nominals'] = number_format((float) $response_detail['nominal'], '2', ',', '.');

            $sheet->setCellValue("A$detail_start_row", $response_index + 1);
            $sheet->setCellValue("B$detail_start_row", $response_detail['nowarkat']);
            $sheet->setCellValue("C$detail_start_row", $response_detail['tgljatuhtempo']);
            $sheet->setCellValue("D$detail_start_row", $response_detail['coadebet']);
            $sheet->setCellValue("E$detail_start_row", $response_detail['coakredit']);
            $sheet->setCellValue("F$detail_start_row", $response_detail['bank_id']);
            $sheet->setCellValue("G$detail_start_row", $response_detail['pelanggan_id']);
            $sheet->setCellValue("H$detail_start_row", $response_detail['bankpelanggan_id']);
            $sheet->setCellValue("I$detail_start_row", $response_detail['invoice_nobukti']);
            $sheet->setCellValue("J$detail_start_row", $response_detail['jenisbiaya']);
            $sheet->setCellValue("K$detail_start_row", $response_detail['keterangan']);
            $sheet->setCellValue("L$detail_start_row", $response_detail['nominals']);

            $sheet->getStyle("A$detail_start_row:L$detail_start_row")->applyFromArray($styleArray);
            $sheet->getStyle("L$detail_start_row")->applyFromArray($style_number);
            $nominal += $response_detail['nominal'];
            $detail_start_row++;
        }

        $total_start_row = $detail_start_row;
        $sheet->mergeCells('A' . $total_start_row . ':K' . $total_start_row);
        $sheet->setCellValue("A$total_start_row", 'Total :')->getStyle('A' . $total_start_row . ':K' . $total_start_row)->applyFromArray($style_number)->getFont()->setBold(true);
        $sheet->setCellValue("L$total_start_row", number_format((float) $nominal, '2', ',', '.'))->getStyle("L$detail_start_row")->applyFromArray($style_number)->getFont()->setBold(true);

        // set diketahui dibuat
        $ttd_start_row = $total_start_row + 2;
        $sheet->setCellValue("B$ttd_start_row", 'Disetujui');
        $sheet->setCellValue("C$ttd_start_row", 'Diketahui');
        $sheet->setCellValue("D$ttd_start_row", 'Dibuat');
        $sheet->getStyle("B$ttd_start_row:D$ttd_start_row")->applyFromArray($styleArray);

        $sheet->mergeCells("B" . ($ttd_start_row + 1) . ":B" . ($ttd_start_row + 3));
        $sheet->mergeCells("C" . ($ttd_start_row + 1) . ":C" . ($ttd_start_row + 3));
        $sheet->mergeCells("D" . ($ttd_start_row + 1) . ":D" . ($ttd_start_row + 3));
        $sheet->getStyle("B" . ($ttd_start_row + 1) . ":B" . ($ttd_start_row + 3))->applyFromArray($styleArray);
        $sheet->getStyle("C" . ($ttd_start_row + 1) . ":C" . ($ttd_start_row + 3))->applyFromArray($styleArray);
        $sheet->getStyle("D" . ($ttd_start_row + 1) . ":D" . ($ttd_start_row + 3))->applyFromArray($styleArray);

        //set tglcetak
        date_default_timezone_set('Asia/Jakarta');

        $sheet->setCellValue("B" . ($ttd_start_row + 5), 'Dicetak Pada :');
        $sheet->getStyle("B" . ($ttd_start_row + 5))->getFont()->setItalic(true);
        $sheet->setCellValue("C" . ($ttd_start_row + 5), date('d/m/Y H:i:s'));
        $sheet->getStyle("C" . ($ttd_start_row + 5))->getFont()->setItalic(true);
        $sheet->setCellValue("D" . ($ttd_start_row + 5), $user['name']);
        $sheet->getStyle("D" . ($ttd_start_row + 5))->getFont()->setItalic(true);

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



        $writer = new Xlsx($spreadsheet);
        $filename = 'Laporan Penerimaan  ' . date('dmYHis');
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }
}

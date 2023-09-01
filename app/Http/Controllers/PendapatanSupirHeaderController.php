<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class PendapatanSupirHeaderController extends MyController
{
    public $title = 'Pendapatan Supir';

    public function index(Request $request)
    {
        $title = $this->title;
        $data = [
            'comboapproval' => $this->comboList('list', 'STATUS APPROVAL', 'STATUS APPROVAL'),
            'combocetak' => $this->comboList('list', 'STATUSCETAK', 'STATUSCETAK')
        ];
        return view('pendapatansupirheader.index', compact('title', 'data'));
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

    public function combo($aksi)
    {
        $status = [
            'status' => $aksi,
            'grp' => 'STATUSCETAK',
            'subgrp' => 'STATUSCETAK',
        ];
        $response = Http::withHeaders($this->httpHeaders)->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'user/combostatus', $status);
        return $response['data'];
    }

    public function report(Request $request)
    {
        //FETCH HEADER
        $id = $request->id;
        $pendapatan = Http::withHeaders($request->header())
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'pendapatansupirheader/' . $id . '/export')['data'];

        //FETCH DETAIL
        $detailParams = [
            'forReport' => true,
            'pendapatansupir_id' => $request->id
        ];

        $pendapatan_details = Http::withHeaders($request->header())
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'pendapatansupirdetail', $detailParams)['data'];

        $tampilanParams = [
            'grp' => 'PENDAPATAN SUPIR',
            'subgrp' => 'GAJI KENEK',
        ];
        $tampilan = Http::withHeaders($request->header())
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'parameter/getparamfirst', $tampilanParams);
        $tampilan = $tampilan->json();
        $showgajikenek = $tampilan['text'];
        $combo = $this->combo('list');
        $key = array_search('CETAK', array_column($combo, 'parameter'));
        $pendapatan["combo"] =  $combo[$key];
        return view('reports.pendapatansupir', compact('pendapatan', 'pendapatan_details', 'showgajikenek'));
    }

    public function export(Request $request): void
    {
        //FETCH HEADER
        $id = $request->id;
        $pendapatans = Http::withHeaders($request->header())
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'pendapatansupirheader/' . $id . '/export')['data'];

        //FETCH DETAIL
        $detailParams = [
            'forReport' => true,
            'pendapatansupir_id' => $request->id
        ];

        $responses = Http::withHeaders($request->header())
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'pendapatansupirdetail', $detailParams);

        $tampilanParams = [
            'grp' => 'PENDAPATAN SUPIR',
            'subgrp' => 'GAJI KENEK',
        ];

        $tampilan = Http::withHeaders($request->header())
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'parameter/getparamfirst', $tampilanParams);
        $tampilan = $tampilan->json();
        $showgajikenek = $tampilan['text'];

        $pendapatan_details = $responses['data'];

        $tglBukti = $pendapatans["tglbukti"];
        $timeStamp = strtotime($tglBukti);
        $dateTglBukti = date('d-m-Y', $timeStamp);
        $pendapatans['tglbukti'] = $dateTglBukti;

        $tglDari = $pendapatans["tgldari"];
        $timeStampDari = strtotime($tglDari);
        $datetglDari = date('d-m-Y', $timeStampDari);
        $pendapatans['tgldari'] = $datetglDari;

        $tglSampai = $pendapatans["tglsampai"];
        $timeStampSampai = strtotime($tglSampai);
        $datetglSampai = date('d-m-Y', $timeStampSampai);
        $pendapatans['tglsampai'] = $datetglSampai;

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', $pendapatans['judul']);
        $sheet->setCellValue('A2', $pendapatans['judulLaporan']);
        $sheet->getStyle("A1")->getFont()->setSize(12);
        $sheet->getStyle("A2")->getFont()->setSize(12);
        $sheet->getStyle("A1")->getFont()->setBold(true);
        $sheet->getStyle("A2")->getFont()->setBold(true);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal('center');
        $sheet->getStyle('A2')->getAlignment()->setHorizontal('center');
        $sheet->mergeCells('A1:D1');
        $sheet->mergeCells('A2:D2');

        $header_start_row = 4;
        $header_right_start_row = 4;
        $detail_table_header_row = 8;
        $detail_start_row = $detail_table_header_row + 1;
        $dataRow = $detail_table_header_row + 2;
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
                'label' => 'Bank',
                'index' => 'bank_id',
            ]
        ];
        $header_right_columns = [
            [
                'label' => 'Tanggal Dari',
                'index' => 'tgldari',
            ],
            [
                'label' => 'Tanggal Sampai',
                'index' => 'tglsampai',
            ],
            [
                'label' => 'Supir',
                'index' => 'supir_id',
            ],
        ];


        if ($showgajikenek == 'YA') {
            $detail_columns = [
                [
                    'label' => 'NO',
                ],
                [
                    'label' => 'TRADO',
                    'index' => 'kodetrado',
                ],
                [
                    'label' => 'NOMINAL',
                    'index' => 'total',
                    'format' => 'currency'
                ], [
                    'label' => 'TANDA TANGAN',
                ],
            ];
        } else {
            $detail_columns = [
                [
                    'label' => 'NO',
                ],
                [
                    'label' => 'NO BUKTI TRIP',
                    'index' => 'nobuktitrip',
                ],
                [
                    'label' => 'TGL TRIP',
                    'index' => 'tgltrip',
                ],
                [
                    'label' => 'NO BUKTI RINCIAN',
                    'index' => 'nobuktirincian',
                ],
                [
                    'label' => 'DARI',
                    'index' => 'dari',
                ],
                [
                    'label' => 'SAMPAI',
                    'index' => 'sampai',
                ],
                [
                    'label' => 'NOMINAL',
                    'index' => 'nominal',
                    'format' => 'currency'
                ],
            ];
        }
        foreach ($header_columns as $header_column) {
            $sheet->setCellValue('B' . $header_start_row, $header_column['label']);
            $sheet->setCellValue('C' . $header_start_row++, ': ' . $pendapatans[$header_column['index']]);
        }
        foreach ($header_right_columns as $header_right_column) {
            $sheet->setCellValue('D' . $header_right_start_row, $header_right_column['label']);
            $sheet->setCellValue('E' . $header_right_start_row++, ': ' . $pendapatans[$header_right_column['index']]);
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
        if ($showgajikenek == 'YA') {

            $sheet->getStyle("A$detail_table_header_row:D" . "$detail_table_header_row")->applyFromArray($styleArray);

            foreach ($pendapatan_details as $response_index => $response_detail) {

                foreach ($detail_columns as $detail_columns_index => $detail_column) {
                    $sheet->setCellValue($alphabets[$detail_columns_index] . $detail_start_row, isset($detail_column['index']) ? $response_detail[$detail_column['index']] : $response_index + 1);
                    $sheet->getStyle("A$detail_table_header_row:D$detail_table_header_row")->getFont()->setBold(true);
                    $sheet->getStyle("A$detail_table_header_row:D$detail_table_header_row")->getAlignment()->setHorizontal('center');
                }

                $sheet->setCellValue("A$detail_start_row", $response_index + 1);
                $sheet->setCellValue("B$detail_start_row", $response_detail['kodetrado']);
                $sheet->setCellValue("C$detail_start_row", $response_detail['total']);
                $sheet->setCellValue("D$detail_start_row", $response_index + 1);

                if (($response_index + 1) % 2 == 0) {
                    $sheet->getStyle("D$detail_start_row")->getAlignment()->setHorizontal('center');
                    $sheet->getStyle("D$detail_start_row")->getAlignment()->setVertical('center');
                } else {
                    $sheet->getStyle("D$detail_start_row")->getAlignment()->setHorizontal('left');
                    $sheet->getStyle("D$detail_start_row")->getAlignment()->setVertical('center');
                }

                $sheet->getStyle("A$detail_start_row:D$detail_start_row")->applyFromArray($styleArray);
                $sheet->getStyle("C$detail_start_row")->applyFromArray($style_number)->getNumberFormat()->setFormatCode("#,##0.00");
                $spreadsheet->getActiveSheet()->getRowDimension($detail_start_row)->setRowHeight(28);
                $dataRow++;
                $detail_start_row++;
            }

            $total_start_row = $detail_start_row;

            $sheet->mergeCells('A' . $total_start_row . ':B' . $total_start_row);
            $sheet->setCellValue("A$total_start_row", 'Total')->getStyle('A' . $total_start_row . ':B' . $total_start_row)->applyFromArray($styleArray)->getFont()->setBold(true);
            $sheet->setCellValue("C$detail_start_row",  "=SUM(C8:C" . ($dataRow - 1) . ")")->getStyle("C$detail_start_row")->applyFromArray($style_number)->getFont()->setBold(true);

            $sheet->getStyle("C$detail_start_row")->getNumberFormat()->setFormatCode("#,##0.00");
            
            $sheet->getColumnDimension('A')->setAutoSize(true);
            $sheet->getColumnDimension('B')->setAutoSize(true);
            $sheet->getColumnDimension('C')->setAutoSize(true);
            $sheet->getColumnDimension('D')->setWidth(30);
        } else {

            $sheet->getStyle("A$detail_table_header_row:G" . "$detail_table_header_row")->applyFromArray($styleArray);

            foreach ($pendapatan_details as $response_index => $response_detail) {

                foreach ($detail_columns as $detail_columns_index => $detail_column) {
                    $sheet->setCellValue($alphabets[$detail_columns_index] . $detail_start_row, isset($detail_column['index']) ? $response_detail[$detail_column['index']] : $response_index + 1);
                    $sheet->getStyle("A$detail_table_header_row:G$detail_table_header_row")->getFont()->setBold(true);
                    $sheet->getStyle("A$detail_table_header_row:G$detail_table_header_row")->getAlignment()->setHorizontal('center');
                }
                $response_detail['nominals'] = number_format((float) $response_detail['nominal'], '2', '.', ',');

                $sheet->setCellValue("A$detail_start_row", $response_index + 1);
                $sheet->setCellValue("B$detail_start_row", $response_detail['nobuktitrip']);
                $sheet->setCellValue("C$detail_start_row", date('d-m-Y', strtotime($response_detail['tgltrip'])));
                $sheet->setCellValue("D$detail_start_row", $response_detail['nobuktirincian']);
                $sheet->setCellValue("E$detail_start_row", $response_detail['dari']);
                $sheet->setCellValue("F$detail_start_row", $response_detail['sampai']);
                $sheet->setCellValue("G$detail_start_row", $response_detail['nominal']);

                $sheet->getStyle("A$detail_start_row:G$detail_start_row")->applyFromArray($styleArray);
                $sheet->getStyle("G$detail_start_row")->applyFromArray($style_number)->getNumberFormat()->setFormatCode("#,##0.00");

                // $total += $response_detail['nominal'];
                $dataRow++;
                $detail_start_row++;
            }

            $total_start_row = $detail_start_row;

            $sheet->mergeCells('A' . $total_start_row . ':F' . $total_start_row);
            $sheet->setCellValue("A$total_start_row", 'Total')->getStyle('A' . $total_start_row . ':F' . $total_start_row)->applyFromArray($styleArray)->getFont()->setBold(true);
            $sheet->setCellValue("G$detail_start_row",  "=SUM(G8:G" . ($dataRow - 1) . ")")->getStyle("G$detail_start_row")->applyFromArray($style_number)->getFont()->setBold(true);

            $sheet->getStyle("G$detail_start_row")->getNumberFormat()->setFormatCode("#,##0.00");

            $sheet->getColumnDimension('A')->setAutoSize(true);
            $sheet->getColumnDimension('B')->setAutoSize(true);
            $sheet->getColumnDimension('C')->setAutoSize(true);
            $sheet->getColumnDimension('D')->setAutoSize(true);
            $sheet->getColumnDimension('E')->setAutoSize(true);
            $sheet->getColumnDimension('F')->setAutoSize(true);
            $sheet->getColumnDimension('G')->setAutoSize(true);
            $sheet->getColumnDimension('H')->setAutoSize(true);
        }

        $writer = new Xlsx($spreadsheet);
        $filename = 'Laporan Pendapatan Supir' . date('dmYHis');
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }
}

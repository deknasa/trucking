<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class UpahSupirTangkiController extends MyController
{
    public $title = 'Upah Supir Tangki';


    public function index(Request $request)
    {
        $title = $this->title;
        $data = [
            'combo' => $this->comboStatusAktif('list'),
            'listbtn' => $this->getListBtn()
        ];

        return view('upahsupirtangki.index', compact('title', 'data'));
    }

    public function comboStatusAktif($aksi)
    {

        $status = [
            'status' => $aksi,
            'grp' => 'STATUS AKTIF',
            'subgrp' => 'STATUS AKTIF',
        ];

        $response = Http::withHeaders($this->httpHeaders)->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'user/combostatus', $status);

        return $response['data'];
    }


    public function report(Request $request)
    {

        $detailParams = [
            'forReport' => true,
            'upahsupir_id' => $request->id
        ];

        $upahsupir_detail = Http::withHeaders($request->header())
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'upahsupirtangki/export?dari=' . $request->dari . '&sampai=' . $request->sampai);

        $upahsupir_details = $upahsupir_detail['data'];
        $judul = $upahsupir_detail['judul'];

        return view('reports.upahsupirtangki', compact('upahsupir_details', 'judul'));
    }

    public function export(Request $request): void
    {
        $detailParams = [
            'forReport' => true,
        ];

        $upahsupir_detail = Http::withHeaders($request->header())
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'upahsupirtangki/export?dari=' . $request->dari . '&sampai=' . $request->sampai);

        $data = $upahsupir_detail['data'];

        $judul = $upahsupir_detail['judul'];
        if (count($data) == 0) {
            throw new \Exception('TIDAK ADA DATA');
        }

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', $judul['text']);
        $sheet->getStyle("A1")->getFont()->setSize(12)->setBold(true);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal('center');
        $sheet->mergeCells('A1:F1');
        $sheet->setCellValue('A2', 'Laporan Upah Supir Tangki');
        $sheet->getStyle("A2")->getFont()->setSize(12)->setBold(true);
        $sheet->getStyle('A2')->getAlignment()->setHorizontal('center');
        $sheet->mergeCells('A2:F2');
        $detail_table_header_row = 3;
        $detail_start_row = $detail_table_header_row + 1;

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

        $alphabets = range('A', 'Z');

        $detail_columns = [
            [
                'label' => 'No',
            ],
            [
                'label' => 'Trip Tangki',
                'index' => 'triptangki',
            ],
            [
                'label' => 'Nominal',
                'index' => 'nominalsupir',
            ],
        ];

        if (is_array($data)) {

            foreach ($data as $row) {
                $id_header = $row['id_header'];
                $groupedData[$id_header][] = $row;
            }
        }
        if (is_array($data) || is_iterable($data)) {
            foreach ($groupedData as $id_header => $group) {
                $sheet->setCellValue("A$detail_start_row", 'Dari : ' . $group[0]['dari']);
                $sheet->mergeCells("A$detail_start_row:B$detail_start_row");
                $sheet->setCellValue("C$detail_start_row", 'Jarak : ' . $group[0]['jarak']);
                $detail_start_row++;
                $sheet->setCellValue("A" . $detail_start_row, 'Tujuan : ' . $group[0]['sampai']);
                $sheet->setCellValue("C" . $detail_start_row, 'Tgl Mulai Berlaku : ' . date('d-m-Y', strtotime($group[0]['tglmulaiberlaku'])));
                $sheet->mergeCells("A$detail_start_row:B$detail_start_row");

                $detail_start_row++;
                $sheet->setCellValue("A" . $detail_start_row, 'Penyesuaian : ' . $group[0]['penyesuaian']);
                $sheet->mergeCells("A$detail_start_row:B$detail_start_row");

                $detail_start_row++;


                foreach ($detail_columns as $data_columns_index => $data_column) {

                    $sheet->setCellValue($alphabets[$data_columns_index] . $detail_start_row, $data_column['label'] ?? $data_columns_index + 1);
                    $lastColumn = $alphabets[$data_columns_index];
                    $sheet->getStyle("A$detail_start_row:$lastColumn$detail_start_row")->applyFromArray($styleArray)->getFont()->setBold(true);
                }

                $detail_start_row++;
                $no = 1;
                foreach ($group as $response_detail) {
                    $sheet->setCellValue("A$detail_start_row", $no++);
                    $sheet->setCellValue("B$detail_start_row", $response_detail['triptangki']);
                    $sheet->setCellValue("C$detail_start_row", $response_detail['nominalsupir']);

                    $sheet->getStyle("A$detail_start_row:C$detail_start_row")->applyFromArray($styleArray);

                    $sheet->getStyle("C$detail_start_row")->applyFromArray($style_number)->getNumberFormat()->setFormatCode("#,##0.00_);(#,##0.00)");
                    $detail_start_row++;
                }

                $detail_start_row++;
            }
        }

        $sheet->getColumnDimension('A')->setWidth(5);
        $sheet->getColumnDimension('B')->setWidth(26);
        $sheet->getColumnDimension('C')->setAutoSize(true);
        $writer = new Xlsx($spreadsheet);
        $filename = 'LAPORAN UPAH SUPIR TANGKI' . date('dmYHis');
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }
}

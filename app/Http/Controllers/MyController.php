<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class MyController extends Controller
{
    public function __construct() {
        $domain =request()->getScheme().'://'.request()->getHttpHost().env('API_PATH_URL');
        $domainApp =request()->getScheme().'://'.request()->getHttpHost().env('APP_PATH');
        $domainTNL =request()->getScheme().'://'.request()->getHttpHost().env('TRUCKING_API_PATH_TNL');
        // $domainEmkl =request()->getScheme().'://'.request()->getHttpHost().env('EMKL_API_PATH_URL');
        config()->set('app.api_url',$domain);
        config()->set('app.url',$domainApp);
        config()->set('app.trucking_api_tnl',$domainTNL);
        // config()->set('app.emkl_api_url',$domainEmkl);
    }

    public function getListBtn()
    {
        $path = getenv('BTN_FILE');
        $json_data = file_get_contents($path);

        $data = json_decode($json_data);
        return $data;
    }
    public $httpHeaders = [
        'Accept' => 'application/json',
        'Content-Type' => 'application/json',
    ];

    public function getParameter(string $group, string $subgroup): array
    {
        $params = [
            'grp' => $group,
            'subgrp' => $subgroup
        ];

        $response = Http::withHeaders($this->httpHeaders)
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'parameter/combo', $params);

        return $response['data'] ?? [];
    }

    public function getJenisEmkl(): array
    {

        $response = Http::withHeaders($this->httpHeaders)
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'jenisemkl/combo');

        return $response['data'] ?? [];
    }

    /* Compatible for single table */
    public function toExcel(string $title, array $data, array $columns)
    {
        $tableHeaderRow = 2;
        $startRow = $tableHeaderRow + 1;
        $alphabets = range('A', 'Z');

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'Laporan ' . $title);
        $sheet->getStyle("A1")->getFont()->setSize(20);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal('center');
        $sheet->mergeCells('A1:' . $alphabets[count($columns) - 1] . '1');

        /* Set the table header */
        foreach ($columns as $columnsIndex => $column) {
            $sheet->setCellValue($alphabets[$columnsIndex] . $tableHeaderRow, $column['label'] ?? $columnsIndex + 1);
        }

        /* Set the table header style */
        $sheet
            ->getStyle("A$tableHeaderRow:" . $alphabets[count($columns) - 1] . "$tableHeaderRow")
            ->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()
            ->setARGB('FF02c4f5');

        /* Write each cell */
        foreach ($data as $dataIndex => $row) {
            foreach ($columns as $columnsIndex => $column) {
                $sheet->setCellValue($alphabets[$columnsIndex] . $startRow, isset($column['index']) ? $row[$column['index']] : $dataIndex + 1);
            }

            $startRow++;
        }

        /* Write to excel, then download the file */
        $writer = new Xlsx($spreadsheet);
        $filename = 'laporanAbsensi' . date('dmYHis');

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }
}

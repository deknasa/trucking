<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\View\View;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class AkunPusatController extends MyController
{
    public $title = 'Kode Perkiraan Cabang';
    public $httpHeaders = [
        'Accept' => 'application/json',
        'Content-Type' => 'application/json'
    ];

    /**
     * @ClassName
     */
    public function index(Request $request)
    {
        $title = $this->title;

        $data = [
            'comboaktif' => $this->comboList('list', 'STATUS AKTIF', 'STATUS AKTIF'),
            'comboparent' => $this->comboList('list', 'STATUS PARENT', 'STATUS PARENT'),
            'comboneraca' => $this->comboList('list', 'STATUS NERACA', 'STATUS NERACA'),
            'combolabarugi' => $this->comboList('list', 'STATUS LABA RUGI', 'STATUS LABA RUGI'),
            'listbtn' => $this->getListBtn()
        ];

        return view('akunpusat.index', compact('title', 'data'));
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

    public function create()
    {
        $title = $this->title;

        $combo = [
            'statuscoa' => $this->getParameter('status kode perkiraan', 'status kode perkiraan'),
            'statusaccountpayable' => $this->getParameter('STATUS ACCOUNT PAYABLE', 'STATUS ACCOUNT PAYABLE'),
            'statusneraca' => $this->getParameter('STATUS NERACA', 'STATUS NERACA'),
            'statuslabarugi' => $this->getParameter('STATUS LABA RUGI', 'STATUS LABA RUGI'),
            'statusaktif' => $this->getParameter('STATUS AKTIF', 'STATUS AKTIF')
        ];

        return view('akunpusat.add', compact('title', 'combo'));
    }

    public function edit($id)
    {
        $title = $this->title;

        $combo = [
            'statuscoa' => $this->getParameter('status kode perkiraan', 'status kode perkiraan'),
            'statusaccountpayable' => $this->getParameter('STATUS ACCOUNT PAYABLE', 'STATUS ACCOUNT PAYABLE'),
            'statusneraca' => $this->getParameter('STATUS NERACA', 'STATUS NERACA'),
            'statuslabarugi' => $this->getParameter('STATUS LABA RUGI', 'STATUS LABA RUGI'),
            'statusaktif' => $this->getParameter('STATUS AKTIF', 'STATUS AKTIF')
        ];

        $response = Http::withHeaders($this->httpHeaders)
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . "akunpusat/$id");

        $akunPusat = $response['data'];

        return view('akunpusat.edit', compact('title', 'akunPusat', 'combo'));
    }

    public function delete($id)
    {
        try {
            $title = $this->title;

            $combo = [
                'statuscoa' => $this->getParameter('STATUS COA', 'STATUS COA'),
                'statusaccountpayable' => $this->getParameter('STATUS ACCOUNT PAYABLE', 'STATUS ACCOUNT PAYABLE'),
                'statusneraca' => $this->getParameter('STATUS NERACA', 'STATUS NERACA'),
                'statuslabarugi' => $this->getParameter('STATUS LABA RUGI', 'STATUS LABA RUGI'),
                'statusaktif' => $this->getParameter('STATUS AKTIF', 'STATUS AKTIF')
            ];

            $response = Http::withHeaders($this->httpHeaders)
                ->withOptions(['verify' => false])
                ->withToken(session('access_token'))
                ->get(config('app.api_url') . "akunpusat/$id");

            $akunPusat = $response['data'];

            return view('akunpusat.delete', compact('title', 'akunPusat', 'combo'));
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /**
     * @ClassName
     */
    public function report(Request $request)
    {
        $response = Http::withHeaders($this->httpHeaders)
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'akunpusat', $request->all());

        $akunpusats = $response['data'];

        $i = 0;
        foreach ($akunpusats as $index => $params) {

            $statusaktif = $params['statusaktif'];
            $statusParent = $params['statusparent'];
            $statusNeraca = $params['statusneraca'];
            $statusLabaRugi = $params['statuslabarugi'];

            $result = json_decode($statusaktif, true);
            $resultParent = json_decode($statusParent, true);
            $resultNeraca = json_decode($statusNeraca, true);
            $resultLabaRugi = json_decode($statusLabaRugi, true);

            $format = $result['MEMO'];
            $statusParent = $resultParent['MEMO'];
            $statusNeraca = $resultNeraca['MEMO'];
            $statusLabaRugi = $resultLabaRugi['MEMO'];


            $akunpusats[$i]['statusaktif'] = $format;
            $akunpusats[$i]['statusparent'] = $statusParent;
            $akunpusats[$i]['statusneraca'] = $statusNeraca;
            $akunpusats[$i]['statuslabarugi'] = $statusLabaRugi;


            $i++;
        }

        return view('reports.akunpusat', compact('akunpusats'));
    }

    /**
     * @ClassName
     */
    // public function export(Request $request): void
    // {
    //     $params = [
    //         'offset' => $request->dari - 1,
    //         'rows' => $request->sampai - $request->dari + 1,
    //     ];

    //     $akunPusats = $this->get($params);

    //     $spreadsheet = new Spreadsheet();
    //     $sheet = $spreadsheet->getActiveSheet();
    //     $sheet->setCellValue('A1', 'Laporan Akun Pusat');
    //     $sheet->getStyle("A1")->getFont()->setSize(20);
    //     $sheet->getStyle('A1')->getAlignment()->setHorizontal('center');
    //     $sheet->mergeCells('A1:E1');

    //     $sheet->setCellValue('A2', 'No');
    //     $sheet->setCellValue('B2', 'ID');
    //     $sheet->setCellValue('C2', 'Group');
    //     $sheet->setCellValue('D2', 'Sub Group');
    //     $sheet->setCellValue('E2', 'Nama Akun Pusat');
    //     $sheet->setCellValue('F2', 'Memo');
    //     $sheet->setCellValue('G2', 'ModifiedBy');
    //     $sheet->setCellValue('H2', 'ModifiedOn');

    //     $sheet->getColumnDimension('C')->setAutoSize(true);
    //     $sheet->getColumnDimension('D')->setAutoSize(true);
    //     $sheet->getColumnDimension('E')->setAutoSize(true);
    //     $sheet->getColumnDimension('F')->setAutoSize(true);
    //     $sheet->getColumnDimension('G')->setAutoSize(true);
    //     $sheet->getColumnDimension('H')->setAutoSize(true);

    //     $no = 1;
    //     $x = 3;
    //     foreach ($akunPusats['rows'] as $row) {
    //         $sheet->setCellValue('A' . $x, $no++);
    //         $sheet->setCellValue('B' . $x, $row['id']);
    //         $sheet->setCellValue('C' . $x, $row['grp']);
    //         $sheet->setCellValue('D' . $x, $row['subgrp']);
    //         $sheet->setCellValue('E' . $x, $row['text']);
    //         $sheet->setCellValue('F' . $x, $row['memo']);
    //         $sheet->setCellValue('G' . $x, $row['modifiedby']);
    //         $sheet->setCellValue('H' . $x,  date("d-m-Y H:i:s", strtotime($row['updated_at'])));
    //         $lastCell = 'H' . $x;
    //         $x++;
    //     }

    //     $sheet->setCellValue('E' . $x, "=ROWS(E3:" . $lastCell . ")");

    //     $styleArray = array(
    //         'borders' => array(
    //             'allBorders' => array(
    //                 'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
    //             ),
    //         ),
    //     );

    //     $sheet->getStyle('A2:H2')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('FF02c4f5');
    //     $sheet->getStyle('A2:' . $lastCell)->applyFromArray($styleArray);

    //     $writer = new Xlsx($spreadsheet);
    //     $filename = 'laporanAkun Pusat' . date('dmYHis');

    //     header('Content-Type: application/vnd.ms-excel');
    //     header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
    //     header('Cache-Control: max-age=0');

    //     $writer->save('php://output');
    // }
    
}

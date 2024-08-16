<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;


class LaporanBanGudangSementaraController extends MyController
{
    public $title = 'Laporan Ban di Gudang Sementara';

    public function index(Request $request)
    {
        $title = $this->title;
        $data = [
            'pagename' => 'Menu Utama Laporan Ban di Gudang Sementara',
        ];

        return view('laporanbangudangsementara.index', compact('title'));
    }

    public function report(Request $request)
    {
        $detailParams = [
            'sampai' => $request->sampai,
            'dari' => $request->dari,
            'type' => $request->type,
        ];

        $header = Http::withHeaders(request()->header())
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'laporanbangudangsementara/report', $detailParams);

        $data = $header['data'];
        $dataCabang['namacabang'] = $header['namacabang'];
        $user = Auth::user();
        return view('reports.laporanbangudangsementara', compact('data','dataCabang', 'user', 'detailParams'));
    }

    public function export(Request $request): void
    {
        if ($request->posisiakhirtrado != null) {

            $parameter = $request->posisiakhirtrado;
        } else {
            $parameter = $request->posisiakhirgandengan;
        }

        $detailParams = [
            'dari' => $request->dari,
            'sampai' => $request->sampai,
            'type' => $request->type,
        ];

        $header = Http::withHeaders(request()->header())
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'laporanbangudangsementara/export', $detailParams);

        $data = $header['data'];
        if(count($data) == 0){
            throw new \Exception('TIDAK ADA DATA');
        }
        $namacabang = $header['namacabang'];
        $disetujui = $data[0]['disetujui'] ?? '';
        $diperiksa = $data[0]['diperiksa'] ?? '';

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', $data[0]['judul'] ?? '');
        $sheet->setCellValue('A2', $namacabang ?? '');
        $sheet->setCellValue('A3', $data[0]['judulLaporan'] ?? '');
        $sheet->getStyle("A1")->getFont()->setSize(16)->setBold(true);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal('center');
        $sheet->getStyle("A2")->getFont()->setSize(16)->setBold(true);
        $sheet->getStyle('A2')->getAlignment()->setHorizontal('center');
        $sheet->getStyle("A3")->getFont()->setBold(true);
        $sheet->mergeCells('A1:F1');
        $sheet->mergeCells('A2:F2');

        $detail_table_header_row = 5;
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

        $header_columns = [
            [
                'label' => 'No',
            ],
            [
                'label' => 'Nama Stok',
                'index' => 'namabarang',
            ],
            [
                'label' => 'Gudang',
                'index' => 'gudang',
            ],
            [
                'label' => 'No Bukti',
                'index' => 'nobukti',
            ],
            [
                'label' => 'Tanggal',
                'index' => 'tanggal',
            ],
            [
                'label' => 'Jlh Hari',
                'index' => 'jlhhari',
            ],
        ];

        foreach ($header_columns as $detail_columns_index => $detail_column) {
            $sheet->setCellValue($alphabets[$detail_columns_index] . $detail_table_header_row, $detail_column['label'] ?? $detail_columns_index + 1);
        }
        $sheet->getStyle("A$detail_table_header_row:F$detail_table_header_row")->applyFromArray($styleArray)->getFont()->setBold(true);

        // LOOPING DETAIL
        $totalDebet = 0;
        $totalKredit = 0;
        $totalSaldo = 0;
        $dataRow = $detail_table_header_row + 1;
        $no=1;
        foreach ($data as $response_index => $response_detail) {

            foreach ($header_columns as $detail_columns_index => $detail_column) {
                $sheet->setCellValue($alphabets[$detail_columns_index] . $detail_start_row, isset($detail_column['index']) ? $response_detail[$detail_column['index']] : $response_index + 1);
            }
            $tanggal = ($response_detail['tanggal'] != null) ? Date::PHPToExcel(date('Y-m-d',strtotime($response_detail['tanggal']))) : ''; 
           

            $sheet->setCellValue("A$detail_start_row", $no++);
            $sheet->setCellValue("B$detail_start_row", $response_detail['namabarang']);
            $sheet->setCellValue("C$detail_start_row", $response_detail['gudang']);
            $sheet->setCellValue("D$detail_start_row", $response_detail['nobukti']);
            $sheet->setCellValue("E$detail_start_row", $tanggal);
            $sheet->setCellValue("F$detail_start_row", $response_detail['jlhhari']);


            $sheet->getStyle("A$detail_start_row:F$detail_start_row")->applyFromArray($styleArray);
            $sheet->getStyle("E$detail_start_row")->getNumberFormat()->setFormatCode('dd-mm-yyyy');

            $detail_start_row++;
        }



        // $ttd_start_row = $detail_start_row + 2;
        // $sheet->setCellValue("A$ttd_start_row", 'Disetujui Oleh,');
        // $sheet->setCellValue("C$ttd_start_row", 'Diperiksa Oleh,');
        // $sheet->setCellValue("F$ttd_start_row", 'Disusun Oleh,');

        // $sheet->setCellValue("A" . ($ttd_start_row + 3), '( ' . $disetujui . ' )');
        // $sheet->setCellValue("C" . ($ttd_start_row + 3), '( ' . $diperiksa . ' )');
        // $sheet->setCellValue("F" . ($ttd_start_row + 3), '(                )');

        $sheet->getColumnDimension('A')->setWidth(4);
        $sheet->getColumnDimension('B')->setAutoSize(true);
        $sheet->getColumnDimension('C')->setAutoSize(true);
        $sheet->getColumnDimension('D')->setAutoSize(true);
        $sheet->getColumnDimension('E')->setAutoSize(true);
        $sheet->getColumnDimension('F')->setAutoSize(true);



        $writer = new Xlsx($spreadsheet);
        $filename = 'LAPORAN BAN GUDANG SEMENTARA ' . date('dmYHis');
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }
}

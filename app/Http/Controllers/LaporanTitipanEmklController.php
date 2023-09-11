<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Menu;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class LaporanTitipanEmklController extends MyController
{
    public $title = 'Laporan Titipan EMKL';

    public function index(Request $request)
    {
        $title = $this->title;
        $combojenisorder = $this->combojenisorder();

        $data = [
            'pagename' => 'Menu Utama Laporan Titipan EMKL',
        ];

        return view('laporantitipanemkl.index', compact('title','combojenisorder'));
    }

    public function combojenisorder()
    {
        $response = Http::withHeaders($this->httpHeaders)
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'jenisorder',["limit"=>20]);

        return $response['data'];
    }

    public function report(Request $request)
    {
        $detailParams = [
            'tgldari' => $request->tgldari,
            'tglsampai' => $request->tglsampai,
            'jenisorder' => $request->jenisorder,
        ];

        $header = Http::withHeaders(request()->header())
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'laporantitipanemkl/report', $detailParams);

        $data = $header['data'];
        $user = Auth::user();
        return view('reports.laporantitipanemkl', compact('data', 'user', 'detailParams'));
    }

    public function export(Request $request): void
    {
        $detailParams = [
            'tgldari' => $request->tgldari,
            'tglsampai' => $request->tglsampai,
            'jenisorder' => $request->jenisorder,
        ];

        $responses = Http::withHeaders($request->header())
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'laporantitipanemkl/export', $detailParams);

        $pengeluaran = $responses['data'];

        $disetujui = $pengeluaran[0]['disetujui'] ?? '';
        $diperiksa = $pengeluaran[0]['diperiksa'] ?? '';
        $user = Auth::user();
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $jenisorder = $pengeluaran[0]['jenisorder'] ?? '';
        $sheet->setCellValue('A1', $pengeluaran[0]['judul']??'');
        $sheet->setCellValue('A2', $pengeluaran[0]['judulLaporan']??'');
        $sheet->setCellValue('A3', 'Periode: ' . $request->tgldari .'s/d'.$request->tgldari );
        $sheet->setCellValue('A4', 'Jenis Order: ' . $jenisorder);

        $sheet->getStyle("A1")->getFont()->setSize(16)->setBold(true);

        $sheet->getStyle('A1')->getAlignment()->setHorizontal('center');
        $sheet->getStyle('A2')->getAlignment()->setHorizontal('left');
        $sheet->mergeCells('A1:E1');

        $header_start_row = 6;
        $detail_start_row = 7;

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

            'borders' => array(
                'allBorders' => array(
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ),
            ),
        ];

        $alphabets = range('A', 'Z');



        $header_columns = [
            [
                "index"=>"tglbukti",
                "label"=>"tglbukti",
            ],
            [
                "index"=>"day",
                "label"=>"day",
            ],
            [
                "index"=>"tujuan",
                "label"=>"tujuan",
            ],
            [
                "index"=>"shipper",
                "label"=>"shipper",
            ],
            [
                "index"=>"container",
                "label"=>"container",
            ],
            [
                "index"=>"nosp",
                "label"=>"nosp",
            ],
            [
                "index"=>"nominal",
                "label"=>"nominal",
            ],
        ];

        $tradoPrev = null;
        foreach ($header_columns as $data_columns_index => $data_column) {
            $sheet->setCellValue($alphabets[$data_columns_index] . $header_start_row, $data_column['label'] ?? $data_columns_index + 1);
        }

        $lastColumn = $alphabets[$data_columns_index];
        $sheet->getStyle("A$header_start_row:$lastColumn$header_start_row")->applyFromArray($styleArray)->getFont()->setBold(true);

        if (is_array($pengeluaran) || is_iterable($pengeluaran)) {
            foreach ($pengeluaran as $response_index => $response_detail) {

                foreach ($header_columns as $detail_columns_index => $detail_column) {
                    $sheet->setCellValue($alphabets[$detail_columns_index] . $detail_start_row, isset($detail_column['index']) ? $response_detail[$detail_column['index']] : $response_index + 1);
                }

                if ($tradoPrev != $response_detail['trado_id']) {
                    $sheet->mergeCells('A' . $detail_start_row . ':F' . $detail_start_row);
                    $sheet->setCellValue("A$detail_start_row", $response_detail['trado'])->getStyle('A' . $detail_start_row . ':F' . $detail_start_row)->applyFromArray($styleArray)->getFont()->setBold(true);
                    $detail_start_row++;
                }

                $sheet->setCellValue("A$detail_start_row", date('d-m-Y', strtotime($response_detail['tglbukti'])));
                $sheet->setCellValue("B$detail_start_row", $response_detail['day']);
                $sheet->setCellValue("C$detail_start_row", $response_detail['tujuan']);
                $sheet->setCellValue("D$detail_start_row", $response_detail['shipper']);
                $sheet->setCellValue("E$detail_start_row", $response_detail['container']);
                $sheet->setCellValue("F$detail_start_row", $response_detail['nosp']);
                $sheet->setCellValue("G$detail_start_row", $response_detail['nominal']);
                

                $sheet->getStyle("A$detail_start_row:G$detail_start_row")->applyFromArray($styleArray);
                $sheet->getStyle("G$detail_start_row")->getNumberFormat()->setFormatCode("#,##0.00");
                $detail_start_row++;
                $tradoPrev = $response_detail['trado_id'];
            }
        }

        //total
        $total_start_row = $detail_start_row;
        $sheet->mergeCells('A' . $total_start_row . ':F' . $total_start_row);
        $sheet->setCellValue("A$total_start_row", 'Total')->getStyle('A' . $total_start_row . ':F' . $total_start_row)->applyFromArray($styleArray)->getFont()->setBold(true);

        $totalDebet = "=SUM(G6:G" . ($detail_start_row - 1) . ")";
        $sheet->setCellValue("G$total_start_row", $totalDebet)->getStyle("G$total_start_row")->applyFromArray($style_number);
        $sheet->setCellValue("G$total_start_row", $totalDebet)->getStyle("G$total_start_row")->getNumberFormat()->setFormatCode("#,##0.00");

        $ttd_start_row = $detail_start_row + 2;
        $sheet->setCellValue("A$ttd_start_row", 'Disetujui Oleh,');
        $sheet->setCellValue("C$ttd_start_row", 'Diperiksa Oleh,');
        $sheet->setCellValue("E$ttd_start_row", 'Disusun Oleh,');

        $sheet->setCellValue("A" . ($ttd_start_row + 3), '( ' . $disetujui . ' )');
        $sheet->setCellValue("C" . ($ttd_start_row + 3), '( ' . $diperiksa . ' )');
        $sheet->setCellValue("E" . ($ttd_start_row + 3), '(                )');

        //ukuran kolom
        $sheet->getColumnDimension('A')->setAutoSize(true);
        $sheet->getColumnDimension('B')->setAutoSize(true);
        $sheet->getColumnDimension('C')->setAutoSize(true);
        $sheet->getColumnDimension('D')->setAutoSize(true);
        $sheet->getColumnDimension('E')->setAutoSize(true);
        $sheet->getColumnDimension('F')->setAutoSize(true);
        $sheet->getColumnDimension('G')->setAutoSize(true);



        $writer = new Xlsx($spreadsheet);
        $filename = 'LAPORAN Titipan EMKL' . date('dmYHis');
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }
}

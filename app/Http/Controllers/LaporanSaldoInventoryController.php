<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;


use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class LaporanSaldoInventoryController extends Controller
{
    public $title = 'Laporan Saldo Inventory';

    public function index(Request $request)
    {
        $title = $this->title;
        $data = [
            'pagename' => 'Menu Utama Laporan Saldo Inventory',
        ];

        return view('laporansaldoinventory.index', compact('title'));
    }

    public function report(Request $request)
    {

        $detailParams = [
            'kelompok_id' => $request->kelompok_id,
            'statusreuse' => $request->statusreuse,
            'statusban' => $request->statusban,
            'filter' => $request->filter,
            'jenistgltampil' => $request->jenistgltampil,
            'priode' => $request->priode,
            'stokdari_id' => $request->stokdari_id,
            'stoksampai_id' => $request->stoksampai_id,
            'dataFilter' => $request->dataFilter,
        ];

        $header = Http::withHeaders(request()->header())
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'laporansaldoinventory/report', $detailParams);

        $data = $header['data'];
        $user = Auth::user();
        return view('reports.laporansaldoinventory', compact('data', 'user', 'detailParams'));
    }

    public function export(Request $request): void
    {
        $detailParams = [
            'kelompok_id' => $request->kelompok_id,
            'statusreuse' => $request->statusreuse,
            'statusban' => $request->statusban,
            'filter' => $request->filter,
            'jenistgltampil' => $request->jenistgltampil,
            'priode' => $request->priode,
            'stokdari_id' => $request->stokdari_id,
            'stoksampai_id' => $request->stoksampai_id,
            'dataFilter' => $request->dataFilter,
        ];

        $header = Http::withHeaders(request()->header())
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'laporansaldoinventory/report', $detailParams);

        $data = $header['data'];

        $disetujui = $data[0]['disetujui'] ?? '';
        $diperiksa = $data[0]['diperiksa'] ?? '';

        $user = Auth::user();

        $format = \PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_DATE_DMYMINUS;

        $data = $header['data'];
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', $data[0]['header'] ?? '');
        $sheet->getStyle("A1")->getFont()->setSize(20)->setBold(true);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal('center');
        $sheet->mergeCells('A1:G1');

        $sheet->setCellValue('A4', 'PERIODE');
        $sheet->getStyle("A4")->getFont()->setSize(12)->setBold(true);
        $sheet->getStyle("B4")->getFont()->setSize(12)->setBold(true);

        $sheet->setCellValue('B4', ': ' . $request->priode);

        $sheet->setCellValue('A5', 'STOK');
        $sheet->getStyle("A5")->getFont()->setSize(12)->setBold(true);
        $sheet->getStyle("B5")->getFont()->setSize(12)->setBold(true);
        $stokdari = $data[0]['stokdari'] ?? " ";
        $stoksampai = $data[0]['stoksampai'] ?? " ";
        $kategori = $data[0]['kategori'] ?? " ";
        $lokasi = $data[0]['lokasi'] ?? " ";
        $namalokasi = $data[0]['namalokasi'] ?? " ";
        $sheet->setCellValue('B5', ': ' .  $stokdari ?? " " . " S/D" . " " . $stoksampai ?? " ");

        $sheet->setCellValue('A6', 'KATEGORI');
        $sheet->getStyle("A6")->getFont()->setSize(12)->setBold(true);
        $sheet->getStyle("B6")->getFont()->setSize(12)->setBold(true);

        $sheet->setCellValue('B6', ': ' .  $kategori ?? '');

        $sheet->setCellValue('A7', $lokasi);
        $sheet->getStyle("A7")->getFont()->setSize(12)->setBold(true);
        $sheet->getStyle("B7")->getFont()->setSize(12)->setBold(true);

        $sheet->setCellValue('B7', ': ' .  $namalokasi ?? '');

        $sheet->getStyle("C4")->getFont()->setSize(12)->setBold(true);

        $detail_table_header_row = 9;
        $detail_start_row = $detail_table_header_row + 1;

        $alphabets = range('A', 'Z');

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

        $header_columns = [
            [
                "index" => "vulkanisirke",
                "label" => "vulkanisirke",
            ],
            [
                "index" => "kodebarang",
                "label" => "kodebarang",
            ],
            [
                "index" => "namabarang",
                "label" => "namabarang",
            ],
            [
                "index" => "tanggal",
                "label" => "tanggal",
            ],
            [
                "index" => "qty",
                "label" => "qty",
            ],
            [
                "index" => "satuan",
                "label" => "satuan",
            ],
            [
                "index" => "nominal",
                "label" => "nominal",
            ]
        ];



        foreach ($header_columns as $detail_columns_index => $detail_column) {
            $sheet->setCellValue($alphabets[$detail_columns_index] . $detail_table_header_row, $detail_column['label'] ?? $detail_columns_index + 1);
        }
        $sheet->getStyle("A$detail_table_header_row:G$detail_table_header_row")->applyFromArray($styleArray)->getFont()->setBold(true);

        // LOOPING DETAIL
        $totalSaldo = 0;
       
        foreach ($data as $response_index => $response_detail) {

            foreach ($header_columns as $detail_columns_index => $detail_column) {
                $sheet->setCellValue($alphabets[$detail_columns_index] . $detail_start_row, isset($detail_column['index']) ? $response_detail[$detail_column['index']] : $response_index + 1);
            }



            // $sheet->getStyle("D$detail_start_row")->getNumberFormat()->setFormatCode($format);

            $sheet->setCellValue("A$detail_start_row", $response_detail['vulkanisirke']);
            $sheet->setCellValue("B$detail_start_row", $response_detail['kodebarang']);
            $sheet->setCellValue("C$detail_start_row", $response_detail['namabarang']);
            $sheet->setCellValue("D$detail_start_row", date('d-m-Y',strtotime($response_detail['tanggal'])) );
            $sheet->setCellValue("E$detail_start_row", $response_detail['qty']);
            $sheet->setCellValue("F$detail_start_row", $response_detail['satuan']);
            $sheet->setCellValue("G$detail_start_row", $response_detail['nominal']);

            $sheet->getStyle("A$detail_start_row:G$detail_start_row")->applyFromArray($styleArray);
            $sheet->getStyle("G$detail_start_row")->getNumberFormat()->setFormatCode("#,##0.00");


            $totalSaldo += $response_detail['nominal'];
            $detail_start_row++;
        }

        //total
        $totalSaldo = "=SUM(G7:G" . ($detail_start_row - 1) . ")";
        $sheet->setCellValue("A$detail_start_row", "TOTAL")->getStyle("A$detail_start_row:G$detail_start_row")->applyFromArray($style_number);
        $sheet->setCellValue("G$detail_start_row", $totalSaldo)->getStyle("G$detail_start_row")->applyFromArray($style_number);
        $sheet->setCellValue("G$detail_start_row", $totalSaldo)->getStyle("G$detail_start_row")->getNumberFormat()->setFormatCode("#,##0.00");

        // set diketahui dibuat
        $ttd_start_row = $detail_start_row + 2;
        $sheet->setCellValue("C$ttd_start_row", 'Disetujui Oleh,');
        $sheet->setCellValue("E$ttd_start_row", 'Diperiksa Oleh,');
        $sheet->setCellValue("G$ttd_start_row", 'Disusun Oleh,');

        $sheet->setCellValue("C" . ($ttd_start_row + 3), '( ' . $disetujui . ' )');
        $sheet->setCellValue("E" . ($ttd_start_row + 3), '( ' . $diperiksa . ' )');
        $sheet->setCellValue("G" . ($ttd_start_row + 3), '(                )');


        //style header
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

        // $sheet->getStyle("A4")->applyFromArray($styleArray3);
        // $sheet->getStyle("B4")->applyFromArray($styleArray3);
        // $sheet->getStyle("C4")->applyFromArray($styleArray3);
        // $sheet->getStyle("D4")->applyFromArray($styleArray3);
        // $sheet->getStyle("E4")->applyFromArray($styleArray3);
        // $sheet->getStyle("F4")->applyFromArray($styleArray3);
        // $sheet->getStyle("G4")->applyFromArray($styleArray3);
        // $sheet->getStyle("H4")->applyFromArray($styleArray3);
        // $sheet->getStyle("I4")->applyFromArray($styleArray3);
        // $sheet->getStyle("J4")->applyFromArray($styleArray3);
        // $sheet->getStyle("A")->applyFromArray($styleArray);
        // $sheet->getStyle("E")->applyFromArray($styleArray);


        $writer = new Xlsx($spreadsheet);
        $filename = 'LAPORAN PENYESUAIAN BARANG' . date('dmYHis');
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\RedirectResponse;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;


class LaporanHutangGiroController extends MyController
{
    public $title = 'Laporan Hutang Giro';

    public function index(Request $request)
    {
        $title = $this->title;
        $data = [
            'pagename' => 'Menu Utama Laporan Hutang Giro',
        ];

        return view('laporanhutanggiro.index', compact('title'));
    }

    public function get($params = []): array
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
            ->get(config('app.api_url') . 'laporanhutanggiro', $params);

        $data = [
            'total' => $response['attributes']['totalPages'] ?? [],
            'records' => $response['attributes']['totalRows'] ?? [],
            'rows' => $response['data'] ?? []
        ];

        return $data;
    }


    public function report(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');
        $detailParams = [
            'judul' => 'PT. TRANSPORINDO AGUNG SEJAHTERA',
            'judullaporan' => 'Laporan  Hutang Giro',
            'tanggal_cetak' => date('d-m-Y H:i:s'),
            'periode' => $request->periode,
        ];


        // dd($detailParams);
        $header = Http::withHeaders(request()->header())
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'laporanhutanggiro/report', $detailParams);
        $data = $header['data'];
        $dataCabang['namacabang'] = $header['namacabang'];



        // $dataHeader = $header['dataheader'];
        $user = Auth::user();
        $cabang['cabang'] = session('cabang');
        // dd($data);
        return view('reports.laporanhutanggiro', compact('data','dataCabang', 'user', 'detailParams','cabang'));
    }

    // public function export(Request $request): void
    // {
    //     $detailParams = [
    //         'judul' => 'PT. TRANSPORINDO AGUNG SEJAHTERA',
    //         'judullaporan' => 'Laporan  Hutang Giro',
    //         'tanggal_cetak' => date('d-m-Y H:i:s'),
    //         'periode' => $request->periode,
    //     ];

    //     $responses = Http::withHeaders($request->header())
    //         ->withOptions(['verify' => false])
    //         ->withToken(session('access_token'))
    //         ->get(config('app.api_url') . 'laporanhutanggiro/export', $detailParams);

    //     $pengeluaran = $responses['data'];

    //     if(count($pengeluaran) == 0){
    //         throw new \Exception('TIDAK ADA DATA');
    //     }

    //     $namacabang = $responses['namacabang'];
    //     $disetujui = $pengeluaran[0]['disetujui'] ?? '';
    //     $diperiksa = $pengeluaran[0]['diperiksa'] ?? '';

    //     $user = Auth::user();
    //     $spreadsheet = new Spreadsheet();
    //     $sheet = $spreadsheet->getActiveSheet();

    //     $sheet->setCellValue('A1', $pengeluaran[0]['judul']);
    //     $sheet->getStyle("A1")->getFont()->setSize(16)->setBold(true);
    //     $sheet->getStyle('A1')->getAlignment()->setHorizontal('center');
    //     $sheet->mergeCells('A1:F1');
    //     $sheet->setCellValue('A2', $namacabang);
    //     $sheet->getStyle("A2")->getFont()->setSize(16)->setBold(true);
    //     $sheet->getStyle('A2')->getAlignment()->setHorizontal('center');
    //     $sheet->mergeCells('A2:F2');
        

    //     $englishMonths = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
    //     $indonesianMonths = ['JANUARI', 'FEBRUARI', 'MARET', 'APRIL', 'MEI', 'JUNI', 'JULI', 'AGUSTUS', 'SEPTEMBER', 'OKTOBER', 'NOVEMBER', 'DESEMBER'];
        
    //     $tanggal = str_replace($englishMonths, $indonesianMonths, date('d - M - Y', strtotime($request->periode)));

    //     $sheet->setCellValue('A3', $pengeluaran[0]['judulLaporan']);
    //     $sheet->setCellValue('A4', 'Periode : ' . $tanggal);

    //     // $sheet->getStyle("A1")->getFont()->setSize(20)->setBold(true);
    //     $sheet->getStyle("A3")->getFont()->setBold(true);
    //     $sheet->getStyle("A4:B4")->getFont()->setBold(true);

    //     $header_start_row = 6;
    //     $detail_start_row = 7;

    //     $styleArray = array(
    //         'borders' => array(
    //             'allBorders' => array(
    //                 'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
    //             ),
    //         ),
    //     );

    //     $style_number = [
    //         'alignment' => [
    //             'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT,
    //         ],

    //         'borders' => [
    //             'top' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
    //             'right' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
    //             'bottom' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
    //             'left' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN]
    //         ]
    //     ];

    //     $alphabets = range('A', 'Z');



    //     $header_columns = [
    //         [
    //             'label' => 'No Bukti',
    //             'index' => 'nobukti',
    //         ],
    //         [
    //             'label' => 'Tgl Bukti',
    //             'index' => 'tglbukti',
    //         ],
    //         [
    //             'label' => 'Keterangan',
    //             'index' => 'keterangan',
    //         ],
    //         [
    //             'label' => 'No Warkat',
    //             'index' => 'nowarkat',
    //         ],
    //         [
    //             'label' => 'Tgl Jatuh Tempo',
    //             'index' => 'tgljatuhtempo',
    //         ],
    //         [
    //             'label' => 'Nominal',
    //             'index' => 'nominal',
    //         ],

    //     ];


    //     foreach ($header_columns as $data_columns_index => $data_column) {
    //         $sheet->setCellValue($alphabets[$data_columns_index] . $header_start_row, ucfirst($data_column['label']) ?? $data_columns_index + 1);
    //     }

    //     $lastColumn = $alphabets[$data_columns_index];
    //     $sheet->getStyle("A$header_start_row:$lastColumn$header_start_row")->applyFromArray($styleArray)->getFont()->setBold(true);
    //     $totalDebet = 0;
    //     if (is_array($pengeluaran) || is_iterable($pengeluaran)) {
    //         foreach ($pengeluaran as $response_index => $response_detail) {

    //             foreach ($header_columns as $detail_columns_index => $detail_column) {
    //                 $sheet->setCellValue($alphabets[$detail_columns_index] . $detail_start_row, isset($detail_column['index']) ? $response_detail[$detail_column['index']] : $response_index + 1);
    //             }

    //             $sheet->setCellValue("A$detail_start_row", $response_detail['nobukti']);
    //             $sheet->setCellValue("B$detail_start_row", date('d-m-Y', strtotime($response_detail['tglbukti'])));
    //             $dateValue = ($response_detail['tglbukti'] != null) ? Date::PHPToExcel(date('Y-m-d',strtotime($response_detail['tglbukti']))) : ''; 
    //             $sheet->setCellValue("B$detail_start_row", $dateValue);
    //             $sheet->getStyle("B$detail_start_row") 
    //             ->getNumberFormat() 
    //             ->setFormatCode('dd-mm-yyyy');

    //             $sheet->setCellValue("C$detail_start_row", $response_detail['keterangan']);
    //             $sheet->setCellValue("D$detail_start_row", $response_detail['nowarkat']);
    //             $dateValue = ($response_detail['tgljatuhtempo'] != null) ? Date::PHPToExcel(date('Y-m-d',strtotime($response_detail['tgljatuhtempo']))) : ''; 
    //             $sheet->setCellValue("E$detail_start_row", $dateValue);
    //             $sheet->getStyle("E$detail_start_row") 
    //             ->getNumberFormat() 
    //             ->setFormatCode('dd-mm-yyyy');
    //             $sheet->setCellValue("F$detail_start_row", $response_detail['nominal']);
    //             $sheet->getStyle("C$detail_start_row")->getAlignment()->setWrapText(true);
    //             $sheet->getStyle("A$detail_start_row:F$detail_start_row")->applyFromArray($styleArray);
    //             $sheet->getStyle("F$detail_start_row")->getNumberFormat()->setFormatCode("#,##0.00_);(#,##0.00)");
    //             $detail_start_row++;
    //         }
    //     }
    //     //total
    //     $total_start_row = $detail_start_row;
    //     $sheet->mergeCells('A' . $total_start_row . ':E' . $total_start_row);
    //     $sheet->setCellValue("A$total_start_row", 'Total')->getStyle('A' . $total_start_row . ':E' . $total_start_row)->applyFromArray($styleArray)->getFont()->setBold(true);

    //     $totalDebet = "=SUM(F7:F" . ($detail_start_row - 1) . ")";
    //     $sheet->setCellValue("F$total_start_row", $totalDebet)->getStyle("F$total_start_row")->applyFromArray($style_number)->getFont()->setBold(true);
    //     $sheet->setCellValue("F$total_start_row", $totalDebet)->getStyle("F$total_start_row")->getNumberFormat()->setFormatCode("#,##0.00_);(#,##0.00)");
        
    //     $ttd_start_row = $detail_start_row + 2;
    //     $sheet->setCellValue("A$ttd_start_row", 'Disetujui Oleh,');
    //     $sheet->setCellValue("C$ttd_start_row", 'Diperiksa Oleh,');
    //     $sheet->setCellValue("E$ttd_start_row", 'Disusun Oleh,');

    //     $sheet->setCellValue("A" . ($ttd_start_row + 3), '( ' . $disetujui . ' )');
    //     $sheet->setCellValue("C" . ($ttd_start_row + 3), '( ' . $diperiksa . ' )');
    //     $sheet->setCellValue("E" . ($ttd_start_row + 3), '(                )');
    //     //ukuran kolom
    //     $sheet->getColumnDimension('A')->setWidth(24);
    //     $sheet->getColumnDimension('B')->setWidth(20);
    //     $sheet->getColumnDimension('D')->setWidth(24);
    //     $sheet->getColumnDimension('E')->setWidth(20);
    //     $sheet->getColumnDimension('F')->setWidth(24);
    //     $sheet->getColumnDimension('C')->setWidth(64);        

    //     $writer = new Xlsx($spreadsheet);
    //     $filename = 'LAPORAN HUTANG GIRO ' . date('dmYHis');
    //     header('Content-Type: application/vnd.ms-excel');
    //     header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
    //     header('Cache-Control: max-age=0');

    //     $writer->save('php://output');
    // }
}

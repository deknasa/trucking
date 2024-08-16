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


class laporanpembelianController extends MyController
{
    public $title = 'Laporan Pembelian Per Supplier';

    public function index(Request $request)
    {
        $title = $this->title;
        $data = [
            'pagename' => 'Menu Utama Laporan Pembelian',
        ];

        return view('laporanpembelian.index', compact('title'));
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
            ->get(config('app.api_url') . 'laporanpembelian', $params);

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
            'judullaporan' => 'Laporan  Pembelian',
            'tanggal_cetak' => date('d-m-Y H:i:s'),
            'dari' => $request->dari,
            'sampai' => $request->sampai,
            'supplierdari' => $request->supplierdari,
            'suppliersampai' => $request->suppliersampai,
            'supplierdari_id' => $request->supplierdari_id,
            'suppliersampai_id' => $request->suppliersampai_id,
            'status' => $request->status,
            'dari' => $request->dari,

        ];
        // dd($detailParams);
        $header = Http::withHeaders(request()->header())
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'laporanpembelian/report', $detailParams);
        $data = $header['data'];
        $dataCabang['namacabang'] = $header['namacabang'];


        // dd($data);
        // $dataHeader = $header['dataheader'];
        $user = Auth::user();

        return view('reports.laporanpembelian', compact('data','dataCabang', 'user', 'detailParams'));
    }





    public function export(Request $request): void
    {
        $detailParams = [
            'judul' => 'PT. TRANSPORINDO AGUNG SEJAHTERA',
            'judullaporan' => 'Laporan  Pembelian',
            'tanggal_cetak' => date('d-m-Y H:i:s'),
            'dari' => $request->dari,
            'sampai' => $request->sampai,
            'supplierdari' => $request->supplierdari,
            'suppliersampai' => $request->suppliersampai,
            'supplierdari_id' => $request->supplierdari_id,
            'suppliersampai_id' => $request->suppliersampai_id,
            'status' => $request->status,
            'dari' => $request->dari,


        ];

        $responses = Http::withHeaders($request->header())
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'laporanpembelian/report', $detailParams);

        $pengeluaran = $responses['data'];

        if(count($pengeluaran) == 0){
            throw new \Exception('TIDAK ADA DATA');
        }
        
        $namacabang = $responses['namacabang'];
        $disetujui = $pengeluaran[0]['disetujui'] ?? '';
        $diperiksa = $pengeluaran[0]['diperiksa'] ?? '';
        $user = Auth::user();
        // dd($pengeluaran);
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', $pengeluaran[0]['judul']);
        $sheet->getStyle("A1")->getFont()->setSize(16)->setBold(true);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal('center');
        $sheet->mergeCells('A1:G1');
        $sheet->setCellValue('A2', $namacabang);
        $sheet->getStyle("A2")->getFont()->setSize(16)->setBold(true);
        $sheet->getStyle('A2')->getAlignment()->setHorizontal('center');
        $sheet->mergeCells('A2:G2');
        
        $sheet->setCellValue('A3', $pengeluaran[0]['judulLaporan']);
        // $sheet->mergeCells('A3:B3');
        $sheet->setCellValue('A4', 'Tanggal : ' . date('d-M-Y', strtotime($detailParams['dari'])) . ' s/d ' . date('d-M-Y', strtotime($detailParams['sampai'])));
        // $sheet->mergeCells('A4:B4');
        $sheet->setCellValue('A5', 'Status : '. $request->status);
        // $sheet->mergeCells('A5:B5');

        $sheet->getStyle("A3")->getFont()->setBold(true);
        $sheet->getStyle("A4:B4")->getFont()->setBold(true);
        $sheet->getStyle("A5:B5")->getFont()->setBold(true);

        $header_start_row = 7;
        $detail_start_row = 8;

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

        ];

        $alphabets = range('A', 'Z');



        $header_columns = [
            [
                'label' => 'No Bukti',
                'index' => 'nobukti',
            ],
            [
                'label' => 'Tgl Bukti',
                'index' => 'tglbukti',
            ],
            [
                'label' => 'Nama Supplier',
                'index' => 'namasupplier',
            ],
            [
                'label' => 'Nama Stok',
                'index' => 'namastok',
            ],
            [
                'label' => 'Qty',
                'index' => 'qty',
            ],
            [
                'label' => 'Satuan',
                'index' => 'satuan',
            ],
            [
                'label' => 'Keterangan',
                'index' => 'keterangan',
            ],



        ];


        foreach ($header_columns as $data_columns_index => $data_column) {
            $sheet->setCellValue($alphabets[$data_columns_index] . $header_start_row, $data_column['label'] ?? $data_columns_index + 1);
        }

        $lastColumn = $alphabets[$data_columns_index];
        $sheet->getStyle("A$header_start_row:$lastColumn$header_start_row")->getFont()->setBold(true);
        $sheet->getStyle("A$header_start_row:$lastColumn$header_start_row")->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        
        if (is_array($pengeluaran) || is_iterable($pengeluaran)) {
            foreach ($pengeluaran as $response_index => $response_detail) {

                foreach ($header_columns as $detail_columns_index => $detail_column) {
                    $sheet->setCellValue($alphabets[$detail_columns_index] . $detail_start_row, isset($detail_column['index']) ? $response_detail[$detail_column['index']] : $response_index + 1);
                }

                $sheet->setCellValue("A$detail_start_row", $response_detail['nobukti']);
                $dateValue = ($response_detail['tglbukti'] != null) ? Date::PHPToExcel(date('Y-m-d',strtotime($response_detail['tglbukti']))) : ''; 
                $sheet->setCellValue("B$detail_start_row", $dateValue);
                $sheet->getStyle("B$detail_start_row") 
                ->getNumberFormat() 
                ->setFormatCode('dd-mm-yyyy');
                $sheet->setCellValue("C$detail_start_row", $response_detail['namasupplier']);
                $sheet->setCellValue("D$detail_start_row", $response_detail['namastok']);
                $sheet->setCellValue("E$detail_start_row", $response_detail['qty']);
                $sheet->setCellValue("F$detail_start_row", $response_detail['satuan']);
                $sheet->setCellValue("G$detail_start_row", $response_detail['keterangan']);

                $sheet->getStyle("A$detail_start_row:G$detail_start_row")->applyFromArray($styleArray);
                // $sheet->getStyle("C$detail_start_row:I$detail_start_row")->getNumberFormat()->setFormatCode("#,##0.00");
                // $sheet->getStyle("B$detail_start_row:B$detail_start_row")->getNumberFormat()->setFormatCode('dd-mm-yyyy');
                // $sheet->getStyle("D$detail_start_row:D$detail_start_row")->getNumberFormat()->setFormatCode('dd-mm-yyyy');


                //    $totalKredit += $response_detail['kredit'];
                //     $totalDebet += $response_detail['debet'];
                //     $totalSaldo += $response_detail['Saldo'];
                $detail_start_row++;
            }
        }

        $ttd_start_row = $detail_start_row + 2;
        $sheet->setCellValue("A$ttd_start_row", 'Disetujui Oleh,');
        $sheet->setCellValue("C$ttd_start_row", 'Diperiksa Oleh,');
        $sheet->setCellValue("F$ttd_start_row", 'Disusun Oleh,');

        $sheet->setCellValue("A" . ($ttd_start_row + 3), '( ' . $disetujui . ' )');
        $sheet->setCellValue("C" . ($ttd_start_row + 3), '( ' . $diperiksa . ' )');
        $sheet->setCellValue("F" . ($ttd_start_row + 3), '(                )');

        //ukuran kolom
        $sheet->getColumnDimension('A')->setWidth(18);
        $sheet->getColumnDimension('B')->setWidth(14);
        $sheet->getColumnDimension('C')->setWidth(22);
        $sheet->getColumnDimension('D')->setWidth(33);
        $sheet->getColumnDimension('E')->setAutoSize(true);
        $sheet->getColumnDimension('F')->setWidth(8);
        $sheet->getColumnDimension('G')->setWidth(72);



        $writer = new Xlsx($spreadsheet);
        $filename = 'LAPORAN PEMBELIAN PER SUPPLIER' . date('dmYHis');
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }
}

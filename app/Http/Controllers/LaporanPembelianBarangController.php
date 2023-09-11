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

class LaporanPembelianBarangController extends Controller
{
    public $title = 'Laporan Pembelian Barang';

    public function index(Request $request)
    {
        $title = $this->title;
        $data = [
            'pagename' => 'Menu Utama Laporan Pembelian Barang',
        ];

        return view('laporanpembelianbarang.index', compact('title'));
    }

    public function report(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');
        $detailParams = [
            'judul' => 'PT. TRANSPORINDO AGUNG SEJAHTERA',
            'judullaporan' => 'Laporan Pembelian Barang',
            'tanggal_cetak' => date('d-m-Y H:i:s'),
            'sampai' => $request->sampai,

        ];
        $header = Http::withHeaders(request()->header())
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'laporanpembelianbarang/report', $detailParams);


        if ($header->successful()) {
            $data = $header['data'];
            $user = Auth::user(); 
            // return response()->json(['url' => route('reports.laporanpembelianbarang', compact('data', 'user', 'detailParams'))]);
            return view('reports.laporanpembelianbarang', compact('data', 'user', 'detailParams'));
        } else {
            return response()->json($header->json(), $header->status());
        }
    }

    public function export(Request $request): void
    {
        $detailParams = [
            'judul' => 'PT. TRANSPORINDO AGUNG SEJAHTERA',
            'judullaporan' => 'Laporan  Pembelian Barang',
            'tanggal_cetak' => date('d-m-Y H:i:s'),
            'sampai' => $request->sampai,


        ];

        $responses = Http::withHeaders($request->header())
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'laporanpembelianbarang/export', $detailParams);

        $pengeluaran = $responses['data'];
        $disetujui = $pengeluaran[0]['disetujui'] ?? '';
        $diperiksa = $pengeluaran[0]['diperiksa'] ?? '';
        $user = Auth::user();
        // dd($pengeluaran);
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', 'PT. TRANSPORINDO AGUNG SEJAHTERA');
        $sheet->setCellValue('A2', 'Laporan Pembelian Barang');
        $sheet->setCellValue('A3', 'Periode: ' . $request->sampai);

        // $sheet->getStyle("A1")->getFont()->setSize(20)->setBold(true);

        $sheet->getStyle('A1')->getAlignment()->setHorizontal('center');
        $sheet->getStyle('A2')->getAlignment()->setHorizontal('left');
        $sheet->mergeCells('A1:B1');
        $sheet->mergeCells('A2:B2');
        $sheet->mergeCells('A3:B3');
        $sheet->mergeCells('A4:B4');

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

        ];

        $alphabets = range('A', 'Z');



        $header_columns = [

            [
                'label' => 'KETERANGAN',
                'index' => 'keteranganmain',
            ],

            [
                'label' => 'NILAI',
                'index' => 'Nominal',
            ],
        ];

        foreach ($header_columns as $data_columns_index => $data_column) {
            $sheet->setCellValue($alphabets[$data_columns_index] . $header_start_row, $data_column['label'] ?? $data_columns_index + 1);
        }

        $lastColumn = $alphabets[$data_columns_index];
        $sheet->getStyle("A$header_start_row:$lastColumn$header_start_row")->getFont()->setBold(true);
        $totalDebet = 0;
        $totalKredit = 0;
        $totalSaldo = 0;
        // $no = 1;
        if (is_array($pengeluaran) || is_iterable($pengeluaran)) {
            // $no = 1;

            // Menambahkan baris untuk Pendapatan
            // $sheet->setCellValue("A$detail_start_row", $no);
            // Tulis label "Pendapatan :" pada kolom "A"

            // Gabungkan sel pada kolom "A" untuk label "Pendapatan :"
            $sheet->mergeCells("A$detail_start_row:A$detail_start_row");

            $detail_start_row++;

            // Menulis data dan melakukan grup berdasarkan kolom "KeteranganMain"
            $previous_keterangan_main = '';
            foreach ($pengeluaran as $response_detail) {
                $keterangan_main = $response_detail['keteranganmain'];

                if ($keterangan_main != $previous_keterangan_main) {
                    // Jika nilai "KeteranganMain" berbeda dengan sebelumnya, buat grup baru
                    $sheet->setCellValue("A$detail_start_row", $keterangan_main);
                    $sheet->mergeCells("A$detail_start_row:A$detail_start_row");

                    // Tingkatkan nomor baris
                    $detail_start_row++;
                }


                // Tulis data pada kolom-kolom lain
                $sheet->setCellValue("A$detail_start_row", $response_detail['KeteranganParent']);

                $sheet->setCellValue("A$detail_start_row", "      " . $response_detail['keterangancoa']);
                $sheet->setCellValue("B$detail_start_row", $response_detail['Nominal']);

                // Tingkatkan nomor baris
                $detail_start_row++;

                // Simpan nilai "KeteranganMain" untuk perbandingan selanjutnya
                $previous_keterangan_main = $keterangan_main;
            }
        }



        //ukuran kolom
        $sheet->getColumnDimension('A')->setAutoSize(true);
        $sheet->getColumnDimension('B')->setAutoSize(true);



        // menambahkan sel Total pada baris terakhir + 1
        // $sheet->setCellValue("A" . ($detail_start_row + 1), 'Total');
        // $sheet->setCellValue("D" . ($detail_start_row + 1), "=SUM(D5:D" . $detail_start_row . ")");
        // $sheet->setCellValue("E" . ($detail_start_row + 1), "=SUM(E5:E" . $detail_start_row . ")");


        //FORMAT
        // set format ribuan untuk kolom D dan E
        $sheet->getStyle("B" . ($detail_start_row + 1) . ":B" . ($detail_start_row + 1))->getNumberFormat()->setFormatCode("#,##0.00");
        $sheet->getStyle("A" . ($detail_start_row + 1) . ":$lastColumn" . ($detail_start_row + 1))->getFont()->setBold(true);


        //persetujuan
        // $sheet->mergeCells('A' . ($detail_start_row + 3) . ':B' . ($detail_start_row + 3));
        // $sheet->setCellValue('A' . ($detail_start_row + 3), 'Disetujui Oleh,');
        // $sheet->mergeCells('C' . ($detail_start_row + 3). ($detail_start_row + 3));
        // $sheet->setCellValue('C' . ($detail_start_row + 3), 'Diperiksa Oleh');
        // $sheet->mergeCells('D' . ($detail_start_row + 3) . ':E' . ($detail_start_row + 3));
        // $sheet->setCellValue('D' . ($detail_start_row + 3), 'Disusun Oleh,');


        // $sheet->mergeCells('A' . ($detail_start_row + 6) . ':B' . ($detail_start_row + 6));
        // $sheet->setCellValue('A' . ($detail_start_row + 6), '( ' . $disetujui . ' )');
        // $sheet->mergeCells('C' . ($detail_start_row + 6) . ($detail_start_row + 6));
        // $sheet->setCellValue('C' . ($detail_start_row + 6), '( ' . $diperiksa . ' )');
        // $sheet->mergeCells('D' . ($detail_start_row + 6) . ':E' . ($detail_start_row + 6));
        // $sheet->setCellValue('D' . ($detail_start_row + 6), '(                                          )');


        // style persetujuan
        // $sheet->getStyle('A' . ($detail_start_row + 3))->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        // $sheet->getStyle('A' . ($detail_start_row + 3))->getFont()->setSize(12);
        // $sheet->getStyle('C' . ($detail_start_row + 3))->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        // $sheet->getStyle('C' . ($detail_start_row + 3))->getFont()->setSize(12);
        // $sheet->getStyle('D' . ($detail_start_row + 3))->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        // $sheet->getStyle('D' . ($detail_start_row + 3))->getFont()->setSize(12);


        // $sheet->getStyle('A' . ($detail_start_row + 6))->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        // $sheet->getStyle('A' . ($detail_start_row + 6))->getFont()->setSize(12);
        // $sheet->getStyle('C' . ($detail_start_row + 6))->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        // $sheet->getStyle('C' . ($detail_start_row + 6))->getFont()->setSize(12);
        // $sheet->getStyle('D' . ($detail_start_row + 6))->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        // $sheet->getStyle('D' . ($detail_start_row + 6))->getFont()->setSize(12);

        // mengatur border top dan bottom pada cell Total
        // $border_style = [
        //     'borders' => [
        //         'top' => ['borderStyle' => 'thin', 'color' => ['rgb' => '000000']],
        //         'bottom' => ['borderStyle' => 'thin', 'color' => ['rgb' => '000000']]
        //     ]
        // ];
        // $sheet->getStyle("A" . ($detail_start_row + 1) . ":$lastColumn" . ($detail_start_row + 1))->applyFromArray($border_style);


        $writer = new Xlsx($spreadsheet);
        $filename = 'EXPORT LAPORAN PEMBELIAN BARANG' . date('dmYHis');
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }

}

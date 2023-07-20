<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;


class ExportPembelianBarangController extends MyController
{
    public $title = 'Export Pembelian Barang';

    public function index(Request $request)
    {
        $title = $this->title;
        $data = [
            'pagename' => 'Menu Utama Export Pembelian Barang',
        ];

        return view('exportpembelianbarang.index', compact('title'));
    }

    public function export(Request $request): void
    {
        $detailParams = [
            'periode' => $request->periode,
        ];
        date_default_timezone_set("Asia/Jakarta");

        $monthNum  = intval(substr($request->periode, 0, 2));
        $yearNum  = substr($request->periode,3);
        $monthName = $this->getBulan($monthNum);
        
        // $responses = Http::withHeaders($request->header())
        //     ->withOptions(['verify' => false])
        //     ->withToken(session('access_token'))
        //     ->get(config('app.api_url') . 'exportpembelianbarang/export', $detailParams);

        // $pengeluaran = $responses['data'];
        // $user = Auth::user();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'LAPORAN PEMBELIAN BARANG BULAN '. $monthName.' - '.$yearNum);
        $sheet->getStyle("A1")->getFont()->setSize(20)->setBold(true);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal('center');
        $sheet->mergeCells('A1:J3');

        $header_start_row = 4;
        $detail_start_row = 5;

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
                'label' => 'No',
                'index' => 'no',
            ],
            [
                'label' => 'No Bukti',
                'index' => 'nobukti',
            ],
            [
                'label' => 'Tanggal',
                'index' => 'tglbukti',
            ],
            [
                'label' => 'Nama Stock',
                'index' => 'namastok',
            ],
            [
                'label' => 'QTY',
                'index' => 'qty',
            ],
            [
                'label' => 'Satuan',
                'index' => 'satuan',
            ],
            [
                'label' => 'Harga',
                'index' => 'harga',
            ],
            [
                'label' => 'Nominal',
                'index' => 'nominal',
            ],
            [
                'label' => 'Keterangan',
                'index' => 'keterangan',
            ],
            [
                'label' => 'Keterangan Header',
                'index' => 'keteranganheader',
            ],
        ];

        foreach ($header_columns as $data_columns_index => $data_column) {
            $sheet->setCellValue($alphabets[$data_columns_index] . $header_start_row, $data_column['label'] ?? $data_columns_index + 1);
        }
        
        $lastColumn = $alphabets[$data_columns_index];
        $sheet->getStyle("A$header_start_row:$lastColumn$header_start_row")->getFont()->setBold(true);
        
        // LOOPING DETAIL
        // $no=1;
        // $totalNominal = 0;
        // foreach ($pengeluaran as $response_index => $response_detail) {

        //     $alphabets = range('A', 'Z');
        //     foreach ($header_columns as $data_columns_index => $data_column) {
        //         if($data_column['index'] == 'no'){
                    
        //             $sheet->setCellValue($alphabets[$data_columns_index] . $detail_start_row, $no++);
        //             $sheet->getColumnDimension($alphabets[$data_columns_index])->setAutoSize(true);
        //         }else{

        //             $sheet->setCellValue($alphabets[$data_columns_index] . $detail_start_row, $response_detail[$data_column['index']]);
        //             $sheet->getColumnDimension($alphabets[$data_columns_index])->setAutoSize(true);
        //         }
        //     }
            
        //     $totalNominal += $response_detail['nominal'];
        //     $detail_start_row++;
        // }
        // $sheet->mergeCells('A' . $detail_start_row . ':H' . $detail_start_row);
        // $sheet->setCellValue("A$detail_start_row", 'Total')->getStyle('A' . $detail_start_row . ':H' . $detail_start_row)->getFont()->setBold(true);
        // $sheet->setCellValue("I$detail_start_row", number_format((float) $totalNominal, '2', ',', '.'))->getStyle("I$detail_start_row")->applyFromArray($style_number)->getFont()->setBold(true);

        $sheet->getColumnDimension('A')->setAutoSize(true);
        $sheet->getColumnDimension('B')->setAutoSize(true);
        $sheet->getColumnDimension('C')->setAutoSize(true);
        $sheet->getColumnDimension('D')->setAutoSize(true);
        $sheet->getColumnDimension('E')->setAutoSize(true);
        $sheet->getColumnDimension('F')->setAutoSize(true);



        $writer = new Xlsx($spreadsheet);
        $filename = 'PEMBELIANBARANG' . date('dmYHis');
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }

    public function getBulan($bln){
        switch ($bln){
         case 1:
          return "JANUARI";
          break;
         case 2:
          return "FEBRUARI";
          break;
         case 3:
          return "MARET";
          break;
         case 4:
          return "APRIL";
          break;
         case 5:
          return "MEI";
          break;
         case 6:
          return "JUNI";
          break;
         case 7:
          return "JULI";
          break;
         case 8:
          return "AGUSTUS";
          break;
         case 9:
          return "SEPTEMBER";
          break;
         case 10:
          return "OKTOBER";
          break;
         case 11:
          return "NOVEMBER";
          break;
         case 12:
          return "DESEMBER";
          break;
        }
       }
}

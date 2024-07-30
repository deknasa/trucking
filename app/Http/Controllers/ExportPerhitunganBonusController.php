<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Calculation\DateTimeExcel\Date;

class ExportPerhitunganBonusController extends MyController
{
    public $title = 'Export Perhitungan Bonus';

    public function index(Request $request)
    {
        $title = $this->title;
      
        return view('exportperhitunganbonus.index', compact('title'));
    }
    
    public function export(Request $request): void
    {
        $detailParams = [
            'periode' => $request->periode,
            'tahun' => $request->tahun,
            'cabang_id' => $request->cabang_id,
        ];

        $responses = Http::withHeaders($request->header())
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'exportperhitunganbonus/export', $detailParams);

            
            // dd($responses);
            // dd($responses['data']);
        $bukubesar = $responses['data'];
        
        if(count($bukubesar) == 0){
            throw new \Exception('TIDAK ADA DATA');
        }
        $dataheader = $responses['dataheader'];
        $judul = $responses['judul'];
        $user = Auth::user();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', $bukubesar[0]['cmpyname']);
        $sheet->getStyle("A1")->getFont()->setSize(16)->setBold(true);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal('center');
        $sheet->mergeCells('A1:D1');

        $sheet->setCellValue('A2', $judul);
        $sheet->getStyle("A2")->getFont()->setBold(true);

        // $sheet->setCellValue('A1', $judul);
        // $sheet->getStyle("A1")->getFont()->setSize(20)->setBold(true);
        // $sheet->getStyle('A1')->getAlignment()->setHorizontal('center');
        // $sheet->mergeCells('A1:D1');

   

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

        $style_number2 = [
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT,
            ],

          
        ];

        $alphabets = range('A', 'Z');

        $detail_columns = [
            
            [
                'label' => 'Perkiraan',
                'index' => 'perkiraan',
            ],
            [
                'label' => 'bulankesatu',
                'index' => 'bulankesatu',
            ],
            [
                'label' => 'bulankedua',
                'index' => 'bulankedua',
            ],
            [
                'label' => 'bulanketiga',
                'index' => 'bulanketiga',
            ],
            
        ];


        foreach ($detail_columns as $detail_columns_index => $detail_column) {
            $sheet->setCellValue($alphabets[$detail_columns_index] . $detail_start_row, $dataheader[$detail_column['index']]);
            $sheet->getStyle($alphabets[$detail_columns_index] . $detail_start_row)->getFont()->setBold(true);

        }
        $detail_start_row++;
        $barisawalsumpendapatan=$detail_start_row;
        $ftype='';
        $fketparent='';
        $hitbeban=0;
        foreach ($bukubesar as $response_index => $response_detail) {

            if (($response_detail['ftype'] =='BEBAN') && ($response_detail['fketparent'] != $fketparent) && ($hitbeban != 0)) {
                $detail_start_row=$detail_start_row+1;
                $sheet->setCellValue("a$detail_start_row", $response_detail['fketparent'])->getStyle("a$detail_start_row")->getFont()->setBold(true);
                $detail_start_row++;
            }
            $sheet->setCellValue("a$detail_start_row", $response_detail['fketcoa']);

            $sheet->setCellValue("b$detail_start_row",$response_detail['nominal1']);
            $sheet->setCellValue("c$detail_start_row",$response_detail['nominal2']);
            $sheet->setCellValue("d$detail_start_row",$response_detail['nominal3']);
            $sheet->getStyle('b' . $detail_start_row)->getNumberFormat()->setFormatCode("#,##0.00_);(#,##0.00)");            
            $sheet->getStyle('c' . $detail_start_row)->getNumberFormat()->setFormatCode("#,##0.00_);(#,##0.00)");            
            $sheet->getStyle('d' . $detail_start_row)->getNumberFormat()->setFormatCode("#,##0.00_);(#,##0.00)");  
            if (($response_detail['ftype'] != $ftype)  && ($ftype=='PENDAPATAN')){
                // $test="=SUM(b" . ($barisawalsumpendapatan) . ":b" . ($detail_start_row - 1) . ")";
                $sheet->setCellValue("a$detail_start_row", 'TOTAL PENDAPATAN')->getStyle("a$detail_start_row")->getFont()->setBold(true);;
                $barispendapatan=$detail_start_row;
                $sheet->setCellValue("b$detail_start_row", "=SUM(b" . ($barisawalsumpendapatan) . ":b" . ($detail_start_row - 1) . ")")->getStyle("b$detail_start_row")->getFont()->setBold(true);
                $sheet->setCellValue("c$detail_start_row", "=SUM(c" . ($barisawalsumpendapatan) . ":c" . ($detail_start_row - 1) . ")")->getStyle("c$detail_start_row")->getFont()->setBold(true);
                $sheet->setCellValue("d$detail_start_row", "=SUM(d" . ($barisawalsumpendapatan) . ":d" . ($detail_start_row - 1) . ")")->getStyle("d$detail_start_row")->getFont()->setBold(true);
                $sheet->getStyle('b' . $detail_start_row)->getNumberFormat()->setFormatCode("#,##0.00_);(#,##0.00)");            
                $sheet->getStyle('c' . $detail_start_row)->getNumberFormat()->setFormatCode("#,##0.00_);(#,##0.00)");            
                $sheet->getStyle('d' . $detail_start_row)->getNumberFormat()->setFormatCode("#,##0.00_);(#,##0.00)");            
                    $detail_start_row=$detail_start_row+2;
            }
            if (($response_detail['ftype'] != $ftype)  && ($response_detail['ftype'] =='BEBAN')){
                $hitbeban=0;
                $barisawalsumbiaya=$detail_start_row;
                $sheet->setCellValue("a$detail_start_row", $response_detail['ketmain'])->getStyle("a$detail_start_row")->getFont()->setBold(true);;
                $detail_start_row++;
                $sheet->setCellValue("a$detail_start_row", $response_detail['fketparent'])->getStyle("a$detail_start_row")->getFont()->setBold(true);;
                $detail_start_row++;                
                $sheet->setCellValue("a$detail_start_row", $response_detail['fketcoa']);

                $sheet->setCellValue("b$detail_start_row",$response_detail['nominal1']);
                $sheet->setCellValue("c$detail_start_row",$response_detail['nominal2']);
                $sheet->setCellValue("d$detail_start_row",$response_detail['nominal3']);
    
            }

            if ($response_detail['ftype'] =='BEBAN') {
                $hitbeban=$hitbeban+1;
            }


            // $sheet->getStyle("A$detail_start_row:D$detail_start_row")->applyFromArray($styleArray);
            $sheet->getStyle("B$detail_start_row:D$detail_start_row")->applyFromArray($style_number2);
            $sheet->getStyle('b' . $detail_start_row)->getNumberFormat()->setFormatCode("#,##0.00_);(#,##0.00)");            
            $sheet->getStyle('c' . $detail_start_row)->getNumberFormat()->setFormatCode("#,##0.00_);(#,##0.00)");            
            $sheet->getStyle('d' . $detail_start_row)->getNumberFormat()->setFormatCode("#,##0.00_);(#,##0.00)");            
            $detail_start_row++;
            $ftype=$response_detail['ftype'];
            $fketparent=$response_detail['fketparent'];
        }  
        $detail_start_row++;
        $barisbiaya=$detail_start_row;

        $sheet->setCellValue("a$detail_start_row", 'TOTAL BIAYA')->getStyle("a$detail_start_row")->getFont()->setBold(true);;
        $sheet->setCellValue("b$detail_start_row", "=SUM(b" . ($barisawalsumbiaya) . ":b" . ($detail_start_row - 1) . ")")->getStyle("b$detail_start_row")->getFont()->setBold(true);
        $sheet->setCellValue("c$detail_start_row", "=SUM(c" . ($barisawalsumbiaya) . ":c" . ($detail_start_row - 1) . ")")->getStyle("c$detail_start_row")->getFont()->setBold(true);
        $sheet->setCellValue("d$detail_start_row", "=SUM(d" . ($barisawalsumbiaya) . ":d" . ($detail_start_row - 1) . ")")->getStyle("d$detail_start_row")->getFont()->setBold(true);
        $sheet->getStyle('b' . $detail_start_row)->getNumberFormat()->setFormatCode("#,##0.00_);(#,##0.00)");            
        $sheet->getStyle('c' . $detail_start_row)->getNumberFormat()->setFormatCode("#,##0.00_);(#,##0.00)");            
        $sheet->getStyle('d' . $detail_start_row)->getNumberFormat()->setFormatCode("#,##0.00_);(#,##0.00)");            

        $detail_start_row++;
        $sheet->setCellValue("a$detail_start_row", 'LABA/RUGI BERSIH')->getStyle("a$detail_start_row");
        $sheet->setCellValue("b$detail_start_row", "=(b" . ($barispendapatan) . "-b" . ($barisbiaya) . ")");
        $sheet->setCellValue("c$detail_start_row", "=(c" . ($barispendapatan) . "-c" . ($barisbiaya) . ")");
        $sheet->setCellValue("d$detail_start_row", "=(d" . ($barispendapatan) . "-d" . ($barisbiaya) . ")");
        $sheet->getStyle('b' . $detail_start_row)->getNumberFormat()->setFormatCode("#,##0.00_);(#,##0.00)");            
        $sheet->getStyle('c' . $detail_start_row)->getNumberFormat()->setFormatCode("#,##0.00_);(#,##0.00)");            
        $sheet->getStyle('d' . $detail_start_row)->getNumberFormat()->setFormatCode("#,##0.00_);(#,##0.00)");            

        $detail_start_row++;
        $sheet->setCellValue("a$detail_start_row", 'BONUS KARYAWAN (3%)')->getStyle("a$detail_start_row");
        $sheet->setCellValue("b$detail_start_row", "=(b" . ($detail_start_row-1) . "*0.03)");
        $sheet->setCellValue("c$detail_start_row", "=(c" . ($detail_start_row-1) . "*0.03)");
        $sheet->setCellValue("d$detail_start_row", "=(d" . ($detail_start_row-1) . "*0.03)");
        $sheet->getStyle('b' . $detail_start_row)->getNumberFormat()->setFormatCode("#,##0.00_);(#,##0.00)");            
        $sheet->getStyle('c' . $detail_start_row)->getNumberFormat()->setFormatCode("#,##0.00_);(#,##0.00)");            
        $sheet->getStyle('d' . $detail_start_row)->getNumberFormat()->setFormatCode("#,##0.00_);(#,##0.00)");            

        $detail_start_row++;
        $sheet->setCellValue("a$detail_start_row", 'TOTAL')->getStyle("a$detail_start_row");
        $sheet->setCellValue("b$detail_start_row", "=(b" . ($detail_start_row-1) . "+c" . ($detail_start_row-1) . "+d" . ($detail_start_row-1) . ")");
        $sheet->getStyle('b' . $detail_start_row)->getNumberFormat()->setFormatCode("#,##0.00_);(#,##0.00)");            

        $detail_start_row++;
        $sheet->setCellValue("a$detail_start_row", 'KANTOR PUSAT (10%)')->getStyle("a$detail_start_row");
        $sheet->setCellValue("b$detail_start_row", "=(b" . ($detail_start_row-1) . "*0.1)");
        $sheet->getStyle('b' . $detail_start_row)->getNumberFormat()->setFormatCode("#,##0.00_);(#,##0.00)");            

        // $sheet->mergeCells('A' . $detail_start_row . ':C' . $detail_start_row);
        // $sheet->setCellValue("A$detail_start_row", 'Total')->getStyle('A' . $detail_start_row . ':C' . $detail_start_row)->applyFromArray($styleArray)->getFont()->setBold(true);
        // $sheet->setCellValue("D$detail_start_row", number_format((float) $totalDebet, '2', ',', '.'))->getStyle("D$detail_start_row")->applyFromArray($style_number)->getFont()->setBold(true);
        // $sheet->setCellValue("E$detail_start_row", number_format((float) $totalKredit, '2', ',', '.'))->getStyle("E$detail_start_row")->applyFromArray($style_number)->getFont()->setBold(true);
        // $sheet->setCellValue("F$detail_start_row", number_format((float) $totalSaldo, '2', ',', '.'))->getStyle("F$detail_start_row")->applyFromArray($style_number)->getFont()->setBold(true);
        // if (is_array($bukubesar)) {
        //     // dd($groupedData)
        //     foreach ($groupedData as $coa => $group) {
        //         $sheet->mergeCells("A$detail_start_row:F$detail_start_row");
        //         $sheet->setCellValue("A$detail_start_row", 'Kode Perkiraan : ' . $coa . ' (' . $group[0]['keterangancoa'] . ')')->getStyle('A' . $detail_start_row . ':F' . $detail_start_row);
        //         // $sheet->getStyle("A$detail_start_row")->getFont()->setSize(12)->setBold(true);
        //         // $sheet->getStyle("A$detail_start_row")->getAlignment()->setHorizontal('center');
        //         $detail_start_row++;

        //         // table header
        //         foreach ($detail_columns as $detail_columns_index => $detail_column) {
        //             $sheet->setCellValue($alphabets[$detail_columns_index] . $detail_start_row, $detail_column['label'] ?? $detail_columns_index + 1);
        //         }
        //         $sheet->getStyle("A$detail_start_row:F$detail_start_row")->getFont()->setBold(true);
        //         $detail_start_row++;


        //         $dataRow = $detail_table_header_row + 2;
        //         $previousRow = $dataRow - 1;
        //         foreach ($group as $response_index => $response_detail) {
        //             // ... (your existing code for filling in details)
        //             $dateValue = ($response_detail['tglbukti'] != null) ? Date::PHPToExcel(date('Y-m-d', strtotime($response_detail['tglbukti']))) : '';

        //             $sheet->setCellValue("A$detail_start_row", $dateValue);
        //             $sheet->setCellValue("B$detail_start_row", ($response_detail['nobukti'] == '') ? $response_detail['keterangan'] : $response_detail['nobukti']);
        //             $sheet->setCellValue("C$detail_start_row", ($response_detail['keterangan'] == 'SALDO AWAL') ? '' : $response_detail['keterangan']);
        //             $sheet->setCellValue("D$detail_start_row", ($response_detail['keterangan'] == 'SALDO AWAL') ? 0 : $response_detail['debet']);
        //             $sheet->setCellValue("E$detail_start_row", ($response_detail['keterangan'] == 'SALDO AWAL') ? 0 : $response_detail['kredit']);

        //             if ($response_detail['nobukti'] == '') {
        //                 $sheet->setCellValue('F' . $detail_start_row, $response_detail['Saldo']);
        //                 $previousRow = $detail_start_row;
        //             } else {
        //                 if ($detail_start_row > $detail_table_header_row + 1) {
        //                     $sheet->setCellValue('F' . $detail_start_row, '=(F' . $previousRow . '+D' . $detail_start_row . ')-E' . $detail_start_row);
        //                 }
        //             }
        //             // $sheet->setCellValue("F$detail_start_row", $response_detail['Saldo']);
        //             // $sheet->getStyle("C$detail_start_row")->getAlignment()->setWrapText(true);
        //             // $sheet->getColumnDimension('C')->setWidth(150);
        //             $sheet->getStyle("A$detail_start_row")->getNumberFormat()->setFormatCode('dd-mm-yyyy');
        //             $sheet->getStyle("D$detail_start_row:F$detail_start_row")->getNumberFormat()->setFormatCode("#,##0.00_);(#,##0.00)");
        //             $totalKredit += $response_detail['kredit'];
        //             $totalDebet += $response_detail['debet'];
        //             $totalSaldo += $response_detail['Saldo'];
        //             $previousRow = $detail_start_row;
        //             $detail_start_row++;
        //             $prevKeteranganCoa = $response_detail['keterangancoa'];
        //         }
        //         // Display the group totals at the end of the group
        //         // $sheet->mergeCells('A' . $detail_start_row . ':C' . $detail_start_row);
        //         $sheet->setCellValue("C$detail_start_row", 'Total')->getStyle('C' . $detail_start_row)->getFont()->setBold(true);
        //         $sheet->setCellValue("D$detail_start_row", "=SUM(D" . ($detail_start_row - count($group)) . ":D" . ($detail_start_row - 1) . ")")->getStyle("D$detail_start_row")->getFont()->setBold(true);
        //         $sheet->setCellValue("E$detail_start_row", "=SUM(E" . ($detail_start_row - count($group)) . ":E" . ($detail_start_row - 1) . ")")->getStyle("E$detail_start_row")->getFont()->setBold(true);
        //         // $sheet->setCellValue("F$detail_start_row", "=F" . ($detail_start_row - 1))->getStyle("F$detail_start_row")->applyFromArray($style_number)->getFont()->setBold(true);

        //         $sheet->getStyle("D$detail_start_row:F$detail_start_row")->getNumberFormat()->setFormatCode("#,##0.00_);(#,##0.00)");
        //         $detail_start_row += 2; // Add an empty row between groups
        //     }
        // }

        // $ttd_start_row = $detail_start_row + 2;
        // $sheet->setCellValue("A$ttd_start_row", 'Disetujui Oleh,');
        // $sheet->setCellValue("C$ttd_start_row", 'Diperiksa Oleh,');
        // $sheet->setCellValue("F$ttd_start_row", 'Disusun Oleh,');

        // $sheet->setCellValue("A" . ($ttd_start_row + 3), '(                )');
        // $sheet->setCellValue("C" . ($ttd_start_row + 3), '(                )');
        // $sheet->setCellValue("F" . ($ttd_start_row + 3), '(                )');

        $sheet->getColumnDimension('A')->setWidth(30);
        $sheet->getColumnDimension('B')->setAutoSize(true);
        $sheet->getColumnDimension('C')->setAutoSize(true);
        $sheet->getColumnDimension('D')->setAutoSize(true);



        $writer = new Xlsx($spreadsheet);
        $filename = 'Perhitungan Bonus ' . date('dmYHis');
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }
}

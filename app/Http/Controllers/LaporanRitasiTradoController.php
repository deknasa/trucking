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


class LaporanRitasiTradoController extends MyController
{
    public $title = 'Export Laporan Ritasi Trado';

    public function index(Request $request)
    {
        $title = $this->title;
        $data = [
            'pagename' => 'Menu Utama Export Laporan Ritasi Trado',
        ];

        return view('laporanritasitrado.index', compact('title'));
    }

    public function export(Request $request): void
    {
        $detailParams = [
            'periode' => $request->periode,
        ];
        date_default_timezone_set("Asia/Jakarta");
        // dd($detailParams);
        $monthNum  = intval(substr($request->periode, 0, 2));
        $yearNum  = substr($request->periode,3);
        $monthName = $this->getBulan($monthNum);
        // dd($detailParams);
        $responses = Http::withHeaders($request->header())
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'laporanritasitrado/export', $detailParams);

        $pengeluaran = $responses['data'];
        $user = Auth::user();
        // dd($pengeluaran);
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'Laporan Ritasi Trado : '. $monthName.' - '.$yearNum);

        $rowIndex = 4;
        foreach ($pengeluaran as $data) {
            $noPol = $data['nopol']; // Ganti 'no_pol' dengan indeks yang sesuai
            $tgl1 = $data['1'];
            $tgl2 = $data['2'];
            $tgl3 = $data['3'];
            $tgl4 = $data['4'];
            $tgl5 = $data['5'];
            $tgl6 = $data['6'];
            $tgl7 = $data['7'];
            $tgl8 = $data['8'];
            $tgl9 = $data['9'];
            $tgl10 = $data['10'];
            $tgl11 = $data['11'];
            $tgl12 = $data['12'];
            $tgl13 = $data['13'];
            $tgl14 = $data['14'];
            $tgl15 = $data['15'];
            $tgl16 = $data['16'];
            $tgl17 = $data['17'];
            $tgl18 = $data['18'];
            $tgl19 = $data['19'];
            $tgl20 = $data['20'];
            $tgl21 = $data['21'];
            $tgl22 = $data['22'];
            $tgl23 = $data['23'];
            $tgl24 = $data['24'];
            $tgl25 = $data['25'];
            $tgl26 = $data['26'];
            $tgl27 = $data['27'];
            $tgl28 = $data['28'];
            
            $sheet->setCellValue('A'.$rowIndex, $noPol);
            $sheet->setCellValue('B'.$rowIndex, $tgl1);
            $sheet->setCellValue('C'.$rowIndex, $tgl2);
            $sheet->setCellValue('D'.$rowIndex, $tgl3);
            $sheet->setCellValue('E'.$rowIndex, $tgl4);
            $sheet->setCellValue('F'.$rowIndex, $tgl5);
            $sheet->setCellValue('G'.$rowIndex, $tgl6);
            $sheet->setCellValue('H'.$rowIndex, $tgl7);
            $sheet->setCellValue('I'.$rowIndex, $tgl8);
            $sheet->setCellValue('J'.$rowIndex, $tgl9);
            $sheet->setCellValue('K'.$rowIndex, $tgl10);
            $sheet->setCellValue('L'.$rowIndex, $tgl11);
            $sheet->setCellValue('M'.$rowIndex, $tgl12);
            $sheet->setCellValue('N'.$rowIndex, $tgl13);
            $sheet->setCellValue('O'.$rowIndex, $tgl14);
            $sheet->setCellValue('P'.$rowIndex, $tgl15);
            $sheet->setCellValue('Q'.$rowIndex, $tgl16);
            $sheet->setCellValue('R'.$rowIndex, $tgl17);
            $sheet->setCellValue('S'.$rowIndex, $tgl18);
            $sheet->setCellValue('T'.$rowIndex, $tgl19);
            $sheet->setCellValue('U'.$rowIndex, $tgl20);
            $sheet->setCellValue('V'.$rowIndex, $tgl21);
            $sheet->setCellValue('W'.$rowIndex, $tgl22);
            $sheet->setCellValue('X'.$rowIndex, $tgl23);
            $sheet->setCellValue('Y'.$rowIndex, $tgl24);
            $sheet->setCellValue('Z'.$rowIndex, $tgl25);
            $sheet->setCellValue('AA'.$rowIndex, $tgl26);
            $sheet->setCellValue('AB'.$rowIndex, $tgl27);
            $sheet->setCellValue('AC'.$rowIndex, $tgl28);
            $rowIndex++;
        }
        
        $sheet->setCellValue('A3', 'No Pol');
        $sheet->setCellValue('B3', '1');
        $sheet->setCellValue('C3', '2');
        $sheet->setCellValue('D3', '3');
        $sheet->setCellValue('E3', '4');
        $sheet->setCellValue('F3', '5');
        $sheet->setCellValue('G3', '6');
        $sheet->setCellValue('H3', '7');
        $sheet->setCellValue('I3', '8');
        $sheet->setCellValue('J3', '9');
        $sheet->setCellValue('K3', '10');
        $sheet->setCellValue('L3', '11');
        $sheet->setCellValue('M3', '12');
        $sheet->setCellValue('N3', '13');
        $sheet->setCellValue('O3', '14');
        $sheet->setCellValue('P3', '15');
        $sheet->setCellValue('Q3', '16');
        $sheet->setCellValue('R3', '17');
        $sheet->setCellValue('S3', '18');
        $sheet->setCellValue('T3', '19');
        $sheet->setCellValue('U3', '20');
        $sheet->setCellValue('V3', '21');
        $sheet->setCellValue('W3', '22');
        $sheet->setCellValue('X3', '23');
        $sheet->setCellValue('Y3', '24');
        $sheet->setCellValue('Z3', '25');
        $sheet->setCellValue('AA3','26');
        $sheet->setCellValue('AB3', '27');
        $sheet->setCellValue('AC3', '28');
        // $sheet->setCellValue('AD3', '29');
        // $sheet->setCellValue('AE3', '30');
        // $sheet->setCellValue('AF3', '31');
        $sheet->setCellValue('AD3', 'Total');
        // Melanjutkan untuk kolom lainnya
        
       
      
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
        $sheet->getColumnDimension('K')->setAutoSize(true);
        $sheet->getColumnDimension('L')->setAutoSize(true);
        $sheet->getColumnDimension('M')->setAutoSize(true);
        $sheet->getColumnDimension('N')->setAutoSize(true);
        $sheet->getColumnDimension('O')->setAutoSize(true);
        $sheet->getColumnDimension('P')->setAutoSize(true);
        $sheet->getColumnDimension('Q')->setAutoSize(true);
        $sheet->getColumnDimension('R')->setAutoSize(true);
        $sheet->getColumnDimension('S')->setAutoSize(true);
        $sheet->getColumnDimension('T')->setAutoSize(true);
        $sheet->getColumnDimension('U')->setAutoSize(true);
        $sheet->getColumnDimension('V')->setAutoSize(true);
        $sheet->getColumnDimension('W')->setAutoSize(true);
        $sheet->getColumnDimension('X')->setAutoSize(true);
        $sheet->getColumnDimension('Y')->setAutoSize(true);
        $sheet->getColumnDimension('Z')->setAutoSize(true);
        $sheet->getColumnDimension('AA')->setAutoSize(true);
        $sheet->getColumnDimension('AB')->setAutoSize(true);
        $sheet->getColumnDimension('AC')->setAutoSize(true);
        $sheet->getColumnDimension('AD')->setAutoSize(true);
  

        $cellRange = 'A3:AD3';
       


        //NOTE GRAND TOTAL
        $sheet->setCellValue("A" . ($rowIndex), 'Grand Total');
        // $sheet->setCellValue("A" . ($rowIndex + 1), 'Keterangan Lain');
        $cellFooter = "A" . $rowIndex . ":AD" . $rowIndex;
        $sheet->setCellValue("B" . ($rowIndex), "=SUM(B4:B" . $rowIndex . ")");
        $sheet->setCellValue("C" . ($rowIndex), "=SUM(C4:C" . $rowIndex . ")");
        $sheet->setCellValue("D" . ($rowIndex), "=SUM(D4:D" . $rowIndex . ")");
        $sheet->setCellValue("E" . ($rowIndex), "=SUM(E4:E" . $rowIndex . ")");
        $sheet->setCellValue("F" . ($rowIndex), "=SUM(F4:F" . $rowIndex . ")");
        $sheet->setCellValue("G" . ($rowIndex), "=SUM(G4:G" . $rowIndex . ")");
        $sheet->setCellValue("H" . ($rowIndex), "=SUM(H4:H" . $rowIndex . ")");
        $sheet->setCellValue("I" . ($rowIndex), "=SUM(I4:I" . $rowIndex . ")");
        $sheet->setCellValue("J" . ($rowIndex), "=SUM(J4:J" . $rowIndex . ")");
        $sheet->setCellValue("K" . ($rowIndex), "=SUM(K4:K" . $rowIndex . ")");
        $sheet->setCellValue("L" . ($rowIndex), "=SUM(L4:L" . $rowIndex . ")");
        $sheet->setCellValue("M" . ($rowIndex), "=SUM(M4:M" . $rowIndex . ")");
        $sheet->setCellValue("N" . ($rowIndex), "=SUM(N4:N" . $rowIndex . ")");
        $sheet->setCellValue("O" . ($rowIndex), "=SUM(O4:O" . $rowIndex . ")");
        $sheet->setCellValue("P" . ($rowIndex), "=SUM(P4:P" . $rowIndex . ")");
        $sheet->setCellValue("Q" . ($rowIndex), "=SUM(Q4:Q" . $rowIndex . ")");
        $sheet->setCellValue("R" . ($rowIndex), "=SUM(R4:R" . $rowIndex . ")");
        $sheet->setCellValue("S" . ($rowIndex), "=SUM(S4:S" . $rowIndex . ")");
        $sheet->setCellValue("T" . ($rowIndex), "=SUM(T4:T" . $rowIndex . ")");
        $sheet->setCellValue("U" . ($rowIndex), "=SUM(U4:U" . $rowIndex . ")");
        $sheet->setCellValue("V" . ($rowIndex), "=SUM(V4:V" . $rowIndex . ")");
        $sheet->setCellValue("W" . ($rowIndex), "=SUM(W4:W" . $rowIndex . ")");
        $sheet->setCellValue("X" . ($rowIndex), "=SUM(X4:X" . $rowIndex . ")");
        $sheet->setCellValue("Y" . ($rowIndex), "=SUM(Y4:Y" . $rowIndex . ")");
        $sheet->setCellValue("Z" . ($rowIndex), "=SUM(Z4:Z" . $rowIndex . ")");
        $sheet->setCellValue("AA" . ($rowIndex), "=SUM(AA4:AA" . $rowIndex . ")");
        $sheet->setCellValue("AB" . ($rowIndex), "=SUM(AB4:AB" . $rowIndex . ")");
        $sheet->setCellValue("AC" . ($rowIndex), "=SUM(AC4:AC" . $rowIndex . ")");





$styleArray = [
    'fill' => [
        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
        'color' => [
            'rgb' => 'FFFF00', // Warna kuning (kode RGB)
        ],
    ],
    'borders' => [
        'allBorders' => [
            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
            'color' => ['rgb' => '000000'], // Warna border (kode RGB)
        ],
    ],
    'alignment' => [
        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
        'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
    ],
];


$styleBody = [
    'borders' => [
        'allBorders' => [
            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
            'color' => ['rgb' => '000000'], // Warna border (kode RGB)
        ],
    ],
    'alignment' => [
        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
        'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
    ],
];
        $sheet->getStyle($cellRange)->applyFromArray($styleArray);
        $sheet->getStyle($cellFooter)->applyFromArray($styleArray);

        $cellBody = "B4:"."B".$rowIndex;
        $sheet->getStyle($cellBody)->applyFromArray($styleBody);
        $cellBody = "C4:" . "C" . $rowIndex;
        $sheet->getStyle($cellBody)->applyFromArray($styleBody);
        $cellBody = "D4:"."D".$rowIndex;
        $sheet->getStyle($cellBody)->applyFromArray($styleBody);
        $cellBody = "E4:" . "E" . $rowIndex;
        $sheet->getStyle($cellBody)->applyFromArray($styleBody);
        $cellBody = "F4:"."F".$rowIndex;
        $sheet->getStyle($cellBody)->applyFromArray($styleBody);
        $cellBody = "G4:" . "G" . $rowIndex;
        $sheet->getStyle($cellBody)->applyFromArray($styleBody);
        $cellBody = "H4:"."H".$rowIndex;
        $sheet->getStyle($cellBody)->applyFromArray($styleBody);
        $cellBody = "I4:" . "I" . $rowIndex;
        $sheet->getStyle($cellBody)->applyFromArray($styleBody);
        $cellBody = "J4:"."J".$rowIndex;
        $sheet->getStyle($cellBody)->applyFromArray($styleBody);
        $cellBody = "K4:" . "K" . $rowIndex;
        $sheet->getStyle($cellBody)->applyFromArray($styleBody);
        $cellBody = "L4:"."L".$rowIndex;
        $sheet->getStyle($cellBody)->applyFromArray($styleBody);
        $cellBody = "M4:" . "M" . $rowIndex;
        $sheet->getStyle($cellBody)->applyFromArray($styleBody);
        $cellBody = "N4:" . "N" . $rowIndex;
        $sheet->getStyle($cellBody)->applyFromArray($styleBody);
        $cellBody = "O4:" . "O" . $rowIndex;
        $sheet->getStyle($cellBody)->applyFromArray($styleBody);
        $cellBody = "P4:" . "P" . $rowIndex;
        $sheet->getStyle($cellBody)->applyFromArray($styleBody);
        $cellBody = "Q4:" . "Q" . $rowIndex;
        $sheet->getStyle($cellBody)->applyFromArray($styleBody);
        $cellBody = "R4:" . "R" . $rowIndex;
        $sheet->getStyle($cellBody)->applyFromArray($styleBody);
        $cellBody = "S4:" . "S" . $rowIndex;
        $sheet->getStyle($cellBody)->applyFromArray($styleBody);
        $cellBody = "T4:" . "T" . $rowIndex;
        $sheet->getStyle($cellBody)->applyFromArray($styleBody);
        $cellBody = "U4:" . "U" . $rowIndex;
        $sheet->getStyle($cellBody)->applyFromArray($styleBody);
        $cellBody = "V4:" . "V" . $rowIndex;
        $sheet->getStyle($cellBody)->applyFromArray($styleBody);
        $cellBody = "W4:" . "W" . $rowIndex;
        $sheet->getStyle($cellBody)->applyFromArray($styleBody);
        $cellBody = "X4:" . "X" . $rowIndex;
        $sheet->getStyle($cellBody)->applyFromArray($styleBody);
        $cellBody = "Y4:" . "Y" . $rowIndex;
        $sheet->getStyle($cellBody)->applyFromArray($styleBody);
        $cellBody = "Z4:" . "Z" . $rowIndex;
        $sheet->getStyle($cellBody)->applyFromArray($styleBody);
        $cellBody = "AA4:" . "AA" . $rowIndex;
        $sheet->getStyle($cellBody)->applyFromArray($styleBody);
        $cellBody = "AB4:" . "AB" . $rowIndex;
        $sheet->getStyle($cellBody)->applyFromArray($styleBody);
        $cellBody = "AC4:" . "AC" . $rowIndex;
        $sheet->getStyle($cellBody)->applyFromArray($styleBody);
        $cellBody = "AD4:" . "AD" . $rowIndex;
        $sheet->getStyle($cellBody)->applyFromArray($styleBody);


        
        
        

        $writer = new Xlsx($spreadsheet);
        $filename = 'LAPORANRITASITRADO' . date('dmYHis');
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

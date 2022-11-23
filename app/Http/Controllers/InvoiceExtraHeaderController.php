<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class InvoiceExtraHeaderController extends MyController
{
    public $title = 'Invoice Extra';
    
    public function index()
    {

        $title = $this->title;
        return view('invoiceextraheader.index', compact('title'));
    }
    public function get($params = [])
    {
        $params = [
            'offset' => $params['offset'] ?? request()->offset ?? ((request()->page - 1) * request()->rows),
            'limit' => $params['rows'] ?? request()->rows ?? 0,
            'sortIndex' => $params['sidx'] ?? request()->sidx,
            'sortOrder' => $params['sord'] ?? request()->sord,
            'search' => json_decode($params['filters'] ?? request()->filters, 1) ?? [],
            'withRelations' => $params['withRelations'] ?? request()->withRelations ?? false,
        ];

        $response = Http::withHeaders(request()->header())
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'invoiceextraheader', $params);

        $data = [
            'total' => $response['attributes']['totalPages'] ?? [],
            'records' => $response['attributes']['totalRows'] ?? [],
            'rows' => $response['data'] ?? [],
            'params' => $response['params'] ?? [],
        ];

        return $data;
    }

    public function find($params,$id)
    {
        $params = [
            'offset' => $params['offset'] ?? request()->offset ?? ((request()->page - 1) * request()->rows),
            'limit' => $params['rows'] ?? request()->rows ?? 0,
            'sortIndex' => $params['sidx'] ?? request()->sidx,
            'sortOrder' => $params['sord'] ?? request()->sord,
            'search' => json_decode($params['filters'] ?? request()->filters, 1) ?? [],
            'withRelations' => $params['withRelations'] ?? request()->withRelations ?? false,
        ];
        return $response = Http::withHeaders(request()->header())
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'invoiceextraheader/'.$id);
    }

    /**
     * @ClassName
     */
    public function report(Request $request,$id)
    {
        $params = [
            'offset' => $request->dari - 1,
            'rows' => $request->sampai - $request->dari + 1,
            'withRelations' => true,

        ];
        $invoicceextra = $this->find($params,$id)['data'];

        $data = $invoicceextra;
        $i =0;
        
        $response = Http::withHeaders($this->httpHeaders)
        ->withOptions(['verify' => false])
        ->withToken(session('access_token'))
        ->get(config('app.api_url') . 'invoiceextradetail', ['invoiceextra_id' => $invoicceextra['id']]);

        $data["details"] =$response['data'];
        $data["user"] = Auth::user();
     
        
        $invoiceextraheaders = $data;
        return view('reports.invoiceextraheader', compact('invoiceextraheaders'));
    }

    public function export(Request $request)
    {
        $params = [
            'offset' => $request->dari - 1,
            'rows' => $request->sampai - $request->dari + 1,
            'withRelations' => true,

        ];

        // return $this->get($params);
        $invoiceExtras = $this->get($params)['rows'];
        $data = [];
        $i =0;
        foreach ($invoiceExtras as $invoiceExtras) {
            $data[$i] =$invoiceExtras;
           $response = Http::withHeaders($this->httpHeaders)
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'invoiceextradetail', [$request->all()]);


            $data[$i]["details"] =$response ['data'];
            $i++;
        }
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'Laporan Invoice Extra');
        $sheet->getStyle("A1")->getFont()->setSize(20);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal('center');
        $sheet->mergeCells('A1:D1');

        $header_start_row = 2;
        $detail_table_header_row = 7;
        $detail_start_row = $detail_table_header_row + 1;

        $alphabets = range('A', 'Z');
        $header_columns = [
            [
                'label'=>'No Bukti',
                'index'=>'nobukti'
            ],
            
            [
                'label'=>'Tgl Bukti',
                'index'=>'tglbukti'
            ],
            
            [
                'label'=>'Pelanggan',
                'index'=>'pelanggan'
            ],
            [
                'label'=>'Agen',
                'index'=>'agen'
            ],
            
            [
                'label'=>'Nominal',
                'index'=>'nominal'
            ],
            [
                'label'=>'Keterangan',
                'index'=>'keterangan'
            ],
           
            
        ];
        $detail_columns = [
            [
                'label'=>'NO',
            ],
            [
                'label'=>'No Bukti',
                'index'=>'nobukti'
            ],
            [
                'label'=>'Keterangan',
                'index'=>'keterangan'
            ],
            [
                'label'=>'nominal',
                'index'=>'nominal'
            ],
            
        ];

        for ($i = 0; $i < count($data); $i++) {
            foreach ($header_columns as $header_column) {
                $sheet->setCellValue('A' . $header_start_row, $header_column['label']);
                $sheet->setCellValue('B' . $header_start_row, ':');
                $sheet->setCellValue('C' . $header_start_row++, $data[$i][$header_column['index']]);
            }

            $header_start_row += count($data[$i]['details']) + 1;

            foreach ($detail_columns as $detail_columns_index => $detail_column) {
                $sheet->setCellValue($alphabets[$detail_columns_index] . $detail_table_header_row, $detail_column['label'] ?? $detail_columns_index + 1);
            }

            $sheet->getStyle("A$detail_table_header_row:D$detail_table_header_row")->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('FF02c4f5');

            foreach ($data[$i]['details'] as $detail_index => $detail_data) {
                foreach ($detail_columns as $detail_columns_index => $detail_column) {
                    $sheet->setCellValue($alphabets[$detail_columns_index] . $detail_start_row, isset($detail_column['index']) ? $detail_data[$detail_column['index']] : $detail_index + 1);
                }
                $sheet->setCellValue("A$detail_start_row", $detail_index + 1);
                $sheet->setCellValue("B$detail_start_row", $detail_data['nobukti']);
                $sheet->setCellValue("C$detail_start_row", $detail_data['keterangan']);
                $sheet->setCellValue("D$detail_start_row", $detail_data['nominal']);

                $detail_start_row++;
            }

            $detail_table_header_row += (7 + count($data[$i]['details']) );
            $detail_start_row = $detail_table_header_row + 1;
        }

        $sheet->getColumnDimension('A')->setAutoSize(true);
        $sheet->getColumnDimension('B')->setAutoSize(true);
        $sheet->getColumnDimension('C')->setAutoSize(true);
        $sheet->getColumnDimension('D')->setAutoSize(true);

        $styleArray = array(
            'borders' => array(
                'allBorders' => array(
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ),
            ),
        );

        $writer = new Xlsx($spreadsheet);
        $filename = 'Laporaninvoicceextra' . date('dmYHis');

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }
}

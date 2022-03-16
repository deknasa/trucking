<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use stdClass;

class UserAclController extends MyController
{
    public $title = 'User Acl';

   /**
     * @ClassName index
     */    
    public function index(Request $request)
    {
       
        $title = $this->title;
        $data = [
            'pagename' => 'Menu Utama User Acl',
        ];

        return view('useracl.index', compact('title', 'data'));

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
                ->get(config('app.api_url') . 'useracl', $params);

            $data = [
                'total' => $response['attributes']['totalPages'] ?? [],
                'records' => $response['attributes']['totalRows'] ?? [],
                'rows' => $response['data'] ?? []
            ];


            return $data;
        

    }

    public function detail(Request $request)
    {

        if ($request->ajax()) {
            $params = [
                'offset' => (($request->page - 1) * $request->rows),
                'limit' => $request->rows,
                'sortIndex' => $request->sidx,
                'sortOrder' => $request->sord,
                'search' => json_decode($request->filters, 1) ?? [],
                'user_id' => $request->user_id,

            ];

            // dump(config('app.api_url') . 'useracl/detail');
            // dd($params);

            $response = Http::withHeaders($request->header())
                ->get(config('app.api_url') . 'useracl/detail', $params);

            $data = [
                'total' => $response['attributes']['totalPages'] ?? [],
                'records' => $response['attributes']['totalRows'] ?? [],
                'rows' => $response['data'] ?? []
            ];


            return response($data);
        }

    
    }

   /**
     * Fungsi create
     * @ClassName create
     */    
    public function create(Request $request)
    {
        $title = $this->title;
        $list = [
            'detail' => $this->detaillist($request->user_id  ?? '0'),
        ];
        $data['combo'] = $this->combo('entry');

        $user_id='0';
        //   dd($data);
        return view('useracl.add', compact('title','list','user_id', 'data'));
    }

    public function store(Request $request)
    {

        
        $request['modifiedby']=Auth::user()->name;

        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ])->post(config('app.api_url') . 'useracl', $request->all());

        
        
        return response($response);
    }

   /**
     * Fungsi edit
     * @ClassName edit
     */    
    public function edit($id)
    {
        $title = $this->title;

        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Content-Type' => 'application/json'
        ])->get(config('app.api_url') . "useracl/$id");

        $useracl = $response['data'];
        $list = [
            'detail' => $this->detaillist($useracl['user_id']  ?? '0'),
        ];
        $data['combo'] = $this->combo('entry');

        $user_id=$useracl['user_id'];
        return view('useracl.edit', compact('title', 'useracl','list','user_id','data'));
    }

    public function update(Request $request, $id)
    {
        $request['modifiedby']=Auth::user()->name;
        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ])->patch(config('app.api_url') . "useracl/$id", $request->all());

        return response($response);
    }

   /**
     * Fungsi delete
     * @ClassName delete
     */       
    public function delete($id)
    {
        try {
            $title = $this->title;

            $response = Http::withHeaders([
                'Accept' => 'application/json',
                'Content-Type' => 'application/json'
            ])->get(config('app.api_url') . "useracl/$id");

            
            $useracl = $response['data'];
            $list = [
                'detail' => $this->detaillist($useracl['user_id']  ?? '0'),
            ];
            $data['combo'] = $this->combo('entry');

            $user_id=$useracl['user_id'];
            
        
           
            return view('useracl.delete', compact('title', 'useracl','list','user_id','data'));
        } catch (\Throwable $th) {
            return redirect()->route('useracl.index');
        }
    }

    public function destroy($id,Request $request)
    {
        $request['modifiedby']=Auth::user()->name;
        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Content-Type' => 'application/json'
        ])->delete(config('app.api_url') . "useracl/$id", $request->all());

        

        return response($response);
        
    }

    public function fieldLength()
    {
        $response = Http::withHeaders($this->httpHeaders)->get(config('app.api_url') . 'useracl/field_length');

        return response($response['data']);
    }

    public function detaillist($user_id)
    {
        $status = [
            'user_id' => $user_id,
        ];
        $response = Http::get(config('app.api_url') . 'useracl/detaillist', $status);
        return $response['data'];
        

    
    }
    
    public function combo($aksi)
    {

        $status = [
            'status' => $aksi,
            'grp' => 'STATUS AKTIF',
            'subgrp' => 'STATUS AKTIF',
        ];

        $response = Http::withHeaders($this->httpHeaders)
            ->get(config('app.api_url') . 'useracl/combostatus', $status);

        return $response['data'];
    }

    public function report(Request $request): View
    {
        $request->offset = $request->dari - 1;
        $request->rows = $request->sampai;

        $parameters = $this->get($request)['rows'];

        return view('reports.parameter', compact('parameters'));
    }

    public function export(): void
    {
        $parameters = $this->get();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'Laporan Parameter');
        $sheet->getStyle("A1")->getFont()->setSize(20);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal('center');
        $sheet->mergeCells('A1:E1');

        $sheet->setCellValue('A2', 'No');
        $sheet->setCellValue('B2', 'ID');
        $sheet->setCellValue('C2', 'Group');
        $sheet->setCellValue('D2', 'Sub Group');
        $sheet->setCellValue('E2', 'Nama Parameter');
        $sheet->setCellValue('F2', 'Memo');
        $sheet->setCellValue('G2', 'ModifiedBy');
        $sheet->setCellValue('H2', 'ModifiedOn');

        $sheet->getColumnDimension('C')->setAutoSize(true);
        $sheet->getColumnDimension('D')->setAutoSize(true);
        $sheet->getColumnDimension('E')->setAutoSize(true);
        $sheet->getColumnDimension('F')->setAutoSize(true);
        $sheet->getColumnDimension('G')->setAutoSize(true);
        $sheet->getColumnDimension('H')->setAutoSize(true);

        $no = 1;
        $x = 3;
        foreach ($parameters['rows'] as $row) {
            $sheet->setCellValue('A' . $x, $no++);
            $sheet->setCellValue('B' . $x, $row['id']);
            $sheet->setCellValue('C' . $x, $row['grp']);
            $sheet->setCellValue('D' . $x, $row['subgrp']);
            $sheet->setCellValue('E' . $x, $row['text']);
            $sheet->setCellValue('F' . $x, $row['memo']);
            $sheet->setCellValue('G' . $x, $row['modifiedby']);
            $sheet->setCellValue('H' . $x,  date("d-m-Y H:i:s", strtotime($row['updated_at'])));
            $lastCell = 'H' . $x;
            $x++;
        }

        $sheet->setCellValue('E' . $x, "=ROWS(E3:" . $lastCell . ")");

        $styleArray = array(
            'borders' => array(
                'allBorders' => array(
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ),
            ),
        );

        $sheet->getStyle('A2:H2')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('FF02c4f5');
        $sheet->getStyle('A2:' . $lastCell)->applyFromArray($styleArray);

        $writer = new Xlsx($spreadsheet);
        $filename = 'laporanParameter' . date('dmYHis');

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }


}

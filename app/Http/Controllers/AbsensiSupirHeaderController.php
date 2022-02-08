<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class AbsensiSupirHeaderController extends Controller
{
    public $title = 'Absensi';

    public $httpHeaders = [
        'Accept' => 'application/json',
        'Content-Type' => 'application/json'
    ];

    /**
     * Fungsi index
     * @ClassName index
     */
    public function index(Request $request)
    {
        $title = $this->title;

        return view('absensi.index', compact('title'));
    }

    public function get($params = null)
    {
        $params = [
            'offset' => $params->offset ?? request()->offset ?? ((request()->page - 1) * request()->rows),
            'limit' => $params->rows ?? request()->rows ?? 0,
            'sortIndex' => $params->sidx ?? request()->sidx,
            'sortOrder' => $params->sord ?? request()->sord,
            'search' => json_decode($params->filters ?? request()->filters, 1) ?? [],
            'withRelations' => $params->withRelations ?? request()->withRelations ?? false,
        ];

        $response = Http::withHeaders(request()->header())
            ->get('http://localhost/trucking-laravel/public/api/absensi', $params);

        $data = [
            'total' => $response['attributes']['totalPages'] ?? [],
            'records' => $response['attributes']['totalRows'] ?? [],
            'rows' => $response['data'] ?? [],
            'params' => $response['params'] ?? [],
        ];

        return $data;
    }

    /**
     * Fungsi create
     * @ClassName create
     */
    public function create()
    {
        $title = $this->title;

        $noBukti = $this->getNoBukti('ABSENSI', 'ABSENSI', 'absensisupirheader');
        $kasGantungNoBukti = $this->getNoBukti('ABSENSI', 'ABSENSI', 'absensisupirheader');

        $combo = [
            'trado' => $this->getTrado(),
            'supir' => $this->getSupir(),
            'status' => $this->getStatus(),
        ];

        return view('absensi.add', compact('title', 'noBukti', 'combo', 'kasGantungNoBukti'));
    }

    public function store(Request $request)
    {
        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ])->post(config('app.api_url') . 'absensi', $request->all());

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
        ])->get(config('app.api_url') . "absensi/$id");

        $absensi = $response['data'];
        $combo = [
            'trado' => $this->getTrado(),
            'supir' => $this->getSupir(),
            'status' => $this->getStatus(),
        ];

        return view('absensi.edit', compact('title', 'absensi', 'combo'));
    }

    public function update(Request $request, $id)
    {
        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ])->patch(config('app.api_url') . "absensi/$id", $request->all());

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
            ])->get(config('app.api_url') . "absensi/$id");

            $absensi = $response['data'];
            $combo = [
                'trado' => $this->getTrado(),
                'supir' => $this->getSupir(),
                'status' => $this->getStatus(),
            ];

            return view('absensi.delete', compact('title', 'combo', 'absensi'));
        } catch (\Throwable $th) {
            return redirect()->route('absensi.index');
        }
    }

    public function destroy($id)
    {
        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Content-Type' => 'application/json'
        ])->delete(config('app.api_url') . "absensi/$id");

        return response($response);
    }

    public function getTrado()
    {
        $response = Http::get(config('app.api_url') . 'trado');

        return $response['data'];
    }

    public function getSupir()
    {
        $response = Http::get(config('app.api_url') . 'supir');

        return $response['data'];
    }

    public function getStatus()
    {
        $response = Http::get(config('app.api_url') . 'absentrado');

        return $response['data'];
    }

    public function getNoBukti($group, $subgroup, $table)
    {
        $params = [
            'group' => $group,
            'subgroup' => $subgroup,
            'table' => $table
        ];

        $response = Http::withHeaders($this->httpHeaders)
            ->get(config('app.api_url') . "absensi/running_number", $params);

        $noBukti = $response['data'] ?? 'No bukti tidak ditemukan';

        return $noBukti;
    }

    public function report(Request $request): View
    {
        $request->offset = $request->dari - 1;
        $request->rows = $request->sampai;

        $absensis = $this->get($request);

        foreach ($absensis as &$absensi) {
            foreach ($absensi['absensi_supir_detail'] as &$absensi_supir_detail) {
                $absensi_supir_detail['trado'] = $absensi_supir_detail['trado']['nama'] ?? '';
                $absensi_supir_detail['supir'] = $absensi_supir_detail['supir']['namasupir'] ?? '';
                $absensi_supir_detail['status'] = $absensi_supir_detail['absen_trado']['keterangan'] ?? '';
            }
        }

        return view('reports.absensi', compact('absensis'));
    }

    public function export(): void
    {
        $absensis = $this->get();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'Laporan Absensi');
        $sheet->getStyle("A1")->getFont()->setSize(20);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal('center');
        $sheet->mergeCells('A1:E1');

        $sheet->setCellValue('A2', 'No');
        $sheet->setCellValue('B2', 'ID');
        $sheet->setCellValue('C2', 'Group');
        $sheet->setCellValue('D2', 'Sub Group');
        $sheet->setCellValue('E2', 'Nama Absensi');
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
        foreach ($absensis['rows'] as $row) {
            $sheet->setCellValue('A' . $x, $no++);
            $sheet->setCellValue('B' . $x, $row['id']);
            $sheet->setCellValue('C' . $x, $row['nobukti']);
            $sheet->setCellValue('D' . $x, $row['tgl']);
            $sheet->setCellValue('E' . $x, $row['keterangan']);
            $sheet->setCellValue('F' . $x, $row['kasgantung_nobukti']);
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
        $filename = 'laporanAbsensi' . date('dmYHis');

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }
}

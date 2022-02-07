<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

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
        if ($request->ajax()) {
            $params = [
                'offset' => (($request->page - 1) * $request->rows),
                'limit' => $request->rows,
                'sortIndex' => $request->sidx,
                'sortOrder' => $request->sord,
                'search' => json_decode($request->filters, 1) ?? [],
            ];

            $response = Http::withHeaders($request->header())
                ->get(config('app.api_url') . 'absensi', $params);

            $data = [
                'total' => $response['attributes']['totalPages'],
                'records' => $response['attributes']['totalRows'],
                'rows' => $response['data']
            ];

            return response($data);
        }

        $title = $this->title;

        return view('absensi.index', compact('title'));
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
}

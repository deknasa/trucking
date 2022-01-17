<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AbsensiSupirHeaderController extends Controller
{
    public $title = 'Absensi';

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
                ->get('http://localhost/trucking-laravel/public/api/absensi', $params);

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
    
    public function create()
    {
        $title = $this->title;

        $combo = [
            'trado' => $this->getTrado(),
            'supir' => $this->getSupir(),
            'status' => $this->getStatus(),
        ];

        return view('absensi.add', compact('title', 'combo'));
    }

    public function store(Request $request)
    {
        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ])->post('http://localhost/trucking-laravel/public/api/absensi', $request->all());

        return response($response);
    }

    public function edit($id)
    {
        $title = $this->title;

        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Content-Type' => 'application/json'
        ])->get("http://localhost/trucking-laravel/public/api/absensi/$id");

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
        ])->patch("http://localhost/trucking-laravel/public/api/absensi/$id", $request->all());

        return response($response);
    }
    
    public function delete($id)
    {
        try {
            $title = $this->title;

            $response = Http::withHeaders([
                'Accept' => 'application/json',
                'Content-Type' => 'application/json'
            ])->get("http://localhost/trucking-laravel/public/api/absensi/$id");

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
        ])->delete("http://localhost/trucking-laravel/public/api/absensi/$id");

        return response($response);
    }
    
    public function getTrado() {
        $response = Http::get('http://localhost/trucking-laravel/public/api/trado');

        return $response['data'];
    }

    public function getSupir() {
        $response = Http::get('http://localhost/trucking-laravel/public/api/supir');

        return $response['data'];
    }

    public function getStatus() {
        $response = Http::get('http://localhost/trucking-laravel/public/api/absentrado');

        return $response['data'];
    }
}

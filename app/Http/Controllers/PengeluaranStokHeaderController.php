<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class PengeluaranStokHeaderController extends MyController
{
    public $title = 'Pengeluaran Stok Header';

    public function index(Request $request)
    {
        $title = $this->title;

        return view('pengeluaranstokheader.index', compact('title'));
    }

    public function create()
    {
        $title = $this->title;

        $combo = $this->combo();

        return view('pengeluaranstokheader.add', compact('title','combo'));
    }

    public function store(Request $request)
    {
        try {
            $request['modifiedby'] = Auth::user()->name;

            $response = Http::withHeaders($this->httpHeaders)
                ->withOptions(['verify' => false])
                ->withToken(session('access_token'))
                ->post(config('app.api_url') . 'pengeluaranstokheader', $request->all());


            return response($response, $response->status());
        } catch (\Throwable $th) {
            throw $th->getMessage();
        }
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
            ->get(config('app.api_url') . 'pengeluaranstokheader', $params);

        $data = [
            'total' => $response['attributes']['totalPages'] ?? [],
            'records' => $response['attributes']['totalRows'] ?? [],
            'rows' => $response['data'] ?? [],
            'params' => $response['params'] ?? [],
        ];

        return $data;
    }

    public function edit($id)
    {
        $title = $this->title;

        $response = Http::withHeaders($this->httpHeaders)
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . "pengeluaranstokheader/$id");
            // dd($response->getBody()->getContents());

        $pengeluaranstokheader = $response['data'];
        $kode = $response['kode'];

        if($kode == 'PJT'){
            $pengeluaranstokheaderNoBukti = $this->getNoBukti('PINJAMAN SUPIR', 'PINJAMAN SUPIR', 'pengeluaranstokheader');
        }else{
            $pengeluaranstokheaderNoBukti = $this->getNoBukti('BIAYA LAIN SUPIR', 'BIAYA LAIN SUPIR', 'pengeluaranstokheader');
        }


        $combo = $this->combo();

        return view('pengeluaranstokheader.edit', compact('title', 'pengeluaranstokheader','combo', 'pengeluaranstokheaderNoBukti'));
    }

    public function update(Request $request, $id)
    {
        /* Unformat nominal */
        $request->nominal = array_map(function ($nominal) {
            $nominal = str_replace('.', '', $nominal);
            $nominal = str_replace(',', '', $nominal);

            return $nominal;
        }, $request->nominal);

        $request->merge([
            'nominal' => $request->nominal
        ]);

        $request['modifiedby'] = Auth::user()->name;

        $response = Http::withHeaders($this->httpHeaders)
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->patch(config('app.api_url') . "pengeluaranstokheader/$id", $request->all());

        return response($response);
    }

    public function delete($id)
    {
        try {
            $title = $this->title;

            $response = Http::withHeaders($this->httpHeaders)
                ->withOptions(['verify' => false])
                ->withToken(session('access_token'))
                ->get(config('app.api_url') . "pengeluaranstokheader/$id");

            $pengeluaranstokheader = $response['data'];
            
            $combo = $this->combo();

            return view('pengeluaranstokheader.delete', compact('title','combo', 'pengeluaranstokheader'));
        } catch (\Throwable $th) {
            return redirect()->route('pengeluaranstokheader.index');
        }
    }

    public function destroy($id)
    {
        $request['modifiedby'] = Auth::user()->name;
        $response = Http::withHeaders($this->httpHeaders)
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->delete(config('app.api_url') . "pengeluaranstokheader/$id");

            
        return response($response);
    }

    public function getNoBukti($group, $subgroup, $table)
    {
        $params = [
            'group' => $group,
            'subgroup' => $subgroup,
            'table' => $table
        ];

        $response = Http::withHeaders($this->httpHeaders)
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . "running_number", $params);

        $noBukti = $response['data'] ?? 'No bukti tidak ditemukan';

        return $noBukti;
    }

    private function combo()
    {
        $response = Http::withHeaders($this->httpHeaders)
        ->withToken(session('access_token'))
        ->withOptions(['verify' => false])
            ->get(config('app.api_url') . 'pengeluaranstokheader/combo');

        return $response['data'];
    }
}

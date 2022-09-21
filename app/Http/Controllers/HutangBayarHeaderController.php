<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class HutangBayarHeaderController extends MyController
{
    public $title = 'Pembayaran Hutang';

    public function index(Request $request)
    {
        $title = $this->title;
        return view('hutangbayarheader.index', compact('title'));
    }

    public function create()
    {
        $title = $this->title;

        $combo = $this->combo();

        return view('hutangbayarheader.add', compact('title','combo'));
    }

    public function store(Request $request)
    {
        try {
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
                ->post(config('app.api_url') . 'hutangbayarheader', $request->all());


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
            ->get(config('app.api_url') . 'hutangbayarheader', $params);

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
            ->get(config('app.api_url') . "hutangbayarheader/$id");
            // dd($response->getBody()->getContents());

        $hutangbayarheader = $response['data'];
        $kode = $response['kode'];

        // if($kode == 'PJT'){
        //     $pengeluarantruckingheaderNoBukti = $this->getNoBukti('PINJAMAN SUPIR', 'PINJAMAN SUPIR', 'pengeluarantruckingheader');
        // }else{
        //     $pengeluarantruckingheaderNoBukti = $this->getNoBukti('BIAYA LAIN SUPIR', 'BIAYA LAIN SUPIR', 'pengeluarantruckingheader');
        // }
        // return view('hutangbayarheader.edit', compact('title', 'hutangbayarheader','combo', 'hutangbayarheaderNoBukti'));


        $combo = $this->combo();

        return view('hutangbayarheader.edit', compact('title', 'hutangbayarheader','combo'));
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
            ->patch(config('app.api_url') . "hutangbayarheader/$id", $request->all());

        return response($response);
    }

    public function delete($id)
    {
        try {
            $title = $this->title;

            $response = Http::withHeaders($this->httpHeaders)
                ->withOptions(['verify' => false])
                ->withToken(session('access_token'))
                ->get(config('app.api_url') . "hutangbayarheader/$id");

            $hutangbayarheader = $response['data'];
            
            $combo = $this->combo();

            return view('hutangbayarheader.delete', compact('title','combo', 'hutangbayarheader'));
        } catch (\Throwable $th) {
            return redirect()->route('hutangbayarheader.index');
        }
    }

    public function destroy($id)
    {
        $request['modifiedby'] = Auth::user()->name;
        $response = Http::withHeaders($this->httpHeaders)
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->delete(config('app.api_url') . "hutangbayarheader/$id");

            
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
            ->get(config('app.api_url') . 'hutangbayarheader/combo');

        return $response['data'];
    }

    
}

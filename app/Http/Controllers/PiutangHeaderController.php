<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class PiutangHeaderController extends MyController
{
    public $title = 'Piutang';

    public function index(){
        $title = $this->title;
        return view('piutang.index', compact('title'));
    }

    public function create(){
        $title = $this->title;

        return view('piutang.add', compact('title'));
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

            $request->nominal_detail = array_map(function ($nominal_detail) {
                $nominal_detail = str_replace('.', '', $nominal_detail);
                $nominal_detail = str_replace(',', '', $nominal_detail);

                return $nominal_detail;
            }, $request->nominal_detail);

            $request->merge([
                'nominal' => $request->nominal,
                'nominal_detail' => $request->nominal_detail,
            ]);

            $request['modifiedby'] = Auth::user()->name;

            $response = Http::withHeaders($this->httpHeaders)
                ->withOptions(['verify' => false])
                ->withToken(session('access_token'))
                ->post(config('app.api_url') . 'piutang', $request->all());


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
            ->get(config('app.api_url') . 'piutang', $params);

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
            ->get(config('app.api_url') . "piutang/$id");
            // dd($response->getBody()->getContents());

        $piutang = $response['data'];
        $piutangNoBukti = $this->getNoBukti('PIUTANG', 'PIUTANG', 'piutangheader');


        return view('piutang.edit', compact('title', 'piutang', 'piutangNoBukti'));
    }

    public function update(Request $request, $id)
    {
        /* Unformat nominal */
        $request->nominal = array_map(function ($nominal) {
            $nominal = str_replace('.', '', $nominal);
            $nominal = str_replace(',', '', $nominal);

            return $nominal;
        }, $request->nominal);

        /* Unformat nominal detail*/
        $request->nominal_detail = array_map(function ($nominal_detail) {
            $nominal_detail = str_replace('.', '', $nominal_detail);
            $nominal_detail = str_replace(',', '', $nominal_detail);

            return $nominal_detail;
        }, $request->nominal_detail);

        $request->merge([
            'nominal' => $request->nominal,
            'nominal_detail' => $request->nominal_detail
        ]);

        $request['modifiedby'] = Auth::user()->name;

        $response = Http::withHeaders($this->httpHeaders)
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->patch(config('app.api_url') . "piutang/$id", $request->all());

        return response($response);
    }

    public function delete($id)
    {
        try {
            $title = $this->title;

            $response = Http::withHeaders($this->httpHeaders)
                ->withOptions(['verify' => false])
                ->withToken(session('access_token'))
                ->get(config('app.api_url') . "piutang/$id");

            $piutang = $response['data'];
            

            return view('piutang.delete', compact('title', 'piutang'));
        } catch (\Throwable $th) {
            return redirect()->route('piutang.index');
        }
    }

    public function destroy($id)
    {
        $request['modifiedby'] = Auth::user()->name;
        $response = Http::withHeaders($this->httpHeaders)
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->delete(config('app.api_url') . "piutang/$id");

            
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

}
   
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class JurnalUmumHeaderController extends MyController
{
    public $title = 'Jurnal Umum';
    
    public function index(Request $request)
    {
        $title = $this->title;
        
        return view('jurnalumum.index', compact('title'));
    }

    
    public function store(Request $request)
    {
        try {
             /* Unformat nominal */
            $request->nominal_detail = array_map(function ($nominal) {
                $nominal = str_replace('.', '', $nominal);
                $nominal = str_replace(',', '', $nominal);

                return $nominal;
            }, $request->nominal_detail);

            $request->merge([
                'nominal' => $request->nominal_detail
            ]);

            $request['modifiedby'] = Auth::user()->name;

            $response = Http::withHeaders($this->httpHeaders)
                ->withOptions(['verify' => false])
                ->withToken(session('access_token'))
                ->post(config('app.api_url') . 'jurnalumumheader', $request->all());


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
            ->get(config('app.api_url') . 'jurnalumumheader', $params);

        $data = [
            'total' => $response['attributes']['totalPages'] ?? [],
            'records' => $response['attributes']['totalRows'] ?? [],
            'rows' => $response['data'] ?? [],
            'params' => $response['params'] ?? [],
        ];

        return $data;
    }
    
    
    public function create()
    {
        $title = $this->title;

        $combo = $this->combo();

        return view('jurnalumum.add', compact('title','combo'));
    }

    
    public function edit($id)
    {
        $title = $this->title;

        $response = Http::withHeaders($this->httpHeaders)
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . "jurnalumumheader/$id");
            // dd($response->getBody()->getContents());

        $jurnalumum = $response['data'];
        $detail = $response['detail'];
        $jurnalNoBukti = $this->getNoBukti('JURNAL UMUM', 'JURNAL UMUM', 'jurnalumumheader');

        $combo = $this->combo();

        return view('jurnalumum.edit', compact('title', 'jurnalumum','combo','detail', 'jurnalNoBukti'));
    }

    
    public function update(Request $request, $id)
    {
        /* Unformat nominal */
        $request->nominal_detail = array_map(function ($nominal) {
            $nominal = str_replace('.', '', $nominal);
            $nominal = str_replace(',', '', $nominal);

            return $nominal;
        }, $request->nominal_detail);

        $request->merge([
            'nominal' => $request->nominal_detail
        ]);

        $request['modifiedby'] = Auth::user()->name;

        $response = Http::withHeaders($this->httpHeaders)
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->patch(config('app.api_url') . "jurnalumumheader/$id", $request->all());

        return response($response);
    }

    
    
    public function delete($id)
    {
        try {
            $title = $this->title;

            $response = Http::withHeaders($this->httpHeaders)
                ->withOptions(['verify' => false])
                ->withToken(session('access_token'))
                ->get(config('app.api_url') . "jurnalumumheader/$id");

            $jurnalumum = $response['data'];
            $detail = $response['detail'];
            
            $combo = $this->combo();

            return view('jurnalumum.delete', compact('title','combo', 'jurnalumum', 'detail'));
        } catch (\Throwable $th) {
            return redirect()->route('jurnalumum.index');
        }
    }

    
    
    public function destroy($id)
    {
        $request['modifiedby'] = Auth::user()->name;
        $response = Http::withHeaders($this->httpHeaders)
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->delete(config('app.api_url') . "jurnalumumheader/$id");

            
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
            ->get(config('app.api_url') . 'jurnalumumheader/combo');

        return $response['data'];
    }

}
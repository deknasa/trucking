<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class GajiSupirHeaderController extends MyController
{
    public $title = 'Rincian Gaji Supir';
    
    public function index(Request $request)
    {
        $title = $this->title;
        return view('gajisupirheader.index', compact('title'));
    }

    // public function create()
    // {
    //     $title = $this->title;

    //     $combo = $this->combo();

    //     return view('gajisupirheader.add', compact('title','combo'));
    // }

    public function store(Request $request)
    {
        try {
            $request['modifiedby'] = Auth::user()->name;

            $response = Http::withHeaders($this->httpHeaders)
                ->withOptions(['verify' => false])
                ->withToken(session('access_token'))
                ->post(config('app.api_url') . 'gajisupirheader', $request->all());


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
            ->get(config('app.api_url') . 'gajisupirheader', $params);

        $data = [
            'total' => $response['attributes']['totalPages'] ?? [],
            'records' => $response['attributes']['totalRows'] ?? [],
            'rows' => $response['data'] ?? [],
            'params' => $response['params'] ?? [],
        ];

        return $data;
    }

    // public function edit($id)
    // {
    //     $title = $this->title;

    //     $response = Http::withHeaders($this->httpHeaders)
    //         ->withOptions(['verify' => false])
    //         ->withToken(session('access_token'))
    //         ->get(config('app.api_url') . "gajisupirheader/$id");
    //         // dd($response->getBody()->getContents());

    //     $gajisupirheader = $response['data'];
        

    //     $combo = $this->combo();

    //     return view('gajisupirheader.edit', compact('title', 'gajisupirheader','combo'));
    // }

    public function update(Request $request, $id)
    {
        

        $request['modifiedby'] = Auth::user()->name;

        $response = Http::withHeaders($this->httpHeaders)
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->patch(config('app.api_url') . "gajisupirheader/$id", $request->all());

        return response($response);
    }

    // public function delete($id)
    // {
    //     try {
    //         $title = $this->title;

    //         $response = Http::withHeaders($this->httpHeaders)
    //             ->withOptions(['verify' => false])
    //             ->withToken(session('access_token'))
    //             ->get(config('app.api_url') . "gajisupirheader/$id");

    //         $gajisupirheader = $response['data'];
            
    //         $combo = $this->combo();

    //         return view('gajisupirheader.delete', compact('title','combo', 'gajisupirheader'));
    //     } catch (\Throwable $th) {
    //         return redirect()->route('gajisupirheader.index');
    //     }
    // }

    public function destroy($id)
    {
        $request['modifiedby'] = Auth::user()->name;
        $response = Http::withHeaders($this->httpHeaders)
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->delete(config('app.api_url') . "gajisupirheader/$id");

            
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
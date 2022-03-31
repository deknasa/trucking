<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class TradoController extends Controller
{
    public $title = 'Trado';

    public $httpHeaders = [
        'Accept' => 'application/json',
        'Content-Type' => 'application/json'
    ];

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
                ->get(config('app.api_url') . 'api/trado', $params);

            $rows = $response['data'];

            foreach($response['data'] as $key => $item) {
                $arrtrado   = json_decode($item['phototrado']);
                $arrstnk    = json_decode($item['photostnk']);
                $arrbpkb    = json_decode($item['photobpkb']);

                $imgtrado='';
                if (!empty($arrtrado)) {
                    $count = count($arrtrado);
                    if ($count > 0) {
                        $total = $count / 3;
                        $idx=2;
                        for ($i=0; $i < $total; $i++) {
                            if ($i>0){
                                $idx+=3;
                            }

                            $imgtrado .= "<img src='".config('app.api_url').'uploads/trado/'.$arrtrado[$idx]."' class='mr-2'>";
                        }
                    }
                }

                $imgbpkb='';
                if (!empty($arrbpkb)) {
                    $count = count($arrbpkb);
                    if ($count > 0) {
                        $total = $count / 3;
                        $idx=2;
                        for ($i=0; $i < $total; $i++) {
                            if ($i>0){
                                $idx+=3;
                            }

                            $imgbpkb .= "<img src='".config('app.api_url').'uploads/bpkb/'.$arrbpkb[$idx]."' class='mr-2'>";
                        }
                    }
                }

                $imgstnk='';
                if (!empty($arrstnk)) {
                    $count = count($arrstnk);
                    if ($count > 0) {
                        $total = $count / 3;
                        $idx=2;
                        for ($i=0; $i < $total; $i++) {
                            if ($i>0){
                                $idx+=3;
                            }

                            $imgstnk .= "<img src='".config('app.api_url').'uploads/stnk/'.$arrstnk[$idx]."' class='mr-2'>";
                        }
                    }
                }

                $rows[$key]['phototrado']   = $imgtrado;
                $rows[$key]['photobpkb']    = $imgbpkb;
                $rows[$key]['photostnk']    = $imgstnk;
            }

            $data = [
                'total' => $response['attributes']['totalPages'],
                'records' => $response['attributes']['totalRows'],
                'rows' => $rows
            ];

            return response($data);
        }

        $title = $this->title;

        return view('trado.index', compact('title'));
    }


    public function create()
    {
        $title = $this->title;
        $combo = $this->combo();
        
        return view('trado.add', compact('title','combo'));
    }

    public function store(Request $request)
    {
        $response = Http::withHeaders($this->httpHeaders)->withOptions(['verify' => false]);

        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ])->post(config('app.api_url') . 'api/trado', $request->all());

        if ($response->ok()) {
            $id = $response['data']['id'];
            $res = Http::withToken(ENV('API_KEY'));
            if($request->files) {
                foreach ($request->files as $key=> $files) {
                    if ($request->hasFile($key)) {
                        foreach($files as $k => $file) {
                            $fileName = $file->getClientOriginalName();
                            $res = $res->attach($key.'[]', file_get_contents($file),$fileName);
                        }
                    }
                }
                $res = $res->post(config('app.api_url') . 'api/trado/upload_image/'.$id);
            }
            return response($res);
        } else {
            return response($response);
        }
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $title = $this->title;

        $response = Http::withHeaders($this->httpHeaders)->withOptions(['verify' => false])->get(config('app.api_url') . "api/trado/$id");

        $trado = $response['data'];

        $combo = $this->combo();

        return view('trado.edit', compact('title', 'trado', 'combo'));
    }

    public function update(Request $request, $id)
    {
        $response = Http::withHeaders($this->httpHeaders)->withOptions(['verify' => false])->patch(config('app.api_url') . "api/trado/$id", $request->all());

        if ($response->ok()) {
            $id = $response['data']['id'];
            $res = Http::withToken(ENV('API_KEY'));
            if($request->files) {
                foreach ($request->files as $key=> $files) {
                    if ($request->hasFile($key)) {
                        foreach($files as $k => $file) {
                            $fileName = $file->getClientOriginalName();
                            $res = $res->attach($key.'[]', file_get_contents($file),$fileName);
                        }
                    }
                }
                $res = $res->post(config('app.api_url') . 'api/trado/upload_image/'.$id,[
                    'name' => 'g_all',
                    'contents' => $request['g_all']
                ]);
            }
            return response($res);
        } else {
            return response($response);
        }
    }

    public function delete($id)
    {
        try {
            $title = $this->title;

            $response = Http::withHeaders($this->httpHeaders)->withOptions(['verify' => false])
            ->get(config('app.api_url') . "api/trado/$id");

            $trado = $response['data'];

            $combo = $this->combo();

            return view('trado.delete', compact('title', 'trado', 'combo'));
        } catch (\Throwable $th) {
            return redirect()->route('trado.index');
        }
    }

    public function destroy($id, Request $request)
    {
        $response = Http::withHeaders($this->httpHeaders)->withOptions(['verify' => false])
        ->delete(config('app.api_url') . "api/trado/$id", $request->all());

        return response($response);
    }

    public function fieldLength()
    {
        $response = Http::withHeaders($this->httpHeaders)->withOptions(['verify' => false])->get(config('app.api_url') . 'api/trado/field_length');

        return response($response['data']);
    }


    private function combo()
    {
        $response = Http::withHeaders($this->httpHeaders)->withOptions(['verify' => false])
            ->get(config('app.api_url') . 'api/trado/combo');
        
        return $response['data'];
    }
}

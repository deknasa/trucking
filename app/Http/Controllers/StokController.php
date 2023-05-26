<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class StokController  extends MyController
{
    public $title = 'Stok';

    public function index(Request $request)
    {
        $title = $this->title;

        return view('stok.index', compact('title'));
    }

    public function report(Request $request)
    {
        $response = Http::withHeaders($this->httpHeaders)
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'stok', $request->all());

        $stoks = $response['data'];


        $i = 0;
        foreach ($stoks as $index => $params) {

            $statusaktif = $params['statusaktif'];

            $result = json_decode($statusaktif, true);

            $statusaktif = $result['MEMO'];

            $stoks[$i]['statusaktif'] = $statusaktif;

        
            $i++;


        }

        return view('reports.stok', compact('stoks'));
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;


class PengembalianKasGantungDetailController extends MyController
{
    public $title = 'Pengembalian Kas Gantung Detail';

    public function index(Request $request)
    {
        
        $params = [
            'pengembaliankasgantung_id' => $request->pengembaliankasgantung_id,
            'whereIn' => $request->whereIn
        ];

        $response = Http::withHeaders($request->header())
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') .'pengembaliankasgantungdetail', $params);
            
        $data = [
            'rows' => $response['data'] ?? []
        ];

        return response($data);
    }
    
    public function jurnalGrid()
    {
        return view('jurnalumum._jurnal');
    }
    public function penerimaanGrid()
    {
        return view('penerimaan._penerimaan');
    }
    public function detailGrid()
    {
        return view('pengembaliankasgantung._detail');
    }
}



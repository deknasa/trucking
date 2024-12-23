<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;


class PelunasanPiutangDetailController extends MyController
{
    public $title = 'Pelunasan Piutang Detail';

    public function index(Request $request)
    {
        
        $params = [
            'pelunasanpiutang_id' => $request->pelunasanpiutang_id,
            'whereIn' => $request->whereIn
        ];

        $response = Http::withHeaders($request->header())
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') .'pelunasanpiutangdetail', $params);
            
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
        return view('pelunasanpiutangheader._detail');
    }
}



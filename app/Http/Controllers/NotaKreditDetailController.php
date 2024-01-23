<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;


class NotaKreditDetailController extends MyController
{
    public $title = 'Nota Kredit Detail';

    public function index(Request $request)
    {
        
        $params = [
            'notakredit_id' => $request->notakredit_id,
            'whereIn' => $request->whereIn
        ];

        $response = Http::withHeaders($request->header())
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') .'notakreditdetail', $params);
            
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
    public function pelunasanGrid()
    {
        return view('pelunasanpiutangheader._pelunasan');
    }
    public function detailGrid()
    {
        return view('notakreditheader._detail');
    }
}



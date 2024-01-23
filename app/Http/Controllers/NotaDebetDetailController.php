<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;


class NotaDebetDetailController extends MyController
{
    public $title = 'Nota Debet Detail';

    public function index(Request $request)
    {
        
        $params = [
            'notadebet_id' => $request->notadebet_id,
            'whereIn' => $request->whereIn
        ];

        $response = Http::withHeaders($request->header())
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') .'notadebetdetail', $params);
            
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
        return view('notadebetheader._detail');
    }
}



<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;


class PiutangDetailController extends MyController
{
    public $title = 'Piutang Detail';

    public function index(Request $request)
    {
        $params = [
            'piutang_id' => $request->piutang_id,
            'whereIn' => $request->whereIn
        ];

        $response = Http::withHeaders($request->header())
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') .'piutangdetail', $params);
            
        $data = [
            'rows' => $response['data'] ?? []
        ];

        return response($data);
    }
    public function jurnalGrid()
    {
        return view('jurnalumum._jurnal');
    }
    public function historyGrid()
    {
        return view('piutang._history');
    }
    public function detailGrid()
    {
        return view('piutang._details');
    }


}



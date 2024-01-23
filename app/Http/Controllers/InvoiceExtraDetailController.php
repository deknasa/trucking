<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;


class InvoiceExtraDetailController extends MyController
{
    public $title = 'Invoice Extra Detail';

    public function index(Request $request)
    {
        
        $params = [
            'invoiceextra_id' => $request->invoiceextra_id,
            'whereIn' => $request->whereIn
        ];

        $response = Http::withHeaders($request->header())
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') .'invoiceextradetail', $params);
            
        $data = [
            'rows' => $response['data'] ?? []
        ];

        return response($data);
    }
    
    public function jurnalGrid()
    {
        return view('jurnalumum._jurnal');
    }
    public function piutangGrid()
    {
        return view('invoiceextraheader._piutang');
    }
    public function detailGrid()
    {
        return view('invoiceextraheader._detail');
    }
}



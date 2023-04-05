<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;


class InvoiceDetailController extends Controller
{
    public $title = 'Invoice Detail';

    public function index(Request $request)
    {
        
        $params = [
            'invoice_id' => $request->invoice_id,
            'whereIn' => $request->whereIn
        ];

        $response = Http::withHeaders($request->header())
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') .'invoicedetail', $params);
            
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
        return view('invoiceheader._piutang');
    }
    public function detailGrid()
    {
        return view('invoiceheader._detail');
    }
}



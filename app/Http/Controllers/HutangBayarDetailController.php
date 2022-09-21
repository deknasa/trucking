<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class HutangBayarDetailController extends Controller
{
    public $title = 'Pembayaran Hutang Detail';

    public function index(Request $request)
    {
        $params = [
            'hutangbayar_id' => $request->hutangbayar_id,
            'whereIn' => $request->whereIn
        ];

        $response = Http::withHeaders($request->header())
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') .'hutangbayardetail', $params);
            
        $data = [
            'rows' => $response['data'] ?? []
        ];

        return response($data);
    }
}

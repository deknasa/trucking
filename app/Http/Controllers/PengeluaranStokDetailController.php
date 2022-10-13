<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class PengeluaranStokDetailController extends Controller
{
    public function index(Request $request)
    {
        $params = [
            'pengeluaranstokheader_id' => $request->pengeluaranstokheader_id,
            'whereIn' => $request->whereIn
        ];

        $response = Http::withHeaders($request->header())
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') .'pengeluaranstokdetail', $params);
            
        $data = [
            'rows' => $response['data'] ?? []
        ];
        return response($data);
    }
}

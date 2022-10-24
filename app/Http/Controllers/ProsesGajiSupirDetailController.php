<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;


class ProsesGajiSupirDetailController extends Controller
{
    public $title = 'Proses Gaji Supir Detail';

    public function index(Request $request)
    {
        
        $params = [
            'prosesgajisupir_id' => $request->prosesgajisupir_id,
            'whereIn' => $request->whereIn
        ];

        $response = Http::withHeaders($request->header())
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') .'prosesgajisupirdetail', $params);
            
        $data = [
            'rows' => $response['data'] ?? []
        ];

        return response($data);
    }
}



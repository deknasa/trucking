<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;


class GajiSupirDetailController extends Controller
{
    public $title = 'Gaji Supir Detail';

    public function index(Request $request)
    {
        
        $params = [
            'gajisupir_id' => $request->gajisupir_id,
            'whereIn' => $request->whereIn
        ];

        $response = Http::withHeaders($request->header())
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') .'gajisupirdetail', $params);
            
        $data = [
            'rows' => $response['data'] ?? []
        ];

        return response($data);
    }
}



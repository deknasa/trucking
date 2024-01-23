<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;


class PemutihanSupirDetailController extends MyController
{
    public $title = 'Pemutihan Supir Detail';

    public function index(Request $request)
    {
        
        $params = [
            'pemutihansupir_id' => $request->pemutihansupir_id,
            'whereIn' => $request->whereIn
        ];

        $response = Http::withHeaders($request->header())
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') .'pemutihansupirdetail', $params);
            
        $data = [
            'rows' => $response['data'] ?? []
        ];

        return response($data);
    }
}



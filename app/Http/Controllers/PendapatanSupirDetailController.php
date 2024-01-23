<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;


class PendapatanSupirDetailController extends MyController
{
    public $title = 'Pendapatan Supir Detail';

    public function index(Request $request)
    {
        $params = [
            'pendapatansupir_id' => $request->pendapatansupir_id,
            'whereIn' => $request->whereIn
        ];

        $response = Http::withHeaders($request->header())
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') .'pendapatansupirdetail', $params);
            
        $data = [
            'rows' => $response['data'] ?? []
        ];

        return response($data);
    }
}



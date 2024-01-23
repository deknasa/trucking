<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;


class JurnalUmumDetailController extends MyController
{
    public $title = 'Jurnal Umum Detail';

    public function index(Request $request)
    {
        $params = [
            'jurnalumum_id' => $request->jurnalumum_id,
            'whereIn' => $request->whereIn
        ];

        $response = Http::withHeaders($request->header())
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') .'jurnalumumdetail', $params);
            
        $data = [
            'rows' => $response['data'] ?? []
        ];

        return response($data);
    }
}



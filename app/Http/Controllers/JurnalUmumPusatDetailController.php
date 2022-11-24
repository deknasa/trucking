<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;


class JurnalUmumPusatDetailController extends Controller
{
    public $title = 'Jurnal Umum Pusat Detail';

    public function index(Request $request)
    {
        $params = [
            'jurnalumumpusat_id' => $request->jurnalumumpusat_id,
            'whereIn' => $request->whereIn
        ];

        $response = Http::withHeaders($request->header())
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') .'jurnalumumpusatdetail', $params);
            
        $data = [
            'rows' => $response['data'] ?? []
        ];

        return response($data);
    }
}


